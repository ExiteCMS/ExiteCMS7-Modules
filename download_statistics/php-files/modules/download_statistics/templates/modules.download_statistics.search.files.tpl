{***************************************************************************}
{*                                                                         *}
{* ExiteCMS template: download_statistics.search.files.tpl                 *}
{*                                                                         *}
{***************************************************************************}
{*                                                                         *}
{* Author: WanWizard <wanwizard@gmail.com>                                 *}
{*                                                                         *}
{* Revision History:                                                       *}
{* 2008-08-10 - WW - Initial version                                       *}
{*                                                                         *}
{***************************************************************************}
{*                                                                         *}
{* Template for the download_statistics module 'search download files'     *}
{*                                                                         *}
{***************************************************************************}
{if $action == "search"}
	{section name=idx loop=$reportvars.output}
		{if !$smarty.section.idx.first}
			<br /><br />
		{/if}
		{$locale.dls810}: {$reportvars.output[idx].dlsf_file}
		<br />
		<span class='small'><font class='smallalt'>{$locale.dls811}:</font> {$reportvars.output[idx].dlsf_counter}
	{/section}
{else}
	<input type='radio' name='search_id' value='{$searches[id].search_id}' {if $search_id == $searches[id].search_id}checked='checked'{/if}onclick='javascript:show_filter("date,users");' /> {$searches[id].search_title} {if $searches[id].search_fulltext}<span style='color:red;'>*</span>{/if}<br />
{/if}
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}
