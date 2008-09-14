		
			<form name="formApps1" id="formApps1" method="POST" onsubmit="return false;">
			<input type="hidden" name="isSubmitted" value="0">
			<input type="hidden" name="frType" value="0">
			<input type="hidden" name="ref" value="0">

			<table width="500" align="center" border="0" cellspacing="2" cellpadding="2">
				<tr>
					<td valign="top" align="left">
					<span style="font-weight:bold;">Sign up now to get full access with your <?=APPS_NAME;?> account :</span>
					</td>
				</tr>
			</table>

			<table width="500" align="center" border="0" cellspacing="2" cellpadding="2" style="border-top: 1px #BEBEBE solid;border-bottom: 1px #BEBEBE solid;border-left: 1px #BEBEBE solid;border-right: 1px #BEBEBE solid;background:#EEEEEE; padding:20px;">
				<tr>
					<td valign="top" align="right" colspan="2">

						<div class="LblRqdDiv" style="margin: 5px 10px 5px 0px;" align="right">
							<img src="images/required.gif" alt="Required Field" height="14" width="7">&nbsp;<b>Indicates required field</b>
						</div>
					</td>
				</tr>
			
			<tr>
				<td valign="top" align="left" nowrap>
					<img src="images/required.gif" alt="Required Field" title="Required Field" height="14" width="7" tabindex="1">&nbsp;<span class="LblLev2Txt">Name</span>

				</td> 
				<td valign="top" nowrap align="left" width="75%">
					<input class="TxtFld"size="40" maxlength="255" type="text" name="VmtUserNama" value="<?=$_GET["VmtUserNama"];?>" tabindex="2" onkeyup="if (event.keyCode == 13) {ModalPopup('PopUpload');saveForm(document.getElementById('formApps1'),'Public','frUser');}">
				</td>
			</tr>
		
			
			<tr>
				<td valign="top" align="left" nowrap>
					<img src="images/required.gif" alt="Required Field" title="Required Field" height="14" width="7">&nbsp;<span class="LblLev2Txt">Username</span>
				</td> 
				<td valign="top" nowrap align="left">

					<input class="TxtFld" size="20" maxlength="20" type="text" name="VmtUserLogin" value="<?=$_GET["VmtUserLogin"];?>" tabindex="3" 
					onmouseover="Tip('Your username can only contain letters A-Z or numbers 0-9');"
					onmouseout="UnTip();"
					onblur="if (this.value != '') {getRequest(null,'index.php?mod=Public&act=checkUser&ref=' + this.value + '&do=1',null);}" onkeyup="document.getElementById('UserDiv').style.visibility='hidden';document.getElementById('UserDiv').style.display='none';document.getElementById('UserDiv').innerHTML='';if (event.keyCode == 13) {UnTip();ModalPopup('PopUpload');saveForm(document.getElementById('formApps1'),'Public','frUser');}">
					<span id="UserDiv" style="visibility:hidden;display:none;"></span>
				</td>
			</tr>
		
			
			<tr>
				<td valign="top" align="left" nowrap>
					<img src="images/required.gif" alt="Required Field" title="Required Field" height="14" width="7">&nbsp;<span class="LblLev2Txt">E-mail Address</span>
				</td> 
				<td valign="top" nowrap align="left">

					<input class="TxtFld"size="40" maxlength="255" type="text" name="VmtUserEmail" value="<?=$_GET["VmtUserEmail"];?>" tabindex="4"
					onblur="if (this.value != '') {getRequest(null,'index.php?mod=Public&act=checkEmail&ref=' + this.value + '&do=1',null);}" onkeyup="document.getElementById('EmailDiv').style.visibility='hidden';document.getElementById('EmailDiv').style.display='none';document.getElementById('EmailDiv').innerHTML='';if (event.keyCode == 13) {ModalPopup('PopUpload');saveForm(document.getElementById('formApps1'),'Public','frUser');}">
					<span id="EmailDiv" style="visibility:hidden;display:none;"></span>
				</td>
			</tr>
		
			
			<tr>
				<td valign="top" align="left" nowrap>
					<img src="images/required.gif" alt="Required Field" title="Required Field" height="14" width="7">&nbsp;<span class="LblLev2Txt">Password</span>
				</td> 
				<td valign="top" nowrap align="left">
					<input class="TxtFld"size="20" maxlength="20" type="password" name="VmtUserPassword" value="" tabindex="5"
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
					<input class="TxtFld" size="20" maxlength="20" type="password" name="VmtUserPassword2" value="" tabindex="6" 
					onblur="if (this.value != this.form.VmtUserPassword.value) {document.getElementById('ReTypeDiv').style.color='#BF0000';document.getElementById('ReTypeDiv').innerHTML='Do not match!!';document.getElementById('ReTypeDiv').style.visibility='visible';document.getElementById('ReTypeDiv').style.display='block';}"
					onkeyup="document.getElementById('ReTypeDiv').style.visibility='hidden';document.getElementById('ReTypeDiv').style.display='none';document.getElementById('ReTypeDiv').innerHTML='';if (event.keyCode == 13) {ModalPopup('PopUpload');saveForm(document.getElementById('formApps1'),'Public','frUser');}">
					<input type="hidden" name="VmtGroupId" value="2" />
					<span id="ReTypeDiv" style="visibility:hidden;display:none;font-weight:bold;font-size:11px;font-family:Arial;"></span>
				</td>

			</tr>
			
			<tr>
				<td valign="top" align="left" nowrap>
					<img src="images/spacer.gif" height="14" width="7" tabindex="1">&nbsp;<span class="LblLev2Txt">Verification code</span>

				</td> 
				<td valign="top" nowrap align="left" width="75%">
					<input class="TxtFld" size="7" maxlength="8" type="text" name="CaptchaVerif" id="CaptchaVerif" value="" tabindex="7" onmouseover="Tip('Enter the text in the image');" onmouseout="UnTip();" onfocus="UnTip();"
					onblur="if (this.value != '') {getRequest(null,'index.php?mod=Public&act=checkCaptcha&ref=' + this.value + '&do=1',null);}" onkeyup="document.getElementById('CaptchaDiv').style.visibility='hidden';document.getElementById('CaptchaDiv').style.display='none';document.getElementById('CaptchaDiv').innerHTML='';if (event.keyCode == 13) {UnTip();ModalPopup('PopUpload');saveForm(document.getElementById('formApps1'),'Public','frUser');}">
					<span id="CaptchaDiv" style="visibility:hidden;display:none;"></span>
				</td>
			</tr>
		
			
			<tr>
				<td valign="top" align="left" nowrap>
					&nbsp;
				</td> 
				<td valign="top" nowrap align="left">
					<span id="captcha"><img src="var/cache/captcha/<?=md5($_SESSION["security_code"]);?>.jpeg" width="135" height="48" /></span>
					<br />
					<span class="link4" style="font-style:normal;font-weight:bold;" onclick="document.getElementById('CaptchaVerif').value='';document.getElementById('CaptchaDiv').style.visibility='hidden';document.getElementById('CaptchaDiv').style.display='none';document.getElementById('CaptchaDiv').innerHTML='';getRequest(null,'index.php?mod=Public&act=getCaptcha&do=1&stat=1',null);">New Image</span>
				</td>
			</tr>
		
				
			
			<tr>
				<td valign="top" align="left" colspan="2" style="padding-left:7px;">
				<br />
			<span style="color:#BF0000;">Uploading materials that you do not own is a copyright violation and against the law. If you upload material you do not own, your account will be deleted.</span>
				</td> 

			</tr>
			
			<tr>
				<td valign="top" align="left" nowrap colspan="2">
				<br />
					<img src="images/sign_up.gif"  style="cursor:pointer;" onclick="javascript:ModalPopup('PopUpload');saveForm(document.getElementById('formApps1'),'Public','frUser');" onkeyup="javascript:if (event.keyCode == 13 || event.keyCode == 32) {ModalPopup('PopUpload');saveForm(document.getElementById('formApps1'),'Public','frUser');}" class="button-off" onmouseover="this.className='button-on';"
					onmouseout="this.className='button-off';"
					tabindex=8>
				</td> 

			</tr>
		</table>	
		</form>