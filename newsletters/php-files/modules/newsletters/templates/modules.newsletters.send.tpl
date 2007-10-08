{***************************************************************************}
{*                                                                         *}
{* PLi-Fusion CMS template: modules.newsletters.send.tpl                   *}
{*                                                                         *}
{***************************************************************************}
{*                                                                         *}
{* Author: WanWizard <wanwizard@gmail.com>                                 *}
{*                                                                         *}
{* Revision History:                                                       *}
{* 2007-09-04 - WW - Initial version                                       *}
{*                                                                         *}
{***************************************************************************}
{*                                                                         *}
{* Template for the admin installable module 'newsletters', send panel     *}
{*                                                                         *}
{***************************************************************************}
{include file="_opentable.tpl" name=$_name title=$locale.nl412 state=$_state style=$_style}
<form name='selectform' method='post' action='{$smarty.const.FUSION_SELF}{$aidlink}'>
	<table align='center' width='600' cellspacing='1' cellpadding='0' class='tbl-border'>
		<tr>
			<td align='center' colspan='2' class='tbl2' style='white-space:nowrap'>
				{$locale.nl461}
				<br />
			</td>
		</tr>
		<tr>
			<td align='left' width='1%' class='tbl1' style='white-space:nowrap'>
				{$locale.nl477}
			</td>
			<td align='left' class='tbl1' style='white-space:nowrap'>
				<select name='send_to_myself' class='textbox'>
					<option value='0' selected="selected">{$locale.nl472}</option>
					<option value='1'>{$locale.nl473}</option>
				</select>
				<span class='small'>{$locale.nl478}</span>
			</td>
		</tr>
		<tr>
			<td align='center' colspan='2' class='tbl2' style='white-space:nowrap'>
				{$locale.nl469}
			</td>
		</tr>
		<tr>
			<td align='left' width='1%' class='tbl1' style='white-space:nowrap'>
				{$locale.nl475}
			</td>
			<td align='left' class='tbl1' style='white-space:nowrap'>
				<input type='text' name='users' value='' maxlength='255' class='textbox' style='width:400px;' />
				<br />
				<span class='small'>{$locale.nl476}</span>
			</td>
		</tr>
		<tr>
			<td align='center' colspan='2' class='tbl2' style='white-space:nowrap'>
				{$locale.nl469}
			</td>
		</tr>
		<tr>
			<td align='left' width='1%' class='tbl1' style='white-space:nowrap'>
				{$locale.nl466}
			</td>
			<td align='left' class='tbl1' style='white-space:nowrap'>
				<select name='send_to_all' class='textbox'>
					<option value='0' selected="selected">{$locale.nl472}</option>
					<option value='1'>{$locale.nl473}</option>
				</select>
				<span class='small'>{$locale.nl471}</span>
			</td>
		</tr>
		<tr>
			<td align='center' colspan='2' class='tbl2' style='white-space:nowrap'>
				{$locale.nl469}
			</td>
		</tr>
		<tr>
			<td align='left' width='1%' class='tbl1' style='white-space:nowrap'>
				{$locale.nl462}
			</td>
			<td align='left' class='tbl1' style='white-space:nowrap'>
				<select name='date_lb[mday]' class='textbox'>
					<option>--</option>
					{section name=day start=1 loop=32}
						<option>{$smarty.section.day.index}</option>
					{/section}
				</select>
				<select name='date_lb[mon]' class='textbox'>
					<option>--</option>
					{section name=month start=1 loop=13}
						<option>{$smarty.section.month.index}</option>
					{/section}
				</select>
				<select name='date_lb[year]' class='textbox'>
					<option>--</option>
					{assign var='year' value=$smarty.now|date_format:"%Y"}
					{section name=year start=2000 loop=$year+2}
						<option>{$smarty.section.year.index}</option>
					{/section}
				</select>
				<select name='date_lb[hours]' class='textbox'>
					<option>--</option>
					{section name=hours start=1 loop=25}
						<option>{$smarty.section.hours.index}</option>
					{/section}
				</select>
				<select name='date_lb[minutes]' class='textbox'>
					<option>--</option>
					{section name=minutes start=0 loop=61}
						<option>{$smarty.section.minutes.index}</option>
					{/section}
				</select> : 00 <span class='small'>{$locale.nl470}</span>
			</td>
		</tr>
		<tr>
			<td align='left' width='1%' class='tbl1' style='white-space:nowrap'>
				{$locale.nl463}
			</td>
			<td align='left' class='tbl1' style='white-space:nowrap'>
				<select name='date_la[mday]' class='textbox'>
					<option>--</option>
					{section name=day start=1 loop=32}
						<option>{$smarty.section.day.index}</option>
					{/section}
				</select>
				<select name='date_la[mon]' class='textbox'>
					<option>--</option>
					{section name=month start=1 loop=13}
						<option>{$smarty.section.month.index}</option>
					{/section}
				</select>
				<select name='date_la[year]' class='textbox'>
					<option>--</option>
					{assign var='year' value=$smarty.now|date_format:"%Y"}
					{section name=year start=2000 loop=$year+2}
						<option>{$smarty.section.year.index}</option>
					{/section}
				</select>
				<select name='date_la[hours]' class='textbox'>
					<option>--</option>
					{section name=hours start=1 loop=25}
						<option>{$smarty.section.hours.index}</option>
					{/section}
				</select>
				<select name='date_la[minutes]' class='textbox'>
					<option>--</option>
					{section name=minutes start=0 loop=61}
						<option>{$smarty.section.minutes.index}</option>
					{/section}
				</select> : 00 <span class='small'>{$locale.nl470}</span>
			</td>
		</tr>
		<tr>
			<td align='left' width='1%' class='tbl1' style='white-space:nowrap'>
				{$locale.nl464}
			</td>
			<td align='left' class='tbl1' style='white-space:nowrap'>
				<input type='text' name='days_mt' value='' maxlength='8' class='textbox' style='width:50px;' />
				<span class='small'>{$locale.nl470}</span>
			</td>
		</tr>
		<tr>
			<td align='left' width='1%' class='tbl1' style='white-space:nowrap'>
				{$locale.nl465}
			</td>
			<td align='left' class='tbl1' style='white-space:nowrap'>
				<input type='text' name='days_lt' value='' maxlength='8' class='textbox' style='width:50px;' />
				<span class='small'>{$locale.nl470}</span>
			</td>
		</tr>
		<tr>
			<td align='left' width='1%' class='tbl1' style='white-space:nowrap'>
				{$locale.nl467}
			</td>
			<td align='left' class='tbl1' style='white-space:nowrap'>
				<select name='date_rb[mday]' class='textbox'>
					<option>--</option>
					{section name=day start=1 loop=32}
						<option>{$smarty.section.day.index}</option>
					{/section}
				</select>
				<select name='date_rb[mon]' class='textbox'>
					<option>--</option>
					{section name=month start=1 loop=13}
						<option>{$smarty.section.month.index}</option>
					{/section}
				</select>
				<select name='date_rb[year]' class='textbox'>
					<option>--</option>
					{assign var='year' value=$smarty.now|date_format:"%Y"}
					{section name=year start=2000 loop=$year+2}
						<option>{$smarty.section.year.index}</option>
					{/section}
				</select>
				<select name='date_rb[hours]' class='textbox'>
					<option>--</option>
					{section name=hours start=1 loop=25}
						<option>{$smarty.section.hours.index}</option>
					{/section}
				</select>
				<select name='date_rb[minutes]' class='textbox'>
					<option>--</option>
					{section name=minutes start=0 loop=61}
						<option>{$smarty.section.minutes.index}</option>
					{/section}
				</select> : 00 <span class='small'>{$locale.nl470}</span>
			</td>
		</tr>
		<tr>
			<td align='left' width='1%' class='tbl1' style='white-space:nowrap'>
				{$locale.nl468}
			</td>
			<td align='left' class='tbl1' style='white-space:nowrap'>
				<select name='date_ra[mday]' class='textbox'>
					<option>--</option>
					{section name=day start=1 loop=32}
						<option>{$smarty.section.day.index}</option>
					{/section}
				</select>
				<select name='date_ra[mon]' class='textbox'>
					<option>--</option>
					{section name=month start=1 loop=13}
						<option>{$smarty.section.month.index}</option>
					{/section}
				</select>
				<select name='date_ra[year]' class='textbox'>
					<option>--</option>
					{assign var='year' value=$smarty.now|date_format:"%Y"}
					{section name=year start=2000 loop=$year+2}
						<option>{$smarty.section.year.index}</option>
					{/section}
				</select>
				<select name='date_ra[hours]' class='textbox'>
					<option>--</option>
					{section name=hours start=1 loop=25}
						<option>{$smarty.section.hours.index}</option>
					{/section}
				</select>
				<select name='date_ra[minutes]' class='textbox'>
					<option>--</option>
					{section name=minutes start=0 loop=61}
						<option>{$smarty.section.minutes.index}</option>
					{/section}
				</select> : 00 <span class='small'>{$locale.nl470}</span>
			</td>
		</tr>
		<tr>
			<td align='center' colspan='2' class='tbl2' style='white-space:nowrap'>
			</td>
		</tr>
	</table>
	<center>
	<br />
	<input type='hidden' name='newsletter_id' value='{$newsletter_id}' />
	<input type='submit' name='send_send' value='{$locale.nl474}' class='button' />
	<input type='submit' name='send_cancel' value='{$locale.nl406}' class='button' />
	<br />
	</center>
</form>
{include file="_closetable.tpl"}
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}