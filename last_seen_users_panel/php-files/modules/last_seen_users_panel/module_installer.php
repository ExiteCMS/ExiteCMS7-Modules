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
$mod_title = "Last Seen Users Panel";
$mod_description = "Side panel to display the last active website users";
$mod_version = "1.1.0";
$mod_developer = "WanWizard";
$mod_email = "wanwizard@gmail.com";
$mod_weburl = "http://exitecms.exite.eu/";
$mod_type = "M";

/*---------------------------------------------------+
| Module administration panel installation details   |
+----------------------------------------------------*/

$mod_folder = "last_seen_users_panel";

// no admin module

/*---------------------------------------------------+
| Version and revision control                       |
+----------------------------------------------------*/

// check for a minumum version of the ExiteCMS engine
if (str_replace(".", "", $settings['version']) < 700) {
	$mod_errors .= sprintf($locale['mod001'], '7.00');
}
// check for a maximum version of the ExiteCMS engine
if (str_replace(".", "", $settings['version']) > 710) {
	$mod_errors .= sprintf($locale['mod002'], '7.10');
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
| locale strings for this module                     |
+----------------------------------------------------*/

$localestrings = array();
$localestrings['en'] = array();
$localestrings['en']['lsup000'] = "Last Seen Users";
$localestrings['en']['lsup001'] = "Online";
$localestrings['en']['lsup002'] = "< 5 mins";
$localestrings['en']['lsup003'] = "week";
$localestrings['en']['lsup004'] = "weeks";
$localestrings['en']['lsup005'] = "day";
$localestrings['en']['lsup006'] = "days";

$localestrings['nl'] = array();
$localestrings['nl']['lsup000'] = "Laatste gebruikers";
$localestrings['nl']['lsup001'] = "Online";
$localestrings['nl']['lsup002'] = "< 5 mins";
$localestrings['nl']['lsup003'] = "week";
$localestrings['nl']['lsup004'] = "weken";
$localestrings['nl']['lsup005'] = "dag";
$localestrings['nl']['lsup006'] = "dagen";

$localestrings['de'] = array();
$localestrings['de']['lsup000'] = "letzte User";
$localestrings['de']['lsup001'] = "Jetzt Online";
$localestrings['de']['lsup002'] = "< 5 min";
$localestrings['de']['lsup003'] = "Woche";
$localestrings['de']['lsup004'] = "Wochen";
$localestrings['de']['lsup005'] = "Tag";
$localestrings['de']['lsup006'] = "Tage";

$localestrings['da'] = array();
$localestrings['da']['lsup000'] = "Sidste Brugere Online";
$localestrings['da']['lsup001'] = "Online Nu";
$localestrings['da']['lsup002'] = "< 5 minutter";
$localestrings['da']['lsup003'] = "uge";
$localestrings['da']['lsup004'] = "uger";
$localestrings['da']['lsup005'] = "dag";
$localestrings['da']['lsup006'] = "dage";

$localestrings['sv'] = array();
$localestrings['sv']['lsup000'] = "Senast inloggade anv�ndare";
$localestrings['sv']['lsup001'] = "Inloggad nu";
$localestrings['sv']['lsup002'] = "< 5 minuter";
$localestrings['sv']['lsup003'] = "vecka";
$localestrings['sv']['lsup004'] = "veckor";
$localestrings['sv']['lsup005'] = "dag";
$localestrings['sv']['lsup006'] = "dagar";

$localestrings['ro'] = array();
$localestrings['ro']['lsup000'] = "Ultimii utilizatori v&#259;zu&#355;i";
$localestrings['ro']['lsup001'] = "Online";
$localestrings['ro']['lsup002'] = "< 5 min";
$localestrings['ro']['lsup003'] = "s&#259;pt";
$localestrings['ro']['lsup004'] = "s&#259;pt";
$localestrings['ro']['lsup005'] = "zi";
$localestrings['ro']['lsup006'] = "zile";

/*---------------------------------------------------+
| commands to execute when installing this module    |
+----------------------------------------------------*/

$mod_install_cmds = array();							// commands to execute when installing this module

/*---------------------------------------------------+
| commands to execute when uninstalling this module  |
+----------------------------------------------------*/

$mod_uninstall_cmds = array();							// commands to execute when uninstalling this module

/*---------------------------------------------------+
| function to upgrade from a previous revision       |
+----------------------------------------------------*/
if (!function_exists('module_upgrade')) {
	function module_upgrade($current_version) {

		global $db_prefix, $locale;

		switch($current_version) {
			case "0.0.1":
				// pre-release version, no database or other changes
			case "1.0.0":
				// ExiteCMS v7.0. no upgrade actions for this release
			case "1.1.0":
				// upgrade to ExiteCMS v7.1. no upgrade actions for this release
			default:
				// do this at every upgrade
		}
	}
}
?>