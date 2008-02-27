{***************************************************************************}
{*                                                                         *}
{* PLi-Fusion CMS template: forum_new_posts_detail.tpl                     *}
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
{* forum_threads_list_panel/new_posts_detail                               *}
{*                                                                         *}
{***************************************************************************}
{include file="_opentable.tpl" name=$_name title=$locale.028 state=$_state style=$_style}
{if $rows > 0}
<table cellpadding='0' cellspacing='1' width='100%' class='tbl-border'>
	<tr>
		<td class='tbl2'>
			<b>{$locale.030}</b>
		</td>
		<td class='tbl2'>
			<b>{$locale.035}</b>
		</td>
		<td align='center' class='tbl2' width='100'>
			<b>{$locale.057}</b>
		</td>
		<td align='center' class='tbl2' width='120'>
			<b>{$locale.056}</b>
		</td>
	</tr>
	{section name=id loop=$posts}
	<tr>
		<td class='{cycle values='tbl1,tbl2' advance=no}'>
			<a href='{$smarty.const.BASEDIR}forum/viewforum.php?forum_id={$posts[id].forum_id}&amp;forum_cat={$posts[id].forum_cat}'>{$posts[id].forum_name}</a>
		</td>
		<td class='{cycle values='tbl1,tbl2' advance=no}'>
			<a href='{$smarty.const.BASEDIR}forum/viewthread.php?forum_id={$posts[id].forum_id}&amp;thread_id={$posts[id].thread_id}&amp;pid={$posts[id].post_id}#post_{$posts[id].post_id}'>{$posts[id].post_subject}{if $posts[id].poll} <b>{$locale.FPM_200}</b>{/if}</a>
		</td>
		<td align='center' width='1%' class='{cycle values='tbl1,tbl2' advance=no}' style='white-space:nowrap'>
			<a href='{$smarty.const.BASEDIR}profile.php?lookup={$posts[id].post_author}'>{$posts[id].user_name}</a>
		</td>
		<td align='center' width='1%' class='{cycle values='tbl1,tbl2'}' style='white-space:nowrap'>
			{$posts[id].post_datestamp|date_format:"forumdate"}
		</td>
	</tr>
	{/section}
	<tr>
		<td align='center' colspan='4' class='{cycle values='tbl1,tbl2'}'>
			{if $threads == 1}
				{if $rows == 1}
					<b>{$locale.039a}</b>
				{else}
					<b>{ssprintf format=$locale.039b var1=$rows}</b>
				{/if}
			{else}
			<b>{ssprintf format=$locale.039 var1=$rows var2=$threads}</b>
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