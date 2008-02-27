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
require_once dirname(__FILE__)."../../../includes/core_functions.php";
require_once PATH_ROOT."/includes/theme_functions.php";

// temp storage for template variables
$variables = array();

// defines
define('ITEMS_PER_PAGE', 20);

// only access for members, if not, fall back to the homepage
if (!iMEMBER) fallback(BASEDIR."index.php");

// load the forum functions include
require_once PATH_INCLUDES."forum_functions_include.php";

// validate the parameters and provide defaults if needed
if (!isset($id) or !isNum($id)) $id = $userdata['user_id'];

// check if the requested user_id exists
$result = dbarray(dbquery("SELECT user_name FROM ".$db_prefix."users WHERE user_id = '".$id."'"));
// and bailout if not...
if (!$result) fallback(BASEDIR."index.php");

// set the panel title
if ($id == $userdata['user_id']) {
	$title = $locale['027'];
} else {
	$title = sprintf($locale['049'], $result['user_name']);
}

// initialise the viewthread rowstart variable
if (!isset($rstart)) $rstart = "";

// check if we have anything to display
$result = dbquery(
	"SELECT tp.*, tf.* FROM ".$db_prefix."posts tp
	INNER JOIN ".$db_prefix."forums tf USING(forum_id)
	WHERE ".groupaccess('forum_access')." AND post_author='".$id."'"
);
$rows = dbrows($result);
$variables['rows'] = $rows;

// make sure rowstart has a valid value
if (!isset($rowstart) || !isNum($rowstart)) $rowstart = 0;
$variables['rowstart'] = $rowstart;

$result = dbquery(
	"SELECT tp.*, tf.* FROM ".$db_prefix."posts tp
	INNER JOIN ".$db_prefix."forums tf USING(forum_id)
	WHERE ".groupaccess('forum_access')." AND post_author='".$id."'
	ORDER BY post_datestamp DESC 
	LIMIT $rowstart,".ITEMS_PER_PAGE
);

$posts = array();
while ($data = dbarray($result)) {
	$data['poll'] = fpm_panels_poll_exists($data['forum_id'], $data['thread_id']);
	$posts[] = $data;
}
$variables['posts'] = $posts;

// required template variables
$variables['pagenav_url'] = FUSION_SELF."?id=".$id."&amp;";

// define the search body panel variables
$template_panels[] = array('type' => 'body', 'name' => 'my_posts', 'title' => $title, 'template' => 'modules.forum_threads_list_panel.my_posts.tpl');
$template_variables['my_posts'] = $variables;


// Call the theme code to generate the output for this webpage
require_once PATH_THEME."/theme.php";
?>