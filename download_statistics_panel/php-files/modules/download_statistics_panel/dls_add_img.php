<?php
/*---------------------------------------------------+
| PHP-Fusion 6 Content Management System Infusion
+----------------------------------------------------+
| downloadstats.php
| fetch and process the downloads of the PLi download
| sites
+----------------------------------------------------+
| Copyright © 2006 WanWizard
| http://www.pli-images.org/
+----------------------------------------------------*/

define('LOGGING', true);
define('INCLUDE_HOST', false);

// make sure we're running in CLI mode
if (isset($_SERVER['SERVER_SOFTWARE']))
	die("This is a batch program that needs to run from cron!");

// activate all error reporting
error_reporting(E_ALL);

// make sure there is no interference from already installed PEAR modules
ini_set('include_path', '.');

/*---------------------------------------------------+
| Local functions
+----------------------------------------------------*/

// debug function - write an entry to the debug log
function writelog($key, $message="") {

	$handle = fopen('logs/dls_'.$key.'.log', 'a');
	fwrite($handle, date("Ymd").";".date("His").";".$message."\n");
	fclose($handle);
}

/*---------------------------------------------------+
| Read the user configuration
+----------------------------------------------------*/

// find the core modules
$webroot = "";
while(!file_exists($webroot."includes/core_functions.php")) { 
	$webroot .= '../'; 
	if (strlen($webroot)>100) die('Unable to find the PLi-Fusion core modules!'); 
}
require_once $webroot."includes/core_functions.php";

/*---------------------------------------------------+
| local variables
+----------------------------------------------------*/

/*---------------------------------------------------+
| main 
+----------------------------------------------------*/
echo "\n--------------------------------\n".date("Y-m-d H:i:s T")."\n--------------------------------\n";

// loop through the defined file mappings
$result = dbquery("SELECT * FROM ".$db_prefix."dls_mapping");
$mapping = array();
while ($data = dbarray($result)) {
	// get the count of each alias
	$data2 = dbarray(dbquery("SELECT COUNT(*) AS count FROM ".$db_prefix."dls_statistics WHERE ds_file = '".urldecode($data['ds_file_from'])."'"));
	if (isset($mapping[urldecode($data['ds_file_to'])]))
		$mapping[urldecode($data['ds_file_to'])] += $data2['count'];
	else
		$mapping[urldecode($data['ds_file_to'])] = $data2['count'];
}

foreach($mapping as $key => $value) {
	echo "Found: ".$key." -> ".$value."\n";
}

// process the new statistics, and add them to fusion_download_stats
$result = dbquery("SELECT * FROM ".$db_prefix."downloads");
if (dbrows($result) != 0) {
	while ($data = dbarray($result)) {
		if ($data['download_url'] != "") {
			if(preg_match("@^(?:http://)?([^/]+)(.*)@si", $data['download_url'], $urlparts)) {
//				print_r($urlparts);
			} else {
				echo "failed to detect a proper formatted URL: ".$data['download_url']."\n";
				continue;
			}
			if (isset($mapping[urldecode($urlparts[2])])) {
				echo "UPDATE ".$db_prefix."downloads SET download_count = download_count + '".$mapping[urldecode($urlparts[2])]."' WHERE download_id = '".$data['download_id']."'\n";
				$result2 = dbquery("UPDATE ".$db_prefix."downloads SET download_count = download_count + '".$mapping[urldecode($urlparts[2])]."' WHERE download_id = '".$data['download_id']."'");
				$mapping[urldecode($urlparts[2])] = -1;
			}
		}
	}
}

foreach($mapping as $key => $value) {
	if ($value != -1)
		echo "Missed: ".$key." -> ".$value."\n";
}
echo "\n";
?>