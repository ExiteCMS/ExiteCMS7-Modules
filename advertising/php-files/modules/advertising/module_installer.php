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
$mod_title = "Advertisements";							// title or name of this module
$mod_description = "Advertisement image management";	// short description of it's purpose
$mod_version = "1.1.1";									// module version number
$mod_developer = "WanWizard";							// author's name
$mod_email = "wanwizard@gmail.com";
$mod_weburl = "http://exitecms.exite.eu/";
$mod_type = "M";

/*---------------------------------------------------+
| Module administration panel installation details   |
+----------------------------------------------------*/

$mod_folder = "advertising";							// sub-folder of the /modules folder
$mod_admin_image = "advertising.gif";					// icon to be used for the admin panel
$mod_admin_panel = "advertising_admin.php";				// name of the admin panel for this module
$mod_admin_rights = "wE";								// admin rights code. This HAS to be assigned by ExiteCMS to avoid duplicates!
$mod_admin_page = 1;									// admin page this panel has to be placed on

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
$mod_site_links[] = array('name' => $mod_title, 'url' => 'advertising.php', 'panel' => '', 'visibility' => 100);

/*---------------------------------------------------+
| locale strings for this module                     |
+----------------------------------------------------*/
$localestrings = array();
$localestrings['en'] = array();
// panel titles
$localestrings['en']['ads400'] = "Add an advertisement";
$localestrings['en']['ads401'] = "Edit an advertisement";
$localestrings['en']['ads402'] = "Advertisements";
$localestrings['en']['ads403'] = "Expired advertisements";
$localestrings['en']['ads404'] = "Advertising client";
$localestrings['en']['ads405'] = "Upload an advertisement image";
$localestrings['en']['ads406'] = "Advertisement image management";
$localestrings['en']['ads407'] = "Advertisement image preview";
$localestrings['en']['ads408'] = " for client ";
$localestrings['en']['ads409'] = "Please visit our sponsor";
// add - edit advertisement
$localestrings['en']['ads410'] = "Client name";
$localestrings['en']['ads411'] = "Contract based on";
$localestrings['en']['ads412'] = "Contract start date";
$localestrings['en']['ads413'] = "Contract end date";
$localestrings['en']['ads414'] = "Ads currently purchased";
$localestrings['en']['ads415'] = "Modify purchased amount";
$localestrings['en']['ads416'] = "Ad location";
$localestrings['en']['ads417'] = "Ad image";
$localestrings['en']['ads418'] = "Advert click URL";
$localestrings['en']['ads419'] = "Enable this advert";
$localestrings['en']['ads420'] = "Increase by";
$localestrings['en']['ads421'] = "Decrease by";
$localestrings['en']['ads422'] = "No";
$localestrings['en']['ads423'] = "Yes";
$localestrings['en']['ads424'] = "Advert priority";
$localestrings['en']['ads425'] = "Move to a new client";
// contract information
$localestrings['en']['ads430'] = "Open ended period";
$localestrings['en']['ads431'] = "Fixed time period";
$localestrings['en']['ads432'] = "Number of displays";
// buttons
$localestrings['en']['ads440'] = "Save";
$localestrings['en']['ads441'] = "Back";
$localestrings['en']['ads442'] = "Expire";
$localestrings['en']['ads443'] = "Activate";
$localestrings['en']['ads444'] = "Change URL";
$localestrings['en']['ads445'] = "Email statistics";
$localestrings['en']['ads446'] = "Email All statistics";
$localestrings['en']['ads447'] = "Add a new client";
$localestrings['en']['ads448'] = "Advert image management";
$localestrings['en']['ads449'] = "Upload image";
// advertisement location and type. 
$localestrings['en']['ads450'] = "Logo - left side panel";			// location = 0
$localestrings['en']['ads451'] = "Banner - Forum, on top";			// location = 1
$localestrings['en']['ads452'] = "Banner - Forum index only";		// location = 2
$localestrings['en']['ads453'] = "Banner - Thread index only";		// location = 3
$localestrings['en']['ads454'] = "Banner - Forum, at the bottom";	// location = 4
$localestrings['en']['ads455'] = "Banner - Forum, top and bottom";	// location = 5
// current - finished advertisement
$localestrings['en']['ads460'] = "ID";
$localestrings['en']['ads461'] = "Client name";
$localestrings['en']['ads462'] = "Advertisment type";
$localestrings['en']['ads463'] = "Contract information";
$localestrings['en']['ads464'] = "Clicks";
$localestrings['en']['ads465'] = "Clicks %";
$localestrings['en']['ads466'] = "Options";
$localestrings['en']['ads467'] = "Enable";
$localestrings['en']['ads468'] = "Disable";
$localestrings['en']['ads469'] = "Edit";
$localestrings['en']['ads470'] = "Delete";
$localestrings['en']['ads471'] = "ends";
$localestrings['en']['ads472'] = "starts";
$localestrings['en']['ads473'] = "ended";
$localestrings['en']['ads474'] = "Advertisements";
$localestrings['en']['ads475'] = "Contact email";
$localestrings['en']['ads476'] = "Remove this client";
$localestrings['en']['ads477'] = "left";
$localestrings['en']['ads478'] = "";
$localestrings['en']['ads479'] = "Displayed";
// advertising statistics
$localestrings['en']['ads500'] = "Advertising Statistics";
$localestrings['en']['ads501'] = "Prio";
$localestrings['en']['ads502'] = "Guest";
// client information - email messages
$localestrings['en']['ads510'] = "Following are the complete stats for all your advertising investments at ".$settings['sitename'].":";
$localestrings['en']['ads511'] = "Following are the complete stats for your advertising investment with ID %s at ".$settings['sitename'].":";
$localestrings['en']['ads512'] = "Statistics report generated on %s\r\n\r\n";
$localestrings['en']['ads513'] = "Ads still available";
// advertisement - image upload
$localestrings['en']['ads530'] = "Image filename";
// advertisement - image management
$localestrings['en']['ads540'] = "View";
$localestrings['en']['ads541'] = "Delete";
$localestrings['en']['ads542'] = "Dimensions";
$localestrings['en']['ads543'] = "Options";
$localestrings['en']['ads544'] = "Used";
// messages
$localestrings['en']['ads900'] = "The following errors are detected while validating your input:";
$localestrings['en']['ads901'] = "The requested advertisement can not be found in the database.";
$localestrings['en']['ads902'] = "The advertisement has been deleted.";
$localestrings['en']['ads903'] = "The amount purchased must be numeric.";
$localestrings['en']['ads904'] = "The total amount sold to this client can not be negative.";
$localestrings['en']['ads905'] = "Are you sure you want to delete this?";
$localestrings['en']['ads906'] = "The advertisement is succesfully added.";
$localestrings['en']['ads907'] = "The advertisement is succesfully updated.";
$localestrings['en']['ads908'] = "This client doesn't have any active advertisements.";
$localestrings['en']['ads909'] = "You are about to remove '%s' as an advertising client.<br />This also removes all advertisements, and any images that belong to his client!<br /><br />Are you sure?";
$localestrings['en']['ads910'] = "This client and all the clients advertisements have been removed.";
$localestrings['en']['ads911'] = "This client doesn't have any expired advertisements.";
$localestrings['en']['ads912'] = "The selected image is to big for the selected location.<br />The maximum size for this location is %s, the image selected is %s.";
$localestrings['en']['ads913'] = "Advertisement with ID %s has been enabled.";
$localestrings['en']['ads914'] = "Advertisement with ID %s has been disabled.";
// messages - moving an advert to a new client
$localestrings['en']['ads920'] = "Advertisement succesfully moved from %s to %s.";
$localestrings['en']['ads921'] = "The selected Advertisement can not be found.";
$localestrings['en']['ads922'] = "Invalid Advertisement ID passed. Is this a hacking attempt?";
$localestrings['en']['ads923'] = "The selected new Client record can not be found.";
$localestrings['en']['ads924'] = "Invalid client ID passed. Is this a hacking attempt?";
// messages - advertising statistics
$localestrings['en']['ads950'] = "%s, You do not appear to be an advertising client.<br /><br />Please <a href='/contact.php'>contact us</a> for more information on becoming a client.";
$localestrings['en']['ads951'] = "The URL for the advertisement with ID %s has been updated.";
$localestrings['en']['ads952'] = "Detailed statistics for the advertisement with ID %s have been emailed to you.";
$localestrings['en']['ads953'] = "Detailed statistics for all your advertisements have been emailed to you.";
$localestrings['en']['ads954'] = "%s, There are no advertisements defined for you in this category.";
$localestrings['en']['ads955'] = "Please <a href='/contact.php'>contact us</a> if you feel this is not correct.";
// messages - image uploading
$localestrings['en']['ads960'] = "Upload file does not have an approved file extension (.jpg, .gif or .png)!";
$localestrings['en']['ads961'] = "Upload file is not a valid image!";
$localestrings['en']['ads962'] = "Hacking attempt! This is not an uploaded file!";
// messages - image management
$localestrings['en']['ads970'] = "There are no uploaded advertisement images";
$localestrings['en']['ads971'] = "The advertisement image has been deleted.";

