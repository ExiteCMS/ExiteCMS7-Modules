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
{* This template generates the ExiteCMS module panel: shoutbox_archive     *}
{*                                                                         *}
{***************************************************************************}
{include file="_opentable.tpl" name=$_name title=$locale.120 state=$_state style=$_style}
{section name=shout loop=$shouts}
	{if $smarty.section.shout.first}
	<table cellpadding='0' cellspacing='1' width='100%' class='tbl-border'>
	{/if}
		<tr>
			<td class='{cycle values='tbl1,tbl2'}'>
				<span class='comment-name'>
					{if $shouts[shout].user_name}
						<a href='{$smarty.const.BASEDIR}profile.php?lookup={$shouts[shout].shout_name}'><b>{$shouts[shout].user_name}</b></a>
					{else}
						{$shouts[shout].shout_name}
					{/if}
				</span>
				<span class='small'>
					{$locale.041}{$shouts[shout].shout_datestamp|date_format:"longdate"}
				</span>
				{if $is_admin}
					&middot;
					{imagelink image="page_edit.gif" link=$smarty.const.MODULES|cat:"shoutbox_panel/shoutbox_admin.php"|cat:$aidlink|cat:"&amp;action=edit&amp;shout_id="|cat:$shouts[shout].shout_id title=$locale.048 style="vertical-align:bottom;"}
				{/if}
				<br />
				{$shouts[shout].shout_message}
			</td>
		</tr>
	{if $smarty.section.shout.last}
	</table>
	{/if}
{sectionelse}
	<div style="text-align:center;">
		<br />
		{$locale.127}
		<br /><br />
	</div>
{/section}
{include file="_closetable.tpl"}
{if $rows > $settings.numofthreads}
	{makepagenav start=$rowstart count=$settings.numofthreads total=$rows range=3 link=$pagenav_url}
{/if}
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}
