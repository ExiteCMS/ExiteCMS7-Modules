
<script>

			function uploadForm(fr) {
				fr.action="index.php?mod=Master&act=frGal&frType=<?=$frType;?>&ref=<?=$ref;?>&src1=<?=$src1;?>&do=1";	
				fr.submit();
			}
			</script>
		
<form name="formApps1" enctype="multipart/form-data" method="POST" target="_upload_frame">
<input type="hidden" name="isSubmitted" value="<?=$isSubmitted;?>">
<input type="hidden" id="_ID" name="_ID" value="<?=$_ID;?>">
<input type="hidden" id="PHOTO_ID" name="PHOTO_ID" value="<?=$PHOTO_ID;?>">
<input type="hidden" id="PHOTO_SHOW" name="PHOTO_SHOW" value="<?=$PHOTO_SHOW;?>">
<input type="hidden" name="frType" value="<?=$frType;?>">
<input type="hidden" name="ref" value="<?=$ref;?>">
<input type="hidden" name="src1" value="<?=$src1;?>">
<input type="hidden" name="Owner" id="Owner" value="<?=$form->fields[$obj->Owner];?>">
<br>

	<table cellpadding="3" cellspacing="0" width="90%" align="center">
	
	

			<tr bgcolor="#E6E6E6">
			<td valign="top" align="left" width="150" nowrap>
				<span class="LblLev2Txt">Album Title</span>
			</td> 
			  <td valign="middle" width="100%" align="left">
				<? if ($form->fields[$obj->Owner] == $uid || array_key_exists("1",$_SESSION["gid"]) || $_ID == "-1") { ?>
					<input class="TxtFld" size="56" type="text" name="GalleryAlbumTitle" value="<?=trim($form->fields[$obj->GalleryAlbumTitle]);?>">
				<? } else { ?>
					<input class="TxtFldDis" readonly size="56" type="text" name="GalleryAlbumTitle" value="<?=trim($form->fields[$obj->GalleryAlbumTitle]);?>">
				<? } ?>
				</td>
			 </tr>
			<tr bgcolor="#E6E6E6">
			<td valign="top" align="left" width="150" nowrap>
				<span class="LblLev2Txt">Album Description</span>
			</td> 
			  <td valign="middle" align="left">
				<? if ($form->fields[$obj->Owner] == $uid || array_key_exists("1",$_SESSION["gid"]) || $_ID == "-1") { ?>
					<textarea class="TxtFld" cols="53" rows="5" name="GalleryAlbumDesc"><?=br2nl(trim($form->fields[$obj->GalleryAlbumDesc]));?></textarea>
				<? } else { ?>
					<textarea class="TxtFldDis" readonly cols="53" rows="5" name="GalleryAlbumDesc"><?=br2nl(trim($form->fields[$obj->GalleryAlbumDesc]));?></textarea>
				<? } ?>
				</td>
			 </tr>
			<? if ($form->fields[$obj->Owner] == $uid || array_key_exists("1",$_SESSION["gid"]) || $_ID == "-1") { ?>
				<tr>
				<td valign="top" align="left" width="150" nowrap>
					<span class="LblLev2Txt">Icon</span>
				</td> 
				  <td valign="middle" width="100%" align="left" nowrap>
					<input class="TxtFld" size="46" type="file" id="GalleryAlbumIcon" name="GalleryAlbumIcon" value="">
					</td>
				 </tr>
				<? } else {?>
					<input type="hidden" id="GalleryAlbumIcon" name="GalleryAlbumIcon" value="">
				<? } ?>
			<? if ($form->fields[$obj->Owner] == $uid || $priv1["INSERT"] || $priv1["EDIT"] || $priv2["INSERT"] || $priv2["EDIT"] || $_ID == "-1" || array_key_exists("1",$_SESSION["gid"])) { ?>
			<tr>
			<td valign="top" align="left" width="150" nowrap>
				&nbsp;
			</td> 
			  <td valign="middle" align="left">
				&nbsp;</td>
			 </tr>
			<tr>
			<td valign="top" align="left" width="150" nowrap>
				<span class="LblLev2Txt">Photo Title</span>
			</td> 
			  <td valign="middle" width="100%" align="left">
				<input class="TxtFld" size="56" type="text" name="PhotoTitle" id="PhotoTitle" value="">
				</td>
			 </tr>
			<tr>
			<td valign="top" align="left" width="150" nowrap>
				<span class="LblLev2Txt">Photo Description</span>
			</td> 
			  <td valign="middle" align="left">
				<textarea class="TxtFld" cols="53" rows="5" name="PhotoDesc" id="PhotoDesc"></textarea>
				</td>
			 </tr>
			<tr bgcolor="#E6E6E6">
			<td valign="top" align="left" width="150" nowrap>
				<span class="LblLev2Txt">Keywords</span>
			</td> 
			  <td valign="middle" align="left">
					<input class="TxtFld" size="56" type="text" name="Keywords" id="Keywords" value="" onmouseover="Tip('Enter your keywords separated by comma');" onmouseout="UnTip();">
				</td>
			 </tr>
			<tr>
			<td valign="top" align="left" width="150" nowrap>
				<span class="LblLev2Txt">Upload Photo</span>
				<br><span class="LblLev2Txt" style="font-style:italic;font-size:10px;">*)Image or zip file</span>
			</td> 
			  <td valign="top" width="100%" align="left" nowrap>
				<input class="TxtFld" size="46" type="file" id="GalleryFile" name="GalleryFile" value="" onmouseover="Tip('Zip file will add new photos and will not replace existing photos');" onmouseout="UnTip();">
				<iframe id="_upload_frame" name="_upload_frame" style="visibility:hidden;" width="1" height="1"></iframe>
				</td>
			 </tr>
			 <? } ?>
			<tr>
			<td valign="top" align="left" width="150" nowrap>
				&nbsp;
			</td> 
			  <td valign="middle" width="100%" align="left" nowrap>
				<? if ($form->fields[$obj->Owner] == $uid || $priv1["INSERT"] || $priv1["EDIT"] || $priv2["INSERT"] || $priv2["EDIT"] || $_ID == "-1" || array_key_exists("1",$_SESSION["gid"])) { ?>
				<input type="button"
					 class="Btn1Def" value="Save / Upload"
					 onmouseover="javascript: if (this.disabled==0) this.className='Btn1Hov'" 
					onmouseout="javascript: if (this.disabled==0) this.className='Btn1'" 
					onblur="javascript: if (this.disabled==0) this.className='Btn1'" 
					onfocus="javascript: if (this.disabled==0) this.className='Btn1Hov'"
					 name="btAktif2"
					 id="btAktif2"
					 onclick="ModalPopup('PopUpload');uploadForm(this.form);"
					 >&nbsp;
				<? } ?>
				<input type="button"
					 class="Btn1Def" value="Back"
					 onmouseover="javascript: if (this.disabled==0) this.className='Btn1Hov'" 
					onmouseout="javascript: if (this.disabled==0) this.className='Btn1'" 
					onblur="javascript: if (this.disabled==0) this.className='Btn1'" 
					onfocus="javascript: if (this.disabled==0) this.className='Btn1Hov'"
					 name="btAktif2"
					 id="btAktif2"
					 onclick="location.href='index.php?mod=Master&act=lsGal&src1=<?=$src1;?>';"
					 >
				</td>
			 </tr>
	</table>
	<table cellpadding="3" cellspacing="0" width="90%" align="center">
	<tr>
	<td bgcolor="#F2F5F7">
	<div id="gallery_area">
	&nbsp;
	</div>
	<? if ($_ID != "") { ?>
	<script>
	getRequest(null,'index.php?mod=Master&act=viewThumbnail2&ref=17&gal=<?=$_ID;?>&do=9','gallery_area');
	</script>
	<? } ?>
	</td>
	</tr>
	</table>
	
	<div id="PopUpload" style="margin:15px;width:300px;border:0px; background:transparent;display:none;color:#FFFFFF;text-align:center;">
				&nbsp;<br />
				<img src="images/loading2.gif" align="center" style="opacity: .50;-moz-opacity: 0.50;filter: alpha(opacity=50);" /><br />&nbsp;
				</div>
	
	<div id="PopUpInsert" style="font-family:Arial;margin:15px;width:500px;border:#FFFFFF 2px solid; background-color:#525252;display:none;color:#FFFFFF;font-size:16px;font-weight:bold;text-align:center;">
				&nbsp;<br />
				<img src="images/dialog-error.png" align="absmiddle" />&nbsp;You don't have enough privileges to add new photo !!
				<br />&nbsp;<br />
				<span style="font-family:Arial;text-decoration:underline;font-size:11px;color:#CCFFFF;cursor:pointer;" onclick="ModalPopup.Close('PopUpInsert');">Close</span>
				&nbsp;
				</div>
	
	<div id="PopUpEdit" style="font-family:Arial;margin:15px;width:500px;border:#FFFFFF 2px solid; background-color:#525252;display:none;color:#FFFFFF;font-size:16px;font-weight:bold;text-align:center;">
				&nbsp;<br />
				<img src="images/dialog-error.png" align="absmiddle" />&nbsp;You don't have enough privileges to edit this photo !!
				<br />&nbsp;<br />
				<span style="font-family:Arial;text-decoration:underline;font-size:11px;color:#CCFFFF;cursor:pointer;" onclick="ModalPopup.Close('PopUpEdit');">Close</span>
				&nbsp;
				</div>
	
	<div id="PopUpErrorUpload" style="font-family:Arial;margin:15px;width:500px;border:#FFFFFF 2px solid; background-color:#525252;display:none;color:#FFFFFF;font-size:16px;font-weight:bold;text-align:center;">
				&nbsp;<br />
				<img src="images/dialog-error.png" align="absmiddle" />&nbsp;<span id="ErrorMsgUpload">&nbsp;</span>
				<br />&nbsp;<br />
				<span style="font-family:Arial;text-decoration:underline;font-size:11px;color:#CCFFFF;cursor:pointer;" onclick="ModalPopup.Close('PopUpErrorUpload');">Close</span>
				&nbsp;
				</div>
</form>