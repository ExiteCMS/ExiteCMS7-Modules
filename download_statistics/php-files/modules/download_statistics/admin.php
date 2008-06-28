<?php
/*---------------------------------------------------+
| ExiteCMS Content Management System                 |
+----------------------------------------------------+
| Copyright 2007 Harro "WanWizard" Verton, Exite BV  |
| for support, please visit http://exitecms.exite.eu |
+----------------------------------------------------+
| Some portions copyright 2002 - 2006 Nick Jones     |
| http://www.php-fusion.co.uk/                       |
+----------------------------------------------------+
| Released under the terms & conditions of v2 of the |
| GNU General Public License. For details refer to   |
| the included gpl.txt file or visit http://gnu.org  |
+----------------------------------------------------*/
require_once dirname(__FILE__)."/../../includes/core_functions.php";
require_once PATH_ROOT."/includes/theme_functions.php";

// load the locale for this module
locale_load("modules.download_statistics");

// temp storage for template variables
$variables = array();

// check for the proper admin access rights
if (!checkrights("wS") || !defined("iAUTH") || $aid != iAUTH) fallback(BASEDIR."index.php");

// make sure the parameter is valid
if (isset($dlsc_id) && !isNum($dlsc_id)) fallback(FUSION_SELF.$aidlink);
if (!isset($dlsc_id)) $dlsc_id = 0;
if (!isset($action)) $action = "";

