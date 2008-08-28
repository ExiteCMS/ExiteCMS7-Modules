{***************************************************************************}
{*                                                                         *}
{* ExiteCMS template: download_statiscs.report.topfiles.tpl                *}
{*                                                                         *}
{***************************************************************************}
{*                                                                         *}
{* Author: WanWizard <wanwizard@gmail.com>                                 *}
{*                                                                         *}
{* Revision History:                                                       *}
{* 2008-07-01 - WW - Initial version                                       *}
{*                                                                         *}
{***************************************************************************}
{*                                                                         *}
{* report template include: generate the top downloaded files              *}
{*                                                                         *}
{***************************************************************************}
{if $action == "report"}
	<table width='100%' class='tbl-border'>
		<tr>
			<td align='left' class='tbl2' colspan='2'>
				<b>{$locale.dls810}</b>
			</td>
			<td align='center' class='tbl2'>
				<b>{$locale.dls811}</b>
			</td>
		</tr>
		{section name=id loop=$reportvars.output}
		<tr>
			<td align='right' width='1' class='{cycle values="tbl1,tbl2" advance=false}'>
				{$reportvars.output[id]._rownr}
			</td>
			<td align='left' class='{cycle values="tbl1,tbl2" advance=false}'>
				{$reportvars.output[id].dlsf_file}
			</td>
			<td align='center' class='{cycle values="tbl1,tbl2"}'>
				{$reportvars.output[id].dlsf_counter}
			</td>
		</tr>
		{sectionelse}
		<tr>
			<td align='center' class='tbl1' colspan='3'>
				<b>{$locale.rpt951}</b>
			</td>
		</tr>
		{/section}
	</table>
	{if $rows > $settings.numofthreads}
		<br />
		{makepagenav start=$rowstart count=$settings.numofthreads total=$rows range=3 link=$pagenav_url}
	{/if}
{else}
	<table width='100%'>
		<tr>
			<td align='left'>
				{$locale.dls801}:
				<input name='filter' class='textbox' value='' style='width:300px;' />
			</td>
			<td align='right'>
				{$locale.dls802}:
				<select name='regex' class='textbox'>
					<option value='0'>{$locale.dls506}</option>
					<option value='1'>{$locale.dls507}</option>
				</select>
			</td>
		</tr>
		<tr>
			<td align='left' colspan='2'>
				{$locale.dls803}
				<select name='top' class='textbox'>
					{section name=cnt loop=55 start=5 step=5}
					<option value='{$smarty.section.cnt.index}'>{$locale.dls804} {$smarty.section.cnt.index}</option>
					{/section}
					<option value='0'>{$locale.dls805}</option>
				</select>
				{$locale.dls806}
				<select name='sortorder' class='textbox'>
					<option value='0'>{$locale.dls808}</option>
					<option value='1'>{$locale.dls807}</option>
				</select>
			</td>
		</tr>
	</table>
{/if}
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}
