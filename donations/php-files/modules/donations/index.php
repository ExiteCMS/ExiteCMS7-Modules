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

// load the locale for this module
locale_load('modules.donations');

// temp storage for template variables
$variables = array();

// check if we're running against the Paypal sandbox
if ($settings['donate_use_sandbox']) {
	$variables['sandbox'] = true;
	$variables['form_url'] = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
} else {
	$variables['sandbox'] = false;
	$variables['form_url'] = 'https://www.paypal.com/cgi-bin/webscr';
}

// make the variables available to the template parser
$template->assign($variables);
$template->assign('locale', $locale);

// parse the page
$variables['html'] = $template->fetch("string:".$locale['don_index']);

// define the body panel variables
$template_panels[] = array('type' => 'body', 'name' => 'modules.donations.index', 'template' => 'modules.donations.index.tpl', 'locale' => 'modules.donations');
$template_variables['modules.donations.index'] = $variables;

// Call the theme code to generate the output for this webpage
require_once PATH_THEME."/theme.php";
?>
