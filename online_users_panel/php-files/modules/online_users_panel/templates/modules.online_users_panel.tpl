{****************************************************************************}
{*                                                                          *}
{* PLi-Fusion CMS template: online_users_panel.tpl                          *}
{*                                                                          *}
{****************************************************************************}
{*                                                                          *}
{* Author: WanWizard <wanwizard@gmail.com>                                  *}
{*                                                                          *}
{* Revision History:                                                        *}
{* 2007-07-02 - WW - Initial version                                        *}
{*                                                                          *}
{****************************************************************************}
{*                                                                          *}
{* This template generates the PLi-Fusion infusion panel: online_users_panel*}
{*                                                                          *}
{****************************************************************************}
{include file="_openside_x.tpl" name=$_name title=$locale.010 state=$_state style=$_style}
<img src='{$smarty.const.THEME}images/bullet.gif' alt='' /> {$locale.011}{$guests}<br />
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
