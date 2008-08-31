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
require_once dirname(__FILE__)."/../../../includes/core_functions.php";

// check for the proper admin access rights
if (!CMS_CLI && (!checkrights("T") || !defined("iAUTH") || $aid != iAUTH)) fallback(ADMIN."index.php");

/*---------------------------------------------------+
| local functions                                    |
+----------------------------------------------------*/
function display($text) {

	global $messages;

	if (CMS_CLI) {
		// just output the message
		echo $text,"\n";
	} else {
		// replace leading spaces by &nbsp; to keep indentations
		$t = ltrim($text);
		$l = strlen($text) - strlen($t);
		$messages[] = str_repeat("&nbsp;", $l).$t;
	}
}

/*---------------------------------------------------+
| main code                                          |
+----------------------------------------------------*/

// give this module some memory and execution time
ini_set('memory_limit', '128M');
ini_set('max_execution_time', '0');

// load the theme functions when not in CLI mode
if (!CMS_CLI) {
	require_once PATH_INCLUDES."theme_functions.php";
} else {
	while (@ob_end_flush());
	echo "Running in CLI mode...\n";
}

// save the debug log setting, then disable it
$db_log = $_db_log;
$_db_log = false;

// define the array to store our progress messages in
$messages = array();

display("Make sure the tables are empty...");
display(" ");

// empty the dlstats tables
$result = mysql_query("TRUNCATE ".$db_prefix."dlstats_ips");
$result = mysql_query("TRUNCATE ".$db_prefix."dlstats_files");
$result = mysql_query("TRUNCATE ".$db_prefix."dlstats_file_ips");

// if we use external counting, reset the download counters
if ($settings['dlstats_remote']) {
	$result = mysql_query("UPDATE ".$db_prefix."downloads SET download_count = 0");
}

display("import the download statistics log files ...");
display(" ");

// get the files from the logs folder
$logfiles = makefilelist(($settings['dlstats_logs']{0} == "/" ? "" : PATH_ROOT) . $settings['dlstats_logs'], ".|..");

