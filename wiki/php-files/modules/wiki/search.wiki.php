<?php
/*---------------------------------------------------+
| ExiteCMS Content Management System                 |
+----------------------------------------------------+
| Copyright 2008 Harro "WanWizard" Verton, Exite BV  |
| for support, please visit http://exitecms.exite.eu |
+----------------------------------------------------+
| Released under the terms & conditions of v2 of the |
| GNU General Public License. For details refer to   |
| the included gpl.txt file or visit http://gnu.org  |
+----------------------------------------------------*/
if (eregi("search.wiki.php", $_SERVER['PHP_SELF']) || !defined('INIT_CMS_OK')) die();

// define the wakka version used
if (!defined('WAKKA_VERSION')) define('WAKKA_VERSION', '1.1.6.3');

// load the wiki config
require_once "wikka.config.php";

// load the wiki library
require_once('libs/Wakka.class.php');

// Create Wakka object
$wakka =& new Wakka($wakkaConfig);

// add the Wikka CSS to the page header, we need some tags
$headerparms = '	<link rel="stylesheet" type="text/css" href="'.$wakka->GetConfigValue("stylesheet").'" />';

// array to store variables we want to use in the search template
$reportvars = array();

// set the page title
$title = $locale['424'];

// make sure we have an action variable
if (isset($action)) {

	if ($action == "") {
		
			// no pre-processing required for this search

	} else {

		// get the required variables (could be POST or GET vars!)
		if (isset($stext)) {
			$stext = stripinput($stext);
		} else {
			$stext = isset($_POST['stext']) ? stripinput($_POST['stext']) : "";
		}
		$stext = str_replace(',', ' ', $stext);
		$variables['stext'] = $stext;

		if (!isset($qtype)) {
			$qtype = isset($_POST['qtype']) ? $_POST['qtype'] : "AND";
		}
		if ($qtype != "OR" && $qtype != "AND") {
			$qtype = "AND";
		}
		if (!isset($datelimit)) {
			$datelimit = isset($_POST['datelimit']) ? $_POST['datelimit'] : 0;
		}
		if (!isNum($datelimit)) {
			$datelimit = 0;
		}
		if (!isset($sortby)) {
			$sortby = isset($_POST['sortby']) ? $_POST['sortby'] : "score";
		}
		if (!in_array($sortby, $select_filters)) {
			$sortby = $select_filters[0];
		}
		if (!isset($order)) {
			$order = isset($_POST['order']) ? $_POST['order'] : 1;
		}
		if (!isNum($order)) {
			$order = 1;
		}
		if (!isset($limit)) {
			$limit = isset($_POST['limit']) ? $_POST['limit'] : 0;
		}
		if (!isNum($limit)) {
			$limit = 0;
		}
		$boolean = isset($_POST['boolean']) ? 0 : 1;

		// basis of the query for this search
		if ($boolean) {
			$sql = "SELECT p.*, u.user_id, 
					MATCH(tag, body) AGAINST ('$stext' IN BOOLEAN MODE) AS score
					FROM ".$wakkaConfig["table_prefix"]."pages p
					LEFT JOIN ".$db_prefix."users u ON u.user_name = p.owner
					WHERE latest = 'Y' AND MATCH(tag, body) AGAINST ('$stext' IN BOOLEAN MODE)";
		} else {
			$sql = "SELECT p.*, u.user_id, 1 AS score
					FROM ".$wakkaConfig["table_prefix"]."pages p
					LEFT JOIN ".$db_prefix."users u ON u.user_name = p.owner
					WHERE latest = 'Y'";
			$searchtext = explode(" ", $stext);
			$searchstring = "";
			foreach($searchtext as $sstring) {
				if (!empty($sstring)) {
					$searchstring .= ($searchstring==""?"":(" ".$qtype))." (tag LIKE '%".trim($sstring)."%' OR body LIKE '%".trim($sstring)."%') ";
				}
			}
			if (!empty($searchstring)) {
				$searchstring = " AND (".$searchstring.")";
			}
			$sql .= $searchstring;
		}

		// construct the page navigator URL to allow paging
		$variables['pagenav_url'] = FUSION_SELF."?action=search&amp;search_id=".$search_id."&amp;";
		$variables['pagenav_url'] .= "stext=".$stext."&amp;";
		$variables['pagenav_url'] .= "boolean=".$boolean."&amp;";
		$variables['pagenav_url'] .= "datelimit=".$datelimit."&amp;";
		$variables['pagenav_url'] .= "sortby=".$sortby."&amp;";
		$variables['pagenav_url'] .= "qtype=".$qtype."&amp;";
		$variables['pagenav_url'] .= "order=".$order."&amp;";
		$variables['pagenav_url'] .= "limit=".$limit."&amp;";

		// add the order field
		switch ($sortby) {
			case "score":
				$sql .= " ORDER BY score ".($order?"ASC":"DESC").", tag ASC";
				break;
			case "count":
				// not implemented
				break;
			case "author":
				$sql .= " ORDER BY owner ".($order?"ASC":"DESC");
				break;
			case "subject":
				$sql .= " ORDER BY tag ".($order?"ASC":"DESC");
				break;
			case "datestamp":
				$sql .= " ORDER BY time ".($order?"ASC":"DESC");
				break;
		}

		// check if we have a rowstart value
		if (!isset($rowstart)) $rowstart = 0;

		// check how many rows this would output
		$rptresult = mysql_query($sql.($limit?" LIMIT $limit":""));
		$variables['rows'] = dbrows($rptresult);
		if ($variables['rows']) {
			// store some row counter for the pager
			$variables['rowstart'] = $rowstart;
			$variables['items_per_page'] = $settings['numofthreads'];

			// now add a query limit, make sure not to overshoot the limit requested
			if ($variables['rows']-$rowstart > $settings['numofthreads']) {
				$sql .= " LIMIT ".$rowstart.",".$settings['numofthreads'];
			} else {
				$sql .= " LIMIT ".$rowstart.",".($variables['rows']-$rowstart);
			}
			$rptresult = dbquery($sql);

			// get the results if any
			if ($variables['rows']) {
				$reportvars['output'] = array();
				$i=0;
				while ($rptdata = dbarray($rptresult)) {
					if ($wakka->HasAccess("read",$rptdata["tag"])) {
						$rptdata['access'] = true;
						// display portion of the matching body and highlight the search term */ 
						preg_match_all("/(.{0,120})($stext)(.{0,120})/is",$rptdata['body'],$matchString);
						if (count($matchString[0]) > 3)
						{
							$matchString[0] = array_splice($matchString[0], 3, count($matchString));
						}
						$text = $wakka->htmlspecialchars_ent(implode('<br />', $matchString[0]));
						$text = str_replace('&lt;br /&gt;', '&hellip;<br />&hellip;', $text);
						// CSS-driven highlighting, tse stands for textsearchexpanded. We highlight $text in 2 steps, 
						// We do not use <span>..</span> with preg_replace to ensure that the tag `span' won't be replaced if
						// $phrase contains `span'.
						$highlightMatch = preg_replace('/('.$wakka->htmlspecialchars_ent($stext).')/i','<<$1>>',$text,-1); // -1 = no limit (default!)
						$rptdata['snippet'] = "&hellip;".str_replace(array('<<', '>>'), array('<span class="tse_keywords">', '</span>'), $highlightMatch)."&hellip;";
					} else {
						$rptdata['access'] = false;
						$rptdata['snippet'] = $locale['427'];
					}
					$reportvars['output'][] = $rptdata;
				}

				// get the score divider for this result set
				$divider = 0;
				foreach($reportvars['output'] as $key => $value) {
					$divider = max($divider, $value['score']);
				}

				// calculate the relevance for this result set
				foreach($reportvars['output'] as $key => $value) {
					$reportvars['output'][$key]['relevance'] = $value['score'] / $divider * 100;
				}
			}
		}
	}
}
?>
