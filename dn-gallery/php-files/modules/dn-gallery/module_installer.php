<?php
/*---------------------------------------------------+
| ExiteCMS Content Management System                 |
+----------------------------------------------------+
| Copyright 2008 Harro "WanWizard" Verton, Exite BV  |
| for support, please visit http://exitecms.exite.eu |
+----------------------------------------------------+
| DN-Gallery is copyright 2008 Adam M Riyadi         |
| http://www.devel-nottie.com, released under GPL v3 |
+----------------------------------------------------+
| Released under the terms & conditions of v2 of the |
| GNU General Public License. For details refer to   |
| the included gpl.txt file or visit http://gnu.org  |
+----------------------------------------------------*/
if (!checkrights("I") || !defined("iAUTH") || $aid != iAUTH || !defined('INIT_CMS_OK')) fallback(BASEDIR."index.php");

/*---------------------------------------------------+
| Module identification                              |
+----------------------------------------------------*/
$mod_title = "DN-Gallery";							// title or name of this module
$mod_description = "Ajax based Photo Galleryt";		// short description of it's purpose
$mod_version = "0.0.1";								// module version number
$mod_developer = "WanWizard";						// author's name
$mod_email = "wanwizard@gmail.com";
$mod_weburl = "http://exitecms.exite.eu/";
$mod_type = "M";

/*---------------------------------------------------+
| Module administration panel installation details   |
+----------------------------------------------------*/

$mod_folder = "dn-gallery";								// sub-folder of the /modules folder
$mod_admin_image = "dn-gallery.gif";					// icon to be used for the admin panel
$mod_admin_panel = "admin.php";							// name of the admin panel for this module
$mod_admin_rights = "wH";								// admin rights code. This HAS to be assigned by ExiteCMS to avoid duplicates!
$mod_admin_page = 1;									// admin page this panel has to be placed on

/*---------------------------------------------------+
| Version and revision control                       |
+----------------------------------------------------*/

// check for a minumum version of the ExiteCMS engine
if (str_replace(".", "", $settings['version']) < 710) {
	$mod_errors .= sprintf($locale['mod001'], '7.10');
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

$mod_site_links = array();								// site_links definitions. Multiple can be defined
$mod_site_links[] = array('name' => $mod_title, 'url' => 'index.php', 'panel' => '', 'visibility' => 100);

/*---------------------------------------------------+
| locale strings for this module                     |
+----------------------------------------------------*/
$localestrings = array();
$localestrings['en'] = array();

$localestrings['nl'] = array();

/*---------------------------------------------------+
| commands to execute when installing this module    |
+----------------------------------------------------*/

$mod_install_cmds = array();							// commands to execute when installing this module

// adverts: advertising table
$mod_install_cmds[] = array('type' => 'db', 'value' => "CREATE TABLE ##PREFIX##advertising (
  adverts_id smallint(5) NOT NULL auto_increment,
  adverts_userid mediumint(8) NOT NULL default '0',
  adverts_contract tinyint(1) NOT NULL default '0',
  adverts_contract_start int(10) unsigned NOT NULL default '0',
  adverts_contract_end int(10) unsigned NOT NULL default '0',
  adverts_priority tinyint(1) unsigned NOT NULL default '1',
  adverts_location tinyint(2) unsigned NOT NULL default '0',
  adverts_url varchar(200) NOT NULL default '',
  adverts_shown int(11) NOT NULL default '0',
  adverts_clicks int(11) NOT NULL default '0',
  adverts_sold int(11) NOT NULL default '0',
  adverts_image varchar(50) NOT NULL default '',
  adverts_html text NOT NULL,
  adverts_status enum('0','1') NOT NULL default '0',
  adverts_expired tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (adverts_id)
) ENGINE=MyISAM;");

// add a user group for this module
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##user_groups (group_ident, group_name, group_description, group_forumname, group_visible) VALUES ('".$mod_admin_rights."01', 'Advertising clients', 'Advertising clients', 'Advertising client', '1')");

$mod_install_cmds[] = array('type' => 'function', 'value' => "install_function");

/*---------------------------------------------------+
| commands to execute when uninstalling this module  |
+----------------------------------------------------*/

$mod_uninstall_cmds = array();							// commands to execute when uninstalling this module

$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DROP TABLE ##PREFIX##advertising");

$mod_uninstall_cmds[] = array('type' => 'function', 'value' => "uninstall_function");

/*---------------------------------------------------+
| function for special installations                 |
+----------------------------------------------------*/
if (!function_exists('install_function')) {
	function install_function() {

		global $db_prefix, $locale, $mod_title, $mod_admin_rights;

		// update the visiblity of the menu link

		// get the group_id of the Advertising Clients group
		$group = dbarray(dbquery("SELECT group_id FROM ".$db_prefix."user_groups WHERE group_ident = '".$mod_admin_rights."01'"));
		if (is_array($group)) {
			// modify the visibility
			$result = dbquery("UPDATE ".$db_prefix."site_links SET link_visibility = '".$group['group_id']."' WHERE link_name = '".$mod_title."' AND link_url = 'advertising.php'");
		}
	}
}
/*---------------------------------------------------+
| function for special de-installations              |
+----------------------------------------------------*/
if (!function_exists('uninstall_function')) {
	function uninstall_function() {
	}
}

/*---------------------------------------------------+
| function to upgrade from a previous revision       |
+----------------------------------------------------*/
if (!function_exists('module_upgrade')) {
	function module_upgrade($current_version) {

		global $db_prefix, $locale;

		switch($current_version) {
			default:
				// do this at every upgrade
		}

	}
}
?>
