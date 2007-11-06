<?php
/*---------------------------------------------------+
| ExiteCMS Content Management System                 |
+----------------------------------------------------+
| Copyright 2007 Harro "WanWizard" Verton, Exite BV  |
| for support, please visit http://exitecms.exite.eu |
+----------------------------------------------------+
| Released under the terms & conditions of v2 of the |
| GNU General Public License. For details refer to   |
| the included gpl.txt file or visit http://gnu.org  |
+----------------------------------------------------*/
if (isset($_SERVER['SERVER_SOFTWARE'])) {
	die("This is a batch program that needs to run from cron!");
}

/*---------------------------------------------------+
| Read the user configuration
+----------------------------------------------------*/

require "m2f_config.php";

// find the webroot, so we can load the core functions
$webroot = "";
while(!file_exists($webroot."includes/core_functions.php")) { 
	$webroot .= '../'; 
	if (strlen($webroot)>100) die('Unable to find the ExiteCMS document root!'); 
}

// make sure the host is known
$_SERVER['HTTP_HOST'] = M2F_HOST;

require_once $webroot."includes/core_functions.php";

locale_load("modules.mail2forum");

/*---------------------------------------------------+
| local variables
+----------------------------------------------------*/

$imagetypes = array(".bmp",".gif",".jpg",".jpeg",".png",".psd",".tiff",".wbmp");
$contenttypes = array("image/bmp", "image/gif", "image/jpeg", "image/jpeg", "image/png", "image/x-photoshop", "image/tiff", "image/vnd.wap.wbmp");
$processor = strtoupper(basename($argv[0],'.php'));

/*---------------------------------------------------+
| local functions
+----------------------------------------------------*/

// write an entry to the process log, and optionally abort the program
function logentry($task="", $message="", $abort=false, $exitcode=0) {

	global $processor;
	
	$handle = fopen(M2F_LOGFILE.'/M2F_process.log', 'a');
	fwrite($handle, date("Ymd").";".date("His").";".$processor.";".$task.";".$message.chr(10));
	fclose($handle);
	
	if ($abort) die($exitcode);
}

// debug function - write an entry to the debug log
function logdebug($task="", $message="") {

	global $processor;
	
	$handle = fopen(M2F_LOGFILE.'/'.$processor.'.debug.log', 'a');
	fwrite($handle, date("Ymd").";".date("His").";".$task.";".$message.chr(10));
	fclose($handle);
}

// phpmailer init functions
function mailer_init() {
	global $mail, $locale, $settings;

	if (M2F_SMTP_DEBUG) $mail->SMTPDebug = 2;

	if (file_exists(PATH_INCLUDES."languages/phpmailer.lang-".$locale['phpmailer'].".php")) {
		$mail->SetLanguage($locale['phpmailer'], PATH_INCLUDES."language/");
	} else {
		$mail->SetLanguage("en", PATH_INCLUDES."language/");
	}

	if ($settings['smtp_host']=="") {
		$mail->IsMAIL();
	} else {
		$mail->IsSMTP();
		$mail->Host = $settings['smtp_host'];
		if ($settings['smtp_username'] != "") {
			$mail->SMTPAuth = true;
			$mail->Username = $settings['smtp_username'];
			$mail->Password = $settings['smtp_password'];
		} else {
			$mail->SMTPAuth = false;
		}
	}
	$mail->Timeout = 30;
	$mail->CharSet = $locale['charset'];
}

/*---------------------------------------------------+
| initialisation code
+----------------------------------------------------*/

ini_set('memory_limit', '32M');
ini_set('max_execution_time', '0');

// log the start
if (M2F_PROCESS_LOG) logentry('INIT', 'Program start');

// get the last modified timestamp of this module
$module_lastmod = filemtime('m2f_smtp.php');

// get the last modified timestamp of the config file
$config_lastmod = filemtime('m2f_config.php');

// check if the Mail2Forum module is installed
$result = dbquery("SELECT * FROM ".$db_prefix."modules WHERE mod_title = '".$locale['m2f100']."'");
if (dbrows($result) == 0) {
	if (M2F_PROCESS_LOG) logentry('INIT', $locale['m2f999'].' '.$locale['m2f110'], true, 1);
	die('Mail2Forum is not infused');
}

