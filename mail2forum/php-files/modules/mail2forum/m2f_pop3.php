<?php
/*---------------------------------------------------------------------+
| ExiteCMS Content Management System                                   |
+----------------------------------------------------------------------+
| Copyright 2006-2008 Exite BV, The Netherlands                        |
| for support, please visit http://www.exitecms.org                    |
+----------------------------------------------------------------------+
| Mail2Forum - CLI POP3 processor                                      |
| uses the POP3 and MIME classes from the PEAR library                 |
+----------------------------------------------------------------------+
| Released under the terms & conditions of v2 of the GNU General Public|
| License. For details refer to the included gpl.txt file or visit     |
| http://gnu.org                                                       |
+----------------------------------------------------------------------+
| $Id::                                                               $|
+----------------------------------------------------------------------+
| Last modified by $Author::                                          $|
| Revision number $Rev::                                              $|
+---------------------------------------------------------------------*/
if (isset($_SERVER['SERVER_SOFTWARE'])) {
	die("This is a batch program that needs to run from cron!");
}

// make sure there is no interference from already installed PEAR modules
ini_set('include_path', '.');
// give this module some memory and execution time
ini_set('memory_limit', '32M');
ini_set('max_execution_time', '0');

// find the webroot, so we can load the core functions
$webroot = "";
while(!file_exists($webroot."includes/core_functions.php")) {
	$webroot .= '../';
	if (strlen($webroot)>100) die('Unable to find the ExiteCMS document root!');
}
require_once $webroot."includes/core_functions.php";

// make sure the host is known
$_SERVER['HTTP_HOST'] = $settings['m2f_host'];

// include for attachment manipulation functions
require_once PATH_INCLUDES."forum_functions_include.php";

// include for image manipulation functions
require_once PATH_INCLUDES."photo_functions_include.php";

// need the GeoIP functions to determine the mailers country of origin
require_once PATH_INCLUDES."geoip_include.php";

// include the PEAR POP3 and MIME decode class
require_once "includes/POP3.php";
require_once "includes/mimeDecode.php";

// include the proper language file
locale_load("modules.mail2forum");

/*---------------------------------------------------+
| local variables
+----------------------------------------------------*/

$contenttypes = array("image/bmp", "image/gif", "image/jpeg", "image/jpeg", "image/png", "image/x-photoshop", "image/tiff", "image/vnd.wap.wbmp");
$processor = strtoupper(basename($argv[0],'.php'));
$striphtml = array('head', 'script');
$stripsubject = array('re:', 'fw:', 'betr:');

define('NET_POP3_DEBUG_LOGFILE', $settings['m2f_logfile'].'/'.$processor.'.debug.log');

/*---------------------------------------------------+
| local functions
+----------------------------------------------------*/

// debug function - write an entry to the process log, and optionally abort the program
function logentry($task="", $message="", $abort=false, $exitcode=0) {

	global $processor, $settings;

	$handle = fopen($settings['m2f_logfile'].'/M2F_process.log', 'a');
	fwrite($handle, date("Ymd").";".date("His").";".$processor.";".$task.";".$message.chr(10));
	fclose($handle);

	if ($abort) die($exitcode);
}

// debug function - write an entry to the debug log
function logdebug($task="", $message="") {

	global $processor;

	$handle = fopen(NET_POP3_DEBUG_LOGFILE, 'a');
	fwrite($handle, date("Ymd").";".date("His").";".$task.";".$message.chr(10));
	fclose($handle);
}

// debug function - dump the received message and the extracted parameters
function dumpmessage($message, $post) {

	global $processor, $settings;

	$i=1;
	$log = $settings['m2f_logfile'].'/'.$processor.'.message.';
	while(file_exists($log.sprintf('%06u', $i))) {
		$i++;
		if ($i>1000000) return false;
	}
	$handle = fopen($log.sprintf('%06u', $i), 'a');
	$logmsg = "/------------------------------------------------------------------- \n";
	$logmsg .= "/--- Message logged: ".date('l, d M Y @ H:i:s')." \n";
	$logmsg .= "/------------------------------------------------------------------- \n";
	fwrite($handle, $logmsg);
	$logmsg = "/------------------------------------------------------------------- \n";
	$logmsg .= "/ --- RAW MESSAGE DECODE:\n";
	$logmsg .= "/------------------------------------------------------------------- \n";
	$logmsg .= print_r($message, true);
	fwrite($handle, $logmsg);
	$logmsg = "/------------------------------------------------------------------- \n";
	$logmsg .= "/--- MESSAGE INFORMATION EXTRACTED:\n";
	$logmsg .= "/------------------------------------------------------------------- \n";
	$logmsg .= print_r($post, true);
	$logmsg .= "/------------------------------------------------------------------- \n";
	fwrite($handle, $logmsg);
	fclose($handle);
}

