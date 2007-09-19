{***************************************************************************}
{*                                                                         *}
{* PLi-Fusion CMS template: infusions.donation.thanks.tpl                  *}
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
{* This template generates the paypal thank-you page of the PLi-Fusion     *}
{* Donations installable module (infusion)                                 *}
{*                                                                         *}
{***************************************************************************}
{include file="_opentable.tpl" name=$_name title=$locale.don000 state=$_state style=$_style}
<table align='center' border='0' cellspacing='1' cellpadding='0' width='700' class=''>
	<tr>
		<td colspan='3' align='left' class='donate_title'>
			<br />
			<p>{ssprintf format=$locale.don200 var1=$payer_name}</p>
			<hr />
		</td>
	</tr>
	<tr>
		<td colspan='3' align='left'>
			{ssprintf format=$locale.don201 var1=$mc_gross var2=$mc_currency}
		</td>
	</tr>
	<tr>
		<td colspan='3' align='left'>
			{$locale.don203}
			<br /><br />
			<b>
			<table align='left' border='0' cellspacing='1' cellpadding='0' width='700' class=''>
				<tr>
					<td width='1%'>
						{$locale.don211}
					</td>
					<td width='1%'>
						&nbsp;:&nbsp;
					</td>
					<td>
						{$payment_date|date_format:"forumdate"}
					</td>
				</tr>
				<tr>
					<td width='1%'>
						{$locale.don212}
					</td>
					<td width='1%'>
						&nbsp;:&nbsp;
					</td>
					<td>
						{if $payer_name|default:"" != ""}{$payer_name}{else}{$locale.don215}{/if}
					</td>
				</tr>
				<tr>
					<td width='1%'>
						{$locale.don213}
					</td>
					<td width='1%'>
						&nbsp;:&nbsp;
					</td>
					<td>
						{$mc_currency} {$mc_gross}
					</td>
				</tr>
				<tr>
					<td width='1%'>
						{$locale.don214}
					</td>
					<td width='1%'>
						&nbsp;:&nbsp;
					</td>
					<td>
						{if $comment|default:"" !=""}{$comment}{else}{$locale.don216}{/if}
					</td>
				</tr>
			</table>
			</b>
		</td>
	</tr>
	{if $payer_name|default:"" == ""}
	<tr>
		<td colspan='3' align='left'>
			<br />
			<b>
			{$locale.don202}
			</b>
		</td>
	</tr>
	{/if}
	<tr>
		<td colspan='3' align='left'>
			{$locale.don174}
		</td>
	</tr>
	<tr>
		<td colspan='3' align='left' class='donate_title'>
			<p>{$locale.don175}</p>
		</td>
	</tr>
</table>
<br />
{include file="_closetable.tpl"}
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}