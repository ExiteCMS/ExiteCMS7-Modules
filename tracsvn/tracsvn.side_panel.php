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
| $Id:: tracsvn.side_panel.php 2359 2010-07-24 11:18:10Z WanWizard    $|
+----------------------------------------------------------------------+
| Last modified by $Author:: WanWizard                                $|
| Revision number $Rev:: 2359                                         $|
+---------------------------------------------------------------------*/
if (strpos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false || !defined('INIT_CMS_OK')) die();

require_once "tracsvn_include.php";

// define the variables for the panel
$variables = array();

// get the last SVN commit from the database
if (!empty($settings['tracsvn_database']) && dbtable_exists("revision", $settings['tracsvn_database'])) {
	$result = dbquery("SELECT * FROM ".$settings['tracsvn_database'].".revision ORDER BY time DESC LIMIT 1");
	if (dbrows($result)) {
    	$data = dbarray($result);
	    $variables['rev'] = (int) $data['rev'];
	    if (strlen($data['time']) > 10) $data['time'] = substr($data['time'],0,10);
	    $variables['date'] = $data['time'];
	    $variables['dev'] = tracsvn_getalias($data['author']);
	}
}

// store the data for use in the template
$template_variables['modules.tracsvn.side_panel'] = $variables;
?>
