<?
/**
*	THIS FILES CONTAINS ALL GLOBAL VARIABLES, CONSTANTS, CLASSES AND	*
*              VARIABLE'S CHECKS USED ON THIS FRAMEWORK					*
*	                 DO NOT CHANGE THIS FILE !!!						*
**/

/** GLOBAL CLASSES **/
$http = new Http();
$http->stripPostVars();

$errorPanel = new ErrorPanel();

$history = new History();
/** GLOBAL CLASSES **/

/** GLOBAL VARS **/
$mod="";
$mod = $_GET["mod"];
if ($mod=="") {$mod=$_POST["mod"];}
if ($mod=="") {$mod="Public";}

$do="";
$do = $_GET["do"];
if ($do=="") {$do=$_POST["do"];}
if ($do=="") {$do="0";}

$act="";
$act = $_GET["act"];
if ($act=="") {$act=$_POST["act"];}
if ($act=="") {$act="main";}
	
$frType = $_GET["frType"];
if ($frType=="") {$frType=$_POST["frType"];}
if ($frType=="") {$frType="";}

$show=$_POST["show"];
if (!$show) {$show=$_GET["show"];}
if (!$show) {$show=1;}

$isSubmitted="";
$isSubmitted = $_GET["isSubmitted"];
if ($isSubmitted=="") {$isSubmitted=$_POST["isSubmitted"];}
if ($isSubmitted=="") {$isSubmitted="0";}

$_ID="";
$_ID = $_GET["_ID"];
if ($_ID=="") {$_ID=$_POST["_ID"];}
if ($_ID=="") {$_ID="-1";}

$ref="";
$ref = $_GET["ref"];
if ($ref=="") {$ref=$_POST["ref"];}
if ($ref=="") {$ref="0";}

$params = $_POST["params"];

$logged=false;

$limit=15;
/** GLOBAL VARS **/

/** GLOBAL CONST **/
define("CLASS_PATH","modules/".$mod."/classes/");
define("PATH","/");
define("TEMPLATES","templates/");
/** GLOBAL CONST **/

/** GLOBAL CHECKS **/
if ($_SESSION["gid"] == "" || $_SESSION["pwd"] == "" || $_SESSION["uid"] == "") {
	define("LOGIN",false);
	$publicOnly = true;
}
else {
	$publicOnly = false;
	define("LOGIN",true);
}

if ($frType == "1") {
	if ($params[0] != "") {
		$_ID = $params[0];
	}
}

if ($do=="3") {
	$framepath = $_SERVER["REQUEST_URI"];
	define("FRAME_PATH",eregi_replace("do=3","do=2",$framepath));
}
/** GLOBAL CHECKS **/

$history->addAddress("index.php?".$_SERVER["QUERY_STRING"]);
$dbConnection =& new DBConnection();

$monthName = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
$monthAbb = array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Des");
$monthRoman = array("I","II","III","IV","V","VI","VII","VIII","IX","X","XI","XII");

$defaultWilId = "360010010";
$defaultMapId = "360010010";
?>