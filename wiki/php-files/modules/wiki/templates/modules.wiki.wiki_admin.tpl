{***************************************************************************}
{*                                                                         *}
{* ExiteCMS template: modules.wiki_admin.tpl                               *}
{*                                                                         *}
{***************************************************************************}
{*                                                                         *}
{* Author: WanWizard <wanwizard@gmail.com>                                 *}
{*                                                                         *}
{* Revision History:                                                       *}
{* 2007-12-02 - WW - Initial version                                       *}
{*                                                                         *}
{***************************************************************************}
{*                                                                         *}
{* Template for the admin configuration module 'wiki'                      *}
{*                                                                         *}
{***************************************************************************}
{include file="_opentable.tpl" name=$_name title=$locale.400 state=$_state style=$_style}
<form name='settingsform' method='post' action='{$smarty.const.FUSION_SELF}{$aidlink}'>
	<table align='center' cellpadding='0' cellspacing='0' width='600'>
		<tr>
			<td width='50%' class='tbl'>
				{$locale.401}
			</td>
			<td width='50%' class='tbl'>
				<input type='text' name='wakka_name' value='{$settings2.wiki_wakka_name}' maxlength='50' class='textbox' style='width:250px;' />
			</td>
		</tr>
		<tr>
			<td width='50%' class='tbl'>
				{$locale.402}
			</td>
			<td width='50%' class='tbl'>
				<input type='text' name='root_page' value='{$settings2.wiki_root_page}' maxlength='50' class='textbox' style='width:250px;' />
			</td>
		</tr>
		<tr>
			<td class='tbl' width='50%'>
				{$locale.409}
			</td>
			<td class='tbl' width='50%'>
				<select name='admin_group' class='textbox'>
				{section name=id loop=$usergroups}
					<option value='{$usergroups[id].0}'{if $usergroups[id].0 == $settings2.wiki_admin_group} selected="selected"{/if}>{$usergroups[id].1}</option>
				{/section}
				</select>
			</td>
		</tr>
		<tr>
			<td width='50%' class='tbl'>
				{$locale.403}
			</td>
			<td width='50%' class='tbl'>
				<textarea name='navigation_links' rows='3' cols='80' class='textbox' style='width:250px;'>{$settings2.wiki_navigation_links}</textarea>
			</td>
		</tr>
		<tr>
			<td width='50%' class='tbl'>
				{$locale.404}
			</td>
			<td width='50%' class='tbl'>
				<textarea name='logged_in_navigation_links' rows='3' cols='80' class='textbox' style='width:250px;'>{$settings2.wiki_logged_in_navigation_links}</textarea>
			</td>
		</tr>
		<tr>
			<td width='50%' class='tbl'>
				{$locale.408}
			</td>
			<td width='50%' class='tbl'>
				<select name='external_link_new_window' class='textbox'>
					<option value='0'{if $settings2.wiki_external_link_new_window == "0"} selected="selected"{/if}>{$locale.414}</option>
					<option value='1'{if $settings2.wiki_external_link_new_window == "1"} selected="selected"{/if}>{$locale.413}</option>
				</select>
			</td>
		</tr>
		<tr>
			<td class='tbl' width='50%'>
				{$locale.410}
			</td>
			<td class='tbl' width='50%'>
				<select name='default_read_acl' class='textbox'>
				{section name=id loop=$usergroups}
					<option value='{$usergroups[id].0}'{if $usergroups[id].0 == $settings2.wiki_default_read_acl} selected="selected"{/if}>{$usergroups[id].1}</option>
				{/section}
				</select>
			</td>
		</tr>
		<tr>
			<td class='tbl' width='50%'>
				{$locale.411}
			</td>
			<td class='tbl' width='50%'>
				<select name='default_write_acl' class='textbox'>
				{section name=id loop=$usergroups}
					<option value='{$usergroups[id].0}'{if $usergroups[id].0 == $settings2.wiki_default_write_acl} selected="selected"{/if}>{$usergroups[id].1}</option>
				{/section}
				</select>
			</td>
		</tr>
		<tr>
			<td width='50%' class='tbl'>
				{$locale.406}
			</td>
			<td width='50%' class='tbl'>
				<select name='require_edit_note' class='textbox'>
					<option value='2'{if $settings2.wiki_require_edit_note == "2"} selected="selected"{/if}>{$locale.415}</option>
					<option value='0'{if $settings2.wiki_require_edit_note == "0"} selected="selected"{/if}>{$locale.416}</option>
					<option value='1'{if $settings2.wiki_require_edit_note == "1"} selected="selected"{/if}>{$locale.413}</option>
				</select>
			</td>
		</tr>
		<tr>
			<td width='50%' class='tbl'>
				{$locale.405}
			</td>
			<td width='50%' class='tbl'>
				<select name='hide_comments' class='textbox'>
					<option value='0'{if $settings2.wiki_hide_comments == "0"} selected="selected"{/if}>{$locale.413}</option>
					<option value='1'{if $settings2.wiki_hide_comments == "1"} selected="selected"{/if}>{$locale.414}</option>
				</select>
			</td>
		</tr>
		<tr>
			<td class='tbl' width='50%'>
				{$locale.412}
			</td>
			<td class='tbl' width='50%'>
				<select name='default_comment_acl' class='textbox'>
				{section name=id loop=$usergroups}
					<option value='{$usergroups[id].0}'{if $usergroups[id].0 == $settings2.wiki_default_comment_acl} selected="selected"{/if}>{$usergroups[id].1}</option>
				{/section}
				</select>
			</td>
		</tr>
		<tr>
			<td width='50%' class='tbl'>
				{$locale.407}
			</td>
			<td width='50%' class='tbl'>
				<select name='anony_delete_own_comments' class='textbox'>
					<option value='0'{if $settings2.wiki_anony_delete_own_comments == "0"} selected="selected"{/if}>{$locale.414}</option>
					<option value='1'{if $settings2.wiki_anony_delete_own_comments == "1"} selected="selected"{/if}>{$locale.413}</option>
				</select>
				<span class='small'>{$locale.420}</span>
			</td>
		</tr>
		<tr>
			<td align='center' colspan='2' class='tbl'>
				<br />
				<input type='submit' name='savesettings' value='{$locale.419}' class='button' />
			</td>
		</tr>
	</table>
</form>	
{include file="_closetable.tpl"}
<script type='text/javascript'>
{literal}
{/literal}
</script>
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}