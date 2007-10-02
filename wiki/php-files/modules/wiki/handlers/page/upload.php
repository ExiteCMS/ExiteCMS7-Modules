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
global $db_prefix, $locale, $userdata, $imagetypes;

if ($this->HasAccess("read") && $this->page) {

	// error handling
	if (isset($_GET['status'])) {
		$status = $_GET['status'];
		switch ($status) {
			case "upy":
				$error = stripinput($GET['image'])." succesfully uploaded";
				break;
			case "upe":
				$error = "An image file with this name is already uploaded. Choose a different name";
				break;
			case "upn":
				$error = "The file uploaded is not recognized as a valid image";
				break;
		}
		if (isset($error)) {
			print("<table align='center' cellpadding='0' cellspacing='0' width='700'>
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
	if (isset($_POST['uploadimage'])) {
		$imgext = strrchr($_FILES['myfile']['name'], ".");
		$imgname = $_FILES['myfile']['name'];
		$imgsize = $_FILES['myfile']['size'];
		$imgtemp = $_FILES['myfile']['tmp_name'];
		// valid extension ?
		if (in_array($imgext, $imagetypes)) {
			// really an uploaded file?
			if (is_uploaded_file($imgtemp)){
				// really an image?
				if (verify_image($imgtemp)){
					$imgname = PATH_IMAGES."wiki/".substr("000000".$userdata['user_id'], -6)."_".$imgname;
					// destination doesn't exist yet?
					if (!file_exists($imgname)) {
						move_uploaded_file($imgtemp, $imgname);
						chmod($afolder.$imgname,0644);
						redirect($this->Href('upload')."&status=upy&image=".$_FILES['myfile']['name']);
					} else {
						redirect($this->Href('upload')."&status=upe");
					}
				} else {
					redirect($this->Href('upload')."&status=upn");
				}
			}
		} else {
			redirect($this->Href('upload')."&status=upn");
		}
	}

	if (isset($_GET['delete']) && $this->IsAdmin() && file_exists(PATH_IMAGES."wiki/".stripinput($_GET['delete']))) {
		unlink (PATH_IMAGES."wiki/".stripinput($_GET['delete']));
	}

	// open the page body
	print("<div class='page'>");

	// get the list of uploaded images
	$filelist = makefilelist(PATH_IMAGES.'wiki', ".|..");

	// create a page
	$upload_list = array();
	$uploads = count($filelist);
	$user = "";
	
	// display the uploaded files in a foldable list
	print("<table align='center' cellpadding='0' cellspacing='0' width='700'>
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
	foreach ($filelist as $file) {
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
		$imagesize = @getimagesize(PATH_IMAGES."wiki/".$file);
		print ("<tr>
					<td class='tbl'>
						$file
					</td>
					<td class='tbl' width='1%' style='white-space:nowrap'>
						".date("Y-m-d H:i", filemtime(PATH_IMAGES."wiki/".$file))."
					</td>
					<td class='tbl' width='1%' style='white-space:nowrap'>
						".(is_array($imagesize) ? ($imagesize[0]."x".$imagesize[1]) : "")."
					</td>
					<td align='right' width='1%' class='tbl' style='white-space:nowrap'>
						<a href='".$this->Href('upload')."&amp;userid=$usr&amp;view=$file'><img src='".THEME."images/image_view.gif' alt='View' title='View' /></a>&nbsp;");
		if ($this->IsAdmin()) {
			print ("<a href='".$this->Href('upload')."&amp;userid=$usr&amp;delete=$file' onclick='return DeleteItem()'><img src='".THEME."images/image_delete.gif' alt='Delete' title='Delete' /></a>
					</td>
				</tr>\n");
		}
		if (isset($_GET['view']) && stripinput($_GET['view']) == $file) {
			print ("<tr>
						<td class='tbl' colspan='4' align='center'>
							<img src='".IMAGES."wiki/$file' alt='$file' />
						</td>
					</tr>\n");
			print ("<tr height='20'>
						<td class='tbl2' colspan='4' align='center'>
							<div style='vertical-align:middle;display:table-cell;padding:4px;'>
								<b>WikiFormat</b>: {{image class=\"center\" alt=\"\" title=\"\" url=\"".IMAGES."wiki/$file\"}}
							</div>
						</td>
					</tr>\n");
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
	return confirm('Delete Download?');
	}
	</script>");

	// seperator
	print("<br /><hr /><br />");

	// upload form
	print("<form name='uploadform' method='post' action='".$this->Href('upload')."' enctype='multipart/form-data'>
	<table align='center' cellpadding='0' cellspacing='0' width='700'>
		<tr>
			<td align='center' class='tbl'>
				New Wiki Image: <input type='file' name='myfile' class='textbox' style='width:250px;' />
			</td>
		</tr>
		<tr>
			<td align='center' class='tbl'>
				<input type='submit' name='uploadimage' value='Upload' class='button' style='width:200px;' />
			</td>
		</tr>
	</table>
	</form>");

	// close the page body
	print("</div>");
}
?>