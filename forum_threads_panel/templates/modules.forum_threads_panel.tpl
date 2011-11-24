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
{* This template generates the panel: forum_threads_panel                  *}
{*                                                                         *}
{***************************************************************************}
{include file="_openside_x.tpl" name=$_name title=$locale.020 state=$_state style=$_style}
<div class='side-label'>
	<b>{$locale.021}</b>
</div>
{section name=id loop=$new_threads}
	<img src='{$smarty.const.THEME}images/bullet.gif' alt='' /> <a href='{$smarty.const.FORUM}viewthread.php?forum_id={$new_threads[id].forum_id}&amp;thread_id={$new_threads[id].thread_id}' title='{$new_threads[id].thread_subject}' class='side'>{$new_threads[id].thread_subject|truncate:24:"...":true}</a>
	<br />
{sectionelse}
<div style='text-align:center'>
	{$locale.004}
</div>
{/section}
<div class='side-label'>
	<b>{$locale.022}</b>
</div>
{section name=id loop=$hot_threads}
	{if $smarty.section.id.first}
	<table cellpadding='0' cellspacing='0' width='100%'>
	{/if}
		<tr>
			<td class='small'>
				<img src='{$smarty.const.THEME}images/bullet.gif' alt='' /> <a href='{$smarty.const.FORUM}viewthread.php?forum_id={$hot_threads[id].forum_id}&amp;thread_id={$hot_threads[id].thread_id}' title='{$hot_threads[id].thread_subject}' class='side'>{$hot_threads[id].thread_subject|truncate:18:"...":true}</a>
			</td>
			<td align='right' class='small'>
				[{$hot_threads[id].count_posts}]
			</td>
		</tr>
	{if $smarty.section.id.last}
	</table>
	{/if}
{sectionelse}
<div style='text-align:center'>
	{$locale.004}
</div>
{/section}
{include file="_closeside_x.tpl"}
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}
