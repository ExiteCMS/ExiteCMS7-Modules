<?

$VmtUserId = $_GET["VmtUserId"];
$ref = $_GET["ref"];
$VmtUserPassword = $_GET["VmtUserPassword"];
$VmtUserPassword2 = $_GET["VmtUserPassword2"];


$error = false;

$usr = new VmtUser();
$usr->setTokenReset($ref);
$usr->setVmtUserId($VmtUserId);
$ls = $usr->selectRowByCriteria();

if ($ls->RecordCount() <= 0) {
	$error = true;
	$errorVar["VmtUserId"] = "Invalid Token";
}
if ($VmtUserPassword == "") {
	$error = true;
	$errorVar["VmtUserPassword"] = "Password is required";
}

if ($VmtUserPassword2 == "") {
	$error = true;
	$errorVar["VmtUserPassword2"] = "Re-type Password is required";
}

if (($VmtUserPassword != "") && ($VmtUserPassword2 != "") && ($VmtUserPassword != $VmtUserPassword2)) {
	$error = true;
	$errorVar["VmtUserPassword"] = "Password & Re-type Password do not match";
}


if ($error) {
	$query = "";
	while (list($key,$val) = each($_GET)) {
		$query .= $key."=".$val."&";
	}
	$strError = "";
	while (list($key,$val) = each($errorVar)) {
		$query .= $key."=".$val."&";
		$strError .= "<li div class=\"ErrorTxt\" style=\"color:#FFFFFF\">".$val."</li>";
	}
?>	
document.getElementById("RegErrorDiv").innerHTML = '<table align="center" border=\"0\" cellpadding="0"><tr><td valign="top" align="left" valign="middle"><img src=\"images/dialog-warning.png\" width="48"/></td><td align="left" valign="middle" style="color:#9F0000;font-size:16px;font-weight:bold;">Password Reset failed !!</td></tr><tr><td colspan="2" valign="top" align="left"><ul style=\"padding-top:0px;padding-left:25px;\"><?=$strError;?></ul></td></tr></table>';
document.getElementById("CaptchaVerif").value='';
ModalPopup.Close('PopUpload');
ModalPopup("RegError");
<?
	exit;
}
else {

	$obj =& new VmtUser();
	$obj->clearFieldValue();
	$obj->changePassword($VmtUserId,$VmtUserPassword);
?>
document.getElementById("RegSuceedDiv").innerHTML = '<table align="center" border=\"0\" cellpadding="0"><tr><td align="left" valign="middle" style="color:#FFFFFF;font-size:16px;font-weight:bold;">Your password has been changed !!</td></tr></table>';
ModalPopup.Close('PopUpload');
ModalPopup("RegSuceed");
<?
}
?>