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
locale_load("modules.file_downloads");

// temp storage for template variables
$variables = array();

// check for the proper admin access rights
if (!checkrights("wF") || !defined("iAUTH") || $aid != iAUTH) fallback(BASEDIR."index.php");

// make sure the parameter is valid
if (isset($fd_id) && !isNum($fd_id)) fallback(FUSION_SELF.$aidlink);
if (!isset($fd_id)) $fd_id = 0;
if (!isset($action)) $action = "";

switch ($action) {

	case "add":
	case "edit":
		if (isset($_POST['save'])) {
			// get and sanitize the variables
			$variables['fd_id'] = IsNum($_POST['fd_id']) ? $_POST['fd_id'] : 0;
			$variables['fd_name'] = stripinput($_POST['fd_name']);;
			$variables['fd_path'] = stripinput($_POST['fd_path']);;
			$variables['fd_sort_field'] = stripinput($_POST['fd_sort_field']);;
			$variables['fd_sort_order'] = stripinput($_POST['fd_sort_order']);;
			$variables['fd_group'] = isNum($_POST['fd_group']) ? $_POST['fd_group'] : 103;
			$variables['fd_order'] = dbfunction("MAX(fd_order)","file_downloads","")+1;
			// validate the input
			if (empty($variables['fd_name'])) {
				$variables['message'] = $locale['414'];
			} elseif (empty($variables['fd_path'])) {
				$variables['message'] = $locale['415'];
			} elseif (!is_dir($variables['fd_path'])) {
				$variables['message'] = $locale['416'];
			} else {
				if (!in_array($variables['fd_sort_field'], array("NAME", "DATE"))) $variables['fd_sort_field'] = "NAME";
				if (!in_array($variables['fd_sort_order'], array("ASC", "DESC"))) $variables['fd_sort_field'] = "ASC";
				if ($action == "add") {
					// add the file download directory
					$result = dbquery("INSERT INTO ".$db_prefix."file_downloads (fd_name, fd_path, fd_sort_field, fd_sort_order, fd_group, fd_order) VALUES ('".$variables['fd_name']."', '".$variables['fd_path']."', '".$variables['fd_sort_field']."', '".$variables['fd_sort_order']."', '".$variables['fd_group']."', '".$variables['fd_order']."')");
					$variables['message'] = $locale['417'];
				} elseif ($action == "edit") {
					// update the file download directory
					$result = dbquery("UPDATE ".$db_prefix."file_downloads SET fd_name = '".$variables['fd_name']."', fd_path = '".$variables['fd_path']."', fd_sort_field = '".$variables['fd_sort_field']."', fd_sort_order = '".$variables['fd_sort_order']."', fd_group = '".$variables['fd_group']."' WHERE fd_id = '".$variables['fd_id']."'");
					$variables['message'] = $locale['418'];
				} else {
					terminate('invalid action value detected!');
				}
				// return to the main panel with a success message
				$action = "";
			}
		} else {
			if ($action == "add") {
				$variables['fd_id'] = 0;
				$variables['fd_name'] = "";
				$variables['fd_path'] = "";
				$variables['fd_sort_field'] = "NAME";
				$variables['fd_sort_order'] = "ASC";
				$variables['fd_group'] = 103;
				$variables['fd_order'] = 0;
				$variables['formaction'] = FUSION_SELF.$aidlink."&amp;action=add";
			} elseif ($action == "edit") {
				$result = dbquery("SELECT * FROM ".$db_prefix."file_downloads WHERE fd_id = '".$fd_id."'");
				if ($data = dbarray($result)) {
					$variables['fd_id'] = $data['fd_id'];
					$variables['fd_name'] = $data['fd_name'];
					$variables['fd_path'] = $data['fd_path'];
					$variables['fd_sort_field'] = $data['fd_sort_field'];
					$variables['fd_sort_order'] = $data['fd_sort_order'];
					$variables['fd_group'] = $data['fd_group'];
					$variables['fd_order'] = $data['fd_order'];
				} else {
					// not found?
					$variables['message'] = $locale['419'];
					$action = "";
				}
				$variables['formaction'] = FUSION_SELF.$aidlink."&amp;action=edit&amp;fd_id=".$variables['fd_id'];
			} else {
				terminate('invalid action value detected!');
			}
		}
		break;

	case "up":
		if ($fd_id) {
			// get the selected id
			$result1 = dbquery("SELECT * FROM ".$db_prefix."file_downloads WHERE fd_id = '".$fd_id."'");
			if ($data1 = dbarray($result1)) {
				// get the next order id
				$result2 = dbquery("SELECT * FROM ".$db_prefix."file_downloads WHERE fd_order < '".$data1['fd_order']."' ORDER BY fd_order DESC LIMIT 1");
				if ($data2 = dbarray($result2)) {
					// swap the two orders
					$result = dbquery("UPDATE ".$db_prefix."file_downloads SET fd_order = '".$data2['fd_order']."' WHERE fd_id = '".$data1['fd_id']."'");
					$result = dbquery("UPDATE ".$db_prefix."file_downloads SET fd_order = '".$data1['fd_order']."' WHERE fd_id = '".$data2['fd_id']."'");
				}
			}
		}
		// reset the action switch to return to the default action
		$action = "";
		break;

	case "down":
		if ($fd_id) {
			// get the selected id
			$result1 = dbquery("SELECT * FROM ".$db_prefix."file_downloads WHERE fd_id = '".$fd_id."'");
			if ($data1 = dbarray($result1)) {
				// get the next order id
				$result2 = dbquery("SELECT * FROM ".$db_prefix."file_downloads WHERE fd_order > '".$data1['fd_order']."' ORDER BY fd_order ASC LIMIT 1");
				if ($data2 = dbarray($result2)) {
					// swap the two orders
					$result = dbquery("UPDATE ".$db_prefix."file_downloads SET fd_order = '".$data2['fd_order']."' WHERE fd_id = '".$data1['fd_id']."'");
					$result = dbquery("UPDATE ".$db_prefix."file_downloads SET fd_order = '".$data1['fd_order']."' WHERE fd_id = '".$data2['fd_id']."'");
				}
			}
		}
		// reset the action switch to return to the default action
		$action = "";
		break;

	case "delete":
		$result = dbquery("DELETE FROM ".$db_prefix."file_downloads WHERE fd_id = '".$fd_id."'");
		// reset the action switch to return to the default action
		$action = "";
		break;

	default:
		break;
}

