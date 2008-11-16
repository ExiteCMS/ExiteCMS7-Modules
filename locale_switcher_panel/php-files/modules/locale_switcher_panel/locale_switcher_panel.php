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
if (eregi("locale_switcher_panel.php", $_SERVER['PHP_SELF']) || !defined('INIT_CMS_OK')) die();

// check if the theme has been changed
if (iMEMBER && isset($_POST['locale_switcher_panel_locale'])) {
	$result = dbquery("UPDATE ".$db_prefix."users SET user_locale = '".$_POST['locale_switcher_panel_locale']."' WHERE user_id = '".$userdata['user_id']."'");
	if ($_POST['locale_switcher_panel_locale'] != $settings['locale']) {
		setcookie("locale", $_POST['locale_switcher_panel_locale'], time() + 31536000, "/", "", "0");
	} else {
		setcookie("locale", $_POST['locale_switcher_panel_locale'], time() - 3600, "/");
	}
	redirect(FUSION_REQUEST);
}

// array's to store the variables for this panel
$variables = array();

// feature only available for members
if (iMEMBER) {

	// generate a list of available themes
	$variables['locales'] = array();
	$result = dbquery("SELECT * FROM ".$db_prefix."locale WHERE locale_active = '1' ORDER BY locale_name");
	while ($data = dbarray($result)) {
		$variables['locales'][] = $data;
	}

} else {

	$no_panel_displayed = true;

}

$template_variables['modules.locale_switcher_panel'] = $variables;
?>
