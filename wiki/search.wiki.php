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

// define the wakka version used
if (!defined('WAKKA_VERSION')) define('WAKKA_VERSION', '1.1.6.3');

// load the wiki config
require_once "wikka.config.php";

// load the wiki library
require_once('libs/Wakka.class.php');

// Create Wakka object
$wakka = new Wakka($wakkaConfig);

// add the Wikka CSS to the page header, we need some tags
$headerparms = '	<link rel="stylesheet" type="text/css" href="'.$wakka->GetConfigValue("stylesheet").'" />';

// set the page title
if ($search_id != 99999) $title = $locale['424'];

// make sure we have an action variable
if (isset($action)) {

	if ($action == "") {

		// add the possible  search filters ($data is defined in the calling script!)
		$data['search_filters' ] = "date,users";

	} else {

		// make sure the sub search ID is defined
		if (!isset($sub_search_id)) $sub_search_id = 0;

		// retrieve the search criteria
		if (isset($_SESSION['search'])) {
			// from the session store (used when paging through the results)
			$stext = $_SESSION['search']['stext'];
			$qtype = $_SESSION['search']['qtype'];
			$datelimit = $_SESSION['search']['datelimit'];
			$boolean = $_SESSION['search']['boolean'];
			$sortby = $_SESSION['search']['sortby'];
			$order = $_SESSION['search']['order'];
			$limit = $_SESSION['search']['limit'];
			$contentfilter_forums = $_SESSION['search']['contentfilter_forums'];
			$contentfilter_users = $_SESSION['search']['contentfilter_users'];
		} else {
			// from the search form
			$stext = isset($_POST['stext']) ? stripinput($_POST['stext']) : "";
			$stext = str_replace(',', ' ', $stext);
			$boolean = isset($_POST['boolean']) ? 0 : 1;
			$qtype = isset($_POST['qtype']) ? stripinput($_POST['qtype']) : "AND";
			if ($qtype != "OR" && $qtype != "AND") {
				$qtype = "AND";
			}
			$sortby = isset($_POST['sortby']) ? stripinput($_POST['sortby']) : "score";
			if (!in_array($sortby, $select_filters)) {
				$sortby = $select_filters[0];
			}
			$order = isset($_POST['order']) && isNum($_POST['order']) ? $_POST['order'] : 1;
			$limit = isset($_POST['limit']) && isNum($_POST['limit']) ? $_POST['limit'] : 0;
			$datelimit = isset($_POST['datelimit']) && isNum($_POST['datelimit']) ? $_POST['datelimit'] : 0;
			// add a forum filter if requested
			if (isset($_POST['contentfilter_forums']) && isNum($_POST['contentfilter_forums']) && $_POST['contentfilter_forums'] > 0 ) {
				$contentfilter_forums =  stripinput($_POST['contentfilter_forums']);
			}
			// add an author if requested
			if (isset($_POST['contentfilter_users']) && isNum($_POST['contentfilter_users']) && $_POST['contentfilter_users'] > 0 ) {
				$contentfilter_users = stripinput($_POST['contentfilter_users']);
			}
		}
		$variables['stext'] = $stext;

		// store the search parameters in the session record
		$_SESSION['search'] = array('stext' => $stext,
									'qtype' => $qtype,
									'datelimit' => $datelimit,
									'boolean' => $boolean,
									'sortby' => $sortby,
									'order' => $order,
									'limit' => $limit,
									'contentfilter_forums' => $contentfilter_forums,
									'contentfilter_users' => $contentfilter_users
								);

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

		// check how many rows this would output
		$rptresult = dbquery($sql.($limit?" LIMIT $limit":""));
		$rows = dbrows($rptresult);

		// are there any results?
		if ($rows) {

			// are we interested in these results?
			if ($lines < $settings['numofthreads'] && $rowstart < $variables['rows'] + $rows) {

				// add a query limit, we might not need all records
				$sql .= " LIMIT ".(max($rowstart-$variables['rows'],0)).",".min($rows,($settings['numofthreads']-$lines));

				// launch the query
				$rptresult = dbquery($sql);

				// get the results if any
				if ($rptresult) {
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
						$rptdata['_template'] = $data['template'];
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

			// add the amount of rows found to the total rows counter
			$variables['rows'] += $rows;

		}

	}
}
?>
