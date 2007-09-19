<?php
/*---------------------------------------------------+
| PLi-Fusion Content Management System               |
+----------------------------------------------------+
| Copyright 2007 WanWizard (wanwizard@gmail.com)     |
| http://www.pli-images.org/pli-fusion               |
+----------------------------------------------------+
| Some portions copyright ? 2002 - 2006 Nick Jones   |
| http://www.php-fusion.co.uk/                       |
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

// check if this user has any started any threads
$result = dbquery(
	"SELECT tt.*, tf.*, tu.user_id,user_name FROM ".$db_prefix."threads tt
	INNER JOIN ".$db_prefix."forums tf USING(forum_id)
	INNER JOIN ".$db_prefix."users tu ON tt.thread_lastuser=tu.user_id
	WHERE ".groupaccess('forum_access')." AND thread_author='".$userdata['user_id']."'"
);
$rows = dbrows($result);

// make sure rowstart has a valid value
if (!isset($rowstart) || !isNum($rowstart)) $rowstart = 0;

// get the threads for this page
$result = dbquery(
	"SELECT tt.*, tf.*, tu.user_id,user_name FROM ".$db_prefix."threads tt
	INNER JOIN ".$db_prefix."forums tf USING(forum_id)
	INNER JOIN ".$db_prefix."users tu ON tt.thread_lastuser=tu.user_id
	WHERE ".groupaccess('forum_access')." AND thread_author='".$userdata['user_id']."'
	ORDER BY thread_lastpost DESC LIMIT $rowstart,".ITEMS_PER_PAGE
);

$threads = array();
while ($data = dbarray($result)) {
	$data['poll'] = fpm_panels_poll_exists($data['forum_id'], $data['thread_id']);
	$data['post_count'] = dbcount("(*)", "posts", "thread_id='".$data['thread_id']."'");
	$threads[] = $data;
}
$variables['threads'] = $threads;

// required template variables
$variables['rows'] = $rows;
$variables['rowstart'] = $rowstart;

// define the search body panel variables
$template_panels[] = array('type' => 'body', 'name' => 'my_threads', 'template' => 'modules.forum_threads_list_panel.my_threads.tpl', 'locale' => array(PATH_LOCALE.LOCALESET."admin/forum_polls.php"));
$template_variables['my_threads'] = $variables;


// Call the theme code to generate the output for this webpage
require_once PATH_THEME."/theme.php";
?>