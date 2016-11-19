<?php
/*---------------------------------------------------------------------+
| ExiteCMS Content Management System                                   |
+----------------------------------------------------------------------+
| Copyright 2006-2009 Exite BV, The Netherlands                        |
| for support, please visit http://www.exitecms.org                    |
+----------------------------------------------------------------------+
| Released under the terms & conditions of v2 of the GNU General Public|
| License. For details refer to the included gpl.txt file or visit     |
| http://gnu.org                                                       |
+----------------------------------------------------------------------+
| $Id:: admin.php 2043 2008-11-16 14:25:18Z WanWizard                 $|
+----------------------------------------------------------------------+
| Last modified by $Author:: WanWizard                                $|
| Revision number $Rev:: 2043                                         $|
+---------------------------------------------------------------------*/
require_once dirname(__FILE__)."/../../includes/core_functions.php";
require_once PATH_ROOT."/includes/theme_functions.php";

/*---------------------------------------------------------------------+
| Functions to get descriptions, formats and to convert units          |
+---------------------------------------------------------------------*/


// get the full mileage unit description
function get_mileage_unit_desc($unit = "?") {
	global $locale;

	// get the mileage unit
	switch ($unit) {
		case "K":
			return $locale['eA_653'];
		case "M":
			return $locale['eA_654'];
		default:
			return "unit ".$unit." unknown";
	}

}

// get the abreviated mileage unit description
function get_mileage_unit_abrv($unit = "?") {
	global $locale;

	// get the mileage unit
	switch ($unit) {
		case "K":
			return $locale['eA_665'];
		case "M":
			return $locale['eA_666'];
		default:
			return "unit ".$unit." unknown";
	}

}

// get the format the mileage unit is expressed in
function get_mileage_unit_format($unit = "?") {

	// get the mileage unit
	switch ($unit) {
		case "K":
			return "%d";
		case "M":
			return "%.1F";
		default:
			return "%d";
	}

}

// get the full address type description
function get_address_type_desc($address = "?") {
	global $locale;

	switch($address) {
		case "B":
			return $locale['eA_726'];
		case "P":
			return $locale['eA_727'];
		default:
			return "address type ".$address." unknown";
	}
}


// get the full fuel type description
function get_fuel_type_desc($type = "?") {
	global $locale;

	switch ($type) {
		case "L":
			return $locale['eA_821'];
		case "IG":
			return $locale['eA_822'];
		case "UG":
			return $locale['eA_822'];
		default:
			return "fuel type ".$type." unknown";
	}
}

// get the full fuel type abreviation
function get_fuel_type_abrv($type = "?") {
	global $locale;

	switch ($type) {
		case "L":
			return $locale['eA_673'];
		case "IG":
			return $locale['eA_674'];
		case "UG":
			return $locale['eA_675'];
		default:
			return "fuel type ".$type." unknown";
	}
}

// convert the amount of fuel to liters
function fuel_to_liters($unit = "?", $amount = 0) {

	switch($unit) {
		case "L":
			return $amount;
			break;
		case "IG":
			return $amount * 4.54609188;
		case "UG":
			return $amount * 3.78541178;
		default:
			return -1;
	}
}

/*---------------------------------------------------------------------+
| Start of the main code                                               |
+---------------------------------------------------------------------*/

// load the locale for this module
locale_load("modules.mileage");

// temp storage for template variables
$variables = array();

// only available for logged in users!
if (!iMEMBER) fallback($settings['siteurl']."index.php");

// make sure the parameter is valid
if (isset($travel_id) && !isNum($travel_id)) fallback(FUSION_SELF);
if (isset($car_id) && !isNum($car_id)) fallback(FUSION_SELF);
if (!isset($travel_id)) $travel_id = 0;
if (!isset($car_id)) $car_id = 0;
if (!isset($action)) $action = "";
if (!isset($rowstart)) $rowstart = 0;

// administration rights?
$variables['is_admin'] = checkrights("eA");

// action preprocessing

