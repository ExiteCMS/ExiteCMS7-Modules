<?
$ref = $_GET["ref"];
$show = $_GET["show"];
$fileObj = new GalleryFile();
$fileObj->setId($ref);
$ls = $fileObj->selectRowById();

$file = $ls->fields("file_name");
$thumb = $ls->fields("thumb_file");
$gallery_album_id = $ls->fields("gallery_album_id");

if (eregi(".bmp.png",$thumb)) {
	$original = eregi_replace("Thumbnail/","Original/",eregi_replace(".bmp.png",".bmp",$thumb));
}
else {
	$original = eregi_replace("Thumbnail/","Original/",$thumb);
}

$fileObj->clearFieldValue();
$fileObj->setId($ref);
$fileObj->deleteRow();
unlink($file);
unlink($thumb);
unlink($original);
?>
document.getElementById("PHOTO_ID").value="";
document.getElementById("PhotoTitle").value="";
document.getElementById("PhotoDesc").value="";
document.getElementById("GalleryFile").value="";
document.getElementById("GalleryAlbumIcon").value="";
document.getElementById("Keywords").value="";
getRequest(null,'index.php?mod=Master&act=viewThumbnail2&ref=17&gal=<?=$gallery_album_id;?>&do=9&show=<?=$show;?>','gallery_area');