{***************************************************************************}
{*                                                                         *}
{* PLi-Fusion CMS template: modules.m2f_admin_panel.edit.tpl               *}
{*                                                                         *}
{***************************************************************************}
{*                                                                         *}
{* Author: WanWizard <wanwizard@gmail.com>                                 *}
{*                                                                         *}
{* Revision History:                                                       *}
{* 2007-07-27 - WW - Initial version                                       *}
{*                                                                         *}
{***************************************************************************}
{*                                                                         *}
{* Template for the module mail2forum - m2f_admin_panel, add/edit settings *}
{*                                                                         *}
{***************************************************************************}
{include file="_opentable.tpl" name=$locale.m2f100|cat:" - "|cat:$locale.m2f300|cat:" '"|cat:$forum_name|cat:"'" state=$_state style=$_style}
{if $error != ""}
<center>
<br />
<b>{$error}</b>
<br />
</center>
{/if}
<form name='forumsettings' method='post' action='{$smarty.const.FUSION_SELF}{$aidlink}&amp;forum_id={$forum_id}'>
	<table align='center' cellpadding='0' cellspacing='0' width='500'>
{if $m2f_type_text == $locale.m2f230}			{*  SMTP/POP3  *}
		<tr>
			<td width='50%' class='tbl'>
				{$locale.m2f301}
			</td>
			<td width='50%' class='tbl'>
				<input type='text' name='m2f_email' value='{$m2f.m2f_email}' maxlength='255' class='textbox' style='width:230px;' />
			</td>
		</tr>
		<tr>
			<td width='50%' class='tbl'>
				{$locale.m2f302}
			</td>
			<td width='50%' class='tbl'>
				<input type='text' name='m2f_userid' value='{$m2f.m2f_userid}' maxlength='100' class='textbox' style='width:230px;' />
			</td>
		</tr>
		<tr>
			<td width='50%' class='tbl'>
				{$locale.m2f303}
			</td>
			<td width='50%' class='tbl'>
				<input type='text' name='m2f_password' value='{$m2f.m2f_password}' maxlength='100' class='textbox' style='width:230px;' />
			</td>
		</tr>
		<tr>
			<td width='50%' class='tbl'>
				{$locale.m2f310}
			</td>
			<td class='tbl' width='50%'>
				<select name='m2f_posting' class='textbox' style='width:225px;'>
				{section name=id loop=$posting_opts}
					<option value='{$posting_opts[id].id}'{if $posting_opts[id].selected} selected{/if}>{$posting_opts[id].name}</option>
				{/section}
				</select>
			</td>
		</tr>
		<tr>
			<td width='50%' class='tbl'>
				{$locale.m2f309}
			</td>
			<td class='tbl' width='50%'>
				<select name='m2f_subscribe' class='textbox'>
					<option value='0'{if $m2f.m2f_subscribe == "0"} selected{/if}>{$locale.m2f306}</option>
					<option value='1'{if $m2f.m2f_subscribe == "1"} selected{/if}>{$locale.m2f307}</option>
				</select>
			</td>
		</tr>
		<tr>
			<td width='50%' class='tbl'>
				{$locale.m2f308}
			</td>
			<td class='tbl'>
				<input type='hidden' name='forum_posting' value='{$forum_posting}' />
				<select name='m2f_access' class='textbox' style='width:225px;'>
				{section name=id loop=$access_opts}
					<option value='{$access_opts[id].id}'{if $access_opts[id].selected} selected{/if}>{$access_opts[id].name}</option>
				{/section}
				</select>
			</td>
		</tr>
		<tr>
			<td width='50%' class='tbl'>
				{$locale.m2f305}
			</td>
			<td class='tbl' width='50%'>
				<select name='m2f_active' class='textbox'>
					<option value='0'{if $m2f.m2f_active == "0"} selected{/if}>{$locale.m2f306}</option>
					<option value='1'{if $m2f.m2f_active == "1"} selected{/if}>{$locale.m2f307}</option>
				</select>
			</td>
		</tr>
{elseif $m2f_type_text == $locale.m2f231}		{* SMTP/IMAP *}
{elseif $m2f_type_text == $locale.m2f232}		{* GMail via HTTPS *}
{elseif $m2f_type_text == $locale.m2f233}		{* Majordomo listserver *}
{else}
		<tr>
			<td width='50%' class='tbl' colspan='2' align='center'>
				The '{$m2f_type_text}' method is not supported by this version of M2F!
			</td>
		</tr>
{/if}
		<tr>
			<td align='center' colspan='2' class='tbl'>
				<br />
				<input type='hidden' name='m2f_id' value='{$m2f.m2f_id|default:0}' />
				<input type='hidden' name='m2f_type' value='{$m2f_type}' />
				<input type='submit' name='savesettings' value='{$locale.m2f304}' class='button' />
				<input type='submit' name='back' value='{$locale.m2f216}' class='button' />
			</td>
		</tr>
	</table>
</form>
{include file="_closetable.tpl"}
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}