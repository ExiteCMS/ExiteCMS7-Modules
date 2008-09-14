<? $SearchPanel->Render(); ?>

<form name="formApps1" method="post" action="#">
<input type="hidden" name="ref" value="0">
<input type="hidden" name="frType" value="">	

<? $actions->RenderScript(); ?>


<table border="0" cellpadding="0" cellspacing="0" width="100%" align="Center">
	<tr>
		<td width="100%" align="left">					
			<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
			<tr>
				<td align="left" width="50%">
				<? $actions->RenderButton();?>
				</td>
				<td align="right" width="50%">
					<table border="0" cellpadding="0" cellspacing="0">
						<tr><td colspan="5"><img src="images/spacer.gif" height="5"></td></tr>
					</table>
				</td>
			</tr>
			</table>

			<script>
			disableAllBtn();
			</script>		 

		</td>
		<td align="right" nowrap="nowrap">
			<? 
				if ($obj->getLastPageNumber() == "" || $obj->getLastPageNumber() == "-1") { 
					$last_page = "";
				}
				else {
					$last_page = $obj->getLastPageNumber();
				}
			?>
			<? if ($last_page != "") { ?>	
			<b>Page <?=$show;?> / <?=$last_page; ?></b>
			<? } ?>
		</td>
	</tr>
</table>

<div class="TblMgn">

