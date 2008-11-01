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
| $Id:: viewpage.php 1935 2008-10-29 23:42:42Z WanWizard              $|
+----------------------------------------------------------------------+
| Last modified by $Author:: WanWizard                                $|
| Revision number $Rev:: 1935                                         $|
+---------------------------------------------------------------------*/
require_once dirname(__FILE__)."../../../includes/core_functions.php";
require_once PATH_ROOT."/includes/theme_functions.php";

// make sure the page isn't cached
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");

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
			INNER JOIN ".$db_prefix."threads_read tr ON p.thread_id = tr.thread_id
			WHERE tr.user_id = '".$userdata['user_id']."'
				AND (p.post_datestamp > ".$settings['unread_threshold']." OR p.post_edittime > ".$settings['unread_threshold'].")
				AND ((p.post_datestamp > tr.thread_last_read OR p.post_edittime > tr.thread_last_read)
					OR (p.post_datestamp < tr.thread_first_read OR (p.post_edittime != 0 AND p.post_edittime < tr.thread_first_read)))
			GROUP BY p.thread_id
		");
	// update the last_read datestamp of all threads found
	while ($data = dbarray($result)) {
		$result2 = dbquery("UPDATE ".$db_prefix."threads_read SET thread_first_read = '0', thread_last_read = '".time()."' WHERE user_id = '".$userdata['user_id']."' AND thread_id = '".$data['thread_id']."'");
	}
	// done, fall back to the homepage
	fallback(BASEDIR."index.php");
}

// load the forum functions include
require_once PATH_INCLUDES."forum_functions_include.php";

// check if there are any unread threads for this user
if ($userdata['user_posts_unread']) {
	$result = dbquery("
		SELECT count(*) as unread, tr.thread_id
			FROM ".$db_prefix."posts p 
				INNER JOIN ".$db_prefix."forums f ON p.forum_id = f.forum_id 
				INNER JOIN ".$db_prefix."threads_read tr ON p.thread_id = tr.thread_id 
			WHERE ".groupaccess('f.forum_access')."
				AND tr.user_id = '".$userdata['user_id']."' 
				AND (p.post_datestamp > ".$settings['unread_threshold']." OR p.post_edittime > ".$settings['unread_threshold'].")
				AND ((p.post_datestamp > tr.thread_last_read OR p.post_edittime > tr.thread_last_read)
					OR (p.post_datestamp < tr.thread_first_read OR (p.post_edittime != 0 AND p.post_edittime < tr.thread_first_read)))
			GROUP BY tr.thread_id"
		);
} else {
	$result = dbquery("
		SELECT count(*) as unread, tr.thread_id 
			FROM ".$db_prefix."posts p 
				INNER JOIN ".$db_prefix."forums f ON p.forum_id = f.forum_id 
				INNER JOIN ".$db_prefix."threads_read tr ON p.thread_id = tr.thread_id 
			WHERE ".groupaccess('f.forum_access')."
				AND tr.user_id = '".$userdata['user_id']."' 
				AND p.post_author != '".$userdata['user_id']."'
				AND p.post_edituser != '".$userdata['user_id']."'
				AND (p.post_datestamp > ".$settings['unread_threshold']." OR p.post_edittime > ".$settings['unread_threshold'].")
				AND ((p.post_datestamp > tr.thread_last_read OR p.post_edittime > tr.thread_last_read)
					OR (p.post_datestamp < tr.thread_first_read OR (p.post_edittime != 0 AND p.post_edittime < tr.thread_first_read)))
			GROUP BY tr.thread_id"
		);
} 
$variables['threads'] = dbrows($result);

