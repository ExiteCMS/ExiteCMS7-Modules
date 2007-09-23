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

// make sure unread posts for other users are not marked
if (isset($markasread)) {
    if ($markasread <> $userdata['user_id'])
		redirect(BASEDIR."index.php");
    else {
		$result = dbquery("DELETE FROM ".$db_prefix."posts_unread WHERE user_id = ".$markasread);
		redirect(BASEDIR."index.php");
    }
}

// load the forum functions include
require_once PATH_INCLUDES."forum_functions_include.php";

// get the number of threads we have unread posts in
$threads = dbquery("SELECT DISTINCT thread_id FROM ".$db_prefix."posts_unread WHERE user_id = '".$userdata['user_id']."'");
$variables['threads'] = dbrows($threads);

// number of unread posts
$result = dbquery(
	"SELECT fp.*, ff.forum_cat, ff.forum_name, fu.user_name 
	FROM ".$db_prefix."posts_unread fpu, ".$db_prefix."posts fp, ".$db_prefix."forums ff, ".$db_prefix."users fu
	WHERE fpu.user_id = ".$userdata['user_id']." AND fpu.post_id = fp.post_id AND fp.forum_id = ff.forum_id AND fp.post_author = fu.user_id"
);
$rows = dbrows($result);
$variables['rows'] = $rows;

// make sure rowstart has a valid value
if (!isset($rowstart) || !isNum($rowstart)) $rowstart = 0;
$variables['rowstart'] = $rowstart;

// get this page of unread posts
$result = dbquery(
	"SELECT fp.*, ff.forum_cat, ff.forum_name, fu.user_name 
	FROM ".$db_prefix."posts_unread fpu, ".$db_prefix."posts fp, ".$db_prefix."forums ff, ".$db_prefix."users fu
	WHERE fpu.user_id = ".$userdata['user_id']." AND fpu.post_id = fp.post_id AND fp.forum_id = ff.forum_id AND fp.post_author = fu.user_id 
	ORDER BY post_datestamp ASC LIMIT $rowstart,".ITEMS_PER_PAGE
);

$posts = array();
while ($data = dbarray($result)) {
	$data['poll'] = fpm_panels_poll_exists($data['forum_id'], $data['thread_id']);
	$posts[] = $data;
}
$variables['posts'] = $posts;

// define the search body panel variables
$template_panels[] = array('type' => 'body', 'name' => 'my_new_posts', 'template' => 'modules.forum_threads_list_panel.new_posts_detail.tpl', 'locale' => array(PATH_LOCALE.LOCALESET."admin/forum_polls.php"));
$template_variables['my_new_posts'] = $variables;

// Call the theme code to generate the output for this webpage
require_once PATH_THEME."/theme.php";
?>