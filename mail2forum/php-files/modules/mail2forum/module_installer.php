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
$mod_title = "Mail2Forum";
$mod_description = "Mail2Forum implements an interface between the mail and the web world. Posted messages are emailed to subscribers, their replies are posted on the forum on their behalf";
$mod_version = "1.1.0";
$mod_developer = "WanWizard";
$mod_email = "wanwizard@gmail.com";
$mod_weburl = "http://exitecms.exite.eu/";
$mod_type = "M";

/*---------------------------------------------------+
| Module administration panel installation details   |
+----------------------------------------------------*/

$mod_folder = "mail2forum";								// sub-folder of the /modules folder
$mod_admin_image = "mail2forum.gif";					// icon to be used for the admin panel
$mod_admin_panel = "m2f_admin.php";						// name of the admin panel for this module
$mod_admin_rights = "wA";								// admin rights code. This HAS to be assigned by ExiteCMS to avoid duplicates!
$mod_admin_page = 4;									// admin page this panel has to be placed on

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
$mod_site_links[] = array('name' => "Subscriptions", 'url' => 'm2f_subscriptions.php', 'panel' => '', 'visibility' => 102);

/*---------------------------------------------------+
| locale strings for this module                     |
+----------------------------------------------------*/

$localestrings = array();

$localestrings['en'] = array();
// installation error
$localestrings['en']['m2f110'] = "The Mail2Forum module is not installed. You have to do this before starting a M2F processor";
// Admin panel - forum list
$localestrings['en']['m2f200'] = "Forum list";
$localestrings['en']['m2f201'] = "Forum name";
$localestrings['en']['m2f202'] = "Forum Postability";
$localestrings['en']['m2f203'] = "Options";
$localestrings['en']['m2f204'] = "";
$localestrings['en']['m2f205'] = "Sent";
$localestrings['en']['m2f210'] = "Configure";
$localestrings['en']['m2f211'] = "Activate this configuration";
$localestrings['en']['m2f212'] = "Disable this configuration";
$localestrings['en']['m2f213'] = "Received";
$localestrings['en']['m2f214'] = "Mail system";
$localestrings['en']['m2f215'] = "Remove";
$localestrings['en']['m2f216'] = "Cancel";
$localestrings['en']['m2f217'] = "View the subscribers list";
$localestrings['en']['m2f218'] = "Allow users to subscribe";
$localestrings['en']['m2f219'] = "Disable user subscriptions";
// Supported mailbox types
$localestrings['en']['m2f230'] = "SMTP/POP3";
$localestrings['en']['m2f231'] = "SMTP/IMAP";
$localestrings['en']['m2f232'] = "Gmail";
$localestrings['en']['m2f233'] = "Majordomo";
// Admin panel - Edit screen
$localestrings['en']['m2f300'] = "configuration for forum";
$localestrings['en']['m2f301'] = "Forum email address:";
$localestrings['en']['m2f302'] = "Mailbox username:";
$localestrings['en']['m2f303'] = "Mailbox password:";
$localestrings['en']['m2f304'] = "Save configuration";
$localestrings['en']['m2f305'] = "Activate this configuration:";
$localestrings['en']['m2f306'] = "No";
$localestrings['en']['m2f307'] = "Yes";
$localestrings['en']['m2f308'] = "Restrict subscription to user group:";
$localestrings['en']['m2f309'] = "Allow members to subscribe:";
$localestrings['en']['m2f310'] = "Posting by email allowed for user group:";
// Admin panel - Subscriber list
$localestrings['en']['m2f350'] = "Subscribers to forum";
$localestrings['en']['m2f351'] = "This forum has no subscribers";
$localestrings['en']['m2f352'] = "User id";
$localestrings['en']['m2f353'] = "User Name";
$localestrings['en']['m2f354'] = "Email Address";
// Subscription screen
$localestrings['en']['m2f400'] = "Forum name";
$localestrings['en']['m2f401'] = "Subscribed";
$localestrings['en']['m2f402'] = "Email address for posting";
$localestrings['en']['m2f403'] = "Save subscriptions";
$localestrings['en']['m2f404'] = "Mail2Forum - Subscriptions";
// User configuration
$localestrings['en']['m2f450'] = "Mail2Forum - Configuration";
$localestrings['en']['m2f451'] = "Receive HTML or plain text emails:";
$localestrings['en']['m2f452'] = "Plain text";
$localestrings['en']['m2f453'] = "HTML";
$localestrings['en']['m2f454'] = "Receive attachments:";
$localestrings['en']['m2f455'] = "Ignore";
$localestrings['en']['m2f456'] = "Attach files";
$localestrings['en']['m2f457'] = "Links to files";
$localestrings['en']['m2f458'] = "Receive images as files or inline images:";
$localestrings['en']['m2f459'] = "(HTML messages only)";
$localestrings['en']['m2f460'] = "Inline";
$localestrings['en']['m2f461'] = "As files";
$localestrings['en']['m2f462'] = "Receive thumbnailed images if available:";
$localestrings['en']['m2f463'] = "Thumbnails";
$localestrings['en']['m2f464'] = "Full size";
// M2F_SMTP processor: internal
$localestrings['en']['m2f800'] = "First startup of the %s processor";
$localestrings['en']['m2f801'] = "Time interval to large. Check the infusion admin module for instructions.";
$localestrings['en']['m2f802'] = "Database error. M2F_Status contains values, but these can not be retrieved";
$localestrings['en']['m2f803'] = "Database error. Can not find the forum forum_id from the post record points to:";
$localestrings['en']['m2f804'] = "M2F_INTERVAL to short to process all email. Choose a larger interval. If this error persists, please contact the author";
$localestrings['en']['m2f805'] = "Cancelled by the system administrator";
// M2F_SMTP processor: external
$localestrings['en']['m2f811'] = "Sent using ExiteCMS Mail2Forum: http://exitecms.exite.eu";
$localestrings['en']['m2f812'] = "<a href='http://exitecms.exite.eu'>Sent using ExiteCMS</a>";
$localestrings['en']['m2f813'] = "Click here to go to this forum post";
$localestrings['en']['m2f814'] = "* *  * note: this is an edit of a previous post * * *";
$localestrings['en']['m2f815'] = "wrote";
// M2F_POP3 processor
// Error messages
$localestrings['en']['m2f900'] = "Forum can not be enabled. Please choose [".$localestrings['en']['m2f210']."] to create a configuration first";
$localestrings['en']['m2f901'] = "Email address can not be left blank";
$localestrings['en']['m2f902'] = "POP3 username can not be left blank";
$localestrings['en']['m2f903'] = "POP3 password can bot be left blank";
$localestrings['en']['m2f904'] = "Configuration has been saved";
$localestrings['en']['m2f905'] = "You are about to remove the configuration of the forum '%s'. Are you sure?<br><br>note: this also removes the forum subscriptions of all members!";
$localestrings['en']['m2f906'] = "ERROR! From: %s - To: %s -> %s";
$localestrings['en']['m2f907'] = "SQL Error: %s of table '%s' failed!";
$localestrings['en']['m2f908'] = "Maximum number of attachments reached";
$localestrings['en']['m2f909'] = "Added attachment %s to post #%s";
$localestrings['en']['m2f910'] = "Attachment '%s' can not be stored on disk";
$localestrings['en']['m2f911'] = "Attachment '%s' has an illegal extension or extension doesn't match contents";
$localestrings['en']['m2f912'] = "Attachment '%s' has an illegal filename or it's size exceeded the maximum defined";
$localestrings['en']['m2f913'] = "Message-multipart has an unknown secondary content-type: %s !";
$localestrings['en']['m2f914'] = "Message-multipart has an unsupported primary content-type: %s !";
$localestrings['en']['m2f950'] = "There are no forums you can subscribe to";
$localestrings['en']['m2f951'] = "Subscriptions succesfully updated";
$localestrings['en']['m2f952'] = "There are no forums to configure";
// Subscription intro message
$localestrings['en']['m2f990'] = "Mail-to-Forum is a ExiteCMS installable module which binds the content of a forum with that of a mailing list.\n
<ul>
	<li>Any posts made in a designated forum will be automatically emailed to every member of the corresponding mailing list.</li>\n
	<li>Any mail sent to the mailing list will be automatically added as posts to this forum.</li>\n
	<li>Special formatting makes sure that replies to Mail-to-Forum emails will be added to the correct thread.</li>\n
