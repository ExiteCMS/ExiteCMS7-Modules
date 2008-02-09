{***************************************************************************}
{*                                                                         *}
{* PLi-Fusion CMS template: infusions.shoutbox_panel.tpl                   *}
{*                                                                         *}
{***************************************************************************}
{*                                                                         *}
{* Author: WanWizard <wanwizard@gmail.com>                                 *}
{*                                                                         *}
{* Revision History:                                                       *}
{* 2007-07-08 - WW - Initial version                                       *}
{*                                                                         *}
{***************************************************************************}
{*                                                                         *}
{* This template generates the PLi-Fusion infusion panel: shoutbox_panel   *}
{*                                                                         *}
{***************************************************************************}
{include file="_openside_x.tpl" name=$_name title=$locale.120 state=$_state style=$_style}
{if $smarty.const.iMEMBER || $settings.guestposts == "1"}
<form name='chatform' method='post' action='{$smarty.const.FUSION_SELF}{if $smarty.const.FUSION_QUERY|default:"" != ""}?{$smarty.const.FUSION_QUERY}{/if}'>
	<table align='center' cellpadding='0' cellspacing='0'>
		<tr>
			<td>
				{if $smarty.const.iGUEST}
					{$locale.121}
					<br />
					<input type='text' name='shout_name' value='' class='textbox' maxlength='30' style='width:140px;' />
					<br />
					{$locale.122}
					<br />
				{/if}
				<textarea name='shout_message' rows='4' cols='20' class='textbox' style='width:140px;'></textarea>
			</td>
		</tr>
		<tr>
			<td align='right'>
				<input type='submit' name='post_shout' value='{$locale.123}' class='button' />
			</td>
		</tr>
	</table>
</form>
<br />
{else}
	<center>
	{$locale.125}
	</center>
	<br />
{/if}
{section name=shout loop=$shouts}
	<img src='{$smarty.const.THEME}images/bullet.gif' alt='' />
	<b>
	{if $smarty.const.iMEMBER}
		{if $shouts[shout].user_name|default:"" != ""}
			<a href='{$smarty.const.BASEDIR}profile.php?lookup={$shouts[shout].shout_name}' class='side'>{$shouts[shout].user_name}</a>
		{else}
			{$shouts[shout].shout_name}
		{/if}
	{else}
		{if $shouts[shout].user_name|default:"" != ""}
			{$shouts[shout].user_name}
		{else}
			{$locale.usera}
		{/if}
	{/if}
	</b>
	<br />
	<span class='small2'>
		{$shouts[shout].shout_datestamp|date_format:"shortdate"}
	</span>
	{if $smarty.const.iADMIN && $allow_edit}
		[<a href='{$smarty.const.ADMIN}shoutbox.php{$aidlink}&amp;action=edit&amp;shout_id={$shouts[shout].shout_id}' class='side'>{$locale.048}</a>]
	{/if}
	<br />
	{$shouts[shout].shout_message}
	<br />
	{if !$smarty.section.shout.last}
		<br />
	{else}
		{if $more_shouts}
			<br />
			<center>
			<img src='{$smarty.const.THEME}images/bullet.gif' alt='' />
			<a href='{$smarty.const.MODULES}shoutbox_panel/shoutbox_archive.php' class='side'>{$locale.126}</a>
			<img src='{$smarty.const.THEME}images/bulletb.gif' alt='' />
			</center>
		{/if}
	{/if}
{sectionelse}
	<div align='left'>
	{$locale.127}
	</div>
{/section}
{include file="_closeside_x.tpl"}
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}