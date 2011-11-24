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
{* Template for the admin content module 'advertising'. This template      *}
{* generates a panel with all advertising of one single client.            *}
{*                                                                         *}
{***************************************************************************}
{literal}<script type='text/javascript'>
<!--
function confdel(url) {
	if (confirm('{/literal}{$locale.ads905}{literal}')) location.href = url;
}
// -->
</script>{/literal}
{include file="_opentable.tpl" name=$_name title=$locale.ads404|cat:" : <b>"|cat:$data.user_name|cat:"</b>" state=$_state style=$_style}
<table align='center' cellpadding='0' cellspacing='1' width='90%' class='tbl-border'>
	<tr>
		<td colspan='7' align='center' class='tbl2'><b>{$locale.ads402}</b>
		</td>
	</tr>
{section name=ad loop=$ads1}
{if $smarty.section.ad.first}
	<tr>
		<td align='center' width='1%' class='tbl2' style='white-space:nowrap'><b>{$locale.ads460}</b></td>
		<td align='center' width='1%' class='tbl2' style='white-space:nowrap'><b>{$locale.ads462}</b></td>
		<td align='center' width='1%' class='tbl2' style='white-space:nowrap'><b>{$locale.ads463}</b></td>
		<td align='center' width='1%' class='tbl2' style='white-space:nowrap'><b>{$locale.ads479}</b></td>
		<td align='center' width='1%' class='tbl2' style='white-space:nowrap'><b>{$locale.ads464}</b></td>
		<td align='center' width='1%' class='tbl2' style='white-space:nowrap'><b>{$locale.ads465}</b></td>
		<td align='center' width='1%' class='tbl2' style='white-space:nowrap'><b>{$locale.ads466}</b></td>
	</tr>
{/if}
	<tr>
		<td align='center' class='tbl1' style='white-space:nowrap'>{$ads1[ad].adverts_id}</td>
		<td align='center' class='tbl1' style='white-space:nowrap'>{$ads1[ad].advert_type}</td>
		<td align='center' class='tbl1' style='white-space:nowrap'>{$ads1[ad].contract_type}</td>
		<td align='center' class='tbl1' style='white-space:nowrap'>{$ads1[ad].adverts_shown}</td>
		<td align='center' class='tbl1' style='white-space:nowrap'>{$ads1[ad].adverts_clicks}</td>
		<td align='center' class='tbl1' style='white-space:nowrap'>{$ads1[ad].percentage}%</td>
		<td align='center' class='tbl1' style='white-space:nowrap'>
			<a href='{$smarty.const.FUSION_SELF}{$aidlink}&amp;action=edit&amp;adverts_id={$ads1[ad].adverts_id}'><img src='{$smarty.const.THEME}images/page_edit.gif' alt='{$locale.ads469}' title='{$locale.ads469}' /></a>&nbsp;
			<a href='javascript:confdel("{$smarty.const.FUSION_SELF}{$aidlink}&amp;action=delete&amp;adverts_id={$ads1[ad].adverts_id}");'><img src='{$smarty.const.THEME}images/page_delete.gif' alt='{$locale.ads470}' title='{$locale.ads470}' /></a>&nbsp;
			{if $ads1[ad].adverts_status == 0}
				<a href='{$smarty.const.FUSION_SELF}{$aidlink}&amp;action=enable&amp;adverts_id={$ads1[ad].adverts_id}'><img src='{$smarty.const.THEME}images/page_green.gif' alt='{$locale.ads467}' title='{$locale.ads467}' /></a>
			{else}
				<a href='{$smarty.const.FUSION_SELF}{$aidlink}&amp;action=disable&amp;adverts_id={$ads1[ad].adverts_id}'><img src='{$smarty.const.THEME}images/page_red.gif' alt='{$locale.ads468}' title='{$locale.ads468}' /></a>
			{/if}
		</td>
	</tr>
{sectionelse}
	<tr>
		<td colspan='7' align='center' class='tbl1'>
			<b>{$locale.ads908}</b>
		</td>
	</tr>
{/section}
	<tr>
		<td colspan='7' align='center' class='tbl2'><b>{$locale.ads403}</b>
		</td>
	</tr>
{section name=ad loop=$ads2}
	<tr>
		<td align='center' class='tbl1' style='white-space:nowrap'>{$ads2[ad].adverts_id}</td>
		<td align='center' class='tbl1' style='white-space:nowrap'>{$ads2[ad].advert_type}</td>
		<td align='center' class='tbl1' style='white-space:nowrap'>{$ads2[ad].contract_type}</td>
		<td align='center' class='tbl1' style='white-space:nowrap'>{$ads2[ad].adverts_shown}</td>
		<td align='center' class='tbl1' style='white-space:nowrap'>{$ads2[ad].adverts_clicks}</td>
		<td align='center' class='tbl1' style='white-space:nowrap'>{$ads2[ad].percentage}%</td>
		<td align='center' class='tbl1' style='white-space:nowrap'>
			<a href='{$smarty.const.FUSION_SELF}{$aidlink}&amp;action=edit&amp;adverts_id={$ads2[ad].adverts_id}'><img src='{$smarty.const.THEME}images/page_edit.gif' alt='{$locale.ads469}' title='{$locale.ads469}' /></a>&nbsp;
			<a href='javascript:confdel("{$smarty.const.FUSION_SELF}{$aidlink}&amp;action=delete&amp;adverts_id={$ads2[ad].adverts_id}");'><img src='{$smarty.const.THEME}images/page_delete.gif' alt='{$locale.ads470}' title='{$locale.ads470}' /></a>&nbsp;
			{if $ads2[ad].adverts_status == 0}
				<a href='{$smarty.const.FUSION_SELF}{$aidlink}&amp;action=enable&amp;adverts_id={$ads2[ad].adverts_id}'><img src='{$smarty.const.THEME}images/page_green.gif' alt='{$locale.ads467}' title='{$locale.ads467}' /></a>
			{else}
				<a href='{$smarty.const.FUSION_SELF}{$aidlink}&amp;action=enable&amp;adverts_id={$ads2[ad].adverts_id}'><img src='{$smarty.const.THEME}images/page_red.gif' alt='{$locale.ads468}' title='{$locale.ads468}' /></a>
			{/if}
		</td>
	</tr>
{sectionelse}
	<tr>
		<td colspan='7' align='center' class='tbl1'>
			<b>{$locale.ads911}</b>
		</td>
	</tr>
{/section}
</table>
<div align='center'>
	<form name='sf_{$data.user_name}' method='post' action='{$smarty.const.FUSION_SELF}{$aidlink}&amp;id={$data.user_id}'>
		<br />
		<input type='submit' name='addad' value='{$locale.ads400}' class='button' />&nbsp;
		<input type='submit' name='delclient' value='{$locale.ads476}' class='button' />
	</form>
</div>
{include file="_closetable.tpl"}
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}
