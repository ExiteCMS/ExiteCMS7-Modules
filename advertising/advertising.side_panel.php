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
if (eregi("ad_side_panel.php", $_SERVER['PHP_SELF']) || !defined('INIT_CMS_OK')) die();

// do not display this panel when in an admin module
if (isset($_GET['aid'])) {

	$no_panel_displayed = true;

} else {

	// load the locale for this panel
	locale_load("modules.advertising");

	// load the ad include module
	require_once PATH_MODULES."advertising/get_ad.php";
	
	// array's to store the variables for this panel
	$ad = get_ad(0,0,0);

	if ($ad == "") {

		$no_panel_displayed = true;

	} else {

		$variables = array();
		$variables['advertisement'] = $ad;
		$template_variables['modules.advertising.side_panel'] = $variables;

	}
}
?>
