<?php
/*---------------------------------------------------------------------+
| ExiteCMS Content Management System                                   |
+----------------------------------------------------------------------+
| Copyright 2006-2008 Exite BV, The Netherlands                        |
| for support, please visit http://www.exitecms.org                    |
+----------------------------------------------------------------------+
| Some code derived from PHP-Fusion, copyright 2002 - 2006 Nick Jones  |
+----------------------------------------------------------------------+
| Released under the terms & conditions of v2 of the GNU General Public|
| License. For details refer to the included gpl.txt file or visit     |
| http://gnu.org                                                       |
+----------------------------------------------------------------------+
| $Id::                                                               $|
+----------------------------------------------------------------------+
| Last modified by $Author::                                          $|
| Revision number $Rev::                                              $|
+---------------------------------------------------------------------*/
if (!checkrights("I") || !defined("iAUTH") || $aid != iAUTH || !defined('INIT_CMS_OK')) fallback(BASEDIR."index.php");

/*---------------------------------------------------+
| Module identification                              |
+----------------------------------------------------*/
$mod_title = "Donations";
$mod_description = "Donations module with offline and online payment options, a Paypal interface for automatic payment processing, and a (public) log of donations received";
$mod_version = "1.0.2";
$mod_developer = "WanWizard";
$mod_email = "wanwizard@exitecms.org";
$mod_weburl = "http://www.exitecms.org/";
$mod_type = "M";

/*---------------------------------------------------+
| Module administration panel installation details   |
+----------------------------------------------------*/

$mod_folder = "donations";								// sub-folder of the /modules folder
$mod_admin_image = "donations.gif";						// icon to be used for the admin panel
$mod_admin_panel = "admin_panel.php";					// name of the admin panel for this module
$mod_admin_rights = "wD";								// admin rights code. This HAS to be assigned by PLi-Fusion to avoid duplicates!
$mod_admin_page = 4;									// admin page this panel has to be placed on

/*---------------------------------------------------+
| Version and revision control                       |
+----------------------------------------------------*/

// check for a minumum version of the ExiteCMS engine
if (str_replace(".", "", $settings['version']) < 720) {
	$mod_errors .= sprintf($locale['mod001'], '7.20');
}
// check for a maximum version of the ExiteCMS engine
if (str_replace(".", "", $settings['version']) > 730) {
	$mod_errors .= sprintf($locale['mod002'], '7.30');
}
// check for a specific revision number range that is supported
if ($settings['revision'] < 0 || $settings['revision'] > 999999) {
	$mod_errors .= sprintf($locale['mod003'], 0, 999999);
}

/*---------------------------------------------------+
| Menu entries for this module                       |
+----------------------------------------------------*/

$mod_site_links = array();
$mod_site_links[] = array('name' => 'Donations', 'url' => 'index.php', 'panel' => '', 'visibility' => 101);

/*---------------------------------------------------+
| Report entries for this module                     |
+----------------------------------------------------*/

$mod_report_links = array();	// no reports for this module

/*---------------------------------------------------+
| Search entries for this module                     |
+----------------------------------------------------*/

$mod_search_links = array();	// no search options for this module

/*---------------------------------------------------+
| locale strings for this module                     |
+----------------------------------------------------*/

