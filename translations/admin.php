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
| $Id:: admin.php 2043 2008-11-16 14:25:18Z WanWizard                 $|
+----------------------------------------------------------------------+
| Last modified by $Author:: WanWizard                                $|
| Revision number $Rev:: 2043                                         $|
+---------------------------------------------------------------------*/
require_once dirname(__FILE__)."/../../includes/core_functions.php";
require_once PATH_ROOT."/includes/theme_functions.php";

// check for the proper admin access rights
if (!checkrights("wT") || !defined("iAUTH") || $aid != iAUTH) fallback(BASEDIR."index.php");

// temp storage for template variables
$variables = array();

// load the locale for this module
locale_load("modules.translations");

// make sure step has a value
if (!isset($step)) $step = "overview";

// search and replace array's
$keysearch = array("$", '"', '\'', chr(10), chr(13));
$keyreplace = array("\\$", '\\"', '\\\'', "\\n", "\\r");
$search = array("$", '"', chr(10), chr(13));
$replace = array("\\$", '\\"', "\\n", "\\r");

// save requested
if (isset($_POST['add_edit']) && isset($_POST['locale_id']) && isNum($_POST['locale_id'])) {
	// retrieve and sanitize the posted data
	$locale_id = $_POST['locale_id'];
	$locale_code = stripinput($_POST['locale_code']);
	$locale_name = stripinput($_POST['locale_name']);
	$old_locale_code = stripinput($_POST['old_locale_name']);
	$locale_locale = stripinput($_POST['locale_locale']);
	$locale_countries = stripinput($_POST['locale_countries']);
	$locale_charset = stripinput($_POST['locale_charset']);
	$locale_direction = stripinput($_POST['locale_direction']);
	if ($locale_direction != "LTR" && $locale_direction != "RTL") $locale_direction = "LTR";
	$translators = $_POST['translators'];
	// validate the data
	$message = "";
	if (empty($locale_code)) {
		// code is a required field
		$message .= sprintf($locale['902'], $locale['420']);
	}
	if (empty($locale_name)) {
		// name is a required field
		$message .= sprintf($locale['902'], $locale['421']);
	}
	if (empty($locale_locale)) {
		// locale is a required field
		$message .= sprintf($locale['902'], $locale['423']);
	}
	if (empty($locale_charset)) {
		// charset is a required field
		$message .= sprintf($locale['902'], $locale['425']);
	}
	$result = dbquery("SELECT * FROM ".$db_prefix."locale WHERE locale_code = '$locale_code' AND locale_id != '$locale_id'");
	if (dbrows($result)) {
		// duplicate code entered
		$message .= sprintf($locale['904'], $locale['420']);
	}
	$result = dbquery("SELECT * FROM ".$db_prefix."locale WHERE locale_name = '$locale_name' AND locale_id != '$locale_id'");
	if (dbrows($result)) {
		// duplicate code entered
		$message .= sprintf($locale['904'], $locale['421']);
	}
	if (!empty($message)) {
		// if error(s) were detected, load the posted info in the template variables
		$variables['locale_id'] = $locale_id;
		$variables['locale_code'] = $locale_code;
		$variables['locale_name'] = $locale_name;
		$variables['locale_locale'] = str_replace(" ", "", $locale_locale);
		$variables['locale_countries'] = str_replace(" ", "", $locale_countries);
		$variables['locale_charset'] = $locale_charset;
		$variables['locale_direction'] = $locale_direction;
	} else {
		// no errors, prepare the info for saving
		$locale_locale = str_replace(" ", "", $locale_locale);
		$translators = explode(".", $translators);
		// save the posted info
		if ($step == "add") {
			// insert the new locale
			$result = dbquery("INSERT INTO ".$db_prefix."locale (locale_code, locale_name, locale_locale, locale_countries, locale_charset, locale_direction, locale_active) VALUES ('$locale_code', '$locale_name', '$locale_locale', '$locale_countries', '$locale_charset', '$locale_direction', 0)");
		}
		if ($step == "edit") {
			// update the locale
			$result = dbquery("UPDATE ".$db_prefix."locale SET locale_code = '$locale_code', locale_name = '$locale_name', locale_locale = '$locale_locale', locale_countries = '$locale_countries', locale_charset = '$locale_charset', locale_direction = '$locale_direction' WHERE locale_id = '$locale_id'");

		}
		// update the translator information
		$result = dbquery("DELETE FROM ".$db_prefix."translators WHERE translate_locale_code = '$locale_code'");
		foreach($translators as $translator) {
			$result = dbquery("INSERT INTO ".$db_prefix."translators (translate_translator, translate_locale_code) VALUES ('$translator', '$locale_code')");
		}
		
		// report the save succesfully, and go back to the overview table
		$message = $locale['903'];
		$step = "overview";
	}
}

