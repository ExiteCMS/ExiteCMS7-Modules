{***************************************************************************}
{*                                                                         *}
{* PLi-Fusion CMS template: modules.wiki.upload.tpl                        *}
{*                                                                         *}
{***************************************************************************}
{*                                                                         *}
{* Author: WanWizard <wanwizard@gmail.com>                                 *}
{*                                                                         *}
{* Revision History:                                                       *}
{* 2007-07-20 - WW - Initial version                                       *}
{*                                                                         *}
{***************************************************************************}
{*                                                                         *}
{* Template for the wiki module 'image uploads'                            *}
{*                                                                         *}
{***************************************************************************}
{include file="_opentable.tpl" name=$_name title=$locale.420 state=$_state style=$_style}
<form name='uploadform' method='post' action='{$smarty.const.FUSION_REQUEST}' enctype='multipart/form-data'>
	<table align='center' cellpadding='0' cellspacing='0' width='350'>
		<tr>
			<td width='80' class='tbl'>
				{$locale.421}
			</td>
			<td class='tbl'>
				<input type='file' name='myfile' class='textbox' style='width:250px;' />
			</td>
		</tr>
		<tr>
			<td align='center' colspan='2' class='tbl'>
				<input type='submit' name='uploadimage' value='{$locale.420}' class='button' style='width:100px;'>
			</td>
		</tr>
	</table>
</form>
{include file="_closetable.tpl"}
{if $view|default:"" != ""}
	{include file="_opentable.tpl" name=$_name title=$locale.440 state=$_state style=$_style}
	<center>
		<br />
		{if $view_image|default:"" != ""}
			<img src='{$view_image}' alt='{$view}' />
		{else}
			{$locale.441}
		{/if}
	</center>
	{include file="_closetable.tpl"}
{else}
	{include file="_opentable.tpl" name=$_name title=$locale.460 state=$_state style=$_style}
	<table align='center' cellpadding='0' cellspacing='1' width='450' class='tbl-border'>
		<tr>
			<td align='center' colspan='2' class='tbl2'>
				<b>Uploaded Wiki Images</b>
			</td>
		</tr>
		{foreach from=$image_list item=image name=image_list}
		<tr>
			<td class='{cycle values='tbl1,tbl2' advance=no}'>
				{$image}
			</td>
		</tr>
		{foreachelse}
		<tr>
			<td align='center' class='tbl1'>
				{$locale.463}
			</td>
		</tr>
		{/foreach}
	</table>
	{include file="_closetable.tpl"}
{/if}
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}