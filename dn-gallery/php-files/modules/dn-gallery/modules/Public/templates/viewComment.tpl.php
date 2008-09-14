<table width="90%" align="center" border="0" cellpadding="0" cellspacing="0">
<tr>
<td align="right">
	<? if ($_SESSION["uid"] != "" && $_SESSION["uid"] != "0" && $_SESSION["uid"] != "-1") { ?>
	<span class="link4"
	onclick="
	document.getElementById('comment_form').style.visibility='visible';
	document.getElementById('comment_form').style.display='block';
	document.getElementById('comment_div').style.visibility='hidden';
	document.getElementById('comment_div').style.display='none';
	">Post A Comment</span>
	<?
	$uid = $usr->getIdByLogin($_SESSION["uid"]);
	} ?>
</td>
</tr>
<tr>
	<td align="left" valign="top">
		<img src="images/spacer.gif" height="10" />
	</td>
</tr>
<? while (!$ls_com->EOF) { ?>
<tr>
<td align="left" valign="top">
	<span class="Title2"><?=$usr->getVmtUserLogin($ls_com->fields($com->VmtUserId));?></span> (<span class="Title3"><?=$ls_com->fields($com->CommentsDate);?></span>)
	<? if ($uid == $ls_com->fields($com->VmtUserId) || array_key_exists("1",$_SESSION["gid"])) { ?>&nbsp;<img src="images/trash.gif" align="absmiddle" onclick="UnTip();getRequest(null,'index.php?mod=Public&act=deleteComment&ref=<?=$ls_com->fields($com->CommentId);?>&gal=<?=$ref;?>&do=1',null);" style="cursor:pointer;" onmouseover="Tip('Delete this comment');" onmouseout="UnTip();" /><? }?><br />
	<?=$ls_com->fields($com->CommentsDetail);?>
</td>
</tr>
<tr>
<td align="left" valign="top">
	<img src="images/spacer.gif" height="10" />
</td>
</tr>
<? 
	$ls_com->MoveNext();
} ?>
</table>