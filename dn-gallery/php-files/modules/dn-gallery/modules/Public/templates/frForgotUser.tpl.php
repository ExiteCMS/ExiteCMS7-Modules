		
			<form name="formApps1" id="formApps1" method="POST" onsubmit="return false;">
			<input type="hidden" name="isSubmitted" value="0">
			<input type="hidden" name="frType" value="0">
			<input type="hidden" name="ref" value="0">

			<table width="500" align="center" border="0" cellspacing="2" cellpadding="2" style="border-top: 1px #BEBEBE solid;border-bottom: 1px #BEBEBE solid;border-left: 1px #BEBEBE solid;border-right: 1px #BEBEBE solid;background:#EEEEEE; padding:20px;">
			
			<tr>
				<td valign="top" align="left" nowrap>
					<img src="images/spacer.gif" height="14" width="7" tabindex="1">&nbsp;<span class="LblLev2Txt">E-mail Address</span>
				</td> 
				<td valign="top" nowrap align="left">

					<input class="TxtFld"size="40" maxlength="255" type="text" name="VmtUserEmail" value="<?=$_GET["VmtUserEmail"];?>" tabindex="4"
					onblur="if (this.value != '') {getRequest(null,'index.php?mod=Public&act=checkEmail&ref=' + this.value + '&do=1',null);}" onkeyup="document.getElementById('EmailDiv').style.visibility='hidden';document.getElementById('EmailDiv').style.display='none';document.getElementById('EmailDiv').innerHTML='';if (event.keyCode == 13) {ModalPopup('PopUpload');saveForm(document.getElementById('formApps1'),'Public','frUsername');}">
					<span id="EmailDiv" style="visibility:hidden;display:none;"></span>
				</td>
			</tr>
			
			<tr>
				<td valign="top" align="left" nowrap>
					<img src="images/spacer.gif" height="14" width="7" tabindex="1">&nbsp;<span class="LblLev2Txt">Verification code</span>

				</td> 
				<td valign="top" nowrap align="left" width="75%">
					<input class="TxtFld" size="7" maxlength="8" type="text" name="CaptchaVerif" id="CaptchaVerif" value="" tabindex="7" onmouseover="Tip('Enter the text in the image');" onmouseout="UnTip();" onfocus="UnTip();"
					onblur="if (this.value != '') {getRequest(null,'index.php?mod=Public&act=checkCaptcha&ref=' + this.value + '&do=1',null);}" onkeyup="document.getElementById('CaptchaDiv').style.visibility='hidden';document.getElementById('CaptchaDiv').style.display='none';document.getElementById('CaptchaDiv').innerHTML='';if (event.keyCode == 13) {UnTip();ModalPopup('PopUpload');saveForm(document.getElementById('formApps1'),'Public','frUsername');}">
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
				<td valign="top" align="left" nowrap>
					&nbsp;
				</td> 
				<td valign="top" align="left" nowrap>
				<br />
					<img src="images/email_username.gif"  style="cursor:pointer;" onclick="javascript:ModalPopup('PopUpload');saveForm(document.getElementById('formApps1'),'Public','frUsername');" onkeyup="javascript:if (event.keyCode == 13 || event.keyCode == 32) {ModalPopup('PopUpload');saveForm(document.getElementById('formApps1'),'Public','frUsername');}" class="button-off" onmouseover="this.className='button-on';"
					onmouseout="this.className='button-off';"
					tabindex=8>
				</td> 

			</tr>
		</table>	
		</form>