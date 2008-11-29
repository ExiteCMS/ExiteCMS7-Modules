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
			{foreach from=$auth_methods item=method key=i}
				{if $method_count > 1}
					{if $method == "ldap"}
						<div class='side-label'>
							<div style='display:inline; position:relative; float:right;margin-top:2px;'>
								<img src='{$smarty.const.THEME}images/panel_{if $auth_state.$i}off{else}on{/if}.gif' alt='' name='b_login2{$i}' onclick="javascript:flipBox('login2{$i}')" />
							</div>
							{$locale.069} {$method|upper} {$locale.061}:
						</div>
						<div id='box_login2{$i}' name='login2{$i}' style='display:{if $auth_state.$i}block{else}none{/if};'>
					{elseif $method == "ad"}
						<div class='side-label'>
							<div style='display:inline; position:relative; float:right;margin-top:2px;'>
								<img src='{$smarty.const.THEME}images/panel_{if $auth_state.$i}off{else}on{/if}.gif' alt='' name='b_login2{$i}' onclick="javascript:flipBox('login2{$i}')" />
							</div>
							{$locale.069} {$method|upper} {$locale.061}:
						</div>
						<div id='box_login2{$i}' name='login2{$i}' style='display:{if $auth_state.$i}block{else}none{/if};'>
					{elseif $method == "local"}
						<div class='side-label'>
							<div style='display:inline; position:relative; float:right;margin-top:2px;'>
								<img src='{$smarty.const.THEME}images/panel_{if $auth_state.$i}off{else}on{/if}.gif' alt='' name='b_login2{$i}' onclick="javascript:flipBox('login2{$i}')" />
							</div>
							{$locale.069} {$locale.061}:
						</div>
						<div id='box_login2{$i}' name='login2{$i}' style='display:{if $auth_state.$i}block{else}none{/if};'>
					{elseif $method == "openid"}
						<div class='side-label'>
							<div style='display:inline; position:relative; float:right;margin-top:2px;'>
								<img src='{$smarty.const.THEME}images/panel_{if $auth_state.$i}off{else}on{/if}.gif' alt='' name='b_login2{$i}' onclick="javascript:flipBox('login2{$i}')" />
							</div>
							{$locale.069} {$locale.067}:
						</div>
						<div id='box_login2{$i}' name='login2{$i}' style='display:{if $auth_state.$i}block{else}none{/if};'>
					{/if}
				{/if}
				<div style='padding-left:2px;'>
				{if $method == "ldap"}
					{$locale.061}:<br /><input type='text' name='ldap_name' class='textbox' style='width:145px' /><br />
					{$locale.062}:<br /><input type='password' name='ldap_pass' class='textbox' style='width:145px' /><br />
				{elseif $method == "ad"}
					{$locale.061}:<br /><input type='text' name='ad_name' class='textbox' style='width:145px' /><br />
					{$locale.062}:<br /><input type='password' name='ad_pass' class='textbox' style='width:145px' /><br />
				{elseif $method == "local"}
					{$locale.061}:<br /><input type='text' name='user_name' class='textbox' style='width:145px' /><br />
					{$locale.062}:<br /><input type='password' name='user_pass' class='textbox' style='width:145px' /><br />
				{elseif $method == "openid"}
					<input type='text' name='user_openid_url' class='textbox' style='width:128px;background: url({$smarty.const.IMAGES}openid_small_logo.gif) no-repeat; padding-left: 18px;' /><br />
					<span class='small' style='font-size:90%;'>  <a href="http://{$settings.locale_code}.wikipedia.org/wiki/OpenID"  target="_blank">{$locale.068}</a></span><br />
				{/if}
				</div>
				{if $method_count > 1}
					</div>
				{/if}			
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
