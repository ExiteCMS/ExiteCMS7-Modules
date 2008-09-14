<?
$stat = $_GET["stat"];
$mydir = "var/cache/captcha/"; 
$d = dir($mydir); 
while($entry = $d->read()) { 
	if ($entry!= "." && $entry!= ".." && !is_dir($mydir.$entry)) { 
		unlink($mydir.$entry); 
	} 
} 
$d->close(); 

$captcha = new Captcha(135,48,6,true);

?>
document.getElementById('captcha').innerHTML='<img src="var/cache/captcha/<?=md5($_SESSION["security_code"]);?>.jpeg" width="135" height="48" />';