// send a NDR reply to the poster
function send_reply($forum, $poster, $message) {

	global $mail, $settings, $locale;

	$mail->From = $forum['m2f_email'];
	$mail->FromName = $forum['forum_name'];
	$mail->AddAddress($poster['user_email'], $poster['user_fullname']);
	$mail->AddReplyTo($settings['siteemail'], $settings['sitename']);

	$mail->Body = $message;
	$mail->Subject = $locale['m2f991'];

	if(!$mail->Send()) {
		if ($settings['m2f_process_log']) logentry('SEND', sprintf($locale['m2f906'], $poster['user_email'], $forum['m2f_email'], $mail->ErrorInfo));
	}

	$mail->ClearAllRecipients();
	$mail->ClearReplyTos();
	$mail->ClearAttachments();
}

// convert Mail quote identifiers to bbcode quotes
function quoteit($text) {

	$lines = explode("\n", $text);
	$quotelevel = 0;
	$new = "";
	foreach ($lines as $line) {
		// Count the number of '> ' strings at the beginning of the line.
		$cql = 0;
		$slen = strlen($line);
		while ( ($slen >= ($cql+1)*2 && $line[$cql*2] == '>' && $line[$cql*2+1] == ' ') ||
			($slen == ($cql+1)*2 && $line[$cql*2] == '>' && $line[$cql*2+1] == "\r") ||
			($slen == $cql*2 + 1 && $line[$cql*2] == '>'))
			$cql++;
		// $cql = substr_count($line, "> ");
		if ($cql > $quotelevel) {  // new quote level
			$newlevels = $cql - $quotelevel;
			while ($newlevels) {
				$new .= "[quote]";
				$newlevels--;
			}
			$new .= substr($line, $cql*2) .  "\n";
			$quotelevel = $cql;
		}
		elseif ($cql < $quotelevel) {
			$newlevels = $quotelevel - $cql;
			while ($newlevels) {
				$new .= "[/quote]";
				$newlevels--;
			}
			$new .= "\n" . substr($line, $cql*2) . "\n";
			$quotelevel = $cql;
		}
		else
			$new .= substr($line, $cql*2) . "\n";
	}

	return $new;
}

// characterset conversion
function charsetconv($text, $fromcharset) {

	global $settings;

	// validate the input. if not a string, just return unaltered
	if (empty($text) || !is_string($text)) return $text;

	// validate the original charset. if not a string, just return unaltered
	if (empty($fromcharset) || !is_string($fromcharset)) return $text;

	// do we need to convert anything? If not, just return unaltered
	if ($fromcharset == $settings['charset']) return $text;

	// do we have mbstring?
	if (function_exists('mb_convert_encoding')) {
		if (strtoupper($fromcharset) != strtoupper($settings['charset'])) {
			if ($settings['m2f_pop3_debug']) logdebug("mb_convert_encoding", "converting string from ".strtoupper($fromcharset)." to ".strtoupper($settings['charset']));
			// attempt to convert
			$mbresult = mb_convert_encoding($text, strtoupper($settings['charset']), strtoupper($fromcharset));
			if ($mbresult) {
				return $mbresult;
			}
			if ($settings['m2f_pop3_debug']) logdebug("mb_convert_encoding", "conversion failed!");
		}
	}

	// next attempt, do we have iconv?
	if (function_exists('iconv')) {
		if (strtoupper($fromcharset) != strtoupper($settings['charset'])) {
			if ($settings['m2f_pop3_debug']) logdebug("iconv", "converting string from ".strtoupper($fromcharset)." to ".strtoupper($settings['charset']));
			// attempt to convert
			$iconvresult = iconv(strtoupper($fromcharset), strtoupper($settings['charset']), $text);
			if ($iconvresult) {
				return $iconvresult;
			}
			if ($settings['m2f_pop3_debug']) logdebug("iconv", "conversion failed!");
		}
	}

	// We couldn't convert, or there was no need to. Return unaltered
	return $text;
}

