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
| $Id:: module_installer.php 2323 2010-03-17 19:47:11Z root           $|
+----------------------------------------------------------------------+
| Last modified by $Author:: root                                     $|
| Revision number $Rev:: 2323                                         $|
+---------------------------------------------------------------------*/
if (!checkrights("I") || !defined("iAUTH") || $aid != iAUTH || !defined('INIT_CMS_OK')) fallback(BASEDIR."index.php");

/*---------------------------------------------------+
| Module identification                              |
+----------------------------------------------------*/
$mod_title = "CMS Translations";						// title or name of this module
$mod_description = "This ExiteCMS module provides an interface to the locales table, to manage the website locales, and to allow translators to translate locale strings";	// short description of it's purpose
$mod_version = "1.1.1";									// module version number
$mod_developer = "WanWizard";							// author's name
$mod_email = "wanwizard@exitecms.org";
$mod_weburl = "http://www.exitecms.org/";
$mod_type = "M";

/*---------------------------------------------------+
| Module administration panel installation details   |
+----------------------------------------------------*/

$mod_folder = "translations";							// sub-folder of the /modules folder
$mod_admin_image = "translations.gif";					// icon to be used for the admin panel
$mod_admin_panel = "admin.php";							// name of the admin panel for this module
$mod_admin_rights = "wT";								// admin rights code. This HAS to be assigned by the ExiteCMS team to avoid duplicates!
$mod_admin_page = 4;									// admin page this panel has to be placed on

/*---------------------------------------------------+
| Version and revision control                       |
+----------------------------------------------------*/

