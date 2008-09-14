<?

$VmtUserNama = $_GET["VmtUserNama"];
$VmtUserLogin = $_GET["VmtUserLogin"];
$VmtUserEmail = $_GET["VmtUserEmail"];
$VmtUserPassword = $_GET["VmtUserPassword"];
$VmtUserPassword2 = $_GET["VmtUserPassword2"];
$VmtGroupId = $_GET["VmtGroupId"];
$CaptchaVerif = $_GET["CaptchaVerif"];


$error = false;

if ($VmtUserNama == "") {
	$error = true;
	$errorVar["VmtUserNama"] = "Name is required";
}

if ($VmtUserLogin == "") {
	$error = true;
	$errorVar["VmtUserLogin"] = "Username is required";
}
else {
	$obj = new VmtUser();
	$obj->setVmtUserLogin($VmtUserLogin);
	$ls = $obj->selectRowByCriteria();
	if ($ls->RecordCount() > 0) {
		$error = true;
		$errorVar["VmtUserLogin"] = "User already existed. Please choose another Unername";
	}
}
if ($VmtUserEmail == "") {
	$error = true;
	$errorVar["VmtUserEmail"] = "E-mail address is required";
}
else {
	$mail_error = false;
	if (!eregi("@",$VmtUserEmail)) {
		$mail_error = true;
	}
	else {
		$expl = explode("@",$VmtUserEmail);
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
		$errorVar["VmtUserEmailFormat"] = "Invalid e-mail address";
		$error = true;
	}
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
document.getElementById("RegErrorDiv").innerHTML = '<table align="center" border=\"0\" cellpadding="0"><tr><td valign="top" align="left" valign="middle"><img src=\"images/dialog-warning.png\" width="48"/></td><td align="left" valign="middle" style="color:#9F0000;font-size:16px;font-weight:bold;">Registration failed !!</td></tr><tr><td colspan="2" valign="top" align="left"><ul style=\"padding-top:0px;padding-left:25px;\"><?=$strError;?></ul></td></tr></table>';
document.getElementById("CaptchaVerif").value='';
ModalPopup.Close('PopUpload');
ModalPopup("RegError");
<?
	exit;
}
else {
	$token = md5($VmtUserLogin."".$VmtUserPassword).md5(date("Y-m-d H:i:s"));

	$obj =& new VmtUser();
	$obj->clearFieldValue();
	$obj->setVmtUserNama($VmtUserNama);
	$obj->setVmtUserLogin($VmtUserLogin);
	$obj->setVmtUserPassword($VmtUserPassword);
	$obj->setVmtUserEmail($VmtUserEmail);
	$obj->setIsActive('null');
	$obj->setToken($token);
	$obj->insertRow();
	
	$user_id = $obj->getLastInsertedId();

	$usr_grp = new VmtUserGroup();
	$usr_grp->clearFieldValue();
	$usr_grp->setVmtGroupId("2");
	$usr_grp->setVmtUserId($user_id);
	$usr_grp->insertRow();

	

	if (trim($VmtUserEmail) != "") {
		$VmtUserEmail = trim($VmtUserEmail);
		$VmtUserNama = trim($VmtUserNama);

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
		$rcpt = $VmtUserNama;

		$mail->From = $email_from;
		$mail->FromName = $email_name;
		$mail->AddAddress($to, $rcpt);
		$mail->AddReplyTo($email_from, $email_name);

		$mail->IsHTML(true);

		$mail->Subject = $mail_subject;
		$mail->Body    = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 TRANSITIONAL//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\"><html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en-US\" lang=\"en-US\"><head><title></title></head><body>"; 
		$mail->Body    .= "<p style='font-size:14px;font-family:Arial;font-weight:bold;'>Dear ".$VmtUserNama."</p>";
		$mail->Body    .= "<p style='font-size:12px;font-family:Arial;'>Please click on the following link to activate your account:<br />";
		$mail->Body    .= "<a href='".$appsUrl."index.php?mod=Public&act=Verify&do=1&ref=".$token."'>".$appsUrl."index.php?mod=Public&act=Verify&do=1&ref=".$token."</a><br />";
		$mail->Body    .= "If the url doesn't work for you, it might be because it has line breaks in it. In such case you can copy the url and execute in your browser.</p>";
		$mail->Body    .= "<p style='font-size:12px;font-family:Arial;'><B>Best regards,</b><br />";
		$mail->Body    .= "Your ".$email_name." team</p></body></html>";

		$mail->Send();
		
	}
?>
document.getElementById("RegSuceedDiv").innerHTML = '<table align="center" border=\"0\" cellpadding="0"><tr><td align="left" valign="middle" style="color:#FFFFFF;font-size:16px;font-weight:bold;">Registration Succeed !!<br> Please check your e-mail for confirmation.</td></tr></table>';
ModalPopup.Close('PopUpload');
ModalPopup("RegSuceed");
<?
}
?>