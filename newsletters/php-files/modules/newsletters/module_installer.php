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
| $Id:: viewpage.php 1935 2008-10-29 23:42:42Z WanWizard              $|
+----------------------------------------------------------------------+
| Last modified by $Author:: WanWizard                                $|
| Revision number $Rev:: 1935                                         $|
+---------------------------------------------------------------------*/
if (!checkrights("I") || !defined("iAUTH") || $aid != iAUTH || !defined('INIT_CMS_OK')) fallback(BASEDIR."index.php");

/*---------------------------------------------------+
| Module identification                              |
+----------------------------------------------------*/
// Infusion titles & description
$mod_title = "Newsletters";
$mod_description = "Newsletter management system.";
$mod_version = "1.1.1";
$mod_folder = "newsletters";							// sub-folder of the /modules folder
$mod_developer = "WanWizard";							// author's name
$mod_email = "wanwizard@exitecms.org";
$mod_weburl = "http://www.exitecms.org/";
$mod_type = "M";

/*---------------------------------------------------+
| Module administration panel installation details   |
+----------------------------------------------------*/

$mod_admin_image = "newsletters.gif";					// icon to be used for the admin panel
$mod_admin_panel = "newsletters.php";					// name of the admin panel for this module
$mod_admin_rights = "wC";								// admin rights code. This HAS to be assigned by ExiteCMS to avoid duplicates!
$mod_admin_page = 1;									// admin page this panel has to be placed on

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

$mod_site_links = array();								// site_links definitions. Multiple can be defined

/*---------------------------------------------------+
| locale strings for this module                     |
+----------------------------------------------------*/

$localestrings = array();

$localestrings['en'] = array();
// Current Newsletters
$localestrings['en']['nl400'] = "Current Newsletters";
$localestrings['en']['nl401'] = "Edit";
$localestrings['en']['nl402'] = "Delete";
$localestrings['en']['nl403'] = "Newsletter Subscription Management";
$localestrings['en']['nl404'] = "New Newsletter";
$localestrings['en']['nl405'] = "Send";
$localestrings['en']['nl406'] = "Cancel";
// Add/Edit/Delete Newsletter
$localestrings['en']['nl410'] = "Add Newsletter";
$localestrings['en']['nl411'] = "Edit Newsletter";
$localestrings['en']['nl412'] = "Send this Newsletter";
$localestrings['en']['nl413'] = "Delete Newsletter";
$localestrings['en']['nl414'] = "Newsletter Added";
$localestrings['en']['nl415'] = "Newsletter Updated";
$localestrings['en']['nl416'] = "The newsletter has been sent successfully to %s member(s).";
$localestrings['en']['nl417'] = "The newsletter could not be sent to the following member(s):";
$localestrings['en']['nl418'] = "Please ensure sendmail is configured correctly.";
$localestrings['en']['nl419'] = "There are no members subscribed to this newsletter.";
$localestrings['en']['nl420'] = "Newsletter Deleted";
$localestrings['en']['nl421'] = "Return to Newsletters Admin";
$localestrings['en']['nl422'] = "Return to Admin Index";
$localestrings['en']['nl423'] = "Newsletter Copied";
$localestrings['en']['nl424'] = "A preview of the newsletter has been sent successfully to your email address.";
$localestrings['en']['nl425'] = "%s newsletters could not be sent due to an invalid email address.";
// Add/Edit Newsletter Form
$localestrings['en']['nl430'] = "Subject:";
$localestrings['en']['nl431'] = "Newsletter Content:";
$localestrings['en']['nl432'] = "HTML Code:";
$localestrings['en']['nl433'] = "Format:";
$localestrings['en']['nl434'] = "Plain Text";
$localestrings['en']['nl435'] = "HTML";
$localestrings['en']['nl436'] = "Preview Newsletter";
$localestrings['en']['nl437'] = "Save Newsletter";
$localestrings['en']['nl438'] = "Copy Newsletter";
$localestrings['en']['nl439'] = "Note: the following tags are available when composing this newsletter (tag names must be in UPPER CASE!):";
$localestrings['en']['nl440'] = "<b>Subject:</b> {:USER_NAME:} | <b>Body:</b> {:USER_ID:}, {:USER_NAME:}, {:USER_EMAIL:}, {:USER_POSTS:}, {:USER_JOINED:}, {:USER_LASTVISIT:}, {:TIME:}, {:DATE:}";
$localestrings['en']['nl441'] = "For date variables, you can suffix the tagname with :S to use short date format, :L to use long date format, :D to display the date only, or :T to display the time only.";
// Popup Error/Warning Messages
$localestrings['en']['nl450'] = "Please specify a subject";
$localestrings['en']['nl451'] = "Delete this Newsletter?";
// Send dialog
$localestrings['en']['nl461'] = "Send this newletter to all members that meet the following criteria:";
$localestrings['en']['nl462'] = "Last logged-in before:";
$localestrings['en']['nl463'] = "Last logged-in after";
$localestrings['en']['nl464'] = "Last logged-in more than X days ago";
$localestrings['en']['nl465'] = "Last logged-in less than X days ago";
$localestrings['en']['nl466'] = "Send to all members";
$localestrings['en']['nl467'] = "Registered before:";
$localestrings['en']['nl468'] = "Registered after";
$localestrings['en']['nl469'] = "- OR -";
$localestrings['en']['nl470'] = "(Optional)";
$localestrings['en']['nl471'] = "(this overrides the members preference)";
$localestrings['en']['nl472'] = "No";
$localestrings['en']['nl473'] = "Yes";
$localestrings['en']['nl474'] = "Send it now";
$localestrings['en']['nl475'] = "Send only to member(s)";
$localestrings['en']['nl476'] = "(comma-seperated list of userids and/or nicknames)";
$localestrings['en']['nl477'] = "Preview: send it only to myself";
$localestrings['en']['nl478'] = "(this overrides all other selections)";
$localestrings['en']['nl479'] = "Mailing Results";

