<?
$_ID = $_GET["gal"];

$usr = new VmtUser();
$uid = $usr->getIdByLogin($_SESSION["uid"]);

$usr = new UserAccess();
$priv1 = $usr->getAccess($_SESSION["uid"],$_ID);

$grp = new GroupAccess();
$priv2 = $grp->getAccess($_SESSION["gid"],$_ID);

$obj =& new GalleryAlbum();
$obj->setGalleryAlbumId($_ID);
$list =& $obj->selectRowById();

$Owner = $list->fields($obj->Owner);
?>