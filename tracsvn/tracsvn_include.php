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
| $Id:: tracsvn_include.php 2043 2008-11-16 14:25:18Z WanWizard       $|
+----------------------------------------------------------------------+
| Last modified by $Author:: WanWizard                                $|
| Revision number $Rev:: 2043                                         $|
+---------------------------------------------------------------------*/
if (strpos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false || !defined('INIT_CMS_OK')) die();

// convert the extensions list into an array
$tracsvn_extensions = explode(",", str_replace(" ", "", $settings['tracsvn_extensions']));

// extension to geshi processor mapping
$geshi_map = array();
$geshi_map['asm'] = "asm";
$geshi_map['asp'] = "asp";
$geshi_map['sh'] = "bash";
$geshi_map['c'] = "c";
$geshi_map['cpp'] = "cpp";
$geshi_map['c#'] = "csharp";
$geshi_map['css'] = "css";
$geshi_map['htm'] = "html4strict";
$geshi_map['html'] = "html4strict";
$geshi_map['ini'] = "ini";
$geshi_map['js'] = "javascript";
$geshi_map['sql'] = "mysql";
$geshi_map['php'] = "php";
$geshi_map['py'] = "python";
$geshi_map['tpl'] = "smarty";
$geshi_map['txt'] = "text";
$geshi_map['vbs'] = "vb";
$geshi_map['xml'] = "xml";

// convert wikimarkup to html
function tracsvn_wiki2html($text) {

	// get rid of trailing whitespace
	$text = rtrim(phpentities($text));
	// bullit implies line break
	$text = str_replace("\r\n*", "*", $text);
	$text = str_replace("[[BR]]*", "*", $text);
	// bullet lists
	$text = str_replace("\r\n *", "<br />*", $text);
	$text = preg_replace("/\*\s(.*?)(\w)/i", "&bull; \\1\\2", $text);
	// convert linebreaks
	if (FUSION_SELF == "trac.php") {
		$text = str_replace("\r\n", "<br />", $text);
		$text = str_replace("\n", "<br />", $text);
	} else {
		$text = str_replace("\r\n", "<br /><img src='".THEME."images/bullet.gif' alt=\"\" /> ", $text);
		$text = str_replace("\n", "<br /><img src='".THEME."images/bullet.gif' alt=\"\" /> ", $text);
	}
	// forced line breaks
	$text = str_replace("[[BR]]", "<br />", $text);
	// strike-through
	$text = preg_replace("/~~(.*?)~~/si", "<span style='text-decoration:line-through;'>\\1</span>", $text);
	// superscript
	$text = preg_replace("/\^(.*?)\^/si", "<sup>\\1</sup>", $text);
	// subscript
	$text = preg_replace("/,,(.*?),,/si", "<sub>\\1</sub>", $text);
	// bold and italics
	$text = preg_replace("/'''''(.*?)'''''/si", "<span style='font-weight:bold;font-style:italic;'>\\1</span>", $text);
	// bold
	$text = preg_replace("/'''(.*?)'''/si", "<span style='font-weight:bold;'>\\1</span>", $text);
	// italics
	$text = preg_replace("/''(.*?)''/i", "<span style='font-style:italic;'>\\1</span>", $text);
	// underline
	$text = preg_replace("/__(.*?)__/i", "<span style='font-style:underline;'>\\1</span>", $text);
	// monospace text block
	$text = preg_replace("/{{{(.*?)}}}/i", "<br /><hr ><span style='font-family:monospace;'>\\1</span><hr />", $text);
	// external links in a new window
	$text = preg_replace("/\[http(.*?) (.*?)\]/si", "<a href='http\\1' title='' target='_blank'>\\2</a><img src='".THEME."images/external_link.gif' alt='' />", $text);
	// other links as is
	$text = preg_replace("/\[(.*?) (.*?)\]/si", "<a href='\\1' title=''>\\2</a> alt='' />", $text);
	// svn revisions
	if (FUSION_SELF == "trac.php") {
		$text = preg_replace("/\[([0-9]+?)\]/i", "#<a href='svn.php?rev=\\1' title=''>\\1</a>", $text);
		$text = preg_replace("/#([0-9]+)/si", "#<a href='svn.php?rev=\\1' title=''>\\1</a>", $text);
	} else {
		$text = preg_replace("/\[([0-9]+?)\]/i", "#<a href='trac.php?step=ticket&amp;id=\\1' title=''>\\1</a>", $text);
		$text = preg_replace("/#([0-9]+)(\s)/si", "#<a href='trac.php?step=ticket&amp;id=\\1' title=''>\\1</a>\\2", $text);
	}
	$text = preg_replace("/rev. ([0-9]+)/i", "rev. <a href='svn.php?rev=\\1' title=''>\\1</a>", $text);

	// return the converted text
	return $text;
}

