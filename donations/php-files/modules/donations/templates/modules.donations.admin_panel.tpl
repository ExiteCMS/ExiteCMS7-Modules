{***************************************************************************}
{*                                                                         *}
{* PLi-Fusion CMS template: infusions.donations.admin_panel.tpl            *}
{*                                                                         *}
{***************************************************************************}
{*                                                                         *}
{* Author: WanWizard <wanwizard@gmail.com>                                 *}
{*                                                                         *}
{* Revision History:                                                       *}
{* 2007-07-13 - WW - Initial version                                       *}
{*                                                                         *}
{***************************************************************************}
{*                                                                         *}
{* This template generates the donor admin panel of the donations system   *}
{*                                                                         *}
{***************************************************************************}
{literal}
<script language='javascript' type='text/javascript'>
/* This script and many more are available free online at
The JavaScript Source!! http://javascript.internet.com
Created by: Mario Costa |  */
function currencyFormat(fld, milSep, decSep, e) {
	var sep = 0;
	var key = '';
	var i = j = 0;
	var len = len2 = 0;
	var strCheck = '0123456789';
	var aux = aux2 = '';
	var whichCode = (window.Event) ? e.which : e.keyCode;
	if (whichCode == 8) return true;  // Delete
	if (whichCode == 13 || whichCode == 9 || whichCode == 0) {
		return true;
	}
	key = String.fromCharCode(whichCode);  // Get key value from key code
	if (strCheck.indexOf(key) == -1) return false;  // Not a valid key
	aux = fld.value;
	if (aux.indexOf(decSep) == -1) {
		fld.value = key + decSep + '00';
		return false;
	} else {
		len = aux.indexOf(decSep);
		aux = '';
		for(; i < len; i++)
			if (strCheck.indexOf(fld.value.charAt(i))!=-1) aux += fld.value.charAt(i);
		fld.value = aux + key + decSep + '00';
	}
	return false;
}

function InputIsValid() {
	if (document.paypal.amount.value == '') {
		alert('{/literal}{$locale.donerr00}{literal}');
		return false;
	}
	return true;
}

