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
{* Template for the module mail2forum - m2f_admin_panel                    *}
{*                                                                         *}
{***************************************************************************}
{if $step == "subscribers"}
	{include file="_opentable.tpl" name=$_name title=$locale.m2f350|cat:" <b>"|cat:$forum_name|cat:"</b>" state=$_state style=$_style}
	{section name=id loop=$subscribers}
		{if $smarty.section.id.first}
		<table align='center' cellpadding='0' cellspacing='1' width='400' class='tbl-border'>
			<tr>
				<td align='center' class='tbl2'>
					<b>{$locale.m2f352}</b>
				</td>
				<td align='center' class='tbl2'>
					<b>{$locale.m2f353}</b>
				</td>
				<td align='center' class='tbl2'>
					<b>{$locale.m2f354}</b>
				</td>
			</tr>
		{/if}
			<tr>
				<td align='center' class='tbl1'>
					{$subscribers[id].user_id}
				</td>
				<td align='center' class='tbl1'>
					{$subscribers[id].user_name}
				</td>
				<td align='center' class='tbl1'>
					{$subscribers[id].user_email}
				<td>
			</tr>
		{if $smarty.section.id.last}
		</table>
		{/if}
	{sectionelse}
		<br />
		<center>
		<b>{$locale.m2f351}</b>
		</center>
		<br />
	{/section}
	{include file="_closetable.tpl"}
{elseif $step == "config"}
	{include file="_opentable.tpl" name=$_name title=$locale.m2f500 state=$_state style=$_style}
	<form name='settingsform' method='post' action='{$smarty.const.FUSION_SELF}{$aidlink}'>
		<table align='center' cellpadding='0' cellspacing='0' width='500'>
			<tr>
				<td width='50%' class='tbl'>
					{$locale.m2f502}
				</td>
				<td width='50%' class='tbl'>
					<input type='text' name='m2f_host' value='{$settings.m2f_host}' maxlength='255' class='textbox' style='width:230px;' />
				</td>
			</tr>
			<tr>
				<td width='10%' align='left' colspan='2' class='tbl'>
					<span class='small2'>{$locale.m2f502a}</span>
				</td>
			</tr>
			<tr>
				<td width='50%' class='tbl'>
					{$locale.m2f503}
				</td>
				<td width='50%' class='tbl'>
					<input type='text' name='m2f_interval' value='{$settings.m2f_interval}' maxlength='5' class='textbox' style='width:50px;' />
				</td>
			</tr>
			<tr>
				<td width='10%' align='left' colspan='2' class='tbl'>
					<span class='small2'>{$locale.m2f503a}</span>
				</td>
			</tr>
			<tr>
				<td width='50%' class='tbl'>
					{$locale.m2f504}
				</td>
				<td width='50%' class='tbl'>
					<input type='text' name='m2f_poll_threshold' value='{$settings.m2f_poll_threshold}' maxlength='8' class='textbox' style='width:100px;' />
					<input type='submit' name='poll_restart' value='{$locale.m2f505}' class='button' />
				</td>
			</tr>
			<tr>
				<td width='10%' align='left' colspan='2' class='tbl'>
					<span class='small2'>{$locale.m2f504a}</span>
				</td>
			</tr>
			<tr>
				<td width='50%' class='tbl'>
					{$locale.m2f506}
				</td>
				<td width='50%' class='tbl'>
					<input type='text' name='m2f_max_attachments' value='{$settings.m2f_max_attachments}' maxlength='5' class='textbox' style='width:50px;' />
				</td>
			</tr>
			<tr>
				<td width='10%' align='left' colspan='2' class='tbl'>
					<span class='small2'>{$locale.m2f506a}</span>
				</td>
			</tr>
			<tr>
				<td width='50%' class='tbl'>
					{$locale.m2f507}
				</td>
				<td width='50%' class='tbl'>
					<input type='text' name='m2f_max_attach_size' value='{$settings.m2f_max_attach_size}' maxlength='8' class='textbox' style='width:100px;' />
				</td>
			</tr>
			<tr>
				<td width='10%' align='left' colspan='2' class='tbl'>
					<span class='small2'>{$locale.m2f507a}</span>
				</td>
			</tr>
			<tr>
				<td width='50%' class='tbl'>
					{$locale.m2f508}
				</td>
				<td width='50%' class='tbl'>
					<select name='m2f_use_forum_email' class='textbox'>
						<option value='0'{if $settings.m2f_use_forum_email == "0"} selected="selected"{/if}>{$locale.m2f306}</option>
						<option value='1'{if $settings.m2f_use_forum_email == "1"} selected="selected"{/if}>{$locale.m2f307}</option>
					</select>
				</td>
			</tr>
			<tr>
				<td width='10%' align='left' colspan='2' class='tbl'>
					<span class='small2'>{$locale.m2f508a}</span>
				</td>
			</tr>
			<tr>
				<td width='50%' class='tbl'>
					{$locale.m2f509}
				</td>
				<td width='50%' class='tbl'>
					<select name='m2f_follow_thread' class='textbox'>
						<option value='0'{if $settings.m2f_follow_thread == "0"} selected="selected"{/if}>{$locale.m2f306}</option>
						<option value='1'{if $settings.m2f_follow_thread == "1"} selected="selected"{/if}>{$locale.m2f307}</option>
					</select>
				</td>
			</tr>
			<tr>
				<td width='10%' align='left' colspan='2' class='tbl'>
					<span class='small2'>{$locale.m2f509a}</span>
				</td>
			</tr>
			<tr>
				<td width='50%' class='tbl'>
					{$locale.m2f510}
				</td>
				<td width='50%' class='tbl'>
					<select name='m2f_subscribe_required' class='textbox'>
						<option value='0'{if $settings.m2f_subscribe_required == "0"} selected="selected"{/if}>{$locale.m2f306}</option>
						<option value='1'{if $settings.m2f_subscribe_required == "1"} selected="selected"{/if}>{$locale.m2f307}</option>
					</select>
				</td>
			</tr>
			<tr>
				<td width='10%' align='left' colspan='2' class='tbl'>
					<span class='small2'>{$locale.m2f510a}</span>
				</td>
			</tr>
			<tr>
				<td width='50%' class='tbl'>
					{$locale.m2f511}
				</td>
				<td width='50%' class='tbl'>
					<select name='m2f_send_ndr' class='textbox'>
						<option value='0'{if $settings.m2f_send_ndr == "0"} selected="selected"{/if}>{$locale.m2f306}</option>
						<option value='1'{if $settings.m2f_send_ndr == "1"} selected="selected"{/if}>{$locale.m2f307}</option>
					</select>
				</td>
			</tr>
			<tr>
				<td width='10%' align='left' colspan='2' class='tbl'>
					<span class='small2'>{$locale.m2f511a}</span>
				</td>
			</tr>
			<tr>
				<td width='50%' class='tbl'>
					{$locale.m2f512}
				</td>
				<td width='50%' class='tbl'>
					<input type='text' name='m2f_pop3_server' value='{$settings.m2f_pop3_server}' maxlength='255' class='textbox' style='width:230px;' />
				</td>
			</tr>
			<tr>
				<td width='10%' align='left' colspan='2' class='tbl'>
					<span class='small2'>{$locale.m2f512a}</span>
				</td>
			</tr>
			<tr>
				<td width='50%' class='tbl'>
					{$locale.m2f513}
				</td>
				<td width='50%' class='tbl'>
					<input type='text' name='m2f_pop3_port' value='{$settings.m2f_pop3_port}' maxlength='5' class='textbox' style='width:100px;' />
				</td>
			</tr>
			<tr>
				<td width='10%' align='left' colspan='2' class='tbl'>
					<span class='small2'>{$locale.m2f513a}</span>
				</td>
			</tr>
			<tr>
				<td width='50%' class='tbl'>
					{$locale.m2f514}
				</td>
				<td width='50%' class='tbl'>
					<input type='text' name='m2f_pop3_timeout' value='{$settings.m2f_pop3_timeout}' maxlength='5' class='textbox' style='width:50px;' />
				</td>
			</tr>
			<tr>
				<td width='10%' align='left' colspan='2' class='tbl'>
					<span class='small2'>{$locale.m2f514a}</span>
				</td>
			</tr>
			<tr>
				<td width='50%' class='tbl'>
					{$locale.m2f515}
				</td>
				<td width='50%' class='tbl'>
					<input type='text' name='m2f_logfile' value='{$settings.m2f_logfile}' maxlength='255' class='textbox' style='width:230px;' />
				</td>
			</tr>
			<tr>
				<td width='10%' align='left' colspan='2' class='tbl'>
					<span class='small2'>{$locale.m2f515a}</span>
				</td>
			</tr>
			<tr>
				<td width='50%' class='tbl'>
					{$locale.m2f516}
				</td>
				<td width='50%' class='tbl'>
					<select name='m2f_process_log' class='textbox'>
						<option value='0'{if $settings.m2f_process_log == "0"} selected="selected"{/if}>{$locale.m2f306}</option>
						<option value='1'{if $settings.m2f_process_log == "1"} selected="selected"{/if}>{$locale.m2f307}</option>
					</select>
				</td>
			</tr>
			<tr>
				<td width='10%' align='left' colspan='2' class='tbl'>
					<span class='small2'>{$locale.m2f516a}</span>
				</td>
			</tr>
			<tr>
				<td width='50%' class='tbl'>
					{$locale.m2f517}
				</td>
				<td width='50%' class='tbl'>
					<select name='m2f_smtp_log' class='textbox'>
						<option value='0'{if $settings.m2f_smtp_log == "0"} selected="selected"{/if}>{$locale.m2f306}</option>
						<option value='1'{if $settings.m2f_smtp_log == "1"} selected="selected"{/if}>{$locale.m2f307}</option>
					</select>
				</td>
			</tr>
			<tr>
				<td width='10%' align='left' colspan='2' class='tbl'>
					<span class='small2'>{$locale.m2f517a}</span>
				</td>
			</tr>
			<tr>
				<td width='50%' class='tbl'>
					{$locale.m2f518}
				</td>
				<td width='50%' class='tbl'>
					<select name='m2f_pop3_debug' class='textbox'>
						<option value='0'{if $settings.m2f_pop3_debug == "0"} selected="selected"{/if}>{$locale.m2f306}</option>
						<option value='1'{if $settings.m2f_pop3_debug == "1"} selected="selected"{/if}>{$locale.m2f307}</option>
					</select>
				</td>
			</tr>
			<tr>
				<td width='10%' align='left' colspan='2' class='tbl'>
					<span class='small2'>{$locale.m2f518a}</span>
				</td>
			</tr>
			<tr>
				<td width='50%' class='tbl'>
					{$locale.m2f519}
				</td>
				<td width='50%' class='tbl'>
					<select name='m2f_pop3_message_debug' class='textbox'>
						<option value='0'{if $settings.m2f_pop3_message_debug == "0"} selected="selected"{/if}>{$locale.m2f306}</option>
						<option value='1'{if $settings.m2f_pop3_message_debug == "1"} selected="selected"{/if}>{$locale.m2f307}</option>
					</select>
				</td>
			</tr>
			<tr>
				<td width='10%' align='left' colspan='2' class='tbl'>
					<span class='small2'>{$locale.m2f519a}</span>
				</td>
			</tr>
			<tr>
				<td width='50%' class='tbl'>
					{$locale.m2f520}
				</td>
				<td width='50%' class='tbl'>
					<select name='m2f_smtp_debug' class='textbox'>
						<option value='0'{if $settings.m2f_smtp_debug == "0"} selected="selected"{/if}>{$locale.m2f306}</option>
						<option value='1'{if $settings.m2f_smtp_debug == "1"} selected="selected"{/if}>{$locale.m2f307}</option>
					</select>
				</td>
			</tr>
			<tr>
				<td width='10%' align='left' colspan='2' class='tbl'>
					<span class='small2'>{$locale.m2f520a}</span>
				</td>
			</tr>
			<tr>
				<td align='center' colspan='2' class='tbl'>
					<br />
					<input type='submit' name='saveconfig' value='{$locale.m2f501}' class='button' />
				</td>
			</tr>
		</table>
	</form>
	{include file="_closetable.tpl"}
{else}
	{include file="_opentable.tpl" name=$_name title=$locale.m2f500 state=$_state style=$_style}
	<form name='settingsform' method='post' action='{$smarty.const.FUSION_SELF}{$aidlink}&amp;step=config'>
		<center>
			<input type='submit' name='loadconfig' value='{$locale.m2f500}' class='button' />
		</center>
	</form>
	{include file="_closetable.tpl"}
	{include file="_opentable.tpl" name=$_name title=$locale.m2f100|cat:" - "|cat:$locale.m2f200 state=$_state style=$_style}
	{if $error != ""}
	<center>
	<br />
	<b>{$error}</b>
	<br /><br />
	</center>
	{/if}
	<form name='forum' method='post' action='{$smarty.const.FUSION_SELF}{$aidlink}'>
		<table align='center' cellpadding='0' cellspacing='1' width='95%' class='tbl-border'>
		{section name=id loop=$forums}
			{if $smarty.section.id.first}
			<tr>
				<td class='tbl2'>
					<b>{$locale.m2f201}</b>
				</td>
				<td align='center' width='1%' class='tbl2' style='white-space:nowrap' colspan='2'>
					<b>{$locale.m2f202}</b>
				</td>
				<td align='center' width='1%' class='tbl2' style='white-space:nowrap' colspan='2'>
					<b>{$locale.m2f214}</b>
				</td>
				<td align='center' width='1%' class='tbl2' style='white-space:nowrap'>
					<b>{$locale.m2f205}</b>
				</td>
				<td align='center' width='1%' class='tbl2' style='white-space:nowrap'>
					<b>{$locale.m2f213}</b>
				</td>
				<td align='center' width='1%' class='tbl2' style='white-space:nowrap'>
					<b>{$locale.m2f203}</b>
				</td>
			</tr>
			{/if}
			<tr>
				<td class='tbl1'>
					{$forums[id].forum_name}
					<input type='hidden' name='forum_name' value='{$forums[id].forum_name}' />
				</td>
				<td align='center' width='1%' class='tbl1' style='white-space:nowrap'>
					{$forums[id].forum_posting_name}
					<input type='hidden' name='forum_posting' value='{$forums[id].forum_posting}' />
				</td>
				<td align='center' width='1%' class='tbl1' style='white-space:nowrap'>
					{$forums[id].m2f_subscribers}
				</td>
				<td align='center' width='1%' class='tbl1' style='white-space:nowrap'>
					<select name='m2f_type[{$smarty.section.id.index}]' class='textbox'>
						{foreach from=$mailtypes item=type name=mailtype}
						<option value='{$smarty.foreach.mailtype.index}'{if $smarty.foreach.mailtype.index == $forums[id].m2f_type} selected="selected"{/if}>{$type}</option>
						{/foreach}
					</select>
				</td>
				<td align='left' width='1%' class='tbl1' style='white-space:nowrap'>
					<input type='submit' name='config[{$smarty.section.id.index}]' value='{$locale.m2f210}' class='button' />
					{if $forums[id].m2f_config}
					<input type='submit' name='delete[{$smarty.section.id.index}]' value='{$locale.m2f215}' class='button' />
					<input type='hidden' name='m2f_id[{$smarty.section.id.index}]' value='{$forums[id].m2f_id}' />
					{/if}
					<input type='hidden' name='m2f_forumid[{$smarty.section.id.index}]' value='{$forums[id].forum_id}' />
				</td>
				<td align='center' width='1%' class='tbl1' style='white-space:nowrap'>
					{if $forums[id].m2f_config}{$forums[id].m2f_sent}{else}0{/if}
				</td>
				<td align='center' width='1%' class='tbl1' style='white-space:nowrap'>
					{if $forums[id].m2f_config}{$forums[id].m2f_received}{else}0{/if}
				</td>
				<td align='left' width='1%' class='tbl1' style='white-space:nowrap'>
				{if $forums[id].m2f_config}
					{if $forums[id].m2f_subscribe}
						<a href='{$smarty.const.FUSION_SELF}{$aidlink}&amp;step=deactivate&amp;forum_id={$forums[id].forum_id}'><img src='{$smarty.const.THEME}images/cog_delete.gif' alt='{$locale.m2f219}' title='{$locale.m2f219}' /></a>
					{else}
						<a href='{$smarty.const.FUSION_SELF}{$aidlink}&amp;step=activate&amp;forum_id={$forums[id].forum_id}'><img src='{$smarty.const.THEME}images/cog_add.gif' alt='{$locale.m2f218}' title='{$locale.m2f218}' /></a>
					{/if}
					{if $forums[id].m2f_active}
						<a href='{$smarty.const.FUSION_SELF}{$aidlink}&amp;step=setstatus&amp;status=0&amp;forum_id={$forums[id].forum_id}'><img src='{$smarty.const.THEME}images/page_red.gif' alt='{$locale.m2f212}' title='{$locale.m2f212}' /></a>
					{else}
						<a href='{$smarty.const.FUSION_SELF}{$aidlink}&amp;step=setstatus&amp;status=1&amp;forum_id={$forums[id].forum_id}'><img src='{$smarty.const.THEME}images/page_green.gif' alt='{$locale.m2f211}' title='{$locale.m2f211}' /></a>
					{/if}
				{/if}
				{if $forums[id].m2f_subscribers > 0}
					<a href='{$smarty.const.FUSION_SELF}{$aidlink}&amp;step=subscribers&amp;forum_id={$forums[id].forum_id}'><img src='{$smarty.const.THEME}images/image_view.gif' alt='{$locale.m2f217}' title='{$locale.m2f217}'></a>
				{/if} 
				</td>
			</tr>
			{if $smarty.section.id.last}
			{/if}
		{sectionelse}
			<br />
			<center>
			<b>{$locale.m2f952}</b>
			</center>
			<br />
		{/section}
		</table>
	</form>
	{include file="_closetable.tpl"}
{/if}
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}
