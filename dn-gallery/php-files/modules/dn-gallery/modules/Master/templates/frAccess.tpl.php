
<script>

	function submitForm(fr) {
		fr.action="index.php?mod=Master&act=frAccess&frType=<?=$frType;?>&ref=<?=$ref;?>&src1=<?=$src1;?>&do=1";	
		fr.submit();
	}
	function AddOption(el1,el2,el3) {
		for (i=0;i<el1.options.length;i++) {
			if (el1.options[i].selected) {
				value = el1.options[i].value;
				caption = el1.options[i].text;
				exist = false;
				for (j=0;j<el2.options.length;j++) {
					if (value == el2.options[j].value && caption == el2.options[j].text) {
						exist = true;
					}
				}
				if (!exist) {
					var newElem = document.createElement("option");
					newElem.text = caption;
					newElem.value = value;
					el2.options.add(newElem);
				}
				el1.options[i].selected = false;
			}
		}
		opt = "";
		for (i=0;i<el2.options.length;i++) {
			opt += el2.options[i].value + ",";
		}
		el3.value = opt;
	}
	function AddAll(el1,el2,el3) {
		opt = "";
		for (i=0;i<el1.options.length;i++) {
			value = el1.options[i].value;
			caption = el1.options[i].text;
			exist = false;
			for (j=0;j<el2.options.length;j++) {
				if (value == el2.options[j].value && caption == el2.options[j].text) {
					exist = true;
				}
			}
			if (!exist) {
				var newElem = document.createElement("option");
				newElem.text = caption;
				newElem.value = value;
				el2.options.add(newElem);
			}
			el1.options[i].selected = false;

			opt += el1.options[i].value + ",";
		}
		el3.value = opt;
	}
	function RemoveOption(el,el3) {
		sel = 0;
		for (i=0;i<el.options.length;i++) {
			if (el.options[i].selected) {
				sel++;
			}
		}
		for (i=0;i<=sel;i++) {
			for (j=0;j<el.options.length;j++) {
				if (el.options[j].selected) {
					el.options[j] = null;
				}
			}
		}
		opt = "";
		for (i=0;i<el.options.length;i++) {
			opt += el.options[i].value + ",";
		}
		el3.value = opt;
	}
	function RemoveAll(el,el3) {
		for (i=el.options.length-1;i>=0;i--) {
			el.remove(i);
		}
		el3.value = "";
	}
