<?
$_ID = $_POST["_ID"];
$Access = $_POST["Access"];
$users = $_POST["users"];
$groups = $_POST["groups"];
$src1 = $_POST["src1"];

$users = substr($users,0,-1);
$groups = substr($groups,0,-1);

$obj = new GalleryAlbum();

$obj->clearFieldValue();
$obj->setGalleryAlbumId($_ID);
$obj->setAccess($Access);
$obj->updateRow($_ID);

$usr = new VmtUser();
$current_user = $usr->getIdByLogin($_SESSION["uid"]);

switch($Access) {
	case "CUSTOM":
		$grp = new GroupAccess();

		$grp_list = explode(",",$groups);

		while (list($key,$val) = each($grp_list)) {
			$grp->clearFieldValue();
			$grp->setGalleryAlbumId($_ID);
			$grp->setVmtGroupId($val);
			$ls = $grp->selectRowByCriteria();
			if ($ls->RecordCount() <= 0) {
				$grp->clearFieldValue();
				$grp->setGalleryAlbumId($_ID);
				$grp->setVmtGroupId($val);
				$grp->setAccessRefId("4");
				$grp->insertRow();
			}
		}
		$grp->remove($_ID,$groups);

		$usr = new UserAccess();

		$usr_list = explode(",",$users);

		while (list($key,$val) = each($usr_list)) {
			if ($val != $current_user) {
				$usr->clearFieldValue();
				$usr->setGalleryAlbumId($_ID);
				$usr->setVmtUserId($val);
				$ls = $usr->selectRowByCriteria();
				if ($ls->RecordCount() <= 0) {
					$usr->clearFieldValue();
					$usr->setGalleryAlbumId($_ID);
					$usr->setVmtUserId($val);
					$usr->setAccessRefId("4");
					$usr->insertRow();
				}
			}
		}
		$usr->clearFieldValue();
		$usr->setGalleryAlbumId($_ID);
		$usr->setVmtUserId($current_user);
		$usr->deleteRowByCriteria();
		for ($i = 1;$i<=4;$i++) {
			$usr->clearFieldValue();
			$usr->setGalleryAlbumId($_ID);
			$usr->setVmtUserId($current_user);
			$usr->setAccessRefId($i);
			$usr->insertRow();
		}

		$users .= ",".$current_user;
		$usr->remove($_ID,$users);
	break;
	case "PRIVATE":
		$grp = new GroupAccess();
		$grp->setGalleryAlbumId($_ID);
		$grp->deleteRowByCriteria();
		

		$usr = new UserAccess();
		$usr->setGalleryAlbumId($_ID);
		$usr->deleteRowByCriteria();
		

		for ($i = 1;$i<=4;$i++) {
			$usr->clearFieldValue();
			$usr->setGalleryAlbumId($_ID);
			$usr->setVmtUserId($current_user);
			$usr->setAccessRefId($i);
			$usr->insertRow();
		}
	break;
	case "PUBLIC":
		$grp = new GroupAccess();

		$grp_list = explode(",",$groups);

		while (list($key,$val) = each($grp_list)) {
			$grp->clearFieldValue();
			$grp->setGalleryAlbumId($_ID);
			$grp->setVmtGroupId($val);
			$ls = $grp->selectRowByCriteria();
			if ($ls->RecordCount() <= 0) {
				$grp->clearFieldValue();
				$grp->setGalleryAlbumId($_ID);
				$grp->setVmtGroupId($val);
				$grp->setAccessRefId("4");
				$grp->insertRow();
			}
		}
		$grp->remove($_ID,$groups);

		$usr = new UserAccess();

		$usr_list = explode(",",$users);

		while (list($key,$val) = each($usr_list)) {
			if ($val != $current_user) {
				$usr->clearFieldValue();
				$usr->setGalleryAlbumId($_ID);
				$usr->setVmtUserId($val);
				$ls = $usr->selectRowByCriteria();
				if ($ls->RecordCount() <= 0) {
					$usr->clearFieldValue();
					$usr->setGalleryAlbumId($_ID);
					$usr->setVmtUserId($val);
					$usr->setAccessRefId("4");
					$usr->insertRow();
				}
			}
		}
		$usr->clearFieldValue();
		$usr->setGalleryAlbumId($_ID);
		$usr->setVmtUserId($current_user);
		$usr->deleteRowByCriteria();
		for ($i = 1;$i<=4;$i++) {
			$usr->clearFieldValue();
			$usr->setGalleryAlbumId($_ID);
			$usr->setVmtUserId($current_user);
			$usr->setAccessRefId($i);
			$usr->insertRow();
		}

		$users .= ",".$current_user;
		$usr->remove($_ID,$users);
	break;
}
?>
<script>location.href='index.php?mod=Master&act=lsAccess&src1=<?=$src1;?>';</script>