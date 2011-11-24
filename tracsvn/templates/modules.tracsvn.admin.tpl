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
{* $Id:: modules.tracsvn.admin.tpl 2093 2008-12-05 20:43:27Z WanWizard    $*}
{*-------------------------------------------------------------------------*}
{* Last modified by $Author:: WanWizard                                   $*}
{* Revision number $Rev:: 2093                                            $*}
{***************************************************************************}
{*                                                                         *}
{* This template generates the tracsvn admin panel                         *}
{*                                                                         *}
{***************************************************************************}
{include file="_opentable.tpl" name=$_name title=$locale.400 state=$_state style=$_style}
{if $message|default:"" != ""}
	<div align='center'>
		<br />
		<b>{$message}</b>
		<br /><br />
	</div>
{/if}
<form name='settingsform' method='post' action='{$smarty.const.FUSION_SELF}{$aidlink}'>
	<table align='center' cellpadding='0' cellspacing='0' width='550'>
		<tr>
			<td width='50%' class='tbl'>
				{$locale.411}
			</td>
			<td width='50%' class='tbl'>
				<input type='text' name='database' value='{$database}' maxlength='255' class='textbox' style='width:230px;' />
			</td>
		</tr>
		<tr>
			<td width='50%' class='tbl'>
				{$locale.445}
			</td>
			<td width='50%' class='tbl'>
				<input type='text' name='cmd' value='{$cmd}' maxlength='255' class='textbox' style='width:230px;' />
			</td>
		</tr>
		<tr>
			<td width='50%' class='tbl'>
				{$locale.446}
			</td>
			<td width='50%' class='tbl'>
				<input type='text' name='auth' value='{$auth}' maxlength='255' class='textbox' style='width:300px;' />
			</td>
		</tr>
		<tr>
			<td width='50%' class='tbl'>
				{$locale.447}
			</td>
			<td width='50%' class='tbl'>
				<input type='text' name='url' value='{$url}' maxlength='255' class='textbox' style='width:300px;' />
			</td>
		</tr>
		<tr>
			<td width='50%' class='tbl'>
				{$locale.457}
			</td>
			<td width='50%' class='tbl'>
				<input type='text' name='trac_url' value='{$trac_url}' maxlength='255' class='textbox' style='width:300px;' />
			</td>
		<tr>
			<td width='50%' class='tbl'>
				{$locale.448}
			</td>
			<td width='50%' class='tbl'>
				<input type='text' name='extensions' value='{$extensions}' maxlength='255' class='textbox' style='width:300px;' />
			</td>
		</tr>
		<tr>
			<td width='50%' class='tbl' valign='top'>
				{$locale.456}
			</td>
			<td width='50%' class='tbl'>
				<textarea name='svn_filter' rows='6' cols='50' class='textbox' style='width:300px;'>{$svn_filter}</textarea>
			</td>
		</tr>
		<tr>
			<td width='50%' class='tbl'>
				{$locale.450}
			</td>
			<td width='50%' class='tbl'>
				<select name='view_svn' class='textbox'>
				{section name=id loop=$usergroups}
					<option value='{$usergroups[id].0}'{if $usergroups[id].0 == $view_svn} selected="selected"{/if}>{$usergroups[id].1}</option>
				{/section}
				</select>
			</td>
		</tr>
		<tr>
			<td width='50%' class='tbl'>
				{$locale.451}
			</td>
			<td width='50%' class='tbl'>
				<select name='view_diff' class='textbox'>
				{section name=id loop=$usergroups}
					<option value='{$usergroups[id].0}'{if $usergroups[id].0 == $view_diff} selected="selected"{/if}>{$usergroups[id].1}</option>
				{/section}
				</select>
			</td>
		</tr>
		<tr>
			<td width='50%' class='tbl'>
				{$locale.452}
			</td>
			<td width='50%' class='tbl'>
				<select name='view_file' class='textbox'>
				{section name=id loop=$usergroups}
					<option value='{$usergroups[id].0}'{if $usergroups[id].0 == $view_file} selected="selected"{/if}>{$usergroups[id].1}</option>
				{/section}
				</select>
			</td>
		</tr>
		<tr>
			<td align='center' colspan='2' class='tbl'>
				<br />
				<input type='submit' name='savesettings' value='{$locale.410}' class='button' />
			</td>
		</tr>
	</table>
</form>	
{include file="_closetable.tpl"}
{include file="_opentable.tpl" name=$_name title=$locale.407 state=$_state style=$_style}
<form name='aliasform' method='post' action='{$smarty.const.FUSION_SELF}{$aidlink}'>
	<table align='center' cellpadding='0' cellspacing='1' class='tbl-border' width='500'>
		<tr>
			<td class='tbl2' width='50%' align='center'>
				<b>{$locale.412}</b>
			</td>
			<td class='tbl2' width='50%' align='center'>
				<b>{$locale.413}</b>
			</td>
		</tr>
		{section name=id loop=$aliases}
			<tr>
				<td class='tbl1' align='center'>
					{$aliases[id].tracuser}
					<input type='hidden' name='tracuser[]' value='{$aliases[id].tracuser}' />
					<input type='hidden' name='orgmap[]' value='{$aliases[id].user_id}' />
				</td>
				<td class='tbl1' align='center'>
					<select name='username[]' class='textbox' style='width:200px;'>
						<option value='0'{if $aliases[id].user_id == 0} selected='selected'{/if}></option>
						{section name=usr loop=$members}
							<option value='{$members[usr].user_id}'{if $aliases[id].user_id == $members[usr].user_id} selected='selected'{/if}>{$members[usr].user_name}</option>
						{/section}
					</section>
				</td>
			</tr>
		{sectionelse}
			<tr>
				<td class='tbl1' colspan='2' align='center'>
					{$locale.409}
				</td>
			</tr>
		{/section}
	</table>
	<br />
	<table align='center' cellpadding='0' cellspacing='0' width='500'>
		<tr>
			<td align='center' colspan='2' class='tbl'>
				<input type='submit' name='savealias' value='{$locale.408}' class='button' />
			</td>
		</tr>
	</table>
</form>
{include file="_closetable.tpl"}
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}
