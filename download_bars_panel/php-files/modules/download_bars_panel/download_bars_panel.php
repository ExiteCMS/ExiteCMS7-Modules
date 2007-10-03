<?php
/*---------------------------------------------------+
| ExiteCMS Content Management System                 |
+----------------------------------------------------+
| Copyright 2007 Harro "WanWizard" Verton, Exite BV  |
| for support, please visit http://exitecms.exite.eu |
+----------------------------------------------------+
| Released under the terms & conditions of v2 of the |
| GNU General Public License. For details refer to   |
| the included gpl.txt file or visit http://gnu.org  |
+----------------------------------------------------*/
if (eregi("download_bars_panel.php", $_SERVER['PHP_SELF']) || !defined('INIT_CMS_OK')) die();

// array's to store the variables for this panel
$variables = array();

// define the max width of a bar in pixels
$barwidth = 100;

// define the download records we want a bar graph from
$download = array();

// get the download statistics for the required download records
$total = 0;
$result = dbquery("SELECT * FROM ".$db_prefix."downloads WHERE download_bar > '0' ORDER BY download_bar");
while ($data = dbarray($result)) {
	$access = true;
	$cat_id = $data['download_cat'];
	while(true) {
		// check if the user has access to this download item
		$data2 = dbarray(dbquery("SELECT * FROM ".$db_prefix."download_cats WHERE download_cat_id = '".$cat_id."'"));
		if (!checkgroup($data2['download_cat_access'])) {
			$access = false;
			break;
		}
		// if this was a sub-category, check the parent as well
		$cat_id = $data2['download_parent'];
		// if no more parents are present, end the loop
		if ($cat_id == 0) break;
		
	}
	// if the user has access, add this download to the bar panel
	if ($access) {
		$data['download_title'] = strtoupper(substr($data['download_title'],0,6));
		$download[] = $data;
		$total += $data['download_count'];
	}
}
// calculate the percentages of the grand total of all the entries listed (in $total)

$maxperc = 0;
foreach ($download as $key => $value) {
	if ($total == 0)
		$download[$key]['percentage'] = 0;
	else
		$download[$key]['percentage'] = floor($value['download_count'] / $total * 100);
	$maxperc = max($maxperc, $download[$key]['percentage']);
}

// calculate the percentage multiplier to fill out the bars nicely
$multiplier = $maxperc == 0?1:($barwidth / $maxperc);

foreach ($download as $key => $value) {
	$download[$key]['width'] = floor($value['percentage'] * $multiplier);
	$download[$key]['red'] = $download[$key]['width']+100;
	$download[$key]['green'] = $download[$key]['width']+100;
	$download[$key]['blue'] = $download[$key]['width']+100;
}

$variables['title'] = "Downloads (".$total.")";
$variables['barinfo'] = $download;
$variables['barwidth'] = $barwidth;

$template_variables['modules.download_bars_panel'] = $variables;
?>