</ul>";
// M2F post error messages (used in NDR reports)
$localestrings['en']['m2f991'] = "Mail2Forum - post error message";
$localestrings['en']['m2f992'] = "Your reply with subject '%s' could not be delivered.\r\nThe forum thread you replied to does not belong to this forum.";
$localestrings['en']['m2f993'] = "Your message with subject '%s' could not be delivered.\r\nYou are not a subscribed member of this forum.";
$localestrings['en']['m2f994'] = "Your message with subject '%s' could not be delivered.\r\nThe forum you have sent this to does not exist (anymore).";
$localestrings['en']['m2f995'] = "Your message with subject '%s' could not be delivered.\r\nThe email address '%s' is not recognised as a valid member email address.";
$localestrings['en']['m2f996'] = "Some attachments in your message have not been posted to the forum.\r\nThe maximum number of attachments in a single post is ";
// General M2F process error
$localestrings['en']['m2f999'] = "Mail2Forum detected a problem. The error message is:";

$localestrings['nl'] = array();
// installation error
$localestrings['nl']['m2f110'] = "De Mail2Forum module is niet geinstalleerd. Dit moet gebeuren voordat een M2F processor wordt gestart!";
// Admin panel - forum list
$localestrings['nl']['m2f200'] = "Forum lijst";
$localestrings['nl']['m2f201'] = "Forum naam";
$localestrings['nl']['m2f202'] = "Recht op plaatsen";
$localestrings['nl']['m2f203'] = "Opties";
$localestrings['nl']['m2f204'] = "";
$localestrings['nl']['m2f205'] = "Verstuur";
$localestrings['nl']['m2f210'] = "Configureer";
$localestrings['nl']['m2f211'] = "Activeer deze configuratie";
$localestrings['nl']['m2f212'] = "Deactiveer deze configuratie";
$localestrings['nl']['m2f213'] = "Ontvangen";
$localestrings['nl']['m2f214'] = "Mail systeem";
$localestrings['nl']['m2f215'] = "Verwijder";
$localestrings['nl']['m2f216'] = "Afbreken";
$localestrings['nl']['m2f217'] = "Bekijk de inschrijverslijst";
$localestrings['nl']['m2f218'] = "Sta gebruikers to in te abonneren";
$localestrings['nl']['m2f219'] = "Abonneren uitschakelen";
// Supported mailbox types
$localestrings['nl']['m2f230'] = "SMTP/POP3";
$localestrings['nl']['m2f231'] = "SMTP/IMAP";
$localestrings['nl']['m2f232'] = "Gmail";
$localestrings['nl']['m2f233'] = "Majordomo";
// Admin panel - Edit screen
$localestrings['nl']['m2f300'] = "configuratie voor forum";
$localestrings['nl']['m2f301'] = "Forum email adres:";
$localestrings['nl']['m2f302'] = "Mailbox gebruiker:";
$localestrings['nl']['m2f303'] = "Mailbox wachtwoord:";
$localestrings['nl']['m2f304'] = "Configuratie bewaren";
$localestrings['nl']['m2f305'] = "Activeer deze configuratie:";
$localestrings['nl']['m2f306'] = "Nee";
$localestrings['nl']['m2f307'] = "Ja";
$localestrings['nl']['m2f308'] = "Limiteer inschrijven tot gebruikersgroep:";
$localestrings['nl']['m2f309'] = "Sta leden toe in te schrijven:";
$localestrings['nl']['m2f310'] = "Plaatsen via email toegestaan voor gebruikersgroep:";
// Admin panel - Subscriber list
$localestrings['nl']['m2f350'] = "Abonnees van forum";
$localestrings['nl']['m2f351'] = "Dit forum heeft geen abonees";
$localestrings['nl']['m2f352'] = "Userid";
$localestrings['nl']['m2f353'] = "Usernaam";
$localestrings['nl']['m2f354'] = "Email adres";
// Subscription screen
$localestrings['nl']['m2f400'] = "Forum naam";
$localestrings['nl']['m2f401'] = "Geabonneerd";
$localestrings['nl']['m2f402'] = "Email adres voor plaatsing";
$localestrings['nl']['m2f403'] = "Bewaar inschrijvingen";
$localestrings['nl']['m2f404'] = "Mail2Forum - Inschrijvingen";
// User configuration
$localestrings['nl']['m2f450'] = "Mail2Forum - Configuratie";
$localestrings['nl']['m2f451'] = "Ontvang HTML of platte tekst emails:";
$localestrings['nl']['m2f452'] = "Platte tekst";
$localestrings['nl']['m2f453'] = "HTML";
$localestrings['nl']['m2f454'] = "Ontvang bijlages:";
$localestrings['nl']['m2f455'] = "Negeer";
$localestrings['nl']['m2f456'] = "Als bijlage";
$localestrings['nl']['m2f457'] = "Link naar de bijlage";
$localestrings['nl']['m2f458'] = "Ontvang plaatjes als bestanden of in tekst:";
$localestrings['nl']['m2f459'] = "(alles voor HTML berichten)";
$localestrings['nl']['m2f460'] = "In de tekst";
$localestrings['nl']['m2f461'] = "Als bestanden";
$localestrings['nl']['m2f462'] = "Ontvang verkleinde plaatjes indien beschikbaar:";
$localestrings['nl']['m2f463'] = "Verkleind";
$localestrings['nl']['m2f464'] = "Volle grootte";
// M2F_SMTP processor: internal
$localestrings['nl']['m2f800'] = "First startup of the %s processor";
$localestrings['nl']['m2f801'] = "Time interval to large. Check the infusion admin module for instructions.";
$localestrings['nl']['m2f802'] = "Database error. M2F_Status contains values, but these can not be retrieved";
$localestrings['nl']['m2f803'] = "Database error. Can not find the forum forum_id from the post record points to:";
$localestrings['nl']['m2f804'] = "M2F_INTERVAL to short to process all email. Choose a larger interval. If this error persists, please contact the author";
$localestrings['nl']['m2f805'] = "Cancelled by the system administrator";
// M2F_SMTP processor: external
$localestrings['nl']['m2f811'] = "Verstuurd via ExiteCMS Mail2Forum: http://exitecms.exite.eu";
$localestrings['nl']['m2f812'] = "<a href='http://exitecms.exite.eu'>Verstuurd via ExiteCMS</a>";
$localestrings['nl']['m2f813'] = "Klik hier om naar het forum bericht te gaan";
$localestrings['nl']['m2f814'] = "* *  * opm: dit is een aanpassing van een eerder bericht * * *";
$localestrings['nl']['m2f815'] = "schreef";
// M2F_POP3 processor
// Error messages
$localestrings['nl']['m2f900'] = "Forum kan niet worden geactiveerd . Kies eerst [".$localestrings['nl']['m2f210']."] om een configuratie te maken";
$localestrings['nl']['m2f901'] = "Email adres moet worden ingevuld";
$localestrings['nl']['m2f902'] = "POP3 usernaam moet worden ingevuld";
$localestrings['nl']['m2f903'] = "POP3 wachtwoord moet worden ingevuld";
$localestrings['nl']['m2f904'] = "Configuratie is opgeslagen";
$localestrings['nl']['m2f905'] = "U staat op het punt de configuration voor forum '%s' te verwijderen. Weet u dat zeker?<br><br>opm: dit verwijderd ook de inschrijvingen van alle abonees!";
$localestrings['nl']['m2f906'] = "ERROR! From: %s - To: %s -> %s";
$localestrings['nl']['m2f907'] = "SQL Error: %s of table '%s' failed!";
$localestrings['nl']['m2f908'] = "Maximum number of attachments reached";
$localestrings['nl']['m2f909'] = "Added attachment %s to post #%s";
$localestrings['nl']['m2f910'] = "Attachment '%s' can not be stored on disk";
$localestrings['nl']['m2f911'] = "Attachment '%s' has an illegal extension or extension doesn't match contents";
$localestrings['nl']['m2f912'] = "Attachment '%s' has an illegal filename or it's size exceeded the maximum defined";
$localestrings['nl']['m2f913'] = "Message-multipart has an unknown secondary content-type: %s !";
$localestrings['nl']['m2f914'] = "Message-multipart has an unsupported primary content-type: %s !";
$localestrings['nl']['m2f950'] = "Er zijn geen forums om u op in te schrijven.";
$localestrings['nl']['m2f951'] = "Inschrijvingen succesvol bijgewerkt";
$localestrings['nl']['m2f952'] = "Er zijn geen forums om te configureren";
// Subscription intro message
$localestrings['nl']['m2f990'] = "Mail2Forum is een optioneel installeerbare module voor ExiteCMS, waarbij een connectie gemaakt wordt tussen een webgebaseerd forum en een email mailing lijst.\n
<ul>
	<li>Elk bericht geplaatst in een van de forums zal automatisch per email worden verstuurd naar alle ingeschreven abonees van de mailing lijst voor dat forum.</li>\n
	<li>Alle email gestuurd aan de mailing lijst zal automatisch als nieuw bericht worden geplaatst in het bijbehorende forum.</li>\n
	<li>Speciale formattering zorgt er voor dat antwoorden op Mail2Forum berichten automatisch aan het juiste topic worden toegevoegd.</li>\n
