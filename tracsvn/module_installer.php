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
$mod_title = "Trac-SVN reports";
$mod_description = "This ExiteCMS module provides a reporting of Trac Project management, and connects to SVN to retrieve details status information";
$mod_version = "0.1.6";
$mod_developer = "WanWizard";
$mod_email = "wanwizard@exitecms.org";
$mod_weburl = "http://www.exitecms.org/";
$mod_type = "M";

/*---------------------------------------------------+
| Module administration panel installation details   |
+----------------------------------------------------*/

$mod_folder = "tracsvn";
$mod_admin_image = "tracsvn.gif";
$mod_admin_panel = "admin.php";
$mod_admin_rights = "wN";
$mod_admin_page = 4;

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

$mod_site_links = array();
$mod_site_links[] = array('name' => 'Trac Reporting', 'url' => 'trac.php', 'panel' => '', 'visibility' => 102);
$mod_site_links[] = array('name' => 'SVN Reporting', 'url' => 'svn.php', 'panel' => '', 'visibility' => 102);

/*---------------------------------------------------+
| locale strings for this module                     |
+----------------------------------------------------*/

$localestrings = array();
$localestrings['en'] = array();
$localestrings['en']['400'] = "Project Management";
$localestrings['en']['401'] = "SVN - Now running...";
$localestrings['en']['402'] = "SVN Revision";
$localestrings['en']['403'] = "Committed on";
$localestrings['en']['404'] = "by";
$localestrings['en']['405'] = "No information found!";
$localestrings['en']['406'] = "Database not found, no access to database, or database is not a Trac database";
$localestrings['en']['407'] = "Trac & SVN user aliases";
$localestrings['en']['408'] = "Save aliases";
$localestrings['en']['409'] = "There are no aliases defined";
$localestrings['en']['410'] = "Save settings";
$localestrings['en']['411'] = "Trac MySQL database name:";
$localestrings['en']['412'] = "Trac username";
$localestrings['en']['413'] = "Member Name";
$localestrings['en']['414'] = "Milestone";
$localestrings['en']['415'] = "Overdue by";
$localestrings['en']['416'] = "Due in";
$localestrings['en']['417'] = "Open tickets";
$localestrings['en']['418'] = "Closed tickets";
$localestrings['en']['419'] = "Completed";
$localestrings['en']['420'] = "ago";
$localestrings['en']['421'] = "Opened";
$localestrings['en']['422'] = "Closed";
$localestrings['en']['423'] = "Open";
$localestrings['en']['424'] = "tickets for";
$localestrings['en']['425'] = "Summary";
$localestrings['en']['426'] = "Type";
$localestrings['en']['427'] = "Priority";
$localestrings['en']['428'] = "Status";
$localestrings['en']['429'] = "View ticket details";
$localestrings['en']['430'] = "View open tickets";
$localestrings['en']['431'] = "View closed tickets";
$localestrings['en']['432'] = "Ticket";
$localestrings['en']['433'] = "Reported by";
$localestrings['en']['434'] = "Assigned to";
$localestrings['en']['435'] = "Component";
$localestrings['en']['436'] = "Version";
$localestrings['en']['437'] = "Severity";
$localestrings['en']['438'] = "Keywords";
$localestrings['en']['439'] = "Description";
$localestrings['en']['440'] = "Change history";
$localestrings['en']['441'] = "changed";
$localestrings['en']['442'] = "from";
$localestrings['en']['443'] = "to";
$localestrings['en']['444'] = "Command specified is not the SVN executable";
$localestrings['en']['445'] = "Path to the SVN program:";
$localestrings['en']['446'] = "SVN authorisation string:";
$localestrings['en']['447'] = "SVN repository URL:";
$localestrings['en']['448'] = "Generate diffs for file extensions:";
$localestrings['en']['449'] = "Could not connect to the SVN repository. Output of the command is:<br />";
$localestrings['en']['450'] = "View SubVersion information:";
$localestrings['en']['451'] = "View SVN commit diffs:";
$localestrings['en']['452'] = "View SVN source files:";
$localestrings['en']['453'] = "No information found for this revision number";
$localestrings['en']['454'] = "(or none defined)";
$localestrings['en']['455'] = "Operation on a non-public section of the repository";
$localestrings['en']['456'] = "Non-public repository paths:";
$localestrings['en']['457'] = "Trac base URL:";

