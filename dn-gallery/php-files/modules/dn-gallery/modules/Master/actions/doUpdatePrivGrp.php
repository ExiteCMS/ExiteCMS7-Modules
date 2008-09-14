<?
$grp_id = $_GET["grp_id"];
$gal_id = $_GET["gal_id"];
$priv_id = $_GET["priv_id"];

$grp = new GroupAccess();

$grp->clearFieldValue();
$grp->setGalleryAlbumId($gal_id);
$grp->setVmtGroupId($grp_id);
$grp->setAccessRefId($priv_id);
$ls = $grp->selectRowByCriteria();


switch($priv_id) {
	case 1:
		$div = "insert";
	break;
	case 2:
		$div = "edit";
	break;
	case 3:
		$div = "delete";
	break;
	case 4:
		$div = "read_only";
	break;
}

if ($ls->RecordCount() > 0) {
	$grp->clearFieldValue();
	$grp->setGalleryAlbumId($gal_id);
	$grp->setVmtGroupId($grp_id);
	$grp->setAccessRefId($priv_id);
	$grp->deleteRowByCriteria();
?>
document.getElementById("<?=$div;?>_grp_<?=$grp_id;?>_<?=$gal_id;?>").innerHTML = "&nbsp;";
<?
}
else {
	$grp->clearFieldValue();
	$grp->setGalleryAlbumId($gal_id);
	$grp->setVmtGroupId($grp_id);
	$grp->setAccessRefId($priv_id);
	$grp->insertRow();
?>
document.getElementById("<?=$div;?>_grp_<?=$grp_id;?>_<?=$gal_id;?>").innerHTML = '<img src="images/check.png" />';
<?
}
?>