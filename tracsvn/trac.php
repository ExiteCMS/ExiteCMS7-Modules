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
| $Id:: trac.php 2043 2008-11-16 14:25:18Z WanWizard                  $|
+----------------------------------------------------------------------+
| Last modified by $Author:: WanWizard                                $|
| Revision number $Rev:: 2043                                         $|
+---------------------------------------------------------------------*/
require_once dirname(__FILE__)."/../../includes/core_functions.php";
require_once PATH_ROOT."/includes/theme_functions.php";

require_once "tracsvn_include.php";

// define the variables for this panel
$variables = array();

// load the locale for this module
locale_load("modules.tracsvn");

// check if the Trac database exists and is accessable
if (empty($settings['tracsvn_database']) || !dbtable_exists("revision", $settings['tracsvn_database'])) {
	$step = "notfound";
}

// get the rights for the current user
$variables['view_tickets'] = true;

// check the step variable
if (!isset($step)) $step="roadmap";

// make sure step is not conflicting with the user's rights
if (!$variables['view_tickets'] && ($step == "ticket" || $step == "tickets")) {
	$step = "roadmap";
}

if (!isset($blanks) || ($blanks != "yes" && $blanks != "no")) $blanks = "no";

// and store it for the template
$variables['step'] = $step;

// process the step requested
switch ($step) {
	case "notfound":
		break;
	case "roadmap":
		// get the milestones
		$variables['milestones'] = array();
		$first = true;
		$result = dbquery("SELECT * FROM ".$settings['tracsvn_database'].".milestone ORDER BY name DESC");
		while ($data = dbarray($result)) {
			$data['description'] = tracsvn_wiki2html($data['description']);
			$data['opened'] = dbcount("(*)", $settings['tracsvn_database'].".ticket", "milestone = '".$data['name']."' AND status <> 'closed'"); 
			$data['closed'] = dbcount("(*)", $settings['tracsvn_database'].".ticket", "milestone = '".$data['name']."' AND status = 'closed'"); 
			// add tickets without milestone to the first milestone in the list
			$data['include_blanks'] = $first ? "yes" : "no";
			if ($first) {
				$first = false;
				$data['opened'] += dbcount("(*)", $settings['tracsvn_database'].".ticket", "milestone = '' AND status <> 'closed'"); 
				$data['closed'] += dbcount("(*)", $settings['tracsvn_database'].".ticket", "milestone = '' AND status = 'closed'"); 
			}
			if ($data['due'] > 0) {
				// adjust the due date to be at the end of the day (Trac works in days, we in seconds)
				$data['due'] = $data['due'] + 86399;  // one day minus 1 second
				$data['overdue'] = $data['due'] < time();
			} else {
				$data['overdue'] = false;
			}
			if ($data['completed']) {
				$data['datediff'] = datediff($data['completed'], time());
			} else {
				$data['datediff'] = datediff(time(), $data['due']);
			}
			$variables['milestones'][] = $data;
		}
		break;
	case "tickets":
		// get the requested tickets
		$variables['tickets'] = array();
		if ($blanks == "yes") {
			$result = dbquery("SELECT * FROM ".$settings['tracsvn_database'].".ticket WHERE (milestone='".stripinput($milestone)."' OR milestone = '') AND status".($status=="closed"?"":"!")."='closed' ORDER BY milestone ASC, changetime DESC");
		} else {
			$result = dbquery("SELECT * FROM ".$settings['tracsvn_database'].".ticket WHERE milestone='".stripinput($milestone)."' AND status".($status=="closed"?"":"!")."='closed' ORDER BY milestone DESC, changetime DESC");
		}
		if (dbrows($result)) {
			while ($data = dbarray($result)) {
				$data['blanks'] = $blanks;
				$data['owner'] = tracsvn_getalias($data['owner']);
				$data['reporter'] = tracsvn_getalias($data['reporter']);
				$variables['tickets'][] = $data;
			}
		} else {
			redirect(FUSION_SELF);
		}
		$variables['status'] = $status;
		break;
	case "ticket":
		$result = dbquery("SELECT * FROM ".$settings['tracsvn_database'].".ticket WHERE id='".stripinput($id)."'");
		if (dbrows($result)) {
			$variables['ticket'] = dbarray($result);
			$variables['ticket']['description'] = tracsvn_wiki2html($variables['ticket']['description']);
			$variables['ticket']['datediff'] = datediff($variables['ticket']['time']);
			if (strpos($variables['ticket']['datediff'], ":") === false) {
				$variables['ticket']['datediff'] .= " ".$locale['420'];
			}
			$variables['ticket']['owner'] = tracsvn_getalias($variables['ticket']['owner']);
			$variables['ticket']['reporter'] = tracsvn_getalias($variables['ticket']['reporter']);
			$result = dbquery("SELECT DISTINCT time FROM ".$settings['tracsvn_database'].".ticket_change WHERE ticket='".stripinput($id)."' ORDER BY time DESC");
			$variables['changes'] = array();
			while ($data = dbarray($result)) {
				$result2 = dbquery("SELECT DISTINCT * FROM ".$settings['tracsvn_database'].".ticket_change WHERE ticket='".stripinput($id)."' AND time = '".$data['time']."' AND newvalue != '' ORDER BY CASE WHEN field = 'comment' THEN 1 ELSE 0 END");
				while ($data2 = dbarray($result2)) {
					$data2['author'] = tracsvn_getalias($data2['author']);
					if ($data2['field'] == "comment") {
						$data2['newvalue'] = tracsvn_wiki2html($data2['newvalue']);
					}
					$variables['changes'][] = $data2;
				}
			}
		} else {
			redirect(FUSION_SELF);
		}
		break;
}

//_debug($variables);

// define the body panel variables
$template_panels[] = array('type' => 'body', 'name' => 'tracsvn.index_panel', 'template' => 'modules.tracsvn.trac.tpl', 'locale' => "modules.tracsvn");
$template_variables['tracsvn.index_panel'] = $variables;

// Call the theme code to generate the output for this webpage
require_once PATH_THEME."/theme.php";
?>
