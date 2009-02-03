<?php
/*---------------------------------------------------+
| ExiteCMS Content Management System                 |
+----------------------------------------------------+
| Copyright 2007 Harro "WanWizard" Verton, Exite BV  |
| for support, please visit http://exitecms.exite.eu |
+----------------------------------------------------+
| Released under the terms & conditions of v2 of the |
| GNU General Public License. For details refer to   |
| the included gpl.txt file or visit http://gnu.org  |
+----------------------------------------------------*/

// globals used in PM function storemessage()
global $db_prefix, $locale, $userdata, $imagetypes, $settings, $action, $attachments, $global_options, $totals, $random_id;

// no upload allowed if no write access to the page!
if (!$this->HasAccess("write")) {
	redirect($this->Href());
}

// load the locale
locale_load('modules.wiki');

// (error) message handling
if (isset($_GET['status'])) {
	$status = stripinput($_GET['status']);
	$file = isset($_GET['file']) ? stripinput($_GET['file']) : "";
	switch ($status) {
		case "upy":
			$error = $file." succesfully uploaded";
			break;
		case "upe":
			$error = $file." succesfully replaced";
			break;
		case "upi":
			$error = "The file uploaded has an illegal file type";
			break;
		case "upn":
			$error = "The file uploaded is not recognized as a valid image";
			break;
		case "upx":
			$error = "The file is not really uploaded. Hacking attempt logged!";
			break;
		default:
			break;
	}
	if (isset($error)) {

		// no we need to report this to the wiki admins?
		if (!empty($settings['wiki_report_uploads'])) {

			// include the pm functions
			include_once PATH_INCLUDES."pm_functions_include.php";

			// create the PM message
			$message = array();
			$message['pm_subject'] = $locale['430'];
			$message['pm_message'] = sprintf($locale['431'], $userdata['user_name'], $error);
			$message['pm_size'] = strlen($message['pm_message']);
			$message['pm_datestamp'] = time();
			$message['pm_smileys'] = 1;
			$message['recipients'] = array(-1 * $settings['wiki_report_uploads']);
			$message['user_ids'] = array();

			$group_id = $settings['wiki_report_uploads'];
			if ($group_id == "101" || $group_id == "102" || $group_id == "103") {
				// message to a user_level based group
				$result = dbquery(
					"SELECT u.user_id, u.user_name, u.user_email, mo.pmconfig_email_notify FROM ".$db_prefix."users u
					LEFT JOIN ".$db_prefix."pm_config mo USING(user_id)
					WHERE user_status = '0' AND user_level >= '".$group_id."'"
				);
			} else {
				// message to a user_groups based group
				$groups = array();
				// gather the group and it's sub-groups into an array
				getgroupmembers($group_id);
				$sql = "SELECT u.user_id, u.user_name, u.user_email, mo.pmconfig_email_notify FROM ".$db_prefix."users u
						LEFT JOIN ".$db_prefix."pm_config mo USING(user_id)
						WHERE ";
				$c = 0;
				foreach ($groups as $group) {
					$sql .= ($c++==0?"":"OR ")."user_groups REGEXP('^\\\.{$group}$|\\\.{$group}\\\.|\\\.{$group}$') ";
				}
				$result = dbquery($sql);
			}

			// process the user information retrieved
			while ($data = dbarray($result)) {
				// make sure we don't already have this user (due to group membership)
				if (!in_array($data['user_id'], $message['user_ids'])) {
				// add it to the processed user_ids list
					$message['user_ids'][] = $data;
				}
			}

			// if any recipients found, send the PM message
			if (count($message['user_ids'] ) > 0) {
				storemessage($message, false, true);
			}

		}

		print("<table align='center' cellpadding='0' cellspacing='0' width='100%'>
		<tr>
			<td class='tbl' align='center'>
				<br />
				<b>".$error."</b>
				<br /><br />
			</td>
		</tr>
		</table>\n");
	}
}
// parameter processing
$userid = isset($_GET['userid']) ? stripinput($_GET['userid']) : -1;
if (isset($_POST['uploadfile']) && !empty($_FILES['myfile']['name'])) {
	$imgext = strrchr($_FILES['myfile']['name'], ".");
	$imgname = $_FILES['myfile']['name'];
	$imgsize = $_FILES['myfile']['size'];
	$imgtemp = $_FILES['myfile']['tmp_name'];

	// check if this file has really been uploaded
	if (is_uploaded_file($imgtemp)) {

		// check if this file has a forbidden extension
		if (in_array($imgext, explode(",", $settings['attachtypes']))) {
			redirect($this->Href('upload')."&file=".stripinput($imgname)."&status=upi");
		}

		// check if the file is an image file
		if (in_array($imgext, $imagetypes)) {
			if (verify_image($imgtemp)){
				$imgname = PATH_IMAGES."wiki/".substr("000000".$userdata['user_id'], -6)."_".$imgname;
				$newfile = !file_exists($imgname);
				move_uploaded_file($imgtemp, $imgname);
				chmod($afolder.$imgname,0644);
				if ($newfile) {
					redirect($this->Href('upload')."&file=".stripinput($imgname)."&status=upy");
				} else {
					redirect($this->Href('upload')."&file=".stripinput($imgname)."&status=upe");
				}
			} else {
				redirect($this->Href('upload')."&file=".stripinput($imgname)."&status=upn");
			}

		} else {

			$imgname = PATH_ROOT."files/wiki/".substr("000000".$userdata['user_id'], -6)."_".$imgname;
			$newfile = !file_exists($imgname);
			move_uploaded_file($imgtemp, $imgname);
			chmod($afolder.$imgname,0644);
			if ($newfile) {
				redirect($this->Href('upload')."&file=".stripinput($imgname)."&status=upy");
			} else {
				redirect($this->Href('upload')."&file=".stripinput($imgname)."&status=upe");
			}

		}

	} else {
		redirect($this->Href('upload')."&file=".stripinput($imgname)."&status=upx");
	}

}

if (isset($_GET['delete']) && isset($_GET['type']) && $this->IsAdmin()) {
	switch (stripinput($_GET['type'])) {
		case "F":
			unlink (PATH_ROOT."files/wiki/".stripinput($_GET['delete']));
			break;
		case "I":
			unlink (PATH_IMAGES."wiki/".stripinput($_GET['delete']));
			break;
		default:
	}
}

// get the list of uploaded images and files
$filelist = array_flip(makefilelist(PATH_IMAGES.'wiki', ".|.."));
foreach($filelist as $key => $value) {
	$filelist[$key] = "I";
}
$filelist = array_merge($filelist, array_flip(makefilelist(PATH_ROOT.'files/wiki', ".|..")));
foreach($filelist as $key => $value) {
	if (isNum($value)) $filelist[$key] = "F";
}
ksort($filelist);

// create a page
$upload_list = array();
$uploads = count($imagelist) + count($filelist);
$user = "";

// open the page body
print("<div class='page'>");

// display the uploaded files in a foldable list
print("<table align='center' cellpadding='0' cellspacing='0' width='100%'>
<tr>
	<td class='tbl2' style='white-space:nowrap;'>
		Uploaded by
	</td>
	<td align='right' class='tbl2'>
		Options
	</td>
</tr>
<tr>
	<td colspan='2' height='1'>
	</td>
</tr>\n");

$first = true;
foreach ($filelist as $file => $filetype) {
	$s = explode("_", $file);
	$usr = count($s) > 1 ? (int) $s[0] : 0;
	if ($usr != $user) {
		$user = $usr;
		if ($usr == 0) {
			$username = $locale['user2'];;
		} else {
			$result = dbquery("SELECT user_name FROM ".$db_prefix."users WHERE user_id = '$usr'");
			if ($data = dbarray($result)) {
				$username = $data['user_name'];
			}
		}
		// close the previous block?
		if (!$first) {
			print ("</table>
				</div>
			</td>
		</tr>\n");
		} else {
			$first = false;
		}
		// new user
		print ("<tr>
		<td class='tbl2'>
			<img src='".THEME."images/bullet.gif' alt='' />&nbsp;
			<a href='".BASEDIR."profile.php?lookup=$usr'>$username</a>
		</td>
		<td class='tbl2' align='right'>
			<img onclick=\"javascript:flipBox('dl_$usr')\" src='".THEME."images/panel_".($userid == $usr ? "off" : "on").".gif' name='b_dl_$usr' alt='' />
		</td>
	</tr>
	<tr>
		<td colspan='2'>
			<div id='box_dl_$usr' style='".($userid == $usr ? "" : "display:none")."'>
				<table cellpadding='0' cellspacing='0' width='100%'>\n");
	}
	if ($filetype == "I") {
		$imagesize = @getimagesize(PATH_IMAGES."wiki/".$file);
		$filetime = date("Y-m-d H:i", filemtime(PATH_IMAGES."wiki/".$file));
	} else {
		$imagesize = "";
		$filetime = date("Y-m-d H:i", filemtime(PATH_ROOT."files/wiki/".$file));
	}
	print ("<tr>
				<td class='tbl'>
					$file
				</td>
				<td class='tbl' width='1%' style='white-space:nowrap'>
					".$filetime."
				</td>
				<td class='tbl' width='1%' style='white-space:nowrap'>
					".(is_array($imagesize) ? ($imagesize[0]."x".$imagesize[1]) : "")."
				</td>
				<td align='right' width='1%' class='tbl' style='white-space:nowrap'>");
	print ("
					<a href='".$this->Href('upload')."&amp;userid=$usr&amp;view=$file&amp;type=$filetype'><img src='".THEME."images/image_view.gif' alt='View' title='View' /></a>&nbsp;");
	if ($this->IsAdmin()) {
		if ($filetype == "I") {
			print ("<a href='".$this->Href('upload')."&amp;userid=$usr&amp;delete=$file&amp;type=I' onclick='return DeleteItem()'><img src='".THEME."images/picture_delete.gif' alt='Delete' title='Delete Image' /></a>");
		} else {
			print ("<a href='".$this->Href('upload')."&amp;userid=$usr&amp;delete=$file&amp;type=F' onclick='return DeleteItem()'><img src='".THEME."images/page_delete.gif' alt='Delete' title='Delete File' /></a>");
		}
		print ("</td>
			</tr>\n");
	}
	if (isset($_GET['view']) && stripinput($_GET['view']) == $file) {
		if (stripinput($_GET['type']) == "I") {
			print ("<tr>
					<td class='tbl2' colspan='4' align='center'>
						<img src='".IMAGES."wiki/$file' alt='$file' />
					</td>
				</tr>\n");
			print ("<tr>
					<td class='tbl2' colspan='4' align='center'>
						<div style='vertical-align:middle;display:table-cell;padding:4px;'>
							<b>Copy to Wiki</b>:<br /> {{image class=\"center\" alt=\"$file\" title=\" description here \" url=\"$file\"}}
						</div>
					</td>
				</tr>\n");
		} else {
			print ("<tr>
					<td class='tbl2' colspan='4' align='center'>
						<div style='vertical-align:middle;display:table-cell;padding:4px;'>
							<b>Copy to Wiki</b>:<br /> [[".$settings['siteurl']."files/wiki/$file ".substr($file,7)."]]
						</div>
					</td>
				</tr>\n");
		}
	}
}
// need to close the last block?
if (!$first) {
	print ("</table>
		</div>
	</td>
</tr>\n");
}
print ("</table>
<script type='text/javascript'>
function DeleteItem()
{
return confirm('Delete uploaded file?');
}
</script>");

// file path notice
print("<br /><div style='text-align:center;' class='small'>To prevent abuse, the wiki administrator(s) will be notified about every file uploaded</div>");

// seperator
print("<hr /><br />");

// upload form
print("<form name='uploadform' method='post' action='".$this->Href('upload')."' enctype='multipart/form-data'>
<table align='center' cellpadding='0' cellspacing='0' width='100%'>
	<tr>
		<td align='center' class='tbl'>
			New Wiki File: <input type='file' name='myfile' class='textbox' style='width:250px;' />
		</td>
	</tr>
	<tr>
		<td align='center' class='tbl'>
			<input type='submit' name='uploadfile' value='Upload' class='button' />
		</td>
	</tr>
</table>
</form>");

// close the page body
print("</div>");
?>