// activate a locale
if ($step == "activate") {
	$result = dbquery("UPDATE ".$db_prefix."locale SET locale_active = '1' WHERE locale_id = '$locale_id'");	
	$message = $locale['906'];
}

// deactivate a locale
if ($step == "deactivate") {
	// check if there is more then 1 locale active
	$can_deactivate = dbcount("(*)", "locale", "locale_active = '1'") - 1;
	if ($can_deactivate) {
		$result = dbquery("UPDATE ".$db_prefix."locale SET locale_active = '0' WHERE locale_id = '$locale_id'");
		// get the locale code for this ID, if it's used, reset them to 'en' (the CMS default)	
		$result = dbquery("SELECT * FROM ".$db_prefix."locale WHERE locale_id = '$locale_id'");
		if (dbrows($result)) {
			$data = dbarray($result);
			// update the site default locale
			$result = dbquery("UPDATE ".$db_prefix."configuration SET cfg_value = 'en' WHERE cfg_name = 'locale' AND cfg_value = '".$data['locale_code']."'");
			// update the members default locale
			$result = dbquery("UPDATE ".$db_prefix."users SET user_locale = 'en' WHERE user_locale = '".$data['locale_code']."'");
		}
		$message = $locale['907'];
	} else {
		$message = $locale['905'];
	}
}

