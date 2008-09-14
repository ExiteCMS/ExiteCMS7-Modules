<?php

$_ID = $_POST["_ID"];
$PHOTO_ID = $_POST["PHOTO_ID"];
$PHOTO_SHOW = $_POST["PHOTO_SHOW"];
$ref = $_POST["ref"];

$src1 = $_POST["src1"];

$GalleryAlbumTitle = $_POST["GalleryAlbumTitle"];
$GalleryAlbumDesc = nl2br(trim($_POST["GalleryAlbumDesc"])." ");
$Owner = $_POST["Owner"];

$PhotoTitle = trim($_POST["PhotoTitle"])." ";
$PhotoDesc = nl2br(trim($_POST["PhotoDesc"])." ");
$Keywords = trim($_POST["Keywords"])." ";

$usr = new VmtUser();
$uid = $usr->getIdByLogin($_SESSION["uid"]);

$obj = new GalleryAlbum();

if (($_ID == "" || $_ID == "0" || $_ID == "-1") && ($frType != "2" && $frType != "3" && $frType != "4")) {
	$frType = "0";
}
elseif ($frType != "2" && $frType != "3" && $frType != "4") {
	$frType = "1";
}
if ($frType != "2" && $frType != "3" && $frType != "4") {
	if ($_FILES['GalleryFile']['name'] != "") {
		$uploadPath = ROOT_PATH."var/usr/images/Gallery/Original/";
		$tempPath =  "var/usr/images/Gallery/Original/";
		$imagePath = "var/usr/images/Gallery/";
		$thumbPath = "var/usr/images/Gallery/Thumbnail/";

		$orig_name = $_FILES['GalleryFile']['name'];
		$file_name = ereg_replace("[^a-z0-9._]", "", ereg_replace("[^a-z0-9._]", "", ereg_replace (" ", "_", ereg_replace("%20", "_", strtolower($orig_name)))));	
		$zip_upload = false;
		
		$upload_error = false;
		switch($_FILES['GalleryFile']["error"]) {
			case "1":
				$upload_error = true;
				$error_msg = "The uploaded file exceeds the maximum upload size (".ini_get('upload_max_filesize').")."; 
			break;
			case "2":
				$upload_error = true;
				$error_msg = "The uploaded file exceeds the maximum upload size (".ini_get('upload_max_filesize').")."; 
			break;
			case "3":
				$upload_error = true;
				$error_msg = "The uploaded file was only partially uploaded."; 
			break;
			case "4":
				$upload_error = true;
				$error_msg = "No file was uploaded."; 
			break;
			case "6":
				$upload_error = true;
				$error_msg = "Missing a temporary folder."; 
			break;
			case "7":
				$upload_error = true;
				$error_msg = "Failed to write file to disk."; 
			break;
			case "8":
				$upload_error = true;
				$error_msg = "File upload stopped by extension."; 
			break;
		}


		if ($upload_error) {
?>
				<script>parent.GlobalModalPopup.Close("PopUpload");</script>
				<script>parent.document.getElementById('ErrorMsgUpload').innerHTML='<?=$error_msg;?>';</script>
				<script>parent.GlobalModalPopup("PopUpErrorUpload");</script>

<?
				exit;
		}
		if (strtolower($_FILES['GalleryFile']['type']) == "application/zip") {

			$zip_upload = true;
			if (move_uploaded_file($_FILES['GalleryFile']['tmp_name'], $uploadPath.$file_name)) {

				$file_arr = unzip($uploadPath.$file_name,$uploadPath);
				
				$size = sizeof($file_arr);
				for ($i=0;$i<$size;$i++) {
					$fileName[$i] = $imagePath.$file_arr[$i];
					list($width, $height) = getimagesize($tempPath.$file_arr[$i]);
					if ($width > 600) {
						$w = 600;
						$h = ($height / $width) * 600;
					
						$width = $w;
						$height = $h;
					}
					if ($height > 400) {
						$w = ($width / $height) * 400;
						$h = 400;
					
						$width = $w;
						$height = $h;
					}


					create_thumbnail($tempPath.$file_arr[$i],$fileName[$i],"","{w,h}",$width,$height);
					$thumbName[$i] = $thumbPath.$file_arr[$i];
					create_thumbnail($tempPath.$file_arr[$i],$thumbName[$i],100,"w");
					//unlink($tempPath.$file_name);

					if (eregi(".bmp",strtolower($fileName[$i]))) {
						$fileName[$i] = eregi_replace(".bmp",".bmp.png",strtolower($fileName[$i]));
						$thumbName[$i] = eregi_replace(".bmp",".bmp.png",strtolower($thumbName[$i]));
					}
				}
				unlink($uploadPath.$file_name);
			}
		}
		else {
			$zip_upload = false;
			$file = "";
			if (move_uploaded_file($_FILES['GalleryFile']['tmp_name'], $uploadPath.$file_name)) {
				$fileName = $imagePath.$file_name;
				list($width, $height) = getimagesize($tempPath.$file_name);
				if ($width > 600) {
					$w = 600;
					$h = ($height / $width) * 600;
				
					$width = $w;
					$height = $h;
				}
				if ($height > 400) {
					$w = ($width / $height) * 400;
					$h = 400;
				
					$width = $w;
					$height = $h;
				}


				create_thumbnail($tempPath.$file_name,$fileName,"","{w,h}",$width,$height);
				$thumbName = $thumbPath.$file_name;
				create_thumbnail($tempPath.$file_name,$thumbName,100,"w");
				//unlink($tempPath.$file_name);
			}

			if (eregi(".bmp",strtolower($fileName))) {
				$fileName = eregi_replace(".bmp",".bmp.png",strtolower($fileName));
				$thumbName = eregi_replace(".bmp",".bmp.png",strtolower($thumbName));
			}
		}
	}

	if ($_FILES['GalleryAlbumIcon']['name'] != "") {
		$uploadPath = ROOT_PATH."var/tmp/";
		$tempPath =  "var/tmp/";
		$imagePath = "var/usr/images/Icon/";

		$orig_name = $_FILES['GalleryAlbumIcon']['name'];
		$album_icon = ereg_replace("[^a-z0-9._]", "", ereg_replace("[^a-z0-9._]", "", ereg_replace (" ", "_", ereg_replace("%20", "_", strtolower($orig_name)))));	

		$file = "";
		if (move_uploaded_file($_FILES['GalleryAlbumIcon']['tmp_name'], $uploadPath.$album_icon)) {
			$albumIcon = $imagePath.$album_icon;
			create_thumbnail($tempPath.$album_icon,$albumIcon,100,"w");
			unlink($tempPath.$file_name);
		}

		if (eregi(".bmp",strtolower($albumIcon))) {
			$albumIcon = eregi_replace(".bmp",".bmp.png",strtolower($albumIcon));
		}
		if ($albumIcon != "" && $_ID != "" && $_ID != "-1" && $_ID != "0") {
			$obj2 = new GalleryAlbum();
			$obj2->setGalleryAlbumId($_ID);
			$ls_temp = $obj2->selectRowById();
			$icon_prev = $ls_temp->fields($obj2->GalleryAlbumIcon);
			if ($icon_prev != $albumIcon) {
				unlink($icon_prev);
			}
		}
	}
}
$obj->clearFieldValue();
$obj->setGalleryAlbumTitle($GalleryAlbumTitle);
$obj->setGalleryAlbumDesc($GalleryAlbumDesc);
$obj->setGalleryAlbumDate(date("Y-m-d"));
if ($albumIcon != "") {
	$obj->setGalleryAlbumIcon($albumIcon);
}	
$obj->setIsActive("Active");

