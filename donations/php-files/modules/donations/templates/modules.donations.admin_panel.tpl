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
		alert('you have to fill in an amount!');
		return false;
	}
	return true;
}

</script>
{/literal}
{if $error|default:"" != ""}
	{include file="_opentable.tpl" name=$_name title="" state=$_state style=$_style}
	<div align='center'>
	<b>{$error}</b>
	</div>
	{include file="_closetable.tpl"}
{/if}
{include file="_opentable.tpl" name=$_name title=$_title state=$_state style=$_style}
<form name='{$action}_donate' method='post' action='{$smarty.const.FUSION_SELF}{$aidlink}&amp;action={$action}&amp;id={$id}'>
<table align='center' cellpadding='0' cellspacing='0'>
	<tr>
		<td align='right' class='tbl'>
			{$locale.don212} :
		</td>
		<td class='tbl'>
			<input type='text' name='donate_name' value='{$donate_name}' class='textbox' style='width:250px' />
		</td>
	</tr>
	<tr>
		<td align='right' class='tbl'>
			{$locale.don219} :
		</td>
		<td class='tbl'>
			<select name='donate_country' class='textbox' style='width:225px;'>
			{section name=cc loop=$countries}
			<option value='{$countries[cc].ip_code}'{if $countries[cc].ip_code == $donate_country} selected="selected"{/if}>{$countries[cc].ip_name}</option>
			{/section}
			</select>
		</td>
	</tr>
	<tr>
		<td align='right' width='175' class='tbl'>
			{$locale.don213} :
		</td>
		<td class='tbl'>
			<input type='text' name='donate_amount' value='{$donate_amount}' class='textbox' style='width:75px;' maxlength='30' onkeypress='return(currencyFormat(this,\",\",\".\",event))' />
		</td>
	</tr>
	<tr>
		<td align='right' width='175' class='tbl'>
			{$locale.don218} :
		</td>
		<td class='tbl'>
			<input type='text' name='donate_currency' value='{$donate_currency}' class='textbox' style='width:50px;' />
		</td>
	</tr>
	<tr>
		<td align='right' width='175' class='tbl'>
			{$locale.don214} :
		</td>
		<td class='tbl'>
			<input type='text' name='donate_comment' value='{$donate_comment}' class='textbox' style='width:250px' />
		</td>
	</tr>
	<tr>
		<td align='right' width='175' class='tbl'>
			{$locale.don217} :
		</td>
		<td class='tbl'>
			<select name='donate_type' class='textbox'{if  $donate_type == "0"} disabled="disabled"{/if}>
				{if $action == "edit"}<option value='0'{if $donate_type == "0"} selected="selected"{/if}>{$locale.don425}</option>{/if}
				<option value='1'{if $donate_type == "1"} selected="selected"{/if}>{$locale.don426}</option>
				<option value='2'{if $donate_type == "2"} selected="selected"{/if}>{$locale.don427}</option>
			</select>
		</td>
	</tr>
	<tr>
		<td align='center' colspan='2' class='tbl'>
			<input type='hidden' name='donate_id' value='{$donate_id}' />
			<input type='hidden' name='donate_state' value='{$donate_state}' />
			<input type='hidden' name='donate_timestamp' value='{$donate_timestamp}' />
			{if $action == "add"}
				<input type='submit' name='save' value='{$locale.don430}' class='button' />
			{elseif $action == "edit"}
				<input type='submit' name='save' value='{$locale.don431}' class='button' />
			{/if}
		</td>
	</tr>
</table>
</form>
{include file="_closetable.tpl"}
{include file="_opentable.tpl" name=$_name title=$locale.don402 state=$_state style=$_style}
<form name='donate_notify' method='post' action='{$smarty.const.FUSION_SELF}{$aidlink}&amp;action=notify'>
	<table align='center' cellpadding='0' cellspacing='0' width='500' class='tbl-border'>
		<tr>
			<td>
				<table cellpadding='0' cellspacing='0' width='100%'>
					<tr>
						<td class='tbl1' style='text-align:center;'>
							{$locale.don451} :
							<select name='new_forum_id' class='textbox' style='width:300px;'>
								<option value='0'{if $settings.donate_forum_id == 0} selected="selected"{/if}>{$locale.don450}</option>
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
						<td class='tbl1' style='text-align:center;'>
							<input type='submit' name='save_notify' value='{$locale.don431}' class='button' />
							<input type='hidden' name='forum_id' value='{$settings.donate_forum_id}' />
						</td>
					</tr>
					<tr>
						<td class='tbl1' style='text-align:center;'>
							<span class='small2'>
								{ssprintf format=$locale.don452 var1=$locale.don453}
							</span>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</form>
{include file="_closetable.tpl"}
{include file="_opentable.tpl" name=$_name title=$locale.don000 state=$_state style=$_style}
{if $rows > 0}
	<table align='center' cellpadding='0' cellspacing='1' width='800' class='tbl-border'>
		<tr>
			<td width='13%' align='center' class='tbl2'>
				<b>{$locale.don211}</b>
			</td>
			<td width='20%' align='center' class='tbl2'>
				<b>{$locale.don212}</b>
			</td>
			<td align='center' class='tbl2'>
				<b>{$locale.don214}</b>
			</td>
			<td width='15%' align='center' class='tbl2'>
				<b>{$locale.don217}</b>
			</td>
			<td width='15%' align='left' class='tbl2'>
				<b>{$locale.don420}</b>
			</td>
		</tr>
		{section name=id loop=$donations}
		<tr>
			<td align='center' class='{cycle values='tbl1,tbl2' advance=no}'>
				{$donations[id].donate_timestamp|date_format:"forumdate"}
			</td>
			<td align='center' class='{cycle values='tbl1,tbl2' advance=no}'>
				{if $donations[id].donate_name ==""}{$locale.don215}{else}{$donations[id].donate_name}{/if} ({$donations[id].donate_country})
			</td>
			<td align='left' class='{cycle values='tbl1,tbl2' advance=no}'>
				{$donations[id].donate_comment}
			</td>
			<td align='center' class='{cycle values='tbl1,tbl2' advance=no}'>
				{$donations[id].type}
			</td>
			<td align='left' class='{cycle values='tbl1,tbl2'}'>
				[<a href='{$smarty.const.FUSION_SELF}{$aidlink}&amp;action=edit&amp;id={$donations[id].donate_id}'>{$locale.don432}</a>]
				{if $donations[id].donate_state == '1'}
					[<a href='{$smarty.const.FUSION_SELF}{$aidlink}&amp;action=delete&amp;id={$donations[id].donate_id}' onclick='return DeleteItem()'>{$locale.don433}</a>]
				{/if}
			</td>
		</tr>
		{/section}
	</table>
	{if $rows > $smarty.const.ITEMS_PER_PAGE}
		<br />
		{makepagenav start=$rowstart count=$smarty.const.ITEMS_PER_PAGE total=$rows range=3 link=$pagenav_url}
	{/if}
	<br />
	<form name='add' method='post' action='{$smarty.const.FUSION_SELF}{$aidlink}&amp;action=add'>
		<center>
			<input type='submit' name='add' value='{$locale.don434}' class='button' />
		</center>
	</form>
	<script type='text/javascript'>
		function DeleteItem() {ldelim}
			return confirm('{$locale.don488}');
		{rdelim}
	</script>
{else}
	<center>
	{$locale.don302}
	<br />
	</center>
{/if}
{include file="_closetable.tpl"}
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}