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
| $Id:: ajax.response.php 2164 2009-01-21 19:09:17Z WanWizard         $|
+----------------------------------------------------------------------+
| Last modified by $Author:: WanWizard                                $|
| Revision number $Rev:: 2164                                         $|
+---------------------------------------------------------------------*/
require_once dirname(__FILE__)."/../../includes/core_functions.php";

error_reporting(0);

// load the locale for this module
locale_load("modules.mileage");

// make sure the page isn't cached
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");

// check if we have both a source and destination
if (empty($_GET['saddr']) || empty($_GET['daddr'])) {
	echo "Address information not complete";
	exit;
}

// check if we have the curl extension available
if (!function_exists('curl_exec')) {
	echo $locale['eA_919'];
	exit;
}

$curl = curl_init("http://maps.google.com/maps?saddr=".str_replace(" ", "%20", stripinput($_GET['saddr'])."&daddr=".stripinput($_GET['daddr']))."&output=kml");
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_HTTPGET, true);
curl_setopt($curl, CURLOPT_POST, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
if (curl_errno($curl) == 0) {
	$found = preg_match("@(.*)(Distance: )(.*)\&\#160;(.*)@i", $response, $matches);
	if (isset($matches[3]) && is_numeric($matches[3])) {
		$dist = trim($matches[3]);
		// need to convert?
		switch (stripinput($_GET['type'])) {
			case "K":
			error_reporting(E_ALL);
				if (substr($matches[4],0,2) == "mi") {
					$dist = $dist * 1.609344;
				}
				break;
			case "M":
				if (substr($matches[4],0,2) == "km") {
					$dist = $dist / 1.609344;
				}
				break;
		}
		echo round($dist);
	} else {
		echo $locale['eA_920'];
	}
	exit;
} else {
	echo curl_error($curl);
}
?>
