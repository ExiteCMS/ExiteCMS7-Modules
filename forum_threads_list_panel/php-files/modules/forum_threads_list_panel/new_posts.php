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

// check if there are any unread posts for this user
$unread = dbcount("(post_id)", "posts_unread", "user_id='".$userdata['user_id']."'");
$variables['unread'] = $unread;

// and if so, get them
if ($unread) {
	// get the number of threads with unread posts
	$result = dbquery("SELECT forum_id, thread_id, count( post_time ) AS unread FROM ".$db_prefix."posts_unread ".
		"WHERE user_id ='".$userdata['user_id']."' GROUP BY forum_id, thread_id ORDER BY post_time DESC");
	$rows = dbrows($result);
	$variables['rows'] = $rows;

	// make sure rowstart has a valid value
	if (!isset($rowstart) || !isNum($rowstart)) $rowstart = 0;
	$variables['rowstart'] = $rowstart;

	// get this page of unread posts
	$result = dbquery("SELECT forum_id, thread_id, count( post_time ) AS unread 
		FROM ".$db_prefix."posts_unread
		WHERE user_id ='".$userdata['user_id']."' 
		GROUP BY forum_id, thread_id 
		ORDER BY post_time DESC
		LIMIT $rowstart,".ITEMS_PER_PAGE);

	$posts = array();
	while ($data = dbarray($result)) {
		$data['poll'] = fpm_panels_poll_exists($data['forum_id'], $data['thread_id']);
		// get the forum and thread info needed
		$result2 = dbquery("SELECT f.forum_name, f.forum_cat, t.thread_subject, t.thread_views, t.thread_lastpost FROM ".$db_prefix."forums f, ".
			$db_prefix."threads t, ".$db_prefix."posts p WHERE f.forum_id = '".$data['forum_id']."' AND t.thread_id = '".$data['thread_id'].
			"' AND t.forum_id = f.forum_id");
		$data2 = dbarray($result2);
		$data['forum_name'] = $data2['forum_name'];
		$data['forum_cat'] = $data2['forum_cat'];
		$data['thread_subject'] = $data2['thread_subject'];
		$data['thread_views'] = $data2['thread_views'];
		$data['thread_lastpost'] = $data2['thread_lastpost'];
		// get the first unread post_id for this user and thread
		$result3 = dbquery("SELECT f.post_id, f.post_time, p.post_subject FROM ".$db_prefix."posts_unread f, ".$db_prefix."posts p WHERE f.user_id = '".$userdata['user_id']."' ".
			"AND f.thread_id = '".$data['thread_id']."' AND f.post_id = p.post_id ORDER BY `post_time` ASC LIMIT 1");
		$data3 = dbarray($result3);
		$data['post_id'] = $data3['post_id'];

		$posts[] = $data;
	}
	$variables['posts'] = $posts;
}

// define the search body panel variables
$template_panels[] = array('type' => 'body', 'name' => 'my_new_posts', 'template' => 'modules.forum_threads_list_panel.new_posts.tpl', 'locale' => array(PATH_LOCALE.LOCALESET."admin/forum_polls.php"));
$template_variables['my_new_posts'] = $variables;

// Call the theme code to generate the output for this webpage
require_once PATH_THEME."/theme.php";
?>