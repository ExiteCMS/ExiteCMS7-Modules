<?php
/*---------------------------------------------------+
| ExiteCMS Content Management System                 |
+----------------------------------------------------+
| Copyright 2007 Harro "WanWizard" Verton, Exite BV  |
| for support, please visit http://exitecms.exite.eu |
+----------------------------------------------------+
| Some portions copyright 2002 - 2006 Nick Jones     |
| http://www.php-fusion.co.uk/                       |
+----------------------------------------------------+
| Released under the terms & conditions of v2 of the |
| GNU General Public License. For details refer to   |
| the included gpl.txt file or visit http://gnu.org  |
+----------------------------------------------------*/
require_once dirname(__FILE__)."/../../includes/core_functions.php";
require_once PATH_ROOT."/includes/theme_functions.php";

// load the locale for this module
locale_load("modules.download_bars_panel");

// TODO - WANWIZARD - 20070718 - NEED TO MOVE THIS TO SETTINGS
define('MAX_BARS', 9);

//check if the user has a right to be here. If not, bail out
if (!checkrights("D") || !defined("iAUTH") || $aid != iAUTH) fallback(BASEDIR."index.php");

// array's to store the variables for this panel
$variables = array();

$barmsg = "";
if(isset($_POST['save_bars'])) {
	$barcontent = $_POST['download_bar'];
	if (!is_array($barcontent)) fallback(BASEDIR."index.php");
	$bar_title = stripinput($_POST['bar_title']);
	$result = dbquery("UPDATE ".$db_prefix."download_cats SET download_cat_name = '".$bar_title."' WHERE download_cat_id = '0'");
	// reset all bar indicators before setting new ones
	$result = dbquery("UPDATE ".$db_prefix."downloads SET download_bar = '0'");
	foreach($barcontent as $key => $bar) {
		if ($bar != 0) $result = dbquery("UPDATE ".$db_prefix."downloads SET download_bar = '".$key."' WHERE download_id = '".$bar."'");
	}
	$barmsg = $locale['404'];
}
$variables['barmsg'] = $barmsg;

$result = dbquery("SELECT * FROM ".$db_prefix."download_cats");
if (dbrows($result) != 0) {

	// get all downloads from the database
	$variables['barfiles'] = array();
	$result = dbquery("SELECT * FROM ".$db_prefix."downloads d, ".$db_prefix."download_cats c WHERE d.download_cat = c.download_cat_id ORDER BY download_id DESC");
	while($data = dbarray($result)) {
		$variables['barfiles'][] = $data;
	}

	// get the download bar panel title
	$result = dbquery("SELECT download_cat_name FROM ".$db_prefix."download_cats WHERE download_cat_id='0'");
	if ($data = dbarray($result)) {
		$bar_title = $data['download_cat_name'];
	} else {
		$result = dbquery("INSERT INTO ".$db_prefix."download_cats (download_cat_name, download_cat_access) VALUES ('', '255')");
		$bar_title_id = mysql_insert_id();
		$result = dbquery("UPDATE ".$db_prefix."download_cats SET download_cat_id = '0' WHERE download_cat_id = '".$bar_title_id."'");
		$bar_title = "";
	}
	$variables['bar_title'] = $bar_title;
}

// panel definitions
$template_panels[] = array('type' => 'body', 'name' => 'modules.download_bars_admin', 'template' => 'modules.download_bars_panel.download_bars_admin.tpl', 'locale' => "modules.download_bars_panel");
$template_variables['modules.download_bars_admin'] = $variables;


// Call the theme code to generate the output for this webpage
require_once PATH_THEME."/theme.php";
?>