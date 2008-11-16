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
define('ITEMS_PER_PAGE', 20);

// only access for members, if not, fall back to the homepage
if (!iMEMBER) fallback(BASEDIR."index.php");

// load the forum functions include
require_once PATH_INCLUDES."forum_functions_include.php";

// check if this user has any started any threads
$result = dbquery(
	"SELECT tt.*, tf.*, tu.user_id,user_name FROM ".$db_prefix."threads tt
	INNER JOIN ".$db_prefix."forums tf USING(forum_id)
	INNER JOIN ".$db_prefix."users tu ON tt.thread_lastuser=tu.user_id
	WHERE ".groupaccess('forum_access')." AND thread_author='".$userdata['user_id']."'"
);
$rows = dbrows($result);
$variables['rows'] = $rows;

// make sure rowstart has a valid value
if (!isset($rowstart) || !isNum($rowstart)) $rowstart = 0;
$variables['rowstart'] = $rowstart;

// get the threads for this page
$result = dbquery(
	"SELECT tt.*, tf.*, tu.user_id,user_name FROM ".$db_prefix."threads tt
	INNER JOIN ".$db_prefix."forums tf USING(forum_id)
	INNER JOIN ".$db_prefix."users tu ON tt.thread_lastuser=tu.user_id
	WHERE ".groupaccess('forum_access')." AND thread_author='".$userdata['user_id']."'
	ORDER BY thread_lastpost DESC 
	LIMIT $rowstart,".ITEMS_PER_PAGE
);

$threads = array();
while ($data = dbarray($result)) {
	$data['poll'] = fpm_panels_poll_exists($data['forum_id'], $data['thread_id']);
	$data['post_count'] = dbcount("(*)", "posts", "thread_id='".$data['thread_id']."'");
	$threads[] = $data;
}
$variables['threads'] = $threads;

// define the search body panel variables
$template_panels[] = array('type' => 'body', 'name' => 'my_threads', 'template' => 'modules.forum_threads_list_panel.my_threads.tpl');
$template_variables['my_threads'] = $variables;


// Call the theme code to generate the output for this webpage
require_once PATH_THEME."/theme.php";
?>
