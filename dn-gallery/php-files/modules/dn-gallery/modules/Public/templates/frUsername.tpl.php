				
	  
	  <table  width="95%" height="465" border="0" align="center" cellpadding="0" cellspacing="0">
	  <tr>
		<td valign="top" width="100%">
				<div id="gallery_area">
				
				<table width="100%" border="0" cellspacing="0" cellpadding="0" height="450">
				<tr> 
                <td align="center">
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
						<tr> 
							<td width="50%" align="left" nowrap valign="top" height="32">
								&nbsp;
							</td>
							<td width="50%" align="right" nowrap valign="top">
								<?include_once("templates/form_search.tpl.php");?>
							</td>
						  </tr>
					</table>
				</td>
              </tr>
              <tr> 
                <td class="SlideShow-Header">&nbsp;</td>
			  </tr>
              <tr> 
                <td class="SlideShow-Container" valign="middle" align="center">
					<table width="90%" border="0" cellspacing="0" cellpadding="0" height="350">
					
					<tr><td valign="top" align="center">
								
						<table border="0"cellpadding="0" cellspacing="0" align="center">
						<tr>
						<td align="left" valign="top" style="padding-left:50px;padding-right:20px;" width="50%">
							<span class="TitleBig">Forgot Username</span><br /><br />

							<span class="FontBig">Simply enter the email address you used to sign up, enter the verification code you see in the box, and we'll email your username to you.</span>
						</td>
						<td align="left" style="padding-left:20px;padding-right:50px;" width="50%">
							<? include_once("modules/Public/templates/frForgotUser.tpl.php"); ?>
							
						</td>
						</tr>
						</table>
				
				</td>
				</tr>

			</table>

			</td>
			</tr>
              <tr> 
                <td class="SlideShow-Footer">&nbsp;&nbsp;</td>
			  </tr>
				  <tr> 
					<td>&nbsp;</td>
				  </tr>
				  <tr> 
					<td>&nbsp;</td>
				  </tr>
			</table>
			</div>
	</td>
	</tr>
	</table>

	
	
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