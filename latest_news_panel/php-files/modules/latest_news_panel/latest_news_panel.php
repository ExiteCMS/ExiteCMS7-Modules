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
if (eregi("lastest_news_panel.php", $_SERVER['PHP_SELF']) || !defined('INIT_CMS_OK')) die();

// number of articles to show in the panel
define('MAX_ITEMS', 10);

// array's to store the variables for this panel
$variables = array();

// get the latest news items
$result = dbquery("SELECT * FROM ".$db_prefix."news ORDER BY news_datestamp DESC LIMIT 0,".MAX_ITEMS
);

$variables['news'] = array();
if (dbrows($result) != 0) {
	while($data = dbarray($result)) {
		$variables['news'][] = $data;
	}
}

$template_variables['modules.latest_news_panel'] = $variables;
?>