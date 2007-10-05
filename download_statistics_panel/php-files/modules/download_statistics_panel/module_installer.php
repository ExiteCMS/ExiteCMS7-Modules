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

if (file_exists(PATH_MODULES."download_statistics_panel/locale/".$settings['locale'].".php")) {
	include PATH_MODULES."download_statistics_panel/locale/".$settings['locale'].".php";
} else {
	include PATH_MODULES."download_statistics_panel/locale/English.php";
}

/*---------------------------------------------------+
| Module identification                              |
+----------------------------------------------------*/
$mod_title = $locale['dls100'];							// title or name of this module
$mod_description = $locale['dls101'];					// short description of it's purpose
$mod_version = $locale['dlsver'];						// module version number
$mod_developer = "WanWizard";							// author's name
$mod_email = "wanwizard@gmail.com";
$mod_weburl = "http://exitecms.exite.eu/";
$mod_type = "M";

/*---------------------------------------------------+
| Module administration panel installation details   |
+----------------------------------------------------*/

$mod_folder = "download_statistics_panel";				// sub-folder of the /modules folder

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
$mod_site_links[] = array('name' => $locale['dls102'], 'url' => 'download_statistics_panel.php', 'panel' => '', 'visibility' => 102);

/*---------------------------------------------------+
| commands to execute when installing this module    |
+----------------------------------------------------*/

$mod_install_cmds = array();							// commands to execute when installing this module

// mapping: map multiple URL's to one download ID
$mod_install_cmds[] = array('type' => 'db', 'value' => "CREATE TABLE ##PREFIX##dls_mapping (
  mapping_id smallint(5) unsigned NOT NULL auto_increment,
  mapping_url varchar(255) NOT NULL default '',
  download_id smallint(5) NOT NULL default '0',
  ds_file_from varchar(255) NOT NULL default '',
  ds_file_to varchar(255) NOT NULL default '',
  PRIMARY KEY  (mapping_id)
) ENGINE=MyISAM;");

// statistics: download statistics table
$mod_install_cmds[] = array('type' => 'db', 'value' => "CREATE TABLE ##PREFIX##dls_statistics (
  ds_id mediumint(8) unsigned NOT NULL auto_increment,
  ds_success tinyint(1) unsigned NOT NULL default '0',
  ds_ip varchar(15) NOT NULL default '0.0.0.0',
  ds_cc char(2) NOT NULL default '',
  ds_timestamp int(10) unsigned NOT NULL default '0',
  ds_url varchar(255) NOT NULL default '',
  ds_file varchar(255) NOT NULL default '',
  ds_mirror tinyint(1) unsigned NOT NULL default '0',
  ds_processed tinyint(1) unsigned NOT NULL default '0',
  ds_onmap tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (ds_id),
  KEY countrycode (ds_cc),
  KEY mirror (ds_mirror),
  KEY filename (ds_file),
  KEY `timestamp` (ds_timestamp),
  KEY processed (ds_processed),
  KEY ds_url (ds_url)
) ENGINE=MyISAM;");

$mod_install_cmds[] = array('type' => 'function', 'value' => "install_dls");
$mod_install_cmds = array();							// commands to execute when installing this module

/*---------------------------------------------------+
| commands to execute when uninstalling this module  |
+----------------------------------------------------*/

$mod_uninstall_cmds = array();							// commands to execute when uninstalling this module

$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DROP TABLE ##PREFIX##dls_statistics");
$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DROP TABLE ##PREFIX##dls_mapping");

$mod_uninstall_cmds[] = array('type' => 'function', 'value' => "uninstall_dls");

/*---------------------------------------------------+
| function for special installations                 |
+----------------------------------------------------*/
if (!function_exists('install_dls')) {
	function install_dls() {
	}
}
/*---------------------------------------------------+
| function for special de-installations              |
+----------------------------------------------------*/
if (!function_exists('uninstall_dls')) {
	function uninstall_dls() {
	}
}

/*---------------------------------------------------+
| function to upgrade from a previous revision       |
+----------------------------------------------------*/
if (!function_exists('module_upgrade')) {
	function module_upgrade($current_version) {
		global $db_prefix;
			
		switch ($current_version) {
			case "0.0.1":
			case "0.0.2":
			case "0.0.3":
				$result = dbquery("ALTER TABLE ".$db_prefix."dls_statistics ADD ds_onmap tinyint(1) UNSIGNED NOT NULL DEFAULT '0'");
				$result = dbquery("UPDATE ".$db_prefix."dls_statistics SET ds_onmap = '1' WHERE ds_file LIKE '%/software.ver'");
		}
	}
}
?>