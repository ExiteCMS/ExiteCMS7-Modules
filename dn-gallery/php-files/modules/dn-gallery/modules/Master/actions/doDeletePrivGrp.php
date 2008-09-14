<?
$grp_id = $_GET["grp_id"];
$gal_id = $_GET["gal_id"];

$grp = new GroupAccess();

$grp->clearFieldValue();
$grp->setGalleryAlbumId($gal_id);
$grp->setVmtGroupId($grp_id);
$grp->deleteRowByCriteria();
?>
document.getElementById("priv_grp_<?=$grp_id;?>_<?=$gal_id;?>").innerHTML = "&nbsp;";