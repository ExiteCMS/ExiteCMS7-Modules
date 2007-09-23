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
require_once dirname(__FILE__)."/../../includes/core_functions.php";
require_once PATH_ROOT."/includes/theme_functions.php";

// make sure only the PLi team has access to this function!
$result = dbquery("SELECT group_id FROM ".$db_prefix."user_groups WHERE group_name = 'PLi® team'");
if (!dbrows($result)) fallback("../../index.php");
$data = dbarray($result);
if (!checkgroup($data['group_id'])) fallback("../../index.php");

// temp storage for template variables
$variables = array();

// include the locale for this module
if (file_exists(PATH_MODULES."download_statistics_panel/locale/".$settings['locale'].".php")) {
        $locale_file = PATH_MODULES."download_statistics_panel/locale/".$settings['locale'].".php";
} else {
        $locale_file = PATH_MODULES."download_statistics_panel/locale/English.php";
}
include $locale_file;

// need the geoip module for localisation services
require_once PATH_INCLUDES."geoip_include.php";

// first panel: statistics overview

$data = dbarray(dbquery("SELECT MIN(ds_timestamp) AS timestamp FROM ".$db_prefix."dls_statistics"));
if (!is_array($data)) $data = array("timestamp" => time());
$variables['date_first'] = $data['timestamp'];

$data = dbarray(dbquery("SELECT MAX(ds_timestamp) AS timestamp FROM ".$db_prefix."dls_statistics"));
if (!is_array($data)) $data = array("timestamp" => time());
$variables['date_last'] = $data['timestamp'];

$data = dbarray(dbquery("SELECT COUNT(*) AS count FROM ".$db_prefix."dls_statistics"));
if (!is_array($data)) $data = array("count" => 0);
$variables['stats_count'] = $data['count'];

$data = dbarray(dbquery("SELECT COUNT(DISTINCT ds_url) AS count FROM ".$db_prefix."dls_statistics"));
if (!is_array($data)) $data = array("count" => 0);
$variables['stats_files'] = $data['count'];

// second panels: statistics per download mirror

$variables['stats_mirrors'] = array();
$result = dbquery("SELECT ds_mirror, count(*) as count FROM ".$db_prefix."dls_statistics GROUP BY ds_mirror");
while ($data = dbarray($result)) {
	$data['mirror'] = $data['ds_mirror'] ? ("http://download".$data['ds_mirror'].".pli-images.org") : "Mirror site not recorded";
	$variables['stats_mirrors'][] = $data;
}

// available reports
$variables['reports'] = array();
$variables['reports'][] = array('number' => 1, 'name' => $locale['dls130']);
$variables['reports'][] = array('number' => 2, 'name' => $locale['dls131']);
$variables['reports'][] = array('number' => 3, 'name' => $locale['dls132']);
$variables['reports'][] = array('number' => 4, 'name' => $locale['dls133']);
$variables['reports'][] = array('number' => 5, 'name' => $locale['dls134']);
$variables['reports'][] = array('number' => 6, 'name' => $locale['dls135']);

// box types
$boxtypes = array('DM500', 'DM56x0', 'DM600pvr', 'DM7000', 'DM7020', 'DM7025', 'DM8000');

// image releases (new to old)
$images = array('Helenite', 'Garnet', 'Flubber-The Sequel', 'Flubber', 'Emerald', 'Diamond', 'Citrine', 'Beryl', 'Amber');

