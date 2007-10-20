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
if (!checkrights("wA") || !defined("iAUTH") || $aid != iAUTH) fallback(BASEDIR."index.php");

// make sure the parameter is valid
if (isset($forum_id) && !isNum($forum_id)) fallback(FUSION_SELF.$aidlink);

$mailtypes = array($locale['m2f230'], $locale['m2f231'], $locale['m2f232'], $locale['m2f233']);

$variables['step'] = isset($step) ? $step : "";

if (isset($step) && $step == "setstatus") {
	$result = dbquery("SELECT m2f_id FROM ".$db_prefix."M2F_forums WHERE m2f_forumid = '$forum_id'");
	if (dbrows($result) != 0)
		$result = dbquery("UPDATE ".$db_prefix."M2F_forums SET m2f_active='$status' WHERE m2f_forumid = '$forum_id'");
	else
		$error = $locale['m2f900']."<br>";
}

if (isset($step) && $step == "activate") {
	$result = dbquery("SELECT m2f_id FROM ".$db_prefix."M2F_forums WHERE m2f_forumid = '$forum_id'");
	if (dbrows($result) != 0)
		$result = dbquery("UPDATE ".$db_prefix."M2F_forums SET m2f_subscribe='1' WHERE m2f_forumid = '$forum_id'");
	else
		$error = $locale['m2f900']."<br>";
}

if (isset($step) && $step == "deactivate") {
	$result = dbquery("SELECT m2f_id FROM ".$db_prefix."M2F_forums WHERE m2f_forumid = '$forum_id'");
	if (dbrows($result) != 0) {
		$result = dbquery("UPDATE ".$db_prefix."M2F_forums SET m2f_subscribe='0' WHERE m2f_forumid = '".$forum_id."'");
		$result = dbquery("UPDATE ".$db_prefix."M2F_subscriptions SET m2f_subscribed = '0' WHERE m2f_userid != '1' AND m2f_forumid = '".$forum_id."'");
	} else
		$error = $locale['m2f900']."<br>";
}

