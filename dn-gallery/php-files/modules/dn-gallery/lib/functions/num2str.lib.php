<?php

//$num=151214020015;
function getSatuan($num,&$out,$num2,$tempOld) {
	$num = intval($num);
	$len = strlen($num);
	switch($len) {
		case 3:
			$bagi = 100;
			$temp = " ratus";
			if (substr($num,0,1) == 1) {
				$temp = " seratus";
			}
		break;
		case 2:
			$bagi = 10;
			$temp = " puluh";
			if (substr($num,0,1) == 1) {
				$temp = " sepuluh";
				$isSkip = true;
			}
			if (substr($num,0,1) == 1 && substr($num,1,1) == 0) {
				$temp = " sepuluh";
				$isSkip = true;
			}
			else if (substr($num,0,1) == 1 && substr($num,1,1) == 1) {
				$temp = " sebelas";
				$isSkip = true;
			}
			else if (substr($num,0,1) == 1 && substr($num,1,1) == 2) {
				$temp = " dua belas";
				$isSkip = true;
			}
			else if (substr($num,0,1) == 1 && substr($num,1,1) == 3) {
				$temp = " tiga belas";
				$isSkip = true;
			}
			else if (substr($num,0,1) == 1 && substr($num,1,1) == 4) {
				$temp = " empat belas";
				$isSkip = true;
			}
			else if (substr($num,0,1) == 1 && substr($num,1,1) == 5) {
				$temp = " lima belas";
				$isSkip = true;
			}
			else if (substr($num,0,1) == 1 && substr($num,1,1) == 6) {
				$temp = " enam belas";
				$isSkip = true;
			}
			else if (substr($num,0,1) == 1 && substr($num,1,1) == 7) {
				$temp = " tujuh belas";
				$isSkip = true;
			}
			else if (substr($num,0,1) == 1 && substr($num,1,1) == 8) {
				$temp = " delapan belas";
				$isSkip = true;
			}
			else if (substr($num,0,1) == 1 && substr($num,1,1) == 9) {
				$temp = " sembilan belas";
				$isSkip = true;
			}
		break;
		case 1:
			$bagi = 1;
			$temp = "";
		break;
	}
	$tempNum = floor($num/$bagi);
	if ($tempNum != 0) {
		if ((substr($num,0,1) == 1) && ($bagi > 1)) {
			$out .= $temp; 
		}
		else {
			if ($tempNum != "") {
				$out .= getSpell($tempNum,$num2,$tempOld).$temp; 
			}
		}
	}
	if ($len > 1) {
		$tempNum = $num % $bagi;
		getSatuan($tempNum,$out,$num,$temp);
	}
}

function getResult($num,&$out) {
	$num = intval($num);
	$origNum = $num;
	if (strlen($num) - 3 > 0) {
		$temp = substr($num,strlen($num) - 3,3);
		$out = "";
		getSatuan($temp,$out);
		$sebut[] = $out;
		$num = substr($num,0,strlen($num) - 3);
	}
	if (strlen($num) - 3 > 0) {
		$temp = substr($num,strlen($num) - 3,3);
		$out = "";
		getSatuan($temp,$out);
		$sebut[] = $out;
		$num = substr($num,0,strlen($num) - 3);
	}
	if (strlen($num) - 3 > 0) {
		$temp = substr($num,strlen($num) - 3,3);
		$out = "";
		getSatuan($temp,$out);
		$sebut[] = $out;
		$num = substr($num,0,strlen($num) - 3);
	}
	if (strlen($num) - 3 > 0) {
		$temp = substr($num,strlen($num) - 3,3);
		$out = "";
		getSatuan($temp,$out);
		$sebut[] = $out;
		$num = substr($num,0,strlen($num) - 3);
	}
	if (strlen($num) - 3 <= 0) {
		$temp = substr($num,0,3);
		$out = "";
		getSatuan($temp,$out);
		$sebut[] = $out;
		$num = substr($num,0,strlen($num) - 3);
	}
	
	$arrSatuan[3] = " milyar";
	$arrSatuan[2] = " juta";
	$arrSatuan[1] = " ribu";
	$arrSatuan[0] = " ";
	$strOutput = "";
	for ($i=sizeof($sebut)-1;$i>=0;$i--) {
		if ($sebut[$i]!="") {
			$strOutput .= $sebut[$i].$arrSatuan[$i]." ";
		}
	}
	return $strOutput;
}

function getSpell($num,$num2,$temp2) {
	$num = intval($num);
	$num2 = intval($num2);
	if (substr($num2,0,1) != 1 || !eregi("belas",$temp2)) {
		switch($num) {
			case 1:
				$temp = " satu";
			break;
			case 2:
				$temp = " dua";
			break;
			case 3:
				$temp = " tiga";
			break;
			case 4:
				$temp = " empat";
			break;
			case 5:
				$temp = " lima";
			break;
			case 6:
				$temp = " enam";
			break;
			case 7:
				$temp = " tujuh";
			break;
			case 8:
				$temp = " delapan";
			break;
			case 9:
				$temp = " sembilan";
			break;
		}
	}
	return $temp;
}
//$out = "";
//echo getResult($num,$out,$num,"");
?>