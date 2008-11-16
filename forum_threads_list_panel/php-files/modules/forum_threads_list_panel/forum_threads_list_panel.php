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
if (eregi("forum_threads_list_panel.php", $_SERVER['PHP_SELF']) || !defined('INIT_CMS_OK')) die();

// load the forum functions include
require_once PATH_INCLUDES."forum_functions_include.php";

// check if there is a thread time limit defined for guests
$thread_limit = ($settings['forum_guest_limit']== 0 || iMEMBER) ? 0 : (time() - $settings['forum_guest_limit'] * 86400);

// get the list of latest threads
$result = dbquery(
	"SELECT tf.*, tt.*, tu.user_id,user_name FROM ".$db_prefix."forums tf
	INNER JOIN ".$db_prefix."threads tt USING(forum_id)
	INNER JOIN ".$db_prefix."posts tp USING(thread_id)
	INNER JOIN ".$db_prefix."users tu ON tt.thread_lastuser=tu.user_id
	WHERE ".groupaccess('forum_access').($thread_limit==0?"":" AND tt.thread_lastpost > ".$thread_limit)."
	GROUP BY tt.thread_id ORDER BY tt.thread_lastpost DESC LIMIT 0,".$settings['numofthreads']
);

// array's to store the variables for this panel
$variables = array();
$threadlist = array();

// retrieve the rows found
if (dbrows($result) == 0) {
	$no_panel_displayed = true;
} else {
	$i = 0;
	while ($data = dbarray($result)) {
		$data['poll'] = fpm_panels_poll_exists($data['forum_id'], $data['thread_id']);
		$data2 = dbarray(dbquery("SELECT MAX(post_id) AS last_id FROM ".$db_prefix."posts WHERE thread_id = '".$data['thread_id']."'"));
		$data['last_id'] = $data2['last_id'];
		$data['count_posts'] = dbcount("(*)", "posts", "thread_id = '".$data['thread_id']."'") - 1;
		$threadlist[] = $data;
	}

}

$variables['threadlist'] = $threadlist;
$template_variables['modules.forum_threads_list_panel'] = $variables;
?>
