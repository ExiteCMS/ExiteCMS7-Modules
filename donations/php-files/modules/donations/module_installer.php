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
if (!checkrights("I") || !defined("iAUTH") || $aid != iAUTH || !defined('IN_FUSION')) fallback(BASEDIR."index.php");

/*---------------------------------------------------+
| Locale definition for this installation module     |
+----------------------------------------------------*/

if (file_exists(PATH_MODULES."donations/locale/".$settings['locale'].".php")) {
	include PATH_MODULES."donations/locale/".$settings['locale'].".php";
} else {
	include PATH_MODULES."donations/locale/English.php";
}

/*---------------------------------------------------+
| Module identification                              |
+----------------------------------------------------*/
$mod_title = $locale['don000'];							// title or name of this module
$mod_description = "";									// short description of it's purpose
$mod_version = "1.0.0";									// module version number
$mod_developer = "WanWizard";							// author's name
$mod_email = "wanwizard@gmail.com";
$mod_weburl = "http://exitecms.exite.eu/";
$mod_type = "M";

/*---------------------------------------------------+
| Module administration panel installation details   |
+----------------------------------------------------*/

$mod_folder = "donations";								// sub-folder of the /modules folder
$mod_admin_image = "donations.gif";						// icon to be used for the admin panel
$mod_admin_panel = "admin_panel.php";					// name of the admin panel for this module
$mod_admin_rights = "wD";								// admin rights code. This HAS to be assigned by PLi-Fusion to avoid duplicates!
$mod_admin_page = 4;									// admin page this panel has to be placed on

/*---------------------------------------------------+
| Version and revision control                       |
+----------------------------------------------------*/

// check for a minumum version of the ExiteCMS engine
if (str_replace(".", "", $settings['version']) < 700) {
	$mod_errors .= sprintf($locale['mod001'], '7.00');
}
// check for a maximum version of the ExiteCMS engine
if (str_replace(".", "", $settings['version']) > 700) {
	$mod_errors .= sprintf($locale['mod002'], '7.00');
}
// check for a specific revision number range that is supported
if ($settings['revision'] < 0 || $settings['revision'] > 999999) {
	$mod_errors .= sprintf($locale['mod003'], 0, 999999);
}

/*---------------------------------------------------+
| Menu entries for this module                       |
+----------------------------------------------------*/

$mod_site_links = array();								// site_links definitions. Multiple can be defined
//$mod_site_links[] = array('name' => '', 'url' => '', 'panel' => '', 'visibility' => 0);

/*---------------------------------------------------+
| commands to execute when installing this module    |
+----------------------------------------------------*/

$mod_install_cmds = array();							// commands to execute when installing this module
$mod_install_cmds[] = array('type' => 'db', 'value' => "CREATE TABLE ##PREFIX##donations (
  donate_id smallint(5) NOT NULL auto_increment,
  donate_name varchar(50) NOT NULL default '',
  donate_amount decimal(10,2) NOT NULL default '0.00',
  donate_currency varchar(5) NOT NULL default '',
  donate_country char(2) NOT NULL default '',
  donate_comment varchar(200) NOT NULL default '',
  donate_timestamp int(10) NOT NULL default '0',
  donate_type tinyint(1) NOT NULL default '0',
  donate_state tinyint(1) NOT NULL default '0',
  PRIMARY KEY (donate_id)
) ENGINE=MyISAM");
$mod_install_cmds[] = array('type' => 'db', 'value' => "ALTER TABLE ##PREFIX##settings ADD donate_forum_id SMALLINT(5) NOT NULL");

$mod_install_cmds[] = array('type' => 'function', 'value' => "install_function");

/*---------------------------------------------------+
| commands to execute when uninstalling this module  |
+----------------------------------------------------*/

$mod_uninstall_cmds = array();							// commands to execute when uninstalling this module
$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DROP TABLE ##PREFIX##donations");

$mod_install_cmds[] = array('type' => 'function', 'value' => "uninstall_function");

/*---------------------------------------------------+
| function for special installations                 |
+----------------------------------------------------*/
if (!function_exists('install_donations')) {
	function install_donations() {
	}
}
/*---------------------------------------------------+
| function for special de-installations              |
+----------------------------------------------------*/
if (!function_exists('uninstall_donations')) {
	function uninstall_donations() {
	}
}

/*---------------------------------------------------+
| function to upgrade from a previous revision       |
+----------------------------------------------------*/
if (!function_exists('module_upgrade')) {
	function module_upgrade($current_version) {
	}
}
?>