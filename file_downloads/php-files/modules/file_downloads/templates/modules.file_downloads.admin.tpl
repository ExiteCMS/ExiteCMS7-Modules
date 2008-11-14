{***************************************************************************}
{*                                                                         *}
{* ExiteCMS template: modules.file_downloads.admin.tpl                     *}
{*                                                                         *}
{***************************************************************************}
{*                                                                         *}
{* Author: WanWizard <wanwizard@gmail.com>                                 *}
{*                                                                         *}
{* Revision History:                                                       *}
{* 2008-11-13 - WW - Initial version                                       *}
{*                                                                         *}
{***************************************************************************}
{*                                                                         *}
{* Template for the admin panel of the 'file_downloads' module             *}
{*                                                                         *}
{***************************************************************************}
{if $action == "edit" || $action == "add"}
	{include file="_opentable.tpl" name=$_name title=$action|capitalize|cat:" "|cat:$locale.400|cat:" "|cat:$locale.401 state=$_state style=$_style}
	<form name='layoutform' method='post' action='{$formaction}'>
		<table align='center' cellpadding='0' cellspacing='0'>
			<tr>
				<td class='tbl' valign='top'>
					{$locale.410}
				</td>
				<td class='tbl'>
					<input type='text' name='fd_name' value='{$fd_name}' maxlength='25' class='textbox' style='width:200px;' />
				</td>
			</tr>
			<tr>
				<td class='tbl' valign='top'>
					{$locale.411}
				</td>
				<td class='tbl'>
					<input type='text' name='fd_path' value='{$fd_path}' maxlength='255' class='textbox' style='width:350px;' />
				</td>
			</tr>
			<tr>
				<td class='tbl' valign='top'>
					{$locale.412}
				</td>
				<td class='tbl'>
					<select name='fd_group' class='textbox'>
					{section name=id loop=$usergroups}
						<option value='{$usergroups[id].0}'{if $usergroups[id].0 == $fd_group} selected="selected"{/if}>{$usergroups[id].1}</option>
					{/section}
					</select>
				</td>
			</tr>
			<tr>
				<td align='center' colspan='2' class='tbl'>
					<input type='hidden' name='fd_id' value='{$fd_id}' />
					<input type='hidden' name='fd_order' value='{$fd_order}' />
					<input type='submit' name='save' value='{$locale.413}' class='button' />
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
	{include file="_opentable.tpl" name=$_name title=$locale.400 state=$_state style=$_style}
		{section name=id loop=$entries}
			{if $smarty.section.id.first}
			<table align='center' cellpadding='0' cellspacing='1' width='600' class='tbl-border'>
				<tr>
					<td class='tbl2'>
						<b>{$locale.401}</b>
					</td>
					<td class='tbl2'>
						<b>{$locale.420}</b>
					</td>
					<td align='center' colspan='2' width='1%' class='tbl2' style='white-space:nowrap'>
						<b>{$locale.402}</b>
					</td>
					<td align='center' width='1%' class='tbl2' style='white-space:nowrap'>
						<b>{$locale.403}</b>
					</td>
				</tr>
			{/if}
			<tr>
				<td class='tbl1'>
					<b>{$entries[id].fd_name}</b>
				</td>
				<td align='left' width='1%' class='tbl1' style='white-space:nowrap'>
					<b>{$entries[id].group_name}</b>
				</td>
				<td align='center' width='1%' class='tbl1' style='white-space:nowrap'>
					{$entries[id].fd_order}
				</td>
				<td align='center' width='1%' class='tbl1' style='white-space:nowrap'>
				{if !$smarty.section.id.first}
					{imagelink link=$smarty.const.FUSION_SELF|cat:$aidlink|cat:"&amp;action=up&amp;fd_id="|cat:$entries[id].fd_id image="up.gif" alt=$locale.404 title=$locale.404}
				{/if}
				{if !$smarty.section.id.last}
					{imagelink link=$smarty.const.FUSION_SELF|cat:$aidlink|cat:"&amp;action=down&amp;fd_id="|cat:$entries[id].fd_id image="down.gif" alt=$locale.405 title=$locale.405}
				{/if}
				</td>
				<td align='center' width='1%' class='tbl1' style='white-space:nowrap'>
					{imagelink link=$smarty.const.FUSION_SELF|cat:$aidlink|cat:"&amp;action=edit&amp;fd_id="|cat:$entries[id].fd_id image="page_edit.gif" alt=$locale.406 title=$locale.406}
					&nbsp;
					{imagelink link=$smarty.const.FUSION_SELF|cat:$aidlink|cat:"&amp;action=delete&amp;fd_id="|cat:$entries[id].fd_id image="page_delete.gif" alt=$locale.407 title=$locale.407 onclick="return DeleteFileCat();"}
				</td>
			</tr>
			{if $smarty.section.id.last}
			</table>
			{/if}
		{sectionelse}
			<div style='text-align:center'>
				<br />
				{$locale.408}
			</div>
		{/section}
		<div style='text-align:center'>
			<br />
			{buttonlink name=$locale.409 link=$smarty.const.FUSION_SELF|cat:$aidlink|cat:"&amp;action=add"}
		</div>
	{include file="_closetable.tpl"}
	<script type='text/javascript'>
	function DeleteFileCat() {ldelim}
		return confirm('{$locale.421}');
	{rdelim}
	</script>
{/if}
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}
