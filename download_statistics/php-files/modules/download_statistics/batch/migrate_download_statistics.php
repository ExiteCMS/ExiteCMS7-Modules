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

$result = mysql_query("TRUNCATE ".$db_prefix."dlstats_ips");
$result = mysql_query("TRUNCATE ".$db_prefix."dlstats_files");
$result = mysql_query("TRUNCATE ".$db_prefix."dlstats_file_ips");

display("Migrating the old download statistics...");
display(" ");

$tables = array('dls_history', 'dls_statistics');

// loop through the old statistics tables
foreach($tables as $table) {

	// check if the old download statistics tables exist
	if (dbtable_exists($db_prefix.$table)) {

		display("Start migration of the old statistics table '".$table."'!");

		// Fill the ip's table from the old statistics table
		display("Populating the IP table:");
		$result = mysql_query("SELECT ds_ip, ds_cc, count(*) as ds_count, max(ds_onmap) as on_map FROM ".$db_prefix.$table." GROUP BY ds_ip, ds_cc");
		display("-> migrating ".dbrows($result)." records!");
		$data = mysql_fetch_assoc($result);
		while ($data !== false) {
			$result2 = mysql_query("INSERT INTO ".$db_prefix."dlstats_ips (dlsi_ip, dlsi_ccode, dlsi_onmap, dlsi_counter) VALUES ('".$data['ds_ip']."', '".$data['ds_cc']."', '".$data['on_map']."', '".$data['ds_count']."')");
			$data = mysql_fetch_assoc($result);
		}

		// fill the files table from the old statistics table
		display("Populating the Files table:");	
		$result = mysql_query("SELECT ds_file, MAX(ds_success) as success, COUNT(*) as count FROM ".$db_prefix.$table." GROUP BY ds_file");
		display("-> migrating ".dbrows($result)." unique file records!");	
		$data = mysql_fetch_assoc($result);
		while ($data !== false) {
			$urlinfo = parse_url("http://www.example.com".$data['ds_file']);
			$data['ds_file'] = $urlinfo['path'];
			$result2 = mysql_query("INSERT INTO ".$db_prefix."dlstats_files (dlsf_file, dlsf_success, dlsf_counter) VALUES ('".$data['ds_file']."', '".$data['success']."', '".$data['count']."') ON DUPLICATE KEY UPDATE dlsf_counter = dlsf_counter + ".$data['count']);
			$data = mysql_fetch_assoc($result);
		}
		// fill the file_ipss table from the old statistics table and create the logfiles
		display("Creating the new download logfiles:");	
		$result = mysql_query("SELECT * FROM ".$db_prefix.$table." ORDER BY ds_timestamp");
		display("-> creating ".dbrows($result)." log records!");	
		$oldfile = "";
		$handle = false;
		$data = mysql_fetch_assoc($result);
		while ($data !== false) {
			// get the dlsi_id for this IP
			$result2 = mysql_query("SELECT dlsi_id FROM ".$db_prefix."dlstats_ips WHERE dlsi_ip = '".$data['ds_ip']."' LIMIT 1");
			if (dbrows($result2)) {
				$data2 = mysql_fetch_assoc($result2);
				// get the dlsf_id for this file
				$urlinfo = parse_url("http://www.example.com".$data['ds_file']);
				$result3 = mysql_query("SELECT dlsf_id FROM ".$db_prefix."dlstats_files WHERE dlsf_file = '".$urlinfo['path']."' LIMIT 1");
				if (dbrows($result3)) {
					$data3 = mysql_fetch_assoc($result3);
					$result4 = mysql_query("INSERT INTO ".$db_prefix."dlstats_file_ips (dlsi_id, dlsf_id, dlsfi_timestamp) VALUES ('".$data2['dlsi_id']."', '".$data3['dlsf_id']."', '".$data['ds_timestamp']."')");
				}
			}
			// generate the new filename
			$newfile = ($settings['dlstats_logs']{0} == "/" ? "" : PATH_ROOT) . $settings['dlstats_logs']."/".date("Y-", $data['ds_timestamp']).substr('00'.date("W", $data['ds_timestamp']), -2).".download.log";
			// different from the old? close the old file, open the new file
			if ($oldfile != $newfile) {
				if ($handle) fclose($handle);
				$handle = @fopen($newfile, "wt");	// overwrite if exists!
				display("  -> ".$newfile);
				if (!$handle) {
					display("     ERROR! Can not open logfile: ".$newfile);	
					break;
				}
			}
			// store the filename to check if we need to change logsfiles at the next cycle
			$oldfile = $newfile;
			// create the log file line
			//  |DATE    ;TIME  ;UNIXTIME  |IP ADDRESS   | |URL
			// 1|20070719;131502;1184846124|212.152.84.41|1|http://downloads.pli-images.org/helenite/plugins/inadyn_plugin_1.1.0.tar.gz
			$line  = $data['ds_mirror']."|";
			$line .= date("Ymd", $data['ds_timestamp']).";".date("His", $data['ds_timestamp']).";".$data['ds_timestamp']."|";
			$line .= $data['ds_ip']."|";
			$line .= $data['ds_success']."|";
			$line .= $data['ds_url'];
			$line .= "\n";
			// write the logfile line
			fwrite($handle, $line);
			$data = mysql_fetch_assoc($result);
		}
		// make sure the file handle is closed
		if ($handle) fclose($handle);
	} else {

		display("Old statistics table '".$table."' does not exist!");

	}
}

display(" ");
display("Migration finished!");

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
