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
require_once dirname(__FILE__)."/../../includes/core_functions.php";
require_once PATH_ROOT."/includes/theme_functions.php";

// temp storage for template variables
$variables = array();

/* TEST VALUES
$_POST['mc_gross'] = '12.34';
$_POST['mc_currency'] = 'GBP';
$_POST['first_name'] = 'John';
$_POST['last_name'] = 'Doe';
$_POST['option_selection1'] = 'bla';
$_POST['option_selection2'] = 'This is a comment';
$_POST['payment_date'] = time();
*/

// make sure this is a redirect from Paypal
if (!isset($_POST['mc_gross'])) fallback ('index.php');
$variables['mc_gross'] = $_POST['mc_gross'];
$variables['mc_currency'] = $_POST['mc_currency'];

// load the locale for this module
if (file_exists(PATH_MODULES."donations/locale/".$settings['locale'].".php")) {
	$locale_file = PATH_MODULES."donations/locale/".$settings['locale'].".php";
} else {
	$locale_file = PATH_MODULES."donations/locale/English.php";
}
include $locale_file;

if (isset($_POST['first_name']) && isset($_POST['last_name'])) {
	$payer_name = trim($_POST['first_name'])." ".trim($_POST['last_name']);
} else {
	if (isset($_POST['address_name'])) {
		$payer_name = $_POST['address_name'];
	} else {
		$payer_name = ""; // no name fields present in the SOAP post
	} 
}
// check for anonymous payment
if ($_POST['option_selection1'] !='Mention my name') {
		$payer_name = "";
}
$variables['payer_name'] = $payer_name;
$variables['payment_date'] = strtotime($_POST['payment_date']);
$variables['comment'] = $_POST['option_selection2'];

// define the body panel variables
$template_panels[] = array('type' => 'body', 'name' => 'modules.donations.thanks', 'template' => 'modules.donations.thanks.tpl', 'locale' => $locale_file);
$template_variables['modules.donations.thanks'] = $variables;

// Call the theme code to generate the output for this webpage
require_once PATH_THEME."/theme.php";
?>