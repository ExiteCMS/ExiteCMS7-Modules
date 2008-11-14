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
| $Id:: viewpage.php 1935 2008-10-29 23:42:42Z WanWizard              $|
+----------------------------------------------------------------------+
| Last modified by $Author:: WanWizard                                $|
| Revision number $Rev:: 1935                                         $|
+---------------------------------------------------------------------*/
require_once dirname(__FILE__)."/../../../includes/core_functions.php";

// check for the proper admin access rights
if (!CMS_CLI && (!checkrights("T") || !defined("iAUTH") || $aid == iAUTH)) fallback(ADMIN."index.php");

/*---------------------------------------------------+
| local variables
+----------------------------------------------------*/

// TODO - need to move these values to an admin interface and configuration table!!

$localkey = md5("exb001-1.exite.nl"."*"."94.75.199.4");	// internal IP address
$remotekey = md5("exb001-1.exite.nl"."*"."94.75.199.4");	// external IP address

$logfile = "/logs/downloads.log";

$stats_urls = array();
//$stats_urls[0] = "testfile.log";		// test file
$stats_urls[1] = "http://download1.pli-images.org".$logfile."?key=".$localkey;		// Exite
$stats_urls[2] = "http://download2.pli-images.org".$logfile."?key=".$remotekey;		// NedLinux
$stats_urls[3] = "http://download3.pli-images.org".$logfile."?key=".$remotekey;		// Graver
//$stats_urls[4] = "http://download4.pli-images.org".$logfile."?key=".$remotekey;		// Snoopy

/*---------------------------------------------------+
| local functions                                    |
+----------------------------------------------------*/
function display($text="") {

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
ini_set('memory_limit', '32M');
ini_set('max_execution_time', '0');

// make sure there is no interference from already installed PEAR modules
ini_set('include_path', '.');

// activate all error reporting
error_reporting(E_ALL);

// load the GeoIP functions
require_once PATH_INCLUDES."geoip_include.php";

// load the download log include
require_once dirname(__FILE__)."/../download_include.php";

// load the theme functions when not in CLI mode
if (!CMS_CLI) {
	require_once PATH_INCLUDES."theme_functions.php";
} else {
	while (@ob_end_flush());
}

// save the debug log setting, then disable it
$db_log = $_db_log;
$_db_log = false;

// define the array to store our progress messages in
$messages = array();

// replace numeric entities
$settings['dlstats_geomap_regex'] = preg_replace('~&#x([0-9a-f]+);~ei', 'chr(hexdec("\\1"))', $settings['dlstats_geomap_regex']);
$settings['dlstats_geomap_regex'] = preg_replace('~&#([0-9]+);~e', 'chr("\\1")', $settings['dlstats_geomap_regex']);
// replace other HTML entities
$settings['dlstats_geomap_regex'] = html_entity_decode($settings['dlstats_geomap_regex'], ENT_QUOTES);

// global variable initialisation
$oldfile = "";
$loghandle = false;

// loop through the defined stats url's 

foreach($stats_urls as $key => $url) {
	display("Processing ".$url."...");
	$counter = 0;
	// retrieve the download statistics from this file or URL
	if (isURL($url)) {
		$handle = @fopen($url."&act=get", "r");
	} else {
		$handle = @fopen($url, "r");
	}
	if ($handle) {
		while(!feof($handle)) {
			// get a line
			$buffer = fgets($handle, 4096);
			// get rid of whitespace
			$buffer = trim($buffer);
			// split it into variables
			//
			// Example: 1213868404|123.45.67.89|1|http://www.example.org/this/is/a/downloaded/file.tar.gz
			//
			$record = explode("|", $buffer);
			// verify and validate the log record
			if (isNum($record[0])) {
				if (isIP($record[1], true)) {
					if (isNum($record[2])) {
						if (isURL(trim($record[3]))) {
							if (CMS_CLI) display($buffer);
							// record has a valid format, check if it's in the retry cache
							$download = parse_url($record[3]);
							// add the other record info we might need later on
							$download['mirror'] = $key;
							$download['timestamp'] = $record[0];
							$download['date'] = date("Ymd", $record[0]);
							$download['time'] = date("His", $record[0]);
							$download['ip'] = $record[1];
							$download['on_map'] = preg_match($settings['dlstats_geomap_regex'], trim($download['path']));
							$download['success'] = $record[2];
							// add the download to the statistics tables
							log_download($download['path'], $download['ip'], $download['on_map'], $record[2], $record[0]);
							// generate the new log filename
							$newfile = ($settings['dlstats_logs']{0} == "/" ? "" : PATH_ROOT) . $settings['dlstats_logs']."/".date("Y-", $download['timestamp']).substr('00'.date("W", $download['timestamp']), -2).".download.log";
							// different from the old? close the old file, open the new file
							if ($oldfile != $newfile) {
								if ($loghandle) fclose($loghandle);
								$loghandle = @fopen($newfile, "at");	// append if exists!
								if (!$handle) {
									display("     ERROR! Can not open logfile: ".$newfile);	
									break;
								}
								// store the filename to check if we need to change logsfiles at the next cycle
								$oldfile = $newfile;
							}
							// create a log record
							//
							// Layout -> 1|20070719;131502;1184846124|212.152.84.41|1|/this/is/a/downloaded/file.tar.gz
							//
							$line  = $download['mirror']."|";
							$line .= $download['date'].";".$download['time'].";".$download['timestamp']."|";
							$line .= $download['ip']."|";
							$line .= $download['success']."|";
							$line .= $download['path'];
							$line .= "\n";
							// write the logfile line
							fwrite($loghandle, $line);
							// increase the counter
							$counter++;
						}
					}
				}
			}
		}
		fclose($handle);
		if (isURL($url)) {
			// wipe the processed logfile
			$handle = fopen($url."&act=wipe", "r");
			if ($handle) fclose($handle);
		}
	}
	display($counter." download records processed");
	display();
}
// close the logfile if still open
if ($loghandle) fclose($loghandle);

display("Log processing finished!");

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
	$template_panels[] = array('type' => 'body', 'name' => 'admin.tools.output', 'title' => "Download Log Parser", 'template' => '_custom_html.tpl');
	$template_variables['admin.tools.output'] = $variables;
	
	// Call the theme code to generate the output for this webpage
	require_once PATH_THEME."/theme.php";
}
?>
