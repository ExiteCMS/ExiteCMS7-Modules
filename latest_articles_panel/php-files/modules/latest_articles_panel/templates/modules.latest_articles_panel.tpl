{*****************************************************************************}
{*                                                                           *}
{* PLi-Fusion CMS template: latest_articles_panel.tpl                        *}
{*                                                                           *}
{*****************************************************************************}
{*                                                                           *}
{* Author: WanWizard <wanwizard@gmail.com>                                   *}
{*                                                                           *}
{* Revision History:                                                         *}
{* 2007-09-04 - WW - Initial version                                         *}
{*                                                                           *}
{*****************************************************************************}
{*                                                                           *}
{* This template generates the PLi-Fusion infusion panel: latest_articles_pnl*}
{*                                                                           *}
{*****************************************************************************}
{include file="_openside_x.tpl" name=$_name title=$locale.023 state=$_state style=$_style}
{section name=id loop=$articles}
	<img src='{$smarty.const.THEME}images/bullet.gif' alt='' />
	<a href='{$smarty.const.BASEDIR}readarticle.php?article_id={$articles[id].article_id}' title='{$articles[id].article_subject}' class='side'>{$articles[id].article_subject|truncate:23}</a>
	<br />
{sectionelse}
	<center>{$locale.004}</center>
{/section}
{include file="_closeside_x.tpl"}
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}