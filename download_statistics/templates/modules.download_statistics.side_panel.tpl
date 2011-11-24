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
{* This template generates a side panel with a bar graph depicting the     *}
{* number of files downloaded as percentage of the total                   *}
{*                                                                         *}
{***************************************************************************}
{section name=bar loop=$counters}
{if $smarty.section.bar.first}
{include file="_openside_x.tpl" name=$_name title=$_title state=$_state style=$_style}
<table cellpadding='0' cellspacing='0'>
{/if}
	<tr>
		<td style='padding-right: 4px; height: 16px;'>
			{if $counters[bar].dlsc_download_id && $counters[bar].download_cat}
			<a href='{$settings.siteurl}downloads.php?cat_id={$counters[bar].download_cat}&amp;download_id={$counters[bar].dlsc_download_id}' class='side' title='{$counters[bar].description}'>{$counters[bar].dlsc_name}</a>
			{else}
				{$counters[bar].dlsc_name}
			{/if}
		</td>
		<td style='border-left: 1px solid #cccccc;'>
			<div style='background-color: #f6f6f6;width:{$barwidth}px'>
				<div style='height:12px;width:{$counters[bar].width}px;background-color:rgb({$counters[bar].red},{$counters[bar].green},{$counters[bar].blue});' title='{$counters[bar].description}'></div>
			</div>
		</td>
	</tr>
{if $smarty.section.bar.last}
	{if $settings.dlstats_title != "" || true}
	<tr>
		<td colspan='2' align='center'>
			{ssprintf format=$settings.dlstats_title|replace:"|":"<br />" var1=$total}
		</td>
	</tr>
	{/if}
</table>
{include file="_closeside_x.tpl"}
{/if}
{/section}
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}
