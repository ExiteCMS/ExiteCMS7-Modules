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
{* $Id:: modules.shoutbox_panel.admin.tpl 2104 2008-12-08 18:52:42Z webma#$*}
{*-------------------------------------------------------------------------*}
{* Last modified by $Author:: webmaster                                   $*}
{* Revision number $Rev:: 2104                                            $*}
{***************************************************************************}
{*                                                                         *}
{* Template for the donor list page of the donations module                *}
{*                                                                         *}
{***************************************************************************}
			<table align='center' cellpadding='0' cellspacing='1' width='100%' class='tbl-border'>
				<tr>
					<td width='1%' align='center' class='tbl2' style='white-space:nowrap'>
						<b>{$locale.don456}</b>
					</td>
					<td width='1%' align='center' class='tbl2' style='white-space:nowrap'>
						<b>{$locale.don457}</b>
					</td>
					<td width='1%' align='center' class='tbl2' style='white-space:nowrap'>
						<b>{$locale.don455}</b>
					</td>
					<td align='center' class='tbl2'>
						<b>{$locale.don458}</b>
					</td>
				</tr>
				{section name=idx loop=$donate1}
					<tr>
						<td width='1%' class='tbl1' style='white-space:nowrap'>
							{$donate1[idx].country}
							{if $donate1[idx].donate_state == "2"}<b>{/if}
							{if $donate1[idx].donate_name == ""}{$locale.don459}{else}{$donate1[idx].donate_name}{/if}
							{if $donate1[idx].donate_state == "2"}</b>{/if}
						</td>
						<td width='1%' align='right' class='tbl1' style='white-space:nowrap'>
							{if $donate1[idx].donate_state == "2"}<b>{/if}
							{$donate1[idx].donate_amount|string_format:"%01.2f"} {$donate1[idx].donate_currency}
							{if $donate1[idx].donate_state == "2"}</b>{/if}
						</td>
						<td width='1%' class='tbl1' style='white-space:nowrap'>
							{$donate1[idx].donate_timestamp|date_format:'shortdate'}
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
							{$locale.don472}
							<br /><br />
						</td>
					</tr>
				{/section}
			</table>
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}
	
