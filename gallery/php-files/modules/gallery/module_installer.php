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
$mod_title = "Menalto Gallery v1.5.7";
$mod_description = "ExiteCMS custom integration of the Menalto Photo Gallery software";
$mod_version = "0.0.1";
$mod_developer = "WanWizard";
$mod_email = "wanwizard@gmail.com";
$mod_weburl = "http://exitecms.exite.eu/";
$mod_type = "M";

/*---------------------------------------------------+
| Module administration panel installation details   |
+----------------------------------------------------*/

$mod_folder = "gallery";
$mod_admin_image = "gallery1.gif";
$mod_admin_panel = "cms_admin.php";
$mod_admin_rights = "wG";
$mod_admin_page = 4;

/*---------------------------------------------------+
| Version and revision control                       |
+----------------------------------------------------*/

// check for a minumum version of the ExiteCMS engine
if (str_replace(".", "", $settings['version']) < 710) {
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
| Environment and installation pre-checks            |
+----------------------------------------------------*/
// check if we're running on a *nix platform
if (CMS_getOS() == "Windows") {
	$mod_errors .= "This module can only be installed on a *nix platform. Windows is not supported at the moment!";
}

/*---------------------------------------------------+
| Menu entries for this module                       |
+----------------------------------------------------*/

$mod_site_links = array();
$mod_site_links[] = array('name' => 'Photo Gallery', 'url' => 'index.php', 'panel' => '', 'visibility' => 102);

/*---------------------------------------------------+
| locale strings for this module                     |
+----------------------------------------------------*/

$localestrings = array();
$localestrings['en'] = array();

$localestrings['nl'] = array();

/*---------------------------------------------------+
| commands to execute when installing this module    |
+----------------------------------------------------*/

$mod_install_cmds = array();

// add the configuration items for this module
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ".$db_prefix."configuration( cfg_name, cfg_value ) VALUES ('gallery_zip', '1')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ".$db_prefix."configuration( cfg_name, cfg_value ) VALUES ('gallery_title', 'ExiteCMS Photo Gallery')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ".$db_prefix."configuration( cfg_name, cfg_value ) VALUES ('gallery_albumdir', 'images/gallery')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ".$db_prefix."configuration( cfg_name, cfg_value ) VALUES ('gallery_albumtreedepth', '2')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ".$db_prefix."configuration( cfg_name, cfg_value ) VALUES ('gallery_microtree', 'yes')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ".$db_prefix."configuration( cfg_name, cfg_value ) VALUES ('gallery_highlight_size', '200')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ".$db_prefix."configuration( cfg_name, cfg_value ) VALUES ('gallery_highlight_ratio', '0')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ".$db_prefix."configuration( cfg_name, cfg_value ) VALUES ('gallery_showowners', 'yes')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ".$db_prefix."configuration( cfg_name, cfg_value ) VALUES ('gallery_albumsperpage', '5')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ".$db_prefix."configuration( cfg_name, cfg_value ) VALUES ('gallery_showsearchengine', 'yes')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ".$db_prefix."configuration( cfg_name, cfg_value ) VALUES ('gallery_framestyle', 'shadows')");
// check if zipinfo is installed
$output = array();
$result = exec('which zipinfo', $output, $error);
if ($error == false) {
	$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ".$db_prefix."configuration( cfg_name, cfg_value ) VALUES ('gallery_zipinfo', '".$output[0]."')");
}
// check if unzip is installed
$output = array();
$result = exec('which unzip', $output, $error);
if ($error == false) {
	$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ".$db_prefix."configuration( cfg_name, cfg_value ) VALUES ('gallery_unzip', '".$output[0]."')");
}
// check if zip is installed
$output = array();
$result = exec('which zip', $output, $error);
if ($error == false) {
	$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ".$db_prefix."configuration( cfg_name, cfg_value ) VALUES ('gallery_zip', '".$output[0]."')");
}
// check if rar is installed
$output = array();
$result = exec('which rar', $output, $error);
if ($error == false) {
	$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ".$db_prefix."configuration( cfg_name, cfg_value ) VALUES ('gallery_rar', '".$output[0]."')");
}
// check if jhead is installed
$output = array();
$result = exec('which jhead', $output, $error);
if ($error == false) {
	$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ".$db_prefix."configuration( cfg_name, cfg_value ) VALUES ('gallery_use_exif', '".$output[0]."')");
}
// check if jpegtran is installed
$output = array();
$result = exec('which jpegtran', $output, $error);
if ($error == false) {
	$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ".$db_prefix."configuration( cfg_name, cfg_value ) VALUES ('gallery_jpegtran', '".$output[0]."')");
}
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ".$db_prefix."configuration( cfg_name, cfg_value ) VALUES ('gallery_cacheexif', 'no')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ".$db_prefix."configuration( cfg_name, cfg_value ) VALUES ('gallery_slideshow_type', 'ordered')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ".$db_prefix."configuration( cfg_name, cfg_value ) VALUES ('gallery_slideshow_length', '0')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ".$db_prefix."configuration( cfg_name, cfg_value ) VALUES ('gallery_slideshow_loop', 'yes')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ".$db_prefix."configuration( cfg_name, cfg_value ) VALUES ('gallery_slideshowmode', 'high')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ".$db_prefix."configuration( cfg_name, cfg_value ) VALUES ('gallery_comments_enables', 'yes')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ".$db_prefix."configuration( cfg_name, cfg_value ) VALUES ('gallery_comments_indication', 'both')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ".$db_prefix."configuration( cfg_name, cfg_value ) VALUES ('gallery_comments_verbose', 'yes')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ".$db_prefix."configuration( cfg_name, cfg_value ) VALUES ('gallery_comments_anonymous', 'no')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ".$db_prefix."configuration( cfg_name, cfg_value ) VALUES ('gallery_comments_displayname', '!!USERNAME!!')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ".$db_prefix."configuration( cfg_name, cfg_value ) VALUES ('gallery_comments_addtype', 'inside')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ".$db_prefix."configuration( cfg_name, cfg_value ) VALUES ('gallery_comments_length', '300')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ".$db_prefix."configuration( cfg_name, cfg_value ) VALUES ('gallery_comments_overview_all', 'yes')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ".$db_prefix."configuration( cfg_name, cfg_value ) VALUES ('gallery_rssenabled', 'yes')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ".$db_prefix."configuration( cfg_name, cfg_value ) VALUES ('gallery_rssmode', 'highlight')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ".$db_prefix."configuration( cfg_name, cfg_value ) VALUES ('gallery_highlight', '')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ".$db_prefix."configuration( cfg_name, cfg_value ) VALUES ('gallery_rssmaxalbums', '25')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ".$db_prefix."configuration( cfg_name, cfg_value ) VALUES ('gallery_rssvisibleonly', 'yes')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ".$db_prefix."configuration( cfg_name, cfg_value ) VALUES ('gallery_rssdcdate', 'no')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ".$db_prefix."configuration( cfg_name, cfg_value ) VALUES ('gallery_rsbigphoto', 'no')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ".$db_prefix."configuration( cfg_name, cfg_value ) VALUES ('gallery_rssphototag', 'yes')");

/*---------------------------------------------------+
| commands to execute when uninstalling this module  |
+----------------------------------------------------*/

$mod_uninstall_cmds = array();

// remove the configuration items for this module
$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DELETE FROM ##PREFIX##configuration WHERE cfg_name LIKE 'gallery_%'");

/*---------------------------------------------------+
| function for special installations                 |
+----------------------------------------------------*/
if (!function_exists('install_module')) {
	function install_module() {
	}
}
/*---------------------------------------------------+
| function for special de-installations              |
+----------------------------------------------------*/
if (!function_exists('uninstall_module')) {
	function uninstall_module() {
	}
}

/*---------------------------------------------------+
| function to upgrade from a previous revision       |
+----------------------------------------------------*/
if (!function_exists('module_upgrade')) {
	function module_upgrade($current_version) {

		global $db_prefix, $locale;

		switch($current_version) {
			case "0.0.1":
				// this is the current version. place your upgrade commands here
			default:
				// do this with every upgrade
		}
	}
}
?>
