<?php
// default config

$wakkaConfig = array(
	'mysql_host' => $db_host,
	'mysql_database' => $db_name,
	'mysql_user' => $db_user,
	'table_prefix' => $db_prefix.'wiki_',
	'root_page' => 'HomePage',
	'wakka_name' => 'ExiteCMS Wiki',
	'base_url' => '/modules/wiki/index.php?wakka=',
	'rewrite_mode' => '0',
	'wiki_suffix' => '@Wiki',
	'action_path' => 'actions',
	'handler_path' => 'handlers',
	'gui_editor' => '1',
	'wikka_formatter_path' => 'formatters',
	'wikka_highlighters_path' => 'formatters',
	'geshi_path' => '3rdparty/plugins/geshi',
	'geshi_languages_path' => '3rdparty/plugins/geshi/geshi',
	'header_action' => 'header',
	'footer_action' => 'footer',
	'navigation_links' => '[[CategoryCategory Categories]] | PageIndex |  RecentChanges | RecentlyCommented',
	'logged_in_navigation_links' => '[[CategoryCategory Categories]] | PageIndex | RecentChanges | RecentlyCommented | [[UserSettings Change settings]]',
	'referrers_purge_time' => '30',
	'pages_purge_time' => '0',
	'xml_recent_changes' => '10',
	'hide_comments' => '0',
	'require_edit_note' => '0',
	'anony_delete_own_comments' => '1',
	'public_sysinfo' => '0',
	'double_doublequote_html' => 'safe',
	'external_link_tail' => '<img src="'.THEME.'images/external_link.jpg" alt="" />',
	'external_link_new_window' => 1,
	'sql_debugging' => '0',
	'admin_users' => '',
	'admin_email' => $settings['siteemail'],
	'upload_path' => IMAGES."wiki",
	'mime_types' => 'mime_types.txt',
	'geshi_header' => 'div',
	'geshi_line_numbers' => '1',
	'geshi_tab_width' => '4',
	'grabcode_button' => '1',
	'wikiping_server' => '',
	'default_write_acl' => '+',
	'default_read_acl' => '*',
	'default_comment_acl' => '+',
	'wakka_version' => '1.1.6.3',
	'mysql_password' => $db_pass,
	'meta_keywords' => '',
	'meta_description' => ''
);

// get wiki config variables from the CMSconfig table. They override the default config
$result = dbquery("SELECT * FROM ".$db_prefix."CMSconfig WHERE cfg_name LIKE 'wiki_%'");
while ($data = dbarray($result)) {
	// extract the wakkaConfig key from the cfg_name
	$cfgkey = substr($data['cfg_name'],5);
	// if the wakkaConfig key exists, overwrite the value
	if (isset($wakkaConfig[$cfgkey])) {
		$wakkaConfig[$cfgkey] = $data['cfg_value'];
	}
}

// check if there is a stylesheet for the Wiki in the current theme
// if not, take the Wiki module default
if (file_exists(PATH_THEME."wikka.css")) {
	$wakkaConfig['stylesheet'] = THEME.'wikka.css';
} else {
	$wakkaConfig['stylesheet'] = 'css/wikka.css';
}

// generate the default write ACL based on group membership
/*$result = dbquery("SELECT * FROM ".$db_prefix."user_groups WHERE group_name = 'Wiki Editors'");
if ($data = dbarray($result)) {
	$users = allusersingroup($data['group_id']);
	$acl = "";
	foreach ($users as $user) {
		$acl .= ($acl == "" ? "" : "\n") . $user['user_name'];
	}
	if ($acl != "") $wakkaConfig['default_write_acl'] = $acl;
}*/
?>