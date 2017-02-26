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

// load the locale for this module
locale_load("modules.mileage");

// temp storage for template variables
$variables = array();

// check for the proper admin access rights
if (!checkrights("eA") || !defined("iAUTH") || $aid != iAUTH) fallback(BASEDIR."index.php");

// make sure the parameter is valid
if (isset($car_id) && !isNum($car_id)) fallback(FUSION_SELF.$aidlink);
if (!isset($car_id)) $car_id = 0;
if (!isset($driver_id)) $driver_id = 0;
if (!isset($action)) $action = "";
if (!isset($task)) $task = "";
if (!isset($rowstart)) $rowstart = 0;

// action preprocessing
switch ($action) {

	case "add":
	case "edit":
		if (isset($_POST['save'])) {
			// get and sanitize the variables
			$variables['car_id'] = 0;
			$variables['car_registration'] = stripinput($_POST['car_registration']);
			$variables['car_description'] = stripinput($_POST['car_description']);
			$variables['car_start_from'] = isNum($_POST['car_start_from']) ? $_POST['car_start_from'] : 0;
			$variables['car_mileage'] = isNum($_POST['car_mileage']) ? $_POST['car_mileage'] : 0;
			$variables['car_mileage_unit'] = stripinput($_POST['car_mileage_unit']);
			$variables['car_report_type'] = isNum($_POST['car_report_type']) ? $_POST['car_report_type'] : 0;
			// delivery date components
			$variables['start_Month'] = isNum($_POST['start_Month']) ? $_POST['start_Month'] : 0;
			$variables['start_Day'] = isNum($_POST['start_Day']) ? $_POST['start_Day'] : 0;
			$variables['start_Year'] = isNum($_POST['start_Year']) ? $_POST['start_Year'] : 0;
			$variables['car_start_date'] = mktime(0, 0, 0, $variables['start_Month'], $variables['start_Day'], $variables['start_Year']);
			// deal with invalid start date
			if ($variables['car_start_date'] == -1) $variables['car_start_date'] = 0;
			$variables['end_Month'] = (isset($_POST['end_Month']) && isNum($_POST['end_Month'])) ? $_POST['end_Month'] : 0;
			$variables['end_Day'] = (isset($_POST['end_Day']) && isNum($_POST['end_Day'])) ? $_POST['end_Day'] : 0;
			$variables['end_Year'] = (isset($_POST['end_Year']) && isNum($_POST['end_Year'])) ? $_POST['end_Year'] : 0;
			$variables['car_end_date'] = mktime(0, 0, 0, $variables['end_Month'], $variables['end_Day'], $variables['end_Year']);
			// deal with invalid end date
				if ($variables['car_end_date'] == -1) $variables['car_end_date'] = 0;
			// new address information
			$variables['new_ident'] = stripinput($_POST['new_ident']);
			$variables['new_address'] = stripinput($_POST['new_address']);
			$variables['new_postcode'] = stripinput($_POST['new_postcode']);
			$variables['new_city'] = stripinput($_POST['new_city']);
			$variables['new_country'] = stripinput($_POST['new_country']);
			// fuel info
			$variables['car_fuel'] = (is_numeric($_POST['car_fuel']) && $_POST['car_fuel'] > 0) ? $_POST['car_fuel'] : 0;
			$variables['car_fuel_type'] = stripinput($_POST['car_fuel_type']);
			// validate the input
			if (empty($variables['car_registration'])) {
				// required field
				$variables['message'] = $locale['eA_900'];
			} elseif (empty($variables['car_description'])) {
				// required field
				$variables['message'] = $locale['eA_901'];
			} elseif ($variables['car_start_from'] == 0 && (empty($variables['new_ident']) || empty($variables['new_address']) || empty($variables['new_city']))) {
				// need or existing address, or a new address (at least ident, address, city and coutry!)
				$variables['message'] = $locale['eA_906'];
			} elseif ($variables['car_start_date'] == 0) {
				// invalid date (should not be possible due to dropdown selection)
				$variables['message'] = $locale['eA_912'];
			} elseif ($variables['car_fuel'] == 0) {
				// initial fuel amount is required
				$variables['message'] = $locale['eA_921'];
			} else {
				// if we have a new address, add it first (if needed), and get the adr_id
				if (!empty($variables['new_ident'])) {
					$result = dbquery("SELECT adr_id FROM ".$db_prefix."mileage_address WHERE adr_description = '".mysqli_real_escape_string($_db_link, $variables['new_ident'])."'");
					if (dbrows($result)) {
						// existing address identification. Update the address
						$data = dbarray($result);
						$variables['car_start_from'] = $data['adr_id'];
						$result = dbquery("UPDATE ".$db_prefix."mileage_address SET adr_address = '".mysqli_real_escape_string($_db_link, $variables['new_address'])."', adr_postcode = '".mysqli_real_escape_string($_db_link, $variables['new_postcode'])."', adr_city = '".mysqli_real_escape_string($_db_link, $variables['new_city'])."', adr_country = '".$variables['new_country']."' WHERE adr_id = '".$data['adr_id']."'");
					} else {
						// new address, add it
						$result = dbquery("INSERT INTO ".$db_prefix."mileage_address (adr_description, adr_address, adr_postcode, adr_city, adr_country) VALUES('".mysqli_real_escape_string($_db_link, $variables['new_ident'])."', '".mysqli_real_escape_string($_db_link, $variables['new_address'])."', '".mysqli_real_escape_string($_db_link, $variables['new_postcode'], $_db_link)."', '".mysqli_real_escape_string($_db_link, $variables['new_city'])."', '".$variables['new_country']."')");
						$variables['car_start_from'] = mysqli_insert_id($_db_link);
					}
				}
				if ($action == "add") {
					// add the new car
					$result = dbquery("INSERT INTO ".$db_prefix."mileage_car (car_registration, car_description, car_start_from, car_start_date, car_mileage, car_mileage_unit, car_report_type, car_fuel, car_fuel_type) VALUES ('".$variables['car_registration']."', '".$variables['car_description']."', '".$variables['car_start_from']."', '".$variables['car_start_date']."',  '".$variables['car_mileage']."', '".$variables['car_mileage_unit']."', '".$variables['car_report_type']."', '".$variables['car_fuel']."', '".$variables['car_fuel_type']."')");
					// we need the key to insert the fuel record
					$car_id = mysqli_insert_id($_db_link);
					// return to the main panel with a success message
					$variables['message'] = $locale['eA_902'];
				} elseif ($action == "edit") {
					// update the car info
					$result = dbquery("UPDATE ".$db_prefix."mileage_car SET car_registration = '".mysqli_real_escape_string$_db_link, ($variables['car_registration'])."', car_description ='".mysqli_real_escape_string($_db_link, $variables['car_description'])."', car_start_date = '".$variables['car_start_date']."', car_end_date = '".$variables['car_end_date']."', car_mileage = '".$variables['car_mileage']."', car_mileage_unit = '".$variables['car_mileage_unit']."', car_report_type = '".$variables['car_report_type']."', car_fuel = '".$variables['car_fuel']."', car_fuel_type = '".$variables['car_fuel_type']."' WHERE car_id = '".$car_id."'");
					// return to the main panel with a success message
					$variables['message'] = $locale['eA_903'];
				}
				$action = "";
			}
		} else {
			// initialise the address variables
			$variables['new_ident'] = "";
			$variables['new_address'] = "";
			$variables['new_postcode'] = "";
			$variables['new_city'] = "";
			$variables['new_country'] = strtoupper($settings['country']);
			if ($action == "add") {
				// it's an add, give the other form fields default values
				$variables['car_id'] = 0;
				$variables['car_registration'] = "";
				$variables['car_start_from'] = 0;
				$variables['car_start_date'] = time();
				$variables['car_end_date'] = 0;
				$variables['car_description'] = "";
				$variables['car_mileage'] = 0;
				$variables['car_mileage_unit'] = "";
				$variables['car_report_type'] = 0;
				$variables['car_fuel'] = 0;
				$variables['car_fuel_type'] = "L";
			} else {
				// get the car record and populate the form fields
				$result = dbquery("SELECT * FROM ".$db_prefix."mileage_car WHERE car_id = '".$car_id."'");
				if ($data = dbarray($result)) {
					$variables['car_id'] = $data['car_id'];
					$variables['car_registration'] = $data['car_registration'];
					$variables['car_description'] = $data['car_description'];
					$variables['car_start_from'] = $data['car_start_from'];
					$variables['car_start_date'] = $data['car_start_date'];
					$variables['car_end_date'] = $data['car_end_date'];
					$variables['car_mileage'] = $data['car_mileage'];
					$variables['car_mileage_unit'] = $data['car_mileage_unit'];
					$variables['car_report_type'] = $data['car_report_type'];
					$variables['car_fuel'] = $data['car_fuel'];
					$variables['car_fuel_type'] = $data['car_fuel_type'];
				} else {
					// not found?
					$variables['message'] = $locale['eA_904'];
					$action = "";
				}
			}
		}
		if ($action == "add") {
			$variables['formaction'] = FUSION_SELF.$aidlink."&amp;action=".$action;
		} elseif ($action == "edit") {
			$variables['formaction'] = FUSION_SELF.$aidlink."&amp;action=edit&amp;car_id=".$variables['car_id'];
		}
		break;

	case "delete":
		$result = dbquery("DELETE FROM ".$db_prefix."mileage_travel WHERE travel_car_id = '".$car_id."'");
		$result = dbquery("DELETE FROM ".$db_prefix."mileage_car WHERE car_id = '".$car_id."'");
		// reset the action switch to return to the default action
		$action = "";
		break;

	case "drivers":
		if (isset($_POST['save'])) {
			$variables['driver_user_id'] = isNum($_POST['driver_user_id']) ? $_POST['driver_user_id'] : 0;
			// delivery date components
			$variables['start_Month'] = isNum($_POST['start_Month']) ? $_POST['start_Month'] : 0;
			$variables['start_Day'] = isNum($_POST['start_Day']) ? $_POST['start_Day'] : 0;
			$variables['start_Year'] = isNum($_POST['start_Year']) ? $_POST['start_Year'] : 0;
			$variables['driver_start_date'] = mktime(0, 0, 0, $variables['start_Month'], $variables['start_Day'], $variables['start_Year']);
			// deal with invalid start date
			if ($variables['driver_start_date'] == -1) $variables['driver_start_date'] = 0;
			$variables['end_Month'] = (isset($_POST['end_Month']) && isNum($_POST['end_Month'])) ? $_POST['end_Month'] : 0;
			$variables['end_Day'] = (isset($_POST['end_Day']) && isNum($_POST['end_Day'])) ? $_POST['end_Day'] : 0;
			$variables['end_Year'] = (isset($_POST['end_Year']) && isNum($_POST['end_Year'])) ? $_POST['end_Year'] : 0;
			$variables['driver_end_date'] = mktime(0, 0, 0, $variables['end_Month'], $variables['end_Day'], $variables['end_Year']);
			// deal with invalid end date
			if ($variables['driver_end_date'] == -1) $variables['driver_end_date'] = 0;
			$variables['driver_mileage_unit'] = stripinput($_POST['driver_mileage_unit']);
			$variables['driver_ssn'] = stripinput($_POST['driver_ssn']);
			// validation
			// save the input
			if ($task == "edit") {
				$result = dbquery("UPDATE ".$db_prefix."mileage_drivers SET driver_start_date = '".$variables['driver_start_date']."', driver_end_date = '".$variables['driver_end_date']."', driver_mileage_unit = '".$variables['driver_mileage_unit']."', driver_ssn = '".$variables['driver_ssn']."' WHERE driver_car_id = '".$car_id."' AND driver_user_id = '".$variables['driver_user_id']."'");
			} else {
				$result = dbquery("INSERT INTO ".$db_prefix."mileage_drivers (driver_car_id, driver_user_id, driver_start_date, driver_end_date, driver_mileage_unit, driver_ssn) VALUES ('".$car_id."', '".$variables['driver_user_id']."', '".$variables['driver_start_date']."', '".$variables['driver_end_date']."', '".$variables['driver_mileage_unit']."', '".$variables['driver_ssn']."')");
			}
			$driver_id = 0;
			$task = "";
		}
		if ($task == "edit") {
			$result = dbquery("SELECT * FROM ".$db_prefix."mileage_drivers WHERE driver_car_id = ".$car_id." AND driver_user_id = '".$driver_id."'");
			if ($data = dbarray($result)) {
				$variables['driver_car_id'] = $data['driver_car_id'];
				$variables['driver_user_id'] = $data['driver_user_id'];
				$variables['driver_start_date'] = $data['driver_start_date'];
				$variables['driver_end_date'] = $data['driver_end_date'];
				$variables['driver_mileage_unit'] = $data['driver_mileage_unit'];
				$variables['driver_ssn'] = $data['driver_ssn'];
			} else {
				$action = "drivers";
			}
		} elseif ($task == "delete") {
			if ($car_id && $driver_id) {
				$result = dbquery("DELETE FROM ".$db_prefix."mileage_travel WHERE travel_car_id = ".$car_id." AND travel_driver_id = '".$driver_id."'");
				$result = dbquery("DELETE FROM ".$db_prefix."mileage_drivers WHERE driver_car_id = ".$car_id." AND driver_user_id = '".$driver_id."'");
				$driver_id = 0;
				$task = "";
			}
		}
		if ($task == "") {
			$variables['driver_car_id'] = $car_id;
			$variables['driver_user_id'] = 0;
			$variables['driver_start_date'] = time();
			$variables['driver_end_date'] = 0;
			$variables['driver_mileage_unit'] = "K";
		}
		$variables['formaction'] = FUSION_SELF.$aidlink."&amp;action=drivers&amp;car_id=".$car_id."&amp;task=".$task;
		break;

	default:
		break;
}