switch ($action) {

	case "add":
	case "edit":
		if (isset($_POST['save'])) {
			// get and sanitize the variables
			$variables['travel_car_id'] = isNum($_POST['travel_car_id']) ? $_POST['travel_car_id'] : 0;
			$variables['travel_driver_id'] = isNum($_POST['travel_driver_id']) ? $_POST['travel_driver_id'] : $userdata['user_id'];
			$variables['travel_type'] = stripinput($_POST['travel_type']);
			$variables['travel_from'] = isNum($_POST['travel_from']) ? $_POST['travel_from'] : 0;
			$variables['travel_to'] = isNum($_POST['travel_to']) ? $_POST['travel_to'] : 0;
			$variables['travel_mileage'] = isNum(trim($_POST['travel_mileage'])) ? trim($_POST['travel_mileage']) : "";
			$variables['travel_detour'] = isset($_POST['travel_detour']) && isNum(trim($_POST['travel_detour'])) ? trim($_POST['travel_detour']) : 0;
			$variables['travel_detour_type'] = stripinput($_POST['travel_detour_type']);
			$variables['travel_detour_reason'] = stripinput($_POST['travel_detour_reason']);
			$variables['travel_details'] = stripinput($_POST['travel_details']);
			$_POST['travel_fuel'] = str_replace(",", ".", $_POST['travel_fuel']);
			$variables['travel_fuel'] = is_numeric($_POST['travel_fuel']) ? $_POST['travel_fuel'] : 0;
			$variables['travel_fuel_type'] = stripinput($_POST['travel_fuel_type']);
			// travel date components
			$variables['trip_Minute'] = isNum($_POST['trip_Minute']) ? $_POST['trip_Minute'] : 0;
			$variables['trip_Hour'] = isNum($_POST['trip_Hour']) ? $_POST['trip_Hour'] : 0;
			$variables['trip_Month'] = isNum($_POST['trip_Month']) ? $_POST['trip_Month'] : 0;
			$variables['trip_Day'] = isNum($_POST['trip_Day']) ? $_POST['trip_Day'] : 0;
			$variables['trip_Year'] = isNum($_POST['trip_Year']) ? $_POST['trip_Year'] : 0;
			// compose the date value from the values entered
			$variables['travel_date'] = mktime($variables['trip_Hour'], $variables['trip_Minute'], 0, $variables['trip_Month'], $variables['trip_Day'], $variables['trip_Year']);
			// new address information
			$variables['new_ident'] = stripinput($_POST['new_ident']);
			$variables['new_address'] = stripinput($_POST['new_address']);
			$variables['new_postcode'] = stripinput($_POST['new_postcode']);
			$variables['new_city'] = stripinput($_POST['new_city']);
			$variables['new_country'] = stripinput($_POST['new_country']);
			// validate the input
			if ($variables['travel_mileage'] == "") {
				// mileage required
				$variables['message'] = $locale['eA_910'];
			} elseif ($variables['travel_fuel'] < 0) {
				// fuel amount can not be smaller that 0
				$variables['message'] = $locale['eA_922'];
			} elseif ($variables['travel_to'] == 0 && $variables['travel_type'] == "B" && (empty($variables['new_ident']) || empty($variables['new_address']) || empty($variables['new_city']))) {
				// need or existing address, or a new address (at least ident, address, city and coutry!)
				$variables['message'] = $locale['eA_911'];
			} elseif ($variables['trip_Hour'] == 0 || $variables['trip_Day'] == 0 || $variables['trip_Month'] == 0 || $variables['trip_Year'] == 0) {
				// invalid date (should not be possible due to dropdown selection)
				$variables['message'] = $locale['eA_912'];
			} elseif ($variables['travel_detour'] != "" && $variables['travel_detour_type'] == "B" && empty($variables['travel_detour_reason']) && empty($variables['travel_details'])) {
				// for business detours, a reason or explaination is required
				$variables['message'] = $locale['eA_913'];
			} elseif ($variables['travel_detour'] != "" && $variables['travel_detour'] > $variables['travel_mileage']) {
				// detour can not be bigger that the distance traveled
				$variables['message'] = $locale['eA_914'];
			} else {
				// if we have a new address, add it first (if needed), and get the adr_id
				if (!empty($variables['new_ident'])) {
					$result = dbquery("SELECT adr_id FROM ".$db_prefix."mileage_address WHERE adr_driver_id = '".$variables['travel_driver_id']."' AND adr_description = '".mysqli_real_escape_string($variables['new_ident'], $_db_link)."'");
					if (dbrows($result)) {
						// existing address identification. Update the address
						$data = dbarray($result);
						$variables['travel_to'] = $data['adr_id'];
						$result = dbquery("UPDATE ".$db_prefix."mileage_address SET adr_address = '".mysqli_real_escape_string($variables['new_address'], $_db_link)."', adr_postcode = '".mysqli_real_escape_string($variables['new_postcode'], $_db_link)."', adr_city = '".mysqli_real_escape_string($variables['new_city'], $_db_link)."', adr_country = '".$variables['new_country']."' WHERE adr_id = '".$data['adr_id']."'");
					} else {
						// new address, add it
						$result = dbquery("INSERT INTO ".$db_prefix."mileage_address (adr_driver_id, adr_description, adr_address, adr_postcode, adr_city, adr_country) VALUES('".$variables['travel_driver_id']."', '".mysqli_real_escape_string($variables['new_ident'], $_db_link)."', '".mysqli_real_escape_string($variables['new_address'], $_db_link)."', '".mysqli_real_escape_string($variables['new_postcode'], $_db_link)."', '".mysqli_real_escape_string($variables['new_city'], $_db_link)."', '".$variables['new_country']."')");
						$variables['travel_to'] = mysqli_insert_id($_db_link);
					}
				}
				// save this distance between these two locations as default
				if (isset($_POST['save_mileage'])) {
					$result = dbquery("SELECT * FROM ".$db_prefix."mileage_distance WHERE distance_from = '".$variables['travel_from']."' AND distance_to = '".$variables['travel_to']."'");
					if (dbrows($result) == 0) {
						$result = dbquery("INSERT INTO ".$db_prefix."mileage_distance (distance_from, distance_to, distance_mileage) VALUES ('".$variables['travel_from']."', '".$variables['travel_to']."', '".$variables['travel_mileage']."')");
					} else {
						$result = dbquery("UPDATE ".$db_prefix."mileage_distance SET distance_mileage = '".$variables['travel_mileage']."' WHERE distance_from = '".$variables['travel_from']."' AND distance_to = '".$variables['travel_to']."'");
					}
				}
				// save the detour between these two locations as default
				if (isset($_POST['save_detour'])) {
					$result = dbquery("UPDATE ".$db_prefix."mileage_distance SET distance_detour = '".$variables['travel_detour']."', distance_detour_type = '".$variables['travel_detour_type']."', distance_detour_reason = '".mysqli_real_escape_string($variables['travel_detour_reason'], $_db_link)."' WHERE distance_from = '".$variables['travel_from']."' AND distance_to = '".$variables['travel_to']."'");
				}
				if ($action == "add") {
					// add the new car
					$result = dbquery("INSERT INTO ".$db_prefix."mileage_travel (travel_car_id, travel_driver_id, travel_to, travel_type, travel_mileage, travel_date, travel_detour, travel_detour_type, travel_detour_reason, travel_details, travel_fuel, travel_fuel_type) VALUES ('".$variables['travel_car_id']."', '".$variables['travel_driver_id']."', '".$variables['travel_to']."', '".$variables['travel_type']."', '".$variables['travel_mileage']."', '".$variables['travel_date']."', '".$variables['travel_detour']."', '".$variables['travel_detour_type']."', '".mysqli_real_escape_string($variables['travel_detour_reason'], $_db_link)."', '".mysqli_real_escape_string($variables['travel_details'], $_db_link)."', '".$variables['travel_fuel']."', '".$variables['travel_fuel_type']."')");
					// return to the main panel with a success message
					$variables['message'] = $locale['eA_915'];
				} elseif ($action == "edit") {
					// update the trip
					$result = dbquery("UPDATE ".$db_prefix."mileage_travel SET travel_car_id = '".$variables['travel_car_id']."', travel_driver_id = '".$variables['travel_driver_id']."', travel_to = '".$variables['travel_to']."', travel_type = '".$variables['travel_type']."', travel_mileage = '".$variables['travel_mileage']."', travel_date = '".$variables['travel_date']."', travel_detour = '".$variables['travel_detour']."', travel_detour_type = '".$variables['travel_detour_type']."', travel_detour_reason = '".mysqli_real_escape_string($variables['travel_detour_reason'], $_db_link)."', travel_details = '".mysqli_real_escape_string($variables['travel_details'], $_db_link)."', travel_fuel = '".$variables['travel_fuel']."', travel_fuel_type = '".$variables['travel_fuel_type']."' WHERE travel_id = '".$travel_id."'");
					// return to the main panel with a success message
					$variables['message'] = $locale['eA_917'];
				}
				// return to the travel list of this car
				$action = "list";
			}
		} else {
			$variables['new_ident'] = "";
			$variables['new_address'] = "";
			$variables['new_postcode'] = "";
			$variables['new_city'] = "";
			$variables['new_country'] = strtoupper($settings['country']);
			if ($action == "add") {
				$variables['travel_id'] = 0;
				$variables['travel_car_id'] = $car_id;
				$variables['travel_driver_id'] = 0;
				$variables['travel_to'] = "";
				$variables['travel_type'] = "B";
				$variables['travel_mileage'] = 0;
				$variables['travel_date'] = time();
				$variables['travel_detour'] = 0;
				$variables['travel_detour_type'] = "P";
				$variables['travel_detour_reason'] = "";
				$variables['travel_details'] = "";
				$variables['travel_fuel'] = 0;
				$variables['travel_fuel_type'] = "L";
			} else {
				if (!$travel_id) fallback(FUSION_SELF);
				$result = dbquery("SELECT * FROM ".$db_prefix."mileage_travel WHERE travel_id = '".$travel_id."'");
				if (dbrows($result)) {
					$data = dbarray($result);
					$variables['travel_id'] = $travel_id;
					$variables['travel_car_id'] = $data['travel_car_id'];
					$variables['travel_driver_id'] = $data['travel_driver_id'];
					$variables['travel_to'] = $data['travel_to'];
					$variables['travel_type'] = $data['travel_type'];
					$variables['travel_mileage'] = $data['travel_mileage'];
					$variables['travel_date'] = $data['travel_date'];
					$variables['travel_detour'] = $data['travel_detour'];
					$variables['travel_detour_type'] = $data['travel_detour_type'];
					$variables['travel_detour_reason'] = $data['travel_detour_reason'];
					$variables['travel_details'] = $data['travel_details'];
					$variables['travel_fuel'] = $data['travel_fuel'];
					$variables['travel_fuel_type'] = $data['travel_fuel_type'];
				} else {
					// not found?
					$variables['message'] = $locale['eA_916'];
					$action = "list";
				}
			}
		}
		switch ($action) {
			case "add":
				$variables['formaction'] = FUSION_SELF."?car_id=".$car_id."&amp;action=add";
				// break intentionally omitted

			case "edit":
				if (!isset($variables['formaction'])) $variables['formaction'] = FUSION_SELF."?car_id=".$car_id."&amp;travel_id=".$travel_id."&amp;action=edit";
				// get the info of the car selected
				$variables['car'] = dbarray(dbquery("SELECT * FROM ".$db_prefix."mileage_car WHERE car_id = '".$car_id."'"));
				if (is_array($variables['car'])) {
					// get the mileage unit
					$variables['car']['mileage_unit'] = get_mileage_unit_desc($variables['car']['car_mileage_unit']);
					// get the total milage for this car
					if ($action == "add") {
						$total = dbfunction("SUM(travel_mileage)", "mileage_travel", "travel_car_id = ".$car_id);
						// get the last trip registered for this car
						$result = dbquery("SELECT a.* FROM ".$db_prefix."mileage_travel t LEFT JOIN ".$db_prefix."mileage_address a ON t.travel_to = a.adr_id WHERE t.travel_car_id = '".$car_id."' ORDER BY t.travel_date DESC LIMIT 1");
					} elseif ($action == "edit") {
						$total = dbfunction("SUM(travel_mileage)", "mileage_travel", "travel_car_id = ".$car_id." AND travel_date < ".$variables['travel_date']);
						// get the previous trip registered for this car
						$result = dbquery("SELECT a.* FROM ".$db_prefix."mileage_travel t LEFT JOIN ".$db_prefix."mileage_address a ON t.travel_to = a.adr_id WHERE travel_date < ".$variables['travel_date']." AND t.travel_car_id = '".$car_id."' ORDER BY t.travel_date DESC LIMIT 1");
					}
					$variables['car']['car_total_mileage'] = $variables['car']['car_mileage'] + (is_null($total) ? 0 : $total);
					if (dbrows($result)) {
						$variables['travel'] = dbarray($result);
						if (is_null($variables['travel']['adr_id'])) {
							// No, it's private
							$variables['travel']['adr_id'] = 0;
							$variables['travel']['adr_type'] = "P";
							$variables['travel']['adr_description'] = "";
						}
					} else {
						// if no previous trip is found, get the car delivery address
						$result = dbquery("SELECT a.* FROM ".$db_prefix."mileage_address a WHERE a.adr_id = '".$variables['car']['car_start_from']."' LIMIT 1");
						if (dbrows($result)) {
							$variables['travel'] = dbarray($result);
						} else {
							$variables['travel'] = array();
						}
					}
					// get the start address type description
					$variables['travel']['adr_type_desc'] = get_address_type_desc($variables['travel']['adr_type']);
					// determine the (list of) driver(s)
					$variables['users'] = array();
					if ($variables['is_admin']) {
						$result = dbquery("SELECT u.user_id, u.user_name, u.user_fullname FROM ".$db_prefix."mileage_drivers d, ".$db_prefix."users u WHERE d.driver_user_id = u.user_id AND d.driver_car_id = '".$car_id."'");
					} else {
						$result = dbquery("SELECT user_id, user_name, user_fullname FROM ".$db_prefix."users WHERE user_id = '".$userdata['user_id']."' ORDER BY user_name");
					}
					while ($data = dbarray($result)) {
						$variables['users'][] = $data;
					}
					// get all addresses available
					$variables['address'] = array();
					if ($variables['is_admin']) {
						$result = dbquery("SELECT * FROM ".$db_prefix."mileage_address ORDER BY adr_description");
					} else {
						//  for this driver only
						$result = dbquery("SELECT * FROM ".$db_prefix."mileage_address WHERE adr_driver_id = '".$userdata['user_id']."' OR adr_driver_id = '0' ORDER BY adr_description");
					}
					// add the address type description
					while ($data = dbarray($result)) {
						$data['adr_type_desc'] = get_address_type_desc($data['adr_type']);
						$variables['address'][] = $data;
					}
					// get all distances recorded
					$variables['distance'] = array();
					$result = dbquery("SELECT * FROM ".$db_prefix."mileage_distance WHERE distance_from = '".$variables['travel']['adr_id']."' ORDER BY distance_to");
					while ($data = dbarray($result)) {
						$variables['distance'][] = $data;
					}
				} else {
					// car selected not found, return to the selection list
					$action = "";
				}
				break;
		}
		break;

	case "list":
		break;

	case "print":
		if (isset($_POST['print']) && isset($_POST['report_option'])) {

			// determine start and end of the report
			$start = mktime(0,0,0,$_POST['start_Month'],$_POST['start_Day'],$_POST['start_Year']);
			$end = mktime(23,59,59,$_POST['end_Month'],$_POST['end_Day'],$_POST['end_Year']);

			// get the userid of the selected driver
			$user_id = (isset($_POST['travel_driver_id']) && isNum($_POST['travel_driver_id'])) ? $_POST['travel_driver_id'] : 0;

			// get the report option
			$report_option = (isset($_POST['report_option']) && isNum($_POST['report_option'])) ? $_POST['report_option'] : 0;
			$variables['report_option'] = $report_option;

			// get the info of the car selected
			$variables['car'] = dbarray(dbquery("SELECT d.driver_mileage_unit, d.driver_ssn, c.*, u.user_fullname FROM ".$db_prefix."mileage_drivers d, ".$db_prefix."mileage_car c, ".$db_prefix."users u WHERE d.driver_car_id = c.car_id AND d.driver_user_id = u.user_id AND c.car_id = '".$car_id."' AND d.driver_user_id = '".$user_id."'"));

			// did we find car information?
			if (is_array($variables['car'])) {

				// get the mileage unit abriviation
				$variables['mileage_unit'] = get_mileage_unit_abrv($variables['car']['driver_mileage_unit']);
				// mileage print format
				$variables['format'] = get_mileage_unit_format($variables['car']['driver_mileage_unit']);
				// the fuel type description
				$variables['fuel_desc'] = get_fuel_type_abrv($variables['car']['car_fuel_type']);
				// and the fuel type mileage description
				$variables['fuelconv_desc'] = get_fuel_type_desc($variables['car']['car_fuel_type']);

				// get the total milage for this car at the start of the period
				$total = dbfunction("SUM(travel_mileage)", "mileage_travel", "travel_car_id = ".$car_id." AND travel_date <= ".$start);
				// mileage at the start of the first trip of this report
				$total = (is_null($total) ? 0 : $total) + $variables['car']['car_mileage'];

				// adjust the report end period if the car has an 'end-of-usage' date
				$variables['period_start'] = $start;
				if ($variables['car']['car_end_date'] > 0  && $variables['car']['car_end_date'] < $end) {
					$variables['period_end'] = $variables['car']['car_end_date'];
				} else {
					$variables['period_end'] = $end;
				}

				// array to store some report totals
				$totals = array('fuel' => 0, 'offset' => $total, 'mileage' => 0, 'business' => 0, 'personal' => 0);

				// array to store the trips in the selected period
				$variables['trips'] = array();

				// check if the delivery date falls in range. If so, that's the start
				$result = dbquery("SELECT c.car_id, c.car_start_date, c.car_fuel, c.car_fuel_type, a.* FROM ".$db_prefix."mileage_car c, ".$db_prefix."mileage_address a WHERE car_id = '".$car_id."' AND car_start_from = adr_id AND car_start_date BETWEEN $start AND $end");
				if (dbrows($result)) {
					// fetch the row
					$data = dbarray($result);
				} else {
					// else we need the last trip before our period selection for our start address
					$result = dbquery("SELECT c.car_id, c.car_start_date, c.car_fuel, c.car_fuel_type, a.*, t.* FROM ".$db_prefix."mileage_car c, ".$db_prefix."mileage_travel t, ".$db_prefix."mileage_address a WHERE car_id = '".$car_id."' AND travel_to = adr_id AND travel_car_id = car_id AND travel_date < $start ORDER BY travel_date DESC LIMIT 1 ");
					// fetch the row
					$data = dbarray($result);
					// we don't know the fuel state at this moment
					$data['car_fuel'] = 0;
				}
				// trip counter initialisation
				$count = dbfunction("COUNT(*)", "mileage_travel", "travel_car_id = ".$car_id." AND travel_date < ".$start) + 1;

				// start mileage information
				$mileage = array('start' => array('from' => $total, 'to' => $total), 'fuel' => array('fuel' => $data['car_fuel'], 'type' => $data['car_fuel_type']));

				// start of the first trip
				$trip = array('from' => array('description' => $data['adr_description'], 'address' => $data['adr_address'], 'postcode' => $data['adr_postcode'], 'city' => $data['adr_city'], 'countrycode' => strtolower($data['adr_country']), 'type' => $data['adr_type'], 'mileage' => $total));

				// fetch all trip records for the selected period, and normalise the information
				$result = dbquery("SELECT t.*, a.* FROM ".$db_prefix."mileage_travel t, ".$db_prefix."mileage_address a WHERE a.adr_id = t.travel_to AND travel_car_id = '".$car_id."' AND travel_date BETWEEN $start AND $end ORDER BY travel_date ASC");

				while ($data = dbarray($result)) {
					// calculate the new mileage
					$total += $data['travel_mileage'];
					// store the destination of this trip
					$trip['to'] = array('description' => $data['adr_description'], 'address' => $data['adr_address'], 'postcode' => $data['adr_postcode'], 'city' => $data['adr_city'], 'countrycode' => strtolower($data['adr_country']), 'type' => $data['adr_type'], 'mileage' => $total);
					// do we need to store fuel consumption information?
					if ($data['travel_fuel']) {
						// store info about this trip
						$mileage['end'] = array('from' => $trip['from']['mileage'], 'to' =>  $trip['to']['mileage']);
						// convert the fuel to litres if needed
						switch($mileage['fuel']['type']) {
							case "L":
								$amount = 1;
								break;
							case "IG":
								$amount = 4.54609188;
								break;
							case "UG":
								$amount = 3.78541178;
								break;
						}
						$mileage['fuel'] = array('fuel' => $data['travel_fuel'] * $amount, 'type' => 'L');
						// calculate averages in the cars fuel type
						if ($variables['car']['car_mileage_unit'] == "K") {
							// liters per 100Km
							$mileage['fuel']['range_min'] = $mileage['fuel']['fuel'] / ($mileage['end']['to'] - $mileage['start']['from']) * 100;
							$mileage['fuel']['range_max'] = $mileage['fuel']['fuel'] / ($mileage['end']['from'] - $mileage['start']['to']) * 100;
						} else {
							// miles per gallon
							switch ($variables['car']['car_fuel_type']) {
								case "L":
									// miles to the liter? Unlikely, so convert to Imperal gallons
								case "IG":
									$mileage['fuel']['fuel'] = $mileage['fuel']['fuel'] / 4.54609188;
									break;
								case "UG":
									$mileage['fuel']['fuel'] = $mileage['fuel']['fuel'] / 3.78541178;
									break;
							}
							$mileage['fuel']['range_min'] = $mileage['fuel']['fuel'] / ($mileage['end']['to'] - $mileage['start']['from']) * 100;
							$mileage['fuel']['range_max'] = $mileage['fuel']['fuel'] / ($mileage['end']['from'] - $mileage['start']['to']) * 100;
						}
						$mileage['fuel']['range'] = ($mileage['fuel']['range_min'] + $mileage['fuel']['range_max']) / 2;
						// and store it in the trip record
						$trip['fuel'] = $mileage;
						// and restart with the fuel info from this trip
						$mileage = array('start' => array('from' => $trip['from']['mileage'], 'to' => $trip['to']['mileage']), 'fuel' => array('fuel' => $data['travel_fuel'], 'type' => $data['travel_fuel_type']));

					}
					// any detour information
					$trip['detour'] = array('mileage' => $data['travel_detour'], 'reason' => $data['travel_detour_reason'], 'type' => $data['travel_detour_type']);
					// trip information
					$trip['trip'] = array('count' => $count, 'date' => $data['travel_date'], 'type' => $data['travel_type'], 'mileage' => $data['travel_mileage'], 'business' => 0, 'personal' => 0, 'details' => $data['travel_details']);
					// split the mileage in business and personal
					if ($trip['trip']['type'] == 'B') {
						$trip['trip']['business'] = $trip['trip']['mileage'];
					} else {
						$trip['trip']['personal'] = $trip['trip']['mileage'];
					}
					if ($trip['trip']['type'] != $trip['detour']['type']) {
						if ($trip['detour']['type'] == 'B') {
							$trip['trip']['personal'] -= $trip['detour']['mileage'];
							$trip['trip']['business'] = $trip['detour']['mileage'];
						} else {
							$trip['trip']['business'] -= $trip['detour']['mileage'];
							$trip['trip']['personal'] = $trip['detour']['mileage'];
						}
					}
					// update the mileage totals
					$totals['mileage'] += $trip['trip']['mileage'];
					$totals['business'] += $trip['trip']['business'];
					$totals['personal'] += $trip['trip']['personal'];
					// add it to the list of trips
					$variables['trips'][] = $trip;
					// this address is also the start of the next trip
					$trip = array('from' => array('description' => $data['adr_description'], 'address' => $data['adr_address'], 'postcode' => $data['adr_postcode'], 'city' => $data['adr_city'], 'countrycode' => strtolower($data['adr_country']), 'type' => $data['adr_type'], 'mileage' => $total));
					// increase the trip counter
					$count++;
				}

				// load the countrycode locales

				locale_load('countrycode');

				// calculate the fuel consumption averages for this report and fetch descriptions

				// loop though all trips
				foreach ($variables['trips'] as $idx => $trip) {
					// trip type description
					foreach(array('from', 'to', 'trip', 'detour') as $leg) {
						// address types
						switch($trip[$leg]['type']) {
							case "B":
								$variables['trips'][$idx][$leg]['type_desc'] = $locale['eA_726'];
								break;
							case "P":
								$variables['trips'][$idx][$leg]['type_desc'] = $locale['eA_727'];
								break;
							default:
								$variables['trips'][$idx][$leg]['type_desc'] = "address type ".$trip[$leg]['type'] ." unknown";
								break;
						}
					}
					// countries
					foreach(array('from', 'to') as $leg) {
						// countries
						$variables['trips'][$idx][$leg]['country'] = $locale[$trip[$leg]['countrycode']];
					}

					// refueling on this trip?
					if (isset($trip['fuel']))
					{
						if (!isset($totals['start'])) {
							$totals['start'] = $trip['fuel']['start'];
						}
						$totals['end'] = $trip['fuel']['end'];
						$totals['fuel'] +=  $trip['fuel']['fuel']['fuel'];
					}
				}

				// calculate the report fuel consumption average
				if ($variables['car']['car_mileage_unit'] == "K") {
					// liters per 100Km
					$totals['range_min'] = $totals['fuel'] / ($totals['end']['to'] - $totals['start']['from']) * 100;
					$totals['range_max'] = $totals['fuel'] / ($totals['end']['from'] - $totals['start']['to']) * 100;
				} else {
					// miles per gallon
					switch ($variables['car']['car_fuel_type']) {
						case "L":
							// miles to the liter? Unlikely, so convert to Imperal gallons
						case "IG":
							$totals['fuel'] = $totals['fuel'] / 4.54609188;
							break;
						case "UG":
							$totals['fuel'] = $totals['fuel'] / 3.78541178;
							break;
					}
					$totals['range_min'] = $totals['fuel'] / ($totals['end']['to'] - $totals['start']['from']) * 100;
					$totals['range_max'] = $totals['fuel'] / ($totals['end']['from'] - $totals['start']['to']) * 100;
				}
				$totals['range'] = ($totals['range_min'] + $totals['range_max']) / 2;
				// and store it
				$variables['totals'] = $totals;

				// define the mileage print panel
				$template_panels[] = array('type' => 'body', 'name' => 'modules.mileage.print', 'template' => 'modules.mileage.mileage.print.tpl', 'locale' => "modules.mileage");
				$template_variables['modules.mileage.print'] = $variables;
				// load the panels
				load_templates('body', '');
				// and clean up
				theme_cleanup();
				// and exit
				exit;
			} else {
				$variables['message'] = $locale['eA_918'];
			}
		} else {
			// get the ranges selectable from the travel table
			$range = dbarray(dbquery("SELECT MIN(travel_date) AS first, MAX(travel_date) as last FROM ".$db_prefix."mileage_travel WHERE travel_car_id = '".$car_id."'"));
			if (empty($range['first'])) $range['first'] = time();
			if (empty($range['last'])) $range['last'] = time();
			if (date("Y", $range['first']) != date("Y", time())) {
				$range['start'] = mktime(0,0,0,1,1,date("Y", time()));
			} else {
				$range['start'] = $range['first'];
			}
			if (date("Y", $range['first']) != date("Y", time())) {
				$range['end'] = mktime(23,59,59,12,31,date("Y", time()));
			} else {
				$range['end'] = $range['last'];
			}
			$range['year_start'] = date("Y", $range['first']);
			$range['year_end'] = date("Y", $range['end']);
			$variables['range'] = $range;
			// determine the (list of) driver(s) for this car
			$variables['users'] = array();
			if ($variables['is_admin']) {
				$result = dbquery("SELECT u.user_id, u.user_name, u.user_fullname FROM ".$db_prefix."mileage_drivers d, ".$db_prefix."users u WHERE d.driver_user_id = u.user_id AND d.driver_car_id = '".$car_id."'");
			} else {
				$result = dbquery("SELECT user_id, user_name, user_fullname FROM ".$db_prefix."users WHERE user_id = '".$userdata['user_id']."' ORDER BY user_name");
			}
			while ($data = dbarray($result)) {
				$variables['users'][] = $data;
			}
		}
		break;

	case "delete":
		$result = dbquery("DELETE FROM ".$db_prefix."mileage_travel WHERE travel_id = '".$travel_id."' AND travel_car_id = '".$car_id."'");
		// reset the action switch to return to the default action
		$action = "list";
		break;

	default:
		break;
}

