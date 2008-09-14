<?php 	
/**
*	S E S S I O N S		*
**/

session_name("ptsi_tpt");
session_start();
if (!isset($_SESSION["uid"]) || $_SESSION["uid"] == "" || !isset($_SESSION["pwd"]) || $_SESSION["pwd"] == "" || !isset($_SESSION["gid"]) || $_SESSION["gid"] == "") {
	$logged=false;
	$_SESSION["uid"]="";
	$_SESSION["pwd"]="";
	$_SESSION["gid"]="";
	$_SESSION["pid"]="";
}
else {
	$logged=true;
	$usrID = $_SESSION["uid"];
	$usrPwd = $_SESSION["pwd"];
	$grpID = $_SESSION["gid"];
	$PERUSAHAAN_ID=$_SESSION["pid"];
} 
?>