if (isset($_POST['show_stats'])) {

	$variables['show_report'] = true;

	// validate the selection
	$top = (isset($_POST['top']) && isNum($_POST['top']) ? $_POST['top'] : 1) * 5;
	$report = isset($_POST['report']) && isNum($_POST['report']) ? $_POST['report'] : 1;
	$filter = isset($_POST['filter']) && isNum($_POST['filter']) ? $_POST['filter'] : 1;
	$variables['top'] = $top;
	$variables['report'] = $report;
	$variables['filter'] = $filter;

	// array to store the raw output
	$output = array();	

	// filter definition
	switch ($filter) {
		case 0:			// no filter
			$where = "";
			$title = "";
			break;
		case 1:			// current image release only
			$where = " AND ds_file LIKE '%pli-".reset($images)."%'";
			$title = " (".$locale['dls140'].")";
			break;
		case 2:
			$where = " AND ds_timestamp > ".(time() - 31*86400);
			$title = " (".$locale['dls141'].")";
			break;
		case 3:
			$where = " AND ds_timestamp > ".(time() - 90*86400);
			$title = " (".$locale['dls142'].")";
		case 4:
			$where = " AND ds_timestamp > ".(time() - 182*86400);
			$title = " (".$locale['dls143'].")";
			break;
	}

	switch ($report) {
		case 1:			// downloads per box type
			$t = 0;
			foreach ($boxtypes as $type) {
				$output[$t] = array('title' => sprintf($locale['dls150'], $type), 'headers' => array($locale['dls151'], $locale['dls152']));
				$temp = array();
				$result = dbquery("SELECT ds_file, count(*) as count FROM ".$db_prefix."dls_statistics WHERE ds_file LIKE '/".strtolower($type)."/%'".$where." GROUP BY ds_file ORDER BY count DESC LIMIT ".$top);
				while ($data = dbarray($result)) {
					$data['ds_file'] = substr(strrchr($data['ds_file'], "/"), 1);
					$temp[] = array(0 => $data['ds_file'], 1 => $data['count']);
				}
				$output[$t++]['values'] = $temp;
			}
			$variables['reporttype'] = 1;
			break;
		case 2:			// downloads per image release
			$t = 0;
			if ($filter == 1) $where = "";
			foreach ($images as $type) {
				$output[$t] = array('title' => sprintf($locale['dls153'], $type), 'headers' => array($locale['dls151'], $locale['dls152']));
				$temp = array();
				$result = dbquery("SELECT ds_file, count(*) as count FROM ".$db_prefix."dls_statistics WHERE ds_file LIKE '%pli-".$type."-dm%'".$where." GROUP BY ds_file ORDER BY count DESC LIMIT ".$top);
				while ($data = dbarray($result)) {
					$data['ds_file'] = substr(strrchr($data['ds_file'], "/"), 1);
					$temp[] = array(0 => $data['ds_file'], 1 => $data['count']);
				}
				$output[$t++]['values'] = $temp;
				if ($filter == 1) break;	// only want the most recent image
			}
			$variables['reporttype'] = 1;
			break;
		case 3:			// image downloads per country
			$result = dbquery("SELECT ds_cc, count(*) as count FROM ".$db_prefix."dls_statistics WHERE ds_file LIKE '%pli-%'".$where." GROUP BY ds_cc ORDER BY count DESC LIMIT ".$top);
			$output[0] = array('title' => $locale['dls154'], 'headers' => array($locale['dls155'], $locale['dls152']));
			$temp = array();
			while ($data = dbarray($result)) {
				$temp[] = array(0 => GeoIP_Code2Flag($data['ds_cc'])." ".GeoIP_Code2Name($data['ds_cc']), 1 => $data['count']);
			}
			$output[0]['values'] = $temp;
			$variables['reporttype'] = 1;
			break;
		case 4:			// downloads per IP address
			$result = dbquery("SELECT ds_ip, ds_cc, count(*) as count FROM ".$db_prefix."dls_statistics WHERE ds_file LIKE '%pli-%'".$where." GROUP BY ds_ip ORDER BY count DESC LIMIT ".$top);
			$output[0] = array('title' => $locale['dls156'], 'headers' => array($locale['dls157'], $locale['dls155'], $locale['dls152']));
			$temp = array();
			while ($data = dbarray($result)) {
				$temp[] = array(0 => $data['ds_ip'], 1 => GeoIP_Code2Flag($data['ds_cc'])." ".GeoIP_Code2Name($data['ds_cc']), 2 => $data['count']);
			}
			$output[0]['values'] = $temp;
			$variables['reporttype'] = 1;
			break;
		case 5:			// plugins per image
			$t = 0;
			if ($filter == 1) $where = "";
			foreach ($images as $type) {
				$output[$t] = array('title' => sprintf($locale['dls153'], $type), 'headers' => array($locale['dls158'], $locale['dls152']));
				$temp = array();
				$result = dbquery("SELECT ds_file, count(*) as count FROM ".$db_prefix."dls_statistics WHERE ds_file LIKE '/".$type."/plugins/%'".$where." GROUP BY ds_file ORDER BY count DESC LIMIT ".$top);
				while ($data = dbarray($result)) {
					$data['ds_file'] = substr(strrchr($data['ds_file'], "/"), 1);
					$temp[] = array(0 => $data['ds_file'], 1 => $data['count']);
				}
				$output[$t++]['values'] = $temp;
				if ($filter == 1) break;	// only want the most recent image
			}
			$variables['reporttype'] = 1;
			break;
		case 6:			// active users per image
			$t = 0;
			if ($filter == 1) $where = "";
			foreach ($images as $type) {
				$output[$t] = array('title' => sprintf($locale['dls153'], $type), 'headers' => array($locale['dls159'], $locale['dls152']));
				$temp = array();
				$result = dbquery("SELECT ds_file, count(distinct ds_ip) as count FROM ".$db_prefix."dls_statistics WHERE ds_file LIKE '/".$type."/%/software.ver'".$where." GROUP BY ds_file ORDER BY count DESC LIMIT ".$top);
				while ($data = dbarray($result)) {
					$data['ds_file'] = substr($data['ds_file'], strpos($data['ds_file'], "xml")+4);
					$data['ds_file'] = substr($data['ds_file'], 0, strpos($data['ds_file'], "/"));
					$temp[] = array(0 => strtoupper($data['ds_file']), 1 => $data['count']);
				}
				$output[$t++]['values'] = $temp;
				if ($filter == 1) break;	// only want the most recent image
			}
			$variables['reporttype'] = 1;
			break;
	}
	// add some extra fields for the report
	$variables['subtitle'] = $title;
	$variables['colcount'] = count($output[0]['headers']);
	$variables['colwidth'] = sprintf("%u", 100 / count($output[0]['headers']));
	$variables['output'] = $output;
} else {
// menu initialisation
	$variables['show_report'] = false;
	$variables['top'] = 1;
	$variables['report'] = 1;
	$variables['filter'] = 1;
}

// define the body panel variables
$template_panels[] = array('type' => 'body', 'name' => 'modules.download_statistics_panel', 'template' => 'modules.download_statistics_panel.tpl', 'locale' => $locale_file);
$template_variables['modules.download_statistics_panel'] = $variables;

// Call the theme code to generate the output for this webpage
require_once PATH_THEME."/theme.php";
?>