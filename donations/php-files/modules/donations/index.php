<?php
/*---------------------------------------------------+
| ExiteCMS Content Management System                 |
+----------------------------------------------------+
| Copyright 2007 Harro "WanWizard" Verton, Exite BV  |
| for support, please visit http://exitecms.exite.eu |
+----------------------------------------------------+
| Released under the terms & conditions of v2 of the |
| GNU General Public License. For details refer to   |
| the included gpl.txt file or visit http://gnu.org  |
+----------------------------------------------------*/
require_once dirname(__FILE__)."/../../includes/core_functions.php";
require_once PATH_ROOT."/includes/theme_functions.php";

// temp storage for template variables
$variables = array();

// load the GeoIP include
require_once PATH_INCLUDES."geoip_include.php";

// load the locale for this module
if (file_exists(PATH_MODULES."donations/locale/".$settings['locale'].".php")) {
	$locale_file = PATH_MODULES."donations/locale/".$settings['locale'].".php";
} else {
	$locale_file = PATH_MODULES."donations/locale/English.php";
}
include $locale_file;

// check if we're running in production. If not, switch to Paypal sandbox
if ($_SERVER['HTTP_HOST'] != "www.pli-images.org") {
	$variables['sandbox'] = true;
	$variables['form_url'] = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
	$variables['form_account'] = 'paypal-sandbox@pli-images.org';
} else {
	$variables['sandbox'] = false;
	$variables['form_url'] = 'https://www.paypal.com/cgi-bin/webscr';
	$variables['form_account'] = 'donations@pli-images.org';
}

// try to make a guess of the users home country (so paypal shows up in the correct language)
$user_cccode = GeoIP_IP2Code(USER_IP);
if (!$user_cccode) $user_cccode = $locale['don001'];
$variables['user_cccode'] = $user_cccode;

// define the body panel variables
$template_panels[] = array('type' => 'body', 'name' => 'modules.donations.index', 'template' => 'modules.donations.index.tpl', 'locale' => $locale_file);
$template_variables['modules.donations.index'] = $variables;

// Call the theme code to generate the output for this webpage
require_once PATH_THEME."/theme.php";
?>