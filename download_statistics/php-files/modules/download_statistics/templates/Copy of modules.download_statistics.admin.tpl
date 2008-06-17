{***************************************************************************}
{*                                                                         *}
{* PLi-Fusion CMS template: modules.download_statistics.dlstats_admin.tpl  *}
{*                                                                         *}
{***************************************************************************}
{*                                                                         *}
{* Author: WanWizard <wanwizard@gmail.com>                                 *}
{*                                                                         *}
{* Revision History:                                                       *}
{* 2007-12-27 - WW - Initial version                                       *}
{*                                                                         *}
{***************************************************************************}
{*                                                                         *}
{* Template for the admin panel of the module download_statistics          *}
{*                                                                         *}
{***************************************************************************}
{if $errormessage|default:"" != ""}
{include file="_opentable.tpl" name=$_name title=$locale.dls200 state=$_state style=$_style}
	<div style='text-align:center;font-weight:bold;'>
		<br />
		{$errormessage}
		<br /><br />
	</div>
{include file="_closetable.tpl"}
{/if}
{include file="_opentable.tpl" name=$_name title=$locale.dls200 state=$_state style=$_style}
{if $action == "query"}
{elseif $action == "report"}
	<form name='reportform' method='post' action='{$smarty.const.FUSION_SELF|cat:$aidlink|cat:"&amp;action=report&amp;dlsr_id="|cat:$dlsr_id}'>
		<table align='center' cellpadding='0' cellspacing='0'>
			<tr>
				<td class='tbl' valign='top'>
					{$locale.dls208}:
				</td>
				<td class='tbl'>
					<input type='text' name='report_title' value='{$report_title}' maxlength='50' class='textbox' style='width:300px;' />
				</td>
			</tr>
			<tr>
				<td align='center' colspan='2' class='tbl'>
					<input type='submit' name='save' value='{if $dlsr_id}{$locale.dls210}{else}{$locale.dls209}{/if}' class='button' />
				</td>
			</tr>
		</table>
	</form>
	{if $dlsr_id}
		<br />
		<hr />
		<br />
		<table align='center' cellpadding='0' cellspacing='1' width='600' class='tbl-border'>
		{section name=id loop=$queries}
		{sectionelse}
			<tr>
				<td align='center' colspan='3' class='tbl1'>
					{$locale.dls211}
				</td>
			</tr>
		{/section}
		</table>
		<div style='text-align:center;'>
			<br />
			{buttonlink name=$locale.dls212 link=$smarty.const.FUSION_SELF|cat:$aidlink|cat:"&amp;action=query&amp;dlsq_id=0"}
		</div>
	{/if}
{else}
	<br />
	<table align='center' cellpadding='0' cellspacing='1' width='600' class='tbl-border'>
	{section name=id loop=$reports}
		{if $smarty.section.id.first}
		<tr>
			<td align='center' width='1%' class='tbl2' style='white-space:nowrap'>
				<b>{$locale.dls203}</b>
			</td>
			<td align='left' width='98%' class='tbl2'>
				<b>{$locale.dls204}</b>
			</td>
			<td align='center' width='1%' class='tbl2' style='white-space:nowrap'>
				<b>{$locale.dls213}</b>
			</td>
			<td align='center' width='1%' class='tbl2' style='white-space:nowrap'>
				<b>{$locale.dls205}</b>
			</td>
		</tr>
		{/if}
		<tr>
			<td align='center' width='1%' class='{cycle values="tbl1,tbl2" advance=no}' style='white-space:nowrap'>
				{$smarty.section.id.index+1}
			</td>
			<td align='left' width='97%' class='{cycle values="tbl1,tbl2" advance=no}'>
				{$reports[id].dlsr_title}
			</td>
			<td align='left' width='1%' class='{cycle values="tbl1,tbl2" advance=no}'>
				{$reports[id].queries}
			</td>
			<td align='left' width='1%' class='{cycle values="tbl1,tbl2"}' style='white-space:nowrap'>
				{imagelink link=$smarty.const.FUSION_SELF|cat:$aidlink|cat:"&amp;action=report&amp;dlsr_id="|cat:$reports[id].dlsr_id image="page_edit.gif" alt=$locale.dls206 title=$locale.dls206}
				&nbsp;
				{imagelink link=$smarty.const.FUSION_SELF|cat:$aidlink|cat:"&amp;action=delete&amp;dlsr_id="|cat:$reports[id].dlsr_id image="page_delete.gif" alt=$locale.dls207 title=$locale.dls207}
			</td>
		</tr>
	{sectionelse}
		<tr>
			<td align='center' colspan='4' class='tbl1'>
				{$locale.dls201}
			</td>
		</tr>
	{/section}
	</table>
	<div style='text-align:center;'>
		<br />
		{buttonlink name=$locale.dls202 link=$smarty.const.FUSION_SELF|cat:$aidlink|cat:"&amp;action=report&amp;dlsr_id=0"}
	</div>
{/if}
{include file="_closetable.tpl"}
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}