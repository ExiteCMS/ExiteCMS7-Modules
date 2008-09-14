<?
$ref = $_GET["ref"];

if ($ref != $_SESSION["security_code"]) {
?>
	document.getElementById('CaptchaDiv').innerHTML='<span style="padding-left:2px;color:#BF0000;font-weight:bold;font-size:11px;font-family:Arial;">Wrong code</span>';
	document.getElementById('CaptchaDiv').style.visibility='visible';
	document.getElementById('CaptchaDiv').style.display='block';
<?
}
else {
?>
	document.getElementById('CaptchaDiv').style.visibility='hidden';
	document.getElementById('CaptchaDiv').style.display='none';
<?
}
?>