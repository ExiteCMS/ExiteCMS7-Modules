<?php

if (!isset($_SESSION["uid"]) || $_SESSION["uid"] == "" || !isset($_SESSION["pwd"]) || $_SESSION["pwd"] == "" || !isset($_SESSION["gid"]) || $_SESSION["gid"] == "") {
	$logged=false;
	$_SESSION["uid"]="";
	$_SESSION["pwd"]="";
	$_SESSION["gid"]="";
?>
	<script type="text/javascript" src="js/js_lib.js"></script>
	<script type="text/javascript" src="js/internal_request.js"></script>
	<div id="MyPopup1" style="font-family:Arial;margin:15px;width:500px;border:#FFFFFF 2px solid; background-color:#525252;display:none;color:#FFFFFF;font-size:16px;font-weight:bold;text-align:center;">
				&nbsp;<br />
				<img src="images/dialog-error.png" align="absmiddle" />&nbsp;You are not authorized to view this page !!<br />&nbsp;<br />
				<span style="font-family:Arial;text-decoration:underline;font-size:11px;color:#CCFFFF;cursor:pointer;" onclick="ModalPopup.Close('MyPopup1');location.href='index.php?mod=UserMgmt&act=logout&do=1';">Close</span>
				&nbsp;
				</div>
	<script>ModalPopup("MyPopup1");</script>
<?
	exit;
}
switch($frType) {
	case "0":
		$actType="insert";
	break;
	case "1":
		$actType="edit";
	break;
	case "2":
		$actType="delete";
	break;
}

switch($do) {

	case "0":	
		include_once(TEMPLATES.'index.tpl.php');
	break;
	case "1":
		include_once('modules/'.$mod.'/actions/'.$act.'.php');
	break;
	case "9":	
		include_once(TEMPLATES.'ajax.tpl.php');
	break;
}
?>
