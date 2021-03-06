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
{* generates a panel for adding or editing an ad.                          *}
{*                                                                         *}
{***************************************************************************}
{if $errormessage|default:"" != ""}
	{include file="_message_table_panel.tpl" name=$_name title=$errortitle state=$_state style=$_style message=$errormessage bold=true}
{/if}
{literal}<script type='text/javascript'>
// <!--
function hidefields(ref) {

	var element;

	switch(ref.selectedIndex) {
		case 0:
			// hide enddate, sold1, sold2
			if (document.all) element = document.all[enddate];
			else if (document.getElementById) element = document.getElementById('enddate');
			if (element && element.style) element.style.display = 'none';
			if (document.all) element = document.all[sold1];
			else if (document.getElementById) element = document.getElementById('sold1');
			if (element && element.style) element.style.display = 'none';
			if (document.all) element = document.all[sold2];
			else if (document.getElementById) element = document.getElementById('sold2');
			if (element && element.style) element.style.display = 'none';
			break;
		case 1:
			// show enddate, hide sold1, sold2
			if (document.all) element = document.all[enddate];
			else if (document.getElementById) element = document.getElementById('enddate');
			if (element && element.style) element.style.display = '';
			if (document.all) element = document.all[sold1];
			else if (document.getElementById) element = document.getElementById('sold1');
			if (element && element.style) element.style.display = 'none';
			if (document.all) element = document.all[sold2];
			else if (document.getElementById) element = document.getElementById('sold2');
			if (element && element.style) element.style.display = 'none';
			break;
		case 2:
			// hide enddate, show sold1, sold2
			if (document.all) element = document.all[enddate];
			else if (document.getElementById) element = document.getElementById('enddate');
			if (element && element.style) element.style.display = 'none';
			if (document.all) element = document.all[sold1];
			else if (document.getElementById) element = document.getElementById('sold1');
			if (element && element.style) element.style.display = '';
			if (document.all) element = document.all[sold2];
			else if (document.getElementById) element = document.getElementById('sold2');
			if (element && element.style) element.style.display = '';
			break;
		default:
			break;
	}
	return true;
}
// -->
</script>{/literal}
{include file="_opentable.tpl" name=$_name title=$_title state=$_state style=$_style}
<form name='advertisement' method='post' action='{$smarty.const.FUSION_SELF}{$aidlink}&amp;action={$action}{if $action == "edit"}&amp;adverts_id={$adverts_id}{/if}&amp;id={$ad_client_id}' enctype='multipart/form-data'>
	<table align='center' width='600' cellpadding='0' cellspacing='0'>
		<tr>
			<td width='175' class='tbl'>{$locale.ads411}:</td>
			<td class='tbl'>
				<select class='textbox' name='adverts_contract' onchange='hidefields(this)'>
					{html_options options=$contract_types selected=$adverts_contract}
				</select>
			</td>
		</tr>
		<tr>
			<td width='175' class='tbl'>{$locale.ads412}:</td>
			<td class='tbl'>
				<select name='contract_start[mday]' class='textbox'>
					{section name=sd start=1 loop=32}
						<option{if $contract_start.mday|default:0 == $smarty.section.sd.index} selected="selected"{/if}>{$smarty.section.sd.index}</option>
					{/section}
				</select>
				<select name='contract_start[mon]' class='textbox'>
					{section name=sd start=1 loop=13}
						<option{if $contract_start.mon|default:0 == $smarty.section.sd.index} selected="selected"{/if}>{$smarty.section.sd.index}</option>
					{/section}
				</select>
				<select name='contract_start[year]' class='textbox'>
					{section name=sd start=$ys loop=$ye}
						<option{if $contract_start.year|default:0 == $smarty.section.sd.index} selected="selected"{/if}>{$smarty.section.sd.index}</option>
					{/section}
				</select>
			</td>
		</tr>
		<tr id='enddate' style='{if $adverts_contract != 1}display:none{/if}'>
			<td width='175' class='tbl'>{$locale.ads413}:</td>
			<td class='tbl'>
				<select name='contract_end[mday]' class='textbox'>
					{section name=sd start=1 loop=32}
						<option{if $contract_end.mday|default:0 == $smarty.section.sd.index} selected="selected"{/if}>{$smarty.section.sd.index}</option>
					{/section}
				</select>
				<select name='contract_end[mon]' class='textbox'>
					{section name=sd start=1 loop=13}
						<option{if $contract_end.mon|default:0 == $smarty.section.sd.index} selected="selected"{/if}>{$smarty.section.sd.index}</option>
					{/section}
				</select>
				<select name='contract_end[year]' class='textbox'>
					{section name=sd start=$ys loop=$ye}
						<option{if $contract_end.year|default:0 == $smarty.section.sd.index} selected="selected"{/if}>{$smarty.section.sd.index}</option>
					{/section}
				</select>
			</td>
		</tr>
		<tr id='sold1' style='{if $adverts_contract !=2}display:none{/if}'>
			<td width='175' class='tbl'>{$locale.ads414}:</td>
			<td class='tbl'>{$adverts_sold}</td>
		</tr>
		<tr id='sold2' style='{if $adverts_contract !=2}display:none{/if}'>
			<td width='175' class='tbl'>{$locale.ads415}:</td>
			<td class='tbl'>
				<select class='textbox' name='change' size='1'>
					<option value='+' selected="selected">{$locale.ads420}</option>
					<option value='-'>{$locale.ads421}</option>
				</select>&nbsp;
				<input type='text' class='textbox' name='adverts_purchased' value='0' size='12' maxlength='11' />
			</td>
		</tr>
		<tr>
			<td width='175' class='tbl'>{$locale.ads416}:</td>
			<td class='tbl'>
				<select class='textbox' name='adverts_location'>
					{section name=adloc loop=$locations}
						<option value='{$locations[adloc].index}'{if $adverts_location == $locations[adloc].index} selected="selected"{/if}>{$locations[adloc].location}&nbsp;&nbsp;({$locations[adloc].dimension})</option>
					{/section}
				</select>
			</td>
		</tr>
		<tr>
			<td width='175' class='tbl'>{$locale.ads417}:</td>
			<td class='tbl'>
				{if $ad_images|@count}
					<select class='textbox' name='adverts_image'>
						{section name=img loop=$ad_images}
							<option value='{$ad_images[img].ad_image}'{if $adverts_image == $ad_images[img].ad_image} selected="selected"{/if}>{$ad_images[img].img}&nbsp;&nbsp;({$ad_images[img].x}x{$ad_images[img].y})</option>
						{/section}
					</select>
				{else}
					<b>{$locale.ads449}</b>
				{/if}
			</td>
		</tr>
		<tr>
			<td width='175' class='tbl'>{$locale.ads424}:</td>
			<td class='tbl'>
				<select name='adverts_priority' class='textbox'>
					{section name=sd start=1 loop=6}
						<option value='{$smarty.section.sd.index}'{if $smarty.section.sd.index == $adverts_priority} selected="selected"{/if}> {$smarty.section.sd.index} </option>
					{/section}
				</select>
			</td>
		</tr>
		<tr>
			<td width='175' class='tbl'>{$locale.ads418}:</td>
			<td class='tbl'>
				<input type='text' class='textbox' name='adverts_url' value='{$adverts_url}' size='60' maxlength='200' />
			</td>
		</tr>
		<tr>
			<td width='175' class='tbl'>{$locale.ads419}:</td>
			<td class='tbl'>
				<select class='textbox' name='adverts_status'>
					<option value='0'{if $adverts_status == 0} selected="selected"{/if}>{$locale.ads422}</option>
					<option value='1'{if $adverts_status == 1} selected="selected"{/if}>{$locale.ads423}</option>
				</select>
			</td>
		</tr>
		<tr>
			<td align='center' colspan='2' class='tbl'>
				<input type='hidden' name='ad_client' value='{$ad_client}' />
				<input type='hidden' name='adverts_expired' value='{$adverts_expired}' />
				<input type='hidden' name='adverts_sold' value='{$adverts_sold}' />
				<input type='hidden' name='adverts_userid' value='{$adverts_userid}' />
				<br />
				<input type='submit' name='cancel' value='{$locale.ads441}' class='button' />&nbsp;
				<input type='submit' name='save' value='{$locale.ads440}' class='button' />&nbsp;
				{if $action == "edit"}
					{if $adverts_expired|default:false}
						<input type='submit' name='activate' value='{$locale.ads443}' class='button' />
					{else}
						<input type='submit' name='expire' value='{$locale.ads442}' class='button' />
					{/if}
				{/if}
			</td>
		</tr>
		<tr>
			<td align='center' colspan='2' class='tbl'>
				<hr />
			</td>
		</tr>
		<tr>
			<td width='175' class='tbl'>
				<br />{$locale.ads530}:<br />
			</td>
			<td class='tbl'>
				<br /><input type='file' name='myfile' class='textbox' style='width:250px;' /><br />
			</td>
		</tr>
		<tr>
			<td align='center' colspan='2' class='tbl'>
				<br />
				<input type='submit' name='upload' value='{$locale.ads449}' class='button' />
			</td>
		</tr>
	</table>
</form>
{if $smarty.const.ADVERT_MOVE_AD && $action == "edit"}
<form name='moveuser' method='post' action='{$smarty.const.FUSION_SELF}{$aidlink}&amp;action=edit&amp;id={$ad_client_id}'>
	<table align='center' width='600' cellpadding='0' cellspacing='0'>
		<tr>
			<td align='center' class='tbl'>
				<hr /><br />
				<input type='hidden' name='adverts_id' value='{$adverts_id}' />
				<input type='submit' name='moveuser' value='{$locale.ads425}' class='button' /> : 
				<select class='textbox' name='newid' onkeydown='incrementalSelect(this,event)'>
					<option value='0'>--------</option>
					{html_options options=$users}
				</select>
			</td>
		</tr>
	</table>
</form>
{/if}
{include file="_closetable.tpl"}
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}
