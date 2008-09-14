<?
function sendmail($to,$rcpt,$subject,$message)
{

	$mail = new PHPMailer();

	$mail->IsSMTP();                                      
	$mail->Host = "ssl://smtp.gmail.com";  
	$mail->SMTPAuth = true;    
	$mail->Username = "adam@lug.or.id";  
	$mail->Password = "kosongeuy"; 
	$mail->Port = "465";

	$mail->From = "demo@vmt.co.id";
	$mail->FromName = "Demo Mailer";
	$mail->AddAddress($to, $rcpt);
	$mail->AddReplyTo("demo@vmt.co.id", "Demo Mailer");

	$mail->WordWrap = 50;                               
	$mail->IsHTML(true);                                 

	$mail->Subject = $subject;
	$mail->Body    = $message;

	if(!$mail->Send())
	{
	   return 0;
	}
	return 1;	
}

?>