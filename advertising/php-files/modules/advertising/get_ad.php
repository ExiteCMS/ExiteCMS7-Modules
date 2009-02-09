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

// main ad function. This function returns html code (anchor + image) for an advert of the requested location

function get_ad($location, $bheight=60, $bwidth=468) {

	global $db_prefix, $userdata, $locale;

	// check if the advertisering module is installed
	$result = dbquery("SELECT * FROM ".$db_prefix."modules WHERE mod_folder = 'advertising'");
	if (dbrows($result)==0) {
		// not installed, bail out!
		return "";
	}

	$where = "adverts_status='1' AND adverts_expired = '0' AND ";
	if (is_array($location)) {
		$where .= "adverts_location IN (";
		$comma = false;
		foreach($location as $loc) {
			if ($comma) $where .= ",";
			$comma = true;
			$where .= $loc;
		}
		$where .= ")";
	} else {
		$where .= "adverts_location='".$location."'";
	}

	$advert_html = "";

	$bresult = dbquery("SELECT * FROM ".$db_prefix."advertising WHERE ".$where);
	$gotadverts = dbrows($bresult);
	if($gotadverts > "0") {
		$ads = array();
		while ($data = dbarray($bresult)) {
			// check if the ad image exists
			if (file_exists(PATH_IMAGES_ADS.$data['adverts_image'])) {
				// update the entries according to the priority set
				for($i=1;$i<=$data['adverts_priority'];$i++) {
					$ads[] = $data['adverts_id'];
				}
			}
		}
		$numrows = count($ads);
		if ($numrows == 0) return "";

		//Randomize
		if ($numrows > 1) {
			$numrows = $numrows-1;
			list($usec, $sec) = explode(" ", microtime());
			mt_srand(((float)$usec + (float)$sec));
			$bannum = mt_rand(0, $numrows);
		} else {
				$bannum = 0;
		}

		$bresult2 = dbquery("SELECT * FROM ".$db_prefix."advertising WHERE adverts_id='".$ads[$bannum]."'");
		$advert = dbarray($bresult2);
		if($numrows > 0) {
			// if this a flash ad?
			if (strtolower(substr($advert['adverts_image'],-4,4)) == ".swf") {
				$dimensions = @getimagesize(PATH_IMAGES_ADS.$advert['adverts_image']);
				$advert_html = "<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://active.macromedia.com/flash9/cabs/swflash.cab#version=9,0,0,0\" id=\"AD\" ".$dimensions[3].">
					<param name=movie value=\"".IMAGES_ADS.$advert['adverts_image']."\">
					<param name=\"quality\" value=\"high\">
					<param name=\"bgcolor\" value=\"#ffffff\">
					<embed src=\"".IMAGES_ADS.$advert['adverts_image']."\" quality=\"high\" bgcolor=\"#ffffff\" ".$dimensions[3]." type=\"application/x-shockwave-flash\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\">
					</embed>
					</object>";
			} else {
				$advert_html = "<a target='_blank' href='".$advert['adverts_url']."' onclick='window.location.href=\"".MODULES."advertising/click.php?id=".$advert['adverts_id']."\";return true;'><img src='".IMAGES_ADS.$advert['adverts_image']."' border='0' ".($bheight==0?"":"height='".$bheight."'")." ".($bwidth==0?"":"width='".$bwidth."'")." alt='' /></a>";
			}
			//check ownership user to client id
			if(isset($userdata['user_id']) && $advert['adverts_userid']!=$userdata['user_id']) {
			 	// increment the advert_shown counter
				dbquery("UPDATE ".$db_prefix."advertising SET adverts_shown=adverts_shown+1 WHERE adverts_id='".$advert['adverts_id']."'");
			}
			// check if it should be ended
			$endit = false;
			switch ($advert['adverts_contract']) {
				case 0:
					break;
				case 1:
					// expired by enddate
					if ($advert['adverts_contract_end'] > 0 && $advert['adverts_contract_end'] <= time()) $endit = true;
					break;
				case 2:
					// expired by adverts sold
					if ($advert['adverts_shown'] >= $advert['adverts_sold']) $endit = true;
					break;
				default:
			}
			if ($endit) {
				// add a date and set status to 0
				dbquery("UPDATE ".$db_prefix."advertising SET adverts_expired = '1' WHERE adverts_id = '".$advert['adverts_id']."' LIMIT 1 ;");
			}
		}
	}
	return $advert_html;
}
?>
