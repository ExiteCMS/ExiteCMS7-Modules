<?
if ($ls->RecordCount() <= 0) {
?>
	
	<div id="RegError" style="font-family:Arial;margin:15px;width:500px;border:#FFFFFF 2px solid; background-color:#525252;display:none;color:#FFFFFF;font-size:16px;font-weight:bold;text-align:center;">
	&nbsp;<br />
	<div id="RegErrorDiv">
		<table align="center" border="0" cellpadding="0"><tr><td valign="top" align="left" valign="middle"><img src="images/dialog-warning.png" width="48"/></td><td align="left" valign="middle" style="color:#9F0000;font-size:16px;font-weight:bold;">Password reset failed !!</td></tr><tr><td colspan="2" valign="top" align="left"><ul style="padding-top:0px;padding-left:25px;"><li div class="ErrorTxt" style="color:#FFFFFF">Invalid Token</li></ul></td></tr></table>
	</div>
	<span style="font-family:Arial;text-decoration:underline;font-size:11px;color:#CCFFFF;cursor:pointer;" onclick="location.href='index.php'">Close</span>
	<br />
	&nbsp;
	</div>
<script>ModalPopup('RegError');</script>
<?

}
?>

		
			<form name="formApps1" id="formApps1" method="POST" onsubmit="return false;">
			<input type="hidden" name="isSubmitted" value="0">
			<input type="hidden" name="frType" value="0">
			<input type="hidden" name="ref" value="<?=$ref;?>">
			<input type="hidden" name="VmtUserId" value="<?=$ls->fields($usr->VmtUserId);?>">

			<table width="500" align="center" border="0" cellspacing="2" cellpadding="2" style="border-top: 1px #BEBEBE solid;border-bottom: 1px #BEBEBE solid;border-left: 1px #BEBEBE solid;border-right: 1px #BEBEBE solid;background:#EEEEEE; padding:20px;">
			
			<tr>
				<td valign="top" align="left" nowrap>
					<img src="images/spacer.gif" height="14" width="7" tabindex="1">&nbsp;<span class="LblLev2Txt">Username</span>
				</td> 
				<td valign="top" nowrap align="left">
					<strong><?=$ls->fields($usr->VmtUserLogin);?></strong>
					
				</td>
			</tr>
		
			
			<tr>
				<td valign="top" align="left" nowrap>
					<img src="images/required.gif" alt="Required Field" title="Required Field" height="14" width="7">&nbsp;<span class="LblLev2Txt">Password</span>
				</td> 
				<td valign="top" nowrap align="left">
					<input class="TxtFld"size="22" maxlength="20" type="password" name="VmtUserPassword" value="" tabindex="5"
					onblur="if (this.value != '') {getRequest(null,'index.php?mod=Public&act=checkPassword&ref=' + this.value + '&do=1',null);}"  onkeyup="document.getElementById('PasswordDiv').style.visibility='hidden';document.getElementById('PasswordDiv').style.display='none';document.getElementById('PassBar').style.visibility='hidden';document.getElementById('PassBar').style.display='none';document.getElementById('PassText').style.visibility='hidden';document.getElementById('PassText').style.display='none';document.getElementById('PassText').innerHTML='';if (event.keyCode == 13) {ModalPopup('PopUpload');saveForm(document.getElementById('formApps1'),'Public','frUser');}" />
					<span id="PasswordDiv" style="visibility:hidden;display:none;width:134px;background:#C8C8C8;height:5px;"><span id="PassBar" style="height:5px;visibility:hidden;display:none;"></span></span>
					<span id="PassText" style="visibility:hidden;display:none;width:134px;"></span>

				</td>
			</tr>
		
			
			<tr>
				<td valign="top" align="left" nowrap>
					<img src="images/required.gif" alt="Required Field" title="Required Field" height="14" width="7">&nbsp;<span class="LblLev2Txt">Re-type Password</span>
				</td> 
				<td valign="top" nowrap align="left">
					<input class="TxtFld" size="22" maxlength="20" type="password" name="VmtUserPassword2" value="" tabindex="6" 
					onblur="if (this.value != this.form.VmtUserPassword.value) {document.getElementById('ReTypeDiv').style.color='#BF0000';document.getElementById('ReTypeDiv').innerHTML='Do not match!!';document.getElementById('ReTypeDiv').style.visibility='visible';document.getElementById('ReTypeDiv').style.display='block';}"
					onkeyup="document.getElementById('ReTypeDiv').style.visibility='hidden';document.getElementById('ReTypeDiv').style.display='none';document.getElementById('ReTypeDiv').innerHTML='';if (event.keyCode == 13) {ModalPopup('PopUpload');saveForm(document.getElementById('formApps1'),'Public','frUser');}">
					<span id="ReTypeDiv" style="visibility:hidden;display:none;font-weight:bold;font-size:11px;font-family:Arial;"></span>
				</td>

			</tr>
		
				
			
			<tr>
				<td valign="top" align="left" nowrap>
					&nbsp;
				</td> 
				<td valign="top" align="left" nowrap>
				<br />
					<img src="images/update_pass.gif"  style="cursor:pointer;" onclick="javascript:ModalPopup('PopUpload');saveForm(document.getElementById('formApps1'),'Public','frChPassword');" onkeyup="javascript:if (event.keyCode == 13 || event.keyCode == 32) {ModalPopup('PopUpload');saveForm(document.getElementById('formApps1'),'Public','frChPassword');}" class="button-off" onmouseover="this.className='button-on';"
					onmouseout="this.className='button-off';"
					tabindex=8>
				</td> 

			</tr>
		</table>	
		</form>
	
	
	<div id="RegError" style="font-family:Arial;margin:15px;width:500px;border:#FFFFFF 2px solid; background-color:#525252;display:none;color:#FFFFFF;font-size:16px;font-weight:bold;text-align:center;">
	&nbsp;<br />
	<div id="RegErrorDiv">
		&nbsp;
	</div>
	<span style="font-family:Arial;text-decoration:underline;font-size:11px;color:#CCFFFF;cursor:pointer;" onclick="getRequest(null,'index.php?mod=Public&act=getCaptcha&do=1&stat=1',null);ModalPopup.Close('RegError');">Close</span>
	<br />
	&nbsp;
	</div>
	
	<div id="RegSuceed" style="font-family:Arial;margin:15px;width:500px;border:#FFFFFF 2px solid; background-color:#525252;display:none;color:#FFFFFF;font-size:16px;font-weight:bold;text-align:center;">
	&nbsp;<br />
	<div id="RegSuceedDiv">
		&nbsp;
	</div>
	<span style="font-family:Arial;text-decoration:underline;font-size:11px;color:#CCFFFF;cursor:pointer;" onclick="ModalPopup.Close('RegSuceed');getRequest(null,'index.php?mod=Public&act=main&do=9','main_area');">Close</span>
	<br />
	&nbsp;
	</div>

	
	<div id="PopUpload" style="margin:15px;width:300px;border:0px; background:transparent;display:none;color:#FFFFFF;text-align:center;">
				&nbsp;<br />
				<img src="images/loading2.gif" align="center" style="opacity: .50;-moz-opacity: 0.50;filter: alpha(opacity=50);" /><br />&nbsp;
				</div>