<table class="Tbl" border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
<caption class="TblTtlTxt">Gallery</caption>
<tbody>
	<tr>
		<th class="TblColHdrSrt" scope="col" align="center"  width="3%" nowrap><div class="TblHeader"><a href="#" title="Select All"><img src="images/check_all.gif" onclick="javascript:formCheckAll(document.formApps1);" border="0" style="cursor:pointer;" alt="Select All"></a><a href="#" title="Deselect All"><img src="images/uncheck_all.gif" onclick="javascript:formUnCheckAll(document.formApps1);" style="cursor:pointer;" border="0" alt="Deselect All"></a></div></th>
		<th class="TblColHdrSrt" scope="col" align="left" >
			<div class="TblHeader">Album</div>
		</th>
		<th class="TblColHdrSrt" scope="col" align="center" >
			<div class="TblHeaderCenter">Access</div>
		</th>
		<th class="TblColHdrSrt" scope="col" align="center" >
			<div class="TblHeaderCenter">Groups</div>
		</th>
		<th class="TblColHdrSrt" scope="col" align="center" >
			<div class="TblHeaderCenter">Users</div>
		</th>
	</tr>

	<? while (!$list->EOF) { ?>
	<tr>
		<td class="TblTdSrt" align="center"  valign="top" width="30" nowrap>
			<input class="Cb" type="checkbox" name="params[]" value="<?=$list->fields($obj->GalleryAlbumId);?>" onclick="javascript:toggleDisableButton(this.form,this);">
		</td>
		<td class="TblTdSrt" align="left"  valign="top">
			<?=$list->fields("CONTENTS");?>
		</td>
		<td class="TblTdSrt" align="center"  valign="top" nowrap width="100">
			<?=$list->fields($obj->Access);?>
		</td>
		<td class="TblTdSrt" align="center"  valign="top" nowrap width="100">
			<?
				$grp = $grp_access->findAllGroup($list->fields($obj->GalleryAlbumId));
			?>
			<? if ($grp->RecordCount() > 0) { ?>
				<span class="link3" style="cursor:pointer;" onmouseover="Tip('Click here to edit group privileges');this.className='link1';" onmouseout="UnTip();this.className='link3';" onclick="UnTip();ModalPopup('group_access_<?=$list->fields($obj->GalleryAlbumId);?>');"><img src="images/Document.gif" /></span>

				<div id="group_access_<?=$list->fields($obj->GalleryAlbumId);?>" style="background:#F2F5F7;border:2px solid #5E89CB;width:425px;height:425px;overflow:auto;visibility:hidden;position:absolute;z-index:10;display:none;" title="Group Access:: <?=$list->fields($obj->GalleryAlbumTitle);?>">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr><td background="images/bar1.png" style="background-repeat:repeat-x;" align="right" valign="middle">
					<span class="link3" style="cursor:pointer;" onmouseover="this.className='link1';" onmouseout="this.className='link3';" onclick="ModalPopup.Close('group_access_<?=$list->fields($obj->GalleryAlbumId);?>');" title="Close"><img src="images/close.png" /></span>
					</td>
				</tr></table>
				<br />
				<?
					while (!$grp->EOF) {
						$ls = $grp_access->findByAlbum($list->fields($obj->GalleryAlbumId),$grp->fields($grp_access->VmtGroupId));
						$INSERT = false;
						$EDIT = false;
						$DELETE = false;
						$READ_ONLY = false;
						while (!$ls->EOF) {
							switch($ls->fields($grp_access->AccessRefId)) {
								case 1:
									$INSERT = true;
								break;
								case 2:
									$EDIT = true;
								break;
								case 3:
									$DELETE = true;
								break;
								case 4:
									$READ_ONLY = true;
								break;
							}
							$ls->MoveNext();
						}
				?>
					<div id="priv_grp_<?=$grp->fields($obj2->VmtGroupId);?>_<?=$list->fields($obj->GalleryAlbumId);?>">
					<table border="0" style="background-color:#FFFFCC;" cellpadding="2" cellspacing="0" align="center" width="400" title="<?=$grp->fields($obj2->VmtGroupNama);?>">
					<caption class="TblTtlTxt2"><?=$grp->fields($obj2->VmtGroupNama);?></caption>
					<tr>
						<td align="center" style="background-color:#8D8D8D;color:#FFFFFF;font-weight:bold;font-size:11px;" width="100">
							Insert
						</td>
						<td align="center" style="background-color:#8D8D8D;color:#FFFFFF;font-weight:bold;font-size:11px;" width="100">
							Edit
						</td style="background-color:#8D8D8D;color:#FFFFFF;font-weight:bold;font-size:11px;" width="100">
						<td align="center" style="background-color:#8D8D8D;color:#FFFFFF;font-weight:bold;font-size:11px;" width="100">
							Delete
						</td>
						<td align="center" style="background-color:#8D8D8D;color:#FFFFFF;font-weight:bold;font-size:11px;" width="100">
							Read-Only
						</td>
					</tr>
					<tr>
						<td align="center" onmouseover="Tip('Click here to add / remove<br /> this privilege');" onmouseout="UnTip();" style="cursor:pointer;" onclick="UnTip();getRequest(null,'index.php?mod=Master&act=doUpdatePrivGrp&do=1&grp_id=<?=$grp->fields($obj2->VmtGroupId);?>&gal_id=<?=$list->fields($obj->GalleryAlbumId);?>&priv_id=1',null);">
						<span id="insert_grp_<?=$grp->fields($obj2->VmtGroupId);?>_<?=$list->fields($obj->GalleryAlbumId);?>"><?if ($INSERT) { ?><img src="images/check.png" /><?}?>&nbsp;</span></td>

						<td align="center"  onmouseover="Tip('Click here to add / remove<br /> this privilege');" onmouseout="UnTip();"  style="cursor:pointer;" onclick="UnTip();getRequest(null,'index.php?mod=Master&act=doUpdatePrivGrp&do=1&grp_id=<?=$grp->fields($obj2->VmtGroupId);?>&gal_id=<?=$list->fields($obj->GalleryAlbumId);?>&priv_id=2',null);">
						<span id="edit_grp_<?=$grp->fields($obj2->VmtGroupId);?>_<?=$list->fields($obj->GalleryAlbumId);?>"><?if ($EDIT) { ?><img src="images/check.png" /><?}?>&nbsp;</span></td>

						<td align="center"  onmouseover="Tip('Click here to add / remove<br /> this privilege');" onmouseout="UnTip();"  style="cursor:pointer;" onclick="UnTip();getRequest(null,'index.php?mod=Master&act=doUpdatePrivGrp&do=1&grp_id=<?=$grp->fields($obj2->VmtGroupId);?>&gal_id=<?=$list->fields($obj->GalleryAlbumId);?>&priv_id=3',null);">
						<span id="delete_grp_<?=$grp->fields($obj2->VmtGroupId);?>_<?=$list->fields($obj->GalleryAlbumId);?>"><?if ($DELETE) { ?><img src="images/check.png" /><?}?>&nbsp;</span></td>

						<td align="center"  onmouseover="Tip('Click here to add / remove<br /> this privilege');" onmouseout="UnTip();"  style="cursor:pointer;" onclick="UnTip();getRequest(null,'index.php?mod=Master&act=doUpdatePrivGrp&do=1&grp_id=<?=$grp->fields($obj2->VmtGroupId);?>&gal_id=<?=$list->fields($obj->GalleryAlbumId);?>&priv_id=4',null);">
						<span id="read_only_grp_<?=$grp->fields($obj2->VmtGroupId);?>_<?=$list->fields($obj->GalleryAlbumId);?>"><?if ($READ_ONLY) { ?><img src="images/check.png" /><?}?>&nbsp;</span></td>
					</tr>
					</table>
					<table border="0" style="background-color:#FFFFCC;" cellpadding="2" cellspacing="0" align="center" width="400">
					<tr>
					<td align="right">
						<span align="right" style="cursor:pointer;"  onmouseover="Tip('Click here to remove this group');" onmouseout="UnTip();"  onclick="UnTip();getRequest(null,'index.php?mod=Master&act=doDeletePrivGrp&do=1&grp_id=<?=$grp->fields($obj2->VmtGroupId);?>&gal_id=<?=$list->fields($obj->GalleryAlbumId);?>',null);"><img src="images/trash.gif" /></span>
					</td>
					</tr>
					</table>
					</div>
					<br />
				<?
					$grp->MoveNext();
				}
				?>
				</div>
			<? } ?>
		</td>
		<td class="TblTdSrt" align="center"  valign="top" nowrap width="100">
			<?
				$usr = $usr_access->findAllUser($list->fields($obj->GalleryAlbumId));
			?>
			<? if ($usr->RecordCount() > 0) { ?>
				<span class="link3" style="cursor:pointer;" onmouseover="Tip('Click here to edit user privileges');this.className='link1';" onmouseout="UnTip();this.className='link3';" onclick="UnTip();ModalPopup('user_access_<?=$list->fields($obj->GalleryAlbumId);?>');"><img src="images/Document.gif" /></span>

				<div id="user_access_<?=$list->fields($obj->GalleryAlbumId);?>" style="background:#F2F5F7;border:2px solid #5E89CB;width:425px;height:425px;overflow:auto;visibility:hidden;position:absolute;z-index:10;display:none;" title="User Access:: <?=$list->fields($obj->GalleryAlbumTitle);?>">
				
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr><td background="images/bar1.png" style="background-repeat:repeat-x;" align="right" valign="middle">
					<span class="link3" style="cursor:pointer;" onmouseover="this.className='link1';" onmouseout="this.className='link3';" onclick="ModalPopup.Close('user_access_<?=$list->fields($obj->GalleryAlbumId);?>');" title="Close"><img src="images/close.png" /></span>
					</td>
				</tr></table>
				<br />
				<?
					while (!$usr->EOF) {
						$ls = $usr_access->findByAlbum($list->fields($obj->GalleryAlbumId),$usr->fields($usr_access->VmtUserId));
						$INSERT = false;
						$EDIT = false;
						$DELETE = false;
						$READ_ONLY = false;
						while (!$ls->EOF) {
							switch($ls->fields($usr_access->AccessRefId)) {
								case 1:
									$INSERT = true;
								break;
								case 2:
									$EDIT = true;
								break;
								case 3:
									$DELETE = true;
								break;
								case 4:
									$READ_ONLY = true;
								break;
							}
							$ls->MoveNext();
						}
				?>
					<div id="priv_usr_<?=$usr->fields($obj3->VmtUserId);?>_<?=$list->fields($obj->GalleryAlbumId);?>">
					<table border="0" style="background-color:#FFFFCC;" cellpadding="2" cellspacing="0" align="center" width="400" title="<?=$usr->fields($obj3->VmtUserLogin);?>">
					<caption class="TblTtlTxt2"><?=$usr->fields($obj3->VmtUserLogin);?></caption>
					<tr>
						<td align="center" style="background-color:#8D8D8D;color:#FFFFFF;font-weight:bold;font-size:11px;" width="100">
							Insert
						</td>
						<td align="center" style="background-color:#8D8D8D;color:#FFFFFF;font-weight:bold;font-size:11px;" width="100">
							Edit
						</td style="background-color:#8D8D8D;color:#FFFFFF;font-weight:bold;font-size:11px;" width="100">
						<td align="center" style="background-color:#8D8D8D;color:#FFFFFF;font-weight:bold;font-size:11px;" width="100">
							Delete
						</td>
						<td align="center" style="background-color:#8D8D8D;color:#FFFFFF;font-weight:bold;font-size:11px;" width="100">
							Read-Only
						</td>
					</tr>
					<tr>
						<td align="center"  onmouseover="Tip('Click here to add / remove<br /> this privilege');" onmouseout="UnTip();"  style="cursor:pointer;" onclick="UnTip();getRequest(null,'index.php?mod=Master&act=doUpdatePrivUsr&do=1&usr_id=<?=$usr->fields($obj3->VmtUserId);?>&gal_id=<?=$list->fields($obj->GalleryAlbumId);?>&priv_id=1',null);">
						<span id="insert_usr_<?=$usr->fields($obj3->VmtUserId);?>_<?=$list->fields($obj->GalleryAlbumId);?>"><?if ($INSERT) { ?><img src="images/check.png" /><?}?>&nbsp;</span></td>

						<td align="center"  onmouseover="Tip('Click here to add / remove<br /> this privilege');" onmouseout="UnTip();"  style="cursor:pointer;" onclick="UnTip();getRequest(null,'index.php?mod=Master&act=doUpdatePrivUsr&do=1&usr_id=<?=$usr->fields($obj3->VmtUserId);?>&gal_id=<?=$list->fields($obj->GalleryAlbumId);?>&priv_id=2',null);">
						<span id="edit_usr_<?=$usr->fields($obj3->VmtUserId);?>_<?=$list->fields($obj->GalleryAlbumId);?>"><?if ($EDIT) { ?><img src="images/check.png" /><?}?>&nbsp;</span></td>

						<td align="center"  onmouseover="Tip('Click here to add / remove<br /> this privilege');" onmouseout="UnTip();"  style="cursor:pointer;" onclick="UnTip();getRequest(null,'index.php?mod=Master&act=doUpdatePrivUsr&do=1&usr_id=<?=$usr->fields($obj3->VmtUserId);?>&gal_id=<?=$list->fields($obj->GalleryAlbumId);?>&priv_id=3',null);">
						<span id="delete_usr_<?=$usr->fields($obj3->VmtUserId);?>_<?=$list->fields($obj->GalleryAlbumId);?>"><?if ($DELETE) { ?><img src="images/check.png" /><?}?>&nbsp;</span></td>

						<td align="center"  onmouseover="Tip('Click here to add / remove<br /> this privilege');" onmouseout="UnTip();"  style="cursor:pointer;" onclick="UnTip();getRequest(null,'index.php?mod=Master&act=doUpdatePrivUsr&do=1&usr_id=<?=$usr->fields($obj3->VmtUserId);?>&gal_id=<?=$list->fields($obj->GalleryAlbumId);?>&priv_id=4',null);">
						<span id="read_only_usr_<?=$usr->fields($obj3->VmtUserId);?>_<?=$list->fields($obj->GalleryAlbumId);?>"><?if ($READ_ONLY) { ?><img src="images/check.png" /><?}?>&nbsp;</span></td>
					</tr>
					</table>
					<table border="0" style="background-color:#FFFFCC;" cellpadding="2" cellspacing="0" align="center" width="400">
					<tr>
					<td align="right">
						<span align="right" style="cursor:pointer;"  onmouseover="Tip('Click here to remove this user');" onmouseout="UnTip();"  onclick="UnTip();getRequest(null,'index.php?mod=Master&act=doDeletePrivUsr&do=1&usr_id=<?=$usr->fields($obj3->VmtUserId);?>&gal_id=<?=$list->fields($obj->GalleryAlbumId);?>',null);"><img src="images/trash.gif" /></span>
					</td>
					</tr>
					</table>
					</div>
					<br />
				<?
					$usr->MoveNext();
				}
				?>
				</div>
			<? } ?>
		</td>
	</tr>	
		<? $list->MoveNext(); ?>
	<? } ?>

	<tr>
		<td class="TblTdSrt2" colspan="5">
			<? $dataGrid->RenderPager("TblNav"); ?>
		</td>
	</tr>

</tbody>
</table>
</div>
</form>		