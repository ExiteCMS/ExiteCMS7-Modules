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
if (!checkrights("I") || !defined("iAUTH") || $aid != iAUTH || !defined('INIT_CMS_OK')) fallback(BASEDIR."index.php");

/*---------------------------------------------------+
| Locale definition for this installation module     |
+----------------------------------------------------*/

locale_load("modules.mail2forum");

/*---------------------------------------------------+
| Module identification                              |
+----------------------------------------------------*/
$mod_title = $locale['m2f100'];							// title or name of this module
$mod_description = $locale['m2f101'];					// short description of it's purpose
$mod_version = $locale['m2fver'];						// module version number
$mod_developer = "WanWizard";							// author's name
$mod_email = "wanwizard@gmail.com";
$mod_weburl = "http://exitecms.exite.eu/";
$mod_type = "M";

/*---------------------------------------------------+
| Module administration panel installation details   |
+----------------------------------------------------*/

$mod_folder = "mail2forum";								// sub-folder of the /modules folder
$mod_admin_image = "mail2forum.gif";					// icon to be used for the admin panel
$mod_admin_panel = "m2f_admin_panel.php";				// name of the admin panel for this module
$mod_admin_rights = "wA";								// admin rights code. This HAS to be assigned by PLi-Fusion to avoid duplicates!
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
$mod_site_links[] = array('name' => $locale['m2f102'], 'url' => 'm2f_subscriptions.php', 'panel' => '', 'visibility' => 102);

/*---------------------------------------------------+
| commands to execute when installing this module    |
+----------------------------------------------------*/

$mod_install_cmds = array();							// commands to execute when installing this module

// M2F_status: status of the M2F background process
$mod_install_cmds[] = array('type' => 'db', 'value' => "CREATE TABLE ##PREFIX##M2F_status (
  m2f_lastpoll int(10) unsigned NOT NULL default '0',
  m2f_abort tinyint(1) unsigned NOT NULL default '0'
) ENGINE=MyISAM;");

// M2F_config: user configuration table
$mod_install_cmds[] = array('type' => 'db', 'value' => "CREATE TABLE ##PREFIX##M2F_config (
  m2f_userid mediumint(8) unsigned NOT NULL default '0',
  m2f_html tinyint(1) unsigned NOT NULL default '0',
  m2f_attach tinyint(1) unsigned NOT NULL default '0',
  m2f_inline tinyint(1) unsigned NOT NULL default '0',
  m2f_thumbnail tinyint(1) unsigned NOT NULL default '0'
) ENGINE=MyISAM;");

// M2F_forums: mailer configuration table
$mod_install_cmds[] = array('type' => 'db', 'value' => "CREATE TABLE ##PREFIX##M2F_forums (
  m2f_id smallint(5) unsigned NOT NULL auto_increment,
  m2f_forumid smallint(5) unsigned NOT NULL default '0',
  m2f_type tinyint(3) unsigned NOT NULL default '0',
  m2f_access tinyint(3) unsigned NOT NULL default '0',
  m2f_email varchar(255) default NULL,
  m2f_userid varchar(100) default NULL,
  m2f_password varchar(100) default NULL,
  m2f_sent mediumint(8) unsigned NOT NULL default '0',
  m2f_received mediumint(8) unsigned NOT NULL default '0',
  m2f_active tinyint(1) unsigned NOT NULL default '0',
  m2f_subscribe tinyint(1) unsigned NOT NULL default '0',
  m2f_posting tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (m2f_id),
  UNIQUE KEY m2f_forumid (m2f_forumid)
) ENGINE=MyISAM;");

// M2F_subscriptions: user subscription table
$mod_install_cmds[] = array('type' => 'db', 'value' => "CREATE TABLE ##PREFIX##M2F_subscriptions (
  m2f_subid smallint(5) unsigned NOT NULL auto_increment,
  m2f_forumid smallint(5) unsigned NOT NULL default '0',
  m2f_userid mediumint(8) unsigned NOT NULL default '0',
  m2f_subscribed tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (m2f_subid)
) ENGINE=MyISAM;");

$mod_install_cmds[] = array('type' => 'function', 'value' => "install_function");

/*---------------------------------------------------+
| commands to execute when uninstalling this module  |
+----------------------------------------------------*/

$mod_uninstall_cmds = array();							// commands to execute when uninstalling this module

$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DROP TABLE ##PREFIX##M2F_status");
$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DROP TABLE ##PREFIX##M2F_config");
$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DROP TABLE ##PREFIX##M2F_forums");
$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DROP TABLE ##PREFIX##M2F_subscriptions");

$mod_install_cmds[] = array('type' => 'function', 'value' => "uninstall_function");

/*---------------------------------------------------+
| function for special installations                 |
+----------------------------------------------------*/
if (!function_exists('install_function')) {
	function install_function() {
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

		global $db_prefix;

		switch($current_version) {
			case "0.1.1":
				// pre-release version, no database or other changes
			case "xxx":
				$result = dbquery("ALTER TABLE ".$db_prefix."M2F_config CHANGE m2f_userid m2f_userid MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0'");
				$result = dbquery("ALTER TABLE ".$db_prefix."M2F_subscriptions CHANGE m2f_userid m2f_userid MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0'");
			default:
				// to execute at every upgrade
		}

	}
}
?>