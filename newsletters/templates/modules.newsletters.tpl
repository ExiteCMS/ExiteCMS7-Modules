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
{* Template for the admin installable module 'newsletters'                 *}
{*                                                                         *}
{***************************************************************************}
{include file="_opentable.tpl" name=$_name title=$locale.nl400 state=$_state style=$_style}
<form name='selectform' method='post' action='{$smarty.const.FUSION_SELF}{$aidlink}' onclick='return ValidateSelection(this);' >
	<center>
		<select name='newsletter_id' class='textbox' style='width:600px;'>
			{section name=id loop=$newsletters}
				<option value='{$newsletters[id].newsletter_id}'{if $newsletters[id].selected} selected{/if}>{if $newsletters[id].newsletter_sent == 1}{$newsletters[id].newsletter_send_datestamp|date_format:"%Y-%m-%d %T"}{else}{$locale.nl404}{/if} - {$newsletters[id].newsletter_subject}</option>
			{/section}
		</select>
		<input type='submit' name='edit' value='{$locale.nl401}' class='button' />
		<input type='submit' name='delete' value='{$locale.nl402}' class='button' onclick='return DeleteNewsletter();'/>
		<input type='submit' name='send' value='{$locale.nl405}' class='button' />
	</center>
</form>
{include file="_closetable.tpl"}
<script type="text/javascript">
{literal}
function ValidateSelection(frm) {
	if(frm.newsletter_id.value=='') return false;
}
function DeleteNewsletter(frm) {
	if (document.selectform.newsletter_id.value=='') return false;
	return confirm('{/literal}{$locale.nl451}{literal}');
}
{/literal}
</script>
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}
