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
require_once PATH_INCLUDES."geoip_include.php";

/*---------------------------------------------------+
| local variables
+----------------------------------------------------*/


$localkey = md5("server50096.uk2net.com"."*"."83.170.99.141");
$remotekey = md5("server50096.uk2net.com"."*"."83.170.97.97");

$logfile = "/logs/downloads.log";

// TODO - need to move this to an admin interface and config table!!
$stats_urls = array();
$stats_urls[] = "http://download1.pli-images.org".$logfile."?key=".$localkey;		// Exite
$stats_urls[] = "http://download2.pli-images.org".$logfile."?key=".$remotekey;		// NedLinux
$stats_urls[] = "http://download3.pli-images.org".$logfile."?key=".$remotekey;		// Graver
// $stats_urls[] = "http://download4.pli-images.org".$logfile."?key=".$remotekey;		// Snoopy

/*---------------------------------------------------+
| main 
+----------------------------------------------------*/
echo "\n--------------------------------\n".date("Y-m-d H:i:s T")."\n--------------------------------\n";

// loop through the defined stats url's 

foreach($stats_urls as $key => $url) {
	echo "Processing ".$url."...\n";
	// retrieve the download statistics from this URL
	$handle = @fopen($url."&act=get", "r");
	if ($handle) {
		while(!feof($handle)) {
			$buffer = fgets($handle, 4096);
			// ignore empty lines
//			if ($buffer == "" || $buffer = chr(10) || $buffer=chr(13) || $buffer=(chr(10).chr(13)))
//				continue;
			if (LOGGING) writelog($key, $buffer);
			$record = explode("|", $buffer);
			if(preg_match("@^(?:http://)?([^/]+)(.*)@si", $record[3], $urlparts)) {
//				print_r($urlparts);
			} else {
				echo "failed to detect a proper formatted URL: '".$record[3]."'\n";
				echo "-> ".$buffer."\n";
				continue;
			}
			// check if this is a retry (within 10 minutes)
			$result = dbquery("SELECT * FROM ".$db_prefix."dls_statistics WHERE ds_ip = '".$record[1]."' AND ds_file = '".trim(urldecode($urlparts[2]))."' AND ds_timestamp > '".(time()-60*10)."' LIMIT 1");
			if (dbrows($result)) {
				// retry, update the download timestamp, and ignore the retry
				echo "=> Updating (".$record[1].")  : ".trim(urldecode($urlparts[2]))."\n";
				$data = dbarray($result);
				$result = dbquery("UPDATE ".$db_prefix."dls_statistics SET ds_timestamp = '".$record[0]."' WHERE ds_id = '".$data['ds_ip']."'");
			} else {
				// new download, insert a statistics record
				echo "=> Inserting (".$record[1].") : ".trim(urldecode($urlparts[2]))."\n";
				$cc = GeoIP_IP2Code($record[1]);
				if (!$cc) $cc = '';
				$result = dbquery("INSERT INTO ".$db_prefix."dls_statistics (ds_success, ds_ip, ds_timestamp, ds_url, ds_file, ds_mirror, ds_cc) VALUES (
					'".$record[2]."', '".$record[1]."', '".$record[0]."', '".trim(urldecode($record[3]))."', '".trim(urldecode($urlparts[2]))."', '".($key+1)."', '".$cc."')");
			}
		}
		fclose($handle);
		// wipe the processed logfile
		$handle = fopen($url."&act=wipe", "r");
		if ($handle) fclose($handle);
	} else {
   		echo "Unable to fetch URL: ".$url."\n";
	}
}
// process the new statistics, and update the counters of fusion_downloads
$result = dbquery("SELECT * FROM ".$db_prefix."downloads");
if (dbrows($result) != 0) {
	while ($data = dbarray($result)) {
//		echo "processing ".$data['download_url']."...\n";
		if (INCLUDE_HOST) {
			$data2 = dbarray(dbquery("SELECT count(*) as count FROM ".$db_prefix."dls_statistics WHERE ds_url = '".trim(urldecode($data['download_url']))."'"));
		} else {
			if ($data['download_url'] == "") {
				echo "URL not defined";
				// empty URL, skip it
			} else {
				if(preg_match("@^(?:http://)?([^/]+)(.*)@si", $data['download_url'], $urlparts)) {
//					print_r($urlparts);
				} else {
					echo "failed to detect a proper formatted URL: ".$data['download_url']."\n";
					continue;
				}
				// check if there are aliasses defined for this ds_file
				$where = "";
				$result2 = dbquery("SELECT * FROM ".$db_prefix."dls_mapping WHERE ds_file_to = '".trim(urldecode($urlparts[2]))."'");
				while ($data2 = dbarray($result2)) {
					$where .= "OR ds_file = '".urldecode($data2['ds_file_from'])."' ";
				}
				$data2 = dbarray(dbquery("SELECT count(*) as count FROM ".$db_prefix."dls_statistics WHERE (ds_file = '".trim(urldecode($urlparts[2]))."' ".$where.") AND ds_processed = '0'"));
			}
		}
		if (!$data2) {
			// no downloads of this file detected
		} else {
			$result2 = dbquery("UPDATE ".$db_prefix."downloads SET download_count = download_count + '".$data2['count']."' WHERE download_id = '".$data['download_id']."'");
		}
	}
}
// mark all newly imported statistics records as processed
$result = dbquery("UPDATE ".$db_prefix."dls_statistics SET ds_processed = '1' WHERE ds_processed = '0'");

echo "\n";
?>