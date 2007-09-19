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
if (eregi("birthday_panel.php", $_SERVER['PHP_SELF']) || !defined('IN_FUSION')) die();

// load the locale for this panel
if (file_exists(PATH_MODULES."birthday_panel/locale/".$settings['locale'].".php")) {
        include PATH_MODULES."birthday_panel/locale/".$settings['locale'].".php";
} else {
        include PATH_MODULES."birthday_panel/locale/English.php";
}

// array's to store the variables for this panel
$variables = array();

$localtime = time() + $userdata['user_offset'] * 60 * 60;
$result = dbquery("SELECT user_id, user_name, user_birthdate, YEAR(CURDATE())-YEAR(user_birthdate) as age FROM ".$db_prefix."users WHERE DAYOFMONTH(user_birthdate) = ".date('j' ,$localtime)." AND MONTH(user_birthdate) = ".date('m', $localtime)." ORDER BY user_name");

$variables['count'] = dbrows($result);

$variables['birthdays'] = array();
if ($variables['count']) {
	while ($data = dbarray($result)) {
		$variables['birthdays'][] = $data;
	}
}
$template_variables['modules.birthday_panel'] = $variables;
?>