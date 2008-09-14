				
	  
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
                <td class="SlideShow-Container">
					<table width="100%" border="0" cellspacing="0" cellpadding="0" height="410">
					<tr>
						<td width="5%">
						</td>
						<td align="left" valign="middle" width="25%">
							<table class="main-tab" cellspacing="5" width="175" id="featured_tab" onmouseover="this.className='main-tab-on';document.getElementById('featured_content').className='main-tab-content-on'" onmouseout="this.className='main-tab';document.getElementById('featured_content').className='main-tab-content'"onclick="getRequest(null,'index.php?mod=Public&act=viewAlbum&type=featured&do=9','main_area');" >
							<tr><td align="center">
								<span  class="Title1">Featured Albums</span>
							</td></tr>
							</table>
						</td>
						<td width="5%">
						</td>
						<td align="left" valign="middle" width="25%">
							<table class="main-tab" cellspacing="5" width="175" id="mostviewed_tab" onmouseover="this.className='main-tab-on';document.getElementById('mostviewed_content').className='main-tab-content-on'" onmouseout="this.className='main-tab';document.getElementById('mostviewed_content').className='main-tab-content'" onclick="getRequest(null,'index.php?mod=Public&act=viewAlbum&type=most_viewed&do=9','main_area');">
							<tr><td align="center">
								<span  class="Title1">Most Viewed</span>
							</td></tr>
							</table>
						</td>
						<td width="5%">
						</td>
						<td align="left" valign="middle" width="25%">
							<table class="main-tab" cellspacing="5" width="175" id="all_tab" onmouseover="this.className='main-tab-on';document.getElementById('all_content').className='main-tab-content-on'" onmouseout="this.className='main-tab';document.getElementById('all_content').className='main-tab-content'"onclick="getRequest(null,'index.php?mod=Public&act=viewAlbum&type=all&do=9','main_area');" >
							<tr><td align="center">
								<span  class="Title1">All Albums</span>
							</td></tr>
							</table>
						</td>
						<td width="5%">
						</td>
					</tr>
					
					<tr>
						<td width="5%">
						</td>
						<td align="center" valign="middle" width="25%">
							<table width="100%" height="381" class="main-tab-content" id="featured_content" onmouseover="this.className='main-tab-content-on';document.getElementById('featured_tab').className='main-tab-on'" onmouseout="this.className='main-tab-content';document.getElementById('featured_tab').className='main-tab'">
							<tr><td align="center" valign="top">
							<div id="featured_div" style="overflow:auto;display:block;z-index:20;height:362px;width:100%;">
								<table border="0" cellspacing="20">
								<?
									$obj = new GalleryAlbum();
									$usr = new VmtUser();
									$obj2 = new GalleryFile();

									$limit = 15;
									$ls_obj = $obj->getContent($limit,$show);
									$i = 1;
									while (!$ls_obj->EOF) {
										$gal = $ls_obj->fields($obj->GalleryAlbumId);
										$image_1 = $ls_obj->fields($obj->GalleryAlbumIcon);
										if ($image_1 == "") {
											$obj2->clearFieldValue();
											$ls_obj2 = $obj2->getFile($ls_obj->fields($obj->GalleryAlbumId),1,$show);
											$image_1 = $ls_obj2->fields($obj2->ThumbFile);
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
								?>
										<? if ($i % 2 != 0) { ?>
											<tr>
										<? } ?>
											<td valign="middle" align="center" class="thumbnail-off" style="cursor:pointer;"
											onmouseover="Tip('<?=$tooltip_msg;?>');this.className='thumbnail-on';" 
											onmouseout="UnTip();this.className='thumbnail-off';"
											onclick="UnTip();getRequest(null,'index.php?mod=Public&act=addViewed&ref=<?=$ls_obj->fields($obj->GalleryAlbumId);?>&do=1',null);"
											height="100%">
												<img src="<?=$image_1;?>" width="<?=$size[0];?>" height="<?=$size[1];?>" />
											</td>
										<? if ($i % 2 == 0) { ?>
											</tr>
										<? } ?>
								<?
										$i++;
										$ls_obj->MoveNext();
									}
								?>
								</table>
							</div>							
							</td></tr>
							</table>
						</td>
						<td width="5%">
						</td>
						<td align="center" valign="middle" width="25%">
							
							<table width="100%" height="381" class="main-tab-content" id="mostviewed_content" onmouseover="this.className='main-tab-content-on';document.getElementById('mostviewed_tab').className='main-tab-on'" onmouseout="this.className='main-tab-content';document.getElementById('mostviewed_tab').className='main-tab'">
							<tr><td align="center" valign="top">
							<div id="mostviewed_div" style="overflow:auto;display:block;z-index:20;height:362px;width:100%;">
								<table border="0" cellspacing="20">
								<?
									$obj = new GalleryAlbum();
									$usr = new VmtUser();
									$obj2 = new GalleryFile();

									$limit = 15;
									$ls_obj = $obj->getMostViewed($limit,$show);
									$i = 1;
									while (!$ls_obj->EOF) {
										$gal = $ls_obj->fields($obj->GalleryAlbumId);
										$image_1 = $ls_obj->fields($obj->GalleryAlbumIcon);
										if ($image_1 == "") {
											$obj2->clearFieldValue();
											$ls_obj2 = $obj2->getFile($ls_obj->fields($obj->GalleryAlbumId),1,$show);
											$image_1 = $ls_obj2->fields($obj2->FileName);
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
								?>
										<? if ($i % 2 != 0) { ?>
											<tr>
										<? } ?>
											<td valign="middle" align="center" class="thumbnail-off" style="cursor:pointer;"
											onmouseover="Tip('<?=$tooltip_msg;?>');this.className='thumbnail-on';" 
											onmouseout="UnTip();this.className='thumbnail-off';"
											onclick="UnTip();getRequest(null,'index.php?mod=Public&act=addViewed&ref=<?=$ls_obj->fields($obj->GalleryAlbumId);?>&do=1',null);"
											height="100%">
												<img src="<?=$image_1;?>" width="<?=$size[0];?>" height="<?=$size[1];?>" />
											</td>
										<? if ($i % 2 == 0) { ?>
											</tr>
										<? } ?>
								<?
										$i++;
										$ls_obj->MoveNext();
									}
								?>
								</table>
							</div>							
							</td></tr>
							</table>
						</td>
						<td width="5%">
						</td>
						<td align="center" valign="middle" width="25%">
							
							
							<table width="100%" height="381" class="main-tab-content" id="all_content" onmouseover="this.className='main-tab-content-on';document.getElementById('all_tab').className='main-tab-on'" onmouseout="this.className='main-tab-content';document.getElementById('all_tab').className='main-tab'">
							<tr><td align="center" valign="top">
							<div id="all_div" style="overflow:auto;display:block;z-index:20;height:362px;width:100%;">
								<table border="0" cellspacing="20">
								<?
									$obj = new GalleryAlbum();
									$usr = new VmtUser();
									$obj2 = new GalleryFile();

									$limit = 15;
									$ls_obj = $obj->getRandom($limit,$show);
									$i = 1;
									while (!$ls_obj->EOF) {
										$gal = $ls_obj->fields($obj->GalleryAlbumId);
										$image_1 = $ls_obj->fields($obj->GalleryAlbumIcon);
										if ($image_1 == "") {
											$obj2->clearFieldValue();
											$ls_obj2 = $obj2->getFile($ls_obj->fields($obj->GalleryAlbumId),1,$show);
											$image_1 = $ls_obj2->fields($obj2->FileName);
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
								?>
										<? if ($i % 2 != 0) { ?>
											<tr>
										<? } ?>
											<td valign="middle" align="center" class="thumbnail-off" style="cursor:pointer;"
											onmouseover="Tip('<?=$tooltip_msg;?>');this.className='thumbnail-on';" 
											onmouseout="UnTip();this.className='thumbnail-off';"
											onclick="UnTip();getRequest(null,'index.php?mod=Public&act=addViewed&ref=<?=$ls_obj->fields($obj->GalleryAlbumId);?>&do=1',null);"
											height="100%">
												<img src="<?=$image_1;?>" width="<?=$size[0];?>" height="<?=$size[1];?>" />
											</td>
										<? if ($i % 2 == 0) { ?>
											</tr>
										<? } ?>
								<?
										$i++;
										$ls_obj->MoveNext();
									}
								?>
								</table>
							</div>							
							</td></tr>
							</table>
						</td>
						<td width="5%">
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