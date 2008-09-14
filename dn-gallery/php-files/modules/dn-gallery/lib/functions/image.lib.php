<?
function resize_image($image, $defaultSize = 100, $defaultParam = "w")
{
	$size =getimagesize($image);
	
	$width = $size[0];
	$height = $size[1];
	
	if ($defaultParam == "w") {
		if ($width > $defaultSize) {
			$w = $defaultSize;
			$h = ($height / $width) * $defaultSize;
		
			$width = $w;
			$height = $h;
		}
	}
	elseif ($defaultParam == "h") {
		if ($height > $defaultSize) {
			$w = ($width / $height) * $defaultSize;
			$h = $defaultSize;
		
			$width = $w;
			$height = $h;
		}
	}

	$newSize = array($width,$height);

	return $newSize;
}



function create_thumbnail($image, $thumb,$defaultSize = 100, $defaultParam = "w",$width,$height) {
	if (file_exists($image)) { 
		if ($defaultParam != "{w,h}") {
			$newSize = resize_image($image,$defaultSize,$defaultParam);
		}
		else {
			$newSize = array($width,$height);
		}

		list($width, $height) = getimagesize($image);

		$newwidth = $newSize[0];
		$newheight = $newSize[1];

		$image_p = imagecreatetruecolor($newwidth, $newheight);
		if (eregi(".jpg",strtolower($image)) || eregi(".jpeg",strtolower($image))) {
			$img = imagecreatefromjpeg($image);
			imagecopyresampled($image_p, $img, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

			// Output
			imagejpeg($image_p, $thumb);
		}
		elseif (eregi(".png",strtolower($image))) {
			$img = imagecreatefrompng($image);
			imagecopyresampled($image_p, $img, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

			// Output
			imagepng($image_p, $thumb);
		}
		elseif (eregi(".gif",strtolower($image))) {
			$img = imagecreatefromgif($image);
			imagecopyresampled($image_p, $img, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

			// Output
			imagegif($image_p, $thumb);
		}
		elseif (eregi(".bmp",strtolower($image))) {
			$bmp = new phpthumb_bmp();
			$bmp2gd = $bmp->phpthumb_bmpfile2gd($image,true);
			imagecopyresampled($image_p, $bmp2gd, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

			imagepng($image_p,$thumb.".png");
		}
	}
}
?>