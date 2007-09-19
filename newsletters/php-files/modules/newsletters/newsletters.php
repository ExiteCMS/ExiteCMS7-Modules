<?php
/*---------------------------------------------------+
| PLi-Fusion Content Management System               |
+----------------------------------------------------+
| Copyright 2007 WanWizard (wanwizard@gmail.com)     |
| http://www.pli-images.org/pli-fusion               |
+----------------------------------------------------+
| Some portions copyright ? 2002 - 2006 Nick Jones   |
| http://www.php-fusion.co.uk/                       |
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
				$mail->AddCustomHeader("X-version: PLi-Fusion Newsletters v".$locale['nlver']);
				
				switch ($data2['user_newsletters']) {
					case 1:
						$mail->IsHTML(true);
						$mail->Body = $html;
						$mail->AltBody = $text;
						break;
					case 2:
						$mail->IsHTML(false);
						$mail->Body = $text;
						$mail->AltBody = "";
						break;
					default:
				}
				$mail->Subject = $subject;

				if(!$mail->Send()) {
					$error[] = $data2['user_name']." (".$data2['user_email']."), format = ".$format."<br />";
				} else {
					$sc++;
				}
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
	$variables['html'] = str_replace("{:DATE:}", "<span style='font-family:monospace;color:red;font-size:12px'>".showdate('shortdate')."</span>", $content);
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
<?php
die();
/*---------------------------------------------------+
| PLi-Fusion 7 Content Management System Infusion
+----------------------------------------------------+
| Mail2Forum - CLI POP3 processor
| uses the POP3 and MIME classes from the PEAR library
+----------------------------------------------------+
| Copyright © 2006-2007 WanWizard
| http://www.pli-images.org/PLi-Fusion/
+----------------------------------------------------+
| Released under the terms & conditions of v2 of the
| GNU General Public License. For details refer to
| the included gpl.txt file or visit http://gnu.org
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
	if (strlen($webroot)>100) die('Unable to find the PLi-Fusion document root!'); 
}
require_once $webroot."includes/core_functions.php";

if (file_exists(PATH_MODULES."mail2forum/locale/".$settings['locale'].".php")) {
	include PATH_MODULES."mail2forum/locale/".$settings['locale'].".php";
} else {
	include PATH_MODULES."mail2forum/locale/English.php";
}

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

// check if the Mail2Forum Infusion is installed
$result = dbquery("SELECT * FROM ".$db_prefix."infusions WHERE inf_title = '".$locale['m2f100']."'");
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
					WHERE s.m2f_forumid = '".$postrecord['forum_id']."' AND s.m2f_subscribed = '1' AND u.user_id = s.m2f_userid AND u.user_id = c.m2f_userid");
				while ($recipient = dbarray($result2)) {
					if (M2F_SMTP_DEBUG) logdebug('RECIPIENT', print_r($recipient, true));
					
					// get the senders profile (need the email address and the email-hidden flag)
					if ($edit_post) {
						// check of automatic or system posts
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
								if (USE_PLI_ENHANCEMENTS) {
									$attachURL = $settings['siteurl']."forum/viewthread.php?forum_id=".$postrecord['forum_id']."&thread_id=".$postrecord['thread_id']."&getfile=".$attachment['attach_id']."&user_name=".$recipient['user_name']."&user_pass=";
									$attachURL = str_replace(" ", "%20", $attachURL);
								} else {
									$attachURL = $settings['siteurl']."forum/attachments/".$attachment['attach_name'];
								}
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
												// attach the attachments to the email
												$mail->AddAttachment(PATH_ATTACHMENTS.$attachment['attach_name']);
												break;
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
											// attach the attachments to the email
											$mail->AddAttachment(PATH_ATTACHMENTS.$attachment['attach_name']);
											break;
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