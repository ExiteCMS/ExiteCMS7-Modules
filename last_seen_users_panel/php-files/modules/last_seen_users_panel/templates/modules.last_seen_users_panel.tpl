{***************************************************************************}
{*                                                                         *}
{* PLi-Fusion CMS template: last_seen_users_panel.tpl                      *}
{*                                                                         *}
{***************************************************************************}
{*                                                                         *}
{* Author: WanWizard <wanwizard@gmail.com>                                 *}
{*                                                                         *}
{* Revision History:                                                       *}
{* 2007-07-03 - WW - Initial version                                       *}
{*                                                                         *}
{***************************************************************************}
{*                                                                         *}
{* This template generates the PLi-Fusion infusion panel:                  *}
{* last_seen_users_panel                                                   *}
{*                                                                         *}
{***************************************************************************}
{include file="_openside_x.tpl" name=$_name title=$locale.lsup000 state=$_state style=$_style}
<table cellpadding='0' cellspacing='0' width='100%'>
	{section name=entry loop=$members}
	<tr>
		<td class='side-small' align='left'>
			{if $members[entry].cc_flag == ""}
				<img src='{$smarty.const.THEME}images/bullet.gif' alt='' />&nbsp;
			{else}
				{$members[entry].cc_flag}
			{/if}
			<span style='position:absolute;width:{$smarty.const.SIDE_WIDTH-92}px;white-space:nowrap;overflow:hidden;'>
				{if $smarty.const.iMEMBER}
					<a href='{$smarty.const.BASEDIR}profile.php?lookup={$members[entry].user_id}' title='{$members[entry].user_name}' class='side'>{$members[entry].user_name}</a>
				{else}
					{$members[entry].user_name}
				{/if}
			</span>
		</td>
		<td class='side-small' align='right'>
			{$members[entry].lastseen}
		</td>
	</tr>
	{/section}
</table>
{include file="_closeside_x.tpl"}
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}