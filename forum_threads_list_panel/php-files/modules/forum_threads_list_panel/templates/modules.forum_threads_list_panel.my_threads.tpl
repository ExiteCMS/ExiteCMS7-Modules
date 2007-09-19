{***************************************************************************}
{*                                                                         *}
{* PLi-Fusion CMS template: forum_my_threads.tpl                           *}
{*                                                                         *}
{***************************************************************************}
{*                                                                         *}
{* Author: WanWizard <wanwizard@gmail.com>                                 *}
{*                                                                         *}
{* Revision History:                                                       *}
{* 2007-07-02 - WW - Initial version                                       *}
{*                                                                         *}
{***************************************************************************}
{*                                                                         *}
{* This template generates the PLi-Fusion infusion panel:                  *}
{* forum_threads_list_panel/my_threads                                     *}
{*                                                                         *}
{***************************************************************************}
{include file="_opentable.tpl" name=$_name title=$locale.026 state=$_state style=$_style}
{if $rows > 0}
<table cellpadding='0' cellspacing='1' width='100%' class='tbl-border'>
	<tr>
		<td class='tbl2'>
			<span class='small'><b>{$locale.030}</b></span>
		</td>
		<td class='tbl2'>
			<span class='small'><b>{$locale.031}</b></span>
		</td>
		<td align='center' width='1%' class='tbl2' style='white-space:nowrap'>
			<span class='small'><b>{$locale.032}</b></span>
		</td>
		<td align='center' width='1%' class='tbl2' style='white-space:nowrap'>
			<span class='small'><b>{$locale.033}</b></span>
		</td>
		<td align='center' colspan='2' width='1%' class='tbl2' style='white-space:nowrap'>
			<span class='small'><b>{$locale.034}</b></span>
		</td>
	</tr>
	{section name=id loop=$threads}
	<tr>
		<td width='45%' class='{cycle values='tbl1,tbl2' advance=no}'>
			<span class='small'>
				<a href='{$smarty.const.FORUM}viewforum.php?forum_id={$threads[id].forum_id}' title='{$threads[id].forum_name}'>{$threads[id].forum_name}</a>
			</span>
		</td>
		<td width='55%' class='{cycle values='tbl1,tbl2' advance=no}'>
			<span class='small'>
				<a href='{$smarty.const.FORUM}viewthread.php?forum_id={$threads[id].forum_id}&amp;thread_id={$threads[id].thread_id}' title='{$threads[id].thread_subject}'>{$threads[id].thread_subject|truncate:40:"..."}{if $threads[id].poll} <b>{$locale.FPM_200}</b>{/if}</a>
			</span>
		</td>
		<td align='center' width='1%' class='{cycle values='tbl1,tbl2' advance=no}' style='white-space:nowrap'>
			<span class='small'>{$threads[id].thread_views}</span>
		</td>
		<td align='center' width='1%' class='{cycle values='tbl1,tbl2' advance=no}' style='white-space:nowrap'>
			<span class='small'>{$threads[id].post_count}</span>
		</td>
		<td align='center' width='1%' class='{cycle values='tbl1,tbl2' advance=no}' style='white-space:nowrap'>
			<span class='small'>
				<a href='{$smarty.const.BASEDIR}profile.php?lookup={$threads[id].thread_lastuser}'>{$threads[id].user_name}</a>
			</span>
		</td>
		<td align='center' width='1%' class='{cycle values='tbl1,tbl2'}' style='white-space:nowrap'>
			<span class='small'>{$threads[id].thread_lastpost|date_format:"forumdate"}</span>
		</td>
	</tr>
	{/section}
</table>
{else}
<center>
	<br />
	{$locale.037}
	<br /><br />
</center>
{/if}
{include file="_closetable.tpl"}
{if $rows > $smarty.const.ITEMS_PER_PAGE}
	{makepagenav start=$rowstart count=$smarty.const.ITEMS_PER_PAGE total=$rows range=3}
{/if}
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}