// action postprocessing
switch ($action) {

	case "add":
	case "edit":
		$variables['address'] = array();
		$result = dbquery("SELECT * FROM ".$db_prefix."mileage_address ORDER BY adr_description");
		while ($data = dbarray($result)) {
			switch($data['adr_type']) {
				case "B":
					$data['adr_type_desc'] = $locale['eA_726'];
					break;
				case "P":
					$data['adr_type_desc'] = $locale['eA_727'];
					break;
			}
			$variables['address'][] = $data;
		}
		// create the country dropdown
		$variables['countries'] = array();
		$result = dbquery("SELECT UPPER(locales_key) AS locales_key, locales_value FROM ".$db_prefix."locales WHERE locales_name = 'countrycode' AND locales_code = '".$settings['locale_code']."' ORDER BY locales_value");
		while ($data = dbarray($result)) {
			$variables['countries'][] = $data;
		}
		break;

	case "drivers":
		// get the info of the car selected
		$variables['car'] = dbarray(dbquery("SELECT * FROM ".$db_prefix."mileage_car WHERE car_id = '".$car_id."'"));
		if ($task == "edit" || $task == "") {
			$variables['users'] = array();
			if (empty($driver_id)) {
				$result = dbquery("SELECT user_id, user_name, user_fullname FROM ".$db_prefix."users WHERE user_id NOT IN (SELECT driver_user_id FROM ".$db_prefix."mileage_drivers WHERE driver_car_id = '7') ORDER BY user_name");
			} else {
				$result = dbquery("SELECT u.user_name, u.user_fullname FROM ".$db_prefix."users u WHERE u.user_id = '".$driver_id."'");
			}
			while ($data = dbarray($result)) {
				$variables['users'][] = $data;
			}
		}
		if ($task == "") {
			// get the drivers registered for this car
			$variables['drivers'] = array();
			$result = dbquery("SELECT d.*, u.user_name, u.user_fullname FROM ".$db_prefix."mileage_drivers d, ".$db_prefix."users u WHERE d.driver_user_id = u.user_id AND d.driver_car_id = '".$car_id."'");
			while ($data = dbarray($result)) {
				$variables['drivers'][] = $data;
			}
		}
		break;

	default:
		// load the defined cars list
		$variables['rows'] = dbfunction("COUNT(*)", "mileage_car" );
		$variables['cars'] = array();
		$result = dbquery("SELECT * FROM ".$db_prefix."mileage_car ORDER BY car_end_date, car_description, car_registration LIMIT ".$rowstart.", ".$settings['numofthreads']);
		while ($data = dbarray($result)) {
			$variables['cars'][] = $data;
		}
}

// store the variables we need in the panels
$variables['action'] = $action;
$variables['task'] = $task;
$variables['rowstart'] = $rowstart;
$variables['car_id'] = $car_id;

// display a status panel first if need be
if (isset($variables['message'])) {
	// define the message panel variables
	$variables['bold'] = true;
	$template_panels[] = array('type' => 'body', 'name' => 'modules.mileage.status', 'title' => $locale['eA_600'], 'template' => '_message_table_panel.tpl');
	$template_variables['modules.mileage.status'] = $variables;
}

// define the admin body panel
$template_panels[] = array('type' => 'body', 'name' => 'modules.mileage.admin', 'template' => 'modules.mileage.admin.tpl', 'locale' => "modules.mileage");
$template_variables['modules.mileage.admin'] = $variables;

// Call the theme code to generate the output for this webpage
require_once PATH_THEME."/theme.php";
?>
