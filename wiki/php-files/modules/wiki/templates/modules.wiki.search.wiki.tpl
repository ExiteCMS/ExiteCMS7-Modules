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
{* Template for the download_statistics module 'search download files'     *}
{*                                                                         *}
{***************************************************************************}
{if $action == "search"}
	{section name=idx loop=$reportvars.output}
		<img src='{$smarty.const.THEME}images/bullet.gif' alt='' />
		{if $reportvars.output[idx].access}
			<a href='{$smarty.const.MODULES}wiki/index.php?wakka={$reportvars.output[idx].tag}'>{$reportvars.output[idx].tag}</a>
		{else}
			{$reportvars.output[idx].tag}
		{/if}
		<br />&nbsp;<span class='small'>
			<font class='smallalt'>{$locale.425}</font> {$reportvars.output[idx].time|date_format:"longdate"} - 
			<font class='smallalt'>{$locale.426}</font>
			{if iMEMBER && $reportvars.output[idx].user_id}
				<a href='profile.php?lookup={$reportvars.output[idx].user_id}'>{$reportvars.output[idx].owner}</a>
			{else}
				{$reportvars.output[idx].owner}
			{/if}
		</span>
		<blockquote>{$reportvars.output[idx].snippet}</blockquote>
	{/section}
{else}
	<input type='radio' name='search_id' value='{$searches[id].search_id}' {if $search_id == $searches[id].search_id || $searches[id].search_order == $default_location}checked='checked'{/if}  onclick='javascript:show_filter("{$searches[id].search_filters}");'/> {$searches[id].search_title} {if $searches[id].search_fulltext}<span style='color:red;'>*</span>{/if}<br />
{/if}
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}
