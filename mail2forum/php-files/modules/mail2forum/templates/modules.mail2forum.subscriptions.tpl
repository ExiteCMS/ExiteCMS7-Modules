{***************************************************************************}
{*                                                                         *}
{* PLi-Fusion CMS template: modules.m2f_subscriptions.tpl                  *}
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
{* Template for the module mail2forum - m2f_subscriptions                  *}
{*                                                                         *}
{***************************************************************************}
{include file="_opentable.tpl" name=$_name title=$locale.m2f450 state=$_state style=$_style}
<table align='center' cellpadding='0' cellspacing='1' width='400' class='tbl-border'>
	<tr>
		<td align='left' class='tbl1'>
			{$locale.m2f990}
		</td>
	</tr>
</table>
<br />
<form name='configform' method='post' action='{$smarty.const.FUSION_SELF}'>
	<table align='center' cellpadding='0' cellspacing='0'>
	{if $config_message|default:"" != ""}
		<tr>
			<td align='center' colspan='2' class='tbl'>
				<b>{$config_message}</b>
				<br /><br />
			</td>
		</tr>
	{/if}
		<tr>
			<td class='tbl'>
				{$locale.m2f451}
			</td>
			<td class='tbl'>
				<select name='m2f_html' class='textbox' style='width:150px'>
				{foreach from=$ar_html item=choice name=fe}
				<option value='{$smarty.foreach.fe.index}'{if $smarty.foreach.fe.index == $config.m2f_html} selected{/if}>{$choice}</option>
				{/foreach}
				</select>
			</td>
		</tr>
		<tr>
			<td class='tbl'>
				{$locale.m2f454}
			</td>
			<td class='tbl'>
				<select name='m2f_attach' class='textbox' style='width:150px'>
				{foreach from=$ar_attach item=choice name=fe}
				<option value='{$smarty.foreach.fe.index}'{if $smarty.foreach.fe.index == $config.m2f_attach} selected{/if}>{$choice}</option>
				{/foreach}
				</select>
			</td>
		</tr>
		<tr>
			<td class='tbl'>
				{$locale.m2f458}
				<br />
				<span class='small2'>{$locale.m2f459}</span>
			</td>
			<td class='tbl'>
				<select name='m2f_inline' class='textbox' style='width:150px'>
				{foreach from=$ar_inline item=choice name=fe}
				<option value='{$smarty.foreach.fe.index}'{if $smarty.foreach.fe.index == $config.m2f_inline} selected{/if}>{$choice}</option>
				{/foreach}
				</select>
			</td>
		</tr>
		<tr>
			<td class='tbl'>
				{$locale.m2f462}
			</td>
			<td class='tbl'>
				<select name='m2f_thumbnail' class='textbox' style='width:150px'>
				{foreach from=$ar_thumbnail item=choice name=fe}
				<option value='{$smarty.foreach.fe.index}'{if $smarty.foreach.fe.index == $config.m2f_thumbnail} selected{/if}>{$choice}</option>
				{/foreach}
				</select>
			</td>
		</tr>
		<tr>
			<td align='center' colspan='2'>
				<input type='hidden' name='m2f_userid' value='{$userdata.user_id}' />
				<br/>
				<input type='submit' name='saveconfig' value='{$locale.m2f304}' class='button' />
			</td>
		</tr>
	</table>
</form>
{include file="_closetable.tpl"}
{include file="_opentable.tpl" name=$_name title=$locale.m2f404 state=$_state style=$_style}
{if $save_message|default:"" != ""}
<table align='center' cellpadding='0' cellspacing='1' width='400'>
	<tr>
		<td align='center' class='tbl1'>
			<b>{$locale.m2f951}</b>
		</td>
	</tr>
</table>
<br />
{/if}
<form name='settingsform' method='post' action='{$smarty.const.FUSION_SELF}'>
	<table align='center' cellpadding='0' cellspacing='1' width='90%' class='tbl-border'>
	{section name=id loop=$subscriptions}
		{if $smarty.section.id.first}
		<tr>
			<td width='' class='tbl2'>
				<b>{$locale.m2f400}</b>
			</td>
			<td align='center' width='80' class='tbl2' style='white-space:nowrap'>
				<b>{$locale.m2f401}</b>
			</td>
			<td width='' class='tbl2' style='white-space:nowrap'>
				<b>{$locale.m2f402}</b>
			</td>
		</tr>
		{/if}
		<tr>
			<td class='{cycle values='tbl1,tbl2' advance=no}'>
				{$subscriptions[id].forum_name}
				<input type='hidden' name='m2f_subid[{$smarty.section.id.index}]' value='{$subscriptions[id].m2f_subid}' />
				<input type='hidden' name='m2f_forumid[{$smarty.section.id.index}]' value='{$subscriptions[id].m2f_forumid}' />
				<input type='hidden' name='update[{$smarty.section.id.index}]' value='{$subscriptions[id].update}' />
			</td>
			<td align='center' class='{cycle values='tbl1,tbl2' advance=no}'>
				<select name='m2f_subscribed[{$smarty.section.id.index}]' class='textbox'>
					<option value='0'{if $subscriptions[id].subscribed == "0"} selected{/if}>{$locale.m2f306}</option>
					<option value='1'{if $subscriptions[id].subscribed == "1"} selected{/if}>{$locale.m2f307}</option>
				</select>
			</td>
			<td align='left' class='{cycle values='tbl1,tbl2' advance=no}' style='white-space:nowrap'>
				{$subscriptions[id].m2f_email}
			</td>
		</tr>
		{cycle values='tbl1,tbl2' print=no}
		{if $smarty.section.id.last}
		{/if}
	{sectionelse}
	<tr>
		<td align='center' class='tbl1'>
			<b>{$locale.m2f950}</b>
		</td>
	</tr>
	{/section}
	</table>
	<br />
	<table align='center' width='20%'>
		<tr>
			<td align='center' colspan='3'>
				<input type='submit' name='save' value='{$locale.m2f403}' class='button' />
			</td>
		</tr>
	</table>
</form>
{include file="_closetable.tpl"}
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}