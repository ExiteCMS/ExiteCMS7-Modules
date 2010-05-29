{***************************************************************************}
{* ExiteCMS Content Management System                                      *}
{***************************************************************************}
{* Copyright 2010 Exite BV, The Netherlands                                *}
{* for support, please visit http://www.exitecms.org                       *}
{*-------------------------------------------------------------------------*}
{* Released under the terms & conditions of v2 of the GNU General Public   *}
{* License. For details refer to the included gpl.txt file or visit        *}
{* http://gnu.org                                                          *}
{***************************************************************************}
{* $Id:: modules.newsletters.tpl 2043 2008-11-16 14:25:18Z WanWizard      $*}
{*-------------------------------------------------------------------------*}
{* Last modified by $Author:: WanWizard                                   $*}
{* Revision number $Rev:: 2043                                            $*}
{***************************************************************************}
{*                                                                         *}
{* Template for the admin installable module 'merge_forums'                 *}
{*                                                                         *}
{***************************************************************************}
{include file="_opentable.tpl" name=$_name title=$locale.mf400 state=$_state style=$_style}
{if $error != ""}
<p style="text-align:center;font-weight:bold;color:red;">{$error}</p>
{/if}

<form name='selectform' method='post' action='{$smarty.const.FUSION_SELF}{$aidlink}' onsubmit='return ValidateSelection(this);' >
	<table align='center' cellpadding='0' cellspacing='1' width='800' class='tbl-border'>
		<tr>
			<td align='left' class='tbl2'>
				<b>{$locale.mf401}</b>
			</td>
			<td align='left' class='tbl1'>
				<select name='forum_from_id' class='textbox' style='width:600px;'>
					{foreach from=$forums key=forum_id item=forum}
						<option value='{$forum_id}' {if $forum_id==$forum_from_id}selected="selected"{/if}>{$forum}</option>
					{/foreach}
				</select>
			</td>
		</tr>
		<tr>
			<td align='left' class='tbl2'>
				<b>{$locale.mf402}</b>
			</td>
			<td align='left' class='tbl1'>
				<select name='forum_to_id' class='textbox' style='width:600px;'>
					{foreach from=$forums key=forum_id item=forum}
						<option value='{$forum_id}' {if $forum_id==$forum_to_id}selected="selected"{/if}>{$forum}</option>
					{/foreach}
				</select>
			</td>
		</tr>
		<tr>
			<td align='left' class='tbl2'>
				<b>{$locale.mf403}</b>
			</td>
			<td align='left' class='tbl1'>
				<input type='text' name='prefix' value='{$prefix}' class='textbox' style='width:600px' />
			</td>
		</tr>
	</table>

	<center>
		<br />
		<input type='submit' name='merge' value='{$locale.mf404}' class='button' onclick='return AreYouSure();'/>
		<br />
	</center>
</form>
{include file="_closetable.tpl"}
<script type="text/javascript">
{literal}
function ValidateSelection(frm) {
	if (frm.forum_from_id.selectedIndex == frm.forum_to_id.selectedIndex) {
		alert('{/literal}{$locale.mf500}{literal}');
		return false;
	} else {
		return true;
	}
}
function AreYouSure(frm) {
	return confirm('{/literal}{$locale.mf501}{literal}');
}
{/literal}
</script>
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}
