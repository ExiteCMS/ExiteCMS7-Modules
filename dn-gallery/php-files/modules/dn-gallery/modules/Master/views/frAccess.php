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

?>
