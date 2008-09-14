<?
$ref = $_GET["ref"];
$obj = new GalleryAlbum();
$obj->updateViewed($ref);
?>
getRequest(null,'index.php?mod=Public&act=viewGallery&gal=<?=$ref;?>&do=9','main_area');