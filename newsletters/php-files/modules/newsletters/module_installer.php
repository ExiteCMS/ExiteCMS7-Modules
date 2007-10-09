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
if (!checkrights("I") || !defined("iAUTH") || $aid != iAUTH || !defined('INIT_CMS_OK')) fallback(BASEDIR."index.php");

/*---------------------------------------------------+
| Locale definition for this installation module     |
+----------------------------------------------------*/

if (file_exists(PATH_MODULES."newsletters/locale/".$settings['locale'].".php")) {
	include PATH_MODULES."newsletters/locale/".$settings['locale'].".php";
} else {
	include PATH_MODULES."newsletters/locale/English.php";
}

/*---------------------------------------------------+
| Module identification                              |
+----------------------------------------------------*/
$mod_title = $locale['nl100'];							// title or name of this module
$mod_description = $locale['nl101'];					// short description of it's purpose
$mod_version = $locale['nlver'];						// module version number
$mod_folder = "newsletters";							// sub-folder of the /modules folder
$mod_developer = "WanWizard";							// author's name
$mod_email = "wanwizard@gmail.com";
$mod_weburl = "http://exitecms.exite.eu/";
$mod_type = "M";

/*---------------------------------------------------+
| Module administration panel installation details   |
+----------------------------------------------------*/

$mod_admin_image = "newsletters.gif";					// icon to be used for the admin panel
$mod_admin_panel = "newsletters.php";					// name of the admin panel for this module
$mod_admin_rights = "wC";								// admin rights code. This HAS to be assigned by PLi-Fusion to avoid duplicates!
$mod_admin_page = 1;									// admin page this panel has to be placed on

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

/*---------------------------------------------------+
| commands to execute when installing this module    |
+----------------------------------------------------*/

$mod_install_cmds = array();							// commands to execute when installing this module
$mod_install_cmds[] = array('type' => 'db', 'value' => "CREATE TABLE ##PREFIX##newsletters (
  newsletter_id smallint(5) unsigned NOT NULL auto_increment,
  newsletter_subject varchar(200) NOT NULL default '',
  newsletter_content text NOT NULL,
  newsletter_format varchar(5) NOT NULL default 'plain',
  newsletter_datestamp int(10) unsigned NOT NULL default '0',
  newsletter_sent tinyint(1) unsigned NOT NULL default '0',
  newsletter_send_datestamp int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (newsletter_id)
) ENGINE=MyISAM");

/*---------------------------------------------------+
| commands to execute when uninstalling this module  |
+----------------------------------------------------*/

$mod_uninstall_cmds = array();							// commands to execute when uninstalling this module
$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DROP TABLE ##PREFIX##newsletters");

/*---------------------------------------------------+
| function to upgrade from a previous revision       |
+----------------------------------------------------*/
if (!function_exists('module_upgrade')) {
	function module_upgrade($current_version) {
	}
}
?>