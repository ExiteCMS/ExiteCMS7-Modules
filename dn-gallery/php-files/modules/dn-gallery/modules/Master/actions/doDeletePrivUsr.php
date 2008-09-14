<?
$usr_id = $_GET["usr_id"];
$gal_id = $_GET["gal_id"];

$usr = new UserAccess();

$usr->clearFieldValue();
$usr->setGalleryAlbumId($gal_id);
$usr->setVmtUserId($usr_id);
$usr->deleteRowByCriteria();
?>
document.getElementById("priv_usr_<?=$usr_id;?>_<?=$gal_id;?>").innerHTML = "&nbsp;";