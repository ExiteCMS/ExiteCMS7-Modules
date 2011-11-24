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
{* This template generates the ExiteCMS panel: online_users_panel          *}
{*                                                                         *}
{***************************************************************************}
{include file="_openside_x.tpl" name=$_name title=$locale.010 state=$_state style=$_style}
<img src='{$smarty.const.THEME}images/bullet.gif' alt='' /> {$locale.011}{$guests|@count}<br />
<div style='margin-left:8px;'>
{section name=guest loop=$guests}
	{$guests[guest].cc_flag|replace:"&nbsp;":""}<img src='{$smarty.const.IMAGES}spacer.gif' width='2' alt='' title='' />
{/section}
</div>
<img src='{$smarty.const.THEME}images/bullet.gif' alt='' /> {$locale.012}{$members|@count}<br />
<div style='margin-left:8px;'>
{section name=member loop=$members}
	{if $smarty.const.iMEMBER}<a href='{$smarty.const.BASEDIR}profile.php?lookup={$members[member].user_id}' class='side'>{$members[member].user_name}</a>{else}<u>{$members[member].user_name}</u>{/if}{if $smarty.section.member.last}{else}, {/if}
{sectionelse}
	{$locale.013}
{/section}
</div>
{if $smarty.const.iADMIN}
	<br /><img src='{$smarty.const.THEME}images/bullet.gif' alt='' /> {$max_users|string_format:$locale.018}
	<div style='margin-left:8px;'>{$max_date|string_format:$locale.019}</div>
{/if}
<br /><img src='{$smarty.const.THEME}images/bullet.gif' alt='' /> {$locale.014} {$users_count}<br />
{if $smarty.const.iADMIN}
	<img src='{$smarty.const.THEME}images/bullet.gif' alt='' /> {$locale.017} {$users_online}<br />
{/if}
{if $settings.admin_activation == "1"}
	<img src='{$smarty.const.THEME}images/bullet.gif' alt='' /> {$locale.015} {$users_registered}<br />
{/if}
<img src='{$smarty.const.THEME}images/bullet.gif' alt='' /> {$locale.016}<br />
<div style='margin-left:8px;'>
	{$last_user_flag|default:""}{if $smarty.const.iMEMBER}<a href='{$smarty.const.BASEDIR}profile.php?lookup={$last_user_id}' class='side'>{$last_user_name}</a>{else}{$last_user_name}{/if}
</div>
{include file="_closeside_x.tpl"}
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}
