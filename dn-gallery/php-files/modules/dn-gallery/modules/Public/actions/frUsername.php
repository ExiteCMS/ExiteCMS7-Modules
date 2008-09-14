<?

$VmtUserEmail = $_GET["VmtUserEmail"];
$CaptchaVerif = $_GET["CaptchaVerif"];


$error = false;

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
	else {
		$usr = new VmtUser();
		$usr->setVmtUserEmail($VmtUserEmail);
		$ls = $usr->selectRowByCriteria();
		if ($ls->RecordCount() <= 0) {
			$errorVar["VmtUserEmailFormat"] = "Your E-mail address was not found in our database";
			$error = true;
		}
		else {
			$USERNAME = $ls->fields($usr->VmtUserLogin);
		}
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
document.getElementById("RegErrorDiv").innerHTML = '<table align="center" border=\"0\" cellpadding="0"><tr><td valign="top" align="left" valign="middle"><img src=\"images/dialog-warning.png\" width="48"/></td><td align="left" valign="middle" style="color:#9F0000;font-size:16px;font-weight:bold;">Username search failed !!</td></tr><tr><td colspan="2" valign="top" align="left"><ul style=\"padding-top:0px;padding-left:25px;\"><?=$strError;?></ul></td></tr></table>';
document.getElementById("CaptchaVerif").value='';
ModalPopup.Close('PopUpload');
ModalPopup("RegError");
<?
	exit;
}
else {
	if (trim($VmtUserEmail) != "") {
		$VmtUserEmail = trim($VmtUserEmail);

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
		$rcpt = $VmtUserEmail;

		$mail->From = $email_from;
		$mail->FromName = $email_name;
		$mail->AddAddress($to, $rcpt);
		$mail->AddReplyTo($email_from, $email_name);

		$mail->IsHTML(true);

		$mail->Subject = "Username request";
		$mail->Body    = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 TRANSITIONAL//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\"><html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en-US\" lang=\"en-US\"><head><title></title></head><body>"; 
		$mail->Body    .= "<p style='font-size:14px;font-family:Arial;font-weight:bold;'>Hi ".$VmtUserEmail."</p>";
		$mail->Body    .= "<p style='font-size:12px;font-family:Arial;'>The following ".APPS_NAME." usernames are attached to this email address :<br /><br />";
		$mail->Body    .= "<b>".$USERNAME."</b><br /><br />";
		$mail->Body    .= "We hope this helps.</p>";
		$mail->Body    .= "<p style='font-size:12px;font-family:Arial;'><B>Best regards,</b><br />";
		$mail->Body    .= "Your ".$email_name." team</p></body></html>";

		$mail->Send();
		
	}
?>
document.getElementById("RegSuceedDiv").innerHTML = '<table align="center" border=\"0\" cellpadding="0"><tr><td align="left" valign="middle" style="color:#FFFFFF;font-size:16px;font-weight:bold;">Please check your e-mail for your Username.</td></tr></table>';
ModalPopup.Close('PopUpload');
ModalPopup("RegSuceed");
<?
}
?>