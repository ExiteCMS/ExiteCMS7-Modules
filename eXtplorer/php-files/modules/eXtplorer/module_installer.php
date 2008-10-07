<?php
/*---------------------------------------------------+
| ExiteCMS Content Management System                 |
+----------------------------------------------------+
| Copyright 2008 Harro "WanWizard" Verton, Exite BV  |
| for support, please visit http://exitecms.exite.eu |
+----------------------------------------------------+
| Released under the terms & conditions of v2 of the |
| GNU General Public License. For details refer to   |
| the included gpl.txt file or visit http://gnu.org  |
+----------------------------------------------------*/
if (!checkrights("I") || !defined("iAUTH") || $aid != iAUTH || !defined('INIT_CMS_OK')) fallback(BASEDIR."index.php");

/*---------------------------------------------------+
| Module identification                              |
+----------------------------------------------------*/
$mod_title = "eXtplorer";
$mod_description = "Webbased file explorer and FTP client";
$mod_version = "1.0.0";
$mod_developer = "WanWizard";
$mod_email = "wanwizard@gmail.com";
$mod_weburl = "http://exitecms.exite.eu/";
$mod_type = "M";

/*---------------------------------------------------+
| Module administration panel installation details   |
+----------------------------------------------------*/

$mod_folder = "eXtplorer";

// no administration module for this plugin

/*---------------------------------------------------+
| Version and revision control                       |
+----------------------------------------------------*/

// check for a minumum version of the ExiteCMS engine
if (str_replace(".", "", $settings['version']) < 720) {
	$mod_errors .= sprintf($locale['mod001'], '7.20');
}
// check for a maximum version of the ExiteCMS engine
if (str_replace(".", "", $settings['version']) > 720) {
	$mod_errors .= sprintf($locale['mod002'], '7.20');
}
// check for a specific revision number range that is supported
if ($settings['revision'] < 0 || $settings['revision'] > 999999) {
	$mod_errors .= sprintf($locale['mod003'], 0, 999999);
}

/*---------------------------------------------------+
| Menu entries for this module                       |
+----------------------------------------------------*/

$mod_site_links = array();

/*---------------------------------------------------+
| locale strings for this module                     |
+----------------------------------------------------*/

$localestrings = array();

/*---------------------------------------------------+
| commands to execute when installing this module    |
+----------------------------------------------------*/

$mod_install_cmds = array();

// add the new user groups for the module "eXtplorer"
$mod_install_cmds[] = array('type' => 'function', 'value' => "eXtplorer_add_to_menu");

if (!function_exists('eXtplorer_add_to_menu')) {
	function eXtplorer_add_to_menu() {
		global $db_prefix, $settings;

		// determine the next menu order number
		$order = dbfunction("MAX(link_order)", "site_links") + 1;

		// get the group ID for the file admin group
		$result = dbquery("SELECT group_id FROM ".$db_prefix."user_groups WHERE group_ident = 'EX01'");
		if (dbrows($result)) {
			$data = dbarray($result);
			$group = $data['group_id'];
		} else {
			// if it doesn't exist, create it
			$result = dbquery("INSERT INTO ".$db_prefix."user_groups (group_ident, group_name, group_groups, group_rights, group_description, group_forumname, group_visible) 
							VALUES ('EX01', 'File Administrators', '', '', 'File Administrators', 'File Administrator', '0')");
			$group = mysql_insert_id();
		}

		$result = dbquery("INSERT INTO ".$db_prefix."site_links (link_name, link_locale, link_url, panel_name, link_visibility, link_position, link_window, link_order) 
							VALUES('File Explorer', '".$settings['locale_code']."', 'modules/eXtplorer/index.php', 'main_menu_panel', ".$group.", 1, 1, ".$order.")");
	}
}
/*---------------------------------------------------+
| commands to execute when uninstalling this module  |
+----------------------------------------------------*/

$mod_uninstall_cmds = array();

// delete the menu entry
$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DELETE FROM ##PREFIX##site_links WHERE link_url = 'modules/eXtplorer/index.php'");
// delete the module group
$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DELETE FROM ##PREFIX##user_groups WHERE group_ident = 'EX01'");

/*---------------------------------------------------+
| function to upgrade from a previous revision       |
+----------------------------------------------------*/
if (!function_exists('module_upgrade')) {
	function module_upgrade($current_version) {

		global $db_prefix, $locale;

		switch($current_version) {
			case "1.0.0":
				// current release, add changes here!
			default:
				// do this at every upgrade
		}
	}
}
?>
