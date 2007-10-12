{***************************************************************************}
{*                                                                         *}
{* ExiteCMS template: modules.theme_switcher.tpl                           *}
{*                                                                         *}
{***************************************************************************}
{*                                                                         *}
{* Author: WanWizard <wanwizard@gmail.com>                                 *}
{*                                                                         *}
{* Revision History:                                                       *}
{* 2007-10-11 - WW - Initial version                                       *}
{*                                                                         *}
{***************************************************************************}
{*                                                                         *}
{* This template generates the ExiteCMS side panel: theme_switcher         *}
{*                                                                         *}
{***************************************************************************}
{include file="_openside_x.tpl" name=$_name title=$locale.400 state=$_state style=$_style}
	<form name='theme_switcher_form' method='post' action='{$smarty.const.FUSION_REQUEST|escape:"entities"}'>
		<table width='100%' cellpadding='0' cellspacing='0'>
			<tr>
				<td class='tbl' align='center'>
					<select name='theme_switcher_panel_theme' class='textbox' style='width:150px;' onchange='document.theme_switcher_form.submit();'>
						{foreach from=$theme_files item=theme}
							<option{if $userdata.user_theme ==  $theme} selected="selected"{/if}>{$theme}</option>
						{/foreach}
					</select>
				</td>
			</tr>
		</table>
	</form>
{include file="_closeside_x.tpl"}
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}