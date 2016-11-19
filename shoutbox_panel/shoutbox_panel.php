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

// load message parsing functions
require_once PATH_INCLUDES."forum_functions_include.php";

// load the locale for this include
locale_load("modules.shoutbox_panel");

// array's to store the variables for this panel
$variables = array();

if (iMEMBER || $settings['guestposts'] == "1") {
	if (isset($_POST['post_shout'])) {
		$flood = false;
		if (iMEMBER) {
			$shout_name = $userdata['user_id'];
		} elseif ($settings['guestposts'] == "1") {
			$shout_name = trim(stripinput($_POST['shout_name']));
			$shout_name = preg_replace("(^[0-9]*)", "", $shout_name);
			if (isNum($shout_name)) $shout_name="";
		}
		$shout_message = str_replace("\n", " ", $_POST['shout_message']);
		$shout_message = preg_replace("/^(.{255}).*$/", "$1", $shout_message);
		$shout_message = preg_replace("/([^\s]{25})/", "$1\n", $shout_message);
		$shout_message = trim(stripinput(censorwords($shout_message)));
		$shout_message = str_replace("\n", "<br>", $shout_message);
		if ($shout_name != "" && $shout_message != "") {
			$result = dbquery("SELECT MAX(shout_datestamp) AS last_shout FROM ".$db_prefix."shoutbox WHERE shout_ip='".USER_IP."' AND shout_name='".$shout_name."'");
			if (!iSUPERADMIN && dbrows($result) > 0) {
				$data = dbarray($result);
				if ((time() - $data['last_shout']) < $settings['flood_interval']) {
					$flood = true;
					$result = dbquery("INSERT INTO ".$db_prefix."flood_control (flood_ip, flood_userid, flood_timestamp) VALUES ('".USER_IP."', '".$shout_name."', '".time()."')");
					if (dbcount("(flood_ip)", "flood_control", "flood_ip='".USER_IP."' AND flood_userid='".$shout_name."'") > 4) {
						if (iMEMBER) {
							// ban the member for flooding
							$result = dbquery("UPDATE ".$db_prefix."users SET user_status='1', user_ban_reason='".$locale['407']."' WHERE user_id='".$userdata['user_id']."'");
						} else {
							// anonymous user, blacklist the IP address
							$result = dbquery("INSERT INTO ".$db_prefix."blacklist (blacklist_ip, blacklist_reason) VALUES ('".USER_IP."', '".$locale['407']."')");
						}
					}
				}
			}
			if (!$flood) $result = dbquery("INSERT INTO ".$db_prefix."shoutbox (shout_name, shout_message, shout_datestamp, shout_ip) VALUES ('$shout_name', '$shout_message', '".time()."', '".USER_IP."')");
		}
		fallback(FUSION_SELF.(FUSION_QUERY ? "?".str_replace("&amp;", "&", FUSION_QUERY) : ""));
	}
}
$variables['allow_edit'] = (iADMIN && checkrights("S"));
$numrows = dbfunction("COUNT(shout_id)", "shoutbox");
$result = dbquery(
	"SELECT * FROM ".$db_prefix."shoutbox LEFT JOIN ".$db_prefix."users
	ON ".$db_prefix."shoutbox.shout_name=".$db_prefix."users.user_id
	ORDER BY shout_datestamp DESC LIMIT 0,".$settings['numofshouts']
);
$variables['shouts'] = array();
if (dbrows($result) != 0) {
	$i = 0;
	while ($data = dbarray($result)) {
		$data['shout_message'] = parsemessage(array(), $data['shout_message'], true, true);
		$variables['shouts'][] = $data;
	}
	$variables['more_shouts'] = ($numrows > $settings['numofshouts']);
}

$template_variables['modules.shoutbox_panel'] = $variables;
?>
