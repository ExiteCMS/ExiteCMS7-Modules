{***************************************************************************}
{*                                                                         *}
{* PLi-Fusion CMS template: infusions.donation.index.tpl                   *}
{*                                                                         *}
{***************************************************************************}
{*                                                                         *}
{* Author: WanWizard <wanwizard@gmail.com>                                 *}
{*                                                                         *}
{* Revision History:                                                       *}
{* 2007-07-09 - WW - Initial version                                       *}
{*                                                                         *}
{***************************************************************************}
{*                                                                         *}
{* This template generates the index page of the PLi-Fusion Donations      *}
{* installable module (infusion)                                           *}
{*                                                                         *}
{***************************************************************************}
{include file="_opentable.tpl" name=$_name title=$locale.don000 state=$_state style=$_style}
{literal}<script language='javascript' type='text/javascript'>
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

</script>{/literal}
<table align='center' border='0' cellspacing='1' cellpadding='0' width='700' class=''>
	<tr>
		<td colspan='3' align='left' class='donate_title'>
			<br />
			<p>{$locale.don101}</p>
			<hr />		
		</td>
	</tr>
	<tr>
		<td colspan='3' align='left'>
			{$locale.don102}
		</td>
	</tr>
	<tr>
		<td colspan='3' align='left' class='donate_title'>
			<br />
			<p>{$locale.don111}</p>
			<hr />		
		</td>
	</tr>
	<tr>
		<td colspan='3' align='left'>
			{$locale.don112}
		</td>
	</tr>
	<tr>
		<td colspan='3' align='left' class='donate_title'>
			<br />
			<p>{$locale.don121}</p>
			<hr />		
		</td>
	</tr>
	<tr>
		<td colspan='3' align='left'>
			{$locale.don121a}
		</td>
	</tr>
	<tr>
		<td align='center' style=''>
			<table class='donate_box'>
				<tr valign='top'>
					<td></td>
					<td style='height:30px;'>
						<center><big><b>{$locale.don122}</b></big></center>
					</td>
				</tr>
				<tr>
					<td colspan='2' valign='top'>
						{$locale.don123}
						<form name='paypal' action='{$form_url}' method='post' onsubmit='return InputIsValid()'>
							<!-- hidden data -->
							<input type='hidden' name='business' value='{$form_account}' />
							<input type='hidden' name='item_name' value='{$locale.don124}' />
							<input type='hidden' name='item_number' value='1' />
							<input type='hidden' name='no_note' value='0' />
							<input type='hidden' name='cmd' value='_xclick' />
							<input type='hidden' name='on0' value='Anonymity' />
							<input type='hidden' name='on1' value='Comment' /> 
							<input type='hidden' name='lc' value='{$user_cccode}' />
							<input type='hidden' name='rm' value='2' />
							<input type='hidden' name='no_shipping' value='1' />
							<input type='hidden' name='return' value='{$settings.siteurl}modules/donations/thanks.php' />
							<input type='hidden' name='cancel_return' value='{$settings.siteurl}modules/donations/index.php' />
							<input type='hidden' name='notify_url' value='{$settings.siteurl}modules/donations/notify.php' />
							<!-- amount field -->
							<label for='don-amount'><b>{$locale.don130}</b></label>
							<br /><br />
							<!-- currency menu -->
							<select name='currency_code' size='1'>
								<option value='EUR'>EUR&#160;–&#160;€</option>
								<option value='GBP'>GBP&#160;–&#160;£</option>
								<option value='USD'>USD&#160;–&#160;$</option>
								<option value='AUD'>AUD&#160;–&#160;$&#160;</option>
								<option value='CAD'>CAD&#160;–&#160;$</option>
								<option value='CHF'>CHF&#160;–&#160;F</option>
								<option value='CZK'>CZK&#160;–&#160;Kc</option>
								<option value='DKK'>DKK&#160;–&#160;kr</option>
								<option value='HKD'>HKD&#160;–&#160;HK$</option>
								<option value='HUF'>HUF&#160;–&#160;Ft</option>
								<option value='JPY'>JPY&#160;–&#160;¥</option>
								<option value='NZD'>NZD&#160;–&#160;NZ$</option>
								<option value='NOK'>NOK&#160;–&#160;kr</option>
								<option value='PLN'>PLN&#160;–&#160;zl</option>
								<option value='SGD'>SGD&#160;–&#160;S$</option>
								<option value='SEK'>SEK&#160;–&#160;kr</option>
							</select>
							<input type='text' name='amount' id='don-amount-pp' maxlength='30' size='7' onKeyPress='return(currencyFormat(this, ",", ".", event))' />
							<br /><br />
							<!-- public comment -->
							 <label for='os1'>{$locale.don125}</label>
							 <br />
							<input type='text' size='25' name='os1' id='os1' maxlength='200' />
							<br /><br />
							<!-- public donor list -->
							<a href='{$smarty.const.MODULES}donations/donors.php' title='{$smarty.const.MODULES}donations/donors.php' rel='nofollow'>{$locale.don126}</a>
							<br /><br />
							<input type='radio' name='os0' id='name-yes-pp' value='Mention my name' /><label for='name-yes-pp'>{$locale.don127}</label>
							<br />
							<input type='radio' name='os0' id='name-no-pp' checked='checked' value='Don't mention my name' /><label for='name-no-pp'>{$locale.don128}</label>
							<br />
							<!-- button -->
							<br />
							<input type='submit' value='{$locale.don129}' />
							<br />
						</form>
					</td>
				</tr>
			</table>
		</td>
		{if $sandbox}
		<td align='center' width='200' style=''>
			&nbsp;
		</td>
		<td align='center' style=''>
			<table class='donate_box'>
				<tr valign='top'>
					<td>
						&nbsp;
					</td>
					<td style='height:30px;'>
						<big><center><b>{$locale.don131}</b></center></big>
					</td>
				</tr>
				<tr>
					<td colspan='2' valign='top'>
						{$locale.don132}
						<p>
							<b>{$locale.don133}</b>
							<br />
						</p>
						<p>{$locale.don134}</p>
						<p>
							<b>{$locale.don135}:</b>
							<br />
						</p>
						<p>{$locale.don136}</p>
						<p>{$locale.don137}</p>
					</td>
				</tr>
			</table>
		</td>
		{/if}
	</tr>
	<tr>
		<td colspan='3' align='left' class='donate_title'>
			<br />
			<p>{$locale.don161}</p>
			<hr />		
		</td>
	</tr>
	<tr>
		<td colspan='3' align='left'>
			{$locale.don163}
		</td>
	</tr>
	<tr>
		<td colspan='3' align='left' class='donate_title'>
			<br />
			<p>{$locale.don171}</p>
			<hr />		
		</td>
	</tr>
	<tr>
		<td colspan='3' align='left'>
			{$locale.don172}{$locale.don173}
		</td>
	</tr>
</table>
{include file="_closetable.tpl"}
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}