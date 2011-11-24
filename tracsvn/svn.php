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
| $Id:: svn.php 2043 2008-11-16 14:25:18Z WanWizard                   $|
+----------------------------------------------------------------------+
| Last modified by $Author:: WanWizard                                $|
| Revision number $Rev:: 2043                                         $|
+---------------------------------------------------------------------*/
require_once dirname(__FILE__)."/../../includes/core_functions.php";
require_once PATH_ROOT."/includes/theme_functions.php";

require_once "tracsvn_include.php";

// check if the Trac database exists and is accessable
if (empty($settings['tracsvn_database']) || !dbtable_exists("revision", $settings['tracsvn_database'])) {
	// redirect back to the trac module for error handling
	redirect("trac.php");
}

// load the locale for this module
locale_load("modules.tracsvn");

// define the variables for this panel
$variables = array();

// get the rights for the current user
$variables['view_svn'] = checkgroup($settings['tracsvn_view_svn']);
if (!$variables['view_svn']) {
	// redirect back to the trac module 
	redirect("trac.php");
}
$variables['view_diff'] = checkgroup($settings['tracsvn_view_diff']);
$variables['view_file'] = checkgroup($settings['tracsvn_view_file']);

// check if we have a revision number
if (!isset($rev) || !isNum($rev)) $rev = 0;
$variables['rev'] = $rev;

// check if we have a filename
if (!isset($file))  $file = "";
$variables['file'] = $file;

// retrieve the SVN data
if ($rev) {
	if (!empty($file)) {
		$output = tracsvn_dump(array('rev' => $rev, 'path' => $file));
		$variables['output'] = $output;
		$variables['is_source'] = !is_array($output);
		$variables['file'] = shortenlink($variables['file'], 80);
	} else {
		$diff_nr = 0;
		$variables['revs'] = array();
		$result = dbquery("SELECT * FROM ".$settings['tracsvn_database'].".revision WHERE rev='".$rev."'");
		if (dbrows($result)) {
			// retrieve the SVN change record
			$data = dbarray($result);
			$data['timediff'] = datediff($data['time']);
			$data['author'] = tracsvn_getalias($data['author']);
			$data['message'] = tracsvn_wiki2html($data['message']);
			$variables['revs'][] = $data;
			// retrieve the SVN change details
			$variables['nodes'] = array();
			$variables['diffs'] = array();
			$result = dbquery("SELECT * FROM ".$settings['tracsvn_database'].".node_change WHERE rev='".$rev."'");
			if (dbrows($result)) {
				$filters = explode("\r\n", $settings['tracsvn_svn_filter']);
				while ($data = dbarray($result)) {
					$data['change_filtered'] = false;
					$data['base_filtered'] = false;
					if (!$variables['view_file']) {
						foreach($filters as $filter) {
							if (empty($filter)) continue;
							if ($filter && substr($data['path'],0, strlen($filter)) == $filter) {
								$data['change_filtered'] = true;
								break;
							}
						}
						foreach($filters as $filter) {
							if (empty($filter)) continue;
							if ($filter && substr($data['base_path'],0, strlen($filter)) == $filter) {
								$data['base_filtered'] = true;
								break;
							}
						}
					}
					$data['s_path'] = shortenlink($data['path'], 70);
					$data['s_base_path'] = shortenlink($data['base_path'], 60);
					// get the file extension
					$pathinfo = pathinfo($data['path']);
					if (!isset($pathinfo['extension'])) $pathinfo['extension'] = "";
					// check if we need to get the diff for this file
					if (!$data['change_filtered'] && $data['change_type'] == "E" && $variables['view_diff'] && in_array($pathinfo['extension'], $tracsvn_extensions)) {
						$data['diff_nr'] = ++$diff_nr;
						$diffs = array('nr' => $data['diff_nr'], 'base_rev' => $data['base_rev'], 'rev' => $data['rev'], 'path' => $data['path']);
						$diffs['output'] = tracsvn_diff($diffs);
						$data['diffs'] = $diffs['output'][0]['diffcount'];
						$variables['diffs'][] = $diffs;
					} else {
						$data['diffs'] = false;
					}
					$variables['nodes'][] = $data;
				}
			}
		}
	}
} else {
	$timebreak = 0;
	$result = dbquery("SELECT * FROM ".$settings['tracsvn_database'].".revision ORDER BY time DESC LIMIT 100");
	$variables['revs'] = array();
	while ($data = dbarray($result)) {
		$data['newdate'] = ($timebreak == date("Y-m-d", $data['time']) ? "0" : "1");
		$timebreak = date("Y-m-d", $data['time']);
		$data['author'] = tracsvn_getalias($data['author']);
		$data['message'] = tracsvn_wiki2html($data['message']);
		$variables['revs'][] = $data;
	}	
}

//_debug($variables, true);

// define the body panel variables
$template_panels[] = array('type' => 'body', 'name' => 'tracsvn.svn_panel', 'template' => 'modules.tracsvn.svn.tpl', 'locale' => "modules.tracsvn");
$template_variables['tracsvn.svn_panel'] = $variables;

// Call the theme code to generate the output for this webpage
require_once PATH_THEME."/theme.php";
?>
