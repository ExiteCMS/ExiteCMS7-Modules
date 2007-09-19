{***************************************************************************}
{*                                                                         *}
{* PLi-Fusion CMS template: infusions.donations.donors.tpl                 *}
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
{* This template generates the donor overview panel of the donations system*}
{*                                                                         *}
{***************************************************************************}
{include file="_opentable.tpl" name=$_name title=$locale.don000 state=$_state style=$_style}
<table align='center' border='0' cellspacing='1' cellpadding='0' width='700' class=''>
	<tr>
		<td align='left' class='donate_title'>
			<br />
			<p>{$locale.don300}</p>
			<hr />		
		</td>
	</tr>
	<tr>
		<td align='left'>
			<p>{$locale.don301}</p>
			<br />
		</td>
	</tr>
	<tr>
		<td align='center'>
			<table align='center' cellpadding='0' cellspacing='1' width='100%' class='tbl-border'>
				<tr>
					<td width='15%' align='center' class='tbl2'>
						<b>{$locale.don211}</b>
					</td>
					<td width='22%' align='center' class='tbl2'>
						<b>{$locale.don212}</b>
					</td>
					<td width='13%' align='center' class='tbl2'>
						<b>{$locale.don213}</b>
					</td>
					<td align='center' class='tbl2'>
						<b>{$locale.don214}</b>
					</td>
				</tr>
				{section name=idx loop=$donate1}
					<tr>
						<td width='15%' class='tbl1'>
							{$donate1[idx].donate_timestamp|date_format:'shortdate'}
						</td>
						<td width='22%' class='tbl1'>
							{if $donate1[idx].donate_state == "2"}<b>{/if}
							{if $donate1[idx].donate_name == ""}{$locale.don215}{else}{$donate1[idx].donate_name}{/if}
							({$donate1[idx].donate_country})
							{if $donate1[idx].donate_state == "2"}</b>{/if}
						</td>
						<td width='13%' align='center' class='tbl1'>
							{if $donate1[idx].donate_state == "2"}<b>{/if}
							{$donate1[idx].donate_amount|string_format:"%01.2f"} {$donate1[idx].donate_currency}
							{if $donate1[idx].donate_state == "2"}</b>{/if}
						</td>
						<td class='tbl1'>
							{if $donate1[idx].donate_state == "2"}<b>{/if}
							{$donate1[idx].donate_comment}
							{if $donate1[idx].donate_state == "2"}</b>{/if}
						</td>
					</tr>
				{sectionelse}
					<tr>
						<td align='center' class='tbl1' colspan='4'>
							<br />
							{$locale.don302}
						</td>
					</tr>
				{/section}
			</table>
		</td>
	</tr>
	{section name=idx loop=$donate2}
	{if $smarty.section.idx.first}
	<tr>
		<td align='left' class='donate_title'>
			<br />
			<p>{$locale.don303}</p>
			<hr />		
		</td>
	</tr>
	<tr>
		<td align='left'>
			<p>{$locale.don304}</p>
			<br />
		</td>
	</tr>
	<tr>
		<td align='center'>
			<table align='center' cellpadding='0' cellspacing='1' width='100%' class='tbl-border'>
				<tr>
					<td width='15%' align='center' class='tbl2'>
						<b>{$locale.don211}</b>
					</td>
					<td width='13%' align='center' class='tbl2'>
						<b>{$locale.don213}</b>
					</td>
					<td align='center' class='tbl2'>
						<b>{$locale.don214}</b>
					</td>
				</tr>
	{/if}
				<tr>
					<td width='15%' class='tbl1'>
						{$donate2[idx].donate_timestamp|date_format:'shortdate'}
					</td>
					<td width='13%' align='center' class='tbl1'>
						{if $donate2[idx].donate_state == "2"}<b>{/if}
							{$donate1[idx].donate_amount|string_format:"%01.2f"} {$donate2[idx].donate_currency}
						{if $donate2[idx].donate_state == "2"}</b>{/if}
					</td>
					<td class='tbl1'>
						{if $donate2[idx].donate_state == "2"}<b>{/if}
						{$donate2[idx].donate_comment}
						{if $donate2[idx].donate_state == "2"}</b>{/if}
					</td>
				</tr>
	{if $smarty.section.idx.last}
			</table>
		</td>
	</tr>
	{/if}
	{/section}
</table>
{include file="_closetable.tpl"}
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}