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
{* This template generates the ExiteCMS panel: login_panel                 *}
{*                                                                         *}
{***************************************************************************}
{if $show_login}
	{include file="_openside.tpl" name=$_name title=$locale.060 state=$_state style=$_style}
	<div style='text-align:left'>
		{$loginerror|default:""}
		<form name='loginform2' method='post' action='{$smarty.const.BASEDIR}setuser.php?login=yes'>
			{foreach from=$auth_templates item=method key=i}
				{include file=$i}
			{/foreach}
			<hr />
			<div style='text-align:center'>
				<input type='checkbox' name='remember_me' value='yes' title='{$locale.063}' style='vertical-align:middle;'{if $remember_me|default:"no" == "yes"} checked="checked"{/if}/>
				<input type='submit' name='login' value='{$locale.064}' class='button' /><br />
				<input type='hidden' name='javascript_check' value='n' />
			</div>
		</form>
		{if $show_reglink || $show_passlink}
			<hr />
		{/if}
		{if $show_reglink}{$settings.siteurl|string_format:$locale.065}<br /><br />{/if}
		{if $show_passlink}{$settings.siteurl|string_format:$locale.066}{/if}
	</div>
	{literal}
<script type='text/javascript'>
/* <![CDATA[ */
	if (document.loginform2.javascript_check.value == 'n')
	{
		document.loginform2.javascript_check.value = 'y';
	}
	/* ]]> */
</script>
	{/literal}
	{include file="_closeside.tpl"}
{/if}
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}