$localestrings = array();
$localestrings['en'] = array();
// panel title
$localestrings['en']['don400'] = "Donations";
// config
$localestrings['en']['don410'] = "Use Paypal Sandbox (test mode):";
$localestrings['en']['don411'] = "No";
$localestrings['en']['don412'] = "Yes";
$localestrings['en']['don420'] = "Donation page templates:";
$localestrings['en']['don421'] = "Page";
$localestrings['en']['don422'] = "Locale";
$localestrings['en']['don423'] = "Edit donations template";
$localestrings['en']['don424'] = "Requested donations template can not be found";
$localestrings['en']['don425'] = "Update template";
$localestrings['en']['don426'] = "Donations template has been updated";
// thank you message and page
$localestrings['en']['don455'] = "Date";
$localestrings['en']['don456'] = "Name";
$localestrings['en']['don457'] = "Amount";
$localestrings['en']['don458'] = "Comments";
$localestrings['en']['don459'] = "Anonymous";
$localestrings['en']['don460'] = "no comments given";
$localestrings['en']['don461'] = "Type";
$localestrings['en']['don462'] = "Currency";
$localestrings['en']['don463'] = "Country";
$localestrings['en']['don464'] = "Email";
// donations page
$localestrings['en']['don471'] = "No investments have been made yet.";
$localestrings['en']['don472'] = "No donations have been received yet.";
// admin panel
$localestrings['en']['don475'] = "Add a new donation";
$localestrings['en']['don476'] = "Edit a donation";
$localestrings['en']['don477'] = "Donation settings";
// Field titles
$localestrings['en']['don478'] = "Options";
$localestrings['en']['don479'] = "Paypal donation";
$localestrings['en']['don480'] = "Donation";
$localestrings['en']['don481'] = "Investment";
$localestrings['en']['don482'] = "Refund";
// Buttons
$localestrings['en']['don483'] = "Add";
$localestrings['en']['don484'] = "Save";
$localestrings['en']['don485'] = "Edit";
$localestrings['en']['don486'] = "Delete";
$localestrings['en']['don487'] = "Add a new donation";
// notifications
$localestrings['en']['don488'] = "No notifications";
$localestrings['en']['don489'] = "Post notifications of donation in forum";
$localestrings['en']['don490'] = "Notifications will be posted as a forum message in a locked and stickey thread with<br />the title '%s'. If this thread does not exist, it will be created";
$localestrings['en']['don491'] = "** Paypal Donations **";
$localestrings['en']['don492'] = "Donations received to date:";
$localestrings['en']['don493'] = "donated";
$localestrings['en']['don494'] = "on";
$localestrings['en']['don495'] = "No more notifications of new payments will be posted";
$localestrings['en']['don496'] = "Notifications of new payments will now be posted in the selected forum";
$localestrings['en']['don497'] = "The payment notification thread has been moved to the new forum";
$localestrings['en']['don498'] = "The donor has requested to remain anonymous";
// Error messages
$localestrings['en']['donerr00'] = "You have to fill in an amount!";
$localestrings['en']['donerr01'] = "No refund reason specified";
$localestrings['en']['donerr02'] = "Requested donate_id already exists. Maybe it was added by someone else?";
$localestrings['en']['donerr03'] = "New donation record saved successfully";
$localestrings['en']['donerr04'] = "Donation record saved successfully";
$localestrings['en']['donerr05'] = "Please enter a value for the %s field<br />";
$localestrings['en']['donerr06'] = "The value of the %s field is not correct<br />";
$localestrings['en']['donerr07'] = "Requested donation record does not exist";
$localestrings['en']['donerr08'] = "Donation record has been deleted";
$localestrings['en']['donerr09'] = "Are you sure you want to delete this donation record?";
$localestrings['en']['donerr10'] = "Requested donate_id is missing. Maybe it was deleted by someone else?";

