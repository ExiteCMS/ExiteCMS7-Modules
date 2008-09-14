<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 TRANSITIONAL//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
<title><?=APPS_NAME;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<link href="style/css_ns6up.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/js_lib.js"></script>
<script type="text/javascript" src="js/internal_request.js"></script>
	
<script>
function saveForm(fr,mod,act) {
	doPost(fr,"index.php?mod=" + mod + "&act=" + act + "&do=1",null);
	//btn.form.submit();
}
</script>
</head>

<body>
<script type="text/javascript" src="js/wz_tooltip.js"></script>
<div id="LoadingPopup" style="font-weight:bold;font-size:12px;font-style:italic;color:#555555;font-family:verdana;position:absolute;left:5px;top:2px;display:none;visibility:hidden;opacity: .50;-moz-opacity:0.50;filter: alpha(opacity=50);"><img src="images/ajax-loader2.gif" align="left" width="14" height="14"/>&nbsp;loading ...</div>

<div id="BackGroundDiv" style="filter :alpha(opacity=60); opacity:.60; -moz-opacity:0.60; z-index:90000;width:0px;height:px;background:#000000;top:0px;left:0px;display:none;visibility:hidden;position:absolute;">&nbsp;</div>


<table width="100%" border="0" height="600" align="center" cellpadding="0" cellspacing="0" background="images/BG-2.png" style="background-repeat:repeat-x;">
<tr>
<td background="images/bg_bar.png" style="background-repeat:repeat-x;" valign="top">
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
    <?include_once("templates/index_top.tpl.php");?>
    <tr>
      <td height="10" colspan="6" valign="middle" align="left"><img src="images/spacer.gif" height="10" /></td>
    </tr>
    <tr>
      <td height="21">&nbsp;</td>
      <td colspan="4" width="100%" align="center" valign="top">
	  <? if ($mod == "Public") { ?>
		<div id="main_area">
				<? include_once("templates/content.tpl.php"); ?>
		</div>
	  <? } else { ?>
		<div id="main_area">
			<table  align="center" bgcolor="#F2F5F7" style="border-collapse: collapse; border: 1px solid #A6A69A;	list-style-position: inside;	background-attachment: scroll;	background-repeat: repeat-x;" width="95%" height="465" cellpadding="10">
			<tr>
			<td valign="top">
					 <? include_once("templates/content.tpl.php"); ?>
			</td>
			</tr>
			</table>
		</div>
	  <? } ?>
	  </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="10" colspan="6" valign="middle" align="left"><img src="images/spacer.gif" height="10" /></td>
    </tr>
    <tr>
      <td height="59" colspan="3" valign="middle" align="left" background="images/bg_footer.png"><span class="style30">&nbsp;&nbsp;<?=COPYRIGHT;?></span></td>
      <td height="59" colspan="3" valign="middle" align="right" background="images/bg_footer.png"><span class="style30"><?=POWERED_BY;?>&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
    </tr>
  </table>
 </td>
</tr>
</table>
</body>
</html>
