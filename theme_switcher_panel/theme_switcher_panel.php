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
if (eregi("theme_switcher_panel.php", $_SERVER['PHP_SELF']) || !defined('INIT_CMS_OK')) die();

// check if the theme has been changed
if (iMEMBER && isset($_POST['theme_switcher_panel_theme'])) {
	$result = dbquery("UPDATE ".$db_prefix."users SET user_theme = '".$_POST['theme_switcher_panel_theme']."' WHERE user_id = '".$userdata['user_id']."'");
	redirect(FUSION_REQUEST);
}

// load the locale for this module
if (file_exists(PATH_MODULES."theme_switcher_panel/locale/".$settings['locale'].".php")) {
	$localefile = PATH_MODULES."theme_switcher_panel/locale/".$settings['locale'].".php";
} else {
	$localefile = PATH_MODULES."theme_switcher_panel/locale/English.php";
}
include $localefile;

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