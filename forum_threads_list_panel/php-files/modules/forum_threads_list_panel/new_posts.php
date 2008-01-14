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

// marked as read requested?, mark, and fallback to the homepage
if (isset($markasread)) {
	$result = dbquery("
		SELECT p.thread_id
			FROM ".$db_prefix."posts p
			LEFT JOIN ".$db_prefix."threads_read tr ON p.thread_id = tr.thread_id
			WHERE tr.user_id = '".$userdata['user_id']."'
				AND (p.post_datestamp > ".$settings['unread_threshold']." OR p.post_edittime > ".$settings['unread_threshold'].")
				AND (p.post_datestamp > tr.thread_last_read OR p.post_edittime > tr.thread_last_read)
			GROUP BY p.thread_id
		");
	// update the last_read datestamp of all threads found
	while ($data = dbarray($result)) {
		$result2 = dbquery("UPDATE ".$db_prefix."threads_read SET thread_last_read = '".time()."' WHERE user_id = '".$userdata['user_id']."' AND thread_id = '".$data['thread_id']."'");
	}
	// done, fall back to the homepage
	fallback(BASEDIR."index.php");
}

// load the forum functions include
require_once PATH_INCLUDES."forum_functions_include.php";

// check if there are any unread posts for this user
$result = dbquery("SELECT count(*) as unread, sum(tr.thread_page) AS pages FROM ".$db_prefix."posts p LEFT JOIN ".$db_prefix."threads_read tr ON p.thread_id = tr.thread_id WHERE tr.user_id = '".$userdata['user_id']."' AND (p.post_datestamp > ".$settings['unread_threshold']." OR p.post_edittime > ".$settings['unread_threshold'].") AND (p.post_datestamp > tr.thread_last_read OR p.post_edittime > tr.thread_last_read)", false);
$variables['unread'] = ($result ? mysql_result($result, 0) : 0);

// and if so, get them
if ($variables['unread']) {
	// array to store the thread and post info
	$variables['posts'] = array();
	// get all threads with unread posts, and a count of the unread posts per thread
	$result = dbquery("
		SELECT p.forum_id, p.thread_id, count( * ) AS unread, f.forum_name, f.forum_cat, t.thread_subject, t.thread_views, t.thread_lastpost, MIN( p.post_id ) AS post_id
			FROM ".$db_prefix."posts p
			LEFT JOIN ".$db_prefix."forums f ON p.forum_id = f.forum_id
			LEFT JOIN ".$db_prefix."threads t ON p.thread_id = t.thread_id
			LEFT JOIN ".$db_prefix."threads_read tr ON p.thread_id = tr.thread_id
			WHERE tr.user_id = '".$userdata['user_id']."'
				AND (p.post_datestamp > ".$settings['unread_threshold']." OR p.post_edittime > ".$settings['unread_threshold'].")
				AND (p.post_datestamp > tr.thread_last_read OR p.post_edittime > tr.thread_last_read)
			GROUP BY p.thread_id
		");

	// get the number of unread threads
	$rows = dbrows($result);
	$variables['rows'] = $rows;

	// make sure rowstart has a valid value
	if (!isset($rowstart) || !isNum($rowstart)) $rowstart = 0;
	$variables['rowstart'] = $rowstart;

	// add additional info to the data retrieved
	while ($data = dbarray($result)) {
		$data['poll'] = fpm_panels_poll_exists($data['forum_id'], $data['thread_id']);
		// store the data
		$variables['posts'][] = $data;
	}
}

// define the search body panel variables
$template_panels[] = array('type' => 'body', 'name' => 'my_new_posts', 'template' => 'modules.forum_threads_list_panel.new_posts.tpl');
$template_variables['my_new_posts'] = $variables;

// Call the theme code to generate the output for this webpage
require_once PATH_THEME."/theme.php";
?>