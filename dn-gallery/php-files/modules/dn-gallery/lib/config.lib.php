<?php
/**
*	C O N F I G U R A T I O N 	*
**/

/* DataBase connections param	*/

/* MySQL */
$server="DB_SERVER";
$user="DB_USER";
$password="DB_PASSWORD";
$database="DB_NAME";


$email_from = "EMAIL_FROM";
$email_name = "DN - Gallery";
$smtp_server = "SMTP_SERVER";
$smtp_auth = true;
$smtp_user = "SMTP_USER_NAME";
$smtp_pass = "SMTP_PASSWORD";
$smtp_secure = "ssl";
$smtp_port = "465";
$mail_subject = "Verify email";

$driver="mysqlt";
$debug=false;
$db = &ADONewConnection($driver); 
$db->debug = $debug;

/* MySQL */
$db->PConnect($server, $user, $password, $database);
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;

$__server = $_SERVER["SERVER_NAME"];
if ($_SERVER["SERVER_PORT"] != "80") {
	$__server .= ":".$_SERVER["SERVER_PORT"];
}
$appsUrl = "http://".$__server."/DN-Gallery/";
define("SITE_NAME","");
define("OWNER_NAME"," ");
define("APPS_NAME","DN - Gallery");
define("COPYRIGHT","2008  &copy; www.devel-nottie.com, All Right Reserved ");
define("POWERED_BY","<a href='http://www.devel-nottie.com' target='_blank' class='link2'>Powered By DN - Gallery</a>");
define("ROOT_PATH","/DN-Gallery/");

?>