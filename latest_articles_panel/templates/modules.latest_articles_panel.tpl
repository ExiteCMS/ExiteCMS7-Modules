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
{* This template generates the panel: latest_articles_panel                *}
{*                                                                         *}
{***************************************************************************}
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
