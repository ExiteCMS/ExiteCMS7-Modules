{***************************************************************************}
{*                                                                         *}
{* ExiteCMS template: download_bars_admin_panel.tpl                        *}
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
{* This template generates the ExiteCMS module panel:                      *}
{* download_bars_admin_panel                                               *}
{*                                                                         *}
{***************************************************************************}
{include file="_opentable.tpl" name=$_name title=$locale.400 state=$_state style=$_style}
{if $barmsg|default:"" != ""}
	<center><b>{$barmsg}</b></center><br />
{/if}
<form name='barform' method='post' action='{$smarty.const.FUSION_SELF}{$aidlink}&amp;step=bar'>
	<table align='center' cellpadding='0' cellspacing='0' width='400'>
		<tr>
			<td class='tbl'>
				{$locale.403}:
				<br />
				<input type='text' name='bar_title' value='{$bar_title}' class='textbox' style='width:400px;' />
			</td>
		</tr>
		{section name=bar start=1 loop=`$smarty.const.MAX_BARS+1`}
		<tr>
			<td class='tbl'>
				{$locale.401} {$smarty.section.bar.index}:<br />
				<select name='download_bar[{$smarty.section.bar.index}]' class='textbox' style='width:400px;'>
					<option value='0'>&nbsp;</option>
				{section name=id loop=$barfiles}
					<option value='{$barfiles[id].download_id}'{if $barfiles[id].download_bar == $smarty.section.bar.index} selected="selected"{/if}>{$barfiles[id].download_cat_name} » {$barfiles[id].download_title}</option>
				{/section}
				</select>
			</td>
		</tr>
		{sectionelse}
		<tr>
			<td class='tbl'>
				{$locale.405}:
			</td>
		</tr>
		{/section}
		<tr>
			<td align='center'>
				<input type='submit' name='save_bars' value='{$locale.402}' class='button' />
			</td>
		</tr>
	</table>
</form>
{include file="_closetable.tpl"}
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}