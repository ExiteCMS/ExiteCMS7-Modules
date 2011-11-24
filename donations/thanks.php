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

// load the locale for this module
locale_load("modules.donations");

/* TEST VALUES
$_POST['mc_gross'] = '12.34';
$_POST['mc_currency'] = 'GBP';
$_POST['first_name'] = 'John';
$_POST['last_name'] = 'Doe';
$_POST['option_selection1'] = 'Dont Mention my name';
$_POST['option_selection2'] = 'This is a comment';
$_POST['payment_date'] = time();
*/

// make sure this is a redirect from Paypal
if (!isset($_POST['mc_gross'])) fallback ('index.php');
$variables['mc_gross'] = stripinput($_POST['mc_gross']);
$variables['mc_currency'] = stripinput($_POST['mc_currency']);

if (isset($_POST['first_name']) && isset($_POST['last_name'])) {
	$payer_name = stripinput($_POST['first_name'])." ".stripinput($_POST['last_name']);
} else {
	if (isset($_POST['address_name'])) {
		$payer_name = stripinput($_POST['address_name']);
	} else {
		$payer_name = $locale['don459']; // no name fields present in the SOAP post
	} 
}
// check for anonymous payment
if ($_POST['option_selection1'] !='Mention my name') {
		$payer_name = "";
}
$variables['payer_name'] = $payer_name;
$variables['payment_date'] = strtotime($_POST['payment_date']);
$variables['comment'] = stripinput($_POST['option_selection2']);

// make the variables available to the template parser
$template->assign($variables);

// parse the page
$variables['html'] = $template->fetch("string:".$locale['don_thanks']);

// define the body panel variables
$template_panels[] = array('type' => 'body', 'name' => 'modules.donations.thanks', 'template' => 'modules.donations.thanks.tpl', 'locale' => "modules.donations");
$template_variables['modules.donations.thanks'] = $variables;

// Call the theme code to generate the output for this webpage
require_once PATH_THEME."/theme.php";
?>
