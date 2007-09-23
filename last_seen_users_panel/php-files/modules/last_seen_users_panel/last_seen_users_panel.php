<?php
/*---------------------------------------------------+
| ExiteCMS Content Management System                 |
+----------------------------------------------------+
| Copyright 2007 Harro "WanWizard" Verton, Exite BV  |
| for support, please visit http://exitecms.exite.eu |
+----------------------------------------------------+
| Some portions copyright 2002 - 2006 Nick Jones     |
| http://www.php-fusion.co.uk/                       |
+----------------------------------------------------+
| Released under the terms & conditions of v2 of the |
| GNU General Public License. For details refer to   |
| the included gpl.txt file or visit http://gnu.org  |
+----------------------------------------------------*/
if (eregi("last_seen_users_panel.php", $_SERVER['PHP_SELF']) || !defined('ExiteCMS_INIT')) die();

// number of users to show in the panel
define('MAX_USERS', 15);

// array's to store the variables for this panel
$variables = array();
$members = array();

// load the locale for this panel
if (file_exists(PATH_MODULES."last_seen_users_panel/locale/".$settings['locale'].".php")) {
	include PATH_MODULES."last_seen_users_panel/locale/".$settings['locale'].".php";
} else {
	include PATH_MODULES."last_seen_users_panel/locale/English.php";
}

// load the GeoIP functions
require_once PATH_INCLUDES."geoip_include.php";

// select the last logged in users from the users table
$result = dbquery("SELECT * FROM ".$db_prefix."users WHERE user_lastvisit>'0' AND user_id != 1 AND user_status='0' ORDER BY user_lastvisit DESC LIMIT 0,".MAX_USERS);
if (dbrows($result) != 0) {
	while ($data = dbarray($result)) {
		// calculated 'lastseen'
		$lastseen = time() - $data['user_lastvisit'];
		$iW=sprintf("%2d",floor($lastseen/604800));
		$iD=sprintf("%2d",floor($lastseen/(60*60*24)));
		$iH=sprintf("%02d",floor((($lastseen%604800)%86400)/3600));
		$iM=sprintf("%02d",floor(((($lastseen%604800)%86400)%3600)/60));
		$iS=sprintf("%02d",floor((((($lastseen%604800)%86400)%3600)%60)));
		if ($lastseen < 60){
			$lastseen= $locale['lsup001'];
		} elseif ($lastseen < 360){
			$lastseen= $locale['lsup002'];
		} elseif ($iW > 0){
			if ($iW == 1) { $text = $locale['lsup003']; } else { $text = $locale['lsup004']; }
			$lastseen = $iW." ".$text;
		} elseif ($iD > 0){
			if ($iD == 1) { $text = $locale['lsup005']; } else { $text = $locale['lsup006']; }
			$lastseen = $iD." ".$text;
		} else {
			$lastseen = $iH.":".$iM.":".$iS;
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
}

$variables['members'] = $members;
$template_variables['modules.last_seen_users_panel'] = $variables;

?>