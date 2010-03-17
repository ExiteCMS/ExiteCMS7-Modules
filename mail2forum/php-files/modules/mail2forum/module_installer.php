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
| $Id::                                                               $|
+----------------------------------------------------------------------+
| Last modified by $Author::                                          $|
| Revision number $Rev::                                              $|
+---------------------------------------------------------------------*/
if (!checkrights("I") || !defined("iAUTH") || $aid != iAUTH || !defined('INIT_CMS_OK')) fallback(BASEDIR."index.php");

/*---------------------------------------------------+
| Module identification                              |
+----------------------------------------------------*/
$mod_title = "Mail2Forum";
$mod_description = "Mail2Forum implements an interface between the mail and the web world. Posted messages are emailed to subscribers, their replies are posted on the forum on their behalf";
$mod_version = "1.1.2";
$mod_developer = "WanWizard";
$mod_email = "wanwizard@exitecms.org";
$mod_weburl = "http://www.exitecms.org/";
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
$mod_site_links[] = array('name' => "Subscriptions", 'url' => 'm2f_subscriptions.php', 'panel' => '', 'visibility' => 102);

/*---------------------------------------------------+
| locale strings for this module                     |
+----------------------------------------------------*/

$localestrings = array();

$localestrings['en'] = array();
$localestrings['en']['m2f100'] = "Mail2Forum";
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
// Mail2forum configuration
$localestrings['en']['m2f500'] = "Mail2Forum - Configuration";
$localestrings['en']['m2f501'] = "Save configuration";
$localestrings['en']['m2f502'] = "Forum host name:";
$localestrings['en']['m2f502a'] = "This hostname is used in the footer of email sent out, to link back to your website";
$localestrings['en']['m2f503'] = "Polling interval (seconds):";
$localestrings['en']['m2f503a'] = "Polling interval for the cron processors. Note that this is not the wait time. If set to 5 minutes, and a cycle takes 1 minute and 20 seconds, the processor sleeps for 3 minutes and 40 seconds. If the processors needs more time to process than the interval specified here, a warning will be written to the logfile.";
$localestrings['en']['m2f504'] = "Poll threshold value:";
$localestrings['en']['m2f504a'] = "If the last poll happened more than this number of seconds ago, the processors (that use this value) refuse to run, and die with an error message. This is to prevent sending out thousands of emails after undetected downtime of the processor. Press 'Reset' before restarting the processors";
$localestrings['en']['m2f505'] = "Reset poll timer";
$localestrings['en']['m2f506'] = "Maximum number of attachments:";
$localestrings['en']['m2f506a'] = "If a message contains more attachments, the remainder are skipped and not imported into the forum. If 'SEND_NDR' is set to 'Yes', the sender will be notified";
$localestrings['en']['m2f507'] = "Attachment maximum size:";
$localestrings['en']['m2f507a'] = "Attachments bigger that the size defined here will never be send out via email, only a link will be included to the attachment in the forum";
$localestrings['en']['m2f508'] = "Use mailing list address:";
$localestrings['en']['m2f508a'] = "With this switch you control the from address of outgoing email. The default behaviour is to use the email address from the poster, as defined in the members profile. If the member has elected to hide his email address from other member (the 'hide email' option set to 'Yes'), the from is composed of the Nick of the the poster, and the forum email address as defined in Mail2Forum. When you set this switch to true, email always goes out using the forum email address, regardless of the member setting. This can make it easier for users to define mail filters in their client software";
$localestrings['en']['m2f509'] = "Follow moved thread:";
$localestrings['en']['m2f509a'] = "Allow Mail2Forum posts to a thread, even if it has moved to another forum. This makes sure replies to a thread will be processed, even if the thread has been moved to a different forum by a moderator or administrator. CAUTION: activating this could be a risk, as it allows posting to forums the poster doesn't have access to!";
$localestrings['en']['m2f510'] = "Subscribers only:";
$localestrings['en']['m2f510a'] = "Allow every member that has post access to the forum, also post by email. If this switch is set to 'Yes', only members that have a subscription on this forum will be allowed to post/ new messages using email";
$localestrings['en']['m2f511'] = "Send non-deliveries back:";
$localestrings['en']['m2f511a'] = "Send a non-delivery report back to the poster in case an incomming message can not be processed. NDR's are only send to verified email accounts, email from unknown accounts (SPAM) will be deleted";
$localestrings['en']['m2f512'] = "POP3 server:";
$localestrings['en']['m2f512a'] = "Address of the POP3 mailserver you are going to use to receive email. For performance reasons, specify an IP address, and not a hostname.";
$localestrings['en']['m2f513'] = "POP3 server port:";
$localestrings['en']['m2f513a'] = "TCP port number the POP3 server listens on. Default is 110 (the standard POP3 port)";
$localestrings['en']['m2f514'] = "POP3 server timeout:";
$localestrings['en']['m2f514a'] = "Timeout used for socket communications. Specify any value between 2 and 25 seconds. Default is 25 seconds";
$localestrings['en']['m2f515'] = "Logfile location:";
$localestrings['en']['m2f515a'] = "Default, logfiles will be stored in the directory 'logs' which is a subdirectory of the mail2forum module directory. All logfiles start with 'M2F_', the exact filename depends on the processor and the type of log. Note: Do NOT add a trailing slash to the pathname!!";
$localestrings['en']['m2f516'] = "Activate processor logging:";
$localestrings['en']['m2f516a'] = "When set to 'Yes', a process log file will be used by all Mail2Forum processor modules, so the state and activity can be tracked";
$localestrings['en']['m2f517'] = "Activate SMTP processor logging:";
$localestrings['en']['m2f517a'] = "When set to 'Yes', additional SMTP logging will be performed by the SMTP processor, so the interaction with the SMTP server can be monitored closely. Note, this can generate a BIG logfile on a busy system, use this for debugging purposes only";
$localestrings['en']['m2f518'] = "Activate POP3 processor logging:";
$localestrings['en']['m2f518a'] = "When set to 'Yes', additional POP3 logging will be performed by the POP3 processor, so the internal POP3 data structures can be monitored closely. Note, this can generate a BIG logfile on a busy system, use this for debugging purposes only";
$localestrings['en']['m2f519'] = "Activate POP3 message logging:";
$localestrings['en']['m2f519a'] = "When set to 'Yes', debugging of POP3 message processing is activated. This logs the raw information from MimeDecode, and the extracted message. This makes it easier to debug MIME decoding errors. Note, this can generate a BIG logfile on a busy system, use this for debugging purposes only";
$localestrings['en']['m2f520'] = "Activate SMTP processor debugging:";
$localestrings['en']['m2f520a'] = "When set to 'Yes', additional STMP debugging will be activated, so the internal SMTP data structures can be monitored closely. Note, this can generate a BIG logfile on a busy system, use this for debugging purposes only";
$localestrings['en']['m2f521'] = "The poll counter has been reset. You can restart the batch programs to collect and send email.";
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
$localestrings['nl']['m2f100'] = "Mail2Forum";
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
$localestrings['nl']['m2f301'] = "Adres verzendlijst:";
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
// Mail2forum configuration
$localestrings['nl']['m2f500'] = "Mail2Forum - Configuratie";
$localestrings['nl']['m2f501'] = "Configuration opslaan";
$localestrings['nl']['m2f502'] = "Forum hostnaam:";
$localestrings['nl']['m2f502a'] = "Deze naam wordt gebruikt in de voettekst van de email, om terug naar de website te linken";
$localestrings['nl']['m2f503'] = "Polling interval (seconden):";
$localestrings['nl']['m2f503a'] = "Polling interval voor de cron processors. Dit is niet de wachttijd. Indien ingesteld op 5 minuten, en een cyclus duurt 1 mimuut en 20 seconden, zal de processor slapen voor 3 minuten en 40 seconden. Als de processor meer tijd nodig heeft voor de verwerking dat dit interval, zal er een melding naar de log worden geschreven.";
$localestrings['nl']['m2f504'] = "Poll threshold waarde:";
$localestrings['nl']['m2f504a'] = "Indien de laatste poll meer dat dit aantal seconden geleden is gebeurd, zullen de processors weigeren te starten, en stoppen met een foutmelding. Dit is om er voor te zorgen dat er geen duizenden email worden verstuurd na lange downtijd van de processor. Druk op 'Reset' voor het herstarten van de processors";
$localestrings['nl']['m2f505'] = "Reset poll timer";
$localestrings['nl']['m2f506'] = "Maximum aantal bijlagen:";
$localestrings['nl']['m2f506a'] = "Indien een inkomend bericht meer bijlagen bevat, zullen de resterende worden overgeslagen. Indien 'non-delivery' op 'Ja' staat, zal de verzender worden geinformeerd";
$localestrings['nl']['m2f507'] = "Maximale bijlage grootte:";
$localestrings['nl']['m2f507a'] = "Bijlagen die groter zijn dat deze waarde zullen nooit via email worden uitgestuurd, maar er zal een link in het bericht geplaatst worden naar de bijlage in het forum";
$localestrings['nl']['m2f508'] = "Gebruik verzendlijst adres:";
$localestrings['nl']['m2f508a'] = "Hiermee kunt u het adres voor uitgaande email instellen. Standaard wordt het eigen email adres van de auteur van het bericht gebruikt. Als de gebruiker in zijn profiel gekozen heeft voor 'email adres verbergen', zal als afzender van de email het verzendlijst adres worden gebruikt. Als u deze optie op 'Ja' zet, zal dit altijd het geval zijn, en wordt de gebruikersinstelling genegeerd. Dit kan handig zijn om forum email te kunnen filteren in een email client";
$localestrings['nl']['m2f509'] = "Volg verplaatst topic:";
$localestrings['nl']['m2f509a'] = "Hiermee kunt u Mail2Forum toestaan om een inkomende mail te accepteren als deze is verplaatst naar een ander forum. Hierdoor komen antwoorden altijd aan, ook na verplaatsing. LET OP: dit kan een risico in houden, omdat een abonee hiemee berichten kan plaatsen in een forum waartoe deze geen toegang heeft!";
$localestrings['nl']['m2f510'] = "Alleen voor abonees:";
$localestrings['nl']['m2f510a'] = "Standaard hebben alle leden met toegang tot een forum ook het recht berichten naar de verzendlijst te sturen. Als u dit op 'Ja' zet is men verplicht zich te abonneren.";
$localestrings['nl']['m2f511'] = "Stuur non-deliveries terug:";
$localestrings['nl']['m2f511a'] = "Stuur een non-delivery rapport terug naar de verzender indien een ingekomen email niet kan worden verwerkt. Deze rapporten zullen alleen worden verstuurd naar gekende email adressen, email van onbekende adressen (SPAM?) zal worden verwijderd zonder antwoord";
$localestrings['nl']['m2f512'] = "POP3 server:";
$localestrings['nl']['m2f512a'] = "Adres van de POP3 mail server die gebruikt gaat worden voor het ontvangen van email van de verzendlijst. Voor performance redenen, speficieer een IP adres, en geen hostname.";
$localestrings['nl']['m2f513'] = "POP3 server poort:";
$localestrings['nl']['m2f513a'] = "TCP poort nummer waarop de POP3 server luistert. Standaard is dit poort 110 (de standaard POP3 poort)";
$localestrings['nl']['m2f514'] = "POP3 server timeout:";
$localestrings['nl']['m2f514a'] = "Timeout voor TCP socket communicatie. Specifeer een waarde tussen 2 en 25 seconden. De standaard waarde is 25 seconden";
$localestrings['nl']['m2f515'] = "Logfile locatie:";
$localestrings['nl']['m2f515a'] = "Standaard worden de logfiles opgeslagen in de directory 'logs', een subdirectory van de mail2forum module directory. Alle logfiles beginnen met 'M2F_', de exacte bestandsnaam hangt af van de processor en het type van log . Opm: Geen slash toevoegen aan het einde van de padnaam!!";
$localestrings['nl']['m2f516'] = "Activeer processor logging:";
$localestrings['nl']['m2f516a'] = "Indien geactiveerd zal er een proces log file worden gebruikt door alle Mail2Forum processor modules, zodat de status en activiteit kan worden gemonitord";
$localestrings['nl']['m2f517'] = "Activeer SMTP processor logging:";
$localestrings['nl']['m2f517a'] = "Indien geactiveerd zal er additionele logging worden aangemaakt door de SMTP processor, waardoor de interactie met de SMTP server kan worden gemonitored. Opm, dit kan zorgen voor een GROTE logfile op een druk systeem, gebruik dit alleen voor debugging";
$localestrings['nl']['m2f518'] = "Activeer POP3 processor logging:";
$localestrings['nl']['m2f518a'] = "Indien geactiveerd zal er additionele logging worden aangemaakt door de POP3 processor, waardoor de interactie met de POP3 server kan worden gemonitored. Opm, dit kan zorgen voor een GROTE logfile op een druk systeem, gebruik dit alleen voor debugging";
$localestrings['nl']['m2f519'] = "Activeer POP3 message logging:";
$localestrings['nl']['m2f519a'] = "Indien geactiveerd zal er additionele loggin worden aangemaakt van het POP3 berichtenverwerkingsproces. In een logfile per bericht kunnen de details van de MimeDecode en het resultaat van de verwerking worden bekeken. Opm, dit kan zorgen voor veel logfiles op een druk systeem, gebruik dit alleen voor debugging";
$localestrings['nl']['m2f520'] = "Activeer SMTP processor debugging:";
$localestrings['nl']['m2f520a'] = "Indien geactiveerd zal er additionele loggin worden aangemaakt van het SMTP berichtenverwerkingsproces. Opm, dit kan zorgen voor een GROTE logfile op een druk systeem, gebruik dit alleen voor debugging";
$localestrings['nl']['m2f521'] = "De poll time is gereset. U kunt nu de achtergrond programma's voor het zenden en ontvangen van email weer starten.";
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