// add the new message as a post record to the forum
function addnewpost($forum_id, $thread_id, $sender, $recipient, $post) {

	global $imagetypes, $settings, $locale, $db_prefix;

	// get the post subject
	$subject = (is_array($post['subject'])?$post['subject']['subject']:$post['subject']);

	// sanitize the message
	$subject = trim(stripinput(censorwords($subject)));
	$post['body'] = quoteit($post['body']); // do this first or else the '> ' are replaced by '&gt;'
	$post['body'] = trim(stripinput(censorwords($post['body'])));

	// time of this post
	$posttime = time();

	// update the forum post status
	$sql = "UPDATE ".$db_prefix."forums SET forum_lastpost='$posttime', forum_lastuser='".$sender['user_id']."' WHERE forum_id='".$recipient['m2f_forumid']."'";
	$result = dbquery($sql);
	if (!$result) {
		if ($settings['m2f_process_log']) logentry('ADDPOST', sprintf($locale['m2f907'], 'UPDATE', $db_prefix.'forums'));
		if ($settings['m2f_process_log']) logentry('SQL: ',  $sql);
		return false;
	}
	// is this a new thread?
	if ($thread_id == -1) {
		$sql = "INSERT INTO ".$db_prefix."threads (forum_id, thread_subject, thread_author, thread_views, thread_lastpost, thread_lastuser, thread_sticky, thread_locked)
					VALUES('$forum_id', '".mysql_escape_string($subject)."', '".$sender['user_id']."', '0', '$posttime', '".$sender['user_id']."', '0', '0')";
		$result = dbquery($sql);
		if (!$result) {
			if ($settings['m2f_process_log']) logentry('ADDPOST', sprintf($locale['m2f907'], 'INSERT', $db_prefix.'threads'));
			if ($settings['m2f_process_log']) logentry('SQL: ',  $sql);
			return false;
		}
		$thread_id = mysql_insert_id();
	} else {
		// update the thread post status
		$sql = "UPDATE ".$db_prefix."threads SET thread_lastpost='$posttime', thread_lastuser='".$sender['user_id']."' WHERE thread_id='".$thread_id."'";
		$result = dbquery($sql);
		if (!$result) {
			if ($settings['m2f_process_log']) logentry('ADDPOST', sprintf($locale['m2f907'], 'UPDATE', $db_prefix.'threads'));
			if ($settings['m2f_process_log']) logentry('SQL: ',  $sql);
			return false;
		}
	}

	// determine the country code for the senders mail server
	$sender_cc = GeoIP_IP2Code($post['received']['ip']);
	if (!$sender_cc) $sender_cc = "";

	// insert the new message into the posts table
	$sql = "INSERT INTO ".$db_prefix."posts (forum_id, thread_id, post_subject, post_message, post_showsig, post_smileys, post_author, post_datestamp, post_ip, post_cc, post_edituser, post_edittime)
		VALUES ('$forum_id', '$thread_id', '".mysql_escape_string($subject)."', '".mysql_escape_string($post['body'])."', '1', '1', '".$sender['user_id']."', '$posttime', '".$post['received']['ip']."', '$sender_cc', '0', '0')";
	$result = dbquery($sql);
	if (!$result) {
		if ($settings['m2f_process_log']) logentry('ADDPOST', sprintf($locale['m2f907'], 'INSERT (new post)', $db_prefix.'posts'));
		if ($settings['m2f_process_log']) logentry('SQL: ',  $sql);
		return false;
	}
	$post_id = mysql_insert_id();

	// update the users message counter
	$sql = "UPDATE ".$db_prefix."users SET user_posts=user_posts+1 WHERE user_id='".$sender['user_id']."'";
	$result = dbquery($sql);
	if (!$result) {
		if ($settings['m2f_process_log']) logentry('ADDPOST', sprintf($locale['m2f907'], 'UPDATE', $db_prefix.'users'));
		if ($settings['m2f_process_log']) logentry('SQL: ',  $sql);
		return false;
	}

	// update the m2f received counter
	$result = dbquery("UPDATE ".$db_prefix."M2F_forums SET m2f_received=m2f_received+1 WHERE m2f_forumid='".$forum_id."'");

	// check if there are attachments. If so, save them, and link them to the post
	$error = 0;
	if (isset($post['attachment']) and is_array($post['attachment'])) {
		$attach_count = 0;
		foreach ($post['attachment'] as $attachment) {
			$attach_count++;
			// check if we're reached the max number of attachments allowed
			if ($attach_count > $settings['m2f_max_attachments']) {
				if ($settings['m2f_process_log']) logentry('ADDPOST', $locale['m2f908']);
				if ($settings['m2f_send_ndr']) send_reply($recipient, $sender, $locale['m2f996'].$settings['m2f_max_attachments']);
				break;
			}
			$attachname = substr($attachment['name'], 0, strrpos($attachment['name'], "."));
			$attachext = strtolower(strrchr($attachment['name'],"."));
			if ($attachment['size'] <= $settings['attachmax']) {
				$attachtypes = explode(",", $settings['attachtypes']);
				if (!in_array($attachext, $attachtypes)) {
					$attachname = attach_exists(strtolower($attachment['name']));
					if (!$handle = @fopen(PATH_ATTACHMENTS.$attachname, 'wb'))
						$error = 1;
					else {
						fwrite($handle, $attachment['body']);
						fclose($handle);
						chmod(PATH_ATTACHMENTS.$attachname,0644);
						if (in_array($attachext, $imagetypes)) {
							if (!@getimagesize(PATH_ATTACHMENTS.$attachname) || !@verify_image(PATH_ATTACHMENTS.$attachname)) {
								// extension doesn't match file type. Delete it
								unlink(PATH_ATTACHMENTS.$attachname);
								$error = 2;
							} else {
								// it's a valid image. See if we need to generate a thumbnail
								$imagefile = @getimagesize(PATH_ATTACHMENTS.$attachname);
								if ($imagefile[0] > $settings['thumb_w'] || $imagefile[1] > $settings['thumb_h']) {
									// image is bigger than the defined thumb size. Generate a thumb image
									createthumbnail($imagefile[2], PATH_ATTACHMENTS.$attachname, PATH_ATTACHMENTS.$attachname.".thumb", $settings['thumb_w'], $settings['thumb_h']);
								}
							}
						}
						if (!$error) {
							$result = dbquery("INSERT INTO ".$db_prefix."forum_attachments (thread_id, post_id, attach_name, attach_ext, attach_size) VALUES ('$thread_id', '$post_id', '$attachname', '$attachext', '".$attach['size']."')");
							if ($settings['m2f_process_log']) logentry('ADDPOST', sprintf($locale['m2f909'], PATH_ATTACHMENTS.$attachname, $post_id));
						}
					}
				} else {
					// illegal extension for this attachment. Skip it
					$error = 2;
				}
			} else {
				// filesize exceeded
				$error = 3;
			}
		}
	}
	switch ($error) {
		case 1:
			if ($settings['m2f_process_log']) logentry('ADDPOST', sprintf($locale['m2f910'], PATH_ATTACHMENTS.$attachname));
			return false;
		case 2:
			if ($settings['m2f_process_log']) logentry('ADDPOST', sprintf($locale['m2f911'], PATH_ATTACHMENTS.$attachname));
			return false;
		case 3:
			if ($settings['m2f_process_log']) logentry('ADDPOST', sprintf($locale['m2f911'], PATH_ATTACHMENTS.$attachname));
			return false;
		default:
			break;
	}

	return true;
}