switch ($action) {

	case "add":
		if (isset($_POST['save'])) {
			// get and sanitize the variables
			$variables['dlsc_id'] = 0;
			$variables['dlsc_name'] = stripinput($_POST['dlsc_name']);;
			$variables['dlsc_description'] = stripinput($_POST['dlsc_description']);;
			$variables['dlsc_download_id'] = isNum($_POST['dlsc_download_id']) ? $_POST['dlsc_download_id'] : 0;
			$variables['dlsc_files'] = stripinput($_POST['dlsc_files']);
			$variables['dlsc_order'] = dbfunction("MAX(dlsc_order)","dlstats_counters","")+1;
			// validate the input
			if (empty($variables['dlsc_name'])) {
				$variables['message'] = $locale['dls926'];
			} elseif (empty($variables['dlsc_description'])) {
				$variables['message'] = $locale['dls927'];
			} elseif (empty($variables['dlsc_files']) && $variables['dlsc_download_id'] == 0) {
				$variables['message'] = $locale['dls928'];
			} else { 
				// add the new counter
				$result = dbquery("INSERT INTO ".$db_prefix."dlstats_counters (dlsc_name, dlsc_description, dlsc_download_id, dlsc_files, dlsc_order) VALUES ('".$variables['dlsc_name']."', '".$variables['dlsc_description']."', '".$variables['dlsc_download_id']."', '".$variables['dlsc_files']."', '".$variables['dlsc_order']."')");
				// return to the main panel with a success message
				$variables['message'] = $locale['dls924'];
				$action = "";
			}
		} else {
			$variables['dlsc_id'] = 0;
			$variables['dlsc_name'] = "";
			$variables['dlsc_description'] = "";
			$variables['dlsc_download_id'] = 0;
			$variables['dlsc_files'] = "";
			$variables['dlsc_order'] = 0;
		}
		$variables['formaction'] = FUSION_SELF.$aidlink."&amp;action=add";
		break;

	case "edit":
		if (isset($_POST['save'])) {
			// get and check the input
			$variables['dlsc_id'] = IsNum($_POST['dlsc_id']) ? $_POST['dlsc_id'] : 0;
			$variables['dlsc_name'] = stripinput($_POST['dlsc_name']);;
			$variables['dlsc_description'] = stripinput($_POST['dlsc_description']);;
			$variables['dlsc_download_id'] = IsNum($_POST['dlsc_download_id']) ? $_POST['dlsc_download_id'] : 0;
			$variables['dlsc_files'] = stripinput($_POST['dlsc_files']);
			$variables['dlsc_order'] = IsNum($_POST['dlsc_order']) ? $_POST['dlsc_order'] : 0;
			if (empty($variables['dlsc_name'])) {
				$variables['message'] = $locale['dls926'];
			} elseif (empty($variables['dlsc_description'])) {
				$variables['message'] = $locale['dls927'];
			} elseif (empty($variables['dlsc_files']) && $variables['dlsc_download_id'] == 0) {
				$variables['message'] = $locale['dls928'];
			} else { 
				// update the counter
				$result = dbquery("UPDATE ".$db_prefix."dlstats_counters SET dlsc_name = '".$variables['dlsc_name']."', dlsc_description = '".$variables['dlsc_description']."', dlsc_download_id = '".$variables['dlsc_download_id']."', dlsc_files = '".$variables['dlsc_files']."' WHERE dlsc_id = '".$variables['dlsc_id']."'");
				// return to the main panel with a success message
				$variables['message'] = $locale['dls925'];
				$action = "";
			}
		} else {
			$result = dbquery("SELECT * FROM ".$db_prefix."dlstats_counters WHERE dlsc_id = '".$dlsc_id."'");
			if ($data = dbarray($result)) {
				$variables['dlsc_id'] = $data['dlsc_id'];
				$variables['dlsc_name'] = $data['dlsc_name'];
				$variables['dlsc_description'] = $data['dlsc_description'];
				$variables['dlsc_download_id'] = $data['dlsc_download_id'];
				$variables['dlsc_files'] = $data['dlsc_files'];
				$variables['dlsc_order'] = $data['dlsc_order'];
			} else {
				// not found?
				$variables['message'] = $locale['dls924'];
				$action = "";
			}
			$variables['formaction'] = FUSION_SELF.$aidlink."&amp;action=edit&amp;dlsc_id=".$variables['dlsc_id'];
		}
		break;

	case "config":
		// config save request?
		if (isset($_POST['savesettings'])) {
			$variables['message'] = "";
			// validate the settings
			$access = stripinput($_POST['dlstats_access']);
			if (!isNum($access)) {
				$variables['message'] .= ($variables['message']==""?"":"<br />").$locale['dls910'];
			}
			$regex = stripinput($_POST['dlstats_geomap_regex']);
			if (!empty($regex)) {
				// validate the regex
				$ts = ini_set("track_errors", "1");
				$test = @preg_replace($regex, "x", "x");
				if (is_null($test)) {
					$variables['message'] .= ($variables['message']==""?"":"<br />").$locale['dls911']." '".$php_errormsg;
				}
				$ts = ini_set("track_errors", $ts);
			}
			$logpath = stripinput($_POST['dlstats_logs']);
			if ($logpath{0} != "/") $logpath = PATH_ROOT.$logpath;
			if (!is_dir($logpath)) {
				$variables['message'] .= ($variables['message']==""?"":"<br />").$locale['dls912'];
			} else {
				if (!is_writeable($logpath."/.")) {
					$variables['message'] .= ($variables['message']==""?"":"<br />").$locale['dls913'];
				} else {
					// store it as entered
					$logpath = stripinput($_POST['dlstats_logs']);
				}
			}
			$remote = IsNum($_POST['dlstats_remote']) ? $_POST['dlstats_remote'] : 0;
			$google_key = stripinput($_POST['dlstats_google_api_key']);
			// if no errors were detected...
			if ($variables['message'] == "") {
				// save the new settings
				$result = dbquery("UPDATE ".$db_prefix."configuration SET cfg_value = '".$access."' WHERE cfg_name = 'dlstats_access'");
				$result = dbquery("UPDATE ".$db_prefix."configuration SET cfg_value = '".$regex."' WHERE cfg_name = 'dlstats_geomap_regex'");
				$result = dbquery("UPDATE ".$db_prefix."configuration SET cfg_value = '".$logpath."' WHERE cfg_name = 'dlstats_logs'");
				$result = dbquery("UPDATE ".$db_prefix."configuration SET cfg_value = '".$remote."' WHERE cfg_name = 'dlstats_remote'");
				$result = dbquery("UPDATE ".$db_prefix."configuration SET cfg_value = '".$google_key."' WHERE cfg_name = 'dlstats_google_api_key'");
				redirect(FUSION_SELF.$aidlink."&status=cs");
				exit;
			} else {
				// define the message panel variables
				$variables['bold'] = true;
				$template_panels[] = array('type' => 'body', 'name' => 'modules.download_statistics.status', 'title' => $locale['dls923'], 'template' => '_message_table_panel.tpl');
				$template_variables['modules.download_statistics.status'] = $variables;
				$variables = array();
			}
			$settings2['dlstats_access'] = $access;
			$settings2['dlstats_geomap_regex'] = $regex;
			$settings2['dlstats_logs'] = $logpath;
			$settings2['dlstats_remote'] = $remote;
			$settings2['dlstats_google_api_key'] = $google_key;
		}
		// reset the action switch to return to the default action
		$action = "";
		break;

	case "up":
		if ($dlsc_id) {
			// get the selected id
			$result1 = dbquery("SELECT * FROM ".$db_prefix."dlstats_counters WHERE dlsc_id = '".$dlsc_id."'");
			if ($data1 = dbarray($result1)) {
				// get the next order id
				$result2 = dbquery("SELECT * FROM ".$db_prefix."dlstats_counters WHERE dlsc_order < '".$data1['dlsc_order']."' ORDER BY dlsc_order DESC LIMIT 1");
				if ($data2 = dbarray($result2)) {
					// swap the two orders
					$result = dbquery("UPDATE ".$db_prefix."dlstats_counters SET dlsc_order = '".$data2['dlsc_order']."' WHERE dlsc_id = '".$data1['dlsc_id']."'");			
					$result = dbquery("UPDATE ".$db_prefix."dlstats_counters SET dlsc_order = '".$data1['dlsc_order']."' WHERE dlsc_id = '".$data2['dlsc_id']."'");
				}
			}
		}
		// reset the action switch to return to the default action
		$action = "";
		break;

	case "down":
		if ($dlsc_id) {
			// get the selected id
			$result1 = dbquery("SELECT * FROM ".$db_prefix."dlstats_counters WHERE dlsc_id = '".$dlsc_id."'");
			if ($data1 = dbarray($result1)) {
				// get the next order id
				$result2 = dbquery("SELECT * FROM ".$db_prefix."dlstats_counters WHERE dlsc_order > '".$data1['dlsc_order']."' ORDER BY dlsc_order ASC LIMIT 1");
				if ($data2 = dbarray($result2)) {
					// swap the two orders
					$result = dbquery("UPDATE ".$db_prefix."dlstats_counters SET dlsc_order = '".$data2['dlsc_order']."' WHERE dlsc_id = '".$data1['dlsc_id']."'");			
					$result = dbquery("UPDATE ".$db_prefix."dlstats_counters SET dlsc_order = '".$data1['dlsc_order']."' WHERE dlsc_id = '".$data2['dlsc_id']."'");
				}
			}
		}
		// reset the action switch to return to the default action
		$action = "";
		break;

	case "delete":
		$result = dbquery("DELETE FROM ".$db_prefix."dlstats_counters WHERE dlsc_id = '".$dlsc_id."'");
		// reset the action switch to return to the default action
		$action = "";
		break;

	default:
		break;
}

