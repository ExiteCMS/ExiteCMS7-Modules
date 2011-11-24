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
{* $Id:: modules.translations.admin_panel.tpl 2043 2008-11-16 14:25:18Z W#$*}
{*-------------------------------------------------------------------------*}
{* Last modified by $Author:: WanWizard                                   $*}
{* Revision number $Rev:: 2043                                            $*}
{***************************************************************************}
{*                                                                         *}
{* This template generates the translations admin panel                    *}
{*                                                                         *}
{***************************************************************************}
{if $message|default:"" != ""}
	{include file="_opentable.tpl" name=$_name title=$locale.900 state=$_state style=$_style}
	<div align='center'>
		<br />
		<b>{$message}</b>
		<br />
	</div>
	{include file="_closetable.tpl"}
{/if}
{if $step == "add" || $step == "edit"}
	{if $step == "add"}
		{include file="_opentable.tpl" name=$_name title=$locale.415 state=$_state style=$_style}
	{else}
		{include file="_opentable.tpl" name=$_name title=$locale.416 state=$_state style=$_style}
	{/if}
	<form name='localeform' method='post' action='{$smarty.const.FUSION_SELF}{$aidlink}&amp;step={$step}'>
		<table align='center' cellpadding='0' cellspacing='0'>
			<tr>
				<td class='tbl' valign='top'>
					{$locale.420}:
				</td>
				<td class='tbl'>
					{if $step == "add"}
						<input type='text' name='locale_code' value='{$locale_code}' maxlength='8' class='textbox' style='width:75px;' />
						<br />
						<span class='smallalt'>{$locale.428}</span>
					{else}
						<b>{$locale_code}</b>
						<input type='hidden' name='locale_code' value='{$locale_code}' />
					{/if}
				</td>
			</tr>
			<tr>
				<td class='tbl' valign='top'>
					{$locale.421}:
				</td>
				<td class='tbl'>
					<input type='text' name='locale_name' value='{$locale_name}' maxlength='50' class='textbox' style='width:250px;' />
					<input type='hidden' name='old_locale_name' value='{$locale_name}' />
					<br />
					<span class='smallalt'>{$locale.422}</span>
				</td>
			</tr>
			<tr>
				<td class='tbl' valign='top'>
					{$locale.423}:
				</td>
				<td class='tbl'>
					<input type='text' name='locale_locale' value='{$locale_locale}' maxlength='100' class='textbox' style='width:250px;' />
					<br />
					<span class='smallalt'>{$locale.424}</span>
				</td>
			</tr>
			<tr>
				<td class='tbl' valign='top'>
					{$locale.433}:
				</td>
				<td class='tbl'>
					<input type='text' name='locale_countries' value='{$locale_countries}' maxlength='100' class='textbox' style='width:250px;' />
					<br />
					<span class='smallalt'>{$locale.434}</span>
				</td>
			</tr>
			<tr>
				<td class='tbl' valign='top'>
					{$locale.425}:
				</td>
				<td class='tbl'>
					<input type='text' name='locale_charset' value='{$locale_charset}' maxlength='25' class='textbox' style='width:200px;' />
					<br />
					<span class='smallalt'>{$locale.426}</span>
				</td>
			</tr>
			<tr>
				<td class='tbl' valign='top'>
					{$locale.435}:
				</td>
				<td class='tbl'>
					<select name='locale_direction' class='textbox' style='width:200px;'>
						<option value='LTR'{if $locale_direction == "LTR"}selected="selected"{/if}>{$locale.436}</option>
						<option value='RTL'{if $locale_direction == "RTL"}selected="selected"{/if}>{$locale.437}</option>
					</select>
				</td>
			</tr>
		</table>
		<br />
		<table align='center' width='400' cellpadding='0' cellspacing='0'>
			<tr>
				<td class='tbl' align='center'>
					{$locale.429}:
				</td>
				<td class='tbl' align='center'>
					{$locale.404}:
				</td>
			</tr>
			<tr>
				<td class='tbl' align='center'>
					<select multiple size='15' name='userlist1' id='userlist1' class='textbox' style='width:150px;' onChange="addUser('userlist2','userlist1');">
					{section name=id loop=$userlist1}
						<option value='{$userlist1[id].id}'>{$userlist1[id].name}</option>
					{/section}
					</select>
				</td>
				<td class='tbl' align='center'>
					<select multiple size='15' name='userlist2' id='userlist2' class='textbox' style='width:150px;' onChange="addUser('userlist1','userlist2');">
					{section name=id loop=$userlist2}
						<option value='{$userlist2[id].id}'>{$userlist2[id].name}</option>
					{/section}
					</select>
				</td>
			</tr>
			<tr>
				<td align='center' colspan='2'>
					<br />
					<input type='submit' name='add_edit' value='{$locale.427}' class='button' onclick='saveTranslators();' />
					<input type='hidden' name='locale_id' value='{$locale_id}' />
					<input type='hidden' name='translators' value='' />
				</td>
			</tr>
		</table>
	</form>
	{include file="_closetable.tpl"}
	{literal}
	<script type='text/javascript'>
	// Script Original Author: Kathi O'Shea (Kathi.O'Shea@internet.com)
	// http://www.webdesignhelper.co.uk/sample_code/sample_code/sample_code10/sample_code10.shtml		
	function addUser(toGroup,fromGroup) {
		var listLength = document.getElementById(toGroup).length;
		var selItem = document.getElementById(fromGroup).selectedIndex;
		var selText = document.getElementById(fromGroup).options[selItem].text;
		var selValue = document.getElementById(fromGroup).options[selItem].value;
		var i; var newItem = true;
		for (i = 0; i < listLength; i++) {
			if (document.getElementById(toGroup).options[i].text == selText) {
				newItem = false; break;
			}
		}
		if (newItem) {
			document.getElementById(toGroup).options[listLength] = new Option(selText, selValue);
			document.getElementById(fromGroup).options[selItem] = null;
		}
	}
	function saveTranslators() {
		var strValues = "";
		var boxLength = document.getElementById('userlist2').length;
		var elcount = 0;
		if (boxLength != 0) {
			for (i = 0; i < boxLength; i++) {
				if (elcount == 0) {
					strValues = document.getElementById('userlist2').options[i].value;
				} else {
					strValues = strValues + "." + document.getElementById('userlist2').options[i].value;
				}
				elcount++;
			}
		}
		if (strValues.length == 0) {
			document.forms['localeform'].submit();
		} else {
			document.forms['localeform'].translators.value = strValues;
			document.forms['localeform'].submit();
		}
	}
	</script>
	{/literal}
{/if}
{include file="_opentable.tpl" name=$_name title=$locale.400 state=$_state style=$_style}
{section name=id loop=$localelist}
	{if $smarty.section.id.first}
		<table align='center' cellpadding='0' cellspacing='1' class='tbl-border'>
			<tr>
				<td class='tbl2'>
					<b>{$locale.401}</b>
				</td>
				<td align='center' width='1%' class='tbl2' style='white-space:nowrap'>
					<b>{$locale.402}</b>
				</td>
				<td align='center' width='1%' class='tbl2' style='white-space:nowrap'>
					<b>{$locale.403}</b>
				</td>
				<td align='center' width='1%' class='tbl2' style='white-space:nowrap'>
					<b>{$locale.404}</b>
				</td>
				<td align='center' width='1%' class='tbl2' style='white-space:nowrap'>
					<b>{$locale.431}</b>
				</td>
				<td align='center' width='1%' class='tbl2' style='white-space:nowrap'>
					<b>{$locale.405}</b>
				</td>
				<td align='center' width='1%' class='tbl2' style='white-space:nowrap'>
					<b>{$locale.408}</b>
				</td>
			</tr>
	{/if}
		<tr>
			<td class='{cycle values="tbl1,tbl2" advance=no}'>
				{$localelist[id].locale_name}
			</td>
			<td align='center' width='1%' class='{cycle values="tbl1,tbl2" advance=no}' style='white-space:nowrap'>
				{$localelist[id].locale_code}
			</td>
			<td align='center' width='1%' class='{cycle values="tbl1,tbl2" advance=no}' style='white-space:nowrap'>
				{if $localelist[id].locale_active}{$locale.406}{else}{$locale.407}{/if}
			</td>
			<td align='center' width='1%' class='{cycle values="tbl1,tbl2" advance=no}' style='white-space:nowrap'>
				{section name=uid loop=$localelist[id].translators}
					<a href='{$smarty.const.BASEDIR}profile.php?lookup={$localelist[id].translators[uid].user_id}'>{$localelist[id].translators[uid].user_name}</a>
					({$localelist[id].translators[uid].updated}%)
					<br />
				{/section}
			</td>
			<td align='center' width='1%' class='{cycle values="tbl1,tbl2" advance=no}' style='white-space:nowrap'>
					{math equation="x/y*100" format="%u" x=$localelist[id].records y=$max_records}%
			</td>
			<td align='center' width='1%' class='{cycle values="tbl1,tbl2" advance=no}' style='white-space:nowrap'>
				{if $localelist[id].last_updated}
					{$localelist[id].last_updated|date_format:"shortdate"}{if $localelist[id].translator_updated == 0}*{/if}
				{else}
					{$locale.414}
				{/if}
			</td>
			<td align='left' width='1%' class='{cycle values="tbl1,tbl2"}' style='white-space:nowrap'>
				{if $localelist[id].locale_active}
					{if $can_deactivate && $localelist[id].locale_code != "en"}
						{imagelink link=$smarty.const.FUSION_SELF|cat:$aidlink|cat:"&amp;step=deactivate&amp;locale_id="|cat:$localelist[id].locale_id title=$locale.412|escape:"html" alt=$locale.412|escape:"html" image="page_red.gif"}&nbsp;
					{/if}
				{else}
					{imagelink link=$smarty.const.FUSION_SELF|cat:$aidlink|cat:"&amp;step=activate&amp;locale_id="|cat:$localelist[id].locale_id title=$locale.413|escape:"html" alt=$locale.413|escape:"html" image="page_green.gif"}&nbsp;
				{/if}
				{if $localelist[id].can_edit}
					{imagelink link=$smarty.const.FUSION_SELF|cat:$aidlink|cat:"&amp;step=edit&amp;locale_id="|cat:$localelist[id].locale_id title=$locale.409|escape:"html" alt=$locale.409|escape:"html" image="page_edit.gif"}&nbsp;
				{/if}
				{if $localelist[id].can_delete}
					{imagelink link=$smarty.const.FUSION_SELF|cat:$aidlink|cat:"&amp;step=delete&amp;locale_id="|cat:$localelist[id].locale_id title=$locale.410|escape:"html" alt=$locale.410|escape:"html" onclick='return DeleteLocale("'|cat:$localelist[id].locale_name|cat:'");' image="page_delete.gif"}&nbsp;
				{/if}
				{imagelink link=$smarty.const.FUSION_SELF|cat:$aidlink|cat:"&amp;step=generate&amp;locale_id="|cat:$localelist[id].locale_id title=$locale.432|escape:"html" alt=$locale.432|escape:"html" image="cog_go.gif"}
			</td>
		</tr>
	{if $smarty.section.id.last}
		</table>
		<div style='text-align:center;'>
			{$locale.918}
			<br /><br />
			{buttonlink name=$locale.415 link=$smarty.const.FUSION_SELF|cat:$aidlink|cat:"&amp;step=add"}
		</div>
	{/if}
{sectionelse}
	huh?
{/section}
{include file="_closetable.tpl"}
<script type='text/javascript'>
function DeleteLocale(localename) {ldelim}
	return confirm('{$locale.912}');
{rdelim}
</script>
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}
