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
{* Template for the admin content module 'advertising'. This template      *}
{* generates a panel asking for a delete confirmation                      *}
{*                                                                         *}
{***************************************************************************}
{include file="_opentable.tpl" name=$_name title=$_title state=$_state style=$_style}
<form name='delclient' method='post' action='{$smarty.const.FUSION_SELF}{$aidlink}&amp;action=delclientconf&amp;id={$id}'>
	<table align='center' cellpadding='0' cellspacing='0'>
	<tr>
		<td class='tbl'>
			<div align='center'><b>{$question}</b></div>
		</td>
	</tr>
	<tr>
		<td align='center' class='tbl'>
			<br />
			<input type='submit' name='no' value='{$locale.ads422}' class='button' />&nbsp;
			<input type='submit' name='yes' value='{$locale.ads423}' class='button' />
		</td>
	</tr>
	</table>
</form>
{include file="_closetable.tpl"}
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}