// process a single MIME-multipart (could be recursive!)
function processmessageparts($messagepart) {

	global $locale, $settings, $post, $striphtml;

	switch (strtolower($messagepart->ctype_primary)) {
		case "multipart":
			// it's another multipart message. Process the parts
			if ($settings['m2f_process_log']) logentry('PARSE', 'MULTIPART-MIME messsage');
			foreach($messagepart->parts as $partnr => $msgpart) {
				if ($settings['m2f_process_log']) logentry('PARSE', 'MULTIPART-MIME PART: '.$msgpart->headers['content-type']);
				processmessageparts($msgpart);
			}
			break;
		case "text":
			if ($settings['m2f_process_log']) logentry('PARSE', 'MULTIPART-MIME text messsage');
			switch (strtolower($messagepart->ctype_secondary)) {
				case "plain":
					// don't overwrite a body from a previous body part
					if (!isset($post['body'])) {
						// convert charactersets
						$post['body'] = charsetconv($messagepart->body, $messagepart->ctype_parameters['charset']);
					}
					break;
				case "html":
					// HTML messages need to be sanitized. First get rid of some rubbish
					$post['body'] = preg_replace('/<!DOCTYPE(.|\s)*?>/i', '', $messagepart->body);
					$post['body'] = preg_replace('/<\?xml(.|\s)*?>/i', '', $post['body']);
					$post['body'] = preg_replace('/<!--(.|\s)*?>/i', '', $post['body']);
					// Next, remove tags we don't want, including their content
					foreach($striphtml as $tag) {
						$post['body'] = preg_replace('#<'.$tag.'>(.|\s)*?</'.$tag.'>#i', '', $post['body']);
					}
					// Get rid of line-ends and whitespace. This was HTML, they would have been ignored
					$post['body'] = preg_replace('#\r\n#si', '', $post['body']);
					$post['body'] = preg_replace('#\n#si', '', $post['body']);
					$post['body'] = str_replace('&nbsp;', ' ', $post['body']);
					$post['body'] = html_entity_decode($post['body'], ENT_COMPAT, 'ISO8859-15');
					while (strpos($post['body'], '  ') !== false) {
						$post['body'] = str_replace('  ', ' ', $post['body']);
					}
					// Convert supported HTML tags to BBCode
					$post['body'] = preg_replace('#<br>#si', "\n", $post['body']);
					$post['body'] = preg_replace('#</p>#si', "</p>\n", $post['body']);
					$post['body'] = preg_replace('#<hr(.*?)>#si', str_repeat('_', 70).chr(10), $post['body']);
					$post['body'] = preg_replace('#<li>(.*?)</li>#si', '[li]\1[/li]', $post['body']);
					$post['body'] = preg_replace('#<ul>(.*?)</ul>#si', '[ul]\1[/ul]', $post['body']);
					$post['body'] = preg_replace('#<b>(.*?)</b>#si', '[b]\1[/b]', $post['body']);
					$post['body'] = preg_replace('#<i>(.*?)</i>#si', '[i]\1[/i]', $post['body']);
					$post['body'] = preg_replace('#<u>(.*?)</u>#si', '[u]\1[/u]', $post['body']);
					$post['body'] = preg_replace('#<center>(.*?)</center>#si', '[center]\1[/center]', $post['body']);
					$post['body'] = preg_replace('#<strong>(.*?)</strong>#si', '[]b]\1[/b]', $post['body']);
					$post['body'] = preg_replace('#<font color=(.*?)>(.*?)</font>#si', '[color=\1]\2[/color]', $post['body']);
					// Remove any HTML tags remaining, but leave their content
					$post['body'] = preg_replace('#<(.*?)>#si', '', $post['body']);
					// convert charactersets if needed
					$post['body'] = charsetconv($post['body'], $messagepart->ctype_parameters['charset']);
					break;
				default:
					if ($settings['m2f_process_log']) logentry('PARSE', sprintf($locale['m2f913'], $messagepart->ctype_secondary));
					return false;
			}
			break;
		case "image":
		case "application":
		case "video":
		case "audio":
			if ($settings['m2f_process_log']) logentry('PARSE', 'MULTIPART-MIME binary attachment');
			if (!isset($post['attachment']) or !is_array($post['attachment'])) $post['attachment'] = array();
			$attachment = array();
			$attachment['type'] = $messagepart->ctype_primary;
			$attachment['subtype'] = $messagepart->ctype_secondary;
			$attachment['name'] = $messagepart->ctype_parameters['name'];
			$attachment['body'] = $messagepart->body;
			$attachment['size'] = strlen($messagepart->body);
			$post['attachment'][] = $attachment;
			unset($attachment);
			break;
		default:
			if ($settings['m2f_process_log']) logentry('PARSE', sprintf($locale['m2f914'], $messagepart->ctype_primary));
			return false;
	}
	return true;
}

// returns true if this user is allowed to post in this forum
function can_post($usergroups, $forumgroup, $userlevel) {
	global $db_prefix, $groups;

	// process according to the forumgroup
	switch ($forumgroup) {
		case 0:
			// public access
			return true;
			break;
		case 101:
		case 102:
		case 103:
			// members, administrators and webmaster fixed groups
			return ($userlevel >= $forumgroup);
			break;
		default:
			// all other groups
			$groups = explode(".", substr($usergroups, 1));
			foreach ($groups as $group) {
				// check if this groups has subgroups. If so, add them to the array
				getsubgroups($group);
			}
			// create a new user_group field with all inherited groups, and
			// get the inherited group rights and add them to the user own rights
			// everyone is always member of group 0 (public)
			$usergroups = ".0";
			foreach ($groups as $group) {
				$usergroups .= ".".$group;
				$result = dbarray(dbquery("SELECT group_groups FROM ".$db_prefix."user_groups WHERE group_id = '".$group."'"));
				if (isset($result['group_groups']) && $result['group_groups'] != "") {
					$usergroups .= ($usergroups==""?"":".").$result['group_groups'];
				}
			}
			if (in_array($forumgroup, explode(".", substr($usergroups,1)))) {
				return true;
			} else {
				return false;
			}
	}
}

/*---------------------------------------------------+
| initialisation code
+----------------------------------------------------*/

// log the start
if ($settings['m2f_process_log']) logentry('INIT', 'Program start');

// get the last modified timestamp of this module
$module_lastmod = filemtime('m2f_pop3.php');

// get the last modified timestamp of the config
$data = dbarray(dbquery("SELECT MAX(cfg_timestamp) AS lastmod FROM ".$db_prefix."configuration WHERE cfg_name LIKE 'm2f_%' AND cfg_name != 'm2f_last_polled'"));
$config_lastmod = $data['lastmod'];

// check if the Mail2Forum module is installed
$result = dbquery("SELECT * FROM ".$db_prefix."modules WHERE mod_title = '".$locale['m2f100']."'");
if (dbrows($result) == 0) {
	if ($settings['m2f_process_log']) logentry('INIT', $locale['m2f999'].' NOT_INSTALLED', true, 1);
	die($locale['m2f110']);
}

// initialize POP3-client
$pop3 =& new Net_POP3();
$pop3->_debug = $settings['m2f_pop3_debug'];

// initialize the SMTP mailer if required
if ($settings['m2f_send_ndr']) {
	require_once PATH_INCLUDES."class.phpmailer.php";
	$mail = new PHPMailer();
	if (file_exists(PATH_INCLUDES."languages/phpmailer.lang-".$settings['phpmailer_locale'].".php")) {
		$mail->SetLanguage($settings['phpmailer_locale'], PATH_INCLUDES."language/");
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
	$mail->CharSet = $settings['charset'];
	$mail->IsHTML(false);
}

/*---------------------------------------------------+
| main loop
+----------------------------------------------------*/

while (true) {

	// time of this poll
	$polltime = time();

	// Insert a "we're still alive" marker in the log every hour
	if (isset($marker) && $marker <> date("H"))
		if ($settings['m2f_process_log']) logentry("MARKER", "---");
	$marker = date("H");

	// check for messages received since the last poll
	$m2f_active = dbquery("SELECT f.forum_name, m.* FROM ".$db_prefix."M2F_forums m LEFT JOIN ".$db_prefix."forums f ON f.forum_id = m.m2f_forumid WHERE m.m2f_active = '1'");
	while ($forum = dbarray($m2f_active)) {
		// Get the incoming mail for this forum
		$pop3connect = false;
		if ($settings['m2f_pop3_debug']) logdebug('LOGIN', 'before the POP3 connect');
		if($pop3->connect($settings['m2f_pop3_server'], $settings['m2f_pop3_port'])) {
			if ($settings['m2f_pop3_debug']) logdebug('LOGIN', 'before the POP3 login');
			if($pop3->login($forum['m2f_userid'], $forum['m2f_password'])) {
				if ($settings['m2f_pop3_debug']) logdebug('LOGIN', 'before getting the new message counter');
				$pop3connect = true;
				$newmsg = $pop3->numMsg();
				if ($newmsg !== false) {
					if ($newmsg && $settings['m2f_process_log']) logentry('RETR', 'Mailbox '.$forum['m2f_email'].' - '.$newmsg.' new messages');
				}
			}
		}
		// if the connect failed, log the error. Otherwise start processing the message(s)
		if (!$pop3connect) {
			if ($settings['m2f_process_log']) logentry('CONNECT', $locale['m2f999'].'No connection to the "'.$forum['forum_name'].'" POP3 mailbox ('.$forum['m2f_userid'].')');
		} else {
			// retrieve and process the new messages
			for($i=1;$i<=$newmsg;$i++) {
				// finished processing flag. If true, message will be deleted after processing
				$processed = false;
				// use the PEAR mimeDecode class to decode the message
				$params['include_bodies'] = true;
				$params['decode_bodies'] = true;
				$params['decode_headers'] = true;
				$decoder = new Mail_mimeDecode($pop3->getMsg($i));
				$message = $decoder->decode($params);
				if ($message === false) {
					if ($settings['m2f_process_log']) logentry('PARSE',  $decoder->_error);
				} else {
					// parse the header of the message
					$post = array();
					if (!empty($message->headers['thread-topic']))
						$post['subject'] = $message->headers['thread-topic'];
					else
						$post['subject'] = $message->headers['subject'];
					// subject with a valid thread-id
					if (preg_match("/(.*)\[-(.*)-\](.*)/i", $message->headers['subject'], $matches)) {
						$post['subject'] = array();
						$post['subject']['subject'] = $matches[1];
						$post['subject']['thread_id'] = $matches[2];
					}
					// if the thread topic is present, get it, as it is more reliable
					if (isset($message->headers['thread-topic']) && preg_match("/(.*)\[-(.*)\|(.*)-\](.*)/i", $message->headers['thread-topic'], $matches)) {
						$post['thread'] = array();
						$post['thread']['subject'] = $matches[1];
						$post['thread']['forum_id'] = $matches[2];
						$post['thread']['post_id'] = $matches[3];
					}
					// if there were multiple mail hops, use the first one in the chain (the one that delivered the message)
					$receivedheader = $message->headers['received'];
					if (is_array($receivedheader)) $receivedheader = $receivedheader[0];
					if ($settings['m2f_pop3_debug']) echo "Header: ".$receivedheader."\n";
					// get some information of the sending system
					if (preg_match("#from (.*)\((.*)\[(.*)\]\)(.*)\; (.*)#i", $receivedheader, $matches)) {
						$post['received'] = array();
						$post['received']['domain'] = $matches[1];
						$post['received']['mailhost'] = $matches[2];
						$post['received']['ip'] = $matches[3];
						$post['received']['date'] = $matches[5];
					}
					// information about the poster
					if (preg_match("/\"(.*)\"(.*)<(.*)>/i", $message->headers['from'], $matches)) {
						$post['from'] = array();
						$post['from']['user'] = $matches[1];
						$post['from']['email'] = $matches[3];
					} elseif (preg_match("/(.*)<(.*)>/i", $message->headers['from'], $matches)) {
						$post['from'] = array();
						$post['from']['user'] = trim($matches[1]);
						$post['from']['email'] = $matches[2];
					} else {
						$post['from'] = array();
						$post['from']['forum'] = $message->headers['from'];
						$post['from']['email'] = $message->headers['from'];
					}
					// to which forum has this been sent?
					if (preg_match("/\"(.*)\"(.*)<(.*)>/i", $message->headers['to'], $matches)) {
						$post['to'] = array();
						$post['to']['forum'] = $matches[1];
						$post['to']['email'] = $matches[3];
					} elseif (preg_match("/(.*)<(.*)>/i", $message->headers['to'], $matches)) {
						$post['to'] = array();
						$post['to']['forum'] = trim($matches[1]);
						$post['to']['email'] = $matches[2];
					} else {
						$post['to'] = array();
						$post['to']['forum'] = $message->headers['to'];
						$post['to']['email'] = $message->headers['to'];
					}
 					// process the body (or the body parts)
					if ($settings['m2f_pop3_debug']) echo "Message: ".$message->ctype_primary."\n";
					if (strtolower($message->ctype_primary) == 'text') {
						// if it's a plain-text message, just grab the body
						$post['body'] = charsetconv($message->body, $messagepart->ctype_parameters['charset']);
						if (isset($post['subject'])) {
							if (is_array($post['subject'])) {
								$post['subject']['subject'] = charsetconv($post['subject']['subject'], $messagepart->ctype_parameters['charset']);
							} else {
								$post['subject'] = charsetconv($post['subject'], $messagepart->ctype_parameters['charset']);
							}
						}
					} elseif (strtolower($message->ctype_primary) == 'multipart') {
						// in debug mode, skip this message if the mime decoding failed
						if (!processmessageparts($message) && $settings['m2f_pop3_debug'])
							continue;
					} else {
						// unknown primary type
						if ($settings['m2f_process_log']) logentry('PARSE',  "Message has an unsupported primary content-type:".$msgpart->ctype_primary."!");
					}
				}
				// validate the parsed information
				if (!isset($post['subject']) && $settings['m2f_process_log']) logentry('PARSE', "Missing 'Subject' information!");
				if (!isset($post['received'])) {
					$post['received'] = array('ip' => '0.0.0.0');
					if ($settings['m2f_process_log']) logentry('PARSE', "Missing 'Received' information!");
				}
				if (!isset($post['from']) && $settings['m2f_process_log']) logentry('PARSE', "Missing 'From' information!");
				if (!isset($post['to']) && $settings['m2f_process_log']) logentry('PARSE', "Missing 'To' information!");

				if ($settings['m2f_pop3_message_debug']) dumpmessage($message, $post);

				// find the user
				$sender = dbarray(dbquery("SELECT * FROM ".$db_prefix."users WHERE LOWER(user_email) = '".strtolower($post['from']['email'])."' AND user_status = 0"));

				// find the forum
				$recipient = dbarray(dbquery("SELECT m.*, f.forum_name, f.forum_posting FROM ".$db_prefix."M2F_forums m, ".$db_prefix."forums f WHERE m2f_active = '1' AND m.m2f_forumid = f.forum_id AND LOWER(m2f_email) = '".strtolower($post['to']['email'])."'"));

				// if the user is not found, but public posts to the forum are allowed, create a dummy sender record
				if (!is_array($sender) && $recipient['m2f_posting'] == 0) {
					$sender = array('user_id' => 0);
				}

				// both found, and is the sender is allowed to post in this forum?
				if (is_array($sender)) {
					if (is_array($recipient)) {
						if ($recipient['m2f_posting'] == 0) {
							$send_allowed = true;
						} else {
							if ($settings['m2f_subscribe_required']) {
								$send_allowed = dbrows(dbquery("SELECT m2f_subid FROM ".$db_prefix."M2F_subscriptions WHERE m2f_subscribed = '1' AND m2f_userid = '".$sender['user_id']."' AND m2f_forumid = '".$recipient['m2f_forumid']."'"));
								if ($settings['m2f_process_log']) logentry('DEBUG', "QUERY: SELECT m2f_subid FROM ".$db_prefix."M2F_subscriptions WHERE m2f_subscribed = '1' AND m2f_userid = '".$sender['user_id']."' AND m2f_forumid = '".$recipient['m2f_forumid']."', result = ".($send_allowed?"TRUE":"FALSE"));
							} else {
								$send_allowed = can_post($sender['user_groups'], $recipient['m2f_posting'], $sender['user_level']);
								if ($settings['m2f_process_log']) logentry('DEBUG', "CAN_POST() CHECK: ".($send_allowed?"TRUE":"FALSE").", sender = ".$sender['user_groups'].", recipient = ".$recipient['m2f_posting']);
							}
						}
						if($send_allowed) {
							// poster is allowed to post. Do we have a thread_id identified?
							if (is_array($post['subject']) && isset($post['subject']['thread_id'])) {
								// see if we can locate this thread
								if ($settings['m2f_follow_thread']) {
									$thread = dbarray(dbquery("SELECT * FROM ".$db_prefix."threads WHERE thread_id = '".$post['subject']['thread_id']."'"));
								} else {
									$thread = dbarray(dbquery("SELECT * FROM ".$db_prefix."threads WHERE forum_id = '".$recipient['m2f_forumid']."' AND thread_id = '".$post['subject']['thread_id']."'"));
								}
								if (is_array($thread)) {
									// found the tread. Post the new message
									if (addnewpost($thread['forum_id'], $thread['thread_id'], $sender, $recipient, $post))
										if ($settings['m2f_process_log']) logentry('POST', "Post reply from ".$post['from']['email']." to thread ".$post['subject']['thread_id']);
									else
										if ($settings['m2f_process_log']) logentry('POST', "Failed to add post reply from ".$post['from']['email']." to thread ".$post['subject']['thread_id']);
									$processed = true;
								} else {
									// Forum/Thread mismatch (or thread does not exist)
									if ($settings['m2f_process_log']) logentry('VERIFY', "Thread: ".$post['subject']['thread_id']." does not belong to forum ".$post['to']['email']);
									$subject = (is_array($post['subject'])?$post['subject']['subject']:$post['subject']);
									if ($settings['m2f_send_ndr']) send_reply($recipient, $sender, sprintf($locale['m2f992'], $subject));
									$processed = true;
								}
							} else {
								// not a valid thread_id extracted. Sanitize the subject first
								$subject = trim(strtolower($post['subject']));
								foreach($stripsubject as $prefix) {
									$subject = preg_replace('#'.$prefix.'#i', '', $subject);
								}
								$subject = trim($subject);
								// See if we can match the subject
								$result = dbquery("SELECT DISTINCT forum_id, thread_id FROM ".$db_prefix."posts WHERE forum_id = '".$recipient['m2f_forumid']."' AND LOWER(post_subject)='".mysql_escape_string($subject)."' ORDER BY thread_id");
								switch (dbrows($result)) {
									case 0:
										// subject not found. Must be a new post
										if (addnewpost($recipient['m2f_forumid'], -1, $sender, $recipient, $post))
											if ($settings['m2f_process_log']) logentry('POST', "New thread from ".$post['from']['email']);
										else
											if ($settings['m2f_process_log']) logentry('POST', "Failed to add new thread from ".$post['from']['email']);
										$processed = true;
										break;
									case 1:
										// found the tread by matching the subject of the email
										$thread = dbarray($result);
										if (addnewpost($recipient['m2f_forumid'], $thread['thread_id'], $sender, $recipient, $post))
											if ($settings['m2f_process_log']) logentry('POST', "Post reply from ".$post['from']['email']." to thread ".$thread['thread_id']);
										else
											if ($settings['m2f_process_log']) logentry('POST', "Failed to add post reply from ".$post['from']['email']." to thread ".$post['subject']['thread_id']);
										$processed = true;
										break;
									default:
										// multiple subjects matched the query. How now brown cow?
										if ($settings['m2f_process_log']) logentry('VERIFY', "Multiple subject match: ".$post['from']['email']." => ".$post['to']['email']);
										// For now, assume a new post
										if (addnewpost($recipient['m2f_forumid'], -1, $sender, $recipient, $post))
											if ($settings['m2f_process_log']) logentry('POST', "New post from ".$post['from']['email']." to thread ".$thread['thread_id']);
										else
											if ($settings['m2f_process_log']) logentry('POST', "Failed to add new post from ".$post['from']['email']." to thread ".$post['subject']['thread_id']);
										$processed = true;
										break;
								}
							}
						} else {
							// sender is not subscribed to the forum
							// Output some debug info for now and send an NDR
							if ($settings['m2f_process_log']) logentry('VERIFY', "Member: ".$post['from']['email']." is not subscribed to ".$post['to']['email']);
							$subject = (is_array($post['subject'])?$post['subject']['subject']:$post['subject']);
							if ($settings['m2f_send_ndr']) send_reply($recipient, $sender, sprintf($locale['m2f993'], $subject));
							$processed = true;
						}
					} else {
						// no match on recipient, shouldn't be possible, means a mismatch between smtp envelope and message header.
						// Output some debug info for now and send an NDR
						if ($settings['m2f_process_log']) logentry('VERIFY', "No such forum: ".$post['to']['email']);
						$subject = (is_array($post['subject'])?$post['subject']['subject']:$post['subject']);
						if ($settings['m2f_send_ndr']) send_reply($recipient, $sender, sprintf($locale['m2f994'], $subject));
						$processed = true;
					}
				} else {
					// no match on sender
					// Output some debug info for now and send an NDR
				if ($settings['m2f_process_log']) logentry('VERIFY', "No such member: ".$post['from']['email']);
					$subject = (is_array($post['subject'])?$post['subject']['subject']:$post['subject']);
					if ($settings['m2f_send_ndr']) send_reply($recipient, $sender, sprintf($locale['m2f995'], $subject, $post['from']['email']));
					$processed = true;
				}
				// finished processing this message. Delete it from the server
				if ($processed) $pop3->deleteMsg($i);
			}
		}
		// finished processing POP3 messages. Close the connection
		if ($pop3connect) {
			$pop3->disconnect();
		}
	}

	// if the module has been modified, exit so it can be restarted
	clearstatcache();
	if (filemtime('m2f_pop3.php') != $module_lastmod) {
		if ($settings['m2f_process_log']) logentry('EXIT', 'Restart due to module code update');
		exit(99);
	}
	// get the last modified timestamp of the config
	$data = dbarray(dbquery("SELECT MAX(cfg_timestamp) AS lastmod FROM ".$db_prefix."configuration WHERE cfg_name LIKE 'm2f_%' AND cfg_name != 'm2f_last_polled'"));
	if ($data['lastmod'] != $config_lastmod) {
		if ($settings['m2f_process_log']) logentry('EXIT', 'Restart due to a configuration change');
		exit(99);
	}

	// calculate the next interval. Log a warning if we can't process quick enough
	$interval = $polltime + $settings['m2f_interval'] - time();
	if ($interval < 0) {
		if ($settings['m2f_process_log']) logentry('SLEEP', $locale['m2f999'].' '.$locale['m2f804']);
	} else {
		sleep($interval);
	}
}
?>
