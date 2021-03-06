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

// load message parsing functions
require_once PATH_INCLUDES."forum_functions_include.php";

// load the locale for this module
locale_load("modules.shoutbox_panel");

// temp storage for template variables
$variables = array();

// check for the proper admin access rights
if (!checkrights("S") || !defined("iAUTH") || $aid != iAUTH) fallback(BASEDIR."index.php");

// make sure the parameter is valid
if (isset($shout_id) && !isNum($shout_id)) fallback(FUSION_SELF.$aidlink);
if (!isset($action)) $action = "";

if (isset($status)) {
	if ($status == "delall") {
		$title = $locale['400'];
		$variables['message'] = $numr." ".$locale['401'];
	} elseif ($status == "del") {
		$title = $locale['404'];
		$variables['message'] = $locale['405'];
	}
	// define the message panel variables
	$variables['bold'] = true;
	$template_panels[] = array('type' => 'body', 'name' => 'admin.shoutbox.status', 'title' => $title, 'template' => '_message_table_panel.tpl');
	$template_variables['admin.shoutbox.status'] = $variables;
	$variables = array();
}

if ($action == "deleteshouts") {
	$deletetime = time() - ($_POST['num_days'] * 86400);
	$result = dbquery("SELECT * FROM ".$db_prefix."shoutbox WHERE shout_datestamp < '$deletetime'");
	$numrows = dbrows($result);
	$result = dbquery("DELETE FROM ".$db_prefix."shoutbox WHERE shout_datestamp < '$deletetime'");
	redirect(FUSION_SELF.$aidlink."&status=delall&numr=$numrows");
} else if ($action == "delete") {
	$result = dbquery("DELETE FROM ".$db_prefix."shoutbox WHERE shout_id='$shout_id'");
	redirect(FUSION_SELF.$aidlink."&status=del");
} else {
	if (isset($_POST['saveshout'])) {
		if ($action == "edit") {
			$shout_message = str_replace("\n", " ", $_POST['shout_message']);
			$shout_message = preg_replace("/^(.{255}).*$/", "$1", $shout_message);
			$shout_message = preg_replace("/([^\s]{25})/", "$1\n", $shout_message);
			$shout_message = stripinput($shout_message);
			$shout_message = str_replace("\n", "<br>", $shout_message);
			$result = dbquery("UPDATE ".$db_prefix."shoutbox SET shout_message='$shout_message' WHERE shout_id='$shout_id'");
			redirect(FUSION_SELF.$aidlink);
		}
	}
	$variables['action'] = $action;
	if ($action == "edit") {
		$result = dbquery("SELECT * FROM ".$db_prefix."shoutbox WHERE shout_id='$shout_id'");
		$data = dbarray($result);
		$data['shout_message'] = str_replace("<br>", "", $data['shout_message']);
		$variables['editdata'] = $data;
	}

	$result = dbquery("SELECT * FROM ".$db_prefix."shoutbox");
	$rows = dbrows($result);
	$variables['rows'] = $rows;
	if (!isset($rowstart) || !isNum($rowstart)) $rowstart = 0;
	$variables['rowstart'] = $rowstart;
	$variables['pagenavurl'] = FUSION_SELF.$aidlink."&amp;";
	
	$result = dbquery(
		"SELECT * FROM ".$db_prefix."shoutbox LEFT JOIN ".$db_prefix."users
		ON ".$db_prefix."shoutbox.shout_name=".$db_prefix."users.user_id
		ORDER BY shout_datestamp DESC LIMIT $rowstart,".$settings['numofthreads']);

	$variables['shouts'] = array();
	while ($data = dbarray($result)) {
		$data['shout_message'] = parsemessage(array(), $data['shout_message'], true, true);
		$variables['shouts'][] = $data;
	}
}

// load the hoteditor if needed
if ($settings['hoteditor_enabled'] && (!iMEMBER || $userdata['user_hoteditor'])) {
	define('LOAD_HOTEDITOR', true);
}

// define the admin body panel
$template_panels[] = array('type' => 'body', 'name' => 'admin.shoutbox', 'template' => 'modules.shoutbox_panel.admin.tpl', 'locale' => "modules.shoutbox_panel");
$template_variables['admin.shoutbox'] = $variables;

// Call the theme code to generate the output for this webpage
require_once PATH_THEME."/theme.php";
?>
