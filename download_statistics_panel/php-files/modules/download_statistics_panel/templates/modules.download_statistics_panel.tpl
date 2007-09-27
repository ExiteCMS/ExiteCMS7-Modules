{***************************************************************************}
{*                                                                         *}
{* PLi-Fusion CMS template: infusions.download_statistics_panel.tpl        *}
{*                                                                         *}
{***************************************************************************}
{*                                                                         *}
{* Author: WanWizard <wanwizard@gmail.com>                                 *}
{*                                                                         *}
{* Revision History:                                                       *}
{* 2007-07-23 - WW - Initial version                                       *}
{*                                                                         *}
{***************************************************************************}
{*                                                                         *}
{* Template for the infusion download_statistics_panel                     *}
{*                                                                         *}
{***************************************************************************}
{include file="_opentable.tpl" name=$_name title=$locale.dls290 state=$_state style=$_style}
<table align='center' cellpadding='0' cellspacing='1' width='400' class=''>
	<tr align='center'>
		<td>{$date_first|date_format:"forumdate"|string_format:$locale.dls291}</td>
	</tr>
	<tr align='center'>
		<td>{$date_last|date_format:"forumdate"|string_format:$locale.dls294}</td>
	</tr>
	<tr align='center'>
		<td>{$stats_count|string_format:$locale.dls292}</td>
	</tr>
	<tr align='center'>
		<td>{$stats_files|string_format:$locale.dls293}</td>
	</tr>
</table>
{section name=id loop=$stats_mirrors}
	{if $smarty.section.id.first}
	<br />
	<table align='center' cellpadding='0' cellspacing='1' width='400' class='tbl-border'>
		<tr class='tbl2' align='center'>
			<td width='80%'>
				<b>{$locale.dls160}</b>
			</td>
			<td width='20%'>
				<b>{$locale.dls161}</b>
			</td>
		</tr>
	{/if}
	<tr class='{cycle values='tbl1'}' align='center'>
		<td>
			{$stats_mirrors[id].mirror}
		</td>
		<td>
			{$stats_mirrors[id].count}
		</td>
	</tr>
	{if $smarty.section.id.last}
	</table>
	{/if}
{/section}
{include file="_closetable.tpl"}
{include file="_opentable.tpl" name=$_name title=$locale.dls120 state=$_state style=$_style}
<form name='selectionforum' method='post' action='{$smarty.const.FUSION_SELF}'>
	<table align='center' cellpadding='0' cellspacing='0' width='500'>
		<tr>
			<td align='center' class='tbl'>
				{$locale.dls121}
				<select name='top' class='textbox' style='width:50px;'>
					<option value='1'{if $top == 5} selected="selected"{/if}>5</option>
					<option value='2'{if $top == 10} selected="selected"{/if}>10</option>
					<option value='3'{if $top == 15} selected="selected"{/if}>15</option>
					<option value='4'{if $top == 20} selected="selected"{/if}>20</option>
					<option value='5'{if $top == 25} selected="selected"{/if}>25</option>
				</select>
				{$locale.dls122}
				<select name='report' class='textbox' style='width:200px;'>
				{section name=id loop=$reports}
					<option value='{$reports[id].number}'{if $report == $reports[id].number} selected="selected"{/if}>{$reports[id].name}</option>
				{/section}
				</select>
			</td>
		</tr>
		<tr>
			<td align='center' class='tbl' height='5'>
			</td>
		</tr>
		<tr>
			<td align='center' class='tbl'>
				{$locale.dls123}
				<select name='filter' class='textbox' style='width:200px;'>
					<option value='0'{if $filter == 0} selected="selected"{/if}>&nbsp;</option>
					<option value='1'{if $filter == 1} selected="selected"{/if}>{$locale.dls140}</option>
					<option value='2'{if $filter == 2} selected="selected"{/if}>{$locale.dls141}</option>
					<option value='3'{if $filter == 3} selected="selected"{/if}>{$locale.dls142}</option>
					<option value='4'{if $filter == 4} selected="selected"{/if}>{$locale.dls143}</option>
				</select>
			</td>
		</tr>
		<tr>
			<td align='center' colspan='2' class='tbl'>
				<br />
				<input type='submit' name='show_stats' value='{$locale.dls124}' class='button' />
			</td>
		</tr>
	</table>
</form>
{include file="_closetable.tpl"}
{if $show_report && $reporttype == 1}
{include file="_opentable.tpl" name=$_name title=$locale.dls100|cat:$subtitle state=$_state style=$_style}
{foreach from=$output item=row name=block}
	{foreach from=$row.values item=values name=block}
	{if $smarty.foreach.block.first}
		<table align='center' cellpadding='0' cellspacing='1' width='500' class='tbl-border'>
			<tr>
				<td align='center' colspan='{$colcount}' class='tbl1'>
					{$row.title}
				</td>
			</tr>
			<tr>
				{foreach from=$row.headers item=header}
				<td align='center' width='{$colwidth}' class='tbl2'>
					<b>{$header}</b>
				</td>
				{/foreach}
			</tr>
	{/if}
			<tr>
		{foreach from=$values item=value}
				<td align='center' width='{$colwidth}' class='tbl1'>
					{$value}
				</td>
		{/foreach}
			</tr>
	{if $smarty.foreach.block.last}
		</table>
		<br />
	{/if}
	{/foreach}
{foreachelse}
	<br />
	<center><b>{$locale.dls299}</b></center>
	<br />br />
{/foreach}
{include file="_closetable.tpl"}
{/if}
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}