// initialize PHP-Mailer
require_once PATH_INCLUDES."phpmailer_include.php";
$mail = new PHPMailer();
mailer_init();

// get the last polled time from the database
$result = dbquery("SELECT * FROM ".$db_prefix."M2F_status");
if (dbrows($result) == 0) {
	// the first time we start. Forget all old posts for now
	$lastpoll = time();
	$result = dbquery("INSERT INTO ".$db_prefix."M2F_status (m2f_lastpoll) VALUES ('".$lastpoll."')");
	if (M2F_PROCESS_LOG) logentry("INIT", sprintf($locale['m2f800'], $processor));
} else {
	if ($data = dbarray($result)) {
		if ($data['m2f_lastpoll'] == 0) {
			// 0 is used as an invalid polltime. This can be reset via the admin module
			die($processor.': LastPoll time is invalid. Use the admin module to correct this');
		}
		if ((time() - $data['m2f_lastpoll']) > M2F_POLL_THRESHOLD) {
			$result = dbquery("UPDATE ".$db_prefix."M2F_status SET m2f_lastpoll = 0");
			if (M2F_PROCESS_LOG) logentry('INIT', $locale['m2f999'].' '.$locale['m2f801'], true, 1);
			die($processor.': More than a week has passed since the last run! Use the admin module to correct this');
		}
		$lastpoll = $data['m2f_lastpoll']+1;
	} else {
		if (M2F_PROCESS_LOG) logentry('INIT', $locale['m2f999'].' '.$locale['m2f802'], true, 1);
		die('This should never happen');
	}
}

// strip bbcode so a message stays readable in plain text
function stripubb($text) {
	global $locale;
	
	$text = preg_replace('#\[li\](.*?)\[/li\]#si', '* \1', $text);
	$text = preg_replace('#\[ul\](.*?)\[/ul\]#si', '\1', $text);

	$text = preg_replace('#\[b\](.*?)\[/b\]#si', '\1', $text);
	$text = preg_replace('#\[i\](.*?)\[/i\]#si', '\1', $text);
	$text = preg_replace('#\[u\](.*?)\[/u\]#si', '\1', $text);
	$text = preg_replace('#\[center\](.*?)\[/center\]#si', '\1', $text);
	
	$text = preg_replace('#\[url\]([\r\n]*)(http://|ftp://|https://|ftps://)([^\s\'\";\+]*?)([\r\n]*)\[/url\]#si', '\2\3', $text);
	$text = preg_replace('#\[url\]([\r\n]*)([^\s\'\";\+]*?)([\r\n]*)\[/url\]#si', 'http://\2', $text);
	$text = preg_replace('#\[url=([\r\n]*)(http://|ftp://|https://|ftps://)([^\s\'\";\+]*?)\](.*?)([\r\n]*)\[/url\]#si', '\2\3', $text);
	$text = preg_replace('#\[url=([\r\n]*)([^\s\'\";\+]*?)\](.*?)([\r\n]*)\[/url\]#si', 'http://\2', $text);
	
	$text = preg_replace('#\[mail\]([\r\n]*)([^\s\'\";:\+]*?)([\r\n]*)\[/mail\]#si', 'mailto:\2', $text);
	$text = preg_replace('#\[mail=([\r\n]*)([^\s\'\";:\+]*?)\](.*?)([\r\n]*)\[/mail\]#si', 'mailto:\2', $text);
	
	$text = preg_replace('#\[small\](.*?)\[/small\]#si', '\1', $text);
	$text = preg_replace('#\[color=(black|blue|brown|cyan|gray|green|lime|maroon|navy|olive|orange|purple|red|silver|violet|white|yellow)\](.*?)\[/color\]#si', '\2', $text);
	
	$text = preg_replace('#\[flash width=([0-9]*?) height=([0-9]*?)\]([^\s\'\";:\+]*?)(\.swf)\[/flash\]#si', '\3\4', $text);
	$text = preg_replace("#\[img\]((http|ftp|https|ftps)://)(.*?)(\.(jpg|jpeg|gif|png|JPG|JPEG|GIF|PNG))\[/img\]#sie","'\\1'.str_replace(array('.php','?','&','='),'','\\3').'\\4'",$text);

	$text = descript($text,false);

	return $text;
}

