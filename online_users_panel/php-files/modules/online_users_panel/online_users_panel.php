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
if (eregi("online_users_panel.php", $_SERVER['PHP_SELF']) || !defined('INIT_CMS_OK')) die();

// GeoIP include to map IP to country
require_once PATH_INCLUDES."geoip_include.php";

// array's to store the variables for this panel
$variables = array();

$result = dbquery(
	"SELECT ton.*, tu.user_id,user_name FROM ".$db_prefix."online ton
	LEFT JOIN ".$db_prefix."users tu ON ton.online_user=tu.user_id".($settings['hide_webmaster']?" WHERE tu.user_level IS NULL OR tu.user_level != '103'":""));
$variables['online'] = dbrows($result);
if ($variables['online'] > $settings['max_users']) {
	$settings['max_users'] = $rows;
	$result2 = dbquery("UPDATE ".$db_prefix."configuration SET cfg_value = '".$variables['online']."' WHERE cfg_name = 'max_users'");
	$settings['max_users_datestamp'] = time();
	$result2 = dbquery("UPDATE ".$db_prefix."configuration SET cfg_value = '".$settings['max_users_datestamp']."' WHERE cfg_name = 'max_users_datestamp'");
}
// get who's online
$variables['guests'] = 0;
$variables['members'] = array();
while ($data = dbarray($result)) {
	if ($data['online_user'] == "0") {
		$variables['guests']++;
	} else {
		$variables['members'][] = $data;
	}
}

// get information of the last registered user
$data = dbarray(dbquery("SELECT user_id,user_name, user_ip, user_cc_code FROM ".$db_prefix."users WHERE user_status='0' ORDER BY user_joined DESC LIMIT 0,1"));
$cc_flag = GeoIP_Code2Flag($data['user_cc_code'], true, false, 10);
if ($cc_flag == "" || $settings['forum_flags'] == 0 || empty($data['user_ip']) || $data['user_ip'] == "X" || $data['user_ip'] == "0.0.0.0") {
	$cc_flag = "";
}
$variables['last_user_id'] = $data['user_id'];
$variables['last_user_name'] = $data['user_name'];
$variables['last_user_flag'] = $cc_flag;

$variables['max_users'] = number_format($settings['max_users']);
$variables['max_date'] = showdate('forumdate', $settings['max_users_datestamp']);
$variables['users_count'] = number_format(dbcount("(user_id)", "users", "user_status<='1'"));
$variables['users_online'] = number_format(dbcount("(user_id)", "users", "user_lastvisit>'".(time()-60*60*24*60)."' AND user_status='0'"));
$variables['users_registered'] = dbcount("(user_id)", "users", "user_status='2'");

$template_variables['modules.online_users_panel'] = $variables;
?>
