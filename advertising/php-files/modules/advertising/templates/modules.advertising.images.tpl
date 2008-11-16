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
{* Template for the admin content module 'advertising'                     *}
{*                                                                         *}
{***************************************************************************}
{literal}<script language='javascript'>
<!---
function confdel(url) {
	if (confirm('{/literal}{$locale.ads905}{literal}')) location.href = url;
}
// --->
</script>{/literal}
{if $errormessage|default:"" != ""}
	{include file="_message_table_panel.tpl" name=$_name title=$errortitle state=$_state style=$_style message=$errormessage}
{/if}
{if $view_image|default:"" != ""}
	{include file="_opentable.tpl" name=$_name title="" state=$_state style=$_style}
	<div align='center'><img src='{$smarty.const.IMAGES_ADS}{$view_image}' alt='{$view_image}' /></div>
	{include file="_closetable.tpl"}
{/if}
{include file="_opentable.tpl" name=$_name title=$locale.ads406 state=$_state style=$_style}
<table align='center' cellpadding='0' cellspacing='1' width='500' class='tbl-border'>
	<tr>
		<td class='tbl2'><b>{$locale.ads530}</b></td>
		<td class='tbl2' align='center' width='1%' style='white-space:nowrap'><b>{$locale.ads542}</b></td>
		<td class='tbl2' align='center' width='1%' style='white-space:nowrap'><b>{$locale.ads544}</b></td>
		<td class='tbl2' align='center' width='1%' style='white-space:nowrap'><b>{$locale.ads543}</b></td>
	</tr>
	{section name=img loop=$image_list}
	<tr>
		<td class='{cycle values="tbl1,tbl2" advance=false}'>{$image_list[img].image}</td>
		<td align='center' width='1%' class='{cycle values="tbl1,tbl2" advance=false}' style='white-space:nowrap'>{$image_list[img].x} x {$image_list[img].y}</td>
		<td align='center' width='1%' class='{cycle values="tbl1,tbl2" advance=false}' style='white-space:nowrap'>
			{if $image_list[img].used}{$locale.ads423}{else}{$locale.ads422}{/if}
		</td>
		<td align='center' width='1%' class='{cycle values="tbl1,tbl2"}' style='white-space:nowrap'>
			[<a href='{$smarty.const.FUSION_SELF}{$aidlink}&amp;action=imgview&amp;image={$image_list[img].image}'>{$locale.ads540}</a>]
			[<a href='javascript:confdel("{$smarty.const.FUSION_SELF}{$aidlink}&amp;action=imgdel&amp;image={$image_list[img].image}");'>{$locale.ads541}</a>]
		</td>
	</tr>
	{sectionelse}
	<tr>
		<td align='center' colspan='4' class='tbl1'>
			{$locale.ads970}
		</td>
	</tr>
	{/section}
	<tr>
		<td align='center' colspan='4' class='tbl1'>
			<br />
			<form name='subfunctions' method='post' action='{$smarty.const.FUSION_SELF}{$aidlink}'>
				<input type='submit' name='cancel' value='{$locale.ads441}' class='button'>
			</form>
		</td>
	</tr>
</table>
{include file="_closetable.tpl"}
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}
