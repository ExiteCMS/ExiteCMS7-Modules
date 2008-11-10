{***************************************************************************}
{*                                                                         *}
{* ExiteCMS template: last_seen_users_panel.tpl                            *}
{*                                                                         *}
{***************************************************************************}
{*                                                                         *}
{* Author: WanWizard <wanwizard@gmail.com>                                 *}
{*                                                                         *}
{* Revision History:                                                       *}
{* 2007-07-03 - WW - Initial version                                       *}
{* 2008-09-17 - WW - Added text-direction support                          *}
{*                                                                         *}
{***************************************************************************}
{*                                                                         *}
{* This template generates the panel: last_seen_users_panel                *}
{*                                                                         *}
{***************************************************************************}
{include file="_openside_x.tpl" name=$_name title=$locale.lsup000 state=$_state style=$_style}
<table cellpadding='0' cellspacing='0' width='100%'>
	{section name=entry loop=$members}
	<tr>
		{if $smarty.const.LOCALEDIR == "LTR"}
			<td class='small' align='left'>
				<div style='width:{$smarty.const.SIDE_WIDTH-75}px;white-space:nowrap;overflow:hidden;'>
					{if $members[entry].cc_flag == ""}
						<img src='{$smarty.const.THEME}images/bullet.gif' alt='' />&nbsp;
					{else}
						{$members[entry].cc_flag}
					{/if}
					{if $smarty.const.iMEMBER}
						<a href='{$smarty.const.BASEDIR}profile.php?lookup={$members[entry].user_id}' title='{$members[entry].user_name}' class='side'>{$members[entry].user_name}</a>
					{else}
						{$members[entry].user_name}
					{/if}
				</div>
			</td>
			<td class='small' align='right'>
				<div style='width:55px;white-space:nowrap;overflow:hidden;'>{$members[entry].lastseen}</div>
			</td>
		{else}
			<td class='small' align='right'>
				<div style='width:55px;white-space:nowrap;overflow:hidden;'>{$members[entry].lastseen}</div>
			</td>
			<td class='small' align='left'>
				<div style='width:{$smarty.const.SIDE_WIDTH-75}px;white-space:nowrap;overflow:hidden;'>
					{if $smarty.const.iMEMBER}
						<a href='{$smarty.const.BASEDIR}profile.php?lookup={$members[entry].user_id}' title='{$members[entry].user_name}' class='side'>{$members[entry].user_name}</a>
					{else}
						{$members[entry].user_name}
					{/if}
					{if $members[entry].cc_flag == ""}
						<img src='{$smarty.const.THEME}images/bullet.gif' alt='' />&nbsp;
					{else}
						{$members[entry].cc_flag}
					{/if}
				</div>
			</td>
		{/if}
	</tr>
	{/section}
</table>
{include file="_closeside_x.tpl"}
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}