</ul>";
// M2F post error messages (used in NDR reports)
$localestrings['nl']['m2f991'] = "Mail2Forum - post error message";
$localestrings['nl']['m2f992'] = "Your reply with subject '%s' could not be delivered.\r\nThe forum thread you replied to does not belong to this forum.";
$localestrings['nl']['m2f993'] = "Your message with subject '%s' could not be delivered.\r\nYou are not a subscribed member of this forum.";
$localestrings['nl']['m2f994'] = "Your message with subject '%s' could not be delivered.\r\nThe forum you have sent this to does not exist (anymore).";
$localestrings['nl']['m2f995'] = "Your message with subject '%s' could not be delivered.\r\nThe email address '%s' is not recognised as a valid member email address.";
$localestrings['nl']['m2f996'] = "Some attachments in your message have not been posted to the forum.\r\nThe maximum number of attachments in a single post is ";
// General M2F process error
$localestrings['nl']['m2f999'] = "Mail2Forum detected a problem. The error message is:";

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

		global $db_prefix, $locale;

		switch($current_version) {
			case "0.0.1":
				// pre-release version, no database or other changes
			case "1.0.0":
				// ExiteCMS v7.0. no upgrade actions for this release
			case "1.0.1":
				$result = dbquery("ALTER TABLE ".$db_prefix."M2F_config CHANGE m2f_userid m2f_userid MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0'");
				$result = dbquery("ALTER TABLE ".$db_prefix."M2F_subscriptions CHANGE m2f_userid m2f_userid MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0'");
				global $mod_title, $mod_folder, $mod_admin_panel;
				$result = dbquery("UPDATE ".$db_prefix."admin SET admin_link = '".(MODULES.$mod_folder."/".$mod_admin_panel)."' WHERE admin_title = '".$mod_title."'");
			case "1.1.0":
				// upgrade to ExiteCMS v7.1. no upgrade actions for this release
			default:
				// do this at every upgrade
		}
	}
}
?>