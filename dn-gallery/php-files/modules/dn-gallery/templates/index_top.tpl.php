 <tr>
      <td height="51" colspan="2" class="style1">&nbsp;</td>
      <td colspan="2" align="left" width="92%"><span class="style3 style30">

	  <? if ($_SESSION["uid"] != "" && $_SESSION["gid"] != "") { ?>
	  
			<span class="link2" style="cursor:pointer;" onmouseover="this.className='link1';" onmouseout="this.className='link2';" onclick="location.href='index.php';">Home</span>
			|
		  <span class="link2" style="cursor:pointer;" onmouseover="this.className='link1';" onmouseout="this.className='link2';" onclick="location.href='index.php?mod=Master&act=lsGal';">Gallery Setup</span>
			| 
		  <span class="link2" style="cursor:pointer;" onmouseover="this.className='link1';" onmouseout="this.className='link2';" onclick="location.href='index.php?mod=Master&act=lsAccess';">Access & Privileges</span>
		   <?if (array_key_exists("1",$_SESSION["gid"])) {?> | 
		  <span class="link2" style="cursor:pointer;" onmouseover="this.className='link1';" onmouseout="this.className='link2';" onclick="location.href='index.php?mod=UserMgmt&act=lsUser';">Users</span> | 
		  <span class="link2" style="cursor:pointer;" onmouseover="this.className='link1';" onmouseout="this.className='link2';" onclick="location.href='index.php?mod=UserMgmt&act=lsGroup';">Groups</span>
		  <? } ?>
	  <? } else { ?>
	  
			<span class="link2" style="cursor:pointer;" onmouseover="this.className='link1';" onmouseout="this.className='link2';" onclick="getRequest(null,'index.php?do=9','main_area');">Home</span>
	  <? } ?>
	  </span></td>

	  <? if ($_SESSION["uid"] != "" && $_SESSION["gid"] != "") { ?>
		 <td width="50" align="center" valign="middle"> <span class="link2" style="cursor:pointer;" onmouseover="this.className='link1';" onmouseout="this.className='link2';"  onclick="location.href='index.php?mod=UserMgmt&act=logout&do=1';">Logout</span></td>
      <td width="31">&nbsp;</td>
	  <? } else { ?>
		 <td align="center" valign="middle" nowrap>
		 <span class="style3 style30">
		 <span class="link2" style="cursor:pointer;font-weight:bold;" onmouseover="this.className='link1';" onmouseout="this.className='link2';" onclick="getRequest(null,'index.php?mod=Public&act=frUser&do=9','main_area');">Sign Up</span> |
		
		 <span class="link2" style="cursor:pointer;" onmouseover="this.className='link1';" onmouseout="this.className='link2';" onclick="getRequest(null,'index.php?mod=Public&act=login&do=9','main_area');">Sign in</span>
		 </span>
		 </td>
      <td width="31">&nbsp;</td>
	  <? } ?>
    </tr>