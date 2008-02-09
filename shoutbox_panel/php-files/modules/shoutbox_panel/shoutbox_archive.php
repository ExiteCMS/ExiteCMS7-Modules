<?php
/*---------------------------------------------------+
| ExiteCMS Content Management System                 |
+----------------------------------------------------+
| Copyright 2007 Harro "WanWizard" Verton, Exite BV  |
| for support, please visit http://exitecms.exite.eu |
+----------------------------------------------------+
| Some portions copyright 2002 - 2006 Nick Jones     |
| http://www.php-fusion.co.uk/                       |
+----------------------------------------------------+
| Released under the terms & conditions of v2 of the |
| GNU General Public License. For details refer to   |
| the included gpl.txt file or visit http://gnu.org  |
+----------------------------------------------------*/
require_once dirname(__FILE__)."../../../includes/core_functions.php";
require_once PATH_ROOT."/includes/theme_functions.php";

// temp storage for template variables
$variables = array();

// defines
define('ITEMS_PER_PAGE', 20);

// check howmany shouts we have
$result = dbquery("SELECT count(shout_id) FROM ".$db_prefix."shoutbox");
$rows = dbresult($result, 0);
$variables['rows'] = $rows;

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