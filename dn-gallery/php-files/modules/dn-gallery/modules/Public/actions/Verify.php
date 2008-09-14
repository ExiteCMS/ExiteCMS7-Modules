<?
$ref = $_GET["ref"];

$usr = new VmtUser();
$usr->setToken($ref);
$ls = $usr->selectRowByCriteria();
if ($ls->RecordCount() > 0) {
	$usr->ClearFieldValue();
	$usr->setActive($ls->fields($usr->VmtUserId));
?>
	<script type="text/javascript" src="js/js_lib.js"></script>
	<script type="text/javascript" src="js/internal_request.js"></script>
	<div id="MyPopup1" style="font-family:Arial;margin:15px;width:500px;border:#FFFFFF 2px solid; background-color:#525252;display:none;color:#FFFFFF;font-size:16px;font-weight:bold;text-align:center;">
				&nbsp;<br />
				<table align="center" border=\"0\" cellpadding="0"><tr><td align="left" valign="middle" style="color:#FFFFFF;font-size:16px;font-weight:bold;">Your account is now active!!<br> Please log in to start using your new account.</td></tr></table>
				<br />
				<span style="font-family:Arial;text-decoration:underline;font-size:11px;color:#CCFFFF;cursor:pointer;" onclick="ModalPopup.Close('MyPopup1');location.href='index.php?mod=Public&act=main';">Close</span>
				&nbsp;
				</div>
	<script>ModalPopup("MyPopup1");</script>
<?
}
else {
?>
	<script type="text/javascript" src="js/js_lib.js"></script>
	<script type="text/javascript" src="js/internal_request.js"></script>
	<div id="MyPopup1" style="font-family:Arial;margin:15px;width:500px;border:#FFFFFF 2px solid; background-color:#525252;display:none;color:#FFFFFF;font-size:16px;font-weight:bold;text-align:center;">
				&nbsp;<br />
				<img src="images/dialog-error.png" align="absmiddle" />&nbsp;Invalid registration token !! Please register a new account if you haven't done yet<br />&nbsp;<br />
				<span style="font-family:Arial;text-decoration:underline;font-size:11px;color:#CCFFFF;cursor:pointer;" onclick="ModalPopup.Close('MyPopup1');location.href='index.php?mod=Public&act=main';">Close</span>
				&nbsp;
				</div>
	<script>ModalPopup("MyPopup1");</script>
<?
}
?>