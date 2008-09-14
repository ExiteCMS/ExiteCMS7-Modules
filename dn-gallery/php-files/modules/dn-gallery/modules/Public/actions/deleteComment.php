<?
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
$gal = $_GET["gal"];
$ref = $_GET["ref"];

$com = new Comments();
$com->setCommentId($ref);
$com->deleteRow();

?>
getRequest(null,'index.php?mod=Public&act=viewComment&do=9&ref=<?=$gal;?>','comment_div');
document.getElementById('CommentsDetail').value='';
document.getElementById('comment_form').style.visibility='hidden';
document.getElementById('comment_form').style.display='none';
document.getElementById('comment_div').style.visibility='visible';
document.getElementById('comment_div').style.display='block';