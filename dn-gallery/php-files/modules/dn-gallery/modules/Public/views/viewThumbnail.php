<?

	$gal = $_GET["gal"];
	$type = $_GET["type"];
	$Src1 = $_GET["Src1"];
	$o = new GalleryAlbum();
	$limit = 24;

	switch($type) {
		case "src":
			$obj = new GalleryFile();
			$obj2 = new GalleryFile();
			$obj->AjaxPager(true);
			$list = $obj->searchFile($Src1,$limit,$show);
		break;
		default:
			$AlbumTitle = $o->getCaption($gal);
			if ($gal == "") {
				$kat = new GalleryAlbum();
				$ls_kat = $kat->getContent();
				$gal = $ls_kat->fields($kat->GalleryAlbumId);
			}
			if ($gal == "") {
				$gal = $ref;
			}
			$obj = new GalleryFile();
			$obj->AjaxPager(true);
			$list = $obj->getFile($gal,$limit,$show);
		break;
	}
?>