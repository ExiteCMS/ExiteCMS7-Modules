<?php
/*---------------------------------------------------------------------+
| ExiteCMS Content Management System                                   |
+----------------------------------------------------------------------+
| Copyright 2010 Exite BV, The Netherlands                             |
| for support, please visit http://www.exitecms.org                    |
+----------------------------------------------------------------------+
| Some code derived from PHP-Fusion, copyright 2002 - 2006 Nick Jones  |
+----------------------------------------------------------------------+
| Released under the terms & conditions of v2 of the GNU General Public|
| License. For details refer to the included gpl.txt file or visit     |
| http://gnu.org                                                       |
+----------------------------------------------------------------------+
| $Id:: module_installer.php 2043 2008-11-16 14:25:18Z WanWizard      $|
+----------------------------------------------------------------------+
| Last modified by $Author:: WanWizard                                $|
| Revision number $Rev:: 2043                                         $|
+---------------------------------------------------------------------*/
if (!checkrights("I") || !defined("iAUTH") || $aid != iAUTH || !defined('INIT_CMS_OK')) fallback(BASEDIR."index.php");

/*---------------------------------------------------+
| Module identification                              |
+----------------------------------------------------*/
$mod_title = "Merge Forums";
$mod_description = "Move all posts from one forum to another, optionally with a subject prefix.";
$mod_version = "1.0.1";
$mod_folder = "merge_forums";							// sub-folder of the /modules folder
$mod_developer = "WanWizard";							// author's name
$mod_email = "wanwizard@exitecms.org";
$mod_weburl = "http://www.exitecms.org/";
$mod_type = "M";

/*---------------------------------------------------+
| Module administration panel installation details   |
+----------------------------------------------------*/

$mod_admin_image = "mergeforums.gif";					// icon to be used for the admin panel
$mod_admin_panel = "merge_forums.php";					// name of the admin panel for this module
$mod_admin_rights = "mF";								// admin rights code. This HAS to be assigned by ExiteCMS to avoid duplicates!
$mod_admin_page = 1;									// admin page this panel has to be placed on

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
$localestrings['en']['mf400'] = 'Merge forums';
$localestrings['en']['mf401'] = 'Forum to move from';
$localestrings['en']['mf402'] = 'Forum to move to';
$localestrings['en']['mf403'] = 'Subject prefix';
$localestrings['en']['mf404'] = 'Start';

$localestrings['en']['mf500'] = 'You can not move a forum to itself!';
$localestrings['en']['mf501'] = 'Are you sure you want to move all posts from this forum?\\\nMoving is irreversable! Make sure you have a backup!';
$localestrings['en']['mf502'] = 'Can not start the merge. Parameter values are not correct!';
$localestrings['en']['mf503'] = 'All the posts of the "%s" forum have been moved to "".';

$localestrings['nl'] = array();

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
			case "1.0.0":
				// Initial version. no upgrade actions for this release

			default:
				// do this at every upgrade
		}
	}
}
?>
