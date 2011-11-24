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
						<b>{$locale.don455}</b>
					</td>
					<td width='1%' align='center' class='tbl2' style='white-space:nowrap'>
						<b>{$locale.don457}</b>
					</td>
					<td align='center' class='tbl2'>
						<b>{$locale.don458}</b>
					</td>
				</tr>
				{section name=idx loop=$donate2}
				<tr>
					<td width='15%' class='tbl1' style='white-space:nowrap'>
						{$donate2[idx].donate_timestamp|date_format:'shortdate'}
					</td>
					<td width='13%' align='right' class='tbl1' style='white-space:nowrap'>
						{if $donate2[idx].donate_state == "2"}<b>{/if}
							{$donate2[idx].donate_amount|string_format:"%01.2f"} {$donate2[idx].donate_currency}
						{if $donate2[idx].donate_state == "2"}</b>{/if}
					</td>
					<td class='tbl1'>
						{if $donate2[idx].donate_state == "2"}<b>{/if}
						{$donate2[idx].donate_comment}
						{if $donate2[idx].donate_state == "2"}</b>{/if}
					</td>
				</tr>
				{sectionelse}
					<tr>
						<td align='center' class='tbl1' colspan='3'>
							<br />
							{$locale.don471}
							<br /><br />
						</td>
					</tr>
				{/section}
			</table>
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}
	