// get the list of user groups
$variables['usergroups'] = getusergroups(false);

// default action: config panel and statistics overview list
if ($action == "") {

	// load the statistics entries
	$variables['entries'] = array();
	$result = dbquery("SELECT * FROM ".$db_prefix."file_downloads ORDER BY fd_order");
	while ($data = dbarray($result)) {
		$data['group_name'] = getgroupname($data['fd_group'], -1);
		$variables['entries'][] = $data;
	}
}

// store the variables we need in the panels
$variables['action'] = $action;

// display a status panel first if need be
if (isset($status) || isset($variables['message'])) {
	if (!isset($variables['message'])) {
		$variables['message'] = "UNKNOWN STATUS PASSED!";
	}
	// define the message panel variables
	$variables['bold'] = true;
	$template_panels[] = array('type' => 'body', 'name' => 'modules.file_downloads.status', 'title' => $locale['400'], 'template' => '_message_table_panel.tpl');
	$template_variables['modules.file_downloads.status'] = $variables;
	$variables = array();
}

// define the admin body panel
$template_panels[] = array('type' => 'body', 'name' => 'modules.file_downloads.admin', 'template' => 'modules.file_downloads.admin.tpl', 'locale' => "modules.file_downloads");
$template_variables['modules.file_downloads.admin'] = $variables;

// Call the theme code to generate the output for this webpage
require_once PATH_THEME."/theme.php";
?>
