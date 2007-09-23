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
if (eregi("forum_threads_panel.php", $_SERVER['PHP_SELF']) || !defined('ExiteCMS_INIT')) die();

define('NEWEST_THREADS', 5);
define('HOTTEST_THREADS', 5);

// array's to store the variables for this panel
$variables = array();

// newest threads

$result = dbquery("
	SELECT * FROM ".$db_prefix."threads
	INNER JOIN ".$db_prefix."forums ON ".$db_prefix."threads.forum_id=".$db_prefix."forums.forum_id
	WHERE ".groupaccess('forum_access')." ORDER BY thread_lastpost DESC LIMIT ".NEWEST_THREADS);

$variables['new_threads'] = array();
while($data = dbarray($result)) {
	$variables['new_threads'][] = $data;
}

// hottest threads

$result = dbquery("
	SELECT tf.forum_id, tt.thread_id, tt.thread_subject, COUNT(tp.post_id) as count_posts 
	FROM ".$db_prefix."forums tf
	INNER JOIN ".$db_prefix."threads tt USING(forum_id)
	INNER JOIN ".$db_prefix."posts tp USING(thread_id)
	WHERE ".groupaccess('forum_access')." GROUP BY thread_id ORDER BY count_posts DESC, thread_lastpost DESC LIMIT ".HOTTEST_THREADS);

$variables['hot_threads'] = array();
while($data = dbarray($result)) {
	$data['count_posts'] = $data['count_posts'] - 1;
	$variables['hot_threads'][] = $data;
}

$template_variables['modules.forum_threads_panel'] = $variables;
?>