// M2F_config: user configuration table
$mod_install_cmds[] = array('type' => 'db', 'value' => "CREATE TABLE ##PREFIX##M2F_config (
  m2f_userid mediumint(8) unsigned NOT NULL default '0',
  m2f_html tinyint(1) unsigned NOT NULL default '0',
  m2f_attach tinyint(1) unsigned NOT NULL default '0',
  m2f_inline tinyint(1) unsigned NOT NULL default '0',
  m2f_thumbnail tinyint(1) unsigned NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

// M2F_subscriptions: user subscription table
$mod_install_cmds[] = array('type' => 'db', 'value' => "CREATE TABLE ##PREFIX##M2F_subscriptions (
  m2f_subid smallint(5) unsigned NOT NULL auto_increment,
  m2f_forumid smallint(5) unsigned NOT NULL default '0',
  m2f_userid mediumint(8) unsigned NOT NULL default '0',
  m2f_subscribed tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (m2f_subid)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

// M2F configuration items
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##configuration (cfg_name, cfg_value) VALUES ('m2f_host', 'www.example.com')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##configuration (cfg_name, cfg_value) VALUES ('m2f_interval', '300')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##configuration (cfg_name, cfg_value) VALUES ('m2f_poll_threshold', '604800')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##configuration (cfg_name, cfg_value) VALUES ('m2f_lastpoll', '".time()."')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##configuration (cfg_name, cfg_value) VALUES ('m2f_max_attachments', '1')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##configuration (cfg_name, cfg_value) VALUES ('m2f_max_attach_size', '5242880')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##configuration (cfg_name, cfg_value) VALUES ('m2f_use_forum_email', '1')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##configuration (cfg_name, cfg_value) VALUES ('m2f_follow_thread', '0')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##configuration (cfg_name, cfg_value) VALUES ('m2f_subscribe_required', '1')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##configuration (cfg_name, cfg_value) VALUES ('m2f_send_ndr', '0')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##configuration (cfg_name, cfg_value) VALUES ('m2f_pop3_server', '127.0.0.1')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##configuration (cfg_name, cfg_value) VALUES ('m2f_pop3_port', '110')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##configuration (cfg_name, cfg_value) VALUES ('m2f_pop3_timeout', '25')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##configuration (cfg_name, cfg_value) VALUES ('m2f_logfile', 'logs')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##configuration (cfg_name, cfg_value) VALUES ('m2f_process_log', '1')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##configuration (cfg_name, cfg_value) VALUES ('m2f_smtp_log', '0')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##configuration (cfg_name, cfg_value) VALUES ('m2f_pop3_debug', '0')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##configuration (cfg_name, cfg_value) VALUES ('m2f_pop3_message_debug', '0')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##configuration (cfg_name, cfg_value) VALUES ('m2f_smtp_debug', '0')");

/*---------------------------------------------------+
| commands to execute when uninstalling this module  |
+----------------------------------------------------*/

$mod_uninstall_cmds = array();							// commands to execute when uninstalling this module

// remove the M2F tables
$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DROP TABLE ##PREFIX##M2F_config");
$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DROP TABLE ##PREFIX##M2F_forums");
$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DROP TABLE ##PREFIX##M2F_subscriptions");

// remove the M2F configuration
$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DELETE FROM ##PREFIX##configuration WHERE cfg_name LIKE 'm2f_%'");
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
				// larger index pointers
				$result = dbquery("ALTER TABLE ".$db_prefix."M2F_config CHANGE m2f_userid m2f_userid MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0'");
				$result = dbquery("ALTER TABLE ".$db_prefix."M2F_subscriptions CHANGE m2f_userid m2f_userid MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0'");
				// update the admin link
				global $mod_title, $mod_folder, $mod_admin_panel;
				$result = dbquery("UPDATE ".$db_prefix."admin SET admin_link = '".(MODULES.$mod_folder."/".$mod_admin_panel)."' WHERE admin_title = '".$mod_title."'");
				// import the config file, and (try to) delete it. if it doesn't exist, use default values
				if (file_exists(PATH_MODULES.$mod_folder."/m2f_config.php")) {
					require PATH_MODULES.$mod_folder."/m2f_config.php";
				} else {
					define('M2F_HOST', "www.example.com");
					define('M2F_INTERVAL', 5*60);	// 5 minutes
					define('M2F_POLL_THRESHOLD', 7*24*60*60);	// one week
					define('M2F_MAX_ATTACHMENTS', 1);
					define('M2F_MAX_ATTACH_SIZE', 5242880);
					define('M2F_USE_FORUM_EMAIL', true);
					define('M2F_FOLLOW_THREAD', false);
					define('M2F_SUBSCRIBE_REQUIRED', false);
					define('M2F_SEND_NDR', true);
					define('M2F_POP3_SERVER', '127.0.0.1');
					define('M2F_POP3_PORT', 110);
					define('M2F_POP3_TIMEOUT', 25);
					define('M2F_LOGFILE', "logs");
					define('M2F_PROCESS_LOG', true);
					define('M2F_SMTP_LOG', false);
					define('M2F_POP3_DEBUG', false);
					define('M2F_POP3_MESSAGE_DEBUG', false);
					define('M2F_SMTP_DEBUG', false);
				}
				if (defined("M2F_HOST")) $result = dbquery("INSERT INTO ".$db_prefix."configuration (cfg_name, cfg_value) VALUES ('m2f_host', '".M2F_HOST."')");
				if (defined("M2F_INTERVAL")) $result = dbquery("INSERT INTO ".$db_prefix."configuration (cfg_name, cfg_value) VALUES ('m2f_interval', '".M2F_INTERVAL."')");
				if (defined("M2F_POLL_THRESHOLD")) $result = dbquery("INSERT INTO ".$db_prefix."configuration (cfg_name, cfg_value) VALUES ('m2f_poll_threshold', '".M2F_POLL_THRESHOLD."')");
				if (defined("M2F_MAX_ATTACHMENTS")) $result = dbquery("INSERT INTO ".$db_prefix."configuration (cfg_name, cfg_value) VALUES ('m2f_max_attachments', '".M2F_MAX_ATTACHMENTS."')");
				if (defined("M2F_MAX_ATTACH_SIZE")) $result = dbquery("INSERT INTO ".$db_prefix."configuration (cfg_name, cfg_value) VALUES ('m2f_max_attach_size', '".M2F_MAX_ATTACH_SIZE."')");
				if (defined("M2F_USE_FORUM_EMAIL")) $result = dbquery("INSERT INTO ".$db_prefix."configuration (cfg_name, cfg_value) VALUES ('m2f_use_forum_email', '".(M2F_USE_FORUM_EMAIL?"1":"0")."')");
				if (defined("M2F_FOLLOW_THREAD")) $result = dbquery("INSERT INTO ".$db_prefix."configuration (cfg_name, cfg_value) VALUES ('m2f_follow_thread', '".(M2F_FOLLOW_THREAD?"1":"0")."')");
				if (defined("M2F_SUBSCRIBE_REQUIRED")) $result = dbquery("INSERT INTO ".$db_prefix."configuration (cfg_name, cfg_value) VALUES ('m2f_subscribe_required', '".(M2F_SUBSCRIBE_REQUIRED?"1":"0")."')");
				if (defined("M2F_SEND_NDR")) $result = dbquery("INSERT INTO ".$db_prefix."configuration (cfg_name, cfg_value) VALUES ('m2f_send_ndr', '".(M2F_SEND_NDR?"1":"0")."')");
				if (defined("M2F_POP3_SERVER")) $result = dbquery("INSERT INTO ".$db_prefix."configuration (cfg_name, cfg_value) VALUES ('m2f_pop3_server', '".M2F_POP3_SERVER."')");
				if (defined("M2F_POP3_PORT")) $result = dbquery("INSERT INTO ".$db_prefix."configuration (cfg_name, cfg_value) VALUES ('m2f_pop3_port', '".M2F_POP3_PORT."')");
				if (defined("M2F_POP3_TIMEOUT")) $result = dbquery("INSERT INTO ".$db_prefix."configuration (cfg_name, cfg_value) VALUES ('m2f_pop3_timeout', '".M2F_POP3_TIMEOUT."')");
				if (defined("M2F_LOGFILE")) $result = dbquery("INSERT INTO ".$db_prefix."configuration (cfg_name, cfg_value) VALUES ('m2f_logfile', '".M2F_LOGFILE."')");
				if (defined("M2F_PROCESS_LOG")) $result = dbquery("INSERT INTO ".$db_prefix."configuration (cfg_name, cfg_value) VALUES ('m2f_process_log', '".(M2F_PROCESS_LOG?"1":"0")."')");
				if (defined("M2F_SMTP_LOG")) $result = dbquery("INSERT INTO ".$db_prefix."configuration (cfg_name, cfg_value) VALUES ('m2f_smtp_log', '".(M2F_SMTP_LOG?"1":"0")."')");
				if (defined("M2F_POP3_DEBUG")) $result = dbquery("INSERT INTO ".$db_prefix."configuration (cfg_name, cfg_value) VALUES ('m2f_pop3_debug', '".(M2F_POP3_DEBUG?"1":"0")."')");
				if (defined("M2F_POP3_MESSAGE_DEBUG")) $result = dbquery("INSERT INTO ".$db_prefix."configuration (cfg_name, cfg_value) VALUES ('m2f_pop3_message_debug', '".(M2F_POP3_MESSAGE_DEBUG?"1":"0")."')");
				if (defined("M2F_SMTP_DEBUG")) $result = dbquery("INSERT INTO ".$db_prefix."configuration (cfg_name, cfg_value) VALUES ('m2f_smtp_debug', '".(M2F_SMTP_DEBUG?"1":"0")."')");
				@unlink(PATH_MODULES.$mod_folder."/m2f_config.php");
			case "1.1.0":
				// ExiteCMS v7.1. Remove the M2F_status table
				$result = dbquery("SELECT * FROM ".$db_prefix."M2F_status");
				if (dbrows($result)) {
					$data = dbarray($result);
					$result = dbquery("INSERT INTO ".$db_prefix."configuration (cfg_name, cfg_value) VALUES ('m2f_last_polled', '".$data['m2f_lastpoll']."')");
					$result = dbquery("DROP TABLE ".$db_prefix."M2F_status");
				}
				case "1.1.1":
				// Current version
			default:
				// do this at every upgrade
		}
	}
}
?>
