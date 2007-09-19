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
if (eregi("shout_panel.php", $_SERVER['PHP_SELF']) || !defined('IN_FUSION')) die();

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
			$result = dbquery("SELECT MAX(shout_datestamp) AS last_shout FROM ".$db_prefix."shoutbox WHERE shout_ip='".USER_IP."'");
			if (!iSUPERADMIN || dbrows($result) > 0) {
				$data = dbarray($result);
				if ((time() - $data['last_shout']) < $settings['flood_interval']) {
					$flood = true;
					$result = dbquery("INSERT INTO ".$db_prefix."flood_control (flood_ip, flood_timestamp) VALUES ('".USER_IP."', '".time()."')");
					if (dbcount("(flood_ip)", "flood_control", "flood_ip='".USER_IP."'") > 4) {
						if (iMEMBER) $result = dbquery("UPDATE ".$db_prefix."users SET user_status='1' WHERE user_id='".$userdata['user_id']."'");
					}
				}
			}
			if (!$flood) $result = dbquery("INSERT INTO ".$db_prefix."shoutbox (shout_name, shout_message, shout_datestamp, shout_ip) VALUES ('$shout_name', '$shout_message', '".time()."', '".USER_IP."')");
		}
		fallback(FUSION_SELF.(FUSION_QUERY ? "?".FUSION_QUERY : ""));
	}
}
$variables['allow_edit'] = (iADMIN && checkrights("S"));
$result = dbquery("SELECT count(shout_id) FROM ".$db_prefix."shoutbox");
$numrows = dbresult($result, 0);
$result = dbquery(
	"SELECT * FROM ".$db_prefix."shoutbox LEFT JOIN ".$db_prefix."users
	ON ".$db_prefix."shoutbox.shout_name=".$db_prefix."users.user_id
	ORDER BY shout_datestamp DESC LIMIT 0,".$settings['numofshouts']
);
$variables['shouts'] = array();
if (dbrows($result) != 0) {
	$i = 0;
	while ($data = dbarray($result)) {
		$data['shout_message'] = parsesmileys($data['shout_message']);
		$variables['shouts'][] = $data;
	}
	$variables['more_shouts'] = ($numrows > $settings['numofshouts']);
}

$template_variables['modules.shoutbox_panel'] = $variables;
?>