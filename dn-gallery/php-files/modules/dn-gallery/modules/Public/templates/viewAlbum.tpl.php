				
	  
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
								<?
								switch($type) {
									case "featured":
								?>
										<span  class="Title1" onmouseout="this.className='Title1';">Featured Albums</span>
								<?
									break;
									case "most_viewed":
								?>
										<span  class="Title1" onmouseout="this.className='Title1';">Most Viewed Albums</span>
								<?
									break;
								}
								?>
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
                <td class="SlideShow-Container">
					<table width="100%" border="0" cellspacing="0" cellpadding="0" height="410">
			
			<?
				$col = 1;
				$row=(($show - 1) * $limit) + 1;
				$usr = new VmtUser();
				$obj2 = new GalleryFile();
				$row_count = 1;
				while (!$ls_obj->EOF) {
					$gal = $ls_obj->fields($obj->GalleryAlbumId);
					$image_1 = $ls_obj->fields($obj->GalleryAlbumIcon);
					if ($image_1 == "") {
						$obj2->clearFieldValue();
						$ls_obj2 = $obj2->getFile($ls_obj->fields($obj->GalleryAlbumId),1,$show);
						$image_1 = $ls_obj2->fields($obj2->ThumbFile);
					}

					if ($image_1 != "") {
						$size = resize_image($image_1,540,"w");
					}
					else {
						$image_1 = "images/spacer.gif";
						$size[0] = 488;
						$size[1] = 200;
					}

					if ($image_1 != "") {
						$size = resize_image($image_1,100,"w");
					}
					else {
						$image_1 = "images/spacer.gif";
						$size[0] = 100;
						$size[1] = 1;
					}
					
					$user_name = $usr->getVmtUserLogin($ls_obj->fields($obj->Owner));
					
					$obj2->clearFieldValue();
					$obj2->setGalleryAlbumId($ls_obj->fields($obj->GalleryAlbumId));
					$ls_photo = $obj2->selectRowByCriteria();
					$total_photos = $ls_photo->RecordCount();
					
										
					$tooltip_msg = "<table border=\'0\' width=\'250\'><tr><td><span class=\'ToolTipTitle\'>".$ls_obj->fields($obj->GalleryAlbumTitle)."</span><br /><span class=\'ToolTip\'>".eregi_replace("\r\n","",$ls_obj->fields($obj->GalleryAlbumDesc))."</span><br /><br /><span class=\'ToolTipItalic\'>Photo: ".$total_photos."<br />By: ".$user_name." (".$ls_obj->fields($obj->GalleryAlbumDate).")<br />Viewed: ".number_format($ls_obj->fields($obj->Viewed),0)."</span></td></tr></table>";

					if ($col == 1) {
				?>
					<tr>
						<td align="center" valign="top"  height="100">
							<table width="100" height="100">
							<tr>
								<td valign="middle" align="center" class="thumbnail-off" style="cursor:pointer;"
								onmouseover="Tip('<?=$tooltip_msg;?>');this.className='thumbnail-on';" 
								onmouseout="UnTip();this.className='thumbnail-off';"
								onclick="UnTip();getRequest(null,'index.php?mod=Public&act=addViewed&ref=<?=$ls_obj->fields($obj->GalleryAlbumId);?>&do=1',null);"
								height="100%">
									<img src="<?=$image_1;?>" width="<?=$size[0];?>" height="<?=$size[1];?>" />
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
								<td valign="middle" align="center" class="thumbnail-off" style="cursor:pointer;"
								onmouseover="Tip('<?=$tooltip_msg;?>');this.className='thumbnail-on';" 
								onmouseout="UnTip();this.className='thumbnail-off';"
								onclick="UnTip();getRequest(null,'index.php?mod=Public&act=addViewed&ref=<?=$ls_obj->fields($obj->GalleryAlbumId);?>&do=1',null);"
								height="100%">
									<img src="<?=$image_1;?>" width="<?=$size[0];?>" height="<?=$size[1];?>" />
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
								<td valign="middle" align="center" class="thumbnail-off" style="cursor:pointer;"
								onmouseover="Tip('<?=$tooltip_msg;?>');this.className='thumbnail-on';" 
								onmouseout="UnTip();this.className='thumbnail-off';"
								onclick="UnTip();getRequest(null,'index.php?mod=Public&act=addViewed&ref=<?=$ls_obj->fields($obj->GalleryAlbumId);?>&do=1',null);"
								height="100%">
									<img src="<?=$image_1;?>" width="<?=$size[0];?>" height="<?=$size[1];?>" />
								</td>
							</tr>
							</table>
						</td>
				<?
						$col++;
					}
					$row_count++;
					$row++;
					$ls_obj->MoveNext();
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
						<td align="center" valign="top"  height="200" colspan="4">
						&nbsp;
						</td>
					</tr>
			<?
			}
			elseif ($row_count <= 17) {
			?>
					<tr>
						<td align="center" valign="top"  height="100" colspan="4">
						&nbsp;
						</td>
					</tr>
			<?
			}
			?>

			</table>

			</td>
			</tr>
              <tr> 
                <td class="SlideShow-Footer">&nbsp;&nbsp;</td>
			  </tr>
				  <tr> 
					<td align="right"><div id="gal_pager">
								<table border="0"><tr><td><? $obj->renderPrevious("index.php?mod=Public&act=main","images/panah-galeri-kiri.gif","images/panah-galeri-kiri-dis.gif","main_area"); ?></td><td><? $obj->renderPageCombo("index.php?mod=Public&act=main","main_area"); ?></td><td><? $obj->renderNext("index.php?mod=Public&act=main","images/panah-galeri-kanan.gif","images/panah-galeri-kanan-dis.gif","main_area"); ?></td></tr></table>
								</div></td>
				  </tr>
				  <tr> 
					<td>&nbsp;</td>
				  </tr>
			</table>
			</div>
	</td>
	</tr>
	</table>