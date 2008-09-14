<?
$ref = $_GET["ref"];

$mail_error = false;
if (!eregi("@",$ref)) {
	$mail_error = true;
}
else {
	$expl = explode("@",$ref);
	if (strlen($expl[0]) < 1) {
		$mail_error = true;
	}
	else {
		$expl2 = explode(".",$expl[1]);
		if (sizeof($expl2) < 2) {
			$mail_error = true;
		}
	}
}
if ($mail_error) {
?>
	document.getElementById('EmailDiv').innerHTML='<span style="padding-left:2px;color:#BF0000;font-weight:bold;font-size:11px;font-family:Arial;">Invalid e-mail address</span>';
	document.getElementById('EmailDiv').style.visibility='visible';
	document.getElementById('EmailDiv').style.display='block';
<?
}
else {
?>
	document.getElementById('EmailDiv').innerHTML='';
	document.getElementById('EmailDiv').style.visibility='hidden';
	document.getElementById('EmailDiv').style.display='none';
<?
}
?>