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
| $Id:: admin.php 2093 2008-12-05 20:43:27Z WanWizard                 $|
+----------------------------------------------------------------------+
| Last modified by $Author:: WanWizard                                $|
| Revision number $Rev:: 2093                                         $|
+---------------------------------------------------------------------*/
require_once dirname(__FILE__)."/../../includes/core_functions.php";
require_once PATH_ROOT."/includes/theme_functions.php";

require_once "tracsvn_include.php";

// check for the proper admin access rights
if (!checkrights("wT") || !defined("iAUTH") || $aid != iAUTH) fallback(BASEDIR."index.php");

// load the locale for this module
locale_load("modules.tracsvn");

// define the variables for this panel
$variables = array();

if (isset($_POST['savesettings'])) {

	// extract and validate the input
	$database = stripinput($_POST['database']);
	$url = stripinput($_POST['url']);
	$trac_url = stripinput($_POST['trac_url']);
	$cmd = stripinput($_POST['cmd']);
	$auth = stripinput($_POST['auth']);
	$extensions = stripinput($_POST['extensions']);
	$svn_filter = stripinput($_POST['svn_filter']);
	$view_svn = isNum($_POST['view_svn']) ? $_POST['view_svn'] : 102;
	$view_diff = isNum($_POST['view_diff']) ? $_POST['view_diff'] : 102;
	$view_file = isNum($_POST['view_file']) ? $_POST['view_file'] : 102;
	
	$variables['message'] = "";

	// check if the database exists and is a Trac database
	if (empty($database) || !dbtable_exists("revision", $database)) {
		$variables['message'] = ($variables['message'] == "" ? "" : "<br />") . $locale['406'];
	} else {
		// check if the cmd points to svn
		$_tmp = explode(" ", $cmd);
		if (CMS_GetOS() == "Windows") {
			$_tmp = substr(strrchr($_tmp[0], "\\"),1);
			if ($_tmp != "svn.exe") {
				$variables['message'] = ($variables['message'] == "" ? "" : "<br />") . $locale['444'];
			}
		} else {
			$_tmp = substr(strrchr($_tmp[0], "/"),1);
			if ($_tmp != "svn") {
				$variables['message'] = ($variables['message'] == "" ? "" : "<br />") . $locale['444'];
			}
		}
		// add a trailing slash if needed
		if (!empty($url) && substr($url, -1) != "/") {
			$url .= "/";
		}
		if (!empty($trac_url) && substr($trac_url, -1) != "/") {
			$trac_url .= "/";
		}
		if ($variables['message'] == "") {
			// executable is valid. check if the repository is readable
			$output = tracsvn_extCmd($cmd." info ".$url." ".$auth);
			if (!is_array($output) || !isset($output[5]) || $output[5] != "Node Kind: directory") {
				$variables['message'] = ($variables['message'] == "" ? "" : "<br />") . $locale['449'];
				foreach($output as $line) {
					$variables['message'] .= "<br />" . $line;
				}
			}
		}
	}
	// if no errors are found, update
	if ($variables['message'] == "") {
		$result = dbquery("UPDATE ".$db_prefix."configuration SET cfg_value = '".$database."' WHERE cfg_name = 'tracsvn_database'");
		$result = dbquery("UPDATE ".$db_prefix."configuration SET cfg_value = '".$url."' WHERE cfg_name = 'tracsvn_url'");
		$result = dbquery("UPDATE ".$db_prefix."configuration SET cfg_value = '".$trac_url."' WHERE cfg_name = 'tracsvn_trac_url'");
		$result = dbquery("UPDATE ".$db_prefix."configuration SET cfg_value = '".$cmd."' WHERE cfg_name = 'tracsvn_svncmd'");
		$result = dbquery("UPDATE ".$db_prefix."configuration SET cfg_value = '".$auth."' WHERE cfg_name = 'tracsvn_svnauth'");
		$result = dbquery("UPDATE ".$db_prefix."configuration SET cfg_value = '".$extensions."' WHERE cfg_name = 'tracsvn_extensions'");
		$result = dbquery("UPDATE ".$db_prefix."configuration SET cfg_value = '".$view_svn."' WHERE cfg_name = 'tracsvn_view_svn'");
		$result = dbquery("UPDATE ".$db_prefix."configuration SET cfg_value = '".$view_diff."' WHERE cfg_name = 'tracsvn_view_diff'");
		$result = dbquery("UPDATE ".$db_prefix."configuration SET cfg_value = '".$view_file."' WHERE cfg_name = 'tracsvn_view_file'");
		$result = dbquery("UPDATE ".$db_prefix."configuration SET cfg_value = '".$svn_filter."' WHERE cfg_name = 'tracsvn_svn_filter'");
		redirect(FUSION_SELF.$aidlink);
	}

} elseif (isset($_POST['savealias'])) {

	// process the selection
	foreach($_POST['username'] as $idx => $user_id) {
		if ($user_id) {
			if ($_POST['orgmap'][$idx]) {
				// update of a previous mapping
				$result = dbquery("UPDATE ".$db_prefix."tracsvn_alias SET tracsvn_userid = '".$user_id."' WHERE tracsvn_username = '".stripinput($_POST['tracuser'][$idx])."'");
			} else {
				// new mapping
				$result = dbquery("INSERT INTO ".$db_prefix."tracsvn_alias (tracsvn_userid, tracsvn_username) VALUES ('".$user_id."', '".stripinput($_POST['tracuser'][$idx])."')");
			}
		} else {
			// no mapping for this trac user
			$result = dbquery("DELETE FROM ".$db_prefix."tracsvn_alias WHERE tracsvn_username = '".stripinput($_POST['tracuser'][$idx])."'");
		}
	}
	redirect(FUSION_SELF.$aidlink);

} else {

	// populate the fields for the settings panel
	$database = $settings['tracsvn_database'];
	$url = $settings['tracsvn_url'];
	$trac_url = $settings['tracsvn_trac_url'];
	$cmd = $settings['tracsvn_svncmd'];
	$auth = $settings['tracsvn_svnauth'];
	$extensions = $settings['tracsvn_extensions'];
	$svn_filter = $settings['tracsvn_svn_filter'];
	$view_svn = $settings['tracsvn_view_svn'];
	$view_diff = $settings['tracsvn_view_diff'];
	$view_file = $settings['tracsvn_view_file'];

	// get the list of user groups
	$groups = getusergroups();
	$variables['usergroups'] = array();
	foreach ($groups as $group) {
		$variables['usergroups'][] = $group;
	}

	// get the information for the alias panel
	$tracusers = array();

	// if we have a valid Trac database configured...
	if (!empty($database) && dbtable_exists("revision", $database)) {
		// get the trac user accounts from the ticket table
		$result = dbquery("SELECT DISTINCT owner, reporter FROM ".$settings['tracsvn_database'].".ticket");
		while ($data = dbarray($result)) {
			// add it to the users array, if not already present
			if (!in_array($data['owner'], $tracusers)) {
				$tracusers[] = $data['owner'];
			}
			if (!in_array($data['reporter'], $tracusers)) {
				$tracusers[] = $data['reporter'];
			}
		}

		// get the trac user accounts from the revisions table
		$result = dbquery("SELECT DISTINCT author FROM ".$settings['tracsvn_database'].".revision");
		while ($data = dbarray($result)) {
			// add it to the users array, if not already present
			if (!in_array($data['author'], $tracusers)) {
				$tracusers[] = $data['author'];
			}
		}

		// sort the users
		sort($tracusers);
	}

	// get the alias mapping for this users
	$variables['aliases'] = array();
	foreach($tracusers as $tracuser) {
		$result = dbquery("SELECT t.*, u.user_name FROM ".$db_prefix."tracsvn_alias t, ".$db_prefix."users u WHERE t.tracsvn_userid = u.user_id AND tracsvn_username = '$tracuser'");
		if (dbrows($result)) {
			$data = dbarray($result);
			$variables['aliases'][] = array('tracuser' => $tracuser, 'user_id' => $data['tracsvn_userid'], 'user_name' => $data['user_name']);
		} else {
			$variables['aliases'][] = array('tracuser' => $tracuser, 'user_id' => 0, 'user_name' => "");
		}
	}

	// get the list of all users for the dropdown
	$variables['members'] = array();
	$result = dbquery("SELECT user_id, user_name FROM ".$db_prefix."users WHERE user_status = '0' ORDER BY user_name");
	while ($data = dbarray($result)) {
		$variables['members'][] = $data;
	}
}
//_debug($variables, true);
// store the variables
$variables['database'] = $database;
$variables['url'] = $url;
$variables['trac_url'] = $trac_url;
$variables['cmd'] = $cmd;
$variables['auth'] = $auth;
$variables['extensions'] = $extensions;
$variables['svn_filter'] = $svn_filter;
$variables['view_svn'] = $view_svn;
$variables['view_diff'] = $view_diff;
$variables['view_file'] = $view_file;

// define the body panel variables
$template_panels[] = array('type' => 'body', 'name' => 'tracsvn.admin_panel', 'template' => 'modules.tracsvn.admin.tpl', 'locale' => "modules.tracsvn");
$template_variables['tracsvn.admin_panel'] = $variables;

// Call the theme code to generate the output for this webpage
require_once PATH_THEME."/theme.php";
?>
