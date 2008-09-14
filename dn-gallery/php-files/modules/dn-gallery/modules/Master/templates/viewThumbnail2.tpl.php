				
			<div id="gallery_area">
				
				<?

					$gal = $_GET["gal"];
					if ($gal == "") {
						$kat = new GalleryAlbum();
						$ls_kat = $kat->getContent();
						$gal = $ls_kat->fields($kat->GalleryAlbumId);
					}
					if ($gal == "") {
						$gal = $ref;
					}
					$limit = 24;
					$obj = new GalleryFile();
					$obj->AjaxPager(true);
					$list = $obj->getFile($gal,$limit,$show);
				if ($list->RecordCount() > 0) {
				?>
				
				<table border="0" cellpadding="0" cellspacing="0" width="100%">
					<tr> 
						<td width="50%" align="left" nowrap valign="middle">
						&nbsp;
						</td>
						<td width="50%" align="right" nowrap valign="middle">
						<div id="gal_pager">
						<table border="0"><tr><td><? $obj->renderPrevious("index.php?mod=Master&act=viewThumbnail2&ref=".$ref."&gal=".$gal."","images/panah-galeri-kiri.png","images/panah-galeri-kiri-dis.png","gallery_area"); ?></td><td><? $obj->renderPageCombo("index.php?mod=Master&act=viewThumbnail2&ref=".$ref."&gal=".$gal."","gallery_area"); ?></td><td><? $obj->renderNext("index.php?mod=Master&act=viewThumbnail2&ref=".$ref."&gal=".$gal."","images/panah-galeri-kanan.png","images/panah-galeri-kanan-dis.png","gallery_area"); ?></td></tr></table>
						</div></td>
					  </tr>
				</table>
				<table class="Thumbnail-Container">
				
				<?
					$col = 1;
					$row=(($show - 1) * $limit) + 1;
					$start_loop = $row;
					$max_loop = $list->RecordCount();
					$row_count = 1;
					while (!$list->EOF) {

						$image_1 = $list->fields($obj->ThumbFile);
						$gallery_album_id = $list->fields($obj->GalleryAlbumId);

						if ($image_1 != "") {
							$size = resize_image($image_1,100,"w");
						}
						else {
							$image_1 = "images/spacer.gif";
							$size[0] = 100;
							$size[1] = 1;
						}
						if ($col == 1) {
					?>
						<tr>
							<td align="center" valign="top"  height="100">
								<table width="100" height="100">
								<tr>
									<td id="row_<?=$row;?>" valign="middle" align="center" class="thumbnail-off"
									onmouseover="this.className='thumbnail-on';" 
									onmouseout="this.className='thumbnail-off';"  height="100%" bgcolor="#f2f5f7">
									
									<img src="<?=$image_1;?>" onmouseover="Tip('Click here to select or deselect this photo');" onmouseout="UnTip();" width="<?=$size[0];?>" height="<?=$size[1];?>" onclick="UnTip();
									if (document.getElementById('row_<?=$row;?>').style.background == 'rgb(242, 245, 247) none repeat scroll 0% 0%' || document.getElementById('row_<?=$row;?>').style.background == '' || document.getElementById('row_<?=$row;?>').style.background == 'rgb(242, 245, 247)' || document.getElementById('row_<?=$row;?>').style.background == 'rgb(242,245,247)') {
										document.getElementById('row_<?=$row;?>').style.background = 'rgb(255, 255, 140) none repeat scroll 0% 0%';
										document.getElementById('PhotoTitle').value='<?=trim($list->fields($obj->PhotoTitle));?>';
										document.getElementById('Keywords').value='<?=trim($list->fields($obj->Keywords));?>';
										document.getElementById('PHOTO_SHOW').value='<?=$show;?>';
										<?
										$str = br2nl(trim($list->fields($obj->PhotoDesc)));
										$expl = explode("\r\n",$str);
										?>
										document.getElementById('PhotoDesc').value='';
										<?
										for ($x = 0;$x < sizeof($expl);$x++) {
											if ($x != sizeof($expl) - 1) {
										?>
										document.getElementById('PhotoDesc').value += '<?=$expl[$x];?>\r\n';
										<?
											}
											else {
										?>
										document.getElementById('PhotoDesc').value += '<?=$expl[$x];?>';
										<?
											}
										}
										?>
										document.getElementById('PHOTO_ID').value='<?=$list->fields($obj->Id);?>';

										for (i = <?=$start_loop;?>;i <= <?=($start_loop + $max_loop - 1);?>;i++) {
											if (document.getElementById('row_'+i).id != 'row_<?=$row;?>') {
												document.getElementById('row_'+i).style.background = 'rgb(242, 245, 247) none repeat scroll 0% 0%';
											}
										}
									}
									else {
										document.getElementById('row_<?=$row;?>').style.background = 'rgb(242, 245, 247) none repeat scroll 0% 0%';
										document.getElementById('PhotoTitle').value='';
										document.getElementById('PhotoDesc').value='';
										document.getElementById('Keywords').value='';
										document.getElementById('PHOTO_ID').value='';
										document.getElementById('PHOTO_SHOW').value='<?=$show;?>';
									}
									" style="cursor:pointer;">
									<? if ($Owner == $uid  || array_key_exists("1",$_SESSION["gid"]) || $priv1["DELETE"] || $priv2["DELETE"]) { ?>
										<br><div align="right"><img style="cursor:pointer;" src="images/trash.gif" align="center" onmouseover="Tip('Click here to delete this photo!');" onmouseout="UnTip();" onclick="UnTip();getRequest(null,'index.php?mod=Master&act=deletePhoto&ref=<?=$list->fields($obj->Id);?>&do=1&show=<?=$show;?>',null);" />
									</div>
									<? } ?>
									</td>
								</tr>
								</table>
							</td>
					<?
							$col++;
						}
						elseif ($col % 8 == 0) {
					?>	
							<td align="center" valign="top"  height="100" >
								<table width="100" height="100">
								<tr>
									<td id="row_<?=$row;?>" valign="middle" align="center" class="thumbnail-off"
									onmouseover="this.className='thumbnail-on';" 
									onmouseout="this.className='thumbnail-off';"  height="100%" bgcolor="#f2f5f7">
									
									<img src="<?=$image_1;?>" onmouseover="Tip('Click here to select or deselect this photo');" onmouseout="UnTip();" width="<?=$size[0];?>" height="<?=$size[1];?>" onclick="UnTip();
									
									if (document.getElementById('row_<?=$row;?>').style.background == 'rgb(242, 245, 247) none repeat scroll 0% 0%' || document.getElementById('row_<?=$row;?>').style.background == '' || document.getElementById('row_<?=$row;?>').style.background == 'rgb(242, 245, 247)' || document.getElementById('row_<?=$row;?>').style.background == 'rgb(242,245,247)') {
										document.getElementById('row_<?=$row;?>').style.background = 'rgb(255, 255, 140) none repeat scroll 0% 0%';
										document.getElementById('PhotoTitle').value='<?=trim($list->fields($obj->PhotoTitle));?>';
										document.getElementById('Keywords').value='<?=trim($list->fields($obj->Keywords));?>';
										document.getElementById('PHOTO_SHOW').value='<?=$show;?>';
										<?
										$str = br2nl(trim($list->fields($obj->PhotoDesc)));
										$expl = explode("\r\n",$str);
										?>
										document.getElementById('PhotoDesc').value='';
										<?
										for ($x = 0;$x < sizeof($expl);$x++) {
											if ($x != sizeof($expl) - 1) {
										?>
										document.getElementById('PhotoDesc').value += '<?=$expl[$x];?>\r\n';
										<?
											}
											else {
										?>
										document.getElementById('PhotoDesc').value += '<?=$expl[$x];?>';
										<?
											}
										}
										?>
										document.getElementById('PHOTO_ID').value='<?=$list->fields($obj->Id);?>';

										for (i = <?=$start_loop;?>;i <= <?=($start_loop + $max_loop - 1);?>;i++) {
											if (document.getElementById('row_'+i).id != 'row_<?=$row;?>') {
												document.getElementById('row_'+i).style.background = 'rgb(242, 245, 247) none repeat scroll 0% 0%';
											}
										}
									}
									else {
										document.getElementById('row_<?=$row;?>').style.background = 'rgb(242, 245, 247) none repeat scroll 0% 0%';
										document.getElementById('PhotoTitle').value='';
										document.getElementById('PhotoDesc').value='';
										document.getElementById('Keywords').value='';
										document.getElementById('PHOTO_ID').value='';
										document.getElementById('PHOTO_SHOW').value='<?=$show;?>';
									}
									
									" style="cursor:pointer;">
									<? if ($Owner == $uid  || array_key_exists("1",$_SESSION["gid"]) || $priv1["DELETE"] || $priv2["DELETE"]) { ?>
										<br><div align="right"><img style="cursor:pointer;" src="images/trash.gif" align="center" onmouseover="Tip('Click here to delete this photo!');" onmouseout="UnTip();" onclick="UnTip();getRequest(null,'index.php?mod=Master&act=deletePhoto&ref=<?=$list->fields($obj->Id);?>&do=1&show=<?=$show;?>',null);" /></div>
									<?}?>
									</td>
								</tr>
								</table>
							</td>
						</tr>
					<?
							$col = 1;
						}
						else {
					?>	
							<td align="center" valign="top"  height="100">
								<table width="100" height="100">
								<tr>
									<td id="row_<?=$row;?>" valign="middle" align="center" class="thumbnail-off"
									onmouseover="this.className='thumbnail-on';" 
									onmouseout="this.className='thumbnail-off';"  height="100%" bgcolor="#f2f5f7">
									
									<img src="<?=$image_1;?>" onmouseover="Tip('Click here to select or deselect this photo');" onmouseout="UnTip();" width="<?=$size[0];?>" height="<?=$size[1];?>" onclick="UnTip();
									if (document.getElementById('row_<?=$row;?>').style.background == 'rgb(242, 245, 247) none repeat scroll 0% 0%' || document.getElementById('row_<?=$row;?>').style.background == '' || document.getElementById('row_<?=$row;?>').style.background == 'rgb(242, 245, 247)' || document.getElementById('row_<?=$row;?>').style.background == 'rgb(242,245,247)') {
										document.getElementById('row_<?=$row;?>').style.background = 'rgb(255, 255, 140) none repeat scroll 0% 0%';
										document.getElementById('PhotoTitle').value='<?=trim($list->fields($obj->PhotoTitle));?>';
										document.getElementById('Keywords').value='<?=trim($list->fields($obj->Keywords));?>';
										document.getElementById('PHOTO_SHOW').value='<?=$show;?>';
										<?
										$str = br2nl(trim($list->fields($obj->PhotoDesc)));
										$expl = explode("\r\n",$str);
										?>
										document.getElementById('PhotoDesc').value='';
										<?
										for ($x = 0;$x < sizeof($expl);$x++) {
											if ($x != sizeof($expl) - 1) {
										?>
										document.getElementById('PhotoDesc').value += '<?=$expl[$x];?>\r\n';
										<?
											}
											else {
										?>
										document.getElementById('PhotoDesc').value += '<?=$expl[$x];?>';
										<?
											}
										}
										?>
										document.getElementById('PHOTO_ID').value='<?=$list->fields($obj->Id);?>';

										for (i = <?=$start_loop;?>;i <= <?=($start_loop + $max_loop - 1);?>;i++) {
											if (document.getElementById('row_'+i).id != 'row_<?=$row;?>') {
												document.getElementById('row_'+i).style.background = 'rgb(242, 245, 247) none repeat scroll 0% 0%';
											}
										}
									}
									else {
										document.getElementById('row_<?=$row;?>').style.background = 'rgb(242, 245, 247) none repeat scroll 0% 0%';
										document.getElementById('PhotoTitle').value='';
										document.getElementById('PhotoDesc').value='';
										document.getElementById('Keywords').value='';
										document.getElementById('PHOTO_ID').value='';
										document.getElementById('PHOTO_SHOW').value='<?=$show;?>';
									}
									
									" style="cursor:pointer;">
									<? if ($Owner == $uid  || array_key_exists("1",$_SESSION["gid"]) || $priv1["DELETE"] || $priv2["DELETE"]) { ?>
										<br><div align="right"><img style="cursor:pointer;" src="images/trash.gif" align="center" onmouseover="Tip('Click here to delete this photo!');" onmouseout="UnTip();" onclick="UnTip();getRequest(null,'index.php?mod=Master&act=deletePhoto&ref=<?=$list->fields($obj->Id);?>&do=1&show=<?=$show;?>',null);" /></div>
									<?}?>
									</td>
								</tr>
								</table>
							</td>
					<?
							$col++;
						}
						$row++;
						$row_count++;
						$list->MoveNext();
					}

				if ($row_count < 8 || $row_count < 16 || $row_count < 24) { ?>
						
					<?	
						
						if ($row_count < 8) { 
							$max = 8;
						}
						elseif ($row_count < 16) { 
							$max = 16;
						}
						elseif ($row_count < 24) { 
							$max = 24;
						}
						for ($i=$row_count;$i<=$max;$i++) { 
							?>
								<td></td>
						<? } ?>

					</tr>
				<? }

				if ($row_count <= 9) {
				?>
						<tr>
							<td align="center" valign="top"  height="200" colspan="8">
							&nbsp;
							</td>
						</tr>
				<?
				}
				elseif ($row_count <= 17) {
				?>
						<tr>
							<td align="center" valign="top"  height="100" colspan="8">
							&nbsp;
							</td>
						</tr>
				<?
				}
				?>
				</table>
				<? } ?>
			</div>