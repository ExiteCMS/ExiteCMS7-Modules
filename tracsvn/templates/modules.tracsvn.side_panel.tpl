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
{* $Id:: modules.tracsvn.side_panel.tpl 2093 2008-12-05 20:43:27Z WanWiza#$*}
{*-------------------------------------------------------------------------*}
{* Last modified by $Author:: WanWizard                                   $*}
{* Revision number $Rev:: 2093                                            $*}
{***************************************************************************}
{*                                                                         *}
{* This template generates the tracsvn svn info side panel                 *}
{*                                                                         *}
{***************************************************************************}
{include file="_openside_x.tpl" name=$_name title=$locale.401 state=$_state style=$_style}
	{if $rev != 0}
		<div style="text-align:center;cursor:pointer;" onclick="window.open('{$settings.tracsvn_trac_url}changeset/{$rev}')" title="{$locale.110} {$locale.402} {$rev}">
			<span class='small'>{$locale.402}</span>
			<b>{$rev}</b>
			<br /><br />
			<span class='small'>{$locale.403}</span>
			<br />
			<b>{$date|date_format:"%d %b %Y · %H:%M"}</b>
			<br />
			<span class='small'>{$locale.404}</span> 
			<b>{$dev.user_name}</b>
		</div>
	{else}
		<div style="text-align:center;color:red;">{$locale.405}</div>
	{/if}
{include file="_closeside_x.tpl"}
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}
