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
$mod_title = "File Downloads";							// title or name of this module
$mod_description = "Module to provide a secure download page for files stored locally on the webserver";	// short description of it's purpose
$mod_version = "1.0.1";									// module version number
$mod_developer = "WanWizard";							// author's name
$mod_email = "wanwizard@exitecms.org";
$mod_weburl = "http://www.exitecms.org/";
$mod_type = "M";

/*---------------------------------------------------+
| Module administration panel installation details   |
+----------------------------------------------------*/

$mod_folder = "file_downloads";							// sub-folder of the /modules folder
$mod_admin_image = "filedownloads.gif";					// icon to be used for the admin panel
$mod_admin_panel = "admin.php";							// name of the admin panel for this module
$mod_admin_rights = "wF";								// admin rights code. This HAS to be assigned by ExiteCMS to avoid duplicates!
$mod_admin_page = 4;									// admin page this panel has to be placed on

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
$mod_site_links[] = array('name' => $mod_title, 'url' => 'file_downloads.php', 'panel' => '', 'visibility' => 103);

/*---------------------------------------------------+
| locale strings for this module                     |
+----------------------------------------------------*/
$localestrings = array();
$localestrings['en'] = array();
// admin panel
$localestrings['en']['400'] = "File Downloads";
$localestrings['en']['401'] = "Category";
$localestrings['en']['402'] = "Order";
$localestrings['en']['403'] = "Options";
$localestrings['en']['404'] = "Move Up";
$localestrings['en']['405'] = "Move Down";
$localestrings['en']['406'] = "Edit Category";
$localestrings['en']['407'] = "Delete Category";
$localestrings['en']['408'] = "There are no local file download categories defined.";
$localestrings['en']['409'] = "Add a new category";
$localestrings['en']['410'] = "Category name:";
$localestrings['en']['411'] = "Local file path";
$localestrings['en']['412'] = "Give access to:";
$localestrings['en']['413'] = "Save";
$localestrings['en']['414'] = "The field 'Category name' may not be empty";
$localestrings['en']['415'] = "The field 'Local file path' may not be empty";
$localestrings['en']['416'] = "No access to the local file path or it does not exist";
$localestrings['en']['417'] = "New category successfully added";
$localestrings['en']['418'] = "New category successfully updated";
$localestrings['en']['419'] = "The requested category can not be found";
$localestrings['en']['420'] = "Visibility";
$localestrings['en']['421'] = "Are you sure you want to delete this category?";
// user panel
$localestrings['en']['450'] = "There are no files found in this category";

$localestrings['nl'] = array();
$localestrings['en']['400'] = "Bestand downloads";
$localestrings['en']['401'] = "Categorie";
$localestrings['en']['402'] = "Volgorde";
$localestrings['en']['403'] = "Opties";
$localestrings['en']['404'] = "Naar boven";
$localestrings['en']['405'] = "Naar beneden";
$localestrings['en']['406'] = "Categorie wijzigen";
$localestrings['en']['407'] = "Categorie verwijderen";
$localestrings['en']['408'] = "Er zijn geen categorieen voor lokale download bestanden gedefinieerd.";
$localestrings['en']['409'] = "Nieuwe categorie toevoegen";
$localestrings['en']['410'] = "Categorie naam:";
$localestrings['en']['411'] = "Lokale bestandsfolder";
$localestrings['en']['412'] = "Geef toegang aan:";
$localestrings['en']['413'] = "Bewaar";
$localestrings['en']['414'] = "Het veld 'Categorie naam' mag niet leeg zijn";
$localestrings['en']['415'] = "Het veld 'Lokale bestandsfolder' mag niet leeg zijn";
$localestrings['en']['416'] = "Geen toegang tot de bestandsfolder of de folder bestaat niet";
$localestrings['en']['417'] = "Nieuwe categorie succesvol toegevoegd";
$localestrings['en']['418'] = "Nieuwe categorie succesvol aangepast";
$localestrings['en']['419'] = "De gevraagde categorie kan niet worden gevonden";
$localestrings['en']['420'] = "Toegang voor";
$localestrings['en']['421'] = "Weet u zeker dat u deze categorie wilt verwijderen?";
// user panel
$localestrings['en']['450'] = "Er zijn geen bestanden in deze directory gevonden";

/*---------------------------------------------------+
| commands to execute when installing this module    |
+----------------------------------------------------*/

$mod_install_cmds = array();							// commands to execute when installing this module

// adverts: advertising table
$mod_install_cmds[] = array('type' => 'db', 'value' => "CREATE TABLE ##PREFIX##file_downloads (
  fd_id smallint(5) NOT NULL auto_increment,
  fd_name varchar(25) NOT NULL default '',
  fd_path varchar(255) NOT NULL default '',
  fd_group smallint(5) NOT NULL default '103',
  fd_order smallint(5) NOT NULL default '0',
  PRIMARY KEY  (fd_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

// add a user group for this module
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##user_groups (group_ident, group_name, group_description, group_forumname, group_visible) VALUES ('".$mod_admin_rights."01', 'File Downloads', 'File Downloads', '', '0')");

$mod_install_cmds[] = array('type' => 'function', 'value' => "install_function");

/*---------------------------------------------------+
| commands to execute when uninstalling this module  |
+----------------------------------------------------*/

$mod_uninstall_cmds = array();							// commands to execute when uninstalling this module

$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DROP TABLE ##PREFIX##file_downloads");

$mod_uninstall_cmds[] = array('type' => 'function', 'value' => "uninstall_function");

/*---------------------------------------------------+
| function for special installations                 |
+----------------------------------------------------*/
if (!function_exists('install_function')) {
	function install_function() {

		global $db_prefix, $locale, $mod_title, $mod_admin_rights, $mod_folder;

		// update the visiblity of the menu link

		// get the group_id of the File Downloads group
		$group = dbarray(dbquery("SELECT group_id FROM ".$db_prefix."user_groups WHERE group_ident = '".$mod_admin_rights."01'"));
		if (is_array($group)) {
			// modify the visibility of the URL
			$result = dbquery("UPDATE ".$db_prefix."site_links SET link_visibility = '".$group['group_id']."' WHERE link_name = '".$mod_title."' AND link_url = '".substr(MODULES,1).$mod_folder."/file_downloads.php'");
		}
	}
}
/*---------------------------------------------------+
| function for special de-installations              |
+----------------------------------------------------*/
if (!function_exists('uninstall_function')) {
	function uninstall_function() {

		global $db_prefix, $mod_admin_rights;

		// delete the module group
		$result = dbquery("DELETE FROM ".$db_prefix."user_groups WHERE group_ident = '".$mod_admin_rights."01'");
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
				// current version
			default:
				// do this at every upgrade
		}

	}
}
?>