</script>
{/literal}
{if $error|default:"" != ""}
	{include file="_opentable.tpl" name=$_name title=$locale.don400 state=$_state style=$_style}
	<div style='color:red;font-weight:bold;text-align:center'>
	<br />{$error}<br /><br />
	</div>
	{include file="_closetable.tpl"}
{/if}
{if $action == "tpledit"}
	<script language="javascript" type="text/javascript" src="{$smarty.const.INCLUDES}editarea/edit_area_full_with_plugins.js"></script>
	{literal}
		<script language="javascript" type="text/javascript">
		editAreaLoader.init({
			id : "tpl"		// textarea id
			,syntax: "smarty"			// syntax to be uses for highgliting
			,start_highlight: true		// to display with highlight mode on start-up
			,language: "{/literal}{$settings.locale_code}{literal}"
			,display:"later"
			,font_size: 8
		});
		</script>
	{/literal}
	{include file="_opentable.tpl" name=$_name title=$locale.don423 state=$_state style=$_style}
	<form name='{$action}_donate' method='post' action='{$smarty.const.FUSION_SELF}{$aidlink}&amp;action={$action}&amp;lc={$lc}&amp;lk={$lk}'>
		<textarea id='tpl' name='tpl' cols='80' rows='30' class='textbox' style='width:100%;'>{$tpldata}</textarea>
		<div style='text-align:center;margin-top:10px;'>
			<input type='submit' name='save_template' value='{$locale.don425}' class='button' />
		</div>
	</form>
	{include file="_closetable.tpl"}
{elseif $action != ""}
	{include file="_opentable.tpl" name=$_name title=$_title state=$_state style=$_style}
	<form name='{$action}_donate' method='post' action='{$smarty.const.FUSION_SELF}{$aidlink}&amp;action={$action}&amp;id={$id}'>
	<table align='center' cellpadding='0' cellspacing='0'>
		<tr>
			<td align='right' class='tbl'>
				{$locale.don456} :
			</td>
			<td class='tbl'>
				<input type='text' name='donate_name' value='{$donate_name}' class='textbox' style='width:250px' />
			</td>
		</tr>
		<tr>
			<td align='right' class='tbl'>
				{$locale.don463} :
			</td>
			<td class='tbl'>
				<select name='donate_country' class='textbox' style='width:225px;'>
				{section name=cc loop=$countries}
				<option value='{$countries[cc].locales_key}'{if $countries[cc].locales_key == $donate_country} selected="selected"{/if}>{$countries[cc].locales_value}</option>
				{/section}
				</select>
			</td>
		</tr>
		<tr>
			<td align='right' width='175' class='tbl'>
				{$locale.don457} :
			</td>
			<td class='tbl'>
				<input type='text' name='donate_amount' value='{$donate_amount}' class='textbox' style='width:75px;' maxlength='30' onkeypress='return(currencyFormat(this,\",\",\".\",event))' />
			</td>
		</tr>
		<tr>
			<td align='right' width='175' class='tbl'>
				{$locale.don462} :
			</td>
			<td class='tbl'>
				<input type='text' name='donate_currency' value='{$donate_currency}' class='textbox' style='width:50px;' />
			</td>
		</tr>
		<tr>
			<td align='right' width='175' class='tbl'>
				{$locale.don458} :
			</td>
			<td class='tbl'>
				<input type='text' name='donate_comment' value='{$donate_comment}' class='textbox' style='width:250px' />
			</td>
		</tr>
		<tr>
			<td align='right' width='175' class='tbl'>
				{$locale.don461} :
			</td>
			<td class='tbl'>
				<select name='donate_type' class='textbox'{if  $donate_type == "0"} disabled="disabled"{/if}>
					{if $action == "edit"}<option value='0'{if $donate_type == "0"} selected="selected"{/if}>{$locale.don479}</option>{/if}
					<option value='1'{if $donate_type == "1"} selected="selected"{/if}>{$locale.don480}</option>
					<option value='2'{if $donate_type == "2"} selected="selected"{/if}>{$locale.don481}</option>
				</select>
			</td>
		</tr>
		<tr>
			<td align='center' colspan='2' class='tbl'>
				<input type='hidden' name='donate_id' value='{$donate_id}' />
				<input type='hidden' name='donate_state' value='{$donate_state}' />
				<input type='hidden' name='donate_timestamp' value='{$donate_timestamp}' />
				{if $action == "add"}
					<input type='submit' name='save' value='{$locale.don483}' class='button' />
				{elseif $action == "edit"}
					<input type='submit' name='save' value='{$locale.don484}' class='button' />
				{/if}
			</td>
		</tr>
	</table>
	</form>
	{include file="_closetable.tpl"}
{else}
	{include file="_opentable.tpl" name=$_name title=$locale.don477 state=$_state style=$_style}
	<form name='donate_settings' method='post' action='{$smarty.const.FUSION_SELF}{$aidlink}&amp;action=notify'>
		<table align='center' cellpadding='0' cellspacing='0' width='100%' class='tbl-border'>
			<tr>
				<td align='right' class='tbl1'>
					{$locale.don489} :
				</td>
				<td class='tbl1'>
					<select name='new_forum_id' class='textbox' style='width:300px;'>
						<option value='0'{if $settings.donate_forum_id == 0} selected="selected"{/if}>{$locale.don488}</option>
					{section name=id loop=$forums}
						{if $forums[id].forum_new_cat}
							{if !$smarty.section.id.first}</optgroup>{/if}
							<optgroup label='{$forums[id].forum_cat_name}'>
							{assign var='hasvalues' value=false}
						{else}
							<option value='{$forums[id].forum_id}'{if $forums[id].forum_id == $settings.donate_forum_id} selected="selected"{/if}>{$forums[id].forum_name}</option>
							{assign var='hasvalues' value=true}
						{/if}
						{if $smarty.section.id.last && $hasvalues}</optgroup>{/if}
					{/section}
					</select>
				</td>
			</tr>
			<tr>
				<td colspan='2' class='tbl1' style='text-align:center;'>
					<span class='small2'>
						{ssprintf format=$locale.don490 var1=$locale.don491}
					</span>
				</td>
			</tr>
			<tr>
				<td align='right' class='tbl1'>
					{$locale.don410} :
				</td>
				<td class='tbl1'>
					<select name='donate_use_sandbox' class='textbox'>
						<option value='0'{if $donate_use_sandbox == 0} selected="selected"{/if}>{$locale.don411}</option>
						<option value='1'{if $donate_use_sandbox == 1} selected="selected"{/if}>{$locale.don412}</option>
					</select>
				</td>
			</tr>
			{if $templates|@count}
			<tr>
				<td colspan='2' class='tbl1' style='text-align:center;'>
					<hr />
				</td>
			</tr>
			<tr>
				<td colspan='2' class='tbl1'>
					{$locale.don420}<br /><br />
					<table align='center' cellpadding='0' cellspacing='1' width='100%' class='tbl-border'>
						<tr>
							<td width='1%' align='center' class='tbl2' style='white-space:nowrap'>
								<b>{$locale.don422}</b>
							</td>
							<td width='1%' align='center' class='tbl2' style='white-space:nowrap'>
								<b>{$locale.don421}</b>
							</td>
							<td width='1%' align='center' class='tbl2' style='white-space:nowrap'>
								<b>{$locale.don478}</b>
							</td>
						</tr>
						{section name=id loop=$templates}
						<tr>
							<td align='center' class='{cycle values='tbl1,tbl2' advance=no}' style='white-space:nowrap'>
								{$templates[id].locale_name}
							</td>
							<td align='center' class='{cycle values='tbl1,tbl2' advance=no}' style='white-space:nowrap'>
								{$templates[id].pagename}
							</td>
							<td align='center' class='{cycle values='tbl1,tbl2'}' style='white-space:nowrap'>
								{imagelink link=$smarty.const.FUSION_SELF|cat:$aidlink|cat:"&amp;action=tpledit&amp;lc="|cat:$templates[id].locale_code|cat:"&amp;lk="|cat:$templates[id].locales_key image="page_edit.gif" alt=$locale.don485 title=$locale.don485}
							</td>
						</tr>
						{/section}
					</table>
				</td>
			</tr>
			<tr>
				<td colspan='2' class='tbl1' style='text-align:center;'>
					<hr />
				</td>
			</tr>
			{/if}
			<tr>
				<td colspan='2' class='tbl1' style='text-align:center;'>
					<br />
					<input type='submit' name='save_settings' value='{$locale.don484}' class='button' />
					<input type='hidden' name='forum_id' value='{$settings.donate_forum_id}' />
				</td>
			</tr>
		</table>
	</form>
	{include file="_closetable.tpl"}
{/if}
{include file="_opentable.tpl" name=$_name title=$locale.don400 state=$_state style=$_style}
{if $rows > 0}
	<table align='center' cellpadding='0' cellspacing='1' width='100%' class='tbl-border'>
		<tr>
			<td width='1%' align='center' class='tbl2' style='white-space:nowrap'>
				<b>{$locale.don455}</b>
			</td>
			<td width='1%' align='center' class='tbl2' style='white-space:nowrap'>
				<b>{$locale.don456}</b>
			</td>
			<td align='left' class='tbl2'>
				<b>{$locale.don458}</b>
			</td>
			<td width='1%' align='center' class='tbl2' style='white-space:nowrap'>
				<b>{$locale.don461}</b>
			</td>
			<td width='1%' align='center' class='tbl2' style='white-space:nowrap'>
				<b>{$locale.don478}</b>
			</td>
		</tr>
		{section name=id loop=$donations}
		<tr>
			<td align='center' class='{cycle values='tbl1,tbl2' advance=no}' style='white-space:nowrap'>
				{$donations[id].donate_timestamp|date_format:"forumdate"}
			</td>
			<td align='center' class='{cycle values='tbl1,tbl2' advance=no}' style='white-space:nowrap'>
				{if $donations[id].donate_name ==""}{$locale.don459}{else}{$donations[id].donate_name}{/if} ({$donations[id].donate_country})
			</td>
			<td align='left' class='{cycle values='tbl1,tbl2' advance=no}'>
				{$donations[id].donate_comment}
			</td>
			<td align='center' class='{cycle values='tbl1,tbl2' advance=no}' style='white-space:nowrap'>
				{$donations[id].type}
			</td>
			<td align='center' class='{cycle values='tbl1,tbl2'}' style='white-space:nowrap'>
				{imagelink link=$smarty.const.FUSION_SELF|cat:$aidlink|cat:"&amp;action=edit&amp;id="|cat:$donations[id].donate_id image="page_edit.gif" alt=$locale.don485 title=$locale.don485}
				{if $donations[id].donate_state == '1'}
					&nbsp;
					{imagelink link=$smarty.const.FUSION_SELF|cat:$aidlink|cat:"&amp;action=delete&amp;id="|cat:$donations[id].donate_id image="page_delete.gif" onclick="return DeleteItem()" alt=$locale.don486 title=$locale.don486}
				{/if}
			</td>
		</tr>
		{/section}
	</table>
	{if $rows > $settings.numofthreads}
		<br />
		{makepagenav start=$rowstart count=$settings.numofthreads total=$rows range=3 link=$pagenav_url}
	{/if}
	<br />
	<form name='add' method='post' action='{$smarty.const.FUSION_SELF}{$aidlink}&amp;action=add'>
		<center>
			<input type='submit' name='add' value='{$locale.don483}' class='button' />
		</center>
	</form>
	<script type='text/javascript'>
		function DeleteItem() {ldelim}
			return confirm('{$locale.donerr09}');
		{rdelim}
	</script>
{else}
	<center>
	{$locale.don472}
	<br />
	</center>
{/if}
{include file="_closetable.tpl"}
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}
