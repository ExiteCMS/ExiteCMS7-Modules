<?
$ref = $_GET["ref"];

$obj = new VmtUser();
$obj->setVmtUserLogin($ref);
$ls = $obj->selectRowByCriteria();
if ($ls->RecordCount() > 0) {
?>
	document.getElementById('UserDiv').innerHTML='<span style="padding-left:2px;color:#BF0000;font-weight:bold;font-size:11px;font-family:Arial;">Username unavailable</span>';
	document.getElementById('UserDiv').style.visibility='visible';
	document.getElementById('UserDiv').style.display='block';
<?
}
else {
?>
	document.getElementById('UserDiv').innerHTML='<span style="padding-left:2px;color:#008A00;font-weight:bold;font-size:11px;font-family:Arial;">Username available</span>';
	document.getElementById('UserDiv').style.visibility='visible';
	document.getElementById('UserDiv').style.display='block';
<?
}
?>