switch($frType) {
	case "0":
		$obj->setOwner($uid);
		$obj->insertRow();

		$GalleryAlbumId = $obj->getLastInsertedId();
		
		$fileObj = new GalleryFile();
		
		if ($zip_upload) {
			$size = sizeof($fileName);
			for ($i=0;$i<$size;$i++) {
				$fileObj->clearFieldValue();
				$fileObj->setGalleryAlbumId($GalleryAlbumId);
				$fileObj->setPhotoTitle($PhotoTitle);
				$fileObj->setPhotoDesc($PhotoDesc);
				$fileObj->setFileName($fileName[$i]);
				$fileObj->setThumbFile($thumbName[$i]);
				$fileObj->setKeywords($Keywords);
				$fileObj->insertRow();
			}
		}
		else {
			$fileObj->clearFieldValue();
			$fileObj->setGalleryAlbumId($GalleryAlbumId);
			$fileObj->setPhotoTitle($PhotoTitle);
			$fileObj->setPhotoDesc($PhotoDesc);
			$fileObj->setFileName($fileName);
			$fileObj->setThumbFile($thumbName);
			$fileObj->setKeywords($Keywords);
			$fileObj->insertRow();
		}
		$Owner = $uid;
	break;
	case "1":
		$usr = new UserAccess();
		$priv1 = $usr->getAccess($_SESSION["uid"],$_ID);

		$grp = new GroupAccess();
		$priv2 = $grp->getAccess($_SESSION["gid"],$_ID);

		$obj->setOwner($Owner);
		$obj->updateRow($_ID);

		$GalleryAlbumId = $_ID;
		if ($zip_upload) {
			$PHOTO_ID = "";
		}

		$insert_new = false;
		if ($PHOTO_ID == "") {
			$insert_new = true;
			if ($zip_upload) {
				if (sizeof($fileName) > 0) {
					$error_insert = false;
					if ($priv1["INSERT"] || $priv2["INSERT"] || $Owner == $uid  || array_key_exists("1",$_SESSION["gid"])) {
						$fileObj = new GalleryFile();
						$size = sizeof($fileName);
						for ($i=0;$i<$size;$i++) {
							$fileObj->clearFieldValue();
							$fileObj->setGalleryAlbumId($GalleryAlbumId);
							$fileObj->setPhotoTitle($PhotoTitle);
							$fileObj->setPhotoDesc($PhotoDesc);
							$fileObj->setFileName($fileName[$i]);
							$fileObj->setThumbFile($thumbName[$i]);
							$fileObj->setKeywords($Keywords);
							$fileObj->insertRow();
						}
					}
					else {
						for ($i=0;$i<sizeof($fileName);$i++) {
							if ($fileName[$i] != "" && file_exists($fileName[$i])) {
								unlink($fileName[$i]);
								unlink($thumbName[$i]);
								if (eregi(".bmp.png",$thumbName[$i])) {
									unlink(eregi_replace("Thumbnail/","Original/",eregi_replace(".bmp.png",".bmp",$thumbName[$i])));
								}
								else {
									unlink(eregi_replace("Thumbnail/","Original/",$thumbName[$i]));
								}
							}
						}
						$error_insert = true;
					}
				}
			}
			else {
				if ($fileName != "") {
					$error_insert = false;
					if ($priv1["INSERT"] || $priv2["INSERT"] || $Owner == $uid  || array_key_exists("1",$_SESSION["gid"])) {
						$fileObj = new GalleryFile();
						$fileObj->setGalleryAlbumId($GalleryAlbumId);
						$fileObj->setPhotoTitle($PhotoTitle);
						$fileObj->setPhotoDesc($PhotoDesc);
						$fileObj->setFileName($fileName);
						$fileObj->setThumbFile($thumbName);
						$fileObj->setKeywords($Keywords);
						$fileObj->insertRow();
					}
					else {
						if ($fileName != "" && file_exists($fileName)) {
							unlink($fileName);
							unlink($thumbName);
							if (eregi(".bmp.png",$thumbName)) {
								unlink(eregi_replace("Thumbnail/","Original/",eregi_replace(".bmp.png",".bmp",$thumbName)));
							}
							else {
								unlink(eregi_replace("Thumbnail/","Original/",$thumbName));
							}
						}
						$error_insert = true;
					}
				}
			}
		}
		else {
			$error_edit = false;
			if ($priv1["EDIT"] || $priv2["EDIT"] || $Owner == $uid || array_key_exists("1",$_SESSION["gid"])) {
				$fileObj = new GalleryFile();
				$fileObj->setGalleryAlbumId($GalleryAlbumId);
				$fileObj->setPhotoTitle($PhotoTitle);
				$fileObj->setPhotoDesc($PhotoDesc);
				$fileObj->setFileName($fileName);
				$fileObj->setThumbFile($thumbName);
				$fileObj->setKeywords($Keywords);
				$fileObj->updateRow($PHOTO_ID);
			}
			else {
				if ($fileName != "" && file_exists($fileName)) {
					unlink($fileName);
					unlink($thumbName);
					if (eregi(".bmp.png",$thumbName)) {
						unlink(eregi_replace("Thumbnail/","Original/",eregi_replace(".bmp.png",".bmp",$thumbName)));
					}
					else {
						unlink(eregi_replace("Thumbnail/","Original/",$thumbName));
					}
				}
				$error_edit = true;
			}
		}
	break;
	case "2":
		$params=$_POST["params"];
		$src1=$_GET["src1"];
		$obj2 = new GalleryFile();
		if (sizeof($params) >= 1) {
			while (list($key,$val)=each($params)) {
				$obj->clearFieldValue();
				$obj->setGalleryAlbumId($val);	
				$ls = $obj->selectRowById();	
				$owner = $ls->fields($obj->Owner);
				$title = $ls->fields($obj->GalleryAlbumTitle);
				if ($owner == $uid || array_key_exists("1",$_SESSION["gid"])) {
					$obj2->clearFieldValue();
					$obj2->setGalleryAlbumId($val);
					$ls2 = $obj2->selectRowByCriteria();
					while (!$ls2->EOF) {
						$file = $ls2->fields($obj2->FileName);
						$thumb = $ls2->fields($obj2->ThumbFile);
						if (eregi(".bmp.png",$thumb)) {
							$original = eregi_replace("Thumbnail/","Original/",eregi_replace('.bmp.png','.bmp',$thumb));
						}
						else {
							$original = eregi_replace("Thumbnail/","Original/",$thumb);
						}

						unlink($file);
						unlink($thumb);
						unlink($original);
						$ls2->MoveNext();
					}

					$obj->clearFieldValue();
					$obj->setGalleryAlbumId($val);	
					$ls = $obj->selectRowById();	
					$icon = $ls->fields($obj->GalleryAlbumIcon);
					unlink($icon);
					

					$obj->clearFieldValue();
					$obj->setGalleryAlbumId($val);		
					$obj->deleteRow();
				}
				else {
					$alert[] = $title;
				}
			}
			if (sizeof($alert) > 0) {
?>
				<script type="text/javascript" src="js/js_lib.js"></script>
				<script type="text/javascript" src="js/internal_request.js"></script>
				<div id="MyPopup1" style="font-family:Arial;margin:15px;width:500px;border:#FFFFFF 2px solid; background-color:#525252;display:none;color:#FFFFFF;font-size:16px;font-weight:bold;text-align:center;">
							&nbsp;<br />
							<img src="images/dialog-error.png" align="absmiddle" />&nbsp;You don't have enough privileges to delete <? if (sizeof($alert) > 1) { ?> the following albums<? } else { ?> this album<? } ?> !!
							<? if (sizeof($alert) > 1) {
								$size = sizeof($alert);
								for ($i=0;$i<$size;$i++) {
							?>
									<li><?=$alert[$i];?></li>
							<?
								}
							}
							?>
							<br />&nbsp;<br />
							<span style="font-family:Arial;text-decoration:underline;font-size:11px;color:#CCFFFF;cursor:pointer;" onclick="ModalPopup.Close('MyPopup1');location.href='index.php?mod=Master&act=lsGal&src1=<?=$src1;?>';">Close</span>
							&nbsp;
							</div>
				<script>ModalPopup("MyPopup1");</script>
<?
				exit;
			}
		}
	break;
	case "3":
		$params=$_POST["params"];
		$src1=$_GET["src1"];
		if (sizeof($params) >= 1) {
			while (list($key,$val)=each($params)) {
				$obj->clearFieldValue();
				$obj->setGalleryAlbumId($val);	
				$ls = $obj->selectRowById();	
				$owner = $ls->fields($obj->Owner);
				$title = $ls->fields($obj->GalleryAlbumTitle);
				if ($owner == $uid || array_key_exists("1",$_SESSION["gid"])) {
					$obj->clearFieldValue();
					$obj->setGalleryAlbumId($val);		
					$obj->setIsActive('Active');
					$obj->updateRow($val);
				}
				else {
					$alert[] = $title;
				}
			}
			if (sizeof($alert) > 0) {
?>
				<script type="text/javascript" src="js/js_lib.js"></script>
				<script type="text/javascript" src="js/internal_request.js"></script>
				<div id="MyPopup1" style="font-family:Arial;margin:15px;width:500px;border:#FFFFFF 2px solid; background-color:#525252;display:none;color:#FFFFFF;font-size:16px;font-weight:bold;text-align:center;">
							&nbsp;<br />
							<img src="images/dialog-error.png" align="absmiddle" />&nbsp;You don't have enough privileges to activate <? if (sizeof($alert) > 1) { ?> the following albums<? } else { ?> this album<? } ?> !!
							<? if (sizeof($alert) > 1) {
								$size = sizeof($alert);
								for ($i=0;$i<$size;$i++) {
							?>
									<li><?=$alert[$i];?></li>
							<?
								}
							}
							?>
							<br />&nbsp;<br />
							<span style="font-family:Arial;text-decoration:underline;font-size:11px;color:#CCFFFF;cursor:pointer;" onclick="ModalPopup.Close('MyPopup1');location.href='index.php?mod=Master&act=lsGal&src1=<?=$src1;?>';">Close</span>
							&nbsp;
							</div>
				<script>ModalPopup("MyPopup1");</script>
<?
				exit;
			}
		}
	break;
	case "4":
		$params=$_POST["params"];
		$src1=$_GET["src1"];
		if (sizeof($params) >= 1) {
			while (list($key,$val)=each($params)) {
				$obj->clearFieldValue();
				$obj->setGalleryAlbumId($val);	
				$ls = $obj->selectRowById();	
				$owner = $ls->fields($obj->Owner);
				$title = $ls->fields($obj->GalleryAlbumTitle);
				if ($owner == $uid || array_key_exists("1",$_SESSION["gid"])) {
					$obj->clearFieldValue();
					$obj->setGalleryAlbumId($val);		
					$obj->setIsActive('null');
					$obj->updateRow($val);
				}
				else {
					$alert[] = $title;
				}
			}
			if (sizeof($alert) > 0) {
?>
				<script type="text/javascript" src="js/js_lib.js"></script>
				<script type="text/javascript" src="js/internal_request.js"></script>
				<div id="MyPopup1" style="font-family:Arial;margin:15px;width:500px;border:#FFFFFF 2px solid; background-color:#525252;display:none;color:#FFFFFF;font-size:16px;font-weight:bold;text-align:center;">
							&nbsp;<br />
							<img src="images/dialog-error.png" align="absmiddle" />&nbsp;You don't have enough privileges to deactivate <? if (sizeof($alert) > 1) { ?> the following albums<? } else { ?> this album<? } ?> !!
							<? if (sizeof($alert) > 1) {
								$size = sizeof($alert);
								for ($i=0;$i<$size;$i++) {
							?>
									<li><?=$alert[$i];?></li>
							<?
								}
							}
							?>
							<br />&nbsp;<br />
							<span style="font-family:Arial;text-decoration:underline;font-size:11px;color:#CCFFFF;cursor:pointer;" onclick="ModalPopup.Close('MyPopup1');location.href='index.php?mod=Master&act=lsGal&src1=<?=$src1;?>';">Close</span>
							&nbsp;
							</div>
				<script>ModalPopup("MyPopup1");</script>
<?
				exit;
			}
		}
	break;
}
if ($frType == "1" || $frType == "0") {
?>
<script type="text/javascript" src="js/internal_request.js"></script>
<script>parent.document.getElementById("_ID").value="<?=$GalleryAlbumId;?>";</script>
<script>parent.document.getElementById("PHOTO_ID").value="";</script>
<script>parent.document.getElementById("PHOTO_SHOW").value="<?=$PHOTO_SHOW;?>";</script>
<script>parent.document.getElementById("PhotoTitle").value="";</script>
<script>parent.document.getElementById("PhotoDesc").value="";</script>
<script>parent.document.getElementById("GalleryFile").value="";</script>
<script>parent.document.getElementById("Keywords").value="";</script>
<script>parent.document.getElementById("GalleryAlbumIcon").value="";</script>
<script>parent.document.getElementById("Owner").value="<?=$Owner;?>";</script>
<? if (!$insert_new) { ?>
<script>getRequestParent(null,'index.php?mod=Master&act=viewThumbnail2&ref=17&gal=<?=$GalleryAlbumId;?>&show=<?=$PHOTO_SHOW;?>&do=9','gallery_area');</script>
<? } else { 
	$fileObj = new GalleryFile();
	$list = $fileObj->getFile($GalleryAlbumId,12,$show);
	$last_page = $fileObj->getLastPageNumber();
?>
<script>getRequestParent(null,'index.php?mod=Master&act=viewThumbnail2&ref=17&gal=<?=$GalleryAlbumId;?>&show=<?=$last_page;?>&do=9','gallery_area');</script>
<? } ?>
<script>parent.GlobalModalPopup.Close("PopUpload");</script>
<? if ($error_insert) { ?>
		<script>
		parent.GlobalModalPopup("PopUpInsert");</script>
<? } ?> 
<? if ($error_edit) { ?>
		<script>
		parent.GlobalModalPopup("PopUpEdit");
	</script>
<? } ?> 

<? } else { ?>
<script>location.href='index.php?mod=Master&act=lsGal&src1=<?=$src1;?>';</script>
<? }?>