<?php
/*
 * Created on 10 Okt 06
 *
 * Author Adam
 * FileName login.php
 */
 
$fldUserName = $_POST["j_username"];
$fldPassword = $_POST["j_password"];

$user = new VmtUser();
$user_group = $user->authenticate($fldUserName,$fldPassword);

if (sizeof($user_group) >= 1 && (array_key_exists("1",$user_group) || array_key_exists("2",$user_group))) {
	$_SESSION["uid"] = $fldUserName;
	$_SESSION["pwd"] = $fldPassword;
	$_SESSION["gid"] = $user_group;
	echo "<script>location.href='index.php';</script>";
}
else {
?>
	<script type="text/javascript" src="js/js_lib.js"></script>
	<script type="text/javascript" src="js/internal_request.js"></script>
	<div id="MyPopup1" style="font-family:Arial;margin:15px;width:500px;border:#FFFFFF 2px solid; background-color:#525252;display:none;color:#FFFFFF;font-size:16px;font-weight:bold;text-align:center;">
				&nbsp;<br />
				<img src="images/dialog-error.png" align="absmiddle" />&nbsp;Invalid Username / Password !!<br />&nbsp;<br />
				<span style="font-family:Arial;text-decoration:underline;font-size:11px;color:#CCFFFF;cursor:pointer;" onclick="ModalPopup.Close('MyPopup1');location.href='index.php?mod=Public&act=login';">Close</span>
				&nbsp;
				</div>
	<script>ModalPopup("MyPopup1");</script>
<?
}
?>