// action post processing
switch ($action) {

	case "add":
	case "edit":
		// create the country dropdown
		$variables['countries'] = array();
		$result = dbquery("SELECT UPPER(locales_key) AS locales_key, locales_value FROM ".$db_prefix."locales WHERE locales_name = 'countrycode' AND locales_code = '".$settings['locale_code']."' ORDER BY locales_value");
		while ($data = dbarray($result)) {
			$variables['countries'][] = $data;
		}
		break;

	case "print":
		// get the info of the car selected
		$variables['car'] = dbarray(dbquery("SELECT * FROM ".$db_prefix."mileage_car WHERE car_id = '".$car_id."'"));
		break;

	case "list":
		// get the info of the car selected
		$variables['car'] = dbarray(dbquery("SELECT * FROM ".$db_prefix."mileage_car WHERE car_id = '".$car_id."'"));
		if (is_array($variables['car'])) {
			// get the travel registered for this car (add one for the delivery address)
			$variables['rows'] = dbfunction("COUNT(*)", "mileage_travel", "travel_car_id = '".$car_id."'") + 1;
			$rowcount = $variables['rows'] - $rowstart - 1;
			$variables['travel'] = array();
			$result = dbquery("SELECT t.*, a.* FROM ".$db_prefix."mileage_travel t LEFT JOIN ".$db_prefix."mileage_address a ON a.adr_id = t.travel_to  WHERE travel_car_id = '".$car_id."' ORDER BY travel_date DESC LIMIT ".$rowstart.", ".$settings['numofthreads']);
			$rows = dbrows($result);
			if ($rows) {
				while ($data = dbarray($result)) {
					// do we have an address?
					if (is_null($data['adr_id'])) {
						// No, it's private
						$data['adr_type'] = "P";
						$data['adr_description'] = "* ".$locale['eA_727']." *";
					}
					switch($data['adr_type']) {
						case "B":
							$data['adr_type_desc'] = $locale['eA_726'];
							break;
						case "P":
							$data['adr_type_desc'] = $locale['eA_727'];
							break;
					}
					// get the mileage unit
					switch ($variables['car']['car_mileage_unit']) {
						case "K":
							$data['mileage_unit'] = $locale['eA_665'];
							break;
						case "M":
							$data['mileage_unit'] = $locale['eA_666'];
							break;
					}
					switch ($data['travel_type']) {
						case "B":
							$data['p_total'] = 0;
							$data['b_total'] = $data['travel_mileage'];
							if ($data['travel_detour_type'] == "P") {
								$data['p_total'] = $data['travel_detour'];
								$data['b_total'] -= $data['p_total'];
							}
							break;
						case "P":
							$data['p_total'] = $data['travel_mileage'];
							$data['b_total'] = 0;
							if ($data['travel_detour_type'] == "B") {
								$data['b_total'] = $data['travel_detour'];
								$data['p_total'] -= $data['b_total'];
							}
							break;
						default:
							$data['p_total'] = "?";
							$data['b_total'] = "?";
					}
					$data['total'] = $data['b_total'] + $data['p_total'];
					$data['row'] = $rowcount--;
					$variables['travel'][] = $data;
				}
			}
			// if at the last page, add the start to the travel list
			if ($rowcount == 0) {
				$data = dbarray(dbquery("SELECT * FROM ".$db_prefix."mileage_address WHERE adr_id = '".$variables['car']['car_start_from']."'"));
				switch($data['adr_type']) {
					case "B":
						$data['adr_type_desc'] = $locale['eA_726'];
						break;
					case "P":
						$data['adr_type_desc'] = $locale['eA_727'];
						break;
				}
				// get the mileage unit
				switch ($variables['car']['car_mileage_unit']) {
					case "K":
						$data['mileage_unit'] = $locale['eA_665'];
						break;
					case "M":
						$data['mileage_unit'] = $locale['eA_666'];
						break;
				}
				$data['travel_id'] = "";
				$data['travel_date'] = $variables['car']['car_start_date'];
				$data['total'] = $variables['car']['car_mileage'];
				$data['p_total'] = 0;
				$data['b_total'] = 0; //$variables['car']['car_mileage'];
				$variables['travel'][] = $data;
				// start mileage on this page
				$mileage = 0;
			} else {
				// calculate the start mileage on this page
				$mileage = dbfunction("SUM(travel_mileage)", "mileage_travel", "travel_car_id = '".$car_id."' AND travel_date < ".$variables['travel'][count($variables['travel'])-1]['travel_date']);
				$mileage += $variables['car']['car_mileage'];
			}
			// calculate the car mileage at the start of this page, using the mileage of each trip
			foreach($variables['travel'] as $trip) {
				$mileage += $trip['total'];
			}
			// now update the mileage of each row
			foreach($variables['travel'] as $key => $trip) {
				$variables['travel'][$key]['total'] = $mileage;
				$mileage = $mileage - $trip['p_total'] - $trip['b_total'];
			}
		} else {
			// car selected not found, return to the selection list
			$action = "";
		}
		break;

	default:
		// load the defined cars list
		$variables['cars'] = array();
		if ($variables['is_admin']) {
			$result = dbquery("SELECT * FROM ".$db_prefix."mileage_car ORDER BY car_description, car_registration LIMIT ".$rowstart.", ".$settings['numofthreads']);
			while ($data = dbarray($result)) {
				$data['car_drivers'] = array();
				$result2 = dbquery("SELECT d.driver_user_id, u.user_name, u.user_fullname FROM ".$db_prefix."mileage_drivers d, ".$db_prefix."users u WHERE d.driver_car_id = '".$data['car_id']."' AND d.driver_user_id = u.user_id");
				while ($data2 = dbarray($result2)) {
					$data['drivers'][] = $data2;
				}
				$variables['cars'][] = $data;
			}
		} else {
			$result = dbquery("SELECT c.* FROM ".$db_prefix."mileage_car c, ".$db_prefix."mileage_drivers d WHERE car_id = driver_car_id AND driver_user_id = '".$userdata['user_id']."' ORDER BY car_description, car_registration LIMIT ".$rowstart.", ".$settings['numofthreads']);
			while ($data = dbarray($result)) {
				$data['car_drivers'] = array();
				$result2 = dbquery("SELECT d.driver_user_id, u.user_name, u.user_fullname FROM ".$db_prefix."mileage_drivers d, ".$db_prefix."users u WHERE d.driver_user_id = u.user_id AND d.driver_car_id = '".$data['car_id']."' AND d.driver_user_id = '".$userdata['user_id']."'");
				while ($data2 = dbarray($result2)) {
					$data['drivers'][] = $data2;
				}
				$variables['cars'][] = $data;
			}
		}
		$variables['rows'] = count($variables['cars']);
		break;
}

// store the variables we need in the panels
$variables['action'] = $action;
$variables['rowstart'] = $rowstart;
$variables['car_id'] = $car_id;
$variables['travel_id'] = $travel_id;

// display a status panel first if need be
if (isset($variables['message'])) {
	// define the message panel variables
	$variables['bold'] = true;
	$template_panels[] = array('type' => 'body', 'name' => 'modules.mileage.status', 'template' => '_message_table_panel.tpl');
	$template_variables['modules.mileage.status'] = $variables;
}

// define the mileage body panel
$template_panels[] = array('type' => 'body', 'name' => 'modules.mileage.mileage', 'template' => 'modules.mileage.mileage.tpl', 'locale' => "modules.mileage");
$template_variables['modules.mileage.mileage'] = $variables;

// Call the theme code to generate the output for this webpage
require_once PATH_THEME."/theme.php";
?>
