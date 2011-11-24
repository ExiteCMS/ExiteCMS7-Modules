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
{* Template for the mileage module 'print' function, dutch tax report      *}
{*                                                                         *}
{***************************************************************************}
{literal}<style type="text/css">
body 		{ font-family:Verdana,Tahoma,Arial,Sans-Serif;font-size:10pt; }
</style>{/literal}

<div style='font-size:125%;margin-bottom:20px;'>
	{$locale.eA_802} {$locale.eA_603|lower}: <b>{$car.user_fullname}</b>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	{$locale.eA_830}: <b>{$car.driver_ssn}</b>
</div>
<table cellpadding='5' cellspacing='0' border='1'>
	<tr>
		<td width='400' align='left'>
			<b>{$locale.eA_602}</b>
		</td>
		<td width='100' align='center'>
			<b>{$locale.eA_601}</b>
		</td>
		<td width='200' align='center'>
			<b>{$locale.eA_828}</b>
		</td>
		<td width='200' align='center'>
			<b>{$locale.eA_829}</b>
		</td>
	</tr>
	<tr>
		<td align='left'>
			{$car.car_description}
		</td>
		<td width='100' align='center'>
			{$car.car_registration}
		</td>
		<td width='200' align='center'>
			{if $period_start lt $car.car_start_date}
				{$car.car_start_date|date_format:"%x"}
			{else}
				{$period_start|date_format:"%x"}
			{/if}
		</td>
		<td width='200' align='center'>
			{$period_end|date_format:"%x"}
		</td>
	</tr>
</table>
<br />
<table width='100%' cellpadding='2' cellspacing='0' border='1'>
	{section name=id loop=$trips}
		{if $smarty.section.id.first}
			<tr>
				<td align='center' colspan='2'>
					<b>{$locale.eA_816}</b>
				</td>
				<td align='center'>
					<b>{$locale.eA_806}</b>
				</td>
				<td align='center'>
					<b>{$locale.eA_831}</b>
				</td>
				<td align='center'>
					<b>{$locale.eA_832}</b>
				</td>
				<td align='center'>
					<b>{$locale.eA_833}</b>
				</td>
				<td align='center'>
					<b>{$locale.eA_834}</b>
				</td>
				<td align='center'>
					<b>{$locale.eA_835}</b>
				</td>
				<td align='center'>
					<b>{$locale.eA_836}</b>
				</td>
				<td width='80' align='center'>
					<b>{$locale.eA_837}</b>
				</td>
				<td align='center'>
					<b>{$locale.eA_838}</b>
				</td>
			</tr>
		{/if}

		<tr>
			<td align='center' style="border-right:1px dotted;">
				{$smarty.section.id.rownum}
			</td>
			<td align='center' style="border-left:0px;font-size:80%;">
				({$trips[id].trip.count})
			</td>
			<td align='center'>
				{$trips[id].trip.date|date_format:"%x"}
			</td>
			<td align='center'>
				{ssprintf format=$format var1=$trips[id].from.mileage}{$mileage_unit}
			</td>
			<td align='center'>
				{ssprintf format=$format var1=$trips[id].to.mileage}{$mileage_unit}
			</td>
			<td align='center'>
				{ssprintf format=$format var1=$trips[id].trip.business+$trips[id].trip.personal}{$mileage_unit}
			</td>
			<td align='left' style='white-space:nowrap;'>
				{$trips[id].from.address}<br />
				{$trips[id].from.postcode} {$trips[id].from.city}, {$trips[id].from.countrycode|upper}
			</td>
			<td align='left' style='white-space:nowrap;'>
				{$trips[id].to.address}<br />
				{$trips[id].to.postcode} {$trips[id].to.city}, {$trips[id].to.countrycode|upper}
			</td>
			<td align='left'>
				{$trips[id].detour.reason}
			</td>
				<td align='left'>
				{if $trips[id].trip.type == "B"}
					{$locale.eA_726}
					{if $trips[id].detour.reason != ""}
						{if $trips[id].detour.type == "P"}
							{$locale.eA_839} {$locale.eA_727}
						{/if}
					{/if}
				{elseif $trips[id].trip.type == "P"}
					{$locale.eA_727}
					{if $trips[id].detour.reason != ""}
						{if $trips[id].detour.type == "B"}
							{$locale.eA_839} {$locale.eA_726}
						{/if}
					{/if}
				{/if}
			</td>
			<td align='left'>
				{if $trips[id].detour.mileage}
					{$locale.eA_731}:
					{$trips[id].detour.mileage}{$mileage_unit}
					{if $trips[id].detour.reason != ""}
						{if $trips[id].detour.type == "B"}
							{$locale.eA_726}
						{elseif $trips[id].detour.type == "P"}
							{$locale.eA_727}
						{/if}
					{/if}
					<br />
				{/if}
				{$trips[id].trip.details}
			</td>
		</tr>

		{if $smarty.section.id.last}
			</table>
			<div style='font-size:125%;margin-top:20px;'>
				<table width='100%'>
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
							{if $report_option == 1 || $report_option == 2 || $report_option == 3}
								{$locale.eA_761}: <b>{ssprintf format=$format var1=$totals.fuel} {$fuel_desc}</b>.
							{/if}
						</td>
					</tr>
					<tr>
						<td align='center' colspan='5' style='font-size:75%; font-style:italic;padding-top:10px;'>
							{$locale.eA_815}
						</td>
					</tr>
				</table>
			</div>
		{/if}

	{sectionelse}
		<div style="text-align:center;margin:20px 0px;">
			{$locale.eA_711}
		</div>
	{/section}
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}
