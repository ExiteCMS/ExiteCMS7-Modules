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
if (eregi("download_statistics.side_panel.php", $_SERVER['PHP_SELF']) || !defined('INIT_CMS_OK')) die();

// array's to store the variables for this panel
$variables = array();

// define the max width of a bar in pixels
$barwidth = 100;

// define the download records we want a bar graph from
$download = array();

// get the download statistics for the required download records
$total = 0;
$variables['counters'] = array();
$result = dbquery("SELECT * FROM ".$db_prefix."dlstats_counters ORDER BY dlsc_order");
while ($data = dbarray($result)) {
	// start with a count of zero
	$data['count'] = 0;
	// check if we need to get a local download counter
	if ($data['dlsc_download_id'] && $data['dlsc_count_id']) {
		$result2 = dbquery("SELECT d.*, c.download_cat_access FROM ".$db_prefix."downloads d LEFT JOIN ".$db_prefix."download_cats c ON d.download_cat = c.download_cat_id WHERE d.download_id = '".$data['dlsc_download_id']."'");
		if ($data2 = dbarray($result2)) {
			// check if the user has access to it
			if (checkgroup($data2['download_cat_access'])) {
				// get the counter and the download category (needed to create a link)
				$data['download_cat'] = $data2['download_cat'];
				$data['count'] = $data2['download_count'];
			}
		}
	}
	// check if we need to file file counters
	$files = explode("\n", $data['dlsc_files']);
	foreach($files as $file) {
		$result2 = dbquery("SELECT * FROM ".$db_prefix."dlstats_files WHERE dlsf_file = '".trim($file)."'");
		if ($data2 = dbarray($result2)) {
			// get the counter
			$data['count'] += $data2['dlsf_counter'];
		}
	}
	// add the count of this counter to the total
	$total += $data['count'];
	// store this counter
	$variables['counters'][] = $data;
}
$variables['total'] = $total;

// calculate the percentages of the grand total of all the entries listed (in $total)

$maxperc = 0;
foreach ($variables['counters'] as $key => $value) {
	if ($total == 0)
		$variables['counters'][$key]['percentage'] = 0;
	else
		$variables['counters'][$key]['percentage'] = floor($value['count'] / $total * 100);
	$maxperc = max($maxperc, $variables['counters'][$key]['percentage']);
}

// calculate the percentage multiplier to fill out the bars nicely
$multiplier = $maxperc == 0?1:($barwidth / $maxperc);

foreach ($variables['counters'] as $key => $value) {
	$variables['counters'][$key]['width'] = floor($value['percentage'] * $multiplier);
	$variables['counters'][$key]['red'] = $variables['counters'][$key]['width']+100;
	$variables['counters'][$key]['green'] = $variables['counters'][$key]['width']+100;
	$variables['counters'][$key]['blue'] = $variables['counters'][$key]['width']+100;
}

$variables['barinfo'] = $download;
$variables['barwidth'] = $barwidth;

$template_variables['modules.download_statistics.side_panel'] = $variables;
?>
