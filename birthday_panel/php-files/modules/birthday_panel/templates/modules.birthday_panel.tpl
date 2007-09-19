{***************************************************************************}
{*                                                                         *}
{* PLi-Fusion CMS template: birthday_panel.tpl                             *}
{*                                                                         *}
{***************************************************************************}
{*                                                                         *}
{* Author: WanWizard <wanwizard@gmail.com>                                 *}
{*                                                                         *}
{* Revision History:                                                       *}
{* 2007-07-02 - WW - Initial version                                       *}
{*                                                                         *}
{***************************************************************************}
{*                                                                         *}
{* This template generates the PLi-Fusion infusion panel: birthday_panel   *}
{*                                                                         *}
{***************************************************************************}
{section name=member loop=$birthdays}
	{if $smarty.section.member.first}{include file="_openside.tpl" name=$_name title=$locale.bdp100 state=$_state style=$_style}{/if}
	<img src='{$smarty.const.THEME}images/bullet.gif' alt='' /> <a href='{$smarty.const.BASEDIR}profile.php?lookup={$birthdays[member].user_id}' class='side'>{$birthdays[member].user_name}</a> ({$birthdays[member].age})<br />
	{if $smarty.section.member.last}
		<hr />
		<center>
			<font color='red'>{if $count > 1}{$locale.bdp111}{else}{$locale.bdp110}{/if}</font>
		</center>
		{include file="_closeside.tpl"}
	{/if}
{/section}
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}