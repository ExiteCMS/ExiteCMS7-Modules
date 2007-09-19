<?php
/*---------------------------------------------------+
| PLi-Fusion Content Management System               |
+----------------------------------------------------+
| Copyright 2007 WanWizard (wanwizard@gmail.com)     |
| http://www.pli-images.org/pli-fusion               |
+----------------------------------------------------+
| Some portions copyright ? 2002 - 2006 Nick Jones   |
| http://www.php-fusion.co.uk/                       |
| Released under the terms & conditions of v2 of the |
| GNU General Public License. For details refer to   |
| the included gpl.txt file or visit http://gnu.org  |
+----------------------------------------------------*/
require_once dirname(__FILE__)."/../../includes/core_functions.php";
require_once PATH_ROOT."/includes/theme_functions.php";

// check for the proper admin access rights
if (!checkrights("wD") || !defined("iAUTH") || $aid != iAUTH) fallback(BASEDIR."index.php");

// temp storage for template variables
$variables = array();

// defines
define('ITEMS_PER_PAGE', 20);

// load the locale for this module
if (file_exists(PATH_MODULES."donations/locale/".$settings['locale'].".php")) {
	$locale_file = PATH_MODULES."donations/locale/".$settings['locale'].".php";
} else {
	$locale_file = PATH_MODULES."donations/locale/English.php";
}
include $locale_file;

// define the donation types
$types = array($locale['don425'], $locale['don426'], $locale['don427']);

// check parameters and provide defaults
if (!isset($action)) $action = "add";

// delete requested
if ($action == "delete") {
	$result = dbquery("SELECT * FROM ".$db_prefix."donations WHERE donate_id = '$id'");
	if (dbrows($result) == 0) {
		$error = 7;
	} else {
		$result = dbquery("DELETE FROM ".$db_prefix."donations WHERE donate_id = '$id'");
		$error = 6;
	}
	$action = "add";
}

// initialize the error indicator
$error = 0;

// get any input values. If not present, provide a default
$donate_id = (isset($_POST['donate_id']) && isNum($_POST['donate_id'])) ? $_POST['donate_id'] : 0;
$donate_name = isset($_POST['donate_name'])? stripinput($_POST['donate_name']) : "";
$donate_amount = (isset($_POST['donate_amount']) && $_POST['donate_amount'] != "") ? ltrim($_POST['donate_amount'], '0') : "0.00";
// make sure we didn't trim of all zero's
if ($donate_amount{0} == ".") $donate_amount = "0".$donate_amount;
$donate_currency = isset($_POST['donate_currency'])? strtoupper(stripinput($_POST['donate_currency'])) : "EUR";
$donate_country = isset($_POST['donate_country'])? stripinput($_POST['donate_country']) : "NL";
$donate_comment = isset($_POST['donate_comment'])? stripinput($_POST['donate_comment']) : "";
$donate_timestamp = isset($_POST['donate_timestamp'])? $_POST['donate_timestamp'] : time();
$donate_state = (isset($_POST['donate_state']) && isNum($_POST['donate_state'])) ? $_POST['donate_state'] : 1;
$donate_type = (isset($_POST['donate_type']) && isNum($_POST['donate_type'])) ? $_POST['donate_type'] : 1;