// check if a mapping between a trac user and a CMS user is defined
function tracsvn_getalias($tracname) {

	global $db_prefix;

	// validate the parameter
	if (!empty($tracname) && is_string($tracname)) {
		// translate Trac/SVN users to ExiteCMS users if needed
    	$result = dbquery("SELECT u.user_id, u.user_name FROM ".$db_prefix."users u, ".$db_prefix."tracsvn_alias t WHERE t.tracsvn_userid = u.user_id AND t.tracsvn_username = '$tracname' LIMIT 1");
    	if (dbrows($result)) {
	    	$tracname = dbarray($result);
		}
	}
	// not found? maybe there's a direct link with a member
	if (!is_array($tracname)) {
		// check the users table
    	$result = dbquery("SELECT user_id, user_name FROM ".$db_prefix."users WHERE user_name = '$tracname' LIMIT 1");
    	if (dbrows($result)) {
	    	$tracname = dbarray($result);
		}
	}

	// still not found? Use the tracname
	if (!is_array($tracname)) {
		$tracname = array('user_id' => '0', 'user_name' => $tracname);
	}

	return $tracname;
}

// get a file from SVN, and dump it based on the extension
function tracsvn_dump($svnfile) {
	global $settings, $geshi_map, $imagetypes;

	// validation
	if (!is_array($svnfile) || !isset($svnfile['path']) || !isset($svnfile['rev'])) {
		return "";
	}

	// check what to do with this file
	$parts = pathinfo($svnfile['path']);
	if (!isset($parts['extension'])) {
		$parts['extension'] = "";
	}
	$geshi_processor = isset($geshi_map[$parts['extension']]) ? $geshi_map[$parts['extension']] : "" ;
	$is_image = in_array(".".$parts['extension'], $imagetypes) ? true : false ;

	// if not an image, and there is no geshi processor, assume it's binary
	if (!$is_image && $geshi_processor == "") {
		$output = array();
		$output[] = "Binary files can not be displayed!";
		return $output;
	}

	// get the file
	$filename = tempnam("temp", "");
	$raw = tracsvn_ExtCmd(tracsvn_quoteCmd($settings['tracsvn_svncmd']." cat ".$settings['tracsvn_url'].$svnfile['path']."@".$svnfile['rev']." ".$settings['tracsvn_svnauth']." > $filename"));
	if ($raw[0] == "ERROR") {
		$output = array();
		$output[] = "While retrieving ".$svnfile['path'].":";
		foreach($raw as $nr => $line) {
			$output[] = $line;
		}
		return $output;
	}

	// handle image files
	if ($is_image) {
		$newfile = md5(uniqid("")).".".$parts['extension'];
		rename($filename, PATH_ROOT."files/cache/".$newfile);
		$output = array();
		$output[] = "<img src='".BASEDIR."files/cache/".$newfile."' alt='' />";
		return $output;
	}

	// else load the source code
	$sourcecode = file_get_contents($filename);

	// and do the GeSHi processing
	require_once PATH_GESHI.'geshi.php';
	$geshi = new GeSHi($sourcecode, $geshi_processor, PATH_GESHI.'geshi');
	$geshi->enable_classes();
	$geshi->set_overall_class('code');
	$geshi->set_header_type(GESHI_HEADER_DIV);
	$geshi->enable_line_numbers(GESHI_FANCY_LINE_NUMBERS);
	$geshi->set_tab_width(4);

	$output = '<!--start GeSHi-->'."\n".$geshi->parse_code()."\n".'<!--end GeSHi-->'."\n";

	// delete the temp file
	@unlink($filename);

	// and return the output
	return $output;
}

