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

define("LOG_RETRY_TIMEOUT", 60 * 10 );	// 10 minutes

// load the GeoIP functions
require_once PATH_INCLUDES."geoip_include.php";

// function to
function log_download($file, $ip, $map=0, $success=1, $timestamp=0) {

	global $db_prefix, $settings, $_db_link;

	// check the parameters
	if (empty($file) || empty($ip) || $ip == "0.0.0.0") {
		return false;
	}
	// check the map variable
	if (!isNum($map) || $map < 0 || $map > 1) {
		$map = 0;
	}
	// check the success variable
	if (!isNum($success) || $success < 0 || $success > 1) {
		$success = 1;
	}
	// check the timestamp variable
	if (!isNum($timestamp) || $timestamp == 0) {
		$timestamp = time();
	}

	// get the country code for this IP
	$cc = GeoIP_IP2Code($ip);

	// delete expired records from the file cache table
	$result = dbquery("DELETE LOW_PRIORITY FROM ".$db_prefix."dlstats_fcache WHERE dlsfc_timeout < ".(time() - LOG_RETRY_TIMEOUT));

	// check if the file it's in the retry cache
	$result = dbquery("SELECT * FROM ".$db_prefix."dlstats_fcache WHERE dlsfc_ip = '".$ip."' AND dlsfc_file = '".mysqli_real_escape_string($file, $_db_link)."'");
	// not in the cache...
	if (dbrows($result) == 0) {
		if (CMS_CLI && function_exists('display')) display("-> not in the file cache");
		// update the IP statistics
		$result2 = dbquery("INSERT INTO ".$db_prefix."dlstats_ips (dlsi_ip, dlsi_ccode, dlsi_onmap, dlsi_counter) VALUES ('".$ip."', '".$cc."', '".$map."', 1) ON DUPLICATE KEY UPDATE dlsi_counter = dlsi_counter + 1".($map == 1 ? ", dlsi_onmap = 1" : ""));
		// update fhe File statistics
		$result2 = dbquery("INSERT INTO ".$db_prefix."dlstats_files (dlsf_file, dlsf_success, dlsf_counter) VALUES ('".$file."', '".$success."', 1) ON DUPLICATE KEY UPDATE dlsf_counter = dlsf_counter + 1");
		// now update the download details for this record
		// get the dlsi_id for this IP
		$result2 = dbquery("SELECT dlsi_id FROM ".$db_prefix."dlstats_ips WHERE dlsi_ip = '".$ip."' LIMIT 1");
		if (dbrows($result2)) {
			$data2 = dbarray($result2);
			// get the dlsf_id for this file
			$result3 = dbquery("SELECT dlsf_id FROM ".$db_prefix."dlstats_files WHERE dlsf_file = '".$file."' LIMIT 1");
			if (dbrows($result3)) {
				$data3 = dbarray($result3);
				$result4 = dbquery("INSERT INTO ".$db_prefix."dlstats_file_ips (dlsi_id, dlsf_id, dlsfi_timestamp) VALUES ('".$data2['dlsi_id']."', '".$data3['dlsf_id']."', '".$timestamp."')");
				if (CMS_CLI && function_exists('display')) display("-> added to the download logs");
			}
		}
		// update download counters if need be
		if ($settings['dlstats_remote']) {
			// do we have a download record for this URL?
			$result2 = dbquery("SELECT * FROM ".$db_prefix."downloads WHERE download_url LIKE '%".$file."' AND download_external = 1");
			while ($data2 = dbarray($result2)) {
				// check if this is a full URL match
				$data2['url'] = parse_url($data2['download_url']);
				if ($file == $data2['url']['path']) {
					// match found, update the counter
					$result3 = dbquery("UPDATE ".$db_prefix."downloads SET download_count=download_count+1 WHERE download_id = '".$data2['download_id']."'");
				}
			}
		}
	}
	// add the record to the file cache (or update the existing record if it was already in the cache
	$result2 = dbquery("INSERT INTO ".$db_prefix."dlstats_fcache (dlsfc_ip, dlsfc_file, dlsfc_timeout) VALUES ('".$ip."', '".mysqli_real_escape_string($_db_link, $file)."', '".time()."') ON DUPLICATE KEY UPDATE dlsfc_timeout = '".time()."'");

	return true;
}
?>