// did we find anything?
if (count($logfiles)) {
	// loop through the files
	foreach($logfiles as $logfile) {
		// check if the logfile has the correct naming (YYYY-MM.download.log
		if (!preg_match("/^[0-9]{4}-[0-9]{2}.download.log$/", $logfile)) {
			// skip if it doesn't match the naming convention
			continue;
		}
		$logfile = ($settings['dlstats_logs']{0} == "/" ? "" : PATH_ROOT) . $settings['dlstats_logs'] . "/".$logfile;
		// create a fully qualified path
		display("Processing logfile: ".$logfile);
		// open the logfile
		$handle = @fopen($logfile, "r");
		if (!$handle) {
			// if it can't be read, print an error and skip it
			display("-> unable to open this logfile!");
			continue;
		}
		// loop through the logfile
		while (!feof($handle)) {
			// get a line from the file
			$logline = trim(fgets($handle));
			// split the line into a record
			$logrec = explode("|", $logline);
			// verify the record
			if (count($logrec) == 5 && isNum($logrec[0]) && isIP($logrec[2]) && isNum($logrec[3]) && isURL("http://www.www.www".$logrec[4])) {
				// record looks clean, check the date and timestamps
				$logrec[1] = explode(";", $logrec[1]);
				if (count($logrec[1]) == 3 && isNum($logrec[1][0]) && isNum($logrec[1][1]) && isNum($logrec[1][2])) {
					// looks ok too, process the record
					if (CMS_CLI) display($logline);
					$logrec['cc'] = GeoIP_IP2Code($logrec[2]);
					$logrec['on_map'] = preg_match($settings['dlstats_geomap_regex'], trim($logrec[4])) ? 1 : 0;
					// update the file cache
					$result = mysql_query("DELETE FROM ".$db_prefix."dlstats_fcache WHERE dlsfc_timeout < ".$logrec[1][2]);
					// check if the file it's in the retry cache
					$result = mysql_query("SELECT * FROM ".$db_prefix."dlstats_fcache WHERE dlsfc_ip = '".$logrec[2]."' AND dlsfc_file = '".mysql_escape_string($logrec[4])."'");
					// not in the cache...
					if (mysql_affected_rows() == 0) {
						if (CMS_CLI) display("-> not in the file cache");
						// update the IP statistics
						$result2 = mysql_query("INSERT INTO ".$db_prefix."dlstats_ips (dlsi_ip, dlsi_ccode, dlsi_onmap, dlsi_counter) VALUES ('".$logrec[2]."', '".$logrec['cc']."', '".$logrec['on_map']."', 1) ON DUPLICATE KEY UPDATE dlsi_counter = dlsi_counter + 1".($logrec['on_map'] == 1 ? ", dlsi_onmap = 1" : ""));
						// update fhe File statistics
						$result2 = mysql_query("INSERT INTO ".$db_prefix."dlstats_files (dlsf_file, dlsf_success, dlsf_counter) VALUES ('".$logrec[4]."', '".$logrec[3]."', 1) ON DUPLICATE KEY UPDATE dlsf_counter = dlsf_counter + 1");
						// now update the download details for this record
						// get the dlsi_id for this IP
						$result2 = mysql_query("SELECT dlsi_id FROM ".$db_prefix."dlstats_ips WHERE dlsi_ip = '".$logrec[2]."' LIMIT 1");
						if (dbrows($result2)) {
							$data2 = mysql_fetch_assoc($result2);
							// get the dlsf_id for this file
							$result3 = mysql_query("SELECT dlsf_id FROM ".$db_prefix."dlstats_files WHERE dlsf_file = '".$logrec[4]."' LIMIT 1");
							if (dbrows($result3)) {
								$data3 = mysql_fetch_assoc($result3);
								$result4 = mysql_query("INSERT INTO ".$db_prefix."dlstats_file_ips (dlsi_id, dlsf_id, dlsfi_timestamp) VALUES ('".$data2['dlsi_id']."', '".$data3['dlsf_id']."', '".$logrec[1][2]."')");
								if (CMS_CLI) display("-> added to the download logs");
							}
						}
						// update download counters if need be
						if ($settings['dlstats_remote']) {
							// do we have a download record for this URL?
							$result2 = mysql_query("SELECT * FROM ".$db_prefix."downloads WHERE download_url LIKE '%".$logrec[4]."' AND download_external = 1");
							while ($data2 = mysql_fetch_assoc($result2)) {
								// check if this is a full URL match
								$data2['url'] = parse_url($data2['download_url']);
								if ($logrec[4] == $data2['url']['path']) {
									// match found, update the counter
									if (true) display("-> updated the corresponding download counter");
									$result3 = mysql_query("UPDATE ".$db_prefix."downloads SET download_count=download_count+1 WHERE download_id = '".$data2['download_id']."'");
								}
							}
						}
					}
					// add the record to the file cache (or update the existing record if it was already in the cache
					$result2 = mysql_query("INSERT INTO ".$db_prefix."dlstats_fcache (dlsfc_ip, dlsfc_file, dlsfc_timeout) VALUES ('".$logrec[2]."', '".mysql_escape_string($logrec[4])."', '".($logrec[1][2]+60*15)."') ON DUPLICATE KEY UPDATE dlsfc_timeout = '".($logrec[1][2]+60*15)."'");


				} else {
					// date issue found
					display("-> ".$logline);
					display("   issue with date or timestamps detected! Record is skipped.");
				}
			} else {
				// validation issue found
				display("-> ".$logline);
				display("   issue with the record layout or values found. Record is skipped.");
				break;
			}
		}
		// finished, close the logfile
		fclose($handle);
	}
} else {
	display("No logfiles found to process!");
}

display(" ");
display("Reload finished!");

// restore the debug log status
$_db_log = $db_log;

// if not in CLI mode, prepare the template for display
if (!CMS_CLI) {
	// used to store template variables
	$variables = array();
	// create the html output
	$variables['html'] = "";
	foreach($messages as $message) {
		$variables['html'] .= $message."<br />"; 
	}
	
	// define the body panel variables
	$template_panels[] = array('type' => 'body', 'name' => 'admin.tools.output', 'title' => "Update GeoIP Database", 'template' => '_custom_html.tpl');
	$template_variables['admin.tools.output'] = $variables;
	
	// Call the theme code to generate the output for this webpage
	require_once PATH_THEME."/theme.php";
}
?>
