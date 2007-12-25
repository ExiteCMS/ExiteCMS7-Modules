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
| Module identification                              |
+----------------------------------------------------*/
$mod_title = "Download Bars Panel";
$mod_description = "Side panel to show download counters in a horizontal bar graph";
$mod_version = "1.0.1";
$mod_developer = "WanWizard";
$mod_email = "wanwizard@gmail.com";
$mod_weburl = "http://exitecms.exite.eu/";
$mod_type = "P";

/*---------------------------------------------------+
| Module administration panel installation details   |
+----------------------------------------------------*/

$mod_folder = "download_bars_panel";
$mod_admin_image = "dl.gif";							// icon to be used for the admin panel
$mod_admin_panel = "download_bars_admin.php";			// name of the admin panel for this module
$mod_admin_rights = "D";								// admin rights code (we use the code for the Downloads admin module).
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

$mod_site_links = array();

/*---------------------------------------------------+
| locale strings for this module                     |
+----------------------------------------------------*/

$localestrings = array();

// English locale strings
$localestrings['en'] = array();
$localestrings['en']['400'] = "Download Bars Panel Content";
$localestrings['en']['401'] = "Bar Position";
$localestrings['en']['402'] = "Save Bar Content";
$localestrings['en']['403'] = "Download Bars Title";
$localestrings['en']['404'] = "Download Bars Panel Content succesfully saved";
$localestrings['en']['405'] = "There are no download items present to add to the download statistics panel";

// Nederlandse locale strings
$localestrings['nl'] = array();
$localestrings['nl']['400'] = "Inhoud download balk-grafiek paneel";
$localestrings['nl']['401'] = "Balk positie";
$localestrings['nl']['402'] = "Inhoud bewaren";
$localestrings['nl']['403'] = "Download balk titel";
$localestrings['nl']['404'] = "Inhoud van het balk-grafiek paneel is opgeslagen";
$localestrings['nl']['405'] = "Er zijn geen download items gevonden om aan het statistieken paneel toe te voegen";

/*---------------------------------------------------+
| commands to execute when installing this module    |
+----------------------------------------------------*/

$mod_install_cmds = array();

/*---------------------------------------------------+
| commands to execute when uninstalling this module  |
+----------------------------------------------------*/

$mod_uninstall_cmds = array();

/*----------------------------------------------------+
| function for installation code                      |
+----------------------------------------------------*/
if (!function_exists('install_module')) {
	function install_module() {
	}
}
/*---------------------------------------------------+
| function for de-installation code                  |
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

		switch ($current_version) {
			case "1.0.0":	// things to do when the current version is 1.0.0

				// commands here, NO break statement!

			case "1.0.1":	// things to do when the current version is 1.0.1

				// commands here, NO break statement!

			default:
		}
	}
}
?>