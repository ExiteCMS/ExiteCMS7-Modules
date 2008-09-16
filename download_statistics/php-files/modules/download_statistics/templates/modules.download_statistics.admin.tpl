{***************************************************************************}
{*                                                                         *}
{* ExiteCMS template: modules.download_statistics.admin.tpl                *}
{*                                                                         *}
{***************************************************************************}
{*                                                                         *}
{* Author: WanWizard <wanwizard@gmail.com>                                 *}
{*                                                                         *}
{* Revision History:                                                       *}
{* 2008-06-10 - WW - Initial version                                       *}
{*                                                                         *}
{***************************************************************************}
{*                                                                         *}
{* Template for the admin panel of the 'download_statistics' module        *}
{*                                                                         *}
{***************************************************************************}
{if $action == "edit" || $action == "add"}
	{include file="_opentable.tpl" name=$_name title=$action|capitalize|cat:" "|cat:$locale.dls616 state=$_state style=$_style}
	<form name='layoutform' method='post' action='{$formaction}'>
		<table align='center' cellpadding='0' cellspacing='0'>
			<tr>
				<td class='tbl' valign='top'>
					{$locale.dls610}
				</td>
				<td class='tbl'>
					<input type='text' name='dlsc_name' value='{$dlsc_name}' maxlength='10' class='textbox' style='width:100px;' />
				</td>
			</tr>
			<tr>
				<td class='tbl' valign='top'>
					{$locale.dls611}
				</td>
				<td class='tbl'>
					<input type='text' name='dlsc_description' value='{$dlsc_description}' maxlength='100' class='textbox' style='width:350px;' />
				</td>
			</tr>
			<tr>
				<td class='tbl' valign='top'>
					{$locale.dls612}
				</td>
				<td class='tbl'>
					<select name='dlsc_download_id' class='textbox' style='width:350px;'>
						<option value='0'>&nbsp;</option>
						{section name=id loop=$downloads}
							<option value='{$downloads[id].download_id}'{if $downloads[id].download_id == $dlsc_download_id} selected="selected"{/if}>{$downloads[id].download_cat_name} » {$downloads[id].download_title}</option>
						{/section}
					</select>
				</td>
			</tr>
			<tr>
				<td class='tbl' valign='top'>
					{$locale.dls617}
				</td>
				<td class='tbl'>
					<select name='dlsc_count_id' class='textbox'>
						<option value='0'{if $dlsc_count_id == 0} selected="selected"{/if}>{$locale.dls506}</option>
						<option value='1'{if $dlsc_count_id == 1} selected="selected"{/if}>{$locale.dls507}</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class='tbl' valign='top'>
					{$locale.dls613}
				</td>
				<td class='tbl'>
					<textarea name='dlsc_files' id='dlsc_files' rows='8' cols='50' class='textbox' style='width:350px;'>{$dlsc_files}</textarea>
				</td>
			</tr>
			<tr>
				<td class='tbl' colspan = '2' valign='top'>
					{$locale.dls615}
					<br /><br />
					<select multiple="multiple" name='filelist' id='filelist' size='15' class='textbox' style='width:610px' onchange="addFile();">
					{foreach from=$files item=file name=files}
						<option value='{$smarty.foreach.files.index}'>{$file}</option>
					{/foreach}
					</select>
				</td>
			</tr>
			<tr>
				<td align='center' colspan='2' class='tbl'>
					<input type='hidden' name='dlsc_id' value='{$dlsc_id}' />
					<input type='hidden' name='dlsc_order' value='{$dlsc_order}' />
					<input type='submit' name='save' value='{$locale.dls614}' class='button' />
				</td>
			</tr>
		</table>
	</form>
	{include file="_closetable.tpl"}
	{literal}
	<script type='text/javascript'>
	function addFile() {
		var selItem = document.getElementById('filelist').selectedIndex;
		var selText = document.getElementById('filelist').options[selItem].text;
		if (document.getElementById('dlsc_files').value == "") {
			document.getElementById('dlsc_files').value += selText + "\n";
		} else {
			if (document.getElementById('dlsc_files').value.substring(document.getElementById('dlsc_files').value.length.toString()-1) == "\n") {
				document.getElementById('dlsc_files').value += selText + "\n";
			} else {
				document.getElementById('dlsc_files').value += "\n" + selText + "\n";
			}
		}
	}
	</script>
	{/literal}
{else}
	{include file="_opentable.tpl" name=$_name title=$locale.dls500  state=$_state style=$_style}
	<form name='settingsform' method='post' action='{$smarty.const.FUSION_SELF}{$aidlink}&amp;action=config'>
		<table align='center' cellpadding='0' cellspacing='0' width='600'>
			<tr>
				<td class='tbl' style='vertical-align:top;width:250px;'>
					{$locale.dls510}
				</td>
				<td class='tbl'>
					<select name='dlstats_access' class='textbox'>
					{section name=id loop=$usergroups}
						<option value='{$usergroups[id].0}'{if $usergroups[id].0 == $settings2.dlstats_access} selected="selected"{/if}>{$usergroups[id].1}</option>
					{/section}
					</select>
				</td>
			</tr>
			<tr>
				<td class='tbl' style='vertical-align:top;width:250px;'>
					{$locale.dls501}
				</td>
				<td class='tbl'>
					<input type='text' name='dlstats_geomap_regex' value='{$settings2.dlstats_geomap_regex}' maxlength='250' class='textbox' style='width:300px;' />
					<br />
					<span class='small2'>{$locale.dls502}</span>
				</td>
			</tr>
			<tr>
				<td class='tbl' style='vertical-align:top;width:250px;'>
					{$locale.dls511}
				</td>
				<td class='tbl'>
					<input type='text' name='dlstats_google_api_key' value='{$settings2.dlstats_google_api_key}' maxlength='90' class='textbox' style='width:300px;' />
					<br />
					<span class='small2'>{$locale.dls512}</span>
				</td>
			</tr>
			<tr>
				<td class='tbl' style='vertical-align:top;width:250px;'>
					{$locale.dls503}
				</td>
				<td class='tbl'>
					<input type='text' name='dlstats_logs' value='{$settings2.dlstats_logs}' maxlength='250' class='textbox' style='width:300px;' />
					<br />
					<span class='small2'>{$locale.dls504}</span>
				</td>
			</tr>
			<tr>
				<td class='tbl' valign='top'>
					{$locale.dls513}
				</td>
				<td class='tbl'>
					<input type='text' name='dlstats_title' value='{$settings2.dlstats_title}' maxlength='50' class='textbox' style='width:300px;' />
					<br />
					<span class='small2'>{$locale.dls514}</span>
				</td>
			</tr>
			<tr>
				<td class='tbl' style='vertical-align:top;width:250px;'>
					{$locale.dls508}
				</td>
				<td class='tbl'>
					<select name='dlstats_remote' class='textbox'>
						<option value='0'{if $settings2.dlstats_remote == 0} selected="selected"{/if}>{$locale.dls506}</option>
						<option value='1'{if $settings2.dlstats_remote == 1} selected="selected"{/if}>{$locale.dls507}</option>
					</select>
					<br />
					<span class='small2'>{$locale.dls509}</span>
				</td>
			</tr>
			<tr>
				<td align='center' colspan='2' class='tbl'>
					<br />
					<input type='submit' name='savesettings' value='{$locale.dls505}' class='button' />
				</td>
			</tr>
		</table>
	</form>
	{include file="_closetable.tpl"}
	{include file="_opentable.tpl" name=$_name title=$locale.dls600 state=$_state style=$_style}
		{section name=id loop=$entries}
			{if $smarty.section.id.first}
			<table align='center' cellpadding='0' cellspacing='1' width='600' class='tbl-border'>
				<tr>
					<td class='tbl2'>
						<b>{$locale.dls601}</b>
					</td>
					<td align='center' colspan='2' width='1%' class='tbl2' style='white-space:nowrap'>
						<b>{$locale.dls602}</b>
					</td>
					<td align='center' width='1%' class='tbl2' style='white-space:nowrap'>
						<b>{$locale.dls603}</b>
					</td>
				</tr>
			{/if}
			<tr>
				<td class='tbl1'>
					<b>{$entries[id].dlsc_name}</b>
				</td>
				<td align='center' width='1%' class='tbl1' style='white-space:nowrap'>
					{$entries[id].dlsc_order}
				</td>
				<td align='center' width='1%' class='tbl1' style='white-space:nowrap'>
				{if !$smarty.section.id.first}
					{imagelink link=$smarty.const.FUSION_SELF|cat:$aidlink|cat:"&amp;action=up&amp;dlsc_id="|cat:$entries[id].dlsc_id image="up.gif" alt=$locale.dls606 title=$locale.dls606}
				{/if}
				{if !$smarty.section.id.last}
					{imagelink link=$smarty.const.FUSION_SELF|cat:$aidlink|cat:"&amp;action=down&amp;dlsc_id="|cat:$entries[id].dlsc_id image="down.gif" alt=$locale.dls607 title=$locale.dls607}
				{/if}
				</td>
				<td align='center' width='1%' class='tbl1' style='white-space:nowrap'>
					{imagelink link=$smarty.const.FUSION_SELF|cat:$aidlink|cat:"&amp;action=edit&amp;dlsc_id="|cat:$entries[id].dlsc_id image="page_edit.gif" alt=$locale.dls608 title=$locale.dls608}
					&nbsp;
					{imagelink link=$smarty.const.FUSION_SELF|cat:$aidlink|cat:"&amp;action=delete&amp;dlsc_id="|cat:$entries[id].dlsc_id image="page_delete.gif" alt=$locale.dls609 title=$locale.dls609 onclick="return DeleteCounter();"}
				</td>
			</tr>
			{if $smarty.section.id.last}
			</table>
			{/if}
		{sectionelse}
			<div style='text-align:center'>
				<br />
				{$locale.dls604}
			</div>
		{/section}
		<div style='text-align:center'>
			<br />
			{buttonlink name=$locale.dls605 link=$smarty.const.FUSION_SELF|cat:$aidlink|cat:"&amp;action=add"}
		</div>
	{include file="_closetable.tpl"}
	<script type='text/javascript'>
	function DeleteCounter() {ldelim}
		return confirm('{$locale.dls929}');
	{rdelim}
	</script>
{/if}
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}
