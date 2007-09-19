<?php
/*---------------------------------------------------+
| PLi-Fusion Content Management System               |
+----------------------------------------------------+
| Copyright 2007 WanWizard (wanwizard@gmail.com)     |
| http://www.pli-images.org/pli-fusion               |
+----------------------------------------------------+
| Some portions copyright ? 2002 - 2006 Nick Jones   |
| http://www.php-fusion.co.uk/                       |
| Released under the terms & conditions of v2 of the |
| GNU General Public License. For details refer to   |
| the included gpl.txt file or visit http://gnu.org  |
+----------------------------------------------------*/
if (eregi("ad_side_panel.php", $_SERVER['PHP_SELF']) || !defined('IN_FUSION')) die();

// do not display this panel when in an admin module
if (isset($_GET['aid'])) {
	$no_panel_displayed = true;
} else {

	// load the locale for this module
	require_once PATH_LOCALE.LOCALESET."admin/adverts.php";

	// load the advertisement include module
	require_once PATH_INCLUDES."advertisement.php";
	
	// array's to store the variables for this panel
	$variables = array();
	$variables['advertisement'] = get_advert(0,0,0);
		
	$template_variables['modules.ad_side_panel'] = $variables;
}
?>