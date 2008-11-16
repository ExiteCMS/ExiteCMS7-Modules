{***************************************************************************}
{* ExiteCMS Content Management System                                      *}
{***************************************************************************}
{* Copyright 2006-2008 Exite BV, The Netherlands                           *}
{* for support, please visit http://www.exitecms.org                       *}
{*-------------------------------------------------------------------------*}
{* Released under the terms & conditions of v2 of the GNU General Public   *}
{* License. For details refer to the included gpl.txt file or visit        *}
{* http://gnu.org                                                          *}
{***************************************************************************}
{* $Id::                                                                  $*}
{*-------------------------------------------------------------------------*}
{* Last modified by $Author::                                             $*}
{* Revision number $Rev::                                                 $*}
{***************************************************************************}
{*                                                                         *}
{* Template for the module mail2forum - m2f_admin_panel, delete confirm.   *}
{*                                                                         *}
{***************************************************************************}
{include file="_opentable.tpl" name=$locale.m2f100|cat:" - "|cat:$locale.m2f300|cat:" '"|cat:$forum_name|cat:"'" state=$_state style=$_style}
<form name='forumsettings' method='post' action='{$smarty.const.FUSION_SELF}{$aidlink}'>
	<table align='center' cellpadding='0' cellspacing='0'>
		<tr>
			<td align='center'>
				<br />
					{$locale.m2f905|string_format:$forum_name}
				<br /><br />
			</td>
		</tr>
		<tr>
			<td align='center'>
				<input type='hidden' name='m2f_id' value='{$_POST.m2f_id}'>
				<input type='hidden' name='m2f_forumid' value='{$_POST.m2f_forumid}'>
				<input type='submit' name='deleteconfirm' value='{$locale.m2f307}' class='button'>&nbsp;
				<input type='submit' name='back' value='{$locale.m2f216}' class='button'>
			</td>
		</tr>
	</table>
</form>
{include file="_closetable.tpl"}
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}