// save requested?
if (isset($_POST['save_notify'])) {
	$old_forum_id = (isset($_POST['forum_id']) && isNum($_POST['forum_id'])) ? $_POST['forum_id'] : -1;
	$new_forum_id = (isset($_POST['new_forum_id']) && isNum($_POST['new_forum_id'])) ? $_POST['new_forum_id'] : -1;
	if ($old_forum_id != $new_forum_id && $old_forum_id >= 0 && $new_forum_id >= 0) {
		$donate_forum_add = false; $donate_forum_move = false;
		if ($new_forum_id == 0) {
			// stop notifications
			$error = 10;
		} elseif ($old_forum_id == 0) {
			// new notifications
			$donate_forum_add = true;
		} else {
			// move from forum
			 $donate_forum_move = true;
		}
		// move if we need to move something
		if ($donate_forum_move) {
			$result = dbquery("SELECT * FROM ".$db_prefix."threads WHERE forum_id = '".$old_forum_id."' AND thread_subject = '".$locale['don453']."'");
			if (dbrows($result)) {
				$data = dbarray($result);
				$result = dbquery("UPDATE ".$db_prefix."posts SET forum_id = '".$new_forum_id."' WHERE thread_id = '".$data['thread_id']."'");
				$result = dbquery("UPDATE ".$db_prefix."threads SET forum_id = '".$new_forum_id."' WHERE thread_id = '".$data['thread_id']."'");
				$error = 8;
			} else {
				// nothing to move. Odd. Then add a new one
				$donate_forum_add = true;
			}
		}
		if ($donate_forum_add) {
			// check if it doesn't exist from a previous activation
			$result = dbquery("SELECT * FROM ".$db_prefix."threads WHERE forum_id = '".$new_forum_id."' AND thread_subject = '".$locale['don453']."'");
			if (dbrows($result)) {
				$data = dbarray($result);
				$thread_id = $data['thread_id'];
			} else {
				// add if there wasn't any previous thread
				$result = dbquery("INSERT INTO ".$db_prefix."threads (forum_id, thread_subject, thread_author, thread_sticky, thread_locked, thread_lastpost, thread_lastuser)
									VALUES ('".$new_forum_id."', '".$locale['don453']."', '0', '1', '1', '".time()."', '0')");
				$thread_id = mysql_insert_id();
			}
			// and insert all donations in the thread
			$result = dbquery("SELECT * FROM ".$db_prefix."donations WHERE donate_type IN (0,1) ORDER BY donate_timestamp ASC");
			$message = $locale['don454']."\n\n";
			while ($data = dbarray($result)) {
				if ($data['donate_comment']) {
					$message .= "[b]".$data['donate_comment']."[/b]:\n";
				}
				$message .= ($data['donate_name'] == "" ? $locale['don215'] : $data['donate_name']);
				$message .= " ".$locale['don455']." ".$data['donate_currency']." ".$data['donate_amount'];
				$message .= " ".$locale['don456']." ".showdate('forumdate', $data['donate_timestamp'])."\n\n";
			}
			$result = dbquery("INSERT INTO ".$db_prefix."posts (forum_id, thread_id, post_subject, post_message, post_author, post_datestamp, post_ip)
								VALUES ('".$new_forum_id."', '".$thread_id."', '".$locale['don453']."', '".$message."', '0', '".time()."', '0.0.0.0')");
			$error = 9;
		}
		// update the settings record
		$result = dbquery("UPDATE ".$db_prefix."settings SET donate_forum_id = '".$new_forum_id."'");
		$settings['donate_forum_id'] = $new_forum_id;
	} else {
		// oops
	}
	// continue with the default action
	$action = "add";
} elseif (isset($_POST['save'])) {
	// validate the input
	$errfields = array();
	if (!isDec($donate_amount)) $errfields[] = sprintf($locale['don485'], $locale['don213']);
	if ($donate_amount == "0.00") $errfields[] = sprintf($locale['don484'], $locale['don213']);
	if ($donate_currency == "") $errfields[] = sprintf($locale['don484'], $locale['don218']);
	if ($donate_country == "") $errfields[] = sprintf($locale['don484'], $locale['don219']);
	if (count($errfields))
		$error = 3;
	else {
		switch ($action) {
			case "add":
				if ($donate_id != 0) {
					$error = 4;
				} else {
					// insert the new donation record
					$result = dbquery("INSERT INTO ".$db_prefix."donations (donate_name, donate_amount, donate_currency, donate_country, donate_comment, donate_timestamp, donate_type, donate_state) 
						VALUES ('$donate_name', '$donate_amount', '$donate_currency', '$donate_country', '$donate_comment', '".time()."', '$donate_type', '$donate_state')");
					$error = 1;
				}
				break;
			case "edit":
				if ($donate_id == 0) {
					$error = 5;
				} else {
					// update the donation record
					$result = dbquery("UPDATE ".$db_prefix."donations SET donate_name = '$donate_name', donate_amount = '$donate_amount', donate_currency = '$donate_currency', donate_country = '$donate_country', donate_comment = '$donate_comment', donate_timestamp = '$donate_timestamp', donate_type = '$donate_type', donate_state = '$donate_state' WHERE donate_id = '$donate_id'");
					$error = 2;
				}
				break;
			default:
				fallback(BASEDIR."index.php");
		}
		// reset the form
		if ($error <= 2) {
			$action = "add";
			$donate_id = 0;
			$donate_name = "";
			$donate_amount = "0.00";
			$donate_currency = "EUR";
			$donate_country = "NL";
			$donate_comment = "";
			$donate_timestamp = time();
			$donate_state = 1;
			$donate_type = 1;
		}
	}
}

// set the title and prepare the action
switch ($action) {
	case "add":
		$title = $locale['don400'];
		break;
	case "edit":
		$title = $locale['don401'];
		if ($error == 0) {
			$result = dbquery("SELECT * FROM ".$db_prefix."donations WHERE donate_id = '$id'");
			if (dbrows($result) == 0) {
				$error = 7;
			} else {
				$data = dbarray($result);
				$donate_id = $data['donate_id'];
				$donate_name = $data['donate_name'];
				$donate_amount = $data['donate_amount'];
				$donate_currency = $data['donate_currency'];
				$donate_country = $data['donate_country'];
				$donate_comment = $data['donate_comment'];
				$donate_timestamp = $data['donate_timestamp'];
				$donate_state = $data['donate_state'];
				$donate_type = $data['donate_type'];
			}
		}
		break;
	case "delete":
		if (!isset($id) && !isNum($id)) fallback(BASEDIR."index.php");
		break;
	default:
		fallback(BASEDIR."index.php");
}

// need to display an error message?
if (isset($error) && isNum($error) && $error) {
	switch ($error) {
		case 1:
			$error = $locale['don482'];
			break;
		case 2:
			$error = $locale['don483'];
			break;
		case 3:
			$error = "";
			foreach ($errfields as $field) {
				$error .= $field."<br />";
			}
			break;
		case 4:
			$error = $locale['don481'];
			break;
		case 5:
			$error = $locale['don486'];
			break;
		case 6:
			$error = $locale['don487'];
			$action = "add";
			break;
		case 7:
			$error = $locale['don489'];
			break;
		case 8:
			$error = $locale['don463'];
			break;
		case 9:
			$error = $locale['don462'];
			break;
		case 10:
			$error = $locale['don461'];
			break;
		default:
			$error = "Unknown error code!";
	}
} else {
	$error = "";
}

// create the country dropdown
$variables['countries'] = array();
$result = dbquery("SELECT DISTINCT ip_code, ip_name FROM ".$db_prefix."GeoIP ORDER BY ip_name");
while ($data = dbarray($result)) {
	$variables['countries'][] = $data;
}

// create the forums dropdown
$variables['forums'] = array();
$current_cat = "";
$result = dbquery(
	"SELECT f.forum_id, f.forum_name, f2.forum_name AS forum_cat_name
	FROM ".$db_prefix."forums f
	INNER JOIN ".$db_prefix."forums f2 ON f.forum_cat=f2.forum_id
	WHERE ".groupaccess('f.forum_access')." AND f.forum_cat!='0' ORDER BY f2.forum_order ASC, f.forum_order ASC"
);
while ($data2 = dbarray($result)) {
	if ($data2['forum_cat_name'] != $current_cat) {
		$data2['forum_new_cat'] = true;
		$current_cat = $data2['forum_cat_name'];
	} else {
		$data2['forum_new_cat'] = false;
	}
	if ($data2['forum_id'] == $settings['donate_forum_id']) {
		$data2['selected'] = true;
	} else {
		$data2['selected'] = false;
	}
	$variables['forums'][] = $data2;
}

// make sure rowstart has a valid value
if (!isset($rowstart) || !isNum($rowstart)) $rowstart = 0;
$variables['rowstart'] = $rowstart;

// get the number of available donation rows
$rows = dbcount('(*)', 'donations', '');
$variables['rows'] = $rows;

// get the donations for this page
$variables['donations'] = array();
$result = dbquery("SELECT * FROM ".$db_prefix."donations ORDER BY donate_timestamp DESC LIMIT $rowstart,".ITEMS_PER_PAGE);
while ($data = dbarray($result)) {
	$data['type'] = $types[$data['donate_type']];
	$variables['donations'][] = $data;
}

$variables['pagenav_url'] = FUSION_SELF.$aidlink."&amp;";

// form variables
$variables['action'] = $action;
$variables['donate_id'] = $donate_id;
$variables['donate_name'] = $donate_name;
$variables['donate_amount'] = $donate_amount;
$variables['donate_currency'] = $donate_currency;
$variables['donate_country'] = $donate_country;
$variables['donate_comment'] = $donate_comment;
$variables['donate_timestamp'] = $donate_timestamp;
$variables['donate_state'] = $donate_state;
$variables['donate_type'] = $donate_type;

// define the body panel variables
$template_panels[] = array('type' => 'body', 'name' => 'donations.admin_panel', 'title' => $title, 'template' => 'modules.donations.admin_panel.tpl', 'locale' => $locale_file);
$template_variables['donations.admin_panel'] = $variables;

// Call the theme code to generate the output for this webpage
require_once PATH_THEME."/theme.php";
?>