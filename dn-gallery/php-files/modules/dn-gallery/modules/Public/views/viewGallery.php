<?

$gal = $_GET["gal"];
$o = new GalleryAlbum();
$AlbumTitle = $o->getCaption($gal);
if ($gal == "") {
	$kat = new GalleryAlbum();
	$ls_kat = $kat->getContent();
	$gal = $ls_kat->fields($kat->GalleryAlbumId);
}
if ($gal == "") {
	$gal = $ref;
}
$obj = new GalleryFile();
$obj->AjaxPager(true);
$list = $obj->getFile($gal,1,$show);
$image_1 = $list->fields($obj->FileName);
$content_id = $list->fields($obj->GalleryAlbumId);
$photo_id = $list->fields($obj->Id);
$photo_title = $list->fields($obj->PhotoTitle);
$photo_desc = $list->fields($obj->PhotoDesc);
$photo_keyword = $list->fields($obj->Keywords);

if ($image_1 != "") {
	$size = resize_image($image_1,540,"w");
}
else {
	$image_1 = "images/spacer.gif";
	$size[0] = 488;
	$size[1] = 200;
}

$com = new Comments();
$com->setGalleryFileId($photo_id);
$ls_com = $com->selectRowByCriteria();

$obj2 = new GalleryFile();
$obj3 = new GalleryFile();
$usr = new VmtUser();

$limit2 = 15;
$list2 = $obj2->getRelated($photo_keyword,$photo_id,$limit2,1);
$i = 1;
$total_row = $list2->RecordCount();
?>