<?
$type = $_GET["type"];
$Src1 = $_GET["Src1"];

$obj = new GalleryAlbum();
$obj->AjaxPager(true);
$limit = 24;

switch($type) {
	case "featured":
		$ls_obj = $obj->getContent($limit,$show);
	break;
	case "most_viewed":
		$ls_obj = $obj->getMostViewed($limit,$show);
	break;
	default:
		$ls_obj = $obj->getRandom($limit,$show);
	break;
}

?>