$localestrings['en']['500'] = "Changeset";
$localestrings['en']['501'] = "Timestamp";
$localestrings['en']['502'] = "Author";
$localestrings['en']['503'] = "Message";
$localestrings['en']['504'] = "Files";
$localestrings['en']['505'] = "copied from";
$localestrings['en']['506'] = "moved from";
$localestrings['en']['507'] = "Unmodified";
$localestrings['en']['508'] = "Added";
$localestrings['en']['509'] = "Removed";
$localestrings['en']['510'] = "Copied";
$localestrings['en']['511'] = "Modified";
$localestrings['en']['512'] = "Moved";
$localestrings['en']['513'] = "diff";
$localestrings['en']['514'] = "Show differences";
$localestrings['en']['515'] = "Show new revision %s of this file";
$localestrings['en']['516'] = "View this changeset";
$localestrings['en']['517'] = "Show entry";
$localestrings['en']['518'] = "Show original file (rev. %s)";
$localestrings['en']['519'] = "* you don't have access to this file *";
$localestrings['en']['520'] = "No commit message given";

$localestrings['nl'] = array();
$localestrings['nl']['400'] = "Project Management";
$localestrings['nl']['401'] = "SVN - nu actief...";
$localestrings['nl']['402'] = "SVN Revisie";
$localestrings['nl']['403'] = "Vastgelegd op";
$localestrings['nl']['404'] = "door";
$localestrings['nl']['405'] = "Geen informatie gevonden!";
$localestrings['nl']['406'] = "Database niet gevonden, geen toegang tot de database, of de database is geen Trac database";
$localestrings['nl']['407'] = "Trac & SVN gebruikersaliassen";
$localestrings['nl']['408'] = "Aliasen aanpassen";
$localestrings['nl']['409'] = "Er zijn geen aliassen gedefinieerd";
$localestrings['nl']['410'] = "Bewaar instellingen";
$localestrings['nl']['411'] = "Trac MySQL database naam:";
$localestrings['nl']['412'] = "Trac gebruiker";
$localestrings['nl']['413'] = "Lid naam";
$localestrings['nl']['414'] = "Mijlpaal";
$localestrings['nl']['415'] = "Opgeleverd op";
$localestrings['nl']['416'] = "Gepland op";
$localestrings['nl']['417'] = "Open tickets";
$localestrings['nl']['418'] = "Gesloten tickets";
$localestrings['nl']['419'] = "Gereed";
$localestrings['nl']['420'] = "geleden";
$localestrings['nl']['421'] = "Geopend";
$localestrings['nl']['422'] = "Gesloten";
$localestrings['nl']['423'] = "Open";
$localestrings['nl']['424'] = "tickets van";
$localestrings['nl']['425'] = "Omschrijving";
$localestrings['nl']['426'] = "Type";
$localestrings['nl']['427'] = "Prioriteit";
$localestrings['nl']['428'] = "Status";
$localestrings['nl']['429'] = "Ticket details bekijken";
$localestrings['nl']['430'] = "Open tickets bekijken";
$localestrings['nl']['431'] = "Gesloten tickets bekijken";
$localestrings['nl']['432'] = "Ticket";
$localestrings['nl']['433'] = "Gemeld door";
$localestrings['nl']['434'] = "Toegewezen aan";
$localestrings['nl']['435'] = "Component";
$localestrings['nl']['436'] = "Versie";
$localestrings['nl']['437'] = "Criticiteit";
$localestrings['nl']['438'] = "Sleutelwoorden";
$localestrings['nl']['439'] = "Omschrijving";
$localestrings['nl']['440'] = "Aanpassingshistorie";
$localestrings['nl']['441'] = "gewijzigd";
$localestrings['nl']['442'] = "van";
$localestrings['nl']['443'] = "naar";
$localestrings['nl']['444'] = "Pad wijst niet naar het SVN programma!";
$localestrings['nl']['445'] = "Pad naar het SVN programma:";
$localestrings['nl']['446'] = "SVN authorisatie string:";
$localestrings['nl']['447'] = "SVN repository URL:";
$localestrings['nl']['448'] = "Genereer diffs voor deze file extensies:";
$localestrings['nl']['449'] = "Kan geen verbinding maken met de SVN repository. Uitvoer van het commando is:<br />";
$localestrings['nl']['450'] = "SubVersion informatie bekijken:";
$localestrings['nl']['451'] = "SVN commit diffs bekijken:";
$localestrings['nl']['452'] = "SVN bron bestanden bekijken:";
$localestrings['nl']['453'] = "Geen informatie over dit revisie nummer gevonden";
$localestrings['nl']['454'] = "(of geen gedefinieerd)";
$localestrings['nl']['455'] = "Bewerking op een niet publiek deel van de repository";
$localestrings['nl']['456'] = "Niet publieke repository paden:";
$localestrings['nl']['457'] = "Trac basis URL:";

