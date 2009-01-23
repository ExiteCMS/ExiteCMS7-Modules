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
$variables['fd_id'] = $fd_id;
if (!isset($dir)) $dir = ""; else $dir=stripinput($dir);
if (!isset($file)) $file = ""; else $file=stripinput($file);

// download request?
if ($file != "") {
	session_set_flash('file_downloads', array('dir' => $dir, 'file' => $file));
	redirect(BASEDIR."getfile.php?type=fd&fd_id=".$fd_id);
	exit;
}

// get the available categories
$variables['cats'] = array();
$result = dbquery("SELECT * FROM ".$db_prefix."file_downloads WHERE ".($fd_id != 0 ? "fd_id = '$fd_id' AND " : "").groupaccess('fd_group')." ORDER BY fd_order");
while ($data = dbarray($result)) {
	// create the full path (deal with any double slash)
	$data['path'] = str_replace("//", "/", $data['fd_path']."/".$dir);
	// hack test
	if ($data['fd_path'] != substr(realpath($data['path']),0,strlen($data['fd_path']))) {
		terminate('hack attempt detected! Program terminated and you activity has been logged!');
	}
	$data['dir'] = $dir;
	if (strpos($dir, "/") === false) {
		$data['prev_dir'] = "";
	} else {
		$data['prev_dir'] = substr($dir, 0, strlen($dir)-strlen(strrchr($dir, "/")));
	}
	// get the list of directories for this category
	$data['directories'] = makefilelist($data['path'], ".|..", true, "folders");
	// get the list of files for this category directory
	$rawfiles = makefilelist($data['path'], ".|..", true, "files");
	// get extra info for these files
	$files = array();
	$dates = array();
	$sizes = array();
	$data['files'] = array();
	foreach($rawfiles as $file) {
		$size = filesize($data['path']."/".$file);
		// hide all files with zero length
		if ($size > 0) {
			$files[] = $file;
			$dates[] = filemtime($data['path']."/".$file);
			$sizes[] = parsebytesize($size, 3);
			$data['files'][] = array('name' => $file, 'date' => filemtime($data['path']."/".$file), 'size' => parsebytesize(filesize($data['path']."/".$file), 3));
		}
	}
	switch ($data['fd_sort_field']) {
		case "NAME":
			switch ($data['fd_sort_order']) {
				case "ASC":
					// this sort order is default
					break;
				case "DESC":
					array_multisort($files, SORT_DESC, $data['files']);
					break;
			}
			break;
		case "DATE":
			switch ($data['fd_sort_order']) {
				case "ASC":
					array_multisort($dates, SORT_ASC, $data['files']);
					break;
				case "DESC":
					array_multisort($dates, SORT_DESC, $data['files']);
					break;
			}
			break;
	}
	// store all info
	$variables['cats'][] = $data;
}

// define the admin body panel
$template_panels[] = array('type' => 'body', 'name' => 'modules.file_downloads.file_downloads', 'template' => 'modules.file_downloads.file_downloads.tpl', 'locale' => "modules.file_downloads");
$template_variables['modules.file_downloads.file_downloads'] = $variables;

// Call the theme code to generate the output for this webpage
require_once PATH_THEME."/theme.php";
?>
