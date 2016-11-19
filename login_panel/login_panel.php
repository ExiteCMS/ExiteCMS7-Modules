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
if (strpos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false || !defined('INIT_CMS_OK')) die();

// array's to store the variables for this panel
$variables = array();

$variables['loginerror'] = isset($loginerror) ? $loginerror : "";
$variables['remember_me'] = isset($_SESSION['remember_me']) ? $_SESSION['remember_me'] : "no";
$variables['login_expiry']  = (iADMIN && isset($_SESSION['login_expire'])) ? time_system2local($_SESSION['login_expire']) : "";

// get the login templates to allow authentication
$variables['auth_templates'] = $GLOBALS['cms_authentication']->get_templates("side");

// check if we need to display a registration link
if ($settings['enable_registration']) {
	$variables['show_reglink'] = true;
	// get all menu items for this user
	global $linkinfo;
	$linkinfo = array();
	require_once PATH_INCLUDES."menu_include.php";
	menu_generate_tree("", array(1,2,3), false);
	foreach ($linkinfo as $link) {
		if ($link['link_url'] == "/register.php") {
			$variables['show_reglink'] = false;
			break;
		}
	}
} else {
	$variables['show_reglink'] = false;
}

// check if we need to display links
$variables['show_passlink'] = 1;

// can we show the login panel?
$variables['show_login'] = $settings['auth_ssl'] == 0 || ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on" );
if (iMEMBER || !$variables['show_login']) $no_panel_displayed = true;

$template_variables['modules.login_panel'] = $variables;
?>