$localestrings['nl']['500'] = "Changeset";
$localestrings['nl']['501'] = "Datum";
$localestrings['nl']['502'] = "Auteur";
$localestrings['nl']['503'] = "Bericht";
$localestrings['nl']['504'] = "Bestanden";
$localestrings['nl']['505'] = "Gekopieerd van";
$localestrings['nl']['506'] = "Verplaatst van";
$localestrings['nl']['507'] = "Ongewijzigd";
$localestrings['nl']['508'] = "Toegevoegd";
$localestrings['nl']['509'] = "Verwijderd";
$localestrings['nl']['510'] = "Gekopieerd";
$localestrings['nl']['511'] = "Gewijzigd";
$localestrings['nl']['512'] = "Verplaatst";
$localestrings['nl']['513'] = "diff";
$localestrings['nl']['514'] = "Toon de wijzigingen";
$localestrings['nl']['515'] = "Toon nieuwe revisie %s van dit bestand";
$localestrings['nl']['516'] = "Bekijk dit changeset";
$localestrings['nl']['517'] = "Bekijk bestand";
$localestrings['nl']['518'] = "Toon origineel bestand (rev. %s)";
$localestrings['nl']['519'] = "* u heeft geen toegang tot dit bestand *";
$localestrings['nl']['520'] = "Geen commit bericht ingegeven";

/*---------------------------------------------------+
| commands to execute when installing this module    |
+----------------------------------------------------*/

$mod_install_cmds = array();

// add the configuration items for this module
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ".$db_prefix."configuration( cfg_name, cfg_value ) VALUES ('tracsvn_database', '')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ".$db_prefix."configuration( cfg_name, cfg_value ) VALUES ('tracsvn_url', '')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ".$db_prefix."configuration( cfg_name, cfg_value ) VALUES ('tracsvn_trac_url', '')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ".$db_prefix."configuration( cfg_name, cfg_value ) VALUES ('tracsvn_svncmd', '/usr/bin/svn')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ".$db_prefix."configuration( cfg_name, cfg_value ) VALUES ('tracsvn_svnauth', '--username name_here --password pass_here')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ".$db_prefix."configuration( cfg_name, cfg_value ) VALUES ('tracsvn_extensions', 'php,tpl,sh')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ".$db_prefix."configuration( cfg_name, cfg_value ) VALUES ('tracsvn_view_svn', '102')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ".$db_prefix."configuration( cfg_name, cfg_value ) VALUES ('tracsvn_view_diff', '102')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ".$db_prefix."configuration( cfg_name, cfg_value ) VALUES ('tracsvn_view_file', '102')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ".$db_prefix."configuration( cfg_name, cfg_value ) VALUES ('tracsvn_svn_filter', '')");

// create the table: tracsvn_alias
$mod_install_cmds[] = array('type' => 'db', 'value' => "CREATE TABLE ##PREFIX##tracsvn_alias (
  tracsvn_id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  tracsvn_userid mediumint(8) unsigned NOT NULL default '0',
  tracsvn_username varchar(50) NOT NULL default '',
  PRIMARY KEY  (tracsvn_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;");


/*---------------------------------------------------+
| commands to execute when uninstalling this module  |
+----------------------------------------------------*/

$mod_uninstall_cmds = array();

// remove the configuration items for this module
$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DELETE FROM ##PREFIX##configuration WHERE cfg_name = 'tracsvn_database'");
$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DELETE FROM ##PREFIX##configuration WHERE cfg_name = 'tracsvn_url'");
$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DELETE FROM ##PREFIX##configuration WHERE cfg_name = 'tracsvn_trac_url'");
$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DELETE FROM ##PREFIX##configuration WHERE cfg_name = 'tracsvn_svncmd'");
$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DELETE FROM ##PREFIX##configuration WHERE cfg_name = 'tracsvn_svnauth'");
$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DELETE FROM ##PREFIX##configuration WHERE cfg_name = 'tracsvn_extensions'");
$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DELETE FROM ##PREFIX##configuration WHERE cfg_name = 'tracsvn_view_svn'");
$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DELETE FROM ##PREFIX##configuration WHERE cfg_name = 'tracsvn_view_diff'");
$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DELETE FROM ##PREFIX##configuration WHERE cfg_name = 'tracsvn_view_file'");
$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DELETE FROM ##PREFIX##configuration WHERE cfg_name = 'tracsvn_svn_filter'");

// delete the table: tracsvn_alias
$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DROP TABLE ##PREFIX##tracsvn_alias");

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
				// no upgrades this version
			case "0.1.0":
				// no upgrades this version
			case "0.1.1":
				// no upgrades this version
			case "0.1.2":
				// add the new svn filter settings key
				$result = dbquery("INSERT INTO ".$db_prefix."configuration( cfg_name, cfg_value ) VALUES ('tracsvn_svn_filter', '')");
			case "0.1.3":
				// no upgrades this version
			case "0.1.4":
				// add the new trac base URL
				$result = dbquery("INSERT INTO ".$db_prefix."configuration( cfg_name, cfg_value ) VALUES ('tracsvn_trac_url', '')");
			case "0.1.5":
				// no upgrades this version
			default:
				// do this with every upgrade
		}
	}
}
?>