// check for a minumum version of the ExiteCMS engine
if (str_replace(".", "", $settings['version']) < 720) {
	$mod_errors .= sprintf($locale['mod001'], '7.20');
}
// check for a maximum version of the ExiteCMS engine
if (str_replace(".", "", $settings['version']) > 730) {
	$mod_errors .= sprintf($locale['mod002'], '7.30');
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
$localestrings['en']['400'] = "Translation Administration";
$localestrings['en']['401'] = "Locale";
$localestrings['en']['402'] = "Code";
$localestrings['en']['403'] = "Active?";
$localestrings['en']['404'] = "Translators";
$localestrings['en']['405'] = "Last updated";
$localestrings['en']['406'] = "Yes";
$localestrings['en']['407'] = "No";
$localestrings['en']['408'] = "Options";
$localestrings['en']['409'] = "Edit locale information";
$localestrings['en']['410'] = "Delete this locale and all translations";
$localestrings['en']['411'] = "Import locale files (both old and new style)";
$localestrings['en']['412'] = "Deactivate this locale";
$localestrings['en']['413'] = "Activate this locale";
$localestrings['en']['414'] = "Never";
$localestrings['en']['415'] = "Add a new locale";
$localestrings['en']['416'] = "Edit a locale";
$localestrings['en']['420'] = "Locale code";
$localestrings['en']['421'] = "Locale name";
$localestrings['en']['422'] = "Specify the language name in the local language";
$localestrings['en']['423'] = "System locales";
$localestrings['en']['424'] = "give all combinations to support all platforms.<br />Use | as separator";
$localestrings['en']['425'] = "Characterset";
$localestrings['en']['426'] = "This is used in the HTML header and for characterset conversions";
$localestrings['en']['427'] = "Save Locale";
$localestrings['en']['428'] = "Follow the ISO standard if possible, p.e. 'de' or 'pt_BR'";
$localestrings['en']['429'] = "Member list";
$localestrings['en']['430'] = "Export all locale files";
$localestrings['en']['431'] = "Done";
$localestrings['en']['432'] = "Generate an installable language pack";
$localestrings['en']['433'] = "Country list";
$localestrings['en']['434'] = "Country code of the countries that use this language.<br />Use | as separator";
$localestrings['en']['435'] = "Text direction";
$localestrings['en']['436'] = "Left-to-Right";
$localestrings['en']['437'] = "Right-to-Left";
$localestrings['en']['900'] = "Messages:";
$localestrings['en']['901'] = "Unable to find this locale in the database<br />";
$localestrings['en']['902'] = "Field '%s' may not be left empty<br />";
$localestrings['en']['903'] = "Locale information succesfully saved<br />";
$localestrings['en']['904'] = "A '%s' with this value already exists<br />";
$localestrings['en']['905'] = "Unable to deactivate this locale. At least one locale must be active at all times!<br />";
$localestrings['en']['906'] = "Locale activated.<br />It can now be selected as default site language, or by users, as preferred language<br />";
$localestrings['en']['907'] = "Locale deactivated.<br />It can no longer be selected. Current selections have been reset to English<br />";
$localestrings['en']['908'] = "Import of '%s' failed<br />";
$localestrings['en']['909'] = "Locale files for locale '%s' succesfully imported<br />";
$localestrings['en']['910'] = "Unable to delete the locale '%s'<br />";
$localestrings['en']['911'] = "Locale '%s' succesfully deleted<br />";
$localestrings['en']['912'] = "Are you sure you want to delete the locate, and ALL translated locale strings?";
$localestrings['en']['913'] = "Unable to generate the locale files. No write access to '%s'<br />";
$localestrings['en']['914'] = "Locale files for '%s' succesfully generated<br />";
$localestrings['en']['915'] = "Unable to open the language pack code template file<br />";
$localestrings['en']['916'] = "Unable to create the language pack %s<br />";
$localestrings['en']['917'] = "Language Pack for for the locale '%s' succesfully generated<br />";
$localestrings['en']['918'] = "*) Last update of the locale strings by installing or updating from a language pack";

$localestrings['nl'] = array();
$localestrings['nl']['400'] = "Beheer van vertalingen";
$localestrings['nl']['401'] = "Locale";
$localestrings['nl']['402'] = "Code";
$localestrings['nl']['403'] = "Actief?";
$localestrings['nl']['404'] = "Vertalers";
$localestrings['nl']['405'] = "Laatst aangepast";
$localestrings['nl']['406'] = "Ja";
$localestrings['nl']['407'] = "Nee";
$localestrings['nl']['408'] = "Opties";
$localestrings['nl']['409'] = "Locale informatie wijzigen";
$localestrings['nl']['410'] = "Deze locale en alle vertalingen verwijderen";
$localestrings['nl']['411'] = "Locale files importeren (ondersteuning voor oud en nieuw formaat)";
$localestrings['nl']['412'] = "Deze locale deactiveren";
$localestrings['nl']['413'] = "Deze locale activeren";
$localestrings['nl']['414'] = "Nooit";
$localestrings['nl']['415'] = "Nieuwe locale toevoegen";
$localestrings['nl']['416'] = "Locale wijzigen";
$localestrings['nl']['420'] = "Locale code";
$localestrings['nl']['421'] = "Locale naam";
$localestrings['nl']['422'] = "Gebruik voor de naam de lokale spelling van het land";
$localestrings['nl']['423'] = "Systeem locale's";
$localestrings['nl']['424'] = "Geef zo veel mogelijk codes voor zo breed mogelijke ondersteuning.<br />Gebruik | als scheidingsteken";
$localestrings['nl']['425'] = "Karakterset";
$localestrings['nl']['426'] = "Dit wordt gebruikt in de HTML header en voor karakterset conversie";
$localestrings['nl']['427'] = "Locale opslaan";
$localestrings['nl']['428'] = "Volg indien mogelijk de ISO standaard b.v. 'de' of 'pt_BR'";
$localestrings['nl']['429'] = "Ledenlijst";
$localestrings['nl']['430'] = "Exporteer alle locale bestanden";
$localestrings['nl']['431'] = "Klaar";
$localestrings['nl']['432'] = "Genereer een te installeren taalpakket";
$localestrings['nl']['433'] = "Landenlijst";
$localestrings['nl']['434'] = "Landcodes van de landen waar deze taal gesproken wordt.<br />Use | as separator";
$localestrings['nl']['435'] = "Tekst richting";
$localestrings['nl']['436'] = "Links-naar-Rechts";
$localestrings['nl']['437'] = "Rechts-naar-Links";
$localestrings['nl']['900'] = "Berichten:";
$localestrings['nl']['901'] = "Deze locale kan niet in de database gevonden worden<br />";
$localestrings['nl']['902'] = "Het veld '%s' moet worden ingevuld<br />";
$localestrings['nl']['903'] = "Locale informatie succesvol opgeslagen<br />";
$localestrings['nl']['904'] = "Een '%s' met deze waarde bestaat al<br />";
$localestrings['nl']['905'] = "Deze locale kan niet worden gedeactiveerd. Er moet altijd minstens één locale actief blijven!<br />";
$localestrings['nl']['906'] = "Locale geactiveerd.<br />Deze kan nu als taal voor deze website gekozen worden. Leden kunnen deze ook als voorkeuze taal selecteren<br />";
$localestrings['nl']['907'] = "Locale gedeactiveerd.<br />Selectie is niet langer mogelijk. Overal waar deze taal was geselecteerd is dit nu vervangen door het Engels<br />";
$localestrings['nl']['908'] = "de import van '%s' is mislukt<br />";
$localestrings['nl']['909'] = "De locale bestanden voor de locale '%s' zijn succesvol geïmporteerd<br />";
$localestrings['nl']['910'] = "Het verwijderen van de locale '%s' is mislukt<br />";
$localestrings['nl']['911'] = "Locale '%s' succesvol verwijderd<br />";
$localestrings['nl']['912'] = "Weet u zeker dat u deze locale, en ALLE vertalingen, wilt verwijderen?";
$localestrings['nl']['913'] = "Fout bij het genereren van de locale bestanden. Geen schrijfrechten op '%s'<br />";
$localestrings['nl']['914'] = "Locale bestanden voor '%s' succesvol gegenereerd<br />";
$localestrings['nl']['915'] = "Fout bij het openen van het template bestand voor het taal pakket<br />";
$localestrings['nl']['916'] = "Fout bij het creeren van het taal pakket %s<br />";
$localestrings['nl']['917'] = "Taal pakket voor de locale '%s' is succesvol gegenereerd<br />";
$localestrings['nl']['918'] = "*) Laatste aanpassing van de locale strings door middel van een installatie van een taalmodule";

/*---------------------------------------------------+
| commands to execute when installing this module    |
+----------------------------------------------------*/

$mod_install_cmds = array();							// commands to execute when installing this module

// create the translators table
$mod_install_cmds[] = array('type' => 'db', 'value' => "CREATE TABLE ##PREFIX##translators (
  translate_id smallint(5) UNSIGNED NOT NULL auto_increment,
  translate_translator smallint(5) UNSIGNED NOT NULL default '0',
  translate_locale_code varchar(8) NOT NULL default '',
  PRIMARY KEY (translate_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

/*---------------------------------------------------+
| commands to execute when uninstalling this module  |
+----------------------------------------------------*/

$mod_uninstall_cmds = array();							// commands to execute when uninstalling this module

// delete the translators table
$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DROP TABLE ##PREFIX##translators");

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
				// pre-release version, no database or other changes
			case "1.0.0":
				// ExiteCMS v7.0. no upgrade actions for this release
			case "1.0.5":
				global $mod_title, $mod_folder, $mod_admin_panel;
				$result = dbquery("UPDATE ".$db_prefix."admin SET admin_link = '".(MODULES.$mod_folder."/".$mod_admin_panel)."' WHERE admin_title = '".$mod_title."'");
			case "1.1.0":
				// upgrade to ExiteCMS v7.1. no upgrade actions for this release
			case "1.1.1":
				// upgrade to ExiteCMS v7.3. no upgrade actions for this release
			default:
				// do this at every upgrade
		}
	}
}
?>
