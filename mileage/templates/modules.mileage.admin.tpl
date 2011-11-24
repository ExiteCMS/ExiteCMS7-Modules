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
{* Template for the admin panel of the 'mileage' module                    *}
{*                                                                         *}
{***************************************************************************}
{if $action == "edit" || $action == "add"}
	{if $action == "edit"}
		{include file="_opentable.tpl" name=$_name title=$locale.eA_671 state=$_state style=$_style}
	{elseif $action == "add"}
		{include file="_opentable.tpl" name=$_name title=$locale.eA_650 state=$_state style=$_style}
	{/if}
	<form name='layoutform' method='post' action='{$formaction}'>
		<table width='100%' align='center' cellpadding='0' cellspacing='0'>
			<tr>
				<td class='tbl' valign='top'>
					{$locale.eA_601}:
				</td>
				<td class='tbl'>
					<input type='text' name='car_registration' value='{$car_registration}' maxlength='15' class='textbox' style='width:200px;' />
				</td>
			</tr>
			<tr>
				<td class='tbl' valign='top'>
					{$locale.eA_602}:
				</td>
				<td class='tbl'>
					<input type='text' name='car_description' value='{$car_description}' maxlength='50' class='textbox' style='width:350px;' />
				</td>
			</tr>
			<tr>
				<td class='tbl' valign='top'>
					{$locale.eA_667}:
				</td>
				<td class='tbl'>
					{html_select_date prefix='start_' time=$car_start_date start_year="-1" end_year="+1" all_extra="class='textbox'"}
				</td>
			</tr>
			<tr>
				<td class='tbl' valign='top'>
					{$locale.eA_658}:
				</td>
				<td class='tbl'>
					<select name='car_start_from' class='textbox' style='width:100%;'>
						<option value='0'>&nbsp;</option>
						{section name=id loop=$address}
							<option value='{$address[id].adr_id}'{if $address[id].adr_id == $car_start_from} selected="selected"{/if}>{$address[id].adr_description} » {$address[id].adr_city} ({$address[id].adr_type_desc})</option>
						{/section}
					</select>
					<fieldset style="margin-top:5px;">
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
									<input type='text' name='new_address' value='{$new_address}' maxlength='50' class='textbox' style='width:300px;' />
								</td>
							</tr>
							<tr>
								<td class='tbl'>
									{$locale.eA_662}:
								</td>
								<td class='tbl'>
									<input type='text' name='new_postcode' value='{$new_postcode}' maxlength='15' class='textbox' style='width:150px;' />
								</td>
							</tr>
							<tr>
								<td class='tbl'>
									{$locale.eA_663}:
								</td>
								<td class='tbl'>
									<input type='text' name='new_city' value='{$new_city}' maxlength='50' class='textbox' style='width:300px;' />
								</td>
							</tr>
							<tr>
								<td class='tbl'>
									{$locale.eA_664}:
								</td>
								<td class='tbl'>
									<select name='new_country' class='textbox' style='width:225px;'>
									{section name=cc loop=$countries}
									<option value='{$countries[cc].locales_key}'{if $countries[cc].locales_key == $new_country} selected="selected"{/if}>{$countries[cc].locales_value}</option>
									{/section}
									</select>
								</td>
							</tr>
						</table>
					</fieldset>
				</td>
			</tr>
			<tr>
				<td class='tbl' valign='top'>
					{$locale.eA_651}:
				</td>
				<td class='tbl'>
					<input type='text' name='car_mileage' value='{$car_mileage}' maxlength='5' class='textbox' style='width:100px;' />
				</td>
			</tr>
			<tr>
				<td class='tbl' valign='top'>
					{$locale.eA_652}:
				</td>
				<td class='tbl'>
					<select name='car_mileage_unit' class='textbox'>
						<option value='K'{if $car_mileage_unit == "K"} selected="selected"{/if}>{$locale.eA_653}</option>
						<option value='M'{if $car_mileage_unit == "M"} selected="selected"{/if}>{$locale.eA_654}</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class='tbl' valign='top'>
					{$locale.eA_672}:
				</td>
				<td class='tbl'>
					<input type='text' name='car_fuel' value='{$car_fuel}' maxlength='5' class='textbox' style='width:100px;' />
					<select name='car_fuel_type' class='textbox'>
						<option value='L'{if $car_fuel_type ==  "L" } selected="selected"{/if}>{$locale.eA_673}</option>
						<option value='IG'{if $car_fuel_type == "IG"} selected="selected"{/if}>{$locale.eA_674}</option>
						<option value='UG'{if $car_fuel_type == "UG"} selected="selected"{/if}>{$locale.eA_675}</option>
					</select>
				</td>
			</tr>
			{if $action == "edit"}
				<tr>
					<td class='tbl' valign='top'>
						{$locale.eA_668}:
					</td>
					<td class='tbl'>
						{html_select_date prefix='end_' time=$car_end_date allow_zero=!$car_end_date start_year="-1" end_year="+1" year_empty="--" month_empty="--" day_empty="--" all_extra="class='textbox'"}
					</td>
				</tr>
			{/if}
			<tr>
				<td class='tbl' valign='top'>
					{$locale.eA_655}:
				</td>
				<td class='tbl'>
					<select name='car_report_type' class='textbox'>
						<option value='0'{if $car_report_type == 0} selected="selected"{/if}>{$locale.eA_656}</option>
					</select>
				</td>
			</tr>
			<tr>
				<td align='center' colspan='2' class='tbl'>
					<input type='hidden' name='car_id' value='{$car_id}' />
					<input type='submit' name='save' value='{$locale.eA_657}' class='button' />
				</td>
			</tr>
		</table>
	</form>
	{include file="_closetable.tpl"}
{elseif $action == "drivers" || $action == "editdriver"}
	{if $task == "edit"}
		{include file="_opentable.tpl" name=$_name title=$locale.eA_621|cat:" <b>"|cat:$car.car_registration|cat:" </b>("|cat:$car.car_description|cat:")" state=$_state style=$_style}
	{else}
		{include file="_opentable.tpl" name=$_name title=$locale.eA_620|cat:" <b>"|cat:$car.car_registration|cat:" </b>("|cat:$car.car_description|cat:")" state=$_state style=$_style}
	{/if}
	<form name='layoutform' method='post' action='{$formaction}'>
		<table width='600' align='center' cellpadding='0' cellspacing='0'>
			<tr>
				<td class='tbl' valign='top'>
					{$locale.eA_624}:
				</td>
				<td class='tbl'>
					{if $task == "edit"}
						<b>{$users.0.user_name} ({$users.0.user_fullname})</b>
						<input type='hidden' name='driver_user_id' value='{$driver_user_id}' />
					{else}
						<select name='driver_user_id' class='textbox' style='width:100%;'>
							{section name=id loop=$users}
								<option value='{$users[id].user_id}'{if $users[id].user_id == $driver_user_id} selected="selected"{/if}>{$users[id].user_name} ({$users[id].user_fullname})</option>
							{/section}
						</select>
					{/if}
				</td>
			</tr>
			<tr>
				<td class='tbl' valign='top'>
					{$locale.eA_830}:
				</td>
				<td class='tbl'>
					<input type='text' name='driver_ssn' value='{$driver_ssn}' style='width:250px;' />
				</td>
			</tr>
			<tr>
				<td class='tbl' valign='top'>
					{$locale.eA_625}:
				</td>
				<td class='tbl'>
					{html_select_date prefix='start_' time=$driver_start_date start_year="-1" end_year="+1" all_extra="class='textbox'"}
				</td>
			</tr>
			<tr>
				<td class='tbl' valign='top'>
					{$locale.eA_626}:
				</td>
				<td class='tbl'>
					{html_select_date prefix='end_' time=$driver_end_date allow_zero=!$driver_end_date start_year="-1" end_year="+10" year_empty="--" month_empty="--" day_empty="--" all_extra="class='textbox'"}
				</td>
			</tr>
			<tr>
				<td class='tbl' valign='top'>
					{$locale.eA_655}:
				</td>
				<td class='tbl'>
					<select name='driver_mileage_unit' class='textbox'>
						<option value='K'{if $driver_mileage_unit == "K"} selected="selected"{/if}>{$locale.eA_653}</option>
						<option value='M'{if $driver_mileage_unit == "M"} selected="selected"{/if}>{$locale.eA_654}</option>
					</select>
				</td>
			</tr>
			<tr>
				<td align='center' colspan='2' class='tbl'>
					<input type='hidden' name='car_id' value='{$car_id}' />
					{if $task == "edit"}
						<input type='submit' name='save' value='{$locale.eA_612}' class='button' />
					{else}
						<input type='submit' name='save' value='{$locale.eA_631}' class='button' />
					{/if}
				</td>
			</tr>
		</table>
	</form>
	{include file="_closetable.tpl"}
	{if $task == ""}
		{include file="_opentable.tpl" name=$_name title=$locale.eA_622|cat:" <b>"|cat:$car.car_registration|cat:" </b>("|cat:$car.car_description|cat:")" state=$_state style=$_style}
			{section name=id loop=$drivers}
				{if $smarty.section.id.first}
				<table align='center' cellpadding='0' cellspacing='1' width='600' class='tbl-border'>
					<tr>
						<td align='center' width='1%' class='tbl2' style='white-space:nowrap'>
							<b>{$locale.eA_624}</b>
						</td>
						<td align='center' width='1%' class='tbl2' style='white-space:nowrap'>
							<b>{$locale.eA_625}</b>
						</td>
						<td align='center' width='1%' class='tbl2' style='white-space:nowrap'>
							<b>{$locale.eA_626}</b>
						</td>
						<td align='center' width='1%' class='tbl2' style='white-space:nowrap'>
							<b>{$locale.eA_604}</b>
						</td>
					</tr>
				{/if}
				<tr>
					<td align='center' class='tbl1'>
						{$drivers[id].user_fullname}
					</td>
					<td align='center' width='1%' class='tbl1' style='white-space:nowrap'>
						{$drivers[id].driver_start_date|date_format:"%x"}
					</td>
					<td align='center' width='1%' class='tbl1' style='white-space:nowrap'>
						{if $drivers[id].driver_end_date == 0}
							<b>{$locale.eA_627}</b>
						{else}
							{$drivers[id].driver_end_date|date_format:"%x"}
						{/if}
					</td>
					<td align='center' width='1%' class='tbl1' style='white-space:nowrap'>
						{imagelink link=$smarty.const.FUSION_SELF|cat:$aidlink|cat:"&amp;action=drivers&amp;task=edit&amp;car_id="|cat:$car.car_id|cat:"&amp;driver_id="|cat:$drivers[id].driver_user_id image="page_edit.gif" alt=$locale.eA_628 title=$locale.eA_628}
						&nbsp;
						{imagelink link=$smarty.const.FUSION_SELF|cat:$aidlink|cat:"&amp;action=drivers&amp;task=delete&amp;car_id="|cat:$car.car_id|cat:"&amp;driver_id="|cat:$drivers[id].driver_user_id image="page_delete.gif" alt=$locale.eA_629 title=$locale.eA_629 onclick="return DeleteDriver();"}
					</td>
				</tr>
				{if $smarty.section.id.last}
				</table>
				{/if}
			{sectionelse}
				<div style='text-align:center'>
					<br />
					{$locale.eA_623}
					<br /><br />
				</div>
			{/section}
			{if $rows > $settings.numofthreads}
				{makepagenav start=$rowstart count=$settings.numofthreads total=$rows range=3 link=$smarty.const.FUSION_SELF|cat:$aidlink|cat:"&amp;action=drivers&amp;"}
			{/if}
		{include file="_closetable.tpl"}
		<script type='text/javascript'>
		function DeleteDriver() {ldelim}
			return confirm("{$locale.eA_630}");
		{rdelim}
		</script>
	{/if}
{else}
	{include file="_opentable.tpl" name=$_name title=$locale.eA_600 state=$_state style=$_style}
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
					{if $cars[id].car_end_date}
						<b>{$locale.eA_611}</b>
					{else}
						{buttonlink name=$locale.eA_612 link=$smarty.const.FUSION_SELF|cat:$aidlink|cat:"&amp;action=drivers&amp;car_id="|cat:$cars[id].car_id}
					{/if}
				</td>
				<td align='center' width='1%' class='tbl2' style='white-space:nowrap'>
					{imagelink link=$smarty.const.FUSION_SELF|cat:$aidlink|cat:"&amp;action=edit&amp;car_id="|cat:$cars[id].car_id image="page_edit.gif" alt=$locale.eA_608 title=$locale.eA_608}
					&nbsp;
					{imagelink link=$smarty.const.FUSION_SELF|cat:$aidlink|cat:"&amp;action=delete&amp;car_id="|cat:$cars[id].car_id image="page_delete.gif" alt=$locale.eA_609 title=$locale.eA_609 onclick="return DeleteCar();"}
				</td>
			</tr>
			{if $smarty.section.id.last}
			</table>
			{/if}
		{sectionelse}
			<div style='text-align:center'>
				<br />
				{$locale.eA_605}
			</div>
		{/section}
		{if $rows > $settings.numofthreads}
			{makepagenav start=$rowstart count=$settings.numofthreads total=$rows range=3 link=$smarty.const.FUSION_SELF|cat:$aidlink|cat:"&amp;"}
		{/if}
		<div style='text-align:center'>
			<br />
			{buttonlink name=$locale.eA_606 link=$smarty.const.FUSION_SELF|cat:$aidlink|cat:"&amp;action=add"}
		</div>
	{include file="_closetable.tpl"}
	<script type='text/javascript'>
	function DeleteCar() {ldelim}
		return confirm("{$locale.eA_607}");
	{rdelim}
	</script>
{/if}
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}