$localestrings['nl'] = array();
// panel titles
$localestrings['nl']['ads400'] = "Advertentie toevoegen";
$localestrings['nl']['ads401'] = "Advertentie wijzigen";
$localestrings['nl']['ads402'] = "Advertenties";
$localestrings['nl']['ads403'] = "Verlopen advertenties";
$localestrings['nl']['ads404'] = "Adverteerder";
$localestrings['nl']['ads405'] = "Advertentie plaatje uploaden";
$localestrings['nl']['ads406'] = "Beheer van advertentie plaatjes";
$localestrings['nl']['ads407'] = "Bekijk advertentie plaatje";
$localestrings['nl']['ads408'] = " van adverteerder ";
$localestrings['nl']['ads409'] = "Bezoek onze sponsor";
// add - edit advertisement
$localestrings['nl']['ads410'] = "Klant naam";
$localestrings['nl']['ads411'] = "Contract gebaseerd op";
$localestrings['nl']['ads412'] = "Contract start datum";
$localestrings['nl']['ads413'] = "Contract eind datum";
$localestrings['nl']['ads414'] = "Advertenties aangekocht";
$localestrings['nl']['ads415'] = "Wijzig gekocht aantal";
$localestrings['nl']['ads416'] = "Ad locatie";
$localestrings['nl']['ads417'] = "Ad plaatje";
$localestrings['nl']['ads418'] = "Advertentie URL";
$localestrings['nl']['ads419'] = "Activeer deze advertentie";
$localestrings['nl']['ads420'] = "Verhogen met";
$localestrings['nl']['ads421'] = "Verlagen met";
$localestrings['nl']['ads422'] = "Nee";
$localestrings['nl']['ads423'] = "Ja";
$localestrings['nl']['ads424'] = "Advertentie prioriteit";
$localestrings['nl']['ads425'] = "Naar nieuwe klant verplaatsen";
// contract information
$localestrings['nl']['ads430'] = "Open periode";
$localestrings['nl']['ads431'] = "Vaste periode";
$localestrings['nl']['ads432'] = "Aantal displays";
// buttons
$localestrings['nl']['ads440'] = "Opslaan";
$localestrings['nl']['ads441'] = "Terug";
$localestrings['nl']['ads442'] = "Verlopen";
$localestrings['nl']['ads443'] = "Activeer";
$localestrings['nl']['ads444'] = "Wijzig URL";
$localestrings['nl']['ads445'] = "Email statistieken";
$localestrings['nl']['ads446'] = "Email alle statistieken";
$localestrings['nl']['ads447'] = "Nieuwe adverteerder toevoegen";
$localestrings['nl']['ads448'] = "Advertentie beheer";
$localestrings['nl']['ads449'] = "Plaatje uploaden";
// advertisement location and type. 
$localestrings['nl']['ads450'] = "Logo - zijpaneel";				// location = 0
$localestrings['nl']['ads451'] = "Banner - Forum, bovenaan";		// location = 1
$localestrings['nl']['ads452'] = "Banner - Alleen forum index";		// location = 2
$localestrings['nl']['ads453'] = "Banner - Alleen topic index";		// location = 3
$localestrings['nl']['ads454'] = "Banner - Forum, onderaan";		// location = 4
$localestrings['nl']['ads455'] = "Banner - Forum, boven en onder";	// location = 5
// current - finished advertisement
$localestrings['nl']['ads460'] = "ID";
$localestrings['nl']['ads461'] = "Adverteerder";
$localestrings['nl']['ads462'] = "Advertentie type";
$localestrings['nl']['ads463'] = "Contract informatie";
$localestrings['nl']['ads464'] = "Kliks";
$localestrings['nl']['ads465'] = "Kliks %";
$localestrings['nl']['ads466'] = "Opties";
$localestrings['nl']['ads467'] = "Activeer";
$localestrings['nl']['ads468'] = "Deactiveer";
$localestrings['nl']['ads469'] = "Wijzig";
$localestrings['nl']['ads470'] = "Verwijder";
$localestrings['nl']['ads471'] = "eindigd";
$localestrings['nl']['ads472'] = "start";
$localestrings['nl']['ads473'] = "geeindigd";
$localestrings['nl']['ads474'] = "Advertenties";
$localestrings['nl']['ads475'] = "Contact email";
$localestrings['nl']['ads476'] = "Verwijder adverteerder";
$localestrings['nl']['ads477'] = "links";
$localestrings['nl']['ads478'] = "";
$localestrings['nl']['ads479'] = "Getoond";
// advertising statistics
$localestrings['nl']['ads500'] = "Advertentie statistieken";
$localestrings['nl']['ads501'] = "Prio";
$localestrings['nl']['ads502'] = "Gast";
// client information - email messages
$localestrings['nl']['ads510'] = "Dit zijn de complete statistieken van al uw advertentie investeringen op ".$settings['sitename'].":";
$localestrings['nl']['ads511'] = "Dit zijn de complete statistieken van uw advertentie inversting met ID %s op ".$settings['sitename'].":";
$localestrings['nl']['ads512'] = "Statistiek rapport aangemaakt op %s\r\n\r\n";
$localestrings['nl']['ads513'] = "Nog steeds beschikbaar";
// advertisement - image upload
$localestrings['nl']['ads530'] = "Bestandsnaam";
// advertisement - image management
$localestrings['nl']['ads540'] = "Bekijk";
$localestrings['nl']['ads541'] = "Verwijder";
$localestrings['nl']['ads542'] = "Dimensies";
$localestrings['nl']['ads543'] = "Opties";
$localestrings['nl']['ads544'] = "Gebruikt";
// messages
$localestrings['nl']['ads900'] = "De volgende fouten zijn gevonden bij het controleren van uw gegevens:";
$localestrings['nl']['ads901'] = "De gevraagde advertentie kan niet in de database worden gevonden.";
$localestrings['nl']['ads902'] = "De advertentie is verwijderd.";
$localestrings['nl']['ads903'] = "De hoeveelheid aangekocht moet numeriek zijn.";
$localestrings['nl']['ads904'] = "Het totaal aantal verkocht aan deze adverteerder mag niet negatief zijn.";
$localestrings['nl']['ads905'] = "Weet u zeker dat u dit wilt verwijderen?";
$localestrings['nl']['ads906'] = "De advertentie is succesvol toegevoegd.";
$localestrings['nl']['ads907'] = "De advertentie is succesvol aangepast.";
$localestrings['nl']['ads908'] = "Deze adverteerder heeft geen actieve advertenties.";
$localestrings['nl']['ads909'] = "U staat op het punt '%s' te verwijderen als adverteerder.<br />Dit verwijderd ook alle advertenties en de plaatjes daarvoor!<br /><br />Weet u het zeker?";
$localestrings['nl']['ads910'] = "Deze adverteerder en al zijn advertenties zijn verwijderd.";
$localestrings['nl']['ads911'] = "Deze adverteerder heeft geen verlopen advertenties.";
$localestrings['nl']['ads912'] = "Het geselecteerde plaatje is te groot voor de gewenste locatie.<br />De maximum afmeting voor deze locatie is %s, het geselecteerde plaatje is %s.";
$localestrings['nl']['ads913'] = "Advertentie met ID %s is geactiveerd.";
$localestrings['nl']['ads914'] = "Advertentie met ID %s is gedeactiveerd.";
// messages - moving an advert to a new client
$localestrings['nl']['ads920'] = "Advertentie succesvol verplaatst van %s naar %s.";
$localestrings['nl']['ads921'] = "De geselecteerde advertentie kan niet worden gevonden.";
$localestrings['nl']['ads922'] = "Ongeldig advertentie ID.";
$localestrings['nl']['ads923'] = "De geselecteerde nieuwe adverteerder kan niet worden gevonden.";
$localestrings['nl']['ads924'] = "Ongeldig adverteerder ID.";
// messages - advertising statistics
$localestrings['nl']['ads950'] = "%s, U bent momenteel geen adverteerder op deze website.<br /><br />U kunt ons <a href='/contact.php'>contacteren</a> voor meer informatie over hoe u een adverteerder kunt worden.";
$localestrings['nl']['ads951'] = "De URL voor de advertentie met ID %s is bijgewerkt.";
$localestrings['nl']['ads952'] = "Gedetaileerde statistieken voor de advertentie met ID %s zijn per email naar u gestuurd.";
$localestrings['nl']['ads953'] = "Gedetaileerde statistieken voor alle advertenties zijn per email naar u gestuurd.";
$localestrings['nl']['ads954'] = "%s, er zijn geen advertenties voor u gedefinieerd in deze categorie.";
$localestrings['nl']['ads955'] = "<a href='/contact.php'>contacteer</a> ons a.u.b. indien u denkt dat dit niet correct is.";
// messages - image uploading
$localestrings['nl']['ads960'] = "Bestand heeft geen geldige bestandsextensie (.jpg, .gif or .png)!";
$localestrings['nl']['ads961'] = "Bestand is niet in een geldig bestandsformaat!";
$localestrings['nl']['ads962'] = "Hacking attempt! This is not an uploaded file!";
// messages - image management
$localestrings['nl']['ads970'] = "Er zijn geen geuploade advertenties";
$localestrings['nl']['ads971'] = "Het advertentie bestand is verwijderd.";

