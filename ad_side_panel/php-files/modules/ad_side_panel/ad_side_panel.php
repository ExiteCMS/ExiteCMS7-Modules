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
if (eregi("ad_side_panel.php", $_SERVER['PHP_SELF']) || !defined('INIT_CMS_OK')) die();

// do not display this panel when in an admin module
if (isset($_GET['aid'])) {
	$no_panel_displayed = true;
} else {

	// check if the advertising module is installed
	if (file_exists(PATH_MODULES."advertising/get_ad.php")) {

		// load the locale for this panel
		if (file_exists(PATH_MODULES."advertising/locale/".$settings['locale'].".php")) {
		        $locale_file = PATH_MODULES."advertising/locale/".$settings['locale'].".php";
		} else {
		        $locale_file = PATH_MODULES."advertising/locale/English.php";
		}
		include $locale_file;

		// load the ad include module
		require_once PATH_MODULES."advertising/get_ad.php";
	
		// array's to store the variables for this panel
		$ad = get_ad(0,0,0);

	} else {
		$ad = "";
	}

	if ($ad == "") {
		$no_panel_displayed = true;
	} else {
		$variables = array();
		$variables['advertisement'] = $ad;
		$template_variables['modules.ad_side_panel'] = $variables;
	}
}
?>