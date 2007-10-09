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
require_once dirname(__FILE__)."/../../includes/core_functions.php";
require_once PATH_ROOT."/includes/theme_functions.php";

// load the locale for this module
if (file_exists(PATH_MODULES."newsletters/locale/".$settings['locale'].".php")) {
	$locale_include = PATH_MODULES."newsletters/locale/".$settings['locale'].".php";
} else {
	$locale_include = PATH_MODULES."newsletters/locale/English.php";
}
include $locale_include;

// temp storage for template variables
$variables = array();

// check for the proper admin access rights
if (!checkrights("dA") || !defined("iAUTH") || $aid != iAUTH) fallback(BASEDIR."index.php");

/*---------------------------------------------------+
| Local functions                                    |
+----------------------------------------------------*/

function html2text($html)
{
    $html = preg_replace('~<br[^>]+>~si',"[@]",$html);
    $tags = array (
    0 => '~<h[123][^>]+>~si',
    1 => '~<h[456][^>]+>~si',
    2 => '~<table[^>]+>~si',
    3 => '~<tr[^>]+>~si',
    4 => '~<li[^>]+>~si',
    5 => '~<p[^>]+>~si',
    6 => '~<span[^>]+>~si',
    7 => '~<div[^>]+>~si',
    );
    $html = preg_replace($tags,"\n",$html);
    $html = preg_replace('~</t(d|h)>\s*<t(d|h)[^>]+>~si',' - ',$html);
    $html = preg_replace('~<[^>]+>~s','',$html);
    // reducing spaces
    $html = preg_replace('~ +~s',' ',$html);
    $html = preg_replace('~^\s+~m','',$html);
    $html = preg_replace('~\s+$~m','',$html);
    // reducing newlines
    $html = preg_replace('~\n+~s',"\n",$html);
    $html = str_replace("[@]","\n",$html);
    return $html;
}