// preserve the exact content of [code] blocks
function quotecode($text) {
	global $locale;
	
	$text = preg_replace(':&#([0-9]*);:sie', 'chr(\1)', $text);
        $replace = array("\"", "<", ">", " ", "&");
        $search = array("&quot;", "&lt;", "&gt;", "&nbsp;", "&amp;");
        $text = str_replace($search, $replace, $text);

	$lines = preg_split("#\n|(\[quote[^\]]*\]|\[/quote\]|\[code\]|\[/code\])#si", $text, -1, PREG_SPLIT_DELIM_CAPTURE);
	$quotelevel = 0;
	$literal = 0;
	$boundary = 0;
	$new = "";
	$indent = "";
	$emptylines = "";
	foreach ($lines as $line) {
		if ($boundary == 1) { // skip empty lines at the start of a quote or code block
			if (strlen(trim($line)) == 0)
				continue;
			$boundary = 0;
		}

		if (strlen(trim($line)) == 0) { // collect empty lines so we can skip them if we hit 
						// a new block before a non-empty line
			$emptylines .= "$indent\n";
	 	}
		elseif ($line == "[/code]")
		{
			$emptylines = "";
			$boundary = 1;
			$literal = 0;
			$new .= "$indent" . "[/code]\n$indent\n"; // one 'empty' line after code block
		}
		elseif ($literal == 1) {
			$new .= "$emptylines$indent    $line\n";
			$emptylines = "";
		}
		elseif ($line == "[code]") {
			$emptylines = "";
			$boundary = 1;
			$literal = 1;
			$new .= "$indent\n$indent" . "[code]\n"; // one 'empty' line before a code block
		}
		elseif ($line == "[quote]") {
			$emptylines = "";
			$new .= "$indent\n"; // one 'empty' line before a new quote
			$boundary = 1;
			$quotelevel++;
			$indent .= "> ";
		}
		elseif (preg_match("#\[quote=([^\]]*)\]#i", $line, $matches)) {
			$emptylines = "";
			$boundary = 1;
			$quotelevel++;
			$poster = $matches[1];
			$poster = trim($poster, '"');
			$new .= "$indent\n$indent" . $poster . " ".$locale['m2f815'].":\n"; // one 'empty' line before a new quote
			$indent .= "> ";
		}
		elseif ($line == "[/quote]") {
			$emptylines = "";
			$boundary = 1;
			if ($quotelevel > 0) {
				$quotelevel--;
				$indent = substr($indent, 0, $quotelevel*2);
			}
			$new .= "$indent\n"; // one 'empty' line after a quote
		}
		else {
			$new .= "$emptylines$indent" . stripubb($line) . "\n";
			$emptylines = "";
		}
	}
	//$text = descript($text,false);

	return $new;
}

/*---------------------------------------------------+
| main loop
+----------------------------------------------------*/