// if there are unread threads ...
if ($variables['threads']) {

	// get the unread posts
	if ($userdata['user_posts_unread']) {
		$result = dbquery("
			SELECT count(*) as unread 
				FROM ".$db_prefix."posts p 
					INNER JOIN ".$db_prefix."forums f ON p.forum_id = f.forum_id 
					INNER JOIN ".$db_prefix."threads_read tr ON p.thread_id = tr.thread_id 
				WHERE ".groupaccess('f.forum_access')."
					AND tr.user_id = '".$userdata['user_id']."' 
					AND (p.post_datestamp > ".$settings['unread_threshold']." OR p.post_edittime > ".$settings['unread_threshold'].")
					AND ((p.post_datestamp > tr.thread_last_read OR p.post_edittime > tr.thread_last_read)
						OR (p.post_datestamp < tr.thread_first_read OR (p.post_edittime != 0 AND p.post_edittime < tr.thread_first_read)))"
			);
	} else {
		$result = dbquery("
			SELECT count(*) as unread 
				FROM ".$db_prefix."posts p 
					INNER JOIN ".$db_prefix."forums f ON p.forum_id = f.forum_id 
					INNER JOIN ".$db_prefix."threads_read tr ON p.thread_id = tr.thread_id 
				WHERE ".groupaccess('f.forum_access')."
					AND tr.user_id = '".$userdata['user_id']."' 
					AND p.post_author != '".$userdata['user_id']."'
					AND p.post_edituser != '".$userdata['user_id']."'
					AND (p.post_datestamp > ".$settings['unread_threshold']." OR p.post_edittime > ".$settings['unread_threshold'].")
					AND ((p.post_datestamp > tr.thread_last_read OR p.post_edittime > tr.thread_last_read)
						OR (p.post_datestamp < tr.thread_first_read OR (p.post_edittime != 0 AND p.post_edittime < tr.thread_first_read)))"
			);
	} 
	$variables['rows'] = ($result ? mysql_result($result, 0) : 0);

	// make sure rowstart has a valid value
	if (!isset($rowstart) || !isNum($rowstart)) $rowstart = 0;
	$variables['rowstart'] = $rowstart;

	// get this page of unread posts
	if ($userdata['user_posts_unread']) {
		$result = dbquery("
				SELECT p.*, f.forum_name, f.forum_cat, u.user_name, t.thread_subject, t.thread_views, t.thread_lastpost
					FROM ".$db_prefix."posts p
					INNER JOIN ".$db_prefix."forums f ON p.forum_id = f.forum_id
					INNER JOIN ".$db_prefix."users u ON p.post_author = u.user_id
					INNER JOIN ".$db_prefix."threads t ON p.thread_id = t.thread_id
					INNER JOIN ".$db_prefix."threads_read tr ON p.thread_id = tr.thread_id
					WHERE ".groupaccess('f.forum_access')."
						AND tr.user_id = '".$userdata['user_id']."'
						AND (p.post_datestamp > ".$settings['unread_threshold']." OR p.post_edittime > ".$settings['unread_threshold'].")
						AND ((p.post_datestamp > tr.thread_last_read OR p.post_edittime > tr.thread_last_read)
							OR (p.post_datestamp < tr.thread_first_read OR (p.post_edittime != 0 AND p.post_edittime < tr.thread_first_read)))
					ORDER BY post_datestamp ASC 
					LIMIT $rowstart,".ITEMS_PER_PAGE
				);
	} else {
		$result = dbquery("
				SELECT p.*, f.forum_name, f.forum_cat, u.user_name, t.thread_subject, t.thread_views, t.thread_lastpost
					FROM ".$db_prefix."posts p
					INNER JOIN ".$db_prefix."forums f ON p.forum_id = f.forum_id
					INNER JOIN ".$db_prefix."users u ON p.post_author = u.user_id
					INNER JOIN ".$db_prefix."threads t ON p.thread_id = t.thread_id
					INNER JOIN ".$db_prefix."threads_read tr ON p.thread_id = tr.thread_id
					WHERE ".groupaccess('f.forum_access')."
						AND tr.user_id = '".$userdata['user_id']."'
						AND p.post_author != '".$userdata['user_id']."'
						AND p.post_edituser != '".$userdata['user_id']."'
						AND (p.post_datestamp > ".$settings['unread_threshold']." OR p.post_edittime > ".$settings['unread_threshold'].")
						AND ((p.post_datestamp > tr.thread_last_read OR p.post_edittime > tr.thread_last_read)
							OR (p.post_datestamp < tr.thread_first_read OR (p.post_edittime != 0 AND p.post_edittime < tr.thread_first_read)))
					ORDER BY post_datestamp ASC 
					LIMIT $rowstart,".ITEMS_PER_PAGE
				);
	}

	$posts = array();
	while ($data = dbarray($result)) {
		// add poll data if present
		$data['poll'] = fpm_panels_poll_exists($data['forum_id'], $data['thread_id']);
		$posts[] = $data;
	}
	$variables['posts'] = $posts;
}

// define the search body panel variables
$template_panels[] = array('type' => 'body', 'name' => 'my_new_posts', 'template' => 'modules.forum_threads_list_panel.new_posts_detail.tpl');
$template_variables['my_new_posts'] = $variables;

// Call the theme code to generate the output for this webpage
require_once PATH_THEME."/theme.php";
?>
