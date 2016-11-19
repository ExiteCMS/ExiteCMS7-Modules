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
if (strpos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false || !defined('INIT_CMS_OK')) die();

// array to store variables we want to use in the report template
$reportvars = array();

// make sure we have an action variable
if (isset($action)) {

	// check if we have a rowstart value
	if (!isset($rowstart)) $rowstart = 0;

	if ($action == "") {

			// pre-processing

	} else {

		// create the query for the report
		$sql = "SELECT dlsf_file, dlsf_counter FROM ".$db_prefix."dlstats_files";

		// get the required variables (could be POST or GET vars!)
		if (isset($filter)) {
			$filter = stripinput($filter);
		} else {
			$filter = isset($_POST['filter']) ? stripinput($_POST['filter']) : "";
		}
		if (!isset($regex)) {
			$regex = isset($_POST['regex']) ? $_POST['regex'] : 0;
		}
		if (!isset($order)) {
			$order = isset($_POST['sortorder']) ? $_POST['sortorder'] : 0;
		}
		if (!isset($top)) {
			$top = isset($_POST['top']) ? $_POST['top'] : 0;
		}

		// construct the page navigator to allow paging
		$variables['pagenav_url'] = FUSION_SELF."?action=report&amp;report_id=".$report_id."&amp;";
		$variables['pagenav_url'] .= "filter=".$filter."&amp;";
		$variables['pagenav_url'] .= "regex=".$regex."&amp;";
		$variables['pagenav_url'] .= "top=".$top."&amp;";
		$variables['pagenav_url'] .= "order=".$order."&amp;";

		// check if this filter is a regex, if so, test it first
		if ($regex == 1) {
			if (!empty($filter)) {
				// validate the regex first
				$ts = ini_set("track_errors", "1");
				$test = @preg_replace("|".$filter."|", "x", "x");
				if (is_null($test)) {
					$variables['message'] .= ($variables['message']==""?"":"<br />").$locale['dls809']." '".$php_errormsg;
				} else {
					$sql .= $filter=="" ? "" : (" WHERE dlsf_file REGEXP '".$filter."'");
				}
				$ts = ini_set("track_errors", $ts);
			}
		} else {
			$sql .= $filter=="" ? "" : (" WHERE dlsf_file LIKE '%".$filter."%'");
		}

		// only continue when there was no error
		if (!isset($variables['message'])) {
			// add the order field
			if ($order == 1) {
				$sql .= " ORDER BY dlsf_counter ASC";
			} else {
				$sql .= " ORDER BY dlsf_counter DESC";
			}

			// check how many rows this would output
			$rptresult = dbquery($sql.($top?" LIMIT $top":""));
			if ($rptresult) {
				// store some row counter for the pager
				$variables['rows'] = dbrows($rptresult);
				$variables['rowstart'] = $rowstart;

				// now add a query limit, make sure not to overshoot the limit requested
				if ($variables['rows']-$rowstart > $settings['numofthreads']) {
					$sql .= " LIMIT ".$rowstart.",".$settings['numofthreads'];
				} else {
					$sql .= " LIMIT ".$rowstart.",".($variables['rows']-$rowstart);
				}
				$rptresult = dbquery($sql);

				// get the results
				$reportvars['output'] = array();
				while ($rptdata = dbarray($rptresult)) {
					$rptdata['_rownr'] = ++$rowstart;
					$reportvars['output'][] = $rptdata;
				}
			} else {
				$variables['message'] = $locale['dls950']." ".mysqli_error($_db_link);
			}
		}
	}
}
?>