$localestrings['nl'] = array();
// Current Newsletters
$localestrings['nl']['nl400'] = "Huidige nieuwsbrieven";
$localestrings['nl']['nl401'] = "Wijzig";
$localestrings['nl']['nl402'] = "Verwijder";
$localestrings['nl']['nl403'] = "Nieuwsbrief management systeem";
$localestrings['nl']['nl404'] = "Nieuwe nieuwsbrief";
$localestrings['nl']['nl405'] = "Verzenden";
$localestrings['nl']['nl406'] = "Afbreken";
// Add/Edit/Delete Newsletter
$localestrings['nl']['nl410'] = "Nieuwsbrief toevoegen";
$localestrings['nl']['nl411'] = "Nieuwsbrief wijzigen";
$localestrings['nl']['nl412'] = "Verstuur deze nieuwsbrief";
$localestrings['nl']['nl413'] = "Nieuwsbrief verwijderen";
$localestrings['nl']['nl414'] = "Nieuwsbrief toegevoegd";
$localestrings['nl']['nl415'] = "Nieuwsbrief aangepast";
$localestrings['nl']['nl416'] = "De nieuwsbrief is succesvol verstuurd naar %s leden.";
$localestrings['nl']['nl417'] = "De Nieuwsbrief kon niet worden verzonden naar de volgende leden:";
$localestrings['nl']['nl418'] = "Controleer a.u.b. of sendmail correct is geconfigureerd.";
$localestrings['nl']['nl419'] = "Er zijn geen leden die zich op de nieuwsbrief hebben ingeschreven.";
$localestrings['nl']['nl420'] = "Nieuwsbrief verwijderd";
$localestrings['nl']['nl421'] = "Terug naar nieuwsbrief beheer";
$localestrings['nl']['nl422'] = "Terug naar beheer index";
$localestrings['nl']['nl423'] = "Nieuwsbrief gekopieerd";
$localestrings['nl']['nl424'] = "Een voorbeeld van deze nieuwsbrief is nu naar uw email adres verstuurd.";
$localestrings['nl']['nl425'] = "%s nieuwsbrieven konden niet worden verstuurd wegens een foutief email adres.";
// Add/Edit Newsletter Form
$localestrings['nl']['nl430'] = "Onderwerp:";
$localestrings['nl']['nl431'] = "Inhoud van de brief:";
$localestrings['nl']['nl432'] = "HTML Code:";
$localestrings['nl']['nl433'] = "Formaat:";
$localestrings['nl']['nl434'] = "Platte tekst";
$localestrings['nl']['nl435'] = "HTML";
$localestrings['nl']['nl436'] = "Nieuwsbrief bekijken";
$localestrings['nl']['nl437'] = "Nieuwsbrief bewaren";
$localestrings['nl']['nl438'] = "Nieuwsbrief kopieeren";
$localestrings['nl']['nl439'] = "Opm: de volgende tags zijn beschikbaar bij het maken van de nieuwsbrief. (tag namen moeten in HOOFDLETTERS zijn!):";
$localestrings['nl']['nl440'] = "<b>Onderwerp:</b> {:USER_NAME:} | <b>Nieuwsbrief:</b> {:USER_ID:}, {:USER_NAME:}, {:USER_EMAIL:}, {:USER_POSTS:}, {:USER_JOINED:}, {:USER_LASTVISIT:}, {:TIME:}, {:DATE:}";
$localestrings['nl']['nl441'] = "Voor datum variabelen, kunt u de tag naam laten volgen door :S voor een kort formaat, :L voor een lang formaat, :D voor alleen de datum, of :T voor alleen de tijd.";
// Popup Error/Warning Messages
$localestrings['nl']['nl450'] = "Geef a.u.b. een onderwerp voor deze nieuwsbrief";
$localestrings['nl']['nl451'] = "Verwijder deze nieuwsbrief?";
// Send dialog
$localestrings['nl']['nl461'] = "Verstuur deze nieuwsbrief aan iedereen die voldoet aan de volgende criteria:";
$localestrings['nl']['nl462'] = "Laatst ingelogd voor:";
$localestrings['nl']['nl463'] = "Laatst ingelogd na:";
$localestrings['nl']['nl464'] = "Laatst ingelogd meer dan X dagen geleden:";
$localestrings['nl']['nl465'] = "Laatst ingelogd minder dan X dagen geleden:";
$localestrings['nl']['nl466'] = "Verstuur naar alle gebruikers:";
$localestrings['nl']['nl467'] = "Aangemeld voor:";
$localestrings['nl']['nl468'] = "Aangemeld na:";
$localestrings['nl']['nl469'] = "- OF -";
$localestrings['nl']['nl470'] = "(Optioneel)";
$localestrings['nl']['nl471'] = "(dit negeert de gebruikersinstelling)";
$localestrings['nl']['nl472'] = "Nee";
$localestrings['nl']['nl473'] = "Ja";
$localestrings['nl']['nl474'] = "Nu versturen";
$localestrings['nl']['nl475'] = "Stuur alleen naar deze leden:";
$localestrings['nl']['nl476'] = "(lijst van userid of gebruikersnamen, gescheiden door een komma)";
$localestrings['nl']['nl477'] = "Resultaat bekijken. Stuur alleen naar mijzelf:";
$localestrings['nl']['nl478'] = "(dit gaat voor alle andere instellingen)";
$localestrings['nl']['nl479'] = "Resultaat van de mailing";

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

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
