<?
$ref = $_GET["ref"];
$strPassword = $ref;


function doesContain($strPassword, $strCheck) {
    $nCount = 0; 
	$len = strlen($strPassword);

	for ($i = 0; $i < $len; $i++) 
	{
		if ($strPassword[$i] != "") {
			if (strpos($strCheck,$strPassword[$i]) > -1) 
			{ 
					$nCount++; 
			} 
		}
	} 
 
	return $nCount; 
}

function doesRepeat($strPassword) {
	$strPassword = strtolower($strPassword);
	$len = strlen($strPassword);
	
	for ($i = 0; $i < $len; $i++) 
	{	
		if (intval($count[$strPassword[$i]]) == 0 && substr_count($strPassword,$strPassword[$i]) > 1) {
			$count[$strPassword[$i]] = substr_count($strPassword,$strPassword[$i]);
		}
	}

	$size = sizeof($count);
    $nCount = 0; 
	while (list($key,$val) = each($count)) {
		if (intval($val) > 0) {
			$nCount++;
		}
	}
	//kosonginaja
	return $nCount;
}

function doesSequential($strPassword) {
	$strPassword = strtolower($strPassword);
	$len = strlen($strPassword);
	
	for ($i = 0; $i < $len; $i++) 
	{	
		for ($j = $i + 1 ; $j < $len; $j++) {
			if ($strPassword[$i] == $strPassword[$j] && $i == ($j-1)) {
				$count[$strPassword[$i]]++;
			}
		}
	}
	
	$size = sizeof($count);
    $nCount = 0; 
	while (list($key,$val) = each($count)) {
		if (intval($val) > 0) {
			$nCount += $val + 1;
		}
	}
	return $nCount;
}


function checkPassword($strPassword) {
	$nComb = 0;
	

	$strCheck = "012389";
	if (doesContain($strPassword, $strCheck) > 0) 
	{ 
		$nComb += strlen($strCheck) / 3; 
	}
	else {
		$nComb -= strlen($strCheck) / 3;
	}

	$strCheck = "4567";
	if (doesContain($strPassword, $strCheck) > 0) 
	{ 
		$nComb += strlen($strCheck); 
	}
	else {
		$nComb -= strlen($strCheck);
	}
	
	$letters = true;
	$strCheck = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	if (doesContain($strPassword, $strCheck) > 0) 
	{ 
		$nComb += strlen($strPassword); 
		$letters = true;
	}
	else {
		$letters = false;
	}

	$strCheck = "abcdefghijklmnopqrstuvwxyz";
	if (doesContain($strPassword, $strCheck) > 0) 
	{ 
		$nComb += strlen($strPassword); 
		$letters = true;
	}
	else {
		$letters = false;
	}
	
	if (!$letters) {
		$nComb -= strlen($strPassword);
	}

	$strCheck = ";:-_=+\|//?^&!.@$£#*()%~<>{}[]";
	if (doesContain($strPassword, $strCheck) > 0) 
	{ 
		$nComb += strlen($strCheck); 
	}
	
	$nRepeat = doesRepeat($strPassword);
	if ($nRepeat > 0) {
		$nComb = $nComb - ($nRepeat * ($nRepeat - 1));
	}
	
	$nSequential = doesSequential($strPassword);
	if ($nSequential > 0) {
		$nComb = $nComb - ($nSequential * ($nSequential - 1));
	}

	// Calculate
	// -- 500 tries per second => minutes 
	$nDays = ((pow($nComb, strlen($strPassword)) / 500) / 2) / 86400;
	$nPasswordLifetime = 365;

	// Number of days out of password lifetime setting
	$nPerc = $nDays / $nPasswordLifetime;
	
	return $nPerc;
}

function runPassword($strPassword) {
	$nPerc = checkPassword($strPassword);
	$nRound = round($nPerc * 100);

	if ($nRound < (strlen($strPassword) * 5)) 
	{ 
		$nRound += strlen($strPassword) * 5; 
	}
	elseif ($nRound < 0) {
		$nRound = strlen($strPassword) * 5; 
	}

	if ($nRound > 100) {
		$nRound = 100;
	}

	if ($nRound > 95)
 	{
 		$strText = "Very Strong";
 		$strColor = "#008A00";
	}
	elseif ($nRound > 75)
 	{
 		$strText = "Strong";
 		$strColor = "orange";
	}
 	elseif ($nRound > 50)
 	{
 		$strText = "Fair";
 		$strColor = "#C17B11";
 	}
 	else
 	{
 		$strText = "Weak";
 		$strColor = "#BF0000";
 	}
	
	return array("score" => $nRound, "text" => $strText, "color" => $strColor);
}

$passCheck = runPassword($strPassword);
?>
document.getElementById("PassBar").style.width = "<?=$passCheck["score"];?>%";
document.getElementById("PassBar").style.backgroundColor = "<?=$passCheck["color"];?>";
document.getElementById("PassText").innerHTML = "<span style=\"color: <?=$passCheck["color"];?>;font-weight:bold;font-size:11px;font-family:Arial;\"><?=$passCheck["text"];?></span>";
document.getElementById('PasswordDiv').style.visibility='visible';
document.getElementById('PasswordDiv').style.display='block';
document.getElementById('PassBar').style.visibility='visible';
document.getElementById('PassBar').style.display='block';
document.getElementById('PassText').style.visibility='visible';
document.getElementById('PassText').style.display='block';