</script>
<form name="formApps1" enctype="multipart/form-data" method="POST">
<input type="hidden" name="isSubmitted" value="<?=$isSubmitted;?>">
<input type="hidden" id="_ID" name="_ID" value="<?=$_ID;?>">
<input type="hidden" name="frType" value="<?=$frType;?>">
<input type="hidden" name="ref" value="<?=$ref;?>">
<input type="hidden" name="src1" value="<?=$src1;?>">
<input type="hidden" name="users" id="users" value="<?=$users;?>">
<input type="hidden" name="groups" id="groups" value="<?=$groups;?>">
<br>

	<table cellpadding="3" cellspacing="0" width="90%" align="center">
	
	

		<tr>
		<td valign="top" align="left" width="150" nowrap>
			<span class="LblLev2Txt">Album Title</span>
		</td> 
		  <td valign="middle" width="100%" align="left">
			<input class="TxtFldDis" readonly size="56" type="text" name="GalleryAlbumTitle" value="<?=$form->fields[$obj->GalleryAlbumTitle];?>">
			</td>
		 </tr>
		<tr>
		<td valign="top" align="left" width="150" nowrap>
			<span class="LblLev2Txt">Album Description</span>
		</td> 
		  <td valign="middle" align="left">
			<textarea class="TxtFldDis" readonly cols="53" rows="5" name="GalleryAlbumDesc"><?=br2nl($form->fields[$obj->GalleryAlbumDesc]);?></textarea>
			</td>
		 </tr>
		<tr>
		<td valign="top" align="left" width="150" nowrap>
			<span class="LblLev2Txt">Access</span>
		</td> 
		  <td valign="middle" width="100%" align="left" nowrap>
			<select style="width:115px;" name="Access" class="TxtFld" onchange='
				if (this.value == "CUSTOM" || this.value == "PUBLIC") {
					document.getElementById("access_priv").style.visibility="visible";
					document.getElementById("access_priv").style.display="block";
				}
				else {
					document.getElementById("access_priv").style.visibility="hidden";
					document.getElementById("access_priv").style.display="none";
				}
				'>
				<option value="PUBLIC" <? if ($form->fields[$obj->Access] == "PUBLIC") { ?> selected<?}?>>PUBLIC</option>
				<option value="PRIVATE" <? if ($form->fields[$obj->Access] == "PRIVATE") { ?> selected<?}?>>PRIVATE</option>
				<option value="CUSTOM" <? if ($form->fields[$obj->Access] == "CUSTOM") { ?> selected<?}?>>CUSTOM</option>
			</select>
			</td>
		 </tr>
			<tr>
			<td valign="top" align="left" width="150" nowrap>
				&nbsp;
			</td> 
			  <td valign="middle" width="100%" align="left" nowrap>
				<input type="button"
					 class="Btn1Def" value="Save"
					 onmouseover="javascript: if (this.disabled==0) this.className='Btn1Hov'" 
					onmouseout="javascript: if (this.disabled==0) this.className='Btn1'" 
					onblur="javascript: if (this.disabled==0) this.className='Btn1'" 
					onfocus="javascript: if (this.disabled==0) this.className='Btn1Hov'"
					 name="btAktif2"
					 id="btAktif2"
					 onclick="submitForm(this.form);"
					 >&nbsp;
				<input type="button"
					 class="Btn1Def" value="Back"
					 onmouseover="javascript: if (this.disabled==0) this.className='Btn1Hov'" 
					onmouseout="javascript: if (this.disabled==0) this.className='Btn1'" 
					onblur="javascript: if (this.disabled==0) this.className='Btn1'" 
					onfocus="javascript: if (this.disabled==0) this.className='Btn1Hov'"
					 name="btAktif2"
					 id="btAktif2"
					 onclick="location.href='index.php?mod=Master&act=lsAccess&src1=<?=$src1;?>';"
					 >
				</td>
			 </tr>
		<tr>
		<td colspan="2" align="left">
		<? if ($form->fields[$obj->Access] == "PRIVATE") { ?>
		<div id="access_priv" style="width:100%;height:250px;visibility:hidden;position:relative;z-index:10;display:none;padding-left:5px;padding-right:5px;padding-top:15px;padding-bottom:25px;">
		<? } else {?>
		<div id="access_priv" style="width:100%;height:250px;visibility:visible;position:relative;z-index:10;display:block;padding-left:5px;padding-right:5px;padding-top:15px;padding-bottom:25px;">
		<? } ?>
			<span id="grp_tab" class="tab-left-on" onclick="
				this.className='tab-left-on';
				document.getElementById('usr_tab').className='tab-right-off';
				document.getElementById('grp_tab_content').className='tab-on';
				document.getElementById('usr_tab_content').className='tab-off';
			">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Groups&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			</span><span id="usr_tab" class="tab-right-off" onclick="
				this.className='tab-right-on';
				document.getElementById('grp_tab').className='tab-left-off';
				document.getElementById('usr_tab_content').className='tab-on';
				document.getElementById('grp_tab_content').className='tab-off';
			">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Users&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			</span><br />
			<div id="grp_tab_content" class="tab-on">
				<table border="0" cellpadding="3" cellspacing="0">
					<tr>
						<td width="200" align="left">
							<strong>Available Group</strong>
						</td>
						<td width="32" align="center" valign="middle" rowspan="2">
							<img src="images/photo-right.png" width="16" height="16" style="cursor:pointer;" onclick="AddOption(document.getElementById('grp_list'),document.getElementById('grp_selected'),document.getElementById('groups'));"/>
							<br />
							<br />
							<img src="images/photo-left.png" width="16" height="16"  style="cursor:pointer;"  onclick="RemoveOption(document.getElementById('grp_selected'),document.getElementById('groups'));"/>

						</td>
						<td width="200" align="left">
							<strong>Selected</strong>
						</td>
					</tr>
					<tr>
						<td width="200" align="left">
							<? 
							$grp = new VmtGroup();
							$ls = $grp->findNonAdmin();
							?>
							<select name="grp_list" id="grp_list" class="TxtFld" style="z-index:0;width:200px;" multiple size="10">
								<?
								while (!$ls->EOF) {
								?>
								<option value="<?=$ls->fields($grp->VmtGroupId);?>"><?=$ls->fields($grp->VmtGroupNama);?></option>
								<?
									$ls->MoveNext();
								}
								?>
							</select>
							<span class="link3" style="cursor:pointer;" onmouseover="this.className='link1';" onmouseout="this.className='link3';" onclick="AddAll(document.getElementById('grp_list'),document.getElementById('grp_selected'),document.getElementById('groups'));">[Add All]</span>
						</td>
						<td width="200" align="left">
							<?
							$grpacc = new GroupAccess();
							$ls = $grpacc->findAllGroup($_ID);
							?>
							<select name="grp_selected" id="grp_selected" class="TxtFld" style="z-index:0;width:200px;" multiple size="10">
								<?
								$str = "";
								while (!$ls->EOF) {
								?>
								<option value="<?=$ls->fields($grpacc->VmtGroupId);?>"><?=$ls->fields($grp->VmtGroupNama);?></option>
								<?
									$str .= $ls->fields($grpacc->VmtGroupId).",";
									$ls->MoveNext();
								}
								?>
							</select>
							<script>document.getElementById('groups').value='<?=$str;?>';</script>
							<span class="link3" style="cursor:pointer;" onmouseover="this.className='link1';" onmouseout="this.className='link3';" onclick="RemoveAll(document.getElementById('grp_selected'),document.getElementById('groups'));">[Remove All]</span>
						</td>
					</tr>
				</table>
			</div>
			<div id="usr_tab_content" class="tab-off">
				<table border="0" cellpadding="3" cellspacing="0">
					<tr>
						<td width="200" align="left">
							<strong>Available User</strong>
						</td>
						<td width="32" align="center" valign="middle" rowspan="2">
							<img src="images/photo-right.png" width="16" height="16" style="cursor:pointer;" onclick="AddOption(document.getElementById('usr_list'),document.getElementById('usr_selected'),document.getElementById('users'));"/>
							<br />
							<br />
							<img src="images/photo-left.png" width="16" height="16"  style="cursor:pointer;"  onclick="RemoveOption(document.getElementById('usr_selected'),document.getElementById('users'));"/>
						</td>
						<td width="200" align="left">
							<strong>Selected</strong>
						</td>
					</tr>
					<tr>
						<td width="200" align="left">
							<? 
							$usr = new VmtUser();
							$ls = $usr->findNonAdmin();
							?>
							<select name="usr_list" id="usr_list" class="TxtFld" style="z-index:0;width:200px;" multiple size="10">
								<?
								while (!$ls->EOF) {
								?>
								<option value="<?=$ls->fields($usr->VmtUserId);?>"><?=$ls->fields($usr->VmtUserLogin);?></option>
								<?
									$ls->MoveNext();
								}
								?>
							</select>
							<span class="link3" style="cursor:pointer;" onmouseover="this.className='link1';" onmouseout="this.className='link3';" onclick="AddAll(document.getElementById('usr_list'),document.getElementById('usr_selected'),document.getElementById('users'));">[Add All]</span>
						</td>
						<td width="200" align="left">
							<?
							$usracc = new UserAccess();
							$ls = $usracc->findAllUser($_ID);
							?>
							<select name="usr_selected" id="usr_selected" class="TxtFld" style="z-index:0;width:200px;" multiple size="10">
								<?
								$str = "";
								while (!$ls->EOF) {
								?>
								<option value="<?=$ls->fields($usracc->VmtUserId);?>"><?=$ls->fields($usr->VmtUserLogin);?></option>
								<?
									$str .= $ls->fields($usracc->VmtUserId).",";
									$ls->MoveNext();
								}
								?>
							</select>
							<script>document.getElementById('users').value='<?=$str;?>';</script>
							<span class="link3" style="cursor:pointer;" onmouseover="this.className='link1';" onmouseout="this.className='link3';" onclick="RemoveAll(document.getElementById('usr_selected'),document.getElementById('users'));">[Remove All]</span>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<br />
		</td>
		</tr>

	</table>
</form>