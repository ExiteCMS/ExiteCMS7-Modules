{***************************************************************************}
{*                                                                         *}
{* PLi-Fusion CMS template: modules.newsletters.editor.tpl                 *}
{*                                                                         *}
{***************************************************************************}
{*                                                                         *}
{* Author: WanWizard <wanwizard@gmail.com>                                 *}
{*                                                                         *}
{* Revision History:                                                       *}
{* 2007-09-04 - WW - Initial version                                       *}
{*                                                                         *}
{***************************************************************************}
{*                                                                         *}
{* Template for the admin installable module 'newsletters', edit panel     *}
{*                                                                         *}
{***************************************************************************}
{include file="_opentable.tpl" name=$_name title=$_title state=$_state style=$_style}
{if $settings.tinymce_enabled == 1}<script language='javascript' type='text/javascript'>advanced();</script>{/if}
<form name='inputform' method='post' action='{$smarty.const.FUSION_SELF}{$aidlink}&amp;newsletter_id={$newsletter_id}' onSubmit='return ValidateForm(this)'>
	<table align='center' cellspacing='0' cellpadding='0' width='90%' class='tbl'>
		<tr>
			<td align='center'>
				{$locale.nl430}
				<input type='text' name='subject' value='{$subject}' class='textbox' style='width:400px;' />
				<br /><br />
			</td>
		</tr>
		<tr>
		<td valign='top'>
			{$locale.nl431}
			<br />
			<textarea name='content' cols='95' rows='15' class='textbox' style='width:100%; height:{math equation="x/2" format="%u" x=$smarty.const.BROWSER_HEIGHT}px'>{$content}</textarea>
		</td>
	</tr>
	{if $settings.tinymce_enabled != 1}
	<tr>
		<td align='center'>
			{$locale.nl432}
			<input type='button' value='p' class='button' style='font-weight:bold;width:25px;' onClick="addText('content', '<p>', '</p>');" />
			<input type='button' value='br' class='button' style='font-weight:bold;width:25px;' onClick="insertText('content', '<br />');" />
			<input type='button' value='b' class='button' style='font-weight:bold;width:25px;' onClick="addText('content', '<b>', '</b>');" />
			<input type='button' value='i' class='button' style='font-style:italic;width:25px;' onClick="addText('content', '<i>', '</i>');" />
			<input type='button' value='u' class='button' style='text-decoration:underline;width:25px;' onClick="addText('content', '<u>', '</u>');" />
			<input type='button' value='link' class='button' style='width:35px;' onClick="addText('content', '<a href=\'http://\' target=\'_blank\'>', '</a>');" />
			<input type='button' value='img' class='button' style='width:35px;' onClick="insertText('content', '<img src=\'{$settings.siteurl}{$smarty.const.IMAGES}\' style=\'margin:5px;\' align=\'left\'>');" />
			<input type='button' value='center' class='button' style='width:45px;' onClick="addText('content', '<center>', '</center>');" />
			<input type='button' value='small' class='button' style='width:40px;' onClick="addText('content', '<span class=\'small\'>', '</span>');" />
			<input type='button' value='small2' class='button' style='width:45px;' onClick="addText('content', '<span class=\'small2\'>', '</span>');" />
			<input type='button' value='alt' class='button' style='width:25px;' onClick="addText('content', '<span class=\'alt\'>', '</span>');" />
		</td>
	</tr>
	<tr>
	<td align='center'>
		<br />
		{$locale.nl433}
		<input type='radio' name='format' value='plain'{if $plain} selected{/if} />
		{$locale.nl434}
		<input type='radio' name='format' value='html'{if $html} selected{/if} />
		{$locale.nl435}
		</td>
	</tr>
	{else}
	<tr>
		<td align='center'>
			<input type='hidden' name='format' value='html' />
		</td>
	</tr>
	{/if}
	<tr>
		<td align='left'>
			<br />
			<span class='small'>
				{$locale.nl439}
				<br />
				{$locale.nl440}
				<br />
				{$locale.nl441}
			</span>
		</td>
	</tr>
	<tr>
		<td align='center'>
			<br />
			<input type='submit' name='preview' value='{$locale.nl436}' class='button' />
			<input type='submit' name='{if $sent}copy{else}save{/if}' value='{if $sent}{$locale.nl438}{else}{$locale.nl437}{/if}' class='button' />
			<input type='hidden' name='sent' value='{$sent}' /></td>
		</tr>
	</table>
</form>
{include file="_closetable.tpl"}
<script type="text/javascript">
function ValidateForm(frm) {ldelim}
	if(frm.subject.value=='') {ldelim}
		alert('{$locale.nl450}');
		return false;
	{rdelim}
{rdelim}
</script>
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}