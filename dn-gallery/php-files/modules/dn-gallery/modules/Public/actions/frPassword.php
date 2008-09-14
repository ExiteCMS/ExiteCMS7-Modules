<?

$VmtUserLogin = $_GET["VmtUserLogin"];
$CaptchaVerif = $_GET["CaptchaVerif"];


$error = false;

if ($VmtUserLogin == "") {
	$error = true;
	$errorVar["VmtUserLogin"] = "Username not found !!";
}
else {
	
	$usr = new VmtUser();
	$usr->setVmtUserLogin($VmtUserLogin);
	$ls = $usr->selectRowByCriteria();
	if ($ls->RecordCount() <= 0) {
		$errorVar["VmtUserLogin"] = "Username not found !!";
		$error = true;
	}
	else {
		$USERNAME = $ls->fields($usr->VmtUserLogin);
		$VmtUserEmail = $ls->fields($usr->VmtUserEmail);
		$UID = $ls->fields($usr->VmtUserId);
	}
}

if ($CaptchaVerif != $_SESSION["security_code"]) {
	$error = true;
	$errorVar["CaptchaVerif"] = "Wrong verification code entered";
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
document.getElementById("RegErrorDiv").innerHTML = '<table align="center" border=\"0\" cellpadding="0"><tr><td valign="top" align="left" valign="middle"><img src=\"images/dialog-warning.png\" width="48"/></td><td align="left" valign="middle" style="color:#9F0000;font-size:16px;font-weight:bold;">Password reset failed !!</td></tr><tr><td colspan="2" valign="top" align="left"><ul style=\"padding-top:0px;padding-left:25px;\"><?=$strError;?></ul></td></tr></table>';
document.getElementById("CaptchaVerif").value='';
ModalPopup.Close('PopUpload');
ModalPopup("RegError");
<?
	exit;
}
else {
	$token = md5($VmtUserLogin).md5(date("Y-m-d H:i:s"));
	$usr = new VmtUser();
	$usr->resetPass($UID,$token);

	if (trim($VmtUserEmail) != "") {
		$VmtUserEmail = trim($VmtUserEmail);
		$VmtUserLogin = trim($VmtUserLogin);

		$mail = new PHPMailer();

		$mail->IsSMTP();
		$mail->Host = $smtp_server;
		$mail->SMTPAuth = $smtp_auth;
		$mail->Username = $smtp_user;
		$mail->Password = $smtp_pass;
		if ($smtp_secure == "ssl") { 
			$mail->SMTPSecure = $smtp_secure;
		}
		$mail->Port = $smtp_port;

		$to = $VmtUserEmail;
		$rcpt = $VmtUserLogin;

		$mail->From = $email_from;
		$mail->FromName = $email_name;
		$mail->AddAddress($to, $rcpt);
		$mail->AddReplyTo($email_from, $email_name);

		$mail->IsHTML(true);

		$mail->Subject = "Password Reset";
		$mail->Body    = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 TRANSITIONAL//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\"><html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en-US\" lang=\"en-US\"><head><title></title></head><body>"; 
		$mail->Body    .= "<p style='font-size:14px;font-family:Arial;font-weight:bold;'>Hi ".$VmtUserLogin."</p>";
		$mail->Body    .= "<p style='font-size:12px;font-family:Arial;'>You are receiving this email because a new password was requested for your ".APPS_NAME." account. <br />If you did not request a new password for this account, ignore this email and continue to use your current password.<br /><br />";
		$mail->Body    .= "If you do wish to reset your password, please use the following link: <br /><br />";
		$mail->Body    .= "<a href='".$appsUrl."index.php?mod=Public&act=ResetPass&ref=".$token."'>".$appsUrl."index.php?mod=Public&act=ResetPass&ref=".$token."</a><br /><br /></p>";
		$mail->Body    .= "<p style='font-size:12px;font-family:Arial;'><B>Best regards,</b><br />";
		$mail->Body    .= "Your ".$email_name." team</p></body></html>";

		$mail->Send();
		
	}
?>
document.getElementById("RegSuceedDiv").innerHTML = '<table align="center" border=\"0\" cellpadding="0"><tr><td align="left" valign="middle" style="color:#FFFFFF;font-size:16px;font-weight:bold;">Please check your e-mail for instruction<br />on how to reset your password.</td></tr></table>';
ModalPopup.Close('PopUpload');
ModalPopup("RegSuceed");
<?
}
?>