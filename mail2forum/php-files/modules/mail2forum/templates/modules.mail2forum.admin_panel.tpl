{***************************************************************************}
{*                                                                         *}
{* PLi-Fusion CMS template: modules.m2f_admin_panel.tpl                    *}
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
{/if}
{include file="_opentable.tpl" name=$_name title=$locale.m2f100|cat:" - "|cat:$locale.m2f200 state=$_state style=$_style}
{if $error != ""}
<center>
<br />
<b>{$error}</b>
<br /><br />
</center>
{/if}
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
	<form name='forum' method='post' action='{$smarty.const.FUSION_SELF}{$aidlink}'>
	<tr>
		<td class='tbl1'>
			{$forums[id].forum_name}
			<input type='hidden' name='forum_name' value='{$forums[id].forum_name}'>
		</td>
		<td align='center' width='1%' class='tbl1' style='white-space:nowrap'>
			{$forums[id].forum_posting_name}
			<input type='hidden' name='forum_posting' value='{$forums[id].forum_posting}'>
		</td>
		<td align='center' width='1%' class='tbl1' style='white-space:nowrap'>
			{$forums[id].m2f_subscribers}
		</td>
		<td align='center' width='1%' class='tbl1' style='white-space:nowrap'>
			<select name='m2f_type' class='textbox'>
				{foreach from=$mailtypes item=type name=mailtype}
				<option value='{$smarty.foreach.mailtype.index}'{if $smarty.foreach.mailtype.index == $forums[id].m2f_type} selected{/if}>{$type}</option>
				{/foreach}
			</select>
		</td>
		<td align='left' width='1%' class='tbl1' style='white-space:nowrap'>
			<input type='submit' name='config' value='{$locale.m2f210}' class='button' />
			{if $forums[id].m2f_config}
			<input type='submit' name='delete' value='{$locale.m2f215}' class='button' />
			<input type='hidden' name='m2f_id' value='{$forums[id].m2f_id}' />
			{/if}
			<input type='hidden' name='m2f_forumid' value='{$forums[id].forum_id}' />
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
	</form>
	{if $smarty.section.id.last}
	{/if}
{sectionelse}
{/section}
</table>
{include file="_closetable.tpl"}
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}