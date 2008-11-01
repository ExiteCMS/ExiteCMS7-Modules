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
if (eregi("last_seen_users_panel.php", $_SERVER['PHP_SELF']) || !defined('INIT_CMS_OK')) die();

// number of users to show in the panel
if (!defined('MAX_USERS')) define('MAX_USERS', 15);

// array's to store the variables for this panel
$variables = array();
$members = array();

// load the locale for this panel
locale_load("modules.last_seen_users_panel");

// load the GeoIP functions
require_once PATH_INCLUDES."geoip_include.php";

// select the last logged in users from the users table
$result = dbquery("SELECT * FROM ".$db_prefix."users WHERE user_lastvisit>'0'".($settings['hide_webmaster']?" AND user_level != '103'":"")." AND user_status='0' ORDER BY user_lastvisit DESC LIMIT 0,".MAX_USERS);
if (dbrows($result) == 0) {
	$no_panel_displayed = true;
} else {
	while ($data = dbarray($result)) {
		// calculated 'lastseen'
		$lastseen = datediff($data['user_lastvisit'], time());
		if (isNum($lastseen)) {
			// online
			$lastseen= $locale['070'];
		} elseif ($lastseen < "00:05:00") {
			// less than 5 minutes
			$lastseen= $locale['071'];
		}
		// get the country code flag from the user's last known IP address
		if ($settings['forum_flags'] == 0) {
			$cc_flag = "";
		} else {
			$cc_flag = GeoIP_Code2Flag($data['user_cc_code'], true, false, 10);
			if ($cc_flag == "" || empty($data['user_ip']) || $data['user_ip'] == "X" || $data['user_ip'] == "0.0.0.0") {
				$cc_flag = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			}
		}
		// store the result in the members array
		$members[] = array('user_id' => $data['user_id'], 'user_name' => $data['user_name'], 'cc_flag' => $cc_flag, 'lastseen' => $lastseen);
	}

	$variables['members'] = $members;
	$template_variables['modules.last_seen_users_panel'] = $variables;
}
?>