/*---------------------------------------------------+
| commands to execute when installing this module    |
+----------------------------------------------------*/

$mod_install_cmds = array();							// commands to execute when installing this module

// adverts: advertising table
$mod_install_cmds[] = array('type' => 'db', 'value' => "CREATE TABLE ##PREFIX##advertising (
  adverts_id smallint(5) NOT NULL auto_increment,
  adverts_userid mediumint(8) NOT NULL default '0',
  adverts_contract tinyint(1) NOT NULL default '0',
  adverts_contract_start int(10) unsigned NOT NULL default '0',
  adverts_contract_end int(10) unsigned NOT NULL default '0',
  adverts_priority tinyint(1) unsigned NOT NULL default '1',
  adverts_location tinyint(2) unsigned NOT NULL default '0',
  adverts_url varchar(200) NOT NULL default '',
  adverts_shown int(11) NOT NULL default '0',
  adverts_clicks int(11) NOT NULL default '0',
  adverts_sold int(11) NOT NULL default '0',
  adverts_image varchar(50) NOT NULL default '',
  adverts_html text NOT NULL,
  adverts_status enum('0','1') NOT NULL default '0',
  adverts_expired tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (adverts_id)
) ENGINE=MyISAM;");

// add a user group for this module
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##user_groups (group_ident, group_name, group_description, group_forumname, group_visible) VALUES ('".$mod_admin_rights."01', 'Advertising clients', 'Advertising clients', 'Advertising client', '1')");