if (isset($step) && $step == "subscribers") {
	$result = dbquery("SELECT * FROM ".$db_prefix."forums WHERE forum_id = '$forum_id'");
	if (dbrows($result) == 0)
		fallback(FUSION_SELF.$aidlink);
	$data = dbarray($result);
	$variables['forum_name'] = $data['forum_name'];
	$result = dbquery("SELECT u.* FROM ".$db_prefix."users u, ".$db_prefix."M2F_subscriptions s 
		WHERE u.user_id = s.m2f_userid AND s.m2f_forumid = '$forum_id' AND s.m2f_subscribed = '1' AND s.m2f_userid > 1 ORDER BY u.user_id");
	$variables['subscribers'] = array();
	while ($data = dbarray($result)) {
		$variables['subscribers'][] = $data;
	}
}

if (isset($_POST['savesettings'])) {
	$m2f_id = isset($_POST['m2f_id'])?$_POST['m2f_id']:0;
	$m2f_type = isset($_POST['m2f_type'])?$_POST['m2f_type']:0;
	$m2f_access = isset($_POST['m2f_access'])?$_POST['m2f_access']:103;
	$m2f_active = isset($_POST['m2f_active'])?$_POST['m2f_active']:0;
	$m2f_subscribe = isset($_POST['m2f_subscribe'])?$_POST['m2f_subscribe']:0;
	$m2f_posting = isset($_POST['m2f_posting'])?$_POST['m2f_posting']:103;
	switch ($mailtypes[$m2f_type]) {
		case $locale['m2f230']:
			// SMTP/POP3
			$m2f_email = stripinput(trim(eregi_replace(" +", "", $_POST['m2f_email'])));
			$m2f_userid = stripinput(trim(eregi_replace(" +", " ", $_POST['m2f_userid'])));
			$m2f_password = stripinput(trim(eregi_replace(" +", "", $_POST['m2f_password'])));
			if ($m2f_email == "")
				$error = $locale['m2f901'];
			if ($m2f_userid == "")
				$error .= (isset($error)?" - ":"").$locale['m2f902'];
			if ($m2f_password == "")
				$error .= (isset($error)?" - ":"").$locale['m2f903'];
			break;
		case $locale['m2f231']:
			// SMTP/IMAP
		case $locale['m2f232']:
			// GMail via HTTPS
		case $locale['m2f233']:
			// Majordomo listserver
			$error = "The '".$mailtypes[$m2f_type]."' method is not supported by this version of M2F!";
			break;
		default:
			$error = "Oops! Unknown M2F type detected. This should not be possible!";
	}
	if (!isset($error)) {
		// save the updates
		switch ($mailtypes[$m2f_type]) {
			case $locale['m2f230']:
				// SMTP/POP3
				if ($m2f_id) {
					$result = dbquery("UPDATE ".$db_prefix."M2F_forums SET m2f_type = '".$m2f_type."', m2f_access = '".$m2f_access."', m2f_email = '".$m2f_email."', m2f_userid = '".$m2f_userid.
						"', m2f_password = '".$m2f_password."', m2f_active = '".$m2f_active."', m2f_subscribe = '".$m2f_subscribe."', m2f_posting = '".$m2f_posting."' WHERE m2f_id = '".$m2f_id."'");
					$error = $locale['m2f904'];
				} else {
					$result = dbquery("INSERT INTO ".$db_prefix."M2F_forums (m2f_forumid, m2f_type, m2f_access, m2f_email, m2f_userid, m2f_password, m2f_active, m2f_subscribe, m2f_posting) VALUES ('".
						$forum_id."', '".$m2f_type."', '".$m2f_access."', '".$m2f_email."', '".$m2f_userid."', '".$m2f_password."', '".$m2f_active."', '".$m2f_subscribe."', '".$m2f_posting."')");
				}
				// if subscription is deactivated, deactivate all current subscriptions
				if (!$m2f_subscribe) {
					$result = dbquery("UPDATE ".$db_prefix."M2F_subscriptions SET m2f_subscribed = '0' WHERE m2f_userid != '1' AND m2f_forumid = '".$forum_id."'");
				}
				break;
			case $locale['m2f231']:
				// SMTP/IMAP
			case $locale['m2f232']:
				// GMail via HTTPS
			case $locale['m2f233']:
				// Majordomo listserver
			default:
		}
		if ($m2f_access != $_POST['forum_posting']) {
			$result = dbquery("SELECT u.user_id, u.user_groups, u.user_level FROM ".$db_prefix."users u, ".$db_prefix."M2F_subscriptions s WHERE s.m2f_userid = u.user_id AND s.m2f_forumid = '$forum_id'");
			if (dbrows($result) > 0) {
				while ($data = dbarray($result)) {
					// if a normal member, check group membership
					if ($data['user_level'] == '101') {
						if (!in_array($m2f_access, explode(".", $data['user_groups']))) {
							$delresult = dbquery("DELETE FROM ".$db_prefix."M2F_subscriptions WHERE m2f_forumid = '".$forum_id."' AND m2f_userid = '".$data['user_id']."'");
						}
					} else {
					// if an administrator, check if the admin level is high enough
						if ($m2f_access > $data['user_level']) {
							$delresult = dbquery("DELETE FROM ".$db_prefix."M2F_subscriptions WHERE m2f_forumid = '".$forum_id."' AND m2f_userid = '".$data['user_id']."'");
						}
					}
				}
			}
		}
	}
}

if (isset($_POST['deleteconfirm'])) {
	$result = dbquery("DELETE FROM ".$db_prefix."M2F_forums WHERE m2f_id = '".$_POST['m2f_id']."'");
	$result = dbquery("DELETE FROM ".$db_prefix."M2F_subscriptions WHERE m2f_forumid = '".$_POST['m2f_forumid']."'");
}

if (isset($_POST['delete'])) {
	$variables['forum_name'] = $data['forum_name'];
	$variables['m2f_id'] = $_POST['m2f_id'];
	$variables['m2f_forumid'] = $_POST['m2f_forumid'];
	// define the panel
	$template_panels[] = array('type' => 'body', 'name' => 'modules.m2f_admin_panel.delete', 'template' => 'modules.mail2forum.admin_panel_delete.tpl', 'locale' => $locale_file);
	$template_variables['modules.m2f_admin_panel.delete'] = $variables;
	$variables = array();
} elseif (isset($_POST['config'])) {
	$result = dbquery("SELECT * FROM ".$db_prefix."forums WHERE forum_id = '".$_POST['m2f_forumid']."'");
	if (dbrows($result) == 0)
		fallback(FUSION_SELF.$aidlink);
	$data = dbarray($result);
	if (isset($error)) {
		$m2f = array();
		$m2f['m2f_id'] = $m2f_id;
		$m2f['m2f_email'] = $m2f_email;
		$m2f['m2f_userid'] = $m2f_userid;
		$m2f['m2f_password'] = $m2f_password;
		$m2f['m2f_access'] = $m2f_access;
		$m2f['m2f_active'] = $m2f_active;
		$m2f['m2f_subscribe'] = $m2f_subscribe;
		$m2f['m2f_posting'] = $m2f_posting;
	} else {
		$result = dbquery("SELECT * FROM ".$db_prefix."M2F_forums WHERE M2F_forumid = '".$_POST['m2f_forumid']."'");
		if (dbrows($result) == 0) {
			$m2f = array();
			$m2f['m2f_id'] = 0;
			$m2f['m2f_email'] = "";
			$m2f['m2f_userid'] = "";
			$m2f['m2f_password'] = "";
			$m2f['m2f_active'] = 0;
			$m2f['m2f_subscribe'] = 1;
			$m2f['m2f_posting'] = $data['forum_posting'];
			$m2f['m2f_access'] = $data['forum_posting'];
		} else {
			$m2f = dbarray($result);
		}
	}
	$user_groups = getusergroups(); 
	$access_opts = array(); 
	$posting_opts = array();
	foreach ($user_groups as $key => $value) {
		$access_opts[] = array('id' => $value['0'], 'name' => $value['1'], 'selected' => ($m2f['m2f_access'] == $value['0']));
		$posting_opts[] = array('id' => $value['0'], 'name' => $value['1'], 'selected' => ($m2f['m2f_posting'] == $value['0']));
	}
	$variables['m2f'] = $m2f;
	$variables['access_opts'] = $access_opts;
	$variables['posting_opts'] = $posting_opts;
	$variables['error'] = isset($error) ? $error : "";
	$variables['forum_id'] = $data['forum_id'];
	$variables['forum_posting'] = $data['forum_posting'];
	$variables['m2f_type'] = $_POST['m2f_type'];
	$variables['m2f_type_text'] = $mailtypes[$_POST['m2f_type']];

	// define the panel
	$template_panels[] = array('type' => 'body', 'name' => 'modules.m2f_admin_panel.edit', 'template' => 'modules.mail2forum.admin_panel_edit.tpl', 'locale' => $locale_file);
	$template_variables['modules.m2f_admin_panel.edit'] = $variables;
	$variables = array();

} else {
	$variables['error'] = isset($error) ? $error : "";
	$result = dbquery("SELECT * FROM ".$db_prefix."forums WHERE forum_cat != '0' ORDER BY forum_name");
	$variables['forums'] = array();
	while ($data = dbarray($result)) {
		$m2fres = dbquery("SELECT * FROM ".$db_prefix."M2F_forums WHERE m2f_forumid = '".$data['forum_id']."'");
		if (dbrows($m2fres) != 0) {
			$m2frec = dbarray($m2fres);
			$data['m2f_config'] = true;
			$data['m2f_type'] = $m2frec['m2f_type'];
			$data['m2f_id'] = $m2frec['m2f_id'];
			$data['m2f_subscribers'] = dbcount("(m2f_userid)", "M2F_subscriptions", "m2f_forumid = '".$data['forum_id']."' AND m2f_subscribed = '1' AND m2f_userid > 1");
			$data['m2f_subscribe'] = $m2frec['m2f_subscribe'];
			$data['m2f_sent'] = $m2frec['m2f_sent'];
			$data['m2f_received'] = $m2frec['m2f_received'];
			$data['m2f_active'] = $m2frec['m2f_active'];
		} else {
			$data['m2f_config'] = false;
			$data['m2f_type'] = 0;
			$data['m2f_id'] = 0;
			$data['m2f_subscribers'] = 0;
			$data['m2f_subscribe'] = 0;
			$data['m2f_sent'] = 0;
			$data['m2f_received'] = 0;
			$data['m2f_active'] = 0;
		}
		$data['forum_posting_name'] = getgroupname($data['forum_posting'], -1);
		$variables['forums'][] = $data;
	}
	$variables['mailtypes'] = $mailtypes;

	// define the admin body panel
	$template_panels[] = array('type' => 'body', 'name' => 'modules.m2f_admin_panel', 'template' => 'modules.mail2forum.admin_panel.tpl', 'locale' => $locale_file);
	$template_variables['modules.m2f_admin_panel'] = $variables;
}

// Call the theme code to generate the output for this webpage
require_once PATH_THEME."/theme.php";
?>
