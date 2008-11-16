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
require_once dirname(__FILE__)."/../../includes/core_functions.php";
require_once PATH_ROOT."/includes/theme_functions.php";

// load the locale for this module
locale_load("modules.file_downloads");

// temp storage for template variables
$variables = array();

// make sure the parameter is valid
if (!isset($fd_id) || !isNum($fd_id)) $fd_id = 0;
if (!isset($dir) || !isNum($dir)) $dir = false;

// is a directory requested? If so, retrieve it from flash
if ($dir !== false) {
	$cats = session_get_flash("file_downloads");
	foreach($cats as $cat) {
		if ($cat['fd_id'] == $fd_id) {
			if (isset($cat['directories'][$dir])) {
				// get the sub directory
				$dir = $cat['directories'][$dir];
				$prev_dir = $cat['fd_this_dir'];
			} elseif ($dir == -1) {
				// go back to the previous directory
				$dir = $cat['fd_prev_dir'];
				if ($dir == "/") {
					// already at the root
					$prev_dir = "";
					$fd_id = 0;
				} else {
					// strip the last directory name
					$prev_dir = substr($cat['fd_this_dir'], 0, (strlen(strchr($cat['fd_this_dir'], "/"))-1)*-1);
				}
			} else {
				$dir = "";
			}
			break;
		}
	}
} else {
	$dir = "";
}

// get the available categories
$variables['cats'] = array();
$result = dbquery("SELECT * FROM ".$db_prefix."file_downloads WHERE ".($fd_id != 0 ? "fd_id = '$fd_id' AND " : "").groupaccess('fd_group')." ORDER BY fd_order");
while ($data = dbarray($result)) {
	// store directory paths
	$data['fd_prev_dir'] = isset($prev_dir) ? $prev_dir : "";
	$data['fd_this_dir'] = $data['fd_prev_dir'] . "/" . $dir;
	// get the list of directories for this category
	$data['directories'] = makefilelist($data['fd_path'].$data['fd_this_dir'], ".|..", true, "folders");
	// get the list of files for this category directory
	$files = makefilelist($data['fd_path'].$data['fd_this_dir'], ".|..", true, "files");
	$data['files'] = array();
	foreach($files as $file) {
		$data['files'][] = array('name' => $file, 'date' => filemtime($data['fd_path'].$data['fd_this_dir']."/".$file), 'size' => parsebytesize(filesize($data['fd_path'].$data['fd_this_dir']."/".$file), 3));
	}
	// store all info
	$variables['cats'][] = $data;
}
//_debug($variables['cats']);

// store the info found in the session, we need it later
session_set_flash("file_downloads", $variables['cats']);

// define the admin body panel
$template_panels[] = array('type' => 'body', 'name' => 'modules.file_downloads.file_downloads', 'template' => 'modules.file_downloads.file_downloads.tpl', 'locale' => "modules.file_downloads");
$template_variables['modules.file_downloads.file_downloads'] = $variables;

// Call the theme code to generate the output for this webpage
require_once PATH_THEME."/theme.php";
?>
