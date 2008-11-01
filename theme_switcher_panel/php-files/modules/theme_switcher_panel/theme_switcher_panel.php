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
if (eregi("theme_switcher_panel.php", $_SERVER['PHP_SELF']) || !defined('INIT_CMS_OK')) die();

// check if the theme has been changed
if (iMEMBER && isset($_POST['theme_switcher_panel_theme'])) {
	$result = dbquery("UPDATE ".$db_prefix."users SET user_theme = '".$_POST['theme_switcher_panel_theme']."' WHERE user_id = '".$userdata['user_id']."'");
	redirect(FUSION_REQUEST);
}

// array's to store the variables for this panel
$variables = array();

// feature only available for members
if (iMEMBER) {

	// generate a list of available themes
	$theme_files = makefilelist(PATH_THEMES, ".|..|.svn", true, "folders", $userdata['user_level'] >= 102);
	array_unshift($theme_files, "Default");
 	$variables['theme_files'] = $theme_files;

} else {

	$no_panel_displayed = true;

}

$template_variables['modules.theme_switcher_panel'] = $variables;
?>
