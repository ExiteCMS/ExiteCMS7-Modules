<?php
$src1 = $http->getVar("src1");

$obj =& new GalleryAlbum();
$obj->setGalleryAlbumId($_ID);
$list =& $obj->selectRowById();

$form = new Form();
if ($isSubmitted == 0) {
	$form->generateValues($list,0,$obj);
}
else {
	$form->generateValues($_POST,1,$obj);
	$errorPanel->setErrorVar($form->fields["errorVar"]);
}

$usr = new VmtUser();
$uid = $usr->getIdByLogin($_SESSION["uid"]);

$usr = new UserAccess();
$priv1 = $usr->getAccess($_SESSION["uid"],$_ID);

$grp = new GroupAccess();
$priv2 = $grp->getAccess($_SESSION["gid"],$_ID);

?>
