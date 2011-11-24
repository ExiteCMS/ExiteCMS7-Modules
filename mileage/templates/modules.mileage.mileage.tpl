{***************************************************************************}
{* ExiteCMS Content Management System                                      *}
{***************************************************************************}
{* Copyright 2006-2009 Exite BV, The Netherlands                           *}
{* for support, please visit http://www.exitecms.org                       *}
{*-------------------------------------------------------------------------*}
{* Released under the terms & conditions of v2 of the GNU General Public   *}
{* License. For details refer to the included gpl.txt file or visit        *}
{* http://gnu.org                                                          *}
{***************************************************************************}
{* $Id:: modules.download_statistics.admin.tpl 2043 2008-11-16 14:25:18Z #$*}
{*-------------------------------------------------------------------------*}
{* Last modified by $Author:: WanWizard                                   $*}
{* Revision number $Rev:: 2043                                            $*}
{***************************************************************************}
{*                                                                         *}
{* Template for the data entry panel of the 'mileage' module               *}
{*                                                                         *}
{***************************************************************************}
{if $action == "edit" || $action == "add"}
	{if $action == "edit"}
		{include file="_opentable.tpl" name=$_name title=$locale.eA_744|cat:" <b>"|cat:$car.car_registration|cat:" </b>("|cat:$car.car_description|cat:")" state=$_state style=$_style}
	{elseif $action == "add"}
		{include file="_opentable.tpl" name=$_name title=$locale.eA_710|cat:" <b>"|cat:$car.car_registration|cat:" </b>("|cat:$car.car_description|cat:")" state=$_state style=$_style}
	{/if}
	<form name='layoutform' method='post' action='{$formaction}'>
		<table align='center' cellpadding='0' cellspacing='0'>
			<tr>
				<td class='tbl' valign='top'>
					{$locale.eA_721}:
				</td>
				<td class='tbl'>
					<b>{$car.car_total_mileage} {$car.mileage_unit}</b>
				</td>
			</tr>
			<tr>
				<td class='tbl' valign='top'>
					{$locale.eA_603}:
				</td>
				<td class='tbl'>
					{if $users|@count == 1}
						<b>{$users.0.user_name} - {$users.0.user_fullname}</b>
						<input type='hidden' name='travel_driver_id' value='{$users.0.user_id}' />
					{else}
						<select name='travel_driver_id' class='textbox' style='width:350px;'>
							{section name=id loop=$users}
								<option value='{$users[id].user_id}'{if $users[id].user_id == $travel_driver_id} selected="selected"{/if}>{$users[id].user_name} - {$users[id].user_fullname}</option>
							{/section}
						</select>
					{/if}
				</td>
			</tr>
			<tr>
				<td class='tbl' valign='top'>
					{$locale.eA_737}:
				</td>
				<td class='tbl'>
					<b>
						{if $travel.adr_description == ""}
							{$travel.adr_type_desc} {$locale.eA_661}
						{else}
							{$travel.adr_description}, {$travel.adr_city} ({$travel.adr_country}) - {$travel.adr_type_desc}
						{/if}
						</b>
					<input type='hidden' name='travel_from' value='{$travel.adr_id}' />
				</td>
			</tr>
			<tr>
				<td class='tbl' valign='top'>
					{$locale.eA_720}:
				</td>
				<td class='tbl'>
					{html_select_date prefix='trip_' time=$travel_date start_year="-1" end_year="+1" all_extra="class='textbox'"}
					-
					{html_select_time prefix='trip_' time=$travel_date display_seconds=0 all_extra="class='textbox'"}
				</td>
			</tr>
			<tr>
				<td class='tbl' valign='top'>
					{$locale.eA_729}:
				</td>
				<td class='tbl'>
					<select name='travel_type' class='textbox'>
						{if $travel.adr_description != "" || $action == "edit"}
							<option value='B'{if $travel_type == "B"} selected="selected"{/if}>{$locale.eA_726}</option>
						{/if}
						<option value='P'{if $travel_type == "P"} selected="selected"{/if}>{$locale.eA_727}</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class='tbl' valign='top'>
					{$locale.eA_728}:
				</td>
				<td class='tbl'>
					<select name='travel_to' id='travel_to' class='textbox' style='width:100%' onchange='getMileage(this);'>
						<option value='0'>&nbsp;</option>
						{section name=id loop=$address}
							<option value='{$address[id].adr_id}'{if $address[id].adr_id == $travel_to} selected="selected"{/if}>{$address[id].adr_description}, {$address[id].adr_city} ({$address[id].adr_country})  » {$address[id].adr_type_desc}</option>
						{/section}
					</select>
					<fieldset style="margin:0px;margin-top:5px;">
						<legend>[ {$locale.eA_659} ]</legend>
						<table width='100%' align='center' cellpadding='0' cellspacing='0'>
							<tr>
								<td class='tbl'>
									{$locale.eA_660}:
								</td>
								<td class='tbl'>
									<input type='text' name='new_ident' value='{$new_ident}' maxlength='50' class='textbox' style='width:300px;' />
								</td>
							</tr>
							<tr>
								<td class='tbl'>
									{$locale.eA_661}:
								</td>
								<td class='tbl'>
									<input type='text' name='new_address' id='new_address' value='{$new_address}' maxlength='50' class='textbox' style='width:300px;' />
								</td>
							</tr>
							<tr>
								<td class='tbl'>
									{$locale.eA_662}:
								</td>
								<td class='tbl'>
									<input type='text' name='new_postcode' id='new_postcode' value='{$new_postcode}' maxlength='15' class='textbox' style='width:150px;' />
								</td>
							</tr>
							<tr>
								<td class='tbl'>
									{$locale.eA_663}:
								</td>
								<td class='tbl'>
									<input type='text' name='new_city' id='new_city' value='{$new_city}' maxlength='50' class='textbox' style='width:300px;' />
								</td>
							</tr>
							<tr>
								<td class='tbl'>
									{$locale.eA_664}:
								</td>
								<td class='tbl'>
									<select name='new_country' id='new_country' class='textbox' style='width:225px;'>
									{section name=cc loop=$countries}
									<option value='{$countries[cc].locales_key}'{if $countries[cc].locales_key == $new_country} selected="selected"{/if}>{$countries[cc].locales_value}</option>
									{/section}
									</select>
								</td>
							</tr>
						</table>
					</fieldset>
					<span class='small'>{$locale.eA_722}</span>
				</td>
			</tr>
			<tr>
				<td class='tbl' valign='top'>
					{$locale.eA_723}:
				</td>
				<td class='tbl'>
					<input type='text' name='travel_mileage' id='travel_mileage' value='{$travel_mileage}' maxlength='5' class='textbox' style='width:100px;' /> {$car.mileage_unit}
					&nbsp;&nbsp;
					{buttonlink name=$locale.eA_745 link="javascript:GetDistance();return false;" script="yes"}
					&nbsp;&nbsp;
					{buttonlink name=$locale.eA_747 link="javascript:GoogleMaps();return false;" script="yes"}
					<select name='gm_travel_to' id='gm_travel_to' style='display:inline;visibility:hidden;width:1px'>
						<option value='0'>&nbsp;</option>
						{section name=id loop=$address}
							<option value='{$address[id].adr_id}'>{$address[id].adr_postcode} {$address[id].adr_address}, {$address[id].adr_city}, {$address[id].adr_country}</option>
						{/section}
					</select>
				</td>
			</tr>
			<tr>
				<td class='tbl' valign='top'>
				</td>
				<td class='tbl'>
					<input type='checkbox' name='save_mileage' class='textbox' style="margin:0px;" /> {$locale.eA_746}
				</td>
			</tr>
			<tr>
				<td class='tbl' valign='top'>
					{$locale.eA_761}:
				</td>
				<td class='tbl'>
					<input type='text' name='travel_fuel' id='travel_fuel' value='{$travel_fuel}' maxlength='6' class='textbox' style='width:100px;' />
					<select name='travel_fuel_type' class='textbox'>
						<option value='L'{if $travel_fuel_type ==  "L" } selected="selected"{/if}>{$locale.eA_673}</option>
						<option value='IG'{if $travel_fuel_type == "IG"} selected="selected"{/if}>{$locale.eA_674}</option>
						<option value='UG'{if $travel_fuel_type == "UG"} selected="selected"{/if}>{$locale.eA_675}</option>
					</select>
					<br />
					<span class='small'>{$locale.eA_762}</span>

				</td>
			</tr>
			<tr>
				<td class='tbl' valign='top'>
					{$locale.eA_838}:
				</td>
				<td class='tbl'>
					<textarea name='travel_details' id='travel_details' class='textbox' cols='60' rows='5' class='textbox' style='width:410px; height:{math equation='x/8' format="%u" x=$smarty.const.BROWSER_HEIGHT}px'>{$travel_details}</textarea>
				</td>
			</tr>
			<tr>
				<td align='left' colspan='2' class='tbl'>
					<hr />
					<span class='smallalt2'>{$locale.eA_730}</span>
					<br />
					<span class='small'>{$locale.eA_734}</span>
					<hr />
				</td>
			</tr>
			<tr>
				<td class='tbl' valign='top'>
					{$locale.eA_731}:
				</td>
				<td class='tbl'>
					<input type='text' name='travel_detour' id='travel_detour_mileage' value='{$travel_detour}' maxlength='5' class='textbox' style='width:100px;' /> {$car.mileage_unit}
				</td>
			</tr>
			<tr>
				<td class='tbl' valign='top'>
					{$locale.eA_732}:
				</td>
				<td class='tbl'>
					<select name='travel_detour_type' id='travel_detour_type' class='textbox'>
						{if $travel.adr_description != "" || $action == "edit"}
							<option value='B'{if $travel_detour_type == "B"} selected="selected"{/if}>{$locale.eA_726}</option>
						{/if}
						<option value='P'{if $travel_detour_type == "P"} selected="selected"{/if}>{$locale.eA_727}</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class='tbl' valign='top'>
					{$locale.eA_733}:
				</td>
				<td class='tbl'>
					<textarea name='travel_detour_reason' id='travel_detour_reason' class='textbox' cols='60' rows='5' class='textbox' style='width:410px; height:{math equation='x/8' format="%u" x=$smarty.const.BROWSER_HEIGHT}px'>{$travel_detour_reason}</textarea>
				</td>
			</tr>
			<tr>
				<td class='tbl' valign='top'>
				</td>
				<td class='tbl'>
					<input type='checkbox' name='save_detour' class='textbox' style="margin:0px;" /> {$locale.eA_748}
				</td>
			</tr>
			<tr>
				<td align='center' colspan='2' class='tbl'>
					<input type='hidden' name='travel_car_id' value='{$travel_car_id}' />
					{if $action == "add"}
						<input type='submit' name='save' value='{$locale.eA_735}' class='button' />
					{else}
						<input type='submit' name='save' value='{$locale.eA_736}' class='button' />
					{/if}
				</td>
			</tr>
		</table>
	</form>
	{include file="_closetable.tpl"}

<script type='text/javascript'>
	var MileageDistance = new Array();
	var MileageDetour = new Array();

	{section name=id loop=$distance}
MileageDistance['{$distance[id].distance_to}']={$distance[id].distance_mileage};
	{/section}

	{section name=id loop=$distance}
MileageDetour['{$distance[id].distance_to}']="{$distance[id].distance_detour_type}|{$distance[id].distance_detour}|{$distance[id].distance_detour_reason|replace:'"':'\"'}";
	{/section}
	{literal}
	function getMileage(selObj)
	{
		if (MileageDistance[selObj.options[selObj.selectedIndex].value]) {
			// check if the mileage field value is zero
			if (document.getElementById("travel_mileage").value == 0) {
				document.getElementById("travel_mileage").value = MileageDistance[selObj.options[selObj.selectedIndex].value];
			}
			// check if there was a default detour as well. If so, use it
			var detour = MileageDetour[selObj.options[selObj.selectedIndex].value].split("|");
			if (detour[0] != "") {
				document.getElementById("travel_detour_type").value = detour[0];
				document.getElementById("travel_detour_mileage").value = detour[1];
				document.getElementById("travel_detour_reason").value = detour[2];
			}
		}
	}
	function GoogleMaps() {
		// get the new address
		var addr = document.getElementById("new_postcode").value + ", " + document.getElementById("new_address").value + ", " + document.getElementById("new_city").value + ", " + document.getElementById("new_country").value;
		// if not entered
		if (addr.substring(0,6) == ", , , ") {
			// get the selected address
			var travel_to = document.getElementById("travel_to");
			var gm_travel_to = document.getElementById("gm_travel_to");
			addr = gm_travel_to.options[travel_to.selectedIndex].text;
		}
		// open google maps in a new window, and calculate the route based on the info entered
		window.open("http://maps.google.com/maps?saddr={/literal}{$travel.adr_address}, {$travel.adr_city}, {$travel.adr_country}{literal}&daddr="+addr, "googlemap", "status=0,toolbar=0,location=0,menubar=0,directories=0");
	}
	function GetDistance() {
		var sAddr = "{/literal}{$travel.adr_address}, {$travel.adr_city}, {$travel.adr_country}{literal}";
		var dAddr = document.getElementById("new_postcode").value + ", " + document.getElementById("new_address").value + ", " + document.getElementById("new_city").value + ", " + document.getElementById("new_country").value;
		// if not entered
		if (dAddr.substring(0,6) == ", , , ") {
			// get the selected address
			var travel_to = document.getElementById("travel_to");
			var gm_travel_to = document.getElementById("gm_travel_to");
			dAddr = gm_travel_to.options[travel_to.selectedIndex].text;
		}
		var dist = AjaxCall("{/literal}{$settings.siteurl}{literal}modules/mileage/getdistance.php?type="+"{/literal}{$car.car_mileage_unit}{literal}"+"&saddr=" + sAddr + "&daddr=" + dAddr);
		if (dist != null) {
			if (IsNumeric(dist)) {
				document.getElementById("travel_mileage").value = dist;
			} else {
				alert(dist);
			}
		} else {
			alert('distance calculated failed: unknown error');
		}
	}
</script>
	{/literal}
{elseif $action == "list"}
	{include file="_opentable.tpl" name=$_name title=$locale.eA_703|cat:"<b>"|cat:$car.car_registration|cat:" </b>("|cat:$car.car_description|cat:")" state=$_state style=$_style}
		{section name=id loop=$travel}
			{if $smarty.section.id.first}
			<table align='center' cellpadding='0' cellspacing='1' width='600' class='tbl-border'>
				<tr>
					<td colspan='2' align='center' width='1%' class='tbl2' style='white-space:nowrap'>
						<b>{$locale.eA_739}</b>
					</td>
					<td align='left'class='tbl2'>
						<b>{$locale.eA_728}</b>
					</td>
					<td align='right' width='1%' class='tbl2' style='white-space:nowrap'>
						<b>{$locale.eA_738}</b>
					</td>
					<td align='right' width='1%' class='tbl2' style='white-space:nowrap'>
						<b>{$locale.eA_726}</b>
					</td>
					<td align='right' width='1%' class='tbl2' style='white-space:nowrap'>
						<b>{$locale.eA_727}</b>
					</td>
					<td align='center' width='1%' class='tbl2' style='white-space:nowrap'>
						<b>{$locale.eA_604}</b>
					</td>
				</tr>
			{/if}
			<tr>
				<td align='right' width='1%' class='tbl1' style='white-space:nowrap'>
					{$travel[id].row}
				</td>
				<td align='center' width='1%' class='tbl1' style='white-space:nowrap'>
					{$travel[id].travel_date|date_format:"%Y-%m-%d %H:%M"}
				</td>
				<td align='left' class='tbl1'>
					{$travel[id].adr_description}
				</td>
				<td align='right' width='1%' class='tbl1' style='white-space:nowrap'>
					{if $travel[id].travel_fuel}
						<img src='images/pump.jpg' />
					{/if}
					{$travel[id].total} {$travel[id].mileage_unit}
				</td>
				<td align='right' width='1%' class='tbl1' style='white-space:nowrap'>
					{if ($travel[id].travel_id)}
						{$travel[id].b_total} {$travel[id].mileage_unit}
					{/if}
				</td>
				<td align='right' width='1%' class='tbl1' style='white-space:nowrap'>
					{if ($travel[id].travel_id)}
						{$travel[id].p_total} {$travel[id].mileage_unit}
					{/if}
				</td>
				<td align='left' width='1%' class='tbl1' style='white-space:nowrap'>
					{if ($travel[id].travel_id)}
						{imagelink link=$smarty.const.FUSION_SELF|cat:"?action=edit&amp;car_id="|cat:$travel[id].travel_car_id|cat:"&amp;travel_id="|cat:$travel[id].travel_id image="page_edit.gif" alt=$locale.eA_740 title=$locale.eA_740}
						&nbsp;
						{imagelink link=$smarty.const.FUSION_SELF|cat:"?action=delete&amp;car_id="|cat:$travel[id].travel_car_id|cat:"&amp;travel_id="|cat:$travel[id].travel_id image="page_delete.gif" alt=$locale.eA_741 title=$locale.eA_741 onclick="return DeleteTrip();"}
					{/if}
				</td>
			</tr>
			{if $smarty.section.id.last}
			</table>
			{/if}
		{sectionelse}
			<div style='text-align:center'>
				<br />
				{$locale.eA_711}
			</div>
		{/section}
		{if $rows > $settings.numofthreads}
			{makepagenav start=$rowstart count=$settings.numofthreads total=$rows range=3 link=$smarty.const.FUSION_SELF|cat:"?car_id="|cat:$car_id|cat:"&amp;action=list&amp;"}
		{/if}
		<div style='text-align:center'>
			<br />
			{buttonlink name=$locale.eA_712 link=$smarty.const.FUSION_SELF|cat:"?car_id="|cat:$car_id|cat:"&amp;action=add"}
			&nbsp;&nbsp;
			{buttonlink name=$locale.eA_700 link=$smarty.const.FUSION_SELF}
		</div>
	{include file="_closetable.tpl"}
	<script type='text/javascript'>
	function DeleteTrip() {ldelim}
		return confirm("{$locale.eA_742}");
	{rdelim}
	</script>
{elseif $action == "print"}
	{include file="_opentable.tpl" name=$_name title=$locale.eA_800|cat:"<b>"|cat:$car.car_registration|cat:" </b>("|cat:$car.car_description|cat:")" state=$_state style=$_style}
	<form name='layoutform' method='post' action='{$formaction}'>
		<table align='center' cellpadding='0' cellspacing='1' width='100%' class='tbl'>
			{if $users|@count < 1}
				<tr>
					<td align='right' class='tbl'>
						{$locale.eA_814}
					</td>
					<td align='left' class='tbl'>
						<select name='travel_driver_id' class='textbox' style='width:300px;'>
							{section name=id loop=$users}
								<option value='{$users[id].user_id}'{if $users[id].user_id == $travel_driver_id} selected="selected"{/if}>{$users[id].user_name} - {$users[id].user_fullname}</option>
							{/section}
						</select>
					</td>
				</tr>
			{/if}
			<tr>
				<td align='right' class='tbl'>
					{$locale.eA_801}
				</td>
				<td align='left' class='tbl'>
					{html_select_date prefix='start_' time=$range.start start_year=$range.year_start end_year=$range.year_end all_extra="class='textbox'"}
					&nbsp;{$locale.eA_626|lower}&nbsp;
					{html_select_date prefix='end_' time=$range.end start_year=$range.year_start end_year=$range.year_end all_extra="class='textbox'"}

				</td>
			</tr>
			<tr>
				<td align='right' class='tbl'>
					{$locale.eA_817}
				</td>
				<td align='left' class='tbl'>
					<select name='report_option' class='textbox' style='width:300px;'>
						<option value='0'>{$locale.eA_818}</option>
						<option value='1'>{$locale.eA_819}</option>
						<option value='2'>{$locale.eA_820}</option>
						<option value='3'>{$locale.eA_826}</option>
						<option value='4'>{$locale.eA_827}</option>
					</select>
				</td>
			</tr>
			<tr>
				<td align='center' colspan='2' class='tbl'>
					{if $users|@count == 1}
						<input type='hidden' name='travel_driver_id' value='{$users.0.user_id}' />
					{/if}
					<input type='submit' name='print' value='{$locale.eA_743}' class='button' />
				</td>
			</tr>
		</table>
	</form>
	{include file="_closetable.tpl"}
{else}
	{include file="_opentable.tpl" name=$_name title=$locale.eA_700 state=$_state style=$_style}
		{section name=id loop=$cars}
			{if $smarty.section.id.first}
			<table align='center' cellpadding='0' cellspacing='1' width='600' class='tbl-border'>
				<tr>
					<td align='center' width='1%' class='tbl2' style='white-space:nowrap'>
						<b>{$locale.eA_601}</b>
					</td>
					<td align='center' width='1%' class='tbl2' style='white-space:nowrap'>
						<b>{$locale.eA_602}</b>
					</td>
					<td align='center' width='1%' class='tbl2' style='white-space:nowrap'>
						<b>{$locale.eA_603}</b>
					</td>
					<td align='center' width='1%' class='tbl2' style='white-space:nowrap'>
						<b>{$locale.eA_604}</b>
					</td>
				</tr>
			{/if}
			<tr>
				<td align='center' width='1%' class='tbl2' style='white-space:nowrap'>
					{$cars[id].car_registration}
				</td>
				<td align='center' width='1%' class='tbl2' style='white-space:nowrap'>
					{$cars[id].car_description}
				</td>
				<td align='center' class='tbl2'>
					{section name=dr loop=$cars[id].drivers}
						{$cars[id].drivers[dr].user_fullname}<br />
					{sectionelse}
						{$locale.eA_610}
					{/section}
				</td>
				<td align='center' width='1%' class='tbl2' style='white-space:nowrap'>
					{if $cars[id].car_end_date == 0 || $cars[id].car_end_date > $smarty.now}
						{buttonlink name=$locale.eA_702 link=$smarty.const.FUSION_SELF|cat:"?car_id="|cat:$cars[id].car_id|cat:"&amp;action=list"}
						&nbsp;
					{/if}
					{buttonlink name=$locale.eA_743 link=$smarty.const.FUSION_SELF|cat:"?car_id="|cat:$cars[id].car_id|cat:"&amp;action=print"}
				</td>
			</tr>
			{if $smarty.section.id.last}
			</table>
			{/if}
		{sectionelse}
			<div style='text-align:center'>
				<br />
				{$locale.eA_701}
				<br />
				<br />
			</div>
		{/section}
		{if $rows > $settings.numofthreads}
			{makepagenav start=$rowstart count=$settings.numofthreads total=$rows range=3 link=$smarty.const.FUSION_SELF|cat:$aidlink|cat:"&amp;"}
		{/if}
	{include file="_closetable.tpl"}
{/if}
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}