// default page text
$localestrings['en']['don_index_name'] = "Donation main page";
$localestrings['en']['don_index'] = "<script language='javascript' type='text/javascript'>
{literal}
/* This script and many more are available free online at
   The JavaScript Source!! http://javascript.internet.com
   Created by: Mario Costa
*/
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
		alert('{/literal}{\$locale.donerr00}{literal}');
		return false;
	}
	return true;
}
</script>
<style>
.donate_title			{ font-weight:bold; font-size:120%; color:#666; }
.donate_box				{ width:24em; height:24em; margin:1px; padding:0.5em; background:#bbb; border:1px solid #999; -moz-border-radius:10px; }
.donate_box_header		{ text-align:center;font-size:120%;font-weight:bold;height:30px; }
</style>
{/literal}
<table align='center' border='0' cellspacing='5' cellpadding='0' width='600'>
	<tr>
		<td align='left' style=''>
			<p>
				<span class='donate_title'>Do you want to help?</span>
				<hr />
				<p>
					As a volunteer-based organisation, we has always relied on internal funding to cover all expenses of the development and distribution of our software.
					<br /><br />
					However, while our userbase has grown consistently over the last years, the cost of releasing regular updates, hardware upgrades &amp; maintenance, as well as bandwidth and rack space has risen substantially also. As of recently, the growing number of requests from the community to support our products has reached a point where it has become increasingly challenging for us to find adequate funding to cover our expenses.
				</p>
				<span class='donate_title'>Point taken. So how can I help?</span>
				<hr />
				<p>
					If you would like to help us continue to release quality products, we would greatly appreciate it. Currently the bulk of our financial obligations are spent on technical infrastructure - development hardware, servers and the bandwidth that is required.
					<br /><br />
					A donation to show us your appreciation will allow us to keep improving our efforts, our dedicated support, and the technical infrastructure behind it. It will also help us in acquiring new hardware to further develop our products.
				</p>
			</p>
		</td>
	</tr>
	<tr>
		<td align='left' style=''>
			<p>
				<span class='donate_title'>No problem, how can I donate?</span>
				<hr />
				<p>
					Donations can be made through Paypal or direct bank transfer. Any amount will be appreciated. For details see the instructions below:
				</p>
			</p>
		</td>
	</tr>
	<tr>
		<td align='center' style=''>
			<table width='100%'>
				<tr>
					<td align='center' valign='top'>
						<table class='donate_box'>
							<tr valign='top'>
								<td class='donate_box_header'>
									PayPal / Credit Card
								</td>
							</tr>
							<tr>
								<td valign='top'>
									<b>Donate securely online with PayPal.<br /><br />You do not need a PayPal account to donate with a credit card.</b>
									<p>You can send donations in any of the currencies below without having to pay a currency conversion fee.</p>
									<form name='paypal' action='{\$form_url}' method='post' onsubmit='return InputIsValid()'>
										<!-- hidden data -->
										<input type='hidden' name='business' value='PAYPAL_ACCOUNT' />
										<input type='hidden' name='item_name' value='One-time donation to ORGANISATION' />
										<input type='hidden' name='item_number' value='1' />
										<input type='hidden' name='no_note' value='0' />
										<input type='hidden' name='cmd' value='_xclick' />
										<input type='hidden' name='on0' value='Anonymity' />
										<input type='hidden' name='on1' value='Comment' />
										<input type='hidden' name='lc' value='{\$smarty.const.USER_CC}' />
										<input type='hidden' name='rm' value='2' />
										<input type='hidden' name='no_shipping' value='1' />
										<input type='hidden' name='charset' value='utf-8' />
										<input type='hidden' name='return' value='{\$smarty.const.siteurl}modules/donations/thanks.php' />
										<input type='hidden' name='cancel_return' value='{\$smarty.const.siteurl}modules/donations/index.php' />
										<input type='hidden' name='notify_url' value='{\$smarty.const.siteurl}modules/donations/notify.php' />
										<!-- amount field -->
										<label for='don-amount'><b>One-time donation to ORGANISATION</b></label>
										<br /><br />
										<!-- currency menu -->
										<select name='currency_code' size='1'>
											<option value='EUR'>EUR&nbsp;-&nbsp;€</option>
											<option value='GBP'>GBP&nbsp;-&nbsp;£</option>
											<option value='USD'>USD&nbsp;-&nbsp;$</option>
											<option value='AUD'>AUD&nbsp;-&nbsp;$</option>
											<option value='CAD'>CAD&nbsp;-&nbsp;$</option>
											<option value='CHF'>CHF&nbsp;-&nbsp;F</option>
											<option value='CZK'>CZK&nbsp;-&nbsp;Kc</option>
											<option value='DKK'>DKK&nbsp;-&nbsp;kr</option>
											<option value='HKD'>HKD&nbsp;-&nbsp;HK$</option>
											<option value='HUF'>HUF&nbsp;-&nbsp;Ft</option>
											<option value='JPY'>JPY&nbsp;-&nbsp;¥</option>
											<option value='NZD'>NZD&nbsp;-&nbsp;NZ$</option>
											<option value='NOK'>NOK&nbsp;-&nbsp;kr</option>
											<option value='PLN'>PLN&nbsp;-&nbsp;zl</option>
											<option value='SGD'>SGD&nbsp;-&nbsp;S$</option>
											<option value='SEK'>SEK&nbsp;-&nbsp;kr</option>
										</select>
										<input type='text' name='amount' id='don-amount-pp' maxlength='30' size='7' onKeyPress='return(currencyFormat(this, \",\", \".\", event))' />
										<br /><br />
										<!-- public comment -->
										<label for='os1'>Public comment <span class='small'>(up to 200 characters)</span></label>
										<br />
										<input type='text' size='25' name='os1' id='os1' maxlength='200' />
										<br /><br />
										<!-- public donor list -->
										<img src='{\$smarty.const.THEME}images/bullet.gif' />
										<a href='{\$smarty.const.MODULES}donations/donors.php' title='{\$smarty.const.MODULES}donations/donors.php' rel='nofollow'>View the list of public donors</a>
										<br /><br />
										<input type='radio' name='os0' id='name-yes-pp' value='Mention my name' /><label for='name-yes-pp'>List my name</label>
										<br />
										<input type='radio' name='os0' id='name-no-pp' checked='checked' value='Don't mention my name' /><label for='name-no-pp'>List anonymously</label>
										<br />
										<!-- button -->
										<br />
										<input type='submit' value='Donate!' />
										<br />
									</form>
								</td>
							</tr>
						</table>
					</td>
					<td align='center' valign='top'>
						<table class='donate_box'>
							<tr valign='top'>
								<td class='donate_box_header'>
									Direct deposit
								</td>
							</tr>
							<tr>
								<td valign='top'>
									<b>Deposit money directly into our bank account.</b>
									<p>ORGANISATION has a bank account that accepts money transfers.</p>
									<p>
										<b>Account holder</b>
										<br />
									</p>
									<p>ADD NAME AND ADDRESS OF ORGANISATION HERE</p>
									<p>
										<b>Bank and Account details:</b>
									</p>
									<p>
										ADD BANK AND ACCOUNT DETAILS HERE
									</p>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align='left' style=''>
			<p>
				<span class='donate_title'>Are there any other ways I can support?</span>
				<hr />
				<p>
					Absolutely. You can buy an article from our Web Shop. A percentage of every sale goes towards supporting our efforts.
					<br /><br />
					You can also directly support us, for example with computer hardware or other equipment, rackspace or Internet bandwidth. Please contact us to discuss any specific needs we have at this moment.
				</p>
			</p>
		</td>
	</tr>
	<tr>
		<td align='left' style=''>
			<p>
				<span class='donate_title'>Thank You!</span>
				<hr />
				<p>
					It would be difficult for us to keep releasing quality products without the continued generous support from our community!
				</p>
				<p>
					We would also like to take this opportunity to thank our <a href='{\$smarty.const.MODULES}donations/donors.php' title='{\$smarty.const.MODULES}donations/donors.php' rel='nofollow'>current donors</a>.
				</p>
		</td>
	</tr>
</table>";

$localestrings['en']['don_thanks_name'] = "Thank you page";
$localestrings['en']['don_thanks'] = "{literal}
<style>
.donate_title			{ font-weight:bold; font-size:120%; color:#666; }
</style>
{/literal}
<table align='center' border='0' cellspacing='1' cellpadding='0' width='100%'>
	<tr>
		<td colspan='3' align='left' class='donate_title'>
			<p>Thank you for your donation{if \$payer_name != ''}, {\$payer_name}{/if}!</p>
			<hr />
		</td>
	</tr>
	<tr>
		<td colspan='3' align='left'>
			<p>We would like to take this opportunity to thank you for your generous donation of {ssprintf format='%.2f %s' var1=\$mc_gross var2=\$mc_currency}.</p>
		</td>
	</tr>
	<tr>
		<td colspan='3' align='left'>
			Your donation will be added to our donations register as soon as the payment is processed.<br /><br />Based on your input, you will be registered as:
			<br /><br />
			<b>
			<table align='left' border='0' cellspacing='1' cellpadding='0' width='100%'>
				<tr>
					<td width='1%'>Date</td>
					<td width='1%'>&nbsp;:&nbsp;</td>
					<td>{\$payment_date|date_format:'forumdate'}</td>
				</tr>
				<tr>
					<td width='1%'>Name</td>
					<td width='1%'>&nbsp;:&nbsp;</td>
					<td>{if \$payer_name != ''}{\$payer_name}{else}Anonymous{/if}</td>
				</tr>
				<tr>
					<td width='1%'>Amount</td>
					<td width='1%'>&nbsp;:&nbsp;</td>
					<td>{\$mc_currency} {\$mc_gross}</td>
				</tr>
				<tr>
					<td width='1%'>Comments</td>
					<td width='1%'>&nbsp;:&nbsp;</td>
					<td>{if \$comment !=''}{\$comment}{else}No comments given{/if}</td>
				</tr>
			</table>
		</td>
	</tr>
	{if \$payer_name == ''}
	<tr>
		<td colspan='3' align='left'>
			<br />
			<b>You have requested that your want to remain anonymous.<br />We respect your request, and will not keep your name on our donation records.<br /></b>
		</td>
	</tr>
	{/if}
	<tr>
		<td colspan='3' align='left'>
			<p>If you do not agree with this registration for whatever reason, please <a href='/contact.php?target=donations&amp;tc=a6af5d9e1948b46a13132cfc313d9eda'><b>contact us</b></a> so we can correct it for you.</p>
		</td>
	</tr>
	<tr>
		<td colspan='3' align='left' class='donate_title'>
			<p>ORGANISATION</p>
		</td>
	</tr>
</table>";
$localestrings['en']['don_list_name'] = "Donation and Investment list";
$localestrings['en']['don_list'] = "{literal}
<style>
.donate_title			{ font-weight:bold; font-size:120%; color:#666; }
</style>
{/literal}
<table align='center' border='0' cellspacing='1' cellpadding='0' width='600' class=''>
	<tr>
		<td align='left' class='donate_title'>
			<p>Thank you for your donations</p>
			<hr />
		</td>
	</tr>
	<tr>
		<td align='left'>
			<p>We would like to take this opportunity to thank you all for your generous donations.</p>
			<br />
		</td>
	</tr>
	<tr>
		<td align='center'>
			{include file=\$smarty.const.PATH_MODULES|cat:'donations/templates/modules.donations.donorlist.tpl'}
		</td>
	</tr>
	<tr>
		<td align='left' class='donate_title'>
			<br />
			<p>Where did your money go to?</p>
			<hr />
		</td>
	</tr>
	<tr>
		<td align='left'>
			<p>We want to be as open as possible. Here's a list of payments made with the money we've received from donations.</p>
			<br />
		</td>
	</tr>
	<tr>
		<td align='center'>
			{include file=\$smarty.const.PATH_MODULES|cat:'donations/templates/modules.donations.investlist.tpl'}
		</td>
	</tr>
</table>";

$localestrings['nl'] = array();
// panel title
$localestrings['nl']['don400'] = "Donaties";
// config
$localestrings['nl']['don410'] = "Gebruik de Paypal Sandbox (voor tests):";
$localestrings['nl']['don411'] = "Nee";
$localestrings['nl']['don412'] = "Ja";
$localestrings['nl']['don420'] = "Donatie pagina sjablonen:";
$localestrings['nl']['don421'] = "Pagina";
$localestrings['nl']['don422'] = "Locale";
$localestrings['nl']['don423'] = "Donatie sjabloon aanpassen";
$localestrings['nl']['don424'] = "Gevraagd donatie sjabloon kan niet worden gevonden";
$localestrings['nl']['don425'] = "Sjabloon opslaan";
$localestrings['nl']['don426'] = "Donatie sjabloon is opgeslagen";
// thank you message and page
$localestrings['nl']['don455'] = "Datum";
$localestrings['nl']['don456'] = "Naam";
$localestrings['nl']['don457'] = "Bedrag";
$localestrings['nl']['don458'] = "Commentaar";
$localestrings['nl']['don459'] = "Anoniem";
$localestrings['nl']['don460'] = "Geen commentaar gegeven";
$localestrings['nl']['don461'] = "Type";
$localestrings['nl']['don462'] = "Valuta";
$localestrings['nl']['don463'] = "Land";
$localestrings['nl']['don464'] = "Email";
// donations page
$localestrings['nl']['don471'] = "Er zijn op dit moment nog geen investeringen gebeurd.";
$localestrings['nl']['don472'] = "Er zijn op dit moment nog geen donaties ontvangen.";
// admin panel
$localestrings['nl']['don475'] = "Voeg een nieuwe donatie toe";
$localestrings['nl']['don476'] = "Donatie aanpassen";
$localestrings['nl']['don477'] = "Donatie instellingen";
// Field titles
$localestrings['nl']['don478'] = "Opties";
$localestrings['nl']['don479'] = "Paypal donatie";
$localestrings['nl']['don480'] = "Donatie";
$localestrings['nl']['don481'] = "Investering";
$localestrings['nl']['don482'] = "Terugbetaling";
// Buttons
$localestrings['nl']['don483'] = "Toevoegen";
$localestrings['nl']['don484'] = "Bewaren";
$localestrings['nl']['don485'] = "Wijzigen";
$localestrings['nl']['don486'] = "Verwijderen";
$localestrings['nl']['don487'] = "Voeg een nieuwe donatie toe";
// notifications
$localestrings['nl']['don488'] = "Geen notificatie";
$localestrings['nl']['don489'] = "Plaats notificatie van donatie in forum";
$localestrings['nl']['don490'] = "Notificaties zullen worden geplaatst als een forum bericht in een gesloten topic<br />met de naam '%s'. Als deze topic niet bestaan zal deze worden aangemaakt";
$localestrings['nl']['don491'] = "** Paypal Donations **";
$localestrings['nl']['don492'] = "Donaties ontvangen tot op heden:";
$localestrings['nl']['don493'] = "gedoneerd";
$localestrings['nl']['don494'] = "op";
$localestrings['nl']['don495'] = "Er zullen geen notificaties van nieuwe betalingen meer worden geplaatst";
$localestrings['nl']['don496'] = "Notificaties van nieuwe betalingen zullen nu worden geplaatst in het geselecteerde forum";
$localestrings['nl']['don497'] = "Het betalings noticifcatie topic is verplaatst naar het nieuwe forum";
$localestrings['nl']['don498'] = "De donateur heeft verzocht anoniem te mogen blijven";
// Error messages
$localestrings['nl']['donerr00'] = "U moet een bedrag invullen!";
$localestrings['nl']['donerr01'] = "Geen terugbetalingsreden ingevuld";
$localestrings['nl']['donerr02'] = "Het gevraagde donate_id bestaat reeds. Wellicht al toegevoegd door iemand anders?";
$localestrings['nl']['donerr03'] = "Nieuwe donatie succesvol toegevoegd.";
$localestrings['nl']['donerr04'] = "Donatie succesvol opgeslagen";
$localestrings['nl']['donerr05'] = "Geef a.u.b een waarde voor het %s veld<br />";
$localestrings['nl']['donerr06'] = "De waarde van het %s veld is niet correct<br />";
$localestrings['nl']['donerr07'] = "Het gevraagde donatie record bestaat niet";
$localestrings['nl']['donerr08'] = "Donatie is verwijderd";
$localestrings['nl']['donerr09'] = "Weet u zeker dat u deze donatie wilt verwijderen?";
$localestrings['nl']['donerr10'] = "Gevraagd donate_id ontbreekt. Misschien verwijderd door iemand anders?";

// default page text
$localestrings['nl']['don_index_name'] = "Donatie hoofd pagina";
$localestrings['nl']['don_index'] = "<script language='javascript' type='text/javascript'>
{literal}
/* This script and many more are available free online at
   The JavaScript Source!! http://javascript.internet.com
   Created by: Mario Costa
*/
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
		alert('{/literal}{\$locale.donerr00}{literal}');
		return false;
	}
	return true;
}
</script>
<style>
.donate_title			{ font-weight:bold; font-size:120%; color:#666; }
.donate_box				{ width:24em; height:24em; margin:1px; padding:0.5em; background:#bbb; border:1px solid #999; -moz-border-radius:10px; }
.donate_box_header		{ text-align:center;font-size:120%;font-weight:bold;height:30px; }
</style>
{/literal}
<table align='center' border='0' cellspacing='5' cellpadding='0' width='600'>
	<tr>
		<td align='left' style=''>
			<p>
				<span class='donate_title'>Wilt u ons helpen?</span>
				<hr />
				<p>
					Als een organisatie gebouwd op vrijwilligers, hebben we altijd gesteund op interne financiering om alle kosten gerelateerd aan de ontwikkeling en distributie van onze producten te dekken.
					<br /><br />
					Echter, terwijl het aantal gebruikers van onze producten de laatste jaren een constante groei heeft doorgemaakt, zijn ook de kosten voor het verbeteren van onze producten, en de kosten van bandbreedte en server capaciteit, fors gestegen. Dit betekent dat het voor ons steeds moeilijker wordt om de financiering van onze kosten rond te krijgen.
				</p>
				<span class='donate_title'>Duidelijk. Dus, hoe kan ik helpen?</span>
				<hr />
				<p>
					Als u ons wilt ondersteunen bij het verder ontwikkelen van onze producten, dan zouden wij dat zeer op prijs stellen. Op dit moment wordt het grootste deel van onze financiele verplichten besteed aan technische infrastructuur, hardware voor ontwikkeling, servers en benodigde internet bandbreedte.
					<br /><br />
					Een donatie als waardering van onze inspanningen zal ons in staat stellen door te gaan het continue verbeteren van onze producten, de ondersteuning daarvoor, en de technische infrastructuur die dit alles onderesteund. Het helpt ons ook nieuwe ontwikkelplatformen aan te kopen wanneer deze beschikbaar komen.
				</p>
			</p>
		</td>
	</tr>
	<tr>
		<td align='left' style=''>
			<p>
				<span class='donate_title'>Geen probleem, hoe kan ik doneren?</span>
				<hr />
				<p>
					U kunt doneren via Paypal of via een directe bank overschrijving. Elk bedrag wordt zeer gewaardeerd. Voor details zie onderstaande instructies:
				</p>
			</p>
		</td>
	</tr>
	<tr>
		<td align='center' style=''>
			<table width='100%'>
				<tr>
					<td align='center' valign='top'>
						<table class='donate_box'>
							<tr valign='top'>
								<td class='donate_box_header'>
									PayPal / Credit Card
								</td>
							</tr>
							<tr>
								<td valign='top'>
									<b>Doneer veilig online met PayPal.<br /><br />U hebt geen PayPal account nodig om via een credit card te doneren.</b>
									<p>U kunt doneren in elk van onderstaande valuta's zonder dat u een valuta conversie kost moet betalen.</p>
									<form name='paypal' action='{\$form_url}' method='post' onsubmit='return InputIsValid()'>
										<!-- hidden data -->
										<input type='hidden' name='business' value='PAYPAL_ACCOUNT' />
										<input type='hidden' name='item_name' value='Eenmalige donatie aan ORGANISATIE' />
										<input type='hidden' name='item_number' value='1' />
										<input type='hidden' name='no_note' value='0' />
										<input type='hidden' name='cmd' value='_xclick' />
										<input type='hidden' name='on0' value='Anonymity' />
										<input type='hidden' name='on1' value='Comment' />
										<input type='hidden' name='lc' value='{\$smarty.const.USER_CC}' />
										<input type='hidden' name='rm' value='2' />
										<input type='hidden' name='no_shipping' value='1' />
										<input type='hidden' name='charset' value='utf-8' />
										<input type='hidden' name='return' value='{\$smarty.const.siteurl}modules/donations/thanks.php' />
										<input type='hidden' name='cancel_return' value='{\$smarty.const.siteurl}modules/donations/index.php' />
										<input type='hidden' name='notify_url' value='{\$smarty.const.siteurl}modules/donations/notify.php' />
										<!-- amount field -->
										<label for='don-amount'><b>Eenmalige donatie aan ORGANISATIE</b></label>
										<br /><br />
										<!-- currency menu -->
										<select name='currency_code' size='1'>
											<option value='EUR'>EUR&nbsp;-&nbsp;€</option>
											<option value='GBP'>GBP&nbsp;-&nbsp;£</option>
											<option value='USD'>USD&nbsp;-&nbsp;$</option>
											<option value='AUD'>AUD&nbsp;-&nbsp;$</option>
											<option value='CAD'>CAD&nbsp;-&nbsp;$</option>
											<option value='CHF'>CHF&nbsp;-&nbsp;F</option>
											<option value='CZK'>CZK&nbsp;-&nbsp;Kc</option>
											<option value='DKK'>DKK&nbsp;-&nbsp;kr</option>
											<option value='HKD'>HKD&nbsp;-&nbsp;HK$</option>
											<option value='HUF'>HUF&nbsp;-&nbsp;Ft</option>
											<option value='JPY'>JPY&nbsp;-&nbsp;¥</option>
											<option value='NZD'>NZD&nbsp;-&nbsp;NZ$</option>
											<option value='NOK'>NOK&nbsp;-&nbsp;kr</option>
											<option value='PLN'>PLN&nbsp;-&nbsp;zl</option>
											<option value='SGD'>SGD&nbsp;-&nbsp;S$</option>
											<option value='SEK'>SEK&nbsp;-&nbsp;kr</option>
										</select>
										<input type='text' name='amount' id='don-amount-pp' maxlength='30' size='7' onKeyPress='return(currencyFormat(this, \",\", \".\", event))' />
										<br /><br />
										<!-- public comment -->
										<label for='os1'>Publiek commentaar <span class='small'>(up to 200 characters)</span></label>
										<br />
										<input type='text' size='25' name='os1' id='os1' maxlength='200' />
										<br /><br />
										<!-- public donor list -->
										<img src='{\$smarty.const.THEME}images/bullet.gif' />
										<a href='{\$smarty.const.MODULES}donations/donors.php' title='{\$smarty.const.MODULES}donations/donors.php' rel='nofollow'>Bekijk de publieke lijst van donateurs</a>
										<br /><br />
										<input type='radio' name='os0' id='name-yes-pp' value='Mention my name' /><label for='name-yes-pp'>Toon mijn naam</label>
										<br />
										<input type='radio' name='os0' id='name-no-pp' checked='checked' value='Don't mention my name' /><label for='name-no-pp'>Anonieme donatie</label>
										<br />
										<!-- button -->
										<br />
										<input type='submit' value='Doneer!' />
										<br />
									</form>
								</td>
							</tr>
						</table>
					</td>
					<td align='center' valign='top'>
						<table class='donate_box'>
							<tr valign='top'>
								<td class='donate_box_header'>
									Directe overschrijving
								</td>
							</tr>
							<tr>
								<td valign='top'>
									<b>U kunt direct naar onze bankrekening overschrijven.</b>
									<p>ORGANISATIE heeft een bankrekening waarnaar u kunt overschrijven.</p>
									<p>
										<b>Rekeninghouder</b>
										<br />
									</p>
									<p>ADD NAME AND ADDRESS OF ORGANISATION HERE</p>
									<p>
										<b>Bank en bankrekening details:</b>
									</p>
									<p>
										ADD BANK AND ACCOUNT DETAILS HERE
									</p>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align='left' style=''>
			<p>
				<span class='donate_title'>Zijn er andere manieren om jullie te steunen?</span>
				<hr />
				<p>
					Absoluut. U kunt een artikel uit onze webwinkel aankopen. Een percentage van elke verkoop zal ten goede komen aan onze inspanningen.
					<br /><br />
					U kunt ons ook direct steunen, bijvoorbeeld met computer componenten of ander materiaal, met rackspace of internet bandbreedte. Neem contact met ons op om eventuele mogelijkheden te bespreken.
				</p>
			</p>
		</td>
	</tr>
	<tr>
		<td align='left' style=''>
			<p>
				<span class='donate_title'>Dank U!</span>
				<hr />
				<p>
					Het zou erg moeilijk zijn voor ons om onze producten continue te verbeteren zonder de continue steun van onze gebruikersgemeenschap!
				</p>
				<p>
					Wij willen van deze gelegenheid gebruik maken om onze <a href='{\$smarty.const.MODULES}donations/donors.php' title='{\$smarty.const.MODULES}donations/donors.php' rel='nofollow'>huidige donateurs</a> te danken voor hun steun.
				</p>
		</td>
	</tr>
</table>";
$localestrings['nl']['don_thanks_name'] = "Bedank voor donatie pagina";
$localestrings['nl']['don_thanks'] = "{literal}
<style>
.donate_title			{ font-weight:bold; font-size:120%; color:#666; }
</style>
{/literal}
<table align='center' border='0' cellspacing='1' cellpadding='0' width='100%'>
	<tr>
		<td colspan='3' align='left' class='donate_title'>
			<p>Hartelijk dank voor uw donatie{if \$payer_name != ''}, {\$payer_name}{/if}!</p>
			<hr />
		</td>
	</tr>
	<tr>
		<td colspan='3' align='left'>
			<p>Wij willen deze gelegenheid aangrijpen om u hartelijk te danken voor uw donatie van {ssprintf format='%.2f %s' var1=\$mc_gross var2=\$mc_currency}.</p>
		</td>
	</tr>
	<tr>
		<td colspan='3' align='left'>
			Uw donatie zal worden toegevoegd aan ons donatie register zodra de betaling is verwerkt..<br /><br />Gebaseerd op uw invoer, zal uw donatie worden geregistreerd als:
			<br /><br />
			<b>
			<table align='left' border='0' cellspacing='1' cellpadding='0' width='100%'>
				<tr>
					<td width='1%'>Datum</td>
					<td width='1%'>&nbsp;:&nbsp;</td>
					<td>{\$payment_date|date_format:'forumdate'}</td>
				</tr>
				<tr>
					<td width='1%'>Naam</td>
					<td width='1%'>&nbsp;:&nbsp;</td>
					<td>{if \$payer_name != ''}{\$payer_name}{else}Anoniem{/if}</td>
				</tr>
				<tr>
					<td width='1%'>Bedrag</td>
					<td width='1%'>&nbsp;:&nbsp;</td>
					<td>{\$mc_currency} {\$mc_gross}</td>
				</tr>
				<tr>
					<td width='1%'>Commentaar</td>
					<td width='1%'>&nbsp;:&nbsp;</td>
					<td>{if \$comment !=''}{\$comment}{else}Geen commentaar gegeven{/if}</td>
				</tr>
			</table>
		</td>
	</tr>
	{if \$payer_name == ''}
	<tr>
		<td colspan='3' align='left'>
			<br />
			<b>U heeft ons verzocht uw donatie anoniem te houden.<br />Wij respecteren dat, en zullen uw naam niet opslaan in ons donatie register.</b>
		</td>
	</tr>
	{/if}
	<tr>
		<td colspan='3' align='left'>
			<p>Als u om welke reden dan ook niet akkoord bent met deze registratie, laat ons dit dan <a href='/contact.php?target=donations&amp;tc=a6af5d9e1948b46a13132cfc313d9eda'><b>weten</b></a> zodat we dit voor u kunnen corrigeren.</p>
		</td>
	</tr>
	<tr>
		<td colspan='3' align='left' class='donate_title'>
			<p>ORGANISATIE</p>
		</td>
	</tr>
</table>";
$localestrings['nl']['don_list_name'] = "Donaties en investeringslijst";
$localestrings['nl']['don_list'] = "{literal}
<style>
.donate_title			{ font-weight:bold; font-size:120%; color:#666; }
</style>
{/literal}
<table align='center' border='0' cellspacing='1' cellpadding='0' width='600' class=''>
	<tr>
		<td align='left' class='donate_title'>
			<p>Hartelijk dank voor uw donatie</p>
			<hr />
		</td>
	</tr>
	<tr>
		<td align='left'>
			<p>We willen van deze gelegenheid gebruik maken om u hartelijk te danken voor uw genereuze donaties.</p>
			<br />
		</td>
	</tr>
	<tr>
		<td align='center'>
			{include file=\$smarty.const.PATH_MODULES|cat:'donations/templates/modules.donations.donorlist.tpl'}
		</td>
	</tr>
	<tr>
		<td align='left' class='donate_title'>
			<br />
			<p>Waar ging uw geld naar toe?</p>
			<hr />
		</td>
	</tr>
	<tr>
		<td align='left'>
			<p>Wij proberen voor wat betreft onze financieen zo open mogelijk te zijn. Dit is de lijst van investeringen die wij hebben gedaan met gelden ontvangen van sponsors en donateurs.</p>
			<br />
		</td>
	</tr>
	<tr>
		<td align='center'>
			{include file=\$smarty.const.PATH_MODULES|cat:'donations/templates/modules.donations.investlist.tpl'}
		</td>
	</tr>
</table>";

/*---------------------------------------------------+
| commands to execute when installing this module    |
+----------------------------------------------------*/

$mod_install_cmds = array();

$mod_install_cmds[] = array('type' => 'db', 'value' => "CREATE TABLE ##PREFIX##donations (
  donate_id smallint(5) NOT NULL auto_increment,
  donate_name varchar(50) NOT NULL default '',
  donate_amount decimal(10,2) NOT NULL default '0.00',
  donate_currency varchar(5) NOT NULL default '',
  donate_country char(2) NOT NULL default '',
  donate_comment varchar(200) NOT NULL default '',
  donate_timestamp int(10) NOT NULL default '0',
  donate_type tinyint(1) NOT NULL default '0',
  donate_state tinyint(1) NOT NULL default '0',
  PRIMARY KEY (donate_id)
) ENGINE=MyISAM");

$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##configuration (cfg_name, cfg_value) VALUES ('donate_forum_id', '0')");
$mod_install_cmds[] = array('type' => 'db', 'value' => "INSERT INTO ##PREFIX##configuration (cfg_name, cfg_value) VALUES ('donate_use_sandbox', '0')");

$mod_install_cmds[] = array('type' => 'function', 'value' => "mod_donations_install");

/*---------------------------------------------------+
| commands to execute when uninstalling this module  |
+----------------------------------------------------*/

$mod_uninstall_cmds = array();
$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DROP TABLE ##PREFIX##donations");

$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DELETE FROM ##PREFIX##configuration WHERE cfg_name = 'donate_forum_id'");
$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DELETE FROM ##PREFIX##configuration WHERE cfg_name = 'donate_use_sandbox'");

$mod_uninstall_cmds[] = array('type' => 'function', 'value' => "mod_donations_uninstall");


/*---------------------------------------------------+
| function for special installations                 |
+----------------------------------------------------*/
if (!function_exists('mod_donations_install')) {
	function mod_donations_install() {
	}
}
/*---------------------------------------------------+
| function for special de-installations              |
+----------------------------------------------------*/
if (!function_exists('mod_donations_uninstall')) {
	function mod_donations_uninstall() {
	}
}

/*---------------------------------------------------+
| function to upgrade from a previous revision       |
+----------------------------------------------------*/
if (!function_exists('module_upgrade')) {
	function module_upgrade($current_version) {
		global $db_prefix;

		switch ($current_version) {
			case "1.0.0":			// current release version
				break;
			case "1.0.1":			// current release version
				$result = dbquery("INSERT INTO ".$db_prefix."configuration (cfg_name, cfg_value) VALUES ('donate_use_sandbox', '0')");
				break;
			default:
				terminate("invalid current version number passed to module_upgrade()!");
		}
	}
}
?>