$mod_install_cmds[] = array('type' => 'function', 'value' => "install_function");

/*---------------------------------------------------+
| commands to execute when uninstalling this module  |
+----------------------------------------------------*/

$mod_uninstall_cmds = array();							// commands to execute when uninstalling this module

$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DROP TABLE ##PREFIX##advertising");

$mod_uninstall_cmds[] = array('type' => 'function', 'value' => "uninstall_function");

/*---------------------------------------------------+
| function for special installations                 |
+----------------------------------------------------*/
if (!function_exists('install_function')) {
	function install_function() {

		global $db_prefix, $locale, $mod_title, $mod_admin_rights;

		// update the visiblity of the menu link

		// get the group_id of the Advertising Clients group
		$group = dbarray(dbquery("SELECT group_id FROM ".$db_prefix."user_groups WHERE group_ident = '".$mod_admin_rights."01'"));
		if (is_array($group)) {
			// modify the visibility
			$result = dbquery("UPDATE ".$db_prefix."site_links SET link_visibility = '".$group['group_id']."' WHERE link_name = '".$mod_title."' AND link_url = 'advertising.php'");
		}
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
				// upgrade the userid field from 16bit to 32bit
				$result = dbquery("ALTER TABLE ".$db_prefix."advertising CHANGE adverts_userid adverts_userid MEDIUMINT(8) NOT NULL DEFAULT '0'");
			case "1.1.0":
				// upgrade to ExiteCMS v7.1. no upgrade actions for this release
			default:
				// do this at every upgrade
		}

	}
}
?>
