<?
$ref = $_GET["ref"];
$com = new Comments();
$com->setGalleryFileId($ref);
$ls_com = $com->selectRowByCriteria();

$usr = new VmtUser();
?>