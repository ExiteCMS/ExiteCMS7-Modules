<?php
/*---------------------------------------------------------------------+
| ExiteCMS Content Management System                                   |
+----------------------------------------------------------------------+
| Copyright 2006-2008 Exite BV, The Netherlands                        |
| for support, please visit http://www.exitecms.org                    |
+----------------------------------------------------------------------+
| Some code derived from PHP-Fusion, copyright 2002 - 2006 Nick Jones  |
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
require_once dirname(__FILE__)."/../../includes/core_functions.php";
require_once PATH_ROOT."/includes/theme_functions.php";

// load the locale for this module
locale_load("modules.mail2forum");

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

// reset the poll timer?
if (isset($_POST['poll_restart'])) {
	$result = dbquery("UPDATE ".$db_prefix."configuration SET cfg_value = '".time()."' WHERE cfg_name = 'm2f_lastpoll'");
	$template_panels[] = array('type' => 'body', 'name' => 'message_panel', 'title' => $locale['m2f450'], 'template' => '_message_table_panel.tpl');
	$variables['message'] = $locale['m2f521'];
	$variables['bold'] = true;
	$template_variables['message_panel'] = $variables;
	// reset the variables, and return to the config screen
	$variables = array('step' => "config");
}

// save the M2F config
if (isset($_POST['saveconfig'])) {
	// validate the input
	$m2f_host = stripinput($_POST['m2f_host']);
	$m2f_interval = isNum($_POST['m2f_interval']) ? $_POST['m2f_interval'] : 300;
	$m2f_poll_threshold = isNum($_POST['m2f_poll_threshold']) ? $_POST['m2f_poll_threshold'] : 604800;
	$m2f_max_attachments = isNum($_POST['m2f_max_attachments']) ? $_POST['m2f_max_attachments'] : 1;
	$m2f_max_attach_size = isNum($_POST['m2f_max_attach_size']) ? $_POST['m2f_max_attach_size'] : 5242880;
	$m2f_use_forum_email = (isNum($_POST['m2f_use_forum_email']) && ($_POST['m2f_use_forum_email'] == "0" || $_POST['m2f_use_forum_email'] == "1")) ? $_POST['m2f_use_forum_email'] : "1";
	$m2f_follow_thread = (isNum($_POST['m2f_follow_thread']) && ($_POST['m2f_follow_thread'] == "0" || $_POST['m2f_follow_thread'] == "1")) ? $_POST['m2f_follow_thread'] : "0";
	$m2f_subscribe_required = (isNum($_POST['m2f_subscribe_required']) && ($_POST['m2f_subscribe_required'] == "0" || $_POST['m2f_subscribe_required'] == "1")) ? $_POST['m2f_subscribe_required'] : "0";
	$m2f_send_ndr = (isNum($_POST['m2f_send_ndr']) && ($_POST['m2f_send_ndr'] == "0" || $_POST['m2f_send_ndr'] == "1")) ? $_POST['m2f_send_ndr'] : "1";
	$m2f_pop3_server = stripinput($_POST['m2f_pop3_server']);
	$m2f_pop3_port = (isNum($_POST['m2f_pop3_port']) && $_POST['m2f_pop3_port'] > 0 && $_POST['m2f_pop3_port'] < 65536) ? $_POST['m2f_pop3_port'] : 110;
	$m2f_pop3_timeout = (isNum($_POST['m2f_pop3_timeout']) && $_POST['m2f_pop3_timeout'] > 1 && $_POST['m2f_pop3_timeout'] < 26) ? $_POST['m2f_pop3_timeout'] : 25;
	$m2f_logfile = stripinput($_POST['m2f_logfile']);
	$m2f_process_log = (isNum($_POST['m2f_process_log']) && ($_POST['m2f_process_log'] == "0" || $_POST['m2f_process_log'] == "1")) ? $_POST['m2f_process_log'] : "1";
	$m2f_smtp_log = (isNum($_POST['m2f_smtp_log']) && ($_POST['m2f_smtp_log'] == "0" || $_POST['m2f_smtp_log'] == "1")) ? $_POST['m2f_smtp_log'] : "0";
	$m2f_pop3_debug = (isNum($_POST['m2f_pop3_debug']) && ($_POST['m2f_pop3_debug'] == "0" || $_POST['m2f_pop3_debug'] == "1")) ? $_POST['m2f_pop3_debug'] : "0";
	$m2f_pop3_message_debug = (isNum($_POST['m2f_pop3_message_debug']) && ($_POST['m2f_pop3_message_debug'] == "0" || $_POST['m2f_pop3_message_debug'] == "1")) ? $_POST['m2f_pop3_message_debug'] : "0";
	$m2f_smtp_debug = (isNum($_POST['m2f_smtp_debug']) && ($_POST['m2f_smtp_debug'] == "0" || $_POST['m2f_smtp_debug'] == "1")) ? $_POST['m2f_smtp_debug'] : "0";
	// save
	$result = dbquery("UPDATE ".$db_prefix."configuration SET cfg_value = '".$m2f_host."' WHERE cfg_name = 'm2f_host'");
	$result = dbquery("UPDATE ".$db_prefix."configuration SET cfg_value = '".$m2f_interval."' WHERE cfg_name = 'm2f_interval'");
	$result = dbquery("UPDATE ".$db_prefix."configuration SET cfg_value = '".$m2f_poll_threshold."' WHERE cfg_name = 'm2f_poll_threshold'");
	$result = dbquery("UPDATE ".$db_prefix."configuration SET cfg_value = '".$m2f_max_attachments."' WHERE cfg_name = 'm2f_max_attachments'");
	$result = dbquery("UPDATE ".$db_prefix."configuration SET cfg_value = '".$m2f_max_attach_size."' WHERE cfg_name = 'm2f_max_attach_size'");
	$result = dbquery("UPDATE ".$db_prefix."configuration SET cfg_value = '".$m2f_use_forum_email."' WHERE cfg_name = 'm2f_use_forum_email'");
	$result = dbquery("UPDATE ".$db_prefix."configuration SET cfg_value = '".$m2f_follow_thread."' WHERE cfg_name = 'm2f_follow_thread'");
	$result = dbquery("UPDATE ".$db_prefix."configuration SET cfg_value = '".$m2f_subscribe_required."' WHERE cfg_name = 'm2f_subscribe_required'");
	$result = dbquery("UPDATE ".$db_prefix."configuration SET cfg_value = '".$m2f_send_ndr."' WHERE cfg_name = 'm2f_send_ndr'");
	$result = dbquery("UPDATE ".$db_prefix."configuration SET cfg_value = '".$m2f_pop3_server."' WHERE cfg_name = 'm2f_pop3_server'");
	$result = dbquery("UPDATE ".$db_prefix."configuration SET cfg_value = '".$m2f_pop3_port."' WHERE cfg_name = 'm2f_pop3_port'");
	$result = dbquery("UPDATE ".$db_prefix."configuration SET cfg_value = '".$m2f_pop3_timeout."' WHERE cfg_name = 'm2f_pop3_timeout'");
	$result = dbquery("UPDATE ".$db_prefix."configuration SET cfg_value = '".$m2f_logfile."' WHERE cfg_name = 'm2f_logfile'");
	$result = dbquery("UPDATE ".$db_prefix."configuration SET cfg_value = '".$m2f_process_log."' WHERE cfg_name = 'm2f_process_log'");
	$result = dbquery("UPDATE ".$db_prefix."configuration SET cfg_value = '".$m2f_smtp_log."' WHERE cfg_name = 'm2f_smtp_log'");
	$result = dbquery("UPDATE ".$db_prefix."configuration SET cfg_value = '".$m2f_pop3_debug."' WHERE cfg_name = 'm2f_pop3_debug'");
	$result = dbquery("UPDATE ".$db_prefix."configuration SET cfg_value = '".$m2f_pop3_message_debug."' WHERE cfg_name = 'm2f_pop3_message_debug'");
	$result = dbquery("UPDATE ".$db_prefix."configuration SET cfg_value = '".$m2f_smtp_debug."' WHERE cfg_name = 'm2f_smtp_debug'");
	// reload the page to update the site configuration
	redirect(FUSION_SELF.$aidlink);
}

// save M2F forum settings
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
			$m2f_email = stripinput(trim(preg_replace("~ +~i", "", $_POST['m2f_email'])));
			$m2f_userid = stripinput(trim(preg_replace("~ +~i", " ", $_POST['m2f_userid'])));
			$m2f_password = stripinput(trim(preg_replace("~ +~i", "", $_POST['m2f_password'])));
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
	$template_panels[] = array('type' => 'body', 'name' => 'modules.m2f_admin_panel.delete', 'template' => 'modules.mail2forum.admin_panel_delete.tpl', 'locale' => "modules.mail2forum");
	$template_variables['modules.m2f_admin_panel.delete'] = $variables;
	$variables = array();
} elseif (isset($_POST['config'])) {
	// what are we going to configure?
	$idx = key($_POST['config']);
	$m2f_forumid = $_POST['m2f_forumid'][$idx];
	$m2f_type = $_POST['m2f_type'][$idx];
	$result = dbquery("SELECT * FROM ".$db_prefix."forums WHERE forum_id = '".$m2f_forumid."'");
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
		$result = dbquery("SELECT * FROM ".$db_prefix."M2F_forums WHERE M2F_forumid = '".$m2f_forumid."'");
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
	$variables['forum_name'] = $data['forum_name'];
	$variables['forum_posting'] = $data['forum_posting'];
	$variables['m2f_type'] = $m2f_type;
	$variables['m2f_type_text'] = $mailtypes[$m2f_type];

	// define the panel
	$template_panels[] = array('type' => 'body', 'name' => 'modules.m2f_admin_panel.edit', 'template' => 'modules.mail2forum.admin_panel_edit.tpl', 'locale' => "modules.mail2forum");
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
	$template_panels[] = array('type' => 'body', 'name' => 'modules.m2f_admin_panel', 'template' => 'modules.mail2forum.admin_panel.tpl', 'locale' => "modules.mail2forum");
	$template_variables['modules.m2f_admin_panel'] = $variables;
}

// Call the theme code to generate the output for this webpage
require_once PATH_THEME."/theme.php";
?>
