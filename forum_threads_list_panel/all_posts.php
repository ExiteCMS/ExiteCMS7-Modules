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
require_once dirname(__FILE__)."../../../includes/core_functions.php";
require_once PATH_ROOT."/includes/theme_functions.php";

// temp storage for template variables
$variables = array();

// defines
define('ITEMS_PER_PAGE', 30);

// load the forum functions include
require_once PATH_INCLUDES."forum_functions_include.php";

// set the panel title
$title = $locale['027'];

// initialise the viewthread rowstart variable
if (!isset($rstart)) $rstart = "";

// check if we have anything to display
$result = dbquery(
	"SELECT tp.*, tf.* FROM ".$db_prefix."posts tp
	INNER JOIN ".$db_prefix."forums tf USING(forum_id)
	WHERE ".groupaccess('forum_access')
);
$rows = dbrows($result);
$variables['rows'] = $rows;

// make sure rowstart has a valid value
if (!isset($rowstart) || !isNum($rowstart)) $rowstart = 0;
$variables['rowstart'] = $rowstart;

$result = dbquery(
	"SELECT tp.*, tf.* FROM ".$db_prefix."posts tp
	INNER JOIN ".$db_prefix."forums tf USING(forum_id)
	WHERE ".groupaccess('forum_access')."
	ORDER BY post_datestamp DESC 
	LIMIT $rowstart,".ITEMS_PER_PAGE
);

$posts = array();
while ($data = dbarray($result)) {
	$data['poll'] = fpm_panels_poll_exists($data['forum_id'], $data['thread_id']);
	$posts[] = $data;
}
$variables['posts'] = $posts;

// define the search body panel variables
$template_panels[] = array('type' => 'body', 'name' => 'all_posts', 'title' => $title, 'template' => 'modules.forum_threads_list_panel.my_posts.tpl');
$template_variables['all_posts'] = $variables;

// Call the theme code to generate the output for this webpage
require_once PATH_THEME."/theme.php";
?>
