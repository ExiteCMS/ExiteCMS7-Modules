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
if (eregi("login_panel.php", $_SERVER['PHP_SELF']) || !defined('INIT_CMS_OK')) die();

// array's to store the variables for this panel
$variables = array();

$variables['loginerror'] = isset($loginerror) ? $loginerror : "";
$variables['remember_me'] = isset($_SESSION['remember_me']) ? $_SESSION['remember_me'] : "no";
$variables['login_expiry']  = (iADMIN && isset($_SESSION['login_expire'])) ? time_system2local($_SESSION['login_expire']) : "";

// get which authentication to show
$variables['auth_methods'] = isset($settings['auth_type']) ? explode(",",$settings['auth_type']) : array('local');
$variables['method_count'] = count($variables['auth_methods']);
$variables['auth_state'] = array();
foreach($variables['auth_methods'] as $key => $method) {
	if (isset($_SESSION['box_login2'.$key])) {
		$variables['auth_state'][] = $_SESSION['box_login2'.$key] == 0 ? 1 : 0;
	} else {
		$variables['auth_state'][] = 1;
	}
}

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

$template_variables['modules.login_panel'] = $variables;
?>
