
<form id="frSearchGal" name="frSearchGal" method="POST" onsubmit="return false;">
<input type="text" name="Src1" id="Src1" class="SearchBox" onkeyup="if (event.keyCode == 13 && this.value != '') {UnTip();doPost(document.getElementById('frSearchGal'),'index.php?mod=Public&act=viewThumbnail&type=src&do=9','main_area');}" onmouseover="Tip('Click to enter search terms');" onmouseout="UnTip();" value="<?=$Src1;?>"  tabindex="13">&nbsp;<img src="images/go_btn.png" style="cursor:pointer;filter:alpa(opacity:70);opacity:0.70;-moz-opacity:0.70;" align="absmiddle" tabindex="14" onmouseover="if (document.getElementById('Src1').value != '') {Tip('Search for : \'' +document.getElementById('Src1').value + '\'');}" onmouseout="if (document.getElementById('Src1').value != '') {UnTip();}" onclick="if (document.getElementById('Src1').value != '') {UnTip();doPost(document.getElementById('frSearchGal'),'index.php?mod=Public&act=viewThumbnail&type=src&do=9','main_area');}" onkeyup="if ((event.keyCode == 13 || event.keyCode == 32) && this.value != '') {UnTip();doPost(document.getElementById('frSearchGal'),'index.php?mod=Public&act=viewThumbnail&type=src&do=9','main_area');}"/>
</form>