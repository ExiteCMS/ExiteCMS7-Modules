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
{* $Id::                                                                  $*}
{*-------------------------------------------------------------------------*}
{* Last modified by $Author::                                             $*}
{* Revision number $Rev::                                                 $*}
{***************************************************************************}
{*                                                                         *}
{* Template for the admin content module 'advertising'                     *}
{*                                                                         *}
{***************************************************************************}
{if $errormessage|default:"" != ""}
	{include file="_message_table_panel.tpl" name=$_name title=$errortitle state=$_state style=$_style message=$errormessage}
{/if}
{include file="_opentable.tpl" name=$_name title=$locale.ads402 state=$_state style=$_style}
<table align='center' cellpadding='0' cellspacing='1' width='600' class='tbl-border'>
	<tr>
		<td align='center' class='tbl1'>
		<form name='subfunctions' method='post' action='{$smarty.const.FUSION_SELF}{$aidlink}'>
			<br />
			<input type='submit' name='add' value='{$locale.ads447}' class='button' />&nbsp;
			<input type='submit' name='images' value='{$locale.ads448}' class='button' />
			<br /><br />
		</form>
		</td>
	</tr>
</table>
{include file="_closetable.tpl"}
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}
