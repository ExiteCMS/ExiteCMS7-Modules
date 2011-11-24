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
require_once dirname(__FILE__)."/../../includes/core_functions.php";
require_once PATH_ROOT."/includes/theme_functions.php";

// load the GeoIP include
require_once PATH_INCLUDES."geoip_include.php";

// temp storage for template variables
$variables = array();

// load the locale for this module
locale_load("modules.donations");

// make sure rowstart has a valid value
if (!isset($rowstart1) || !isNum($rowstart1)) $rowstart1 = 0;
$variables['rowstart1'] = $rowstart1;

// get the list of donations we want to report
$variables['donate1'] = array();
$result = dbquery("SELECT * FROM ".$db_prefix."donations WHERE donate_type != '2' ORDER BY donate_timestamp DESC");
if (dbrows($result)) {
	while ($data = dbarray($result)) {
		$data['country'] = GeoIP_Code2Flag($data['donate_country']);
		$variables['donate1'][] = $data;
	}
}

// get the list of investments and spending we want to report
$variables['donate2'] = array();
$result = dbquery("SELECT * FROM ".$db_prefix."donations WHERE donate_type = '2' ORDER BY donate_timestamp DESC");
if (dbrows($result)) {
	while ($data = dbarray($result)) {
		$variables['donate2'][] = $data;
	}
}

// make the variables available to the template parser
$template->assign($variables);
$template->assign('locale', $locale);

// parse the page
$variables['html'] = $template->fetch("string:".$locale['don_list']);


// define the body panel variables
$template_panels[] = array('type' => 'body', 'name' => 'donations.donors', 'template' => 'modules.donations.donors.tpl', 'locale' => "modules.donations");
$template_variables['donations.donors'] = $variables;

// Call the theme code to generate the output for this webpage
require_once PATH_THEME."/theme.php";
?>