// generate the diff between two svn files
function tracsvn_diff($diffs) {
	global $settings;

	// validation
	if (!is_array($diffs) || !isset($diffs['path']) || !isset($diffs['rev']) || !isset($diffs['base_rev'])) {
		return "";
	}

	// get the base revision
	$oldfile = tempnam("temp", "");
	$raw = tracsvn_ExtCmd(tracsvn_quoteCmd($settings['tracsvn_svncmd']." cat ".$settings['tracsvn_url'].$diffs['path']."@".$diffs['base_rev']." ".$settings['tracsvn_svnauth']." > $oldfile"));
	if ($raw[0] == "ERROR") {
		$output = array();
		$output[] = array();
		$output[] = array('left' => "", 'right' => "", 'line' => 'While retrieving base_rev:');
		foreach($raw as $nr => $line) {
			$output[] = array('left' => "", 'right' => "", 'line' => $line);
		}
		return $output;
	}

	// get the new revision
	$newfile = tempnam("temp", "");
	$raw = tracsvn_ExtCmd(tracsvn_quoteCmd($settings['tracsvn_svncmd']." cat ".$settings['tracsvn_url'].$diffs['path']."@".$diffs['rev']." ".$settings['tracsvn_svnauth']." > $newfile"));
	if ($raw[0] == "ERROR") {
		$output = array();
		$output[] = array();
		$output[] = array('left' => "", 'right' => "", 'line' => 'While retrieving new_rev:');
		foreach($raw as $nr => $line) {
			$output[] = array('left' => "", 'right' => "", 'line' => $line);
		}
		return $output;
	}

	// get the diff between the two files
	$raw = tracsvn_ExtCmd(tracsvn_quoteCmd("diff -w -U 2 $oldfile $newfile"));
	if ($raw[0] == "ERROR") {
		$output = array();
		$output[] = array('left' => "", 'right' => "", 'line' => 'While preparing the diff:');
		foreach($raw as $nr => $line) {
			$output[] = array('left' => "", 'right' => "", 'line' => $line);
		}
		return $output;
	}
//_debug($raw, true);

	// delete the temp files
	@unlink($oldfile);
	@unlink($newfile);

	// initialisation
	$output = array();
	$diffcount = 0;

	// drop the last entry in the raw output
	array_pop($raw);

	// loop trough the raw output
	foreach($raw as $nr => $line) {

		// ignore the first two lines
		if ($nr == 0 || $nr == 1) continue;

		// check if we have a new diff block
		if (substr($line,0,2) == "@@") {
			// increment the diff count
			$diffcount++;
			// extract the linenumber info
			$line = explode(" ", substr($line,3,strlen($line)-6));
			$left = explode(",", substr($line[0],1));
			$right = explode(",", substr($line[1],1));
			$break = $left[1] / 2;
			// if this isn't the first block, insert a separator line
			if (count($output)) $output[] = array('left' => "...", 'right' => "...", 'line' => "");
			continue;
		}
		// create the array for this line
		$thisline = array();

		// check what kind of change it is
		switch (substr($line,0,1)) {
			case "-":
				// removed from the old file
				$thisline['left'] = $left[0]++;
				$thisline['right'] = "";
				break;

			case "+":
				// added to the new file
				$thisline['left'] = "";
				$thisline['right'] = $right[0]++;
				break;

			default:
				// same in both files
				$thisline['left'] = $left[0]++;
				$thisline['right'] = $right[0]++;
				break;
		}
		// line
		$thisline['line'] = stripinput(substr($line,2));
		$thisline['line'] = str_repeat("&nbsp;", strlen($thisline['line']) - strlen(ltrim($thisline['line']))) . ltrim($thisline['line']);

		// store this line
		$output[] = $thisline;
	}

	// store the diffcount
	$output[0]['diffcount'] = $diffcount;

	// and return the output
	return $output;
}

// On Windows machines, the whole line needs quotes round it so that it's
// passed to cmd.exe correctly
function tracsvn_quoteCmd($cmd) {

	if (CMS_GetOS() == "Windows") $cmd = "\"$cmd\"";
	return $cmd;
}

// run an external command
function tracsvn_ExtCmd($cmd, $mayReturnNothing = true) {

	$output = array ();
	$err = false;

	$c = tracsvn_quoteCmd($cmd);

	$descriptorspec = array (0 => array('pipe', 'r'), 1 => array('pipe', 'w'), 2 => array('pipe', 'w'));

	$resource = proc_open($c, $descriptorspec, $pipes);
	$error = "";

	if (!is_resource($resource)) {
		$output = array("ERROR", "badcmd", $cmd);
		return $output;
	}

	$handle = $pipes[1];
	$firstline = true;
	while (!feof($handle)) {
		$line = fgets($handle);
		if ($firstline && empty($line) && !$mayReturnNothing) {
			$err = true;
		}
		$firstline = false;
		$output[] = rtrim($line);
	}

	while (!feof($pipes[2])) {
		$error .= fgets($pipes[2]);
	}

	$error = trim($error);

	fclose($pipes[0]);
	fclose($pipes[1]);
	fclose($pipes[2]);

	proc_close($resource);

	if ($err) {
		$output = array("ERROR", "errout", $cmd, $error);
	}
	return $output;
}
?>