while (true) {

	// time of this poll.
	$polltime = time();
	
	// Insert a marker in the log every hour to show we're still alive
	if (isset($marker) && $marker <> date("H"))
		if (M2F_PROCESS_LOG) logentry("MARKER", "---");
	$marker = date("H");

	// check for messages posted since the last poll
	$result = dbquery("SELECT * FROM ".$db_prefix."posts WHERE (post_datestamp BETWEEN '".$lastpoll."' AND '".$polltime."') OR (post_edittime BETWEEN '".$lastpoll."' AND '".$polltime."')");
	if (dbrows($result) != 0) {

		// get all posts in the selected interval
		while($postrecord = dbarray($result)) {
			if (M2F_SMTP_DEBUG) logdebug('POSTRECORD', print_r($postrecord, true));

			$new_post = ($postrecord['post_datestamp'] >= $lastpoll && $postrecord['post_datestamp'] <= $polltime);
			$edit_post = ($postrecord['post_edittime'] >= $lastpoll && $postrecord['post_edittime'] <= $polltime);

			if (M2F_SMTP_DEBUG) logdebug('POST_STATE', ($new_post?"ADD":"").($new_post&&$edit_post?"-":"").($edit_post?"EDIT":""));

			// if a new post was edited within one poll cycle, don't mark it as edited
			if ($new_post) $edit_post = false;
			
			// get the forum mailing list info
			$result2 = dbquery("SELECT m.m2f_email, f.forum_name FROM ".$db_prefix."M2F_forums m, ".$db_prefix."forums f WHERE m.m2f_active = '1' AND m.m2f_forumid = '".$postrecord['forum_id']."' AND m.m2f_forumid = f.forum_id");
			if (!$result2) {
				if (M2F_PROCESS_LOG) logentry('ERROR', $locale['m2f999'].' '.$locale['m2f803'].$postrecord['forum_id'], true, 1);
				die($locale['m2f803']);
			} else {
				// get sender information			
				$sender = dbarray($result2);
				if (M2F_SMTP_DEBUG) logdebug('SENDER', print_r($sender, true));
				
				// get all subscribed users for this forum
				$result2 = dbquery("SELECT u.*, c.* FROM ".$db_prefix."users u, ".$db_prefix."M2F_subscriptions s, ".$db_prefix."M2F_config c 
					WHERE s.m2f_forumid = '".$postrecord['forum_id']."' AND s.m2f_subscribed = '1' AND u.user_status = 0 AND u.user_bad_email = 0 AND u.user_id = s.m2f_userid AND u.user_id = c.m2f_userid");
				while ($recipient = dbarray($result2)) {
					if (M2F_SMTP_DEBUG) logdebug('RECIPIENT', print_r($recipient, true));
					
					// get the senders profile (need the email address and the email-hidden flag)
					if ($edit_post) {
						// check for automatic or system posts
						if ($postrecord['post_edituser'] != 0) {
							$poster = dbarray(dbquery("SELECT user_name, user_fullname, user_email, user_hide_email FROM ".$db_prefix."users WHERE user_id = '".$postrecord['post_edituser']."'"));
						} else {
							$poster = array('user_name' => $locale['sysusr'], 'user_fullname'  => $locale['sysusr'], 'user_email' => "", 'user_hide_email' => true);
						}
					} else {
						// check of automatic or system posts
						if ($postrecord['post_author'] != 0) {
							$poster = dbarray(dbquery("SELECT user_name, user_fullname, user_email, user_hide_email FROM ".$db_prefix."users WHERE user_id = '".$postrecord['post_author']."'"));
						} else {
							$poster = array('user_name' => $locale['sysusr'], 'user_fullname'  => $locale['sysusr'], 'user_email' => "", 'user_hide_email' => true);
						}
					}
					if (M2F_SMTP_DEBUG) logdebug('POSTER', print_r($poster, true));
					
					// check if the poster wants his email address hidden. If so, use the forum address as sender
					if (M2F_USE_FORUM_EMAIL || $poster['user_hide_email'])
						$poster['user_email'] = $sender['m2f_email'];

					// basics, as from who, to whom, and use the site email as sender					
					$mail->Sender = $settings['siteemail'];
					$mail->From = $poster['user_email'];
					$mail->FromName = $poster['user_name'];
					$mail->AddAddress($recipient['user_email'], $recipient['user_fullname']);
					$mail->AddReplyTo($sender['m2f_email'], $sender['forum_name']);

					// identify this email as one from us
					$mail->AddCustomHeader("X-M2F-version: PHP-Fusion Mail2Forum v".$locale['m2fver']);
					$mail->AddCustomHeader("X-M2F-host: ".utf8_decode($settings['sitename']));
					$mail->AddCustomHeader("X-M2F-forum: ".$sender['forum_name']);

					// set the message format, and convert the message text if needed
					$HTMLbody = $edit_post?("<b>".$locale['m2f814']."</b><br /><br />"):"";
					$HTMLbody = $postrecord['post_message'];
//					if ($postrecord['post_showsig']) { $HTMLbody = $HTMLbody."\n\n<hr>".$postrecord['user_sig']; }
					if ($postrecord['post_smileys']) { $HTMLbody = parsesmileys($HTMLbody); }
					$HTMLbody = parseubb($HTMLbody);
					$HTMLbody = nl2br($HTMLbody);

					$TEXTbody = $edit_post?($locale['m2f814']."\r\n\r\n"):"";
					$TEXTbody .= html_entity_decode($postrecord['post_message'], ENT_QUOTES);
					//$TEXTbody = stripubb($TEXTbody);
					$TEXTbody = quotecode($TEXTbody);

					// check for attachments. If found, process them according to the users config
					if ($recipient['m2f_attach'] > 0) {
						$res_att = dbquery("SELECT * FROM ".$db_prefix."forum_attachments WHERE post_id = '".$postrecord['post_id']."'");
						if (dbrows($res_att) != 0) {
							// although PHP-Fusion does not support multiple attachments, we do... ;-)
							while ($attachment = dbarray($res_att)) {
								if (M2F_SMTP_DEBUG) logdebug('ATTACHMENT', print_r($attachment, true));
								$attachURL = $settings['siteurl']."getfile.php?type=a&file_id=".$attachment['attach_id'];
								if ($recipient['m2f_html'] == 1) {
									// If the attachment is an image and the config is 'show inline'
									$isimage = array_search($attachment['attach_ext'], $imagetypes);
									if ($isimage != false and $recipient['m2f_inline'] == 0) {
										// include original image or only the attachment?
										if ($recipient['m2f_thumbnail'] == 0 and file_exists(PATH_ATTACHMENTS.$attachment['attach_name'].".thumb")) {
											$cid = uniqid("", true);
											$mail->AddEmbeddedImage(PATH_ATTACHMENTS.$attachment['attach_name'].".thumb", $cid, ($attachment['attach_realname']==""?$attachment['attach_name']:$attachment['attach_realname']), "base64", $contenttypes[$isimage]);
											$HTMLbody .= "<br><hr<br><a href=\"".$attachURL."\"><img src='cid:".$cid."' /></a>";
											$TEXTbody .= "\r\n\r\n".($attachment['attach_realname']==""?$attachment['attach_name']:$attachment['attach_realname']).": ".$attachURL;
										} else {
											$cid = uniqid("", true);
											$mail->AddEmbeddedImage(PATH_ATTACHMENTS.$attachment['attach_name'], $cid, ($attachment['attach_realname']==""?$attachment['attach_name']:$attachment['attach_realname']), "base64", $contenttypes[$isimage]);
											$HTMLbody .= "<br><hr><br><img src='cid:".$cid."' />";
											$TEXTbody .= "\r\n\r\n".($attachment['attach_realname']==""?$attachment['attach_name']:$attachment['attach_realname']).": ".$attachURL;
										}
									} else {
										// process the attachments
										switch ($recipient['m2f_attach']) {
											case 0:
												// ignore the attachments
												break;
											case 1:
												// check the size of the attachments, don't send it out if it's to big
												if (filesize(PATH_ATTACHMENTS.$attachment['attach_name']) < M2F_MAX_ATTACH_SIZE) {
													// attach the attachments to the email
													$mail->AddAttachment(PATH_ATTACHMENTS.$attachment['attach_name']);
													break;
												}
											case 2:
												// add a link pointing to the attachment
												$HTMLbody .= "<br><br>Attachment: <a href=\"".$attachURL."\">".($attachment['attach_realname']==""?$attachment['attach_name']:$attachment['attach_realname'])."</a>";
												$TEXTbody .= "\r\n\r\n".($attachment['attach_realname']==""?$attachment['attach_name']:$attachment['attach_realname']).": ".$attachURL;
												break;
										}
									}
								} else {
									// process the attachments
									switch ($recipient['m2f_attach']) {
										case 0:
											// ignore the attachments
											break;
										case 1:
											// check the size of the attachments, don't send it out if it's to big
											if (filesize(PATH_ATTACHMENTS.$attachment['attach_name']) < M2F_MAX_ATTACH_SIZE) {
												// attach the attachments to the email
												$mail->AddAttachment(PATH_ATTACHMENTS.$attachment['attach_name']);
												break;
											}
										case 2:
											// add a link pointing to the attachment
											$TEXTbody .= "\r\n\r\nAttachment: ".$attachURL;
											break;
									}
								}
							}
						}	
					}

					// add a direct link to the forum message at the bottom of the email
					$HTMLbody .= "<br><br><hr>".$locale['m2f812']." - <a href='".$settings['siteurl']."forum/viewthread.php?forum_id=".$postrecord['forum_id']."&thread_id="
						.$postrecord['thread_id']."&pid=".$postrecord['post_id']."#post_".$postrecord['post_id']."'>".$locale['m2f813']."</a>";
					$footer = $settings['siteurl']."forum/viewthread.php?forum_id=".$postrecord['forum_id']."&thread_id=".$postrecord['thread_id']."&pid=".$postrecord['post_id']."#post_".$postrecord['post_id'];
					$TEXTbody .= "\r\n".str_repeat('_', strlen($footer))."\r\n".$footer."\r\n".$locale['m2f811'];

					// the message body (both HTML and plain-text if need be) and set the body type
					if ($recipient['m2f_html'] == 1) {
						$mail->IsHTML(true);
						$mail->Body = $HTMLbody;
						$mail->AltBody = $TEXTbody;
					} else {
						$mail->IsHTML(false);
						$mail->Body = $TEXTbody;
						$mail->AltBody = "";
					}
										
					// add the thread ID to the subject of this post in the correct format
					$subject = html_entity_decode($postrecord['post_subject'], ENT_QUOTES)." [-".$postrecord['thread_id']."-]";
					$mail->Subject = $subject;
					
					// send the post to the user
					if(!$mail->Send()) {
						if (M2F_PROCESS_LOG) logentry('SEND', 'ERROR! From:'.$poster['user_email'].' To:'.$recipient['user_email'].' -> '.$mail->ErrorInfo);
						unset($mail);
						$mail = new PHPMailer();
						mailer_init();
					} else {
						$result4 = dbquery("UPDATE ".$db_prefix."M2F_forums SET m2f_sent = m2f_sent + 1 WHERE m2f_forumid = '".$postrecord['forum_id']."' ");
						if (M2F_PROCESS_LOG) logentry('SEND', 'From:'.$poster['user_email'].' To:'.$recipient['user_email'].' -> '.$subject);
					}

					// make sure all traces of the mail are wiped out
					$mail->ClearAddresses();
					$mail->ClearAllRecipients();
					$mail->ClearAttachments();
					$mail->ClearBCCs();
					$mail->ClearCCs();
					$mail->ClearCustomHeaders();
					$mail->ClearReplyTos();
					$mail->Body = "";
					$mail->AltBody = "";
 				}
			}
		}
	} else {
		if (M2F_PROCESS_LOG) logentry('POLL', 'no new posts');
	}

	// update the status table
	$result = dbquery("UPDATE ".$db_prefix."M2F_status SET m2f_lastpoll = '".$polltime."'");
	
	// if the module has been modified, exit so it can be restarted
	clearstatcache();
	if (filemtime('m2f_smtp.php') != $module_lastmod) {
		if (M2F_PROCESS_LOG) logentry('EXIT', 'Restart due to module code update');
		exit(99);
	}
	// if the config has been modified, exit so it can be reloaded
	if (filemtime('m2f_config.php') != $config_lastmod) {
		if (M2F_PROCESS_LOG) logentry('EXIT', 'Restart due to configuration change');
		exit(99);
	}

	// calculate the next interval. Log a warning if we can't process quick enough
	$interval = $polltime + M2F_INTERVAL - time();
	if ($interval < 0) {
		if (M2F_PROCESS_LOG) logentry('SLEEP', $locale['m2f999'].' '.$locale['m2f804']);
	} else {
		sleep($interval);
	}

	// get the last polled time from the database
	$result = dbquery("SELECT * FROM ".$db_prefix."M2F_status");
	if ($data = dbarray($result)) {
		if ($data['m2f_abort'] == 1) {
			if (M2F_PROCESS_LOG) logentry('WAKE-UP', $locale['m2f999'].' '.$locale['m2f805'], true, 1);
			die($locale['m2f805']);
		}
		$lastpoll = $data['m2f_lastpoll']+1;
	} else {
		if (M2F_PROCESS_LOG) logentry('WAKE-UP', $locale['m2f999'].' '.$locale['m2f802'], true, 1);
		die($locale['m2f802']);
	}
}
?>