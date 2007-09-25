{***************************************************************************}
{*                                                                         *}
{* PLi-Fusion CMS template: forum_new_posts.tpl                            *}
{*                                                                         *}
{***************************************************************************}
{*                                                                         *}
{* Author: WanWizard <wanwizard@gmail.com>                                 *}
{*                                                                         *}
{* Revision History:                                                       *}
{* 2007-07-13 - WW - Initial version                                       *}
{*                                                                         *}
{***************************************************************************}
{*                                                                         *}
{* This template generates the PLi-Fusion infusion panel:                  *}
{* forum_threads_list_panel/new_posts                                      *}
{*                                                                         *}
{***************************************************************************}
{include file="_opentable.tpl" name=$_name title=$locale.028 state=$_state style=$_style}
{if $unread > 0}
<table cellpadding='0' cellspacing='1' width='100%' class='tbl-border'>
	<tr>
		<td class='tbl2'>
			<b>{$locale.030}</b>
		</td>
		<td class='tbl2'>
			<b>{$locale.031}</b>
		</td>
		<td align='center' class='tbl2' width='1%' style='white-space:nowrap'>
			<b>{$locale.032}</b>
		</td>
		<td align='center' class='tbl2' width='1%' style='white-space:nowrap'>
			<b>{$locale.089}</b>
		</td>
		<td align='center' class='tbl2' width='1%' style='white-space:nowrap'>
			<b>{$locale.034}</b>
		</td>
	</tr>
	{section name=id loop=$posts}
	<tr>
		<td class='{cycle values='tbl1,tbl2' advance=no}'>
			<a href='{$smarty.const.BASEDIR}forum/viewforum.php?forum_id={$posts[id].forum_id}&amp;forum_cat={$posts[id].forum_cat}'>{$posts[id].forum_name}</a>
		</td>
		<td class='{cycle values='tbl1,tbl2' advance=no}'>
			<a href='{$smarty.const.BASEDIR}forum/viewthread.php?forum_id={$posts[id].forum_id}&amp;thread_id={$posts[id].thread_id}&amp;pid={$posts[id].post_id}#post_{$posts[id].post_id}'>{$posts[id].thread_subject}{if $posts[id].poll} <b>{$locale.FPM_200}</b>{/if}</a>
		</td>
		<td align='center' width='1%' class='{cycle values='tbl1,tbl2' advance=no}' style='white-space:nowrap'>
			{$posts[id].thread_views}
		</td>
		<td align='center' width='1%' class='{cycle values='tbl1,tbl2' advance=no}' style='white-space:nowrap'>
			{$posts[id].unread}
		</td>
		<td align='center' width='1%' class='{cycle values='tbl1,tbl2'}' style='white-space:nowrap'>
			{$posts[id].thread_lastpost|date_format:"forumdate"}
		</td>
	</tr>
	{/section}
	<tr>
		<td align='center' colspan='5' class='{cycle values='tbl1,tbl2'}'>
			{if $rows == 1}
			<b>{$locale.039a}</b>
			{else}
			<b>{ssprintf format=$locale.039 var1=$unread var2=$rows}</b>
			{/if}
			<br /><br />
			{buttonlink name=$locale.091 link=$smarty.const.FUSION_SELF|cat:"?markasread="|cat:$userdata.user_id}
		</td>
	</tr>
</table>
{else}
<center>
	<br />
	<b>{$locale.038}</b>
	<br /><br />
</center>
{/if}
{include file="_closetable.tpl"}
{if $rows > $smarty.const.ITEMS_PER_PAGE}
	{makepagenav start=$rowstart count=$smarty.const.ITEMS_PER_PAGE total=$rows range=3 link=$pagenav_url}
{/if}
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}