if ($step == "generate") {
	$message = "";
	// check which locale we want export
	$result = dbquery("SELECT * FROM ".$db_prefix."locale WHERE locale_id = '$locale_id'");
	if (dbrows($result)) {
		$__db_log = $_db_log;
		$_db_log = false;
		$data = dbarray($result);
		// open the language pack template file, and the the language pack toolbox file
		if ($thandle = @fopen("langpack.template", 'r')) {
			if ($handle = @fopen(PATH_ADMIN."tools/language_pack_".$data['locale_name'].".php", 'w')) {
				// loop through the lines of the template, and write them to the language pack file
				while (!feof($thandle)) {
					$line = fgets($thandle, 4096);
					// get out of the loop if an error occurred
					if (!$line) break;
					// process the line read from the template
					switch ($line) {
						case "### CREDITS ###\n":
							// get the translator information for each of the locale found
							$translators = "";
							$result2 = dbquery("SELECT t.*, u.user_id, u.user_name FROM ".$db_prefix."translators t, ".$db_prefix."users u WHERE t.translate_locale_code = '".$data['locale_code']."' AND t.translate_translator = u.user_id ORDER BY u.user_name");
							while ($data2 = dbarray($result2)) {
								$translators .= $data2['user_name'].",";
							}
							if ($translators != "") {
								$translators = substr(str_pad(substr($translators,0,-1),68), 0, 68);
								fwrite($handle, "| The ExiteCMS team thanks the following person(s):                    |\n");
								fwrite($handle, "|                                                                      |\n");
								fwrite($handle, "| ".$translators." |\n");
								fwrite($handle, "|                                                                      |\n");
								fwrite($handle, "| for their efforts in making this translation file.                   |\n");
								fwrite($handle, "| They can be contacted on http://www.exitecms.org                     |\n");
								fwrite($handle, "+----------------------------------------------------------------------+\n");
							}
							break;
						case "### DEFINES ###\n":
							fwrite($handle, "if (!defined('LP_LOCALE')) define('LP_LOCALE', \"".$data['locale_code']."\");\n");
							fwrite($handle, "if (!defined('LP_LANGUAGE')) define('LP_LANGUAGE', \"".$data['locale_name']."\");\n");
							fwrite($handle, "if (!defined('LP_LOCALES')) define('LP_LOCALES', \"".$data['locale_locale']."\");\n");
							fwrite($handle, "if (!defined('LP_CHARSET')) define('LP_CHARSET', \"".$data['locale_charset']."\");\n");
							fwrite($handle, "if (!defined('LP_DIRECTION')) define('LP_DIRECTION', \"".$data['locale_direction']."\");\n");
							fwrite($handle, "if (!defined('LP_COUNTRIES')) define('LP_COUNTRIES', \"".$data['locale_countries']."\");\n");
							fwrite($handle, "if (!defined('LP_VERSION')) define('LP_VERSION', \"".$settings['version']."\");\n");
							fwrite($handle, "if (!defined('LP_DATE')) define('LP_DATE', \"".time()."\");\n");
							fwrite($handle, "$"."lp_date = LP_DATE;\n");
							break;
						case "### LOCALESTRINGS ###\n":
							// get all locale_names 
							$result = dbquery("SELECT DISTINCT locales_name FROM ".$db_prefix."locales WHERE locales_code = 'en'");
							while ($names = dbarray($result)) {
								// filter on the locales_names that are part of the ExiteCMS core code
								if (strpos($names['locales_name'], ".") !== false) {
									// skip all but admin.*, forum.*, main.* tables
									if (!in_array(substr($names['locales_name'],0,strpos($names['locales_name'], ".")+1), array("admin.", "main.", "forum."))) {
										continue;
									}
								}
								// get the locale records for the website default language and this locale_name
								$result2 = dbquery("SELECT * FROM ".$db_prefix."locales WHERE locales_code = 'en' AND locales_name = '".$names['locales_name']."' ORDER BY locales_key");
								if (dbrows($result2)) {
									fwrite($handle, "\n\t\t\$localestrings = array();\n");
									while ($localerec = dbarray($result2)) {
										$localerec['locales_key'] = str_replace($keysearch, $keyreplace, $localerec['locales_key']);
										// check if a translated string exists.
										$result3 = dbquery("SELECT * FROM ".$db_prefix."locales WHERE locales_code = '".$data['locale_code']."' AND locales_name = '".$names['locales_name']."' AND locales_key = '".$localerec['locales_key']."'");
										if (dbrows($result3)) {
											// use it instead of the english one
											$localerec = dbarray($result3);
											$localerec['locales_key'] = str_replace($keysearch, $keyreplace, $localerec['locales_key']);
										}
										// check if we're dealing with an array
										if (substr($localerec['locales_value'],0,8) == "#ARRAY#\n") {
											// generate the array definition
											fwrite($handle, "\t\t\$localestrings['".$localerec['locales_key']."'] = array();\n");
											// extract the array
											$localerec['locales_value'] = unserialize(substr($localerec['locales_value'],8));
											// loop through the elements
											foreach($localerec['locales_value'] as $key => $value) {
												$key = str_replace($keysearch, $keyreplace, $key);
												if (is_array($value)) {
													// multi-dimensional array
													fwrite($handle, "\t\t\$localestrings['".$localerec['locales_key']."']['$key'] = array();\n");
													foreach($value as $key2 => $value2) {
														$key2 = str_replace($keysearch, $keyreplace, $key2);
														$value2 = str_replace($search, $replace, $value2);
														fwrite($handle, "\t\t\$localestrings['".$localerec['locales_key']."']['$key']['$key2'] = \"".$value2."\"".";\n");
													}
												} else {
													// single-dimensional array
													$value = str_replace($search, $replace, $value);
													fwrite($handle, "\t\t\$localestrings['".$localerec['locales_key']."']['$key'] = \"".$value."\"".";\n");
												}
											}
										} else {
											$localerec['locales_value'] = str_replace($search, $replace, $localerec['locales_value']);
											fwrite($handle, "\t\t\$localestrings['".$localerec['locales_key']."'] = \"".$localerec['locales_value']."\"".";\n");
										}
									}
									fwrite($handle, "\t\tload_localestrings(\$localestrings, LP_LOCALE, \"".$names['locales_name']."\", \$step);\n");
								}
							}
							break;
						default:
							// code line. Write it to the language pack file
						fwrite($handle, $line);
					}
				}
				fclose($thandle);
				fclose($handle);
				// make sure the setup and global cache files are up to date as well. They are required for the setup 
				locale_load("main.setup", $data['locale_code']);
				locale_load("main.global", $data['locale_code']);
			} else {
				$message .= sprintf($locale['916'], PATH_ADMIN."tools/language_pack_".$data['locale_name'].".php");
			}
			if (empty($message)) $message = sprintf($locale['917'],$data['locale_name']);
		} else {
			$message .= $locale['915'];
		}
	}
	$_db_log = $__db_log;
}

// delete a locale
if ($step == "delete") {
	// check which locale we want to delete
	$result = dbquery("SELECT * FROM ".$db_prefix."locale WHERE locale_id = '$locale_id'");
	if (dbrows($result)) {
		$data = dbarray($result);
		// check if we're not deleting the CMS default language
		if ($data['locale_code'] == $settings['default_locale']) {
			$message = sprintf($locale['910'], $data['locale_name']);
		} else {
			// delete translations from the locales table
			$result = dbquery("DELETE FROM ".$db_prefix."locales WHERE locales_code = '".$data['locale_code']."'");
			// delete the translator records for this locale
			$result = dbquery("DELETE FROM ".$db_prefix."translators WHERE translate_locale_code = '".$data['locale_code']."'");
			// delete the locale record itself
			$result = dbquery("DELETE FROM ".$db_prefix."locale WHERE locale_code = '".$data['locale_code']."'");
			// update the site default locale
			$result = dbquery("UPDATE ".$db_prefix."configuration SET cfg_value = 'en' WHERE cfg_name = 'locale' AND cfg_value = '".$data['locale_code']."'");
			// update the members default locale
			$result = dbquery("UPDATE ".$db_prefix."users SET user_locale = 'en' WHERE user_locale = '".$data['locale_code']."'");
			// report the save succesfully, and go back to the overview table
			$message = sprintf($locale['911'],$data['locale_name']);
			$step = "overview";
		}
	}
}

