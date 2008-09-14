				
				<div id="gallery_area">
				<table  width="95%" height="465" border="0" align="center" cellpadding="0" cellspacing="0">
				<? 
					if ($list->RecordCount() > 0) { ?>
              <tr> 
                <td align="center">
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
						<tr> 
							<td width="50%" align="left" nowrap valign="top" height="32">
							<span  onclick="getRequest(null,'index.php?mod=Public&act=viewThumbnail&gal=<?=$list->fields($obj->GalleryAlbumId);?>&do=9','gallery_area');" style="cursor:pointer;" class="Title1" onmouseover="this.className='Title1Hover';" onmouseout="this.className='Title1';"><?=$AlbumTitle;?>: Thumbnail View</span>
							</td>
							<td width="50%" align="right" nowrap valign="top">
								<?include_once("templates/form_search.tpl.php");?>
							</td>
						  </tr>
					</table>
				</td>
              </tr>
			  <? } ?>
              <tr> 
                <td class="SlideShow-Header">&nbsp;</td>
			  </tr>
              <tr> 
                <td class="SlideShow-Container" width="100%">
					<table width="100%" border="0" cellspacing="0" cellpadding="0" height="410">
					<tr>
					<td valign="top" width="65%">
					

							<table width="100%" border="0" cellspacing="0" cellpadding="0" height="410">
							<tr> 
							  <td align="right">
									<img src="images/photo-left.gif" id="photo_left" <? if ($show > 1) { ?>class="PhotoNav-off" onmouseover="this.className='PhotoNav-on';" onmouseout="this.className='PhotoNav-off';"  onclick="getRequest(null,'index.php?mod=Public&act=viewGallery&ref=<?=$ref;?>&gal=<?=$gal;?>&show=<?=($show - 1);?>&do=9','gallery_area');" <? } else {?>class="PhotoNav-disable" <?}?>/>
							  </td>
							  <td align="center" class="SlideShow-Container-td" valign="middle" width="100%"><span id="banner_area">
							  
							  <? if (eregi(".bmp.png",$image_1)) { ?>
								 <img border="0" id="photo" src="<?=$image_1;?>" width="<?=$size[0];?>" height="<?=$size[1];?>" style="cursor:pointer;" onclick="open('<?=eregi_replace("Gallery/","Gallery/Original/",eregi_replace(".bmp.png",".bmp",$image_1));?>','ZoomImg','toolbar=0,location=0,directories=0,status=0,scrollbars=1,menubar=0,copyhistory=0,width=800,height=600,left='+leftPos+',top='+topPos);" />
							  <? } else { ?>
								<img border="0" id="photo" src="<?=$image_1;?>" width="<?=$size[0];?>" height="<?=$size[1];?>" style="cursor:pointer;" onclick="open('<?=eregi_replace("Gallery/","Gallery/Original/",$image_1);?>','ZoomImg','toolbar=0,location=0,directories=0,status=0,scrollbars=1,menubar=0,copyhistory=0,width=800,height=600,left='+leftPos+',top='+topPos);" />
							  <? } ?></span>
							  </td>
							  <td align="left">
								<img src="images/photo-right.gif" id="photo_right" <? if ($show < $obj->getLastPageNumber()) { ?>class="PhotoNav-off" onmouseover="this.className='PhotoNav-on';" onmouseout="this.className='PhotoNav-off';"  onclick="getRequest(null,'index.php?mod=Public&act=viewGallery&ref=<?=$ref;?>&gal=<?=$gal;?>&show=<?=($show + 1);?>&do=9','gallery_area');"<? } else {?>class="PhotoNav-disable" <?}?> />
							  </td>
							</tr>
						  </table>
					<td>
					<td width="35%" valign="top">
							<table width="100%" border="0" cellspacing="0" cellpadding="0" height="400">
								<tr>
									<td align="left" valign="bottom" width="15%">
										<table class="comment-tab-on" cellspacing="5" width="150" id="related_tab" onclick="
											this.className='comment-tab-on';
											document.getElementById('comment_tab').className='comment-tab';
											document.getElementById('related_div').style.visibility='visible';
											document.getElementById('related_div').style.display='block';
											document.getElementById('comment_div').style.visibility='hidden';
											document.getElementById('comment_div').style.display='none';

											document.getElementById('comment_form').style.visibility='hidden';
											document.getElementById('comment_form').style.display='none';
											document.getElementById('comment_div').style.visibility='hidden';
											document.getElementById('comment_div').style.display='none';
											">
										<tr><td align="center">
											<span  class="Title1">Related Photos</span>
										</td></tr>
										</table>
									</td>
									<td align="left" valign="bottom" width="15%">
										<table class="comment-tab" cellspacing="5" width="150" id="comment_tab" onclick="
											getRequest(null,'index.php?mod=Public&act=viewComment&do=9&ref=<?=$photo_id;?>','comment_div');
											this.className='comment-tab-on';
											document.getElementById('related_tab').className='comment-tab';
											document.getElementById('comment_div').style.visibility='visible';
											document.getElementById('comment_div').style.display='block';
											document.getElementById('related_div').style.visibility='hidden';
											document.getElementById('related_div').style.display='none';

											document.getElementById('comment_form').style.visibility='hidden';
											document.getElementById('comment_form').style.display='none';
											document.getElementById('comment_div').style.visibility='visible';
											document.getElementById('comment_div').style.display='block';
											">
										<tr><td align="center">
											<span  class="Title1">Comments</span>
										</td></tr>
										</table>
									</td>
									<td align="left" valign="middle" width="70%">&nbsp;
									</td>
								</tr>
								
								<tr>
								<td colspan="3" width="100%">
									<table width="350" height="357" class="comment-tab-content-on" id="comment_content">
									<tr><td align="center" valign="top">
									<div id="comment_div" style="overflow:auto;visibility:hidden;display:none;z-index:20;height:357px;width:300px;">
										&nbsp;										
									</div>	
									<div id="comment_form" style="overflow:auto;visibility:hidden;display:none;z-index:20;height:357px;width:300px;">
										<table width="90%" align="center" border="0" cellpadding="0" cellspacing="0">
										<tr>
										<td align="right">
											<span class="link4"
											onclick="
											getRequest(null,'index.php?mod=Public&act=viewComment&do=9&ref=<?=$photo_id;?>','comment_div');
											document.getElementById('comment_form').style.visibility='hidden';
											document.getElementById('comment_form').style.display='none';
											document.getElementById('comment_div').style.visibility='visible';
											document.getElementById('comment_div').style.display='block';
											">View Comments</span>
										</td>
										</tr>
										<tr>
											<td align="left" valign="top">
												<img src="images/spacer.gif" height="10" />
											</td>
										</tr>
										<tr>
											<td align="left" valign="top">
												<form name="frComment" id="frComment" action="#" method="POST">
												Post comment as "<?=$_SESSION["uid"];?>"<br />
												<textarea name="CommentsDetail" id="CommentsDetail" class="TxtFld" rows="10" cols="45"></textarea><br />
												<input type="button"
													 class="Btn1Def" value="Save"
													 onmouseover="javascript: if (this.disabled==0) this.className='Btn1Hov'" 
													onmouseout="javascript: if (this.disabled==0) this.className='Btn1'" 
													onblur="javascript: if (this.disabled==0) this.className='Btn1'" 
													onfocus="javascript: if (this.disabled==0) this.className='Btn1Hov'"
													 name="btAktif2"
													 id="btAktif2"
													 onclick="if (document.getElementById('CommentsDetail').value != '') {ModalPopup('PopUpload');doPost(document.getElementById('frComment'),'index.php?mod=Public&act=postComment&ref=<?=$photo_id;?>&do=1',null);}"
													 >
												</form>
											</td>
										</tr>
										</table>
									</div>	
									<div id="related_div" style="overflow:auto;visibility:visible;display:block;z-index:20;height:357px;width:300px;">
											<table width="90%" align="center" border="0" cellpadding="0" cellspacing="0">
											<?
											$i = 1;
											?>
											<? if ($total_row > 0) { ?>
											<tr>
											<td align="right">
												<span class="link4"
												onmouseover="Tip('Find more photos like this');"
												onmouseout="UnTip();"
												onclick="UnTip();getRequest(null,'index.php?mod=Public&act=viewThumbnail&type=src&do=9&Src1=<?=$photo_keyword;?>','main_area');">Find More ...</span>
											</td>
											</tr>
											<? } ?>
											<tr>
											<td align="center" valign="top" width="100%">
												<table border="0" cellspacing="12">
												<?
													while (!$list2->EOF) {
														$row = $obj3->getRowNumber($list2->fields($obj2->GalleryAlbumId),$list2->fields($obj2->Id));

														$image_1 = $list2->fields($obj2->ThumbFile);
														$content_id = $list2->fields($obj2->GalleryAlbumId);

														if ($image_1 != "") {
															$size = resize_image($image_1,75,"w");
														}
														else {
															$image_1 = "images/spacer.gif";
															$size[0] = 75;
															$size[1] = 1;
														}
														if (trim($list2->fields($obj2->PhotoTitle)) != "") {
															$ToolTip = "<table border=\'0\' width=\'250\'><tr><td><span class=\'ToolTip\'>".$list2->fields($obj2->PhotoTitle)."</span></td></tr></table>";
														}
														else {
															$ToolTip = "<table border=\'0\' width=\'250\'><tr><td><span class=\'ToolTip\'>".eregi_replace("var/usr/images/Gallery/Thumbnail/","",$image_1)."</span></td></tr></table>";
														}
												?>
														<? if ($i == 1) { ?>
															<tr>
														<? } ?>
															<td valign="middle" align="center" class="thumbnail-off" style="cursor:pointer;"
															onmouseover="Tip('<?=$ToolTip;?>');this.className='thumbnail-on';" 
															onmouseout="UnTip();this.className='thumbnail-off';"
															onclick="UnTip();getRequest(null,'index.php?mod=Public&act=viewGallery&gal=<?=$list2->fields($obj2->GalleryAlbumId);?>&show=<?=$row;?>&do=9','gallery_area');"
															height="100%">
																<img src="<?=$image_1;?>" width="<?=$size[0];?>" height="<?=$size[1];?>" />
															</td>
														<? if ($i % 3 == 0) { 
															$i = 0;
															?>
															</tr>
														<? } ?>
												<?
														$i++;
														$list2->MoveNext();
													}
												?>
												</table>
											</td>
											</tr>
											</table>
									</div>							
									</td></tr>
									</table>
								</td>
								</tr>
							</table>
					</td>
					<td width="5%" valign="top"></td>
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
                <td align="left">
			 <span class="Title1Hover"><?=$photo_title;?></span><br>
          <?=$photo_desc;?>
				</td>
				</tr>
            </table>
			</div>

			
	
	<div id="PopUpload" style="margin:15px;width:300px;border:0px; background:transparent;display:none;color:#FFFFFF;text-align:center;">
				&nbsp;<br />
				<img src="images/loading2.gif" align="center" style="opacity: .50;-moz-opacity: 0.50;filter: alpha(opacity=50);" /><br />&nbsp;
				</div>