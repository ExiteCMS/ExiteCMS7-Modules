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
{* $Id:: main.print.tpl 1935 2008-10-29 23:42:42Z WanWizard               $*}
{*-------------------------------------------------------------------------*}
{* Last modified by $Author:: WanWizard                                   $*}
{* Revision number $Rev:: 1935                                            $*}
{***************************************************************************}
{*                                                                         *}
{* Template for the mileage module 'print' function, fuel consumption      *}
{*                                                                         *}
{***************************************************************************}
{literal}<style type="text/css">
body 		{ font-family:Verdana,Tahoma,Arial,Sans-Serif;font-size:10pt; }
hr 			{ height:1px;color:#ccc; }
td			{ }
tr			{ margin: 0px;}
.small 		{ font-family:Verdana,Tahoma,Arial,Sans-Serif;font-size:8pt; }
.small2 	{ font-family:Verdana,Tahoma,Arial,Sans-Serif;font-size:8pt;color:#666; }
.tbl		{ border-bottom:1px solid #666; border-left:1px solid #666; }
.tblhdr		{ border:1px solid #666; border-bottom:0px; border-left:0px; background-color:#ccc; font-size:9pt;}
.tbl1		{ border:1px solid #666; border-bottom:0px; border-left:0px; background-color:#eee; font-size:8pt;}
.tbl2		{ border:1px solid #666; border-bottom:0px; border-left:0px; background-color:#fff; font-size:8pt;}
.notop		{ border-top:0px}
.dashtop	{ border-top:1px dotted #999;}
</style>{/literal}

<table width='900px' cellpadding='0' cellspacing='1' style='line-height:200%;'>
	<tr>
		<td align='left' colspan='2' style='border-bottom:1px solid #666;'>
			{$locale.eA_802} <b>{$car.car_registration}</b> ({$car.car_description})
		</td>
	</tr>
	<tr>
		<td align='left'>
			{$locale.eA_603}: <b>{$car.user_fullname}</b>
		</td>
		<td align='right'>
			{$locale.eA_803}: <b>
			{if $period_start lt $car.car_start_date}
				{$car.car_start_date|date_format:"%x"}
			{else}
				{$period_start|date_format:"%x"}
			{/if}
			&hellip; {$period_end|date_format:"%x"}</b>
		</td>
	</tr>
</table>
<br />
<table width='900px' class='tbl' cellpadding='5' cellspacing='0'>
	{section name=id loop=$trips}
		{if $smarty.section.id.first}
			<tr>
				<td class='tblhdr' width='1%' align='center' style='white-space:nowrap' colspan="2">
					<b>{$locale.eA_816}</b>
				</td>
				<td class='tblhdr' width='1%' align='center' style='white-space:nowrap'>
					<b>{$locale.eA_806}</b>
				</td>
				<td class='tblhdr' align='left'>
					<b>{$locale.eA_826}</b>
				</td>
				<td class='tblhdr' width='1%' align='center' style='white-space:nowrap'>
					<b>{$locale.eA_811}</b>
				</td>
			</tr>
		{/if}

		{if $trips[id].detour.reason == ""}
			{assign var=rowspan value="2"}
		{else}
			{assign var=rowspan value="3"}
		{/if}
		{if $trips[id].fuel.fuel.fuel|default:0 > 0}
			{assign var=rowspan value=`$rowspan+1`}
			<tr>
				<td rowspan='{$rowspan}' class='{cycle values="tbl1,tbl2" advance=no}' align='right' style="border-right:1px dotted;">
					{$smarty.section.id.rownum}
				</td>
				<td rowspan='{$rowspan}' class='{cycle values="tbl1,tbl2" advance=no}' align='right'>
					{$trips[id].trip.count}
				</td>
				<td rowspan='{$rowspan}' class='{cycle values="tbl1,tbl2" advance=no}' width='1%' align='center' style='white-space:nowrap'>
					{$trips[id].trip.date|date_format:"%x"}
				</td>
				<td class='{cycle values="tbl1,tbl2" advance=no}' align='left'>
					{if $trips[id].trip.type == "P"}
						{$locale.eA_812}
					{else}
						{$locale.eA_807}: {$trips[id].from.description} - {$trips[id].from.address}, {$trips[id].from.postcode} {$trips[id].from.city} ({$trips[id].from.countrycode|upper})
					{/if}
				</td>
				<td rowspan='{$rowspan}' class='{cycle values="tbl1,tbl2" advance=no}' align='right' style='white-space:nowrap'>
					{ssprintf format=$locale.eA_840 var1=$trips[id].fuel.end.from-$trips[id].fuel.start.to var2=$trips[id].fuel.end.to-$trips[id].fuel.start.from}{$mileage_unit}
				</td>
			</tr>

			<tr>
				<td class='{cycle values="tbl1,tbl2" advance=no} notop' align='left'>
					{if $trips[id].trip.type == "B"}
						{$locale.eA_808}: {$trips[id].to.description} - {$trips[id].to.address}, {$trips[id].to.postcode} {$trips[id].to.city} ({$trips[id].to.countrycode|upper})
					{/if}
				</td>
			</tr>

			{if $trips[id].detour.reason != ""}
				<tr>
					<td class='{cycle values="tbl1,tbl2" advance=no} dashtop' align='left'>
						{if $trips[id].detour.mileage != 0}
							{$locale.eA_731}:
							{ssprintf format=$format var1=$trips[id].detour.mileage}{$mileage_unit} ({if $trips[id].detour.type == "B"}{$locale.eA_726}{else}{$locale.eA_727}{/if})
						{/if}
						{$trips[id].detour.reason}
					<td>
				</tr>
			{/if}

			{if $trips[id].fuel.fuel.fuel|default:0 > 0}
				<tr>
					<td class='{cycle values="tbl1,tbl2" advance=no} dashtop' align='left'>
						{$locale.eA_761}:
						{ssprintf format="%1.2f" var1=$trips[id].fuel.fuel.fuel} {$fuel_desc}
						{if $trips[id].fuel.fuel.range > 0}
							- {ssprintf format=$locale.eA_823 var1=$trips[id].fuel.fuel.range_min var2=$trips[id].fuel.fuel.range_max} {$fuelconv_desc}
						{/if}
					</td>
				</tr>
			{/if}

			{cycle values="tbl1,tbl2" assign=dummy}

		{/if}

		{if $smarty.section.id.last}
			</table>
			<br />
			<table width='900px'>
				<tr>
					<td colspan='5' align='center'>
						<b>{$locale.eA_824} {ssprintf format=$locale.eA_823 var1=$totals.range_min var2=$totals.range_max} {$fuelconv_desc}</b>
						<br />
						{$locale.eA_825}
						<br /><br />
					</td>
				</tr>
				<tr style='font-size:85%;'>
					<td align='center'>
						{$locale.eA_809}: <b>{ssprintf format=$format var1=$totals.offset}{$mileage_unit}</b>.
					</td>
					<td align='center'>
						{$locale.eA_810}: <b>{ssprintf format=$format var1=$totals.offset+$totals.mileage}{$mileage_unit}</b>.
					</td>
					<td align='center'>
						{$locale.eA_811}: <b>{ssprintf format=$format var1=$totals.mileage}{$mileage_unit}</b>.
					</td>
					<td align='center'>
						{$locale.eA_812}: <b>{ssprintf format=$format var1=$totals.personal}{$mileage_unit}</b>.
					</td>
					<td align='center'>
						{$locale.eA_761}: <b>{ssprintf format=$format var1=$totals.fuel} {$fuel_desc}</b>.
					</td>
				</tr>
				<tr>
					<td align='center' colspan='5' style='font-size:75%; font-style:italic;'>
						{$locale.eA_815}
					</td>
				</tr>
			</table>
		{/if}

	{sectionelse}
		<div style="text-align:center;margin:20px 0px;">
			{$locale.eA_711}
		</div>
	{/section}
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}