// add a new locale: initialise the variables
if ($step == "add" && !isset($message)) {
	$variables['locale_id'] = 0;
	$variables['locale_code'] = "";
	$variables['locale_name'] = "";
	$variables['locale_locale'] = "";
	$variables['locale_countries'] = "";
	$variables['locale_charset'] = "";
	$variables['locale_direction'] = "LTR";
}

// edit a locale: retrieve the variables
if ($step == "edit" && !isset($message)) {
	if (isset($locale_id) && isNum($locale_id)) {
		$result = dbquery("SELECT * FROM ".$db_prefix."locale WHERE locale_id = '$locale_id'");
		if (dbrows($result)) {
			// if found, add the fields to the template variables
			$variables = array_merge($variables, dbarray($result));
		} else {
			// if not, display a message, and reset the step variable
			$message = $locale['901'];
			$step = "overview";
		}
	}
}

// in case of add or edit, we need a memberlist, and a list of translators
if ($step == "add" || $step == "edit") {
	// get the list of translators for this locale
	$translators = array();
	$result = dbquery("SELECT translate_translator FROM ".$db_prefix."translators WHERE translate_locale_code = '".$variables['locale_code']."'");
	while ($data = dbarray($result)) {
		$translators[] = $data['translate_translator'];
	}
	$variables['userlist1'] = array();
	$variables['userlist2'] = array();
	$result = dbquery("SELECT user_id,user_name FROM ".$db_prefix."users ORDER BY LOWER(user_name)");
	while ($data = dbarray($result)) {
		if (in_array($data['user_id'], $translators)) {
			$variables['userlist2'][] = array('id' => $data['user_id'], 'name' => $data['user_name']);
		} else {
			$variables['userlist1'][] = array('id' => $data['user_id'], 'name' => $data['user_name']);
		}
	}
}

$variables['max_records'] = dbcount("(*)", "locales", "locales_code = 'en'");

// get the list of available locales
$variables['localelist'] = array();
$result = dbquery("SELECT * FROM ".$db_prefix."locale ORDER BY locale_name");
while ($data = dbarray($result)) {
	$result2 = dbquery("SELECT MAX(locales_datestamp) as last_updated FROM ".$db_prefix."locales WHERE locales_code = '".$data['locale_code']."'");
	if (dbrows($result2)) {
		$data2 = dbarray($result2);
		$data['last_updated'] = $data2['last_updated'];
	} else {
		$data['last_updated'] = 0;
	}
	$data['translator_updated'] = dbcount("(*)", "locales", "locales_code = '".$data['locale_code']."' AND locales_translator != '0'");;
	$data['records'] = dbcount("(*)", "locales", "locales_code = '".$data['locale_code']."'");
	// get the translator information for each of the locale found
	$data['translators'] = array();
	$result2 = dbquery("SELECT t.*, u.user_id, u.user_name FROM ".$db_prefix."translators t, ".$db_prefix."users u WHERE t.translate_locale_code = '".$data['locale_code']."' AND t.translate_translator = u.user_id ORDER BY u.user_name");
	while ($data2 = dbarray($result2)) {
		$data2['updated'] = round(dbcount("(*)", "locales", "locales_code = '".$data['locale_code']."' AND locales_translator = '".$data2['user_id']."'") / $variables['max_records']);
		$data['translators'][] = $data2;
	}
	$data['can_edit'] = true;
	$data['can_delete'] = ($data['locale_code'] != $settings['default_locale']);
	$variables['localelist'][]  = $data;
}

// when only one active language is present, deactivating it is not possible
$variables['can_deactivate'] = dbcount("(*)", "locale", "locale_active = '1'") - 1;

// do we need to pass a message to the user?
if (isset($message)) $variables['message'] =$message;

// store the step variable
$variables['step'] = $step;

// define the body panel variables
$template_panels[] = array('type' => 'body', 'name' => 'translations.admin_panel', 'template' => 'modules.translations.admin_panel.tpl', 'locale' => "modules.translations");
$template_variables['translations.admin_panel'] = $variables;

// Call the theme code to generate the output for this webpage
require_once PATH_THEME."/theme.php";
?>
