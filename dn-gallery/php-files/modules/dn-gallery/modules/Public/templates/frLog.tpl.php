			<form method="POST" action="index.php?mod=UserMgmt&act=login&do=1" id="loginForm" name="loginform">
				<? if ($_GET["act"] == "frUser") { ?>
				<table width="259" align="center" border="0" cellspacing="2" cellpadding="2">
					<tr>
						<td valign="top" align="center">
						<span style="font-weight:bold;">Already have an account? <br /></span>
						</td>
					</tr>
				</table>
				<? } ?>
				<table border="0" width="259" cellspacing="1" cellpadding="1" style="border-top: 1px #BEBEBE solid;border-bottom: 1px #BEBEBE solid;border-left: 1px #BEBEBE solid;border-right: 1px #BEBEBE solid;background:#EEEEEE;" align="center">
                  <tr>
                    <td nowrap align="left" style="padding-left:20px;padding-right:20px;">
					  <div class="logLblLst">
					    <span class="LblLev2Txt" style="padding>
						    <label for="Login.username">Username</label> <br /><input class="TxtFld" type="text" name="j_username" id="Login.username" tabindex="9" value="" size="35"  onkeyup="javascript:if (event.keyCode == 13) {document.getElementById('loginForm').submit();}">
					    </span>
					  </div>					
					 </td>
                  </tr>
                  <tr>
                    <td nowrap align="left" style="padding-left:20px;padding-right:20px;">
					  <div class="logLblLst">
					    <span class="LblLev2Txt">
						    <label for="Login.password">Password</label> <br /><input class="TxtFld" type="password" name="j_password" id="Login.password" tabindex="10" value="" size="35"  onkeyup="javascript:if (event.keyCode == 13) {document.getElementById('loginForm').submit();}">
						</span>
					  </div>
					</td>
                  </tr>
                  <tr>
                    <td align="left" style="padding-left:20px;padding-right:20px;">
					  <div class="logLblLst">
					    <span class="LblLev2Txt">

					<img src="images/sign_in.gif"  style="cursor:pointer;" onclick="javascript:document.getElementById('loginForm').submit();"  onkeyup="javascript:if (event.keyCode == 13 || event.keyCode == 32) {document.getElementById('loginForm').submit();}"class="button-off" onmouseover="this.className='button-on';"
					onmouseout="this.className='button-off';"
					tabindex=11>

						<input type="hidden" name="loginButton.DisabledHiddenField" value="true" /><br>
						</span>
					  </div>
					</td>
                  </tr>
                  <tr>
                    <td align="center" valign="bottom">
						<br />
						<span class="link5" onclick="getRequest(null,'index.php?mod=Public&act=frUsername&do=9','main_area');">Forgot Username</span> | <span class="link5" onclick="getRequest(null,'index.php?mod=Public&act=frPassword&do=9','main_area');">Forgot Password</span>
					</td>
                  </tr>
                </table>
				</form>
				<? if ($_GET["act"] == "login") { ?>
				<br />
				<table border="0" width="259" cellspacing="1" cellpadding="1" style="border-top: 1px #BEBEBE solid;border-bottom: 1px #BEBEBE solid;border-left: 1px #BEBEBE solid;border-right: 1px #BEBEBE solid;background:#EEEEEE; padding:10px;">
					<tr>
						<td valign="top" align="center">
						<span style="font-weight:bold;">No Account ? <br />
						<span class="link5" style="cursor:pointer;" onclick="getRequest(null,'index.php?mod=Public&act=frUser&do=9','main_area');">Sign up for a <?=APPS_NAME;?> account</span></span>
						</td>
					</tr>
				</table>
				<? } ?>