// default action: config panel and statistics overview list
if ($action == "") {

	// retrieve the current settings values for the config screen
	$settings2 = array();
	$result = dbquery("SELECT * FROM ".$db_prefix."configuration");
	while ($data = dbarray($result)) {
		$settings2[$data['cfg_name']] = $data['cfg_value'];
	}
	
	// store the settings for the panel
	$variables['settings2'] = $settings2;

	// get the list of user groups
	$variables['usergroups'] = getusergroups(true);

	// load the statistics entries
	$variables['entries'] = array();
	$result = dbquery("SELECT * FROM ".$db_prefix."dlstats_counters ORDER BY dlsc_order");
	while ($data = dbarray($result)) {
		$variables['entries'][] = $data;
	}	
}

// preparations for the add/edit panel
if ($action == "add" || $action == "edit") {

	// get an ordered list of all download items available
	$variables['downloads'] = array();
	$result = dbquery("SELECT * FROM ".$db_prefix."downloads d, ".$db_prefix."download_cats c WHERE d.download_cat = c.download_cat_id ORDER BY download_id DESC");
	while($data = dbarray($result)) {
		$variables['downloads'][] = $data;
	}

	// create the list of available download files
	$variables['files'] = array(); 
	$result = dbquery("SELECT dlsf_file FROM ".$db_prefix."dlstats_files WHERE dlsf_success = 1 ORDER BY dlsf_file");
	if (dbrows($result) != 0) {
		while ($data = dbarray($result)) {
			$variables['files'][] = $file['path'];
		}
	}
}

// store the variables we need in the panels
$variables['action'] = $action;

// display a status panel first if need be 
if (isset($status) || isset($variables['message'])) {
	if (!isset($variables['message'])) {
		if ($status == "del") {
			$variables['message'] = $locale['dls920'];
		} elseif ($status == "cs") {
			$variables['message'] = $locale['dls921'];
		} elseif ($status == "cu") {
			$variables['message'] = $locale['dls925'];
		} else {
			$variables['message'] = "UNKNOWN STATUS PASSED!";
		}
	}
	// define the message panel variables
	$variables['bold'] = true;
	$template_panels[] = array('type' => 'body', 'name' => 'modules.download_statistics.status', 'title' => $locale['dls923'], 'template' => '_message_table_panel.tpl');
	$template_variables['modules.download_statistics.status'] = $variables;
	$variables = array();
}

// define the admin body panel
$template_panels[] = array('type' => 'body', 'name' => 'modules.download_statistics.admin', 'template' => 'modules.download_statistics.admin.tpl', 'locale' => "modules.download_statistics");
$template_variables['modules.download_statistics.admin'] = $variables;

// Call the theme code to generate the output for this webpage
require_once PATH_THEME."/theme.php";
?>