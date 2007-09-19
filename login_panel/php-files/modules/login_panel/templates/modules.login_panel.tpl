{****************************************************************************}
{*                                                                          *}
{* PLi-Fusion CMS template: login_panel.tpl                                 *}
{*                                                                          *}
{****************************************************************************}
{*                                                                          *}
{* Author: WanWizard <wanwizard@gmail.com>                                  *}
{*                                                                          *}
{* Revision History:                                                        *}
{* 2007-07-07 - WW - Initial version                                        *}
{*                                                                          *}
{****************************************************************************}
{*                                                                          *}
{* This template generates the PLi-Fusion infusion panel: login_panel       *}
{*                                                                          *}
{****************************************************************************}
{if !$smarty.const.iMEMBER}
	{include file="_openside.tpl" name=$_name title=$locale.060 state=$_state style=$_style}
	<div style='text-align:center'>
		{$loginerror|default:""}
		<form name='loginform' method='post' action='{$smarty.const.FUSION_SELF}'>
			{$locale.061}<br /><input type='text' name='user_name' class='textbox' style='width:100px' /><br />
			{$locale.062}<br /><input type='password' name='user_pass' class='textbox' style='width:100px' /><br />
			<input type='checkbox' name='remember_me' value='y' title='{$locale.063}' style='vertical-align:middle;'{if $remember_me|default:"no" == "yes"} checked{/if}/>
			<input type='submit' name='login' value='{$locale.064}' class='button' /><br />
			<input type='hidden' name='javascript_check' value='n' />
		</form>
	</div>
	{literal}
<script type='text/javascript'>
/* <![CDATA[ */
	if (document.loginform.javascript_check.value == 'n')
	{
		document.loginform.javascript_check.value = 'y';
	}
	/* ]]> */
</script>
	{/literal}
	<br />
	{if $settings.enable_registration}{$locale.065}<br /><br />{/if}
	{$locale.066}
	{include file="_closeside.tpl"}
{/if}
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}