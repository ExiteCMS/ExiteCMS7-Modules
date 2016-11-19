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
if (strpos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false || !defined('INIT_CMS_OK')) die();

// number of articles to show in the panel
define('MAX_ARTICLES', 10);

// array's to store the variables for this panel
$variables = array();

// get the latest articles
switch($settings['article_localisation']) {
	case "multiple":
			$result = dbquery(
				"SELECT ta.*,tac.* FROM ".$db_prefix."articles ta
				INNER JOIN ".$db_prefix."article_cats tac ON ta.article_cat=tac.article_cat_id
				WHERE ".groupaccess('article_cat_access')." AND article_locale = '".$settings['locale_code']."' ORDER BY article_datestamp DESC LIMIT 0,".MAX_ARTICLES
			);
		break;
	case "single":
		// not implemented
	case "none":
	default:
		$result = dbquery(
			"SELECT ta.*,tac.* FROM ".$db_prefix."articles ta
			INNER JOIN ".$db_prefix."article_cats tac ON ta.article_cat=tac.article_cat_id
			WHERE ".groupaccess('article_cat_access')." ORDER BY article_datestamp DESC LIMIT 0,".MAX_ARTICLES
		);
}

$variables['articles'] = array();
if (dbrows($result) != 0) {
	while($data = dbarray($result)) {
		$variables['articles'][] = $data;
	}
}

$template_variables['modules.latest_articles_panel'] = $variables;
?>
