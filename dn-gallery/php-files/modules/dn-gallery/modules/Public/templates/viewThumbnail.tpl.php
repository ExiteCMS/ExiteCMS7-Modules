				
			<div id="gallery_area">
				
				
				<table  width="95%" height="465" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr> 
                <td align="center">
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
						<tr> 
							<td width="50%" align="left" nowrap valign="top" height="32">
								<?
									switch ($type) {
										case "src":
								?>
											<span  class="Title1" onmouseout="this.className='Title1';">Search result for</span>&nbsp;<span  class="Title1" onmouseout="this.className='Title1';" style="font-style:italic;">'<?=$Src1;?>'</span>
								<?
										break;
										default:
								?>
											<span  onclick="getRequest(null,'index.php?mod=Public&act=viewGallery&gal=<?=$list->fields($obj->GalleryAlbumId);?>&do=9','gallery_area');" style="cursor:pointer;" class="Title1" onmouseover="this.className='Title1Hover';" onmouseout="this.className='Title1';"><?=$AlbumTitle;?> : Slide Show View</span>
								<?
										break;
									}
								?>
							</td>
							<td width="50%" align="right" nowrap valign="top">
							<div id="gal_pager">
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
					$row_count = 1;
					while (!$list->EOF) {
						if ($type == "src") {
							$row = $obj2->getRowNumber($list->fields($obj->GalleryAlbumId),$list->fields($obj->Id));
						}
						$image_1 = $list->fields($obj->ThumbFile);
						$content_id = $list->fields($obj->GalleryAlbumId);

						if ($image_1 != "") {
							$size = resize_image($image_1,100,"w");
						}
						else {
							$image_1 = "images/spacer.gif";
							$size[0] = 100;
							$size[1] = 1;
						}
						if (trim($list->fields($obj->PhotoTitle)) != "") {
							$ToolTip = "<table border=\'0\' width=\'250\'><tr><td><span class=\'ToolTip\'>".$list->fields($obj->PhotoTitle)."</span></td></tr></table>";
						}
						else {
							$ToolTip = "<table border=\'0\' width=\'250\'><tr><td><span class=\'ToolTip\'>".eregi_replace("var/usr/images/Gallery/Thumbnail/","",$image_1)."</span></td></tr></table>";
						}
						if ($col == 1) {
					?>
						<tr>
							<td align="center" valign="top"  height="100">
								<table width="100" height="100">
								<tr>
									<td valign="middle" align="center" class="thumbnail-off" style="cursor:pointer;"
									onmouseover="Tip('<?=$ToolTip;?>');this.className='thumbnail-on';" 
									onmouseout="UnTip();this.className='thumbnail-off';"
									onclick="UnTip();getRequest(null,'index.php?mod=Public&act=viewGallery&gal=<?=$list->fields($obj->GalleryAlbumId);?>&show=<?=$row;?>&do=9','gallery_area');"
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
									onmouseover="Tip('<?=$ToolTip;?>');this.className='thumbnail-on';" 
									onmouseout="UnTip();this.className='thumbnail-off';"
									onclick="UnTip();getRequest(null,'index.php?mod=Public&act=viewGallery&gal=<?=$list->fields($obj->GalleryAlbumId);?>&show=<?=$row;?>&do=9','gallery_area');"
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
									onmouseover="Tip('<?=$ToolTip;?>');this.className='thumbnail-on';" 
									onmouseout="UnTip();this.className='thumbnail-off';"
									onclick="UnTip();getRequest(null,'index.php?mod=Public&act=viewGallery&gal=<?=$list->fields($obj->GalleryAlbumId);?>&show=<?=$row;?>&do=9','gallery_area');"
									height="100%">
										<img src="<?=$image_1;?>" width="<?=$size[0];?>" height="<?=$size[1];?>" />
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
					<td align="right">
								<table border="0"><tr><td><? $obj->renderPrevious("index.php?mod=Public&act=viewThumbnail&type=".$type."&Src1=".$Src1."&gal=".$gal."","images/panah-galeri-kiri.gif","images/panah-galeri-kiri-dis.gif","gallery_area"); ?></td><td><? $obj->renderPageCombo("index.php?mod=Public&act=viewThumbnail&type=".$type."&Src1=".$Src1."&gal=".$gal."","gallery_area"); ?></td><td><? $obj->renderNext("index.php?mod=Public&act=viewThumbnail&type=".$type."&Src1=".$Src1."&gal=".$gal."","images/panah-galeri-kanan.gif","images/panah-galeri-kanan-dis.gif","gallery_area"); ?></td></tr></table>
								</div></td>
				  </tr>
              <tr> 
                <td align="left">
					<?
					switch($type) {
						case "src":
						break;
						default:
							$cnt = new GalleryAlbum(); 
							$cnt->setGalleryAlbumId($content_id);
							$ls_cnt = $cnt->selectRowById();
					?>
							<span class="Title1Hover"><?=$ls_cnt->Fields($cnt->GalleryAlbumTitle);?></span><br>
							<?=$ls_cnt->Fields($cnt->GalleryAlbumDesc);?>
					<?
						break;
					}
					?>
						 <? ?>
						<?  ?>
						   
				</td>
				</tr>
            </table>
			</div>