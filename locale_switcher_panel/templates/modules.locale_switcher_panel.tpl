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
{* This template generates the ExiteCMS side panel: locale_switcher        *}
{*                                                                         *}
{***************************************************************************}
{include file="_openside_x.tpl" name=$_name title=$_title state=$_state style=$_style}
	<form name='locale_switcher_form' method='post' action='{$smarty.const.FUSION_REQUEST|escape:"entities"}'>
		<div style='text-align:center;'>
			<select name='locale_switcher_panel_locale' class='textbox' style='width:150px;' onchange='document.locale_switcher_form.submit();'>
				{section name=id loop=$locales}
					<option value='{$locales[id].locale_code}' {if $userdata.user_locale == $locales[id].locale_code}selected="selected"{/if}>{$locales[id].locale_name}</option>
				{/section}
			</select>
		</div>
	</form>
{include file="_closeside_x.tpl"}
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}
