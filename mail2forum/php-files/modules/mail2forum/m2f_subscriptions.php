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
if (file_exists(PATH_MODULES."mail2forum/locale/".$settings['locale'].".php")) {
        $locale_file = PATH_MODULES."mail2forum/locale/".$settings['locale'].".php";
} else {
        $locale_file = PATH_MODULES."mail2forum/locale/English.php";
}
include $locale_file;

// temp storage for template variables
$variables = array();

// check for the proper admin access rights
if (!iMEMBER) fallback(BASEDIR."index.php");

// get the users M2F configuration. If not found, make up some defaults
$result = dbquery("SELECT * FROM ".$db_prefix."M2F_config WHERE m2f_userid = '".$userdata['user_id']."'");
if (dbrows($result) != 0) {
	$data = dbarray($result);
} else {
	$data = array();
	$data['m2f_userid'] = 0;
	$data['m2f_html'] = 0;
	$data['m2f_attach'] = 0;
	$data['m2f_inline'] = 0;
	$data['m2f_thumbnail'] = 0;
}
$variables['config'] = $data;

// save the updates to the config
if (isset($_POST['saveconfig'])) {
	if (isset($_POST['m2f_html'])) $data['m2f_html'] = $_POST['m2f_html'];
	if (isset($_POST['m2f_attach'])) $data['m2f_attach'] = $_POST['m2f_attach'];
	if (isset($_POST['m2f_inline'])) $data['m2f_inline'] = $_POST['m2f_inline'];
	if (isset($_POST['m2f_thumbnail'])) $data['m2f_thumbnail'] = $_POST['m2f_thumbnail'];
	if ($data['m2f_userid']) {
		// update the config record
		$result = dbquery("UPDATE ".$db_prefix."M2F_config SET m2f_html = '".$data['m2f_html']."', m2f_attach = '".$data['m2f_attach']."', 
			m2f_inline = '".$data['m2f_inline']."', m2f_thumbnail = '".$data['m2f_thumbnail']."' WHERE m2f_userid ='".$userdata['user_id']."'");
	} else {
		// insert a new record
		$result = dbquery("INSERT INTO ".$db_prefix."M2F_config (m2f_userid, m2f_html, m2f_attach, m2f_inline, m2f_thumbnail) VALUES (
			'".$userdata['user_id']."', '".$data['m2f_html']."', '".$data['m2f_attach']."', '".$data['m2f_inline']."', '".$data['m2f_thumbnail']."')");
	}
	$variables['config_message'] = $locale['m2f904'];
}

$variables['ar_html'] = array($locale['m2f452'], $locale['m2f453']);
$variables['ar_attach'] = array($locale['m2f455'], $locale['m2f456'], $locale['m2f457']);
$variables['ar_inline'] = array($locale['m2f460'], $locale['m2f461']);
$variables['ar_thumbnail'] = array($locale['m2f463'], $locale['m2f464']);

if (isset($_POST['save'])) {
	// check if there is a config record for this user. If not, create one with defaults
	$result = dbquery("SELECT * FROM ".$db_prefix."M2F_config WHERE m2f_userid = '".$userdata['user_id']."'");
	if (dbrows($result) == 0) {
		// insert a new record with default values
		$result = dbquery("INSERT INTO ".$db_prefix."M2F_config (m2f_userid, m2f_html, m2f_attach, m2f_inline, m2f_thumbnail) VALUES ('".$userdata['user_id']."', '0', '0', '0', '0')");
	}
	foreach($_POST['m2f_subid'] as $key => $subid) {
		if ($_POST['update'][$key]) {
			$result = dbquery("UPDATE ".$db_prefix."M2F_subscriptions SET m2f_subscribed = '".$_POST['m2f_subscribed'][$key]."' WHERE m2f_subid = '".$subid."'");
		} else {
			$result = dbquery("INSERT INTO ".$db_prefix."M2F_subscriptions (m2f_forumid, m2f_userid, m2f_subscribed) VALUES ('".$_POST['m2f_forumid'][$key]."', '".$userdata['user_id']."', '".$_POST['m2f_subscribed'][$key]."')");
		}
	}
	$variables['save_message'] = $locale['m2f951'];
}

$variables['subscriptions'] = array();
$result = dbquery("SELECT * FROM ".$db_prefix."M2F_forums mf, ".$db_prefix."forums f WHERE mf.m2f_subscribe = 1 AND mf.m2f_active = 1 AND mf.m2f_forumid = f.forum_id AND ".groupaccess('mf.m2f_access')." ORDER BY f.forum_name");
while ($data = dbarray($result)) {
		$result2 = dbquery("SELECT * FROM ".$db_prefix."M2F_subscriptions WHERE m2f_forumid = '".$data['m2f_forumid']."' AND m2f_userid = '".$userdata['user_id']."'");
		if ($data2 = dbarray($result2)) {
			$data['subscribed'] = $data2['m2f_subscribed'];
			$data['m2f_subid'] = $data2['m2f_subid'];
			$data['m2f_forumid'] = $data2['m2f_forumid'];
			$data['update'] = "1";
		} else {
			$data['subscribed'] = 0;
			$data['m2f_subid'] = 0;
			$data['m2f_forumid'] = 0;
			$data['update'] = "0";
		}
	$variables['subscriptions'][] = $data;

}

// define the admin body panel
$template_panels[] = array('type' => 'body', 'name' => 'modules.m2f_subscriptions', 'template' => 'modules.mail2forum.subscriptions.tpl', 'locale' => $locale_file);
$template_variables['modules.m2f_subscriptions'] = $variables;

// Call the theme code to generate the output for this webpage
require_once PATH_THEME."/theme.php";
?>