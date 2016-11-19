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

// load the locale for this module
locale_load("modules.wiki");

// temp storage for template variables
$variables = array();

// check for the proper admin access rights
if (!checkrights("wW") || !defined("iAUTH") || $aid != iAUTH) fallback(BASEDIR."index.php");

if (isset($_POST['savesettings'])) {
	// save the new settings
	$result = dbquery("UPDATE ".$db_prefix."configuration SET cfg_value = '".mysqli_real_escape_string($_db_link, stripinput($_POST['root_page']))."' WHERE cfg_name = 'wiki_root_page'");
	$result = dbquery("UPDATE ".$db_prefix."configuration SET cfg_value = '".mysqli_real_escape_string($_db_link, stripinput($_POST['wakka_name']))."' WHERE cfg_name = 'wiki_wakka_name'");
	$result = dbquery("UPDATE ".$db_prefix."configuration SET cfg_value = '".mysqli_real_escape_string($_db_link, stripinput($_POST['navigation_links']))."' WHERE cfg_name = 'wiki_navigation_links'");
	$result = dbquery("UPDATE ".$db_prefix."configuration SET cfg_value = '".mysqli_real_escape_string($_db_link, stripinput($_POST['logged_in_navigation_links']))."' WHERE cfg_name = 'wiki_logged_in_navigation_links'");
	$result = dbquery("UPDATE ".$db_prefix."configuration SET cfg_value = '".stripinput($_POST['hide_comments'])."' WHERE cfg_name = 'wiki_hide_comments'");
	$result = dbquery("UPDATE ".$db_prefix."configuration SET cfg_value = '".stripinput($_POST['require_edit_note'])."' WHERE cfg_name = 'wiki_require_edit_note'");
	$result = dbquery("UPDATE ".$db_prefix."configuration SET cfg_value = '".stripinput($_POST['anony_delete_own_comments'])."' WHERE cfg_name = 'wiki_anony_delete_own_comments'");
	$result = dbquery("UPDATE ".$db_prefix."configuration SET cfg_value = '".stripinput($_POST['external_link_new_window'])."' WHERE cfg_name = 'wiki_external_link_new_window'");
	$result = dbquery("UPDATE ".$db_prefix."configuration SET cfg_value = '".stripinput($_POST['default_write_acl'])."' WHERE cfg_name = 'wiki_default_write_acl'");
	$result = dbquery("UPDATE ".$db_prefix."configuration SET cfg_value = '".stripinput($_POST['default_read_acl'])."' WHERE cfg_name = 'wiki_default_read_acl'");
	$result = dbquery("UPDATE ".$db_prefix."configuration SET cfg_value = '".stripinput($_POST['default_comment_acl'])."' WHERE cfg_name = 'wiki_default_comment_acl'");
	$result = dbquery("UPDATE ".$db_prefix."configuration SET cfg_value = '".stripinput($_POST['admin_group'])."' WHERE cfg_name = 'wiki_admin_group'");
	$result = dbquery("UPDATE ".$db_prefix."configuration SET cfg_value = '".stripinput($_POST['forum_links'])."' WHERE cfg_name = 'wiki_forum_links'");
	$result = dbquery("UPDATE ".$db_prefix."configuration SET cfg_value = '".stripinput($_POST['page_template'])."' WHERE cfg_name = 'wiki_page_template'");
	$result = dbquery("UPDATE ".$db_prefix."configuration SET cfg_value = '".stripinput($_POST['report_uploads'])."' WHERE cfg_name = 'wiki_report_uploads'");
	// if the name of the homepage has changed, update the wiki record
	if ($settings['wiki_root_page'] != stripinput($_POST['root_page'])) {
		$result = dbquery("UPDATE ".$db_prefix."wiki_pages SET tag = '".mysqli_real_escape_string($_db_link, stripinput($_POST['root_page']))."' WHERE tag = '".mysqli_real_escape_string($_db_link, $settings['wiki_root_page'])."'");
		$result = dbquery("SELECT * FROM ".$db_prefix."wiki_pages WHERE body LIKE '%".mysqli_real_escape_string($_db_link, $settings['wiki_root_page'])."%'");
		while ($data = dbarray($result)) {
			$data['body'] = str_replace($settings['wiki_root_page'], stripinput($_POST['root_page']), $data['body']);
		}
	}
}

$settings2 = array();
$result = dbquery("SELECT * FROM ".$db_prefix."configuration");
while ($data = dbarray($result)) {
	$settings2[$data['cfg_name']] = $data['cfg_value'];
}
$variables['settings2'] = $settings2;

// get the list of user groups
$groups = getusergroups();
$variables['usergroups'] = array();
$variables['wikigroups'] = array();
foreach ($groups as $group) {
	$variables['usergroups'][] = $group;
	$group[0] = "G" . $group[0];
	$variables['wikigroups'][] = $group;
}

// define the admin body panel
$template_panels[] = array('type' => 'body', 'name' => 'modules.wiki_admin', 'template' => 'modules.wiki.wiki_admin.tpl', 'locale' => "modules.wiki");
$template_variables['modules.wiki_admin'] = $variables;

// Call the theme code to generate the output for this webpage
require_once PATH_THEME."/theme.php";
?>
