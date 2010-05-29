<?php
/*---------------------------------------------------------------------+
| ExiteCMS Content Management System                                   |
+----------------------------------------------------------------------+
| Copyright 2010 Exite BV, The Netherlands                             |
| for support, please visit http://www.exitecms.org                    |
+----------------------------------------------------------------------+
| Some code derived from PHP-Fusion, copyright 2002 - 2006 Nick Jones  |
+----------------------------------------------------------------------+
| Released under the terms & conditions of v2 of the GNU General Public|
| License. For details refer to the included gpl.txt file or visit     |
| http://gnu.org                                                       |
+----------------------------------------------------------------------+
| $Id:: newsletters.php 2043 2008-11-16 14:25:18Z WanWizard           $|
+----------------------------------------------------------------------+
| Last modified by $Author:: WanWizard                                $|
| Revision number $Rev:: 2043                                         $|
+---------------------------------------------------------------------*/
require_once dirname(__FILE__)."/../../includes/core_functions.php";
require_once PATH_ROOT."/includes/theme_functions.php";

// load the locale for this module
locale_load("modules.merge_forums");

// temp storage for template variables
$variables = array('error' => '',
		'forum_from_id' => 0,
		'forum_to_id' => 0,
		'prefix' => '[prefix]'
	);

// check for the proper admin access rights
if (!checkrights("mF") || !defined("iAUTH") || $aid != iAUTH) fallback(BASEDIR."index.php");

/*---------------------------------------------------+
| Local functions                                    |
+----------------------------------------------------*/

/*---------------------------------------------------+
| Main code                                          |
+----------------------------------------------------*/

// response processing

if (isset($_POST['merge'])) {
	// validate the parameters
	if (!isset($_POST['forum_from_id']) or !is_numeric($_POST['forum_from_id'])) {
		$forum_from_id = false;
	} else {
		$result = dbquery("SELECT * FROM ".$db_prefix."forums WHERE forum_id = ".mysql_real_escape_string($_POST['forum_from_id']));
		if ($data = dbarray($result)) {
			$forum_from_id = $data['forum_id'];
			$forum_from_name = $data['forum_name'];
		} else {
		$forum_from_id = false;
		}
	}
	if (!isset($_POST['forum_to_id']) or !is_numeric($_POST['forum_to_id'])) {
		$forum_to_id = false;
	} else {
		$result = dbquery("SELECT * FROM ".$db_prefix."forums WHERE forum_id = ".mysql_real_escape_string($_POST['forum_to_id']));
		if ($data = dbarray($result)) {
			$forum_to_id = $data['forum_id'];
			$forum_to_name = $data['forum_name'];
		} else {
		$forum_to_id = false;
		}
	}
	if (!isset($_POST['prefix'])) {
		$prefix = false;
	} else {
		if (empty($_POST['prefix'])) {
			$prefix = '';
		} else {
			$prefix = '['.rtrim(ltrim(trim($_POST['prefix']), '['), ']').'] ';
		}
	}

	// complete?
	if ($forum_from_id === false or $forum_to_id === false or $prefix === false) {
		$variables['error'] = $locale['mf502'];
	} else {
		// all is well
		$variables['forum_from_id'] = $forum_from_id;
		$variables['forum_to_id'] = $forum_to_id;
		$variables['prefix'] = $prefix;
		// first, add our prefix
		$result = dbquery("UPDATE ".$db_prefix."threads SET thread_subject = CONCAT('".mysql_real_escape_string($prefix)."', thread_subject) WHERE LEFT(thread_subject,1) != '[' AND forum_id = ".$forum_from_id);
		// move all threads to the new forum
		$result = dbquery("UPDATE ".$db_prefix."threads SET forum_id = ".$forum_to_id." WHERE forum_id = ".$forum_from_id);
		// add our prefix to the post subjects as well
		$result = dbquery("UPDATE ".$db_prefix."posts SET post_subject = CONCAT('".mysql_real_escape_string($prefix)."', post_subject) WHERE LEFT(post_subject,1) != '[' AND forum_id = ".$forum_from_id);
		// move all posts to the new forum as well
		$result = dbquery("UPDATE ".$db_prefix."posts SET forum_id = ".$forum_to_id." WHERE forum_id = ".$forum_from_id);
		// move all thread read pointers
		$result = dbquery("UPDATE ".$db_prefix."threads_read SET forum_id = ".$forum_to_id." WHERE forum_id = ".$forum_from_id);
		// update the to forum last user and post timestamp
		$result = dbquery("SELECT MAX(post_datestamp) AS postdate, MAX(post_edittime) AS editdate FROM ".$db_prefix."posts WHERE forum_id = ".$forum_to_id);
		if ($data = dbarray($result)) {
			if ($data['postdate'] > $data['editdate']) {
				$result = dbquery("SELECT post_author FROM ".$db_prefix."posts WHERE post_datestamp = (SELECT MAX(post_datestamp) FROM ".$db_prefix."posts WHERE forum_id = ".$forum_to_id.")");
				if ($data2 = dbarray($result)) {
					$result = dbquery("UPDATE ".$db_prefix."forums SET forum_lastuser = ".$data2['post_author'].", forum_lastpost = ".$data['postdate']." WHERE forum_id = ".$forum_to_id);
				}
			} else {
				$result = dbquery("SELECT post_edituser FROM ".$db_prefix."posts WHERE post_edittime = (SELECT MAX(post_edittime) FROM ".$db_prefix."posts WHERE forum_id = ".$forum_to_id.")");
				if ($data2 = dbarray($result)) {
					$result = dbquery("UPDATE ".$db_prefix."forums SET forum_lastuser = ".$data2['post_edituser'].", forum_lastpost = ".$data['editdate']." WHERE forum_id = ".$forum_to_id);
				}
			}
		}

		$variables['error'] = sprintf($locale['mf503'], $forum_from_name, $forum_to_name);
	}

// steps:
//
// update the thread subjects of the old forum id with the prefix (if defined)
// update threads, replace old forum_id by new_forum_id
// update posts, replace old forum_id by new_forum_id
// update threads_read, replace old forum_id by new_forum_id

}

// prepare the forum selection panel
$variables['forums'] = array();
$result = dbquery("SELECT * FROM ".$db_prefix."forums WHERE forum_cat > 0 ORDER BY forum_name");
while ($data = dbarray($result)) {
	$variables['forums'][$data['forum_id']] = $data['forum_name'];
}

// define the forum merge body panel
$template_panels[] = array('type' => 'body', 'name' => 'modules.merge_forums', 'template' => 'modules.merge_forums.tpl', 'locale' => "modules.merge_forums");
$template_variables['modules.merge_forums'] = $variables;

// Call the theme code to generate the output for this webpage
require_once PATH_THEME."/theme.php";
?>
