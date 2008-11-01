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
| $Id:: viewpage.php 1935 2008-10-29 23:42:42Z WanWizard              $|
+----------------------------------------------------------------------+
| Last modified by $Author:: WanWizard                                $|
| Revision number $Rev:: 1935                                         $|
+---------------------------------------------------------------------*/
require_once dirname(__FILE__)."../../../includes/core_functions.php";
require_once PATH_ROOT."/includes/theme_functions.php";

// temp storage for template variables
$variables = array();

// defines
define('ITEMS_PER_PAGE', 20);

// check howmany shouts we have
$variables['rows'] = dbfunction("COUNT(shout_id)","shoutbox");

// make sure rowstart has a valid value
if (!isset($rowstart) || !isNum($rowstart)) $rowstart = 0;
$variables['rowstart'] = $rowstart;

// shouts present? Get them!
$variables['shouts'] = array();
if ($rows != 0) {
	$result = dbquery(
		"SELECT * FROM ".$db_prefix."shoutbox LEFT JOIN ".$db_prefix."users
		ON ".$db_prefix."shoutbox.shout_name=".$db_prefix."users.user_id
		ORDER BY shout_datestamp DESC LIMIT $rowstart,".ITEMS_PER_PAGE
	);
	while ($data = dbarray($result)) {
		// parse any smiley's in the message, and strip breaks while at it...
		$data['shout_message'] = str_replace("<br>", "", parsesmileys($data['shout_message']));
		// store the data
		$variables['shouts'][]  = $data;
	}
}

// check if the current user is a shoutbox admin
$variables['is_admin'] = iMEMBER && checkrights("S");

// define the search body panel variables
$template_panels[] = array('type' => 'body', 'name' => 'shoutbox_archive', 'template' => 'modules.shoutbox_panel.archive.tpl');
$template_variables['shoutbox_archive'] = $variables;

// Call the theme code to generate the output for this webpage
require_once PATH_THEME."/theme.php";
?>
