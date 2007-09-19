{***************************************************************************}
{*                                                                         *}
{* PLi-Fusion CMS template: download_bars_panel.tpl                        *}
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
{* download_bars_panel                                                     *}
{*                                                                         *}
{***************************************************************************}
{section name=bar loop=$barinfo}
{if $smarty.section.bar.first}
{literal}<style type='text/css'>
.dbp_list		{padding-right: 4px; height: 16px;}
.dbp_list a		{font-size: 9px;}
.dbp_bar_cell	{border-left: 1px solid #cccccc;}
.dbp_bar_bg		{background-color: #f6f6f6;}
.dbp_bar 		{height:12px;}
</style>{/literal}
{include file="_openside_x.tpl" name=$_name title=$title state=$_state style=$_style}
<table cellpadding='0' cellspacing='0'>
{/if}
	<tr>
		<td class='dbp_list'>
			<a href='{$settings.siteurl}downloads.php?download_id={$barinfo[bar].download_id}'>{$barinfo[bar].download_title}</a>
		</td>
		<td class='dbp_bar_cell'>
			<div class='dbp_bar_bg' style='width:{$barwidth}'>
				<div class='dbp_bar' style='width:{$barinfo[bar].width}px;background-color:rgb({$barinfo[bar].red},{$barinfo[bar].green},{$barinfo[bar].blue});'></div>
			</div>
		</td>
	</tr>
{if $smarty.section.bar.last}
</table>
{include file="_closeside_x.tpl"}
{/if}
{/section}
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}