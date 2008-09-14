<?
$usr_id = $_GET["usr_id"];
$gal_id = $_GET["gal_id"];
$priv_id = $_GET["priv_id"];

$usr = new UserAccess();

$usr->clearFieldValue();
$usr->setGalleryAlbumId($gal_id);
$usr->setVmtUserId($usr_id);
$usr->setAccessRefId($priv_id);
$ls = $usr->selectRowByCriteria();


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
	$usr->clearFieldValue();
	$usr->setGalleryAlbumId($gal_id);
	$usr->setVmtUserId($usr_id);
	$usr->setAccessRefId($priv_id);
	$usr->deleteRowByCriteria();
?>
document.getElementById("<?=$div;?>_usr_<?=$usr_id;?>_<?=$gal_id;?>").innerHTML = "&nbsp;";
<?
}
else {
	$usr->clearFieldValue();
	$usr->setGalleryAlbumId($gal_id);
	$usr->setVmtUserId($usr_id);
	$usr->setAccessRefId($priv_id);
	$usr->insertRow();
?>
document.getElementById("<?=$div;?>_usr_<?=$usr_id;?>_<?=$gal_id;?>").innerHTML = '<img src="images/check.png" />';
<?
}
?>