// phpmailer init functions
function mailer_init() {
	global $mail, $locale, $settings;

	// $mail->SMTPDebug = 2;

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
| Main code                                          |
+----------------------------------------------------*/

// response processing 

if (isset($_POST['save']) || isset($_POST['copy'])) {

	// save or copy a newsletter
	if (isset($_POST['copy'])) unset($newsletter_id);
	$subject = addslash(descript($_POST['subject']));
	$content = addslash(descript($_POST['content']));
	if (isset($newsletter_id)) {
		$result = dbquery("UPDATE ".$db_prefix."newsletters SET newsletter_subject='$subject', newsletter_content='$content', newsletter_format='".$_POST['format']."' WHERE newsletter_id='$newsletter_id'");
		$variables['message'] = $locale['nl414'];
		$title = $locale['nl410'];
	} else {
		$result = dbquery("INSERT INTO ".$db_prefix."newsletters (newsletter_subject, newsletter_content, newsletter_format, newsletter_datestamp) VALUES('$subject', '$content', '".$_POST['format']."', '".time()."')");
		$variables['message'] = $locale['nl415'];
		$title = $locale['nl411'];
	}
	$variables['bold'] = true;
	$template_panels[] = array('type' => 'body', 'title' => $title, 'name' => 'modules.newsletters.message', 'template' => '_message_table_panel.tpl');
	$template_variables['modules.newsletters.message'] = $variables;
	$variables = array();
	unset($newsletter_id);

} else if (isset($_POST['send_cancel'])) {

	// abort sending this newsletter out
	unset($newsletter_id);
		
} else if (isset($_POST['send_send'])) {

	// send the newsletter to the required audience
	$result = dbquery("SELECT * FROM ".$db_prefix."newsletters WHERE newsletter_id='".$_POST['newsletter_id']."'");
	if (dbrows($result) == 0) fallback(BASEDIR."index.php");
	$data = dbarray($result);

	// extract and validate the posted selection
	$date_lb = 0; $date_la = 0; $date_rb = 0; $date_ra = 0; 
	if ($_POST['date_lb']['mday']!="--" && $_POST['date_lb']['mon']!="--" && $_POST['date_lb']['year']!="----") {
		$date_lb = mktime($_POST['date_lb']['hours'],$_POST['date_lb']['minutes'],0,$_POST['date_lb']['mon'],$_POST['date_lb']['mday'],$_POST['date_lb']['year']);
	}
	if ($_POST['date_la']['mday']!="--" && $_POST['date_la']['mon']!="--" && $_POST['date_la']['year']!="----") {
		$date_la = mktime($_POST['date_la']['hours'],$_POST['date_la']['minutes'],0,$_POST['date_la']['mon'],$_POST['date_la']['mday'],$_POST['date_la']['year']);
	}
	if ($_POST['date_rb']['mday']!="--" && $_POST['date_rb']['mon']!="--" && $_POST['date_rb']['year']!="----") {
		$date_rb = mktime($_POST['date_rb']['hours'],$_POST['date_rb']['minutes'],0,$_POST['date_rb']['mon'],$_POST['date_rb']['mday'],$_POST['date_rb']['year']);
	}
	if ($_POST['date_ra']['mday']!="--" && $_POST['date_ra']['mon']!="--" && $_POST['date_ra']['year']!="----") {
		$date_ra = mktime($_POST['date_ra']['hours'],$_POST['date_ra']['minutes'],0,$_POST['date_ra']['mon'],$_POST['date_ra']['mday'],$_POST['date_ra']['year']);
	}
	$days_mt = (isNum($_POST['days_mt']) && $_POST['days_mt'] > 0) ? $_POST['days_mt'] : 0;
	$days_lt = (isNum($_POST['days_lt']) && $_POST['days_lt'] > 0) ? $_POST['days_lt'] : 0;
	$send_to_all = $_POST['send_to_all'] == 1;
	$send_to_myself = $_POST['send_to_myself'] == 1;
	$userlist = $_POST['users']=="" ? "" : explode(",", $_POST['users']);

	// build the query on the user table based on the selection made
	$query = "SELECT * FROM ".$db_prefix."users WHERE";
	$where = "";
	if ($send_to_myself) {
		$where .= " user_id='".$userdata['user_id']."'";
	} else if (is_array($userlist)) {
		foreach($userlist as $user) {
			if (isNum($user)) {
				$where .= ($where==""?"":" OR")." user_id='".$user."'";
			} else {
				$where .= ($where==""?"":" OR")." user_name='".$user."'";
			}
		}
		$send_to_all = false;
	} else if (!$send_to_all) {
		if ($date_lb) $where .= " user_lastvisit < '".$date_lb."'";
		if ($date_la) $where .= ($where==""?"":" AND")." user_lastvisit > '".$date_la."'";
		if ($date_rb) $where .= ($where==""?"":" AND")." user_joined < '".$date_rb."'";
		if ($date_ra) $where .= ($where==""?"":" AND")." user_joined > '".$date_ra."'";
		if ($days_mt) $where .= ($where==""?"":" AND")." user_lastvisit < '".(time() - $days_mt*86400)."'";
		if ($days_lt) $where .= ($where==""?"":" AND")." user_lastvisit > '".(time() - $days_lt*86400)."'";
		$where .= ($where==""?"":" AND")." user_newsletters != '0'";
	}
	if ($where) $query .= $where; else $query .= " 1";
	$result2 = dbquery($query);

	
	$error = ""; $sc = 0;
	if (dbrows($result2) == 0) {
		$error = $locale['nl419'];
	} else {
		// initialize PHP-Mailer
		require_once PATH_INCLUDES."phpmailer_include.php";
		$mail = new PHPMailer();
		mailer_init();
		$error = array();
		while($data2 = dbarray($result2)) {
			$subject = stripslashes($data['newsletter_subject']);
			// replace tags in the subject
			$subject = str_replace("{:USER_NAME:}", $data2['user_name'], $subject);

			$content = stripslashes($data['newsletter_content']);
			// replace tags in the body
			$content = str_replace("{:USER_ID:}", $data2['user_id'], $content);
			$content = str_replace("{:USER_NAME:}", $data2['user_name'], $content);
			$content = str_replace("{:USER_EMAIL:}", $data2['user_email'], $content);
			$content = str_replace("{:USER_POSTS:}", $data2['user_posts'], $content);
			$content = str_replace("{:USER_JOINED:}", showdate('shortdate', $data2['user_joined']), $content);
			$content = str_replace("{:USER_LASTVISIT:}", showdate('shortdate', $data2['user_lastvisit']), $content);
			$content = str_replace("{:USER_JOINED:S:}", showdate('shortdate', $data2['user_joined']), $content);
			$content = str_replace("{:USER_LASTVISIT:S:}", showdate('shortdate', $data2['user_lastvisit']), $content);
			$content = str_replace("{:USER_JOINED:L:}", showdate('longdate', $data2['user_joined']), $content);
			$content = str_replace("{:USER_LASTVISIT:L:}", showdate('longdate', $data2['user_lastvisit']), $content);
			$content = str_replace("{:USER_JOINED:D:}", showdate('%d-%m-%Y', $data2['user_joined']), $content);
			$content = str_replace("{:USER_LASTVISIT:D:}", showdate('%d-%m-%Y', $data2['user_lastvisit']), $content);
			$content = str_replace("{:USER_JOINED:T:}", showdate('%T', $data2['user_joined']), $content);
			$content = str_replace("{:USER_LASTVISIT:T:}", showdate('%T', $data2['user_lastvisit']), $content);
			$content = str_replace("{:TIME:}", strftime("%T"), $content);
			$content = str_replace("{:DATE:}", showdate('%d-%m-%Y'), $content);
			$content = str_replace("{:DATE:S:}", showdate('shortdate'), $content);
			$content = str_replace("{:DATE:L:}", showdate('longdate'), $content);
			$content = str_replace("{:DATE:D:}", showdate('%d-%m-%Y'), $content);
			$content = str_replace("{:DATE:T:}", showdate('%T'), $content);

			// text version
			$text = html2text($content);
			$html = "<html>\n<head>\n<style type=\"text/css\">\n
	<!--
	a { color: #0000ff; text-decoration:none; }
	a:hover { color: #0000ff; text-decoration: underline; }
	body { font-family:Verdana,Tahoma,Arial,Sans-Serif; font-size:11px; }
	p { font-family:Verdana,Tahoma,Arial,Sans-Serif; font-size:11px; }
	.td { font-family:Verdana,Tahoma,Arial,Sans-Serif; font-size:11px; }
	-->
</style>\n</head>\n<body>\n".stripslashes($content)."\n</body>\n</html>";

			// send it out
			if (false) {
				// debug line
				$error[] = "processed: ".$data2['user_name']." (".$data2['user_email'].")<br />";
			} else {
				$mail->Sender = $settings['newsletter_email']=="" ? $settings['siteemail'] : $settings['newsletter_email'];
				$mail->From = $settings['newsletter_email']=="" ? $settings['siteemail'] : $settings['newsletter_email'];
				$mail->FromName = $settings['siteusername'];
				$mail->AddAddress($data2['user_email'], ($data2['user_fullname']=="" ? $data2['user_name'] : $data2['user_fullname']));
				$mail->AddCustomHeader("X-version: ExiteCMS Newsletters v".$locale['nlver']);
				
				switch ($data2['user_newsletters']) {
					case 1:
						$format = "HTML";
						$mail->IsHTML(true);
						$mail->Body = $html;
						$mail->AltBody = $text;
						break;
					case 2:
						$format = "plain/text";
						$mail->IsHTML(false);
						$mail->Body = $text;
						$mail->AltBody = "";
						break;
					default:
						$format = "unknown";
				}
				$mail->Subject = $subject;

				if(!$mail->Send()) {
					$error[] = $data2['user_name']." (".$data2['user_email']."), format = ".$format."<br />";
				} else {
					$sc++;
				}
				// clear everything
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

	// process the error messages
	$variables['message'] = "<b>";
	if (is_array($error)) {
		if ($send_to_myself) {
			$variables['message'] .= $locale['nl424']."<br /><br />";
		} else {
			$variables['message'] .= sprintf($locale['nl416'], $sc)."<br /><br />";
		}
		$se = count($error);
		if ($se) {
			$variables['message'] .= sprintf($locale['nl417'], $se)."<br /><br />";
			foreach($error as $errline) {
				$variables['message'] .= $errline;
			}
			$variables['message'] .= "<b>".$locale['nl418']."</b>";
		}
	} else {
		$variables['message'] .= $error;
	}
	$variables['bold'] = true;
	$template_panels[] = array('type' => 'body', 'title' => $locale['nl479'], 'name' => 'modules.newsletters.message', 'template' => '_message_table_panel.tpl');
	$template_variables['modules.newsletters.message'] = $variables;
	$variables = array();
	// if this was not a test send, mark it as sent
	if (!$send_to_myself) {
		$result = dbquery("UPDATE ".$db_prefix."newsletters SET newsletter_sent='1', newsletter_send_datestamp='".time()."' WHERE newsletter_id='".$_POST['newsletter_id']."'");
	}
	unset($newsletter_id);
} 

// panel processing

if (isset($_POST['send'])) {

	// prepare the distribution list for this newsletter
	$result = dbquery("SELECT * FROM ".$db_prefix."newsletters WHERE newsletter_id='".$_POST['newsletter_id']."'");
	if (dbrows($result) == 0) fallback(BASEDIR."index.php");

	$data = dbarray($result);
	$subject = str_replace("{:USER_NAME:}", "<span style='font-family:monospace;color:red;font-size:12px'>".$userdata['user_name']."</span>", stripslashes($data['newsletter_subject']));
	$content = str_replace("{:USER_NAME:}", "<span style='font-family:monospace;color:red;font-size:12px'>".$userdata['user_name']."</span>", stripslashes($data['newsletter_content']));
	$content = str_replace("{:USER_ID:}", "<span style='font-family:monospace;color:red;font-size:12px'>".$userdata['user_id']."</span>", $content);
	$content = str_replace("{:USER_EMAIL:}", "<span style='font-family:monospace;color:red;font-size:12px'>".$userdata['user_email']."</span>", $content);
	$content = str_replace("{:USER_POSTS:}", "<span style='font-family:monospace;color:red;font-size:12px'>".$userdata['user_posts']."</span>", $content);
	$content = str_replace("{:USER_JOINED:}", "<span style='font-family:monospace;color:red;font-size:12px'>".showdate('shortdate', $userdata['user_joined'])."</span>", $content);
	$content = str_replace("{:USER_LASTVISIT:}", "<span style='font-family:monospace;color:red;font-size:12px'>".showdate('shortdate', $userdata['user_lastvisit'])."</span>", $content);
	$content = str_replace("{:USER_JOINED:S:}", "<span style='font-family:monospace;color:red;font-size:12px'>".showdate('shortdate', $userdata['user_joined'])."</span>", $content);
	$content = str_replace("{:USER_LASTVISIT:S:}", "<span style='font-family:monospace;color:red;font-size:12px'>".showdate('shortdate', $userdata['user_lastvisit'])."</span>", $content);
	$content = str_replace("{:USER_JOINED:L:}", "<span style='font-family:monospace;color:red;font-size:12px'>".showdate('longdate', $userdata['user_joined'])."</span>", $content);
	$content = str_replace("{:USER_LASTVISIT:L:}", "<span style='font-family:monospace;color:red;font-size:12px'>".showdate('longdate', $userdata['user_lastvisit'])."</span>", $content);
	$content = str_replace("{:USER_JOINED:D:}", "<span style='font-family:monospace;color:red;font-size:12px'>".showdate('%d-%m-%Y', $userdata['user_joined'])."</span>", $content);
	$content = str_replace("{:USER_LASTVISIT:D:}", "<span style='font-family:monospace;color:red;font-size:12px'>".showdate('%d-%m-%Y', $userdata['user_lastvisit'])."</span>", $content);
	$content = str_replace("{:USER_JOINED:T:}", "<span style='font-family:monospace;color:red;font-size:12px'>".showdate('%T', $userdata['user_joined'])."</span>", $content);
	$content = str_replace("{:USER_LASTVISIT:T:}", "<span style='font-family:monospace;color:red;font-size:12px'>".showdate('%T', $userdata['user_lastvisit'])."</span>", $content);
	$content = str_replace("{:TIME:}", "<span style='font-family:monospace;color:red;font-size:12px'>".strftime("%T")."</span>", $content);
	$content = str_replace("{:DATE:S:}", "<span style='font-family:monospace;color:red;font-size:12px'>".showdate('shortdate')."</span>", $content);
	$content = str_replace("{:DATE:L:}", "<span style='font-family:monospace;color:red;font-size:12px'>".showdate('longdate')."</span>", $content);
	$content = str_replace("{:DATE:D:}", "<span style='font-family:monospace;color:red;font-size:12px'>".showdate('%d-%m-%Y')."</span>", $content);
	$content = str_replace("{:DATE:T:}", "<span style='font-family:monospace;color:red;font-size:12px'>".showdate('%T')."</span>", $content);
	$content = str_replace("{:DATE:}", "<span style='font-family:monospace;color:red;font-size:12px'>".showdate('shortdate')."</span>", $content);
	// convert &, htmlentities is way to strict for this!
	$variables['html'] = str_replace('&', '&amp;', str_replace('&amp;', '&', $content));

	$template_panels[] = array('type' => 'body', 'title' => $subject, 'name' => 'modules.newsletters.preview', 'template' => '_custom_html.tpl');
	$template_variables['modules.newsletters.preview'] = $variables;
	$variables = array();

	$variables['newsletter_id'] = $_POST['newsletter_id'];
	$template_panels[] = array('type' => 'body', 'name' => 'modules.newsletters.send', 'template' => 'modules.newsletters.send.tpl', 'locale' => $locale_include);
	$template_variables['modules.newsletters.send'] = $variables;
	$variables = array();

} else {

	// prepare the newsletters selection panel
	$variables['newsletters'] = array();
	$result = dbquery("SELECT * FROM ".$db_prefix."newsletters ORDER BY newsletter_datestamp DESC");
	while ($data = dbarray($result)) {
		$data['newsletter_subject'] = stripslashes($data['newsletter_subject']);
		$data['selected'] = (isset($newsletter_id) && $newsletter_id == $data['newsletter_id']);
		$variables['newsletters'][] = $data;
	}
	
	// define the main newsletters body panel
	$template_panels[] = array('type' => 'body', 'name' => 'modules.newsletters', 'template' => 'modules.newsletters.tpl', 'locale' => $locale_include);
	$template_variables['modules.newsletters'] = $variables;
	$variables = array();

	// prepare the preview/add/edit panel
	if (isset($_POST['preview'])) {
		$subject = stripslashes(descript($_POST['subject']));
		$subject = str_replace("{:USER_NAME:}", "<span style='font-family:monospace;color:red;font-size:12px'>".$userdata['user_name']."</span>", $subject);
		$content = stripslashes(descript($_POST['content']));
		$content = str_replace("{:USER_NAME:}", "<span style='font-family:monospace;color:red;font-size:12px'>".$userdata['user_name']."</span>", $content);
		$content = str_replace("{:USER_ID:}", "<span style='font-family:monospace;color:red;font-size:12px'>".$userdata['user_id']."</span>", $content);
		$content = str_replace("{:USER_EMAIL:}", "<span style='font-family:monospace;color:red;font-size:12px'>".$userdata['user_email']."</span>", $content);
		$content = str_replace("{:USER_POSTS:}", "<span style='font-family:monospace;color:red;font-size:12px'>".$userdata['user_posts']."</span>", $content);
		$content = str_replace("{:USER_JOINED:}", "<span style='font-family:monospace;color:red;font-size:12px'>".showdate('shortdate', $userdata['user_joined'])."</span>", $content);
		$content = str_replace("{:USER_LASTVISIT:}", "<span style='font-family:monospace;color:red;font-size:12px'>".showdate('shortdate', $userdata['user_lastvisit'])."</span>", $content);
		$content = str_replace("{:USER_JOINED:S:}", "<span style='font-family:monospace;color:red;font-size:12px'>".showdate('shortdate', $userdata['user_joined'])."</span>", $content);
		$content = str_replace("{:USER_LASTVISIT:S:}", "<span style='font-family:monospace;color:red;font-size:12px'>".showdate('shortdate', $userdata['user_lastvisit'])."</span>", $content);
		$content = str_replace("{:USER_JOINED:L:}", "<span style='font-family:monospace;color:red;font-size:12px'>".showdate('longdate', $userdata['user_joined'])."</span>", $content);
		$content = str_replace("{:USER_LASTVISIT:L:}", "<span style='font-family:monospace;color:red;font-size:12px'>".showdate('longdate', $userdata['user_lastvisit'])."</span>", $content);
		$content = str_replace("{:USER_JOINED:D:}", "<span style='font-family:monospace;color:red;font-size:12px'>".showdate('%d-%m-%Y', $userdata['user_joined'])."</span>", $content);
		$content = str_replace("{:USER_LASTVISIT:D:}", "<span style='font-family:monospace;color:red;font-size:12px'>".showdate('%d-%m-%Y', $userdata['user_lastvisit'])."</span>", $content);
		$content = str_replace("{:USER_JOINED:T:}", "<span style='font-family:monospace;color:red;font-size:12px'>".showdate('%T', $userdata['user_joined'])."</span>", $content);
		$content = str_replace("{:USER_LASTVISIT:T:}", "<span style='font-family:monospace;color:red;font-size:12px'>".showdate('%T', $userdata['user_lastvisit'])."</span>", $content);
		$content = str_replace("{:TIME:}", "<span style='font-family:monospace;color:red;font-size:12px'>".strftime("%T")."</span>", $content);
		$content = str_replace("{:DATE:S:}", "<span style='font-family:monospace;color:red;font-size:12px'>".showdate('shortdate')."</span>", $content);
		$content = str_replace("{:DATE:L:}", "<span style='font-family:monospace;color:red;font-size:12px'>".showdate('longdate')."</span>", $content);
		$content = str_replace("{:DATE:D:}", "<span style='font-family:monospace;color:red;font-size:12px'>".showdate('%d-%m-%Y')."</span>", $content);
		$content = str_replace("{:DATE:T:}", "<span style='font-family:monospace;color:red;font-size:12px'>".showdate('%T')."</span>", $content);
		$content = str_replace("{:DATE:}", "<span style='font-family:monospace;color:red;font-size:12px'>".showdate('shortdate')."</span>", $content);
		$plain = ($_POST['format'] == "plain" ? " checked" : "");
		$html = ($_POST['format'] == "html" ? " checked" : "");
		$sent = $_POST['sent'];

		$variables['html'] = nl2br("$content\n");
		$template_panels[] = array('type' => 'body', 'title' => $subject, 'name' => 'modules.newsletters.preview', 'template' => '_custom_html.tpl');
		$template_variables['modules.newsletters.preview'] = $variables;

		$subject = phpentities(stripslash($_POST['subject']));
		$content = phpentities(stripslash($_POST['content']));
	}
	if (isset($_POST['edit'])) {
		$result = dbquery("SELECT * FROM ".$db_prefix."newsletters WHERE newsletter_id='$newsletter_id'");
		if (dbrows($result) != 0) {
			$data = dbarray($result);
			$subject = phpentities(stripslashes($data['newsletter_subject']));
			$content = phpentities(stripslashes($data['newsletter_content']));
			$plain = ($data['newsletter_format'] == "plain" ? 1 : 0);
			$html = ($data['newsletter_format'] == "html" ? 1 : 0);
			$sent = $data['newsletter_sent'];
		} else {
			unset($newsletter_id);
		}
	}
	if (isset($newsletter_id)) {
		$title = $locale['nl411'];
	} else {
		$title = $locale['nl410'];
	}
	$variables['newsletter_id'] = isset($newsletter_id) ? $newsletter_id : 0;
	$variables['subject'] = isset($subject) ? $subject : "";
	$variables['content'] = isset($content) ? $content : "";
	$variables['plain'] = isset($plain) ? $plain : 1;
	$variables['html'] = isset($html) ? $html  : 0;
	$variables['sent'] = isset($sent) ? $sent : 0;

	define('LOAD_TINYMCE', true);

	$template_panels[] = array('type' => 'body', 'title' => $title, 'name' => 'modules.newsletters.editor', 'template' => 'modules.newsletters.editor.tpl', 'locale' => $locale_include);
	$template_variables['modules.newsletters.editor'] = $variables;
	
}

// Call the theme code to generate the output for this webpage
require_once PATH_THEME."/theme.php";
?>