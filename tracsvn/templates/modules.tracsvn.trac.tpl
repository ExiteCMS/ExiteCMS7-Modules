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
{* $Id:: modules.tracsvn.trac.tpl 2043 2008-11-16 14:25:18Z WanWizard     $*}
{*-------------------------------------------------------------------------*}
{* Last modified by $Author:: WanWizard                                   $*}
{* Revision number $Rev:: 2043                                            $*}
{***************************************************************************}
{*                                                                         *}
{* This template generates the tracsvn trac panel                          *}
{*                                                                         *}
{***************************************************************************}
{include file="_opentable.tpl" name=$_name title=$locale.400 state=$_state style=$_style}
{if $step == "notfound"}
	<div style="text-align:center;color:red;">
		<br />
		{$locale.406}
		<br /><br />
	</div>
{elseif $step == "roadmap"}
	{section name=id loop=$milestones}
		{if $smarty.section.id.first}
			<table cellspacing='1' cellpadding='0' align='center' width='100%' class='tbl-border'>
		{/if}
			<tr>
				<td colspan='3' class='infobar' style='font-weight:bold;'>
					{$locale.414}: {$milestones[id].name}
					{if $milestones[id].completed}
						-
						{$locale.419} {$milestones[id].datediff} {$locale.420} ({$milestones[id].completed|date_format:"%x"})
					{elseif $milestones[id].due}
						-
						{if $milestones[id].overdue}
							{$locale.415} {$milestones[id].datediff} ({$milestones[id].due|date_format:"%x"})
						{else}
							{$locale.416} {$milestones[id].datediff} ({$milestones[id].due|date_format:"%x"})
						{/if}
					{/if}
				</td>
			</tr>
			<tr>
				<td colspan='3' class='tbl1'>
					{$milestones[id].description}
				</td>
			</tr>
			<tr>
				<td class='tbl2' align='center'>
					{$locale.419}:
					{assign var='total' value=$milestones[id].opened+$milestones[id].closed}
					{if $total}
						{assign var='total' value=$milestones[id].closed/$total*100}
						{$total|number_format:"%u"}%
					{else}
						0%
					{/if}
				</td>
				<td class='tbl2' align='center'>
					{$locale.417}: {$milestones[id].opened}
					{if $view_tickets && $milestones[id].opened}
						&nbsp;{imagelink image="image_view.gif" link=$smarty.const.FUSION_SELF|cat:"?step=tickets&amp;milestone="|cat:$milestones[id].name|cat:"&amp;status=open&amp;blanks="|cat:$milestones[id].include_blanks title=$locale.430}
					{/if}
				</td>
				<td class='tbl2' align='center'>
					{$locale.418}: {$milestones[id].closed}
					{if $view_tickets && $milestones[id].closed}
						&nbsp;{imagelink image="image_view.gif" link=$smarty.const.FUSION_SELF|cat:"?step=tickets&amp;milestone="|cat:$milestones[id].name|cat:"&amp;status=closed&amp;blanks="|cat:$milestones[id].include_blanks title=$locale.431}
					{/if}
				</td>
			</tr>
			{if !$smarty.section.id.last}
			<tr>
				<td colspan='3' class='tbl1'>
				</td>
			</tr>
			{/if}
		{if $smarty.section.id.last}
			</table>
		{/if}
	{sectionelse}
		<div style="text-align:center;color:red;">
			<br />
			{$locale.405}
			<br /><br />
		</div>
	{/section}
{elseif $step == "tickets"}
	{section name=id loop=$tickets}
		{if $smarty.section.id.first}
			<table cellspacing='1' cellpadding='0' align='center' width='100%' class='tbl-border'>
			<tr>
				<td colspan='3' class='infobar' style='font-weight:bold;'>
					{if $status == "open"}
						{$locale.423} {$locale.424}
					{else}
						{$locale.422} {$locale.424}
					{/if}
					{$locale.414}: {if $tickets[id].milestone == ""}-{else}{$tickets[id].milestone}{/if} {if $tickets[id].blanks == "yes"}{$locale.454}{/if}
				</td>
			</tr>
			<tr>
				<td colspan='2' class='tbl2'>
				</td>
				<td class='tbl2'>
					<b>{$locale.425}</b>
				</td>
				<td class='tbl2'>
					<b>{$locale.426}</b>
				</td>
				<td class='tbl2'>
					<b>{$locale.427}</b>
				</td>
				<td class='tbl2'>
					<b>{$locale.428}</b>
				</td>
			</tr>
		{/if}
		<tr>
			<td class='tbl1'>
				{imagelink image="image_view.gif" link=$smarty.const.FUSION_SELF|cat:"?step=ticket&amp;id="|cat:$tickets[id].id title=$locale.429}
			</td>
			<td class='tbl1'>
				{$tickets[id].id}
			</td>
			<td class='tbl1'>
				{$tickets[id].summary}
			</td>
			<td class='tbl1'>
				{$tickets[id].type}
			</td>
			<td class='tbl1'>
				{$tickets[id].priority}
			</td>
			<td class='tbl1'>
				{$tickets[id].status}
			</td>
		</tr>
		{if $smarty.section.id.last}
			</table>
		{/if}
	{sectionelse}
		<div style="text-align:center;color:red;">
			<br />
			{$locale.405}
			<br /><br />
		</div>
	{/section}
{elseif $step == "ticket"}
	<b>{$locale.432} #{$ticket.id}</b> ({$ticket.type}, {$ticket.status})
	<br /><br />
	<table align='center' width='100%' cellspacing='1' cellpadding='0' class='tbl-border'>
		<tr>
			<td class='infobar' align='left'>
				{$ticket.summary}
			</td>
			<td class='infobar' align='right'>
				{if $ticket.status == "closed"}
					{$locale.422}
				{else}
					{$locale.421}
				{/if}
				{$ticket.datediff} 
			</td>
		</tr>
	</table>
	<table align='center' width='100%' cellspacing='1' cellpadding='0' class='tbl-border'>
		<tr>
			<td class='tbl2' align='left'>
				{$locale.433}:
			</td>
			<td class='tbl1' align='left'>
				{if $ticket.reporter.user_id}
					<a href='{$smarty.const.BASEDIR}profile.php?lookup={$ticket.reporter.user_id}' title=''>{$ticket.reporter.user_name}</a>
				{else}
					{$ticket.reporter.user_name}
				{/if}
			</td>
			<td class='tbl2' align='left'>
				{$locale.434}:
			</td>
			<td class='tbl1' align='left'>
				{if $ticket.owner.user_id}
					<a href='{$smarty.const.BASEDIR}profile.php?lookup={$ticket.owner.user_id}' title=''>{$ticket.owner.user_name}</a>
				{else}
					{$ticket.owner.user_name}
				{/if}
			</td>
		</tr>
		<tr>
			<td class='tbl2' align='left'>
				{$locale.427}:
			</td>
			<td class='tbl1' align='left'>
				{$ticket.priority}
			</td>
			<td class='tbl2' align='left'>
				{$locale.414}:
			</td>
			<td class='tbl1' align='left'>
				{$ticket.milestone}
			</td>
		</tr>
		<tr>
			<td class='tbl2' align='left'>
				{$locale.435}:
			</td>
			<td class='tbl1' align='left'>
				{$ticket.component}
			</td>
			<td class='tbl2' align='left'>
				{$locale.436}:
			</td>
			<td class='tbl1' align='left'>
				{$ticket.version}
			</td>
		</tr>
		<tr>
			<td class='tbl2' align='left'>
				{$locale.437}:
			</td>
			<td class='tbl1' align='left'>
				{$ticket.severity}
			</td>
			<td class='tbl2' align='left'>
				{$locale.438}:
			</td>
			<td class='tbl1' align='left'>
				{$ticket.keywords}
			</td>
		</tr>
		<tr>
			<td class='tbl2' colspan='4'>
				{$locale.439}:
			</td>
		</tr>
		<tr>
			<td class='tbl1' colspan='4'>
				{$ticket.description}
			</td>
		</tr>
	</table>
	{section name=id loop=$changes}
		{if $smarty.section.id.first}
			<br />
			<b>{$locale.440}:</b>
			<br /><br />
			<table align='center' width='100%' cellspacing='1' cellpadding='0' class='tbl-border'>
		{/if}
			<tr>
				<td class='tbl2'>
					<span style='small'>
						{$changes[id].time|date_format:"forumdate"}  - {$locale.441} {$locale.404}
						{if $changes[id].author.user_id}
							<a href='{$smarty.const.BASEDIR}profile.php?lookup={$changes[id].author.user_id}' title=''>{$changes[id].author.user_name}</a>
						{else}
							{$changes[id].author.user_name}
						{/if}
					</span>
				</td>
			</tr>
			<tr>
				<td class='tbl1'>
					{if $changes[id].field == "comment"}
						{$changes[id].newvalue}
					{elseif $changes[id].oldvalue == ""}
						<img src='{$smart.const.THEME}/images/bullet.gif' alt='' /> <b>{$changes[id].field}</b> {$locale.441} {$locale.443} <span class='small2'>{$changes[id].newvalue}</span>
					{else}
						<img src='{$smart.const.THEME}/images/bullet.gif' alt='' />  <b>{$changes[id].field}</b> {$locale.441} {$locale.442} <span class='small2'>{$changes[id].oldvalue}</span> {$locale.443} <span class='small2'>{$changes[id].newvalue}</span>
					{/if}
				</td>
			</tr>
		{if $smarty.section.id.last}
			</table>
		{/if}
	{sectionelse}
	{/section}
{/if}
{include file="_closetable.tpl"}
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}
