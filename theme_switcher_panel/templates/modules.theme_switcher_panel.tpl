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
{* This template generates the ExiteCMS side panel: theme_switcher         *}
{*                                                                         *}
{***************************************************************************}
{include file="_openside_x.tpl" name=$_name title=$_title state=$_state style=$_style}
	<form name='theme_switcher_form' method='post' action='{$smarty.const.FUSION_REQUEST|escape:"entities"}'>
		<div style='text-align:center;'>
			<select name='theme_switcher_panel_theme' class='textbox' style='width:150px;' onchange='document.theme_switcher_form.submit();'>
				{foreach from=$theme_files item=theme}
					<option{if $userdata.user_theme ==  $theme} selected="selected"{/if}>{$theme}</option>
				{/foreach}
			</select>
		</div>
	</form>
{include file="_closeside_x.tpl"}
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}
