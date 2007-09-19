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

/*---------------------------------------------------+
| main 
+----------------------------------------------------*/
echo "\n--------------------------------\n".date("Y-m-d H:i:s T")."\n--------------------------------\n";

// process the new statistics
$result = dbquery("SELECT * FROM ".$db_prefix."dls_statistics WHERE ds_cc = ''");
if (dbrows($result) != 0) {
	while ($data = dbarray($result)) {
		$result2 = dbquery("UPDATE ".$db_prefix."dls_statistics SET ds_cc = '".GeoIP_IP2Code($data['ds_ip'])."' WHERE ds_id = '".$data['ds_id']."'");
	}
}
?>
