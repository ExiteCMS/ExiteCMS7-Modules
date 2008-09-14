<?
class Captcha {
 
	var $font = 'images/fonts/arial.ttf';
 
	function Captcha($width='150',$height='48',$characters='6',$create_file = false) {
		$code = $this->generateCode($characters);

		/* font size will be 50% of the image height */
		$font_size = $height * 0.5;

		$image = @imagecreate($width, $height) or die('Cannot initialize new GD image stream');

		/* set the colours */
		$background_color = imagecolorallocate($image, 255, 255, 255);
		$text_color = imagecolorallocate($image, 67, 98, 104);
		$noise_color_dots = imagecolorallocate($image, 100, 120, 180);
		$noise_color_lines[] = imagecolorallocate($image, 255, 255, 64);
		$noise_color_lines[] = imagecolorallocate($image, 219, 46, 36);
		$noise_color_lines[] = imagecolorallocate($image, 100, 120, 180);
		$noise_color_lines[] = imagecolorallocate($image, 98, 98, 255);

		/* generate random dots in background */
		for( $i=0; $i<($width*$height)/3; $i++ ) {
			imagefilledellipse($image, mt_rand(0,$width), mt_rand(0,$height), 1, 1, $noise_color_dots);
		}

		/* generate random lines in background */
		for( $i=0; $i<($width*$height)/150; $i++ ) {
			$color_num = intval(mt_rand(0,4));
			imageline($image, mt_rand(0,$width), mt_rand(0,$height), mt_rand(0,$width), mt_rand(0,$height), $noise_color_lines[$color_num]);
		}

		/* create textbox and add text */
		$textbox = imagettfbbox($font_size, 0, $this->font, $code) or die('Error in imagettfbbox function');
		$x = ($width - $textbox[4])/2;
		$y = ($height - $textbox[5])/2;
		
		$deg = intval(mt_rand(-5,5));
		imagettftext($image, $font_size, $deg, $x, $y, $text_color, $this->font , $code) or die('Error in imagettftext function');

		/* output captcha image to browser */
		if ($create_file) {
			imagejpeg($image,"var/cache/captcha/".md5($code).".jpeg");
		}
		else {
			header('Content-Type: image/jpeg');
			imagejpeg($image);
			imagedestroy($image);
		}
		$_SESSION['security_code'] = $code;
	}

	function generateCode($characters) {
		/* list all possible characters, similar looking characters and vowels have been removed */
		//$possible = '234789bcdfgHJKMNqrstv56wxyzBCDFGPhjkmnpQRSTVWXYZ';
		$possible = '234789HJKMN56BCDFGPAQRSTVWXYZ';
		$code = '';
		$i = 0;
		while ($i < $characters) { 
			$code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
			$i++;
		}
		return $code;
	}
}
?>