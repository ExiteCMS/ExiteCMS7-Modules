{***************************************************************************}
{* ExiteCMS Content Management System                                      *}
{***************************************************************************}
{* Copyright 2006-2009 Exite BV, The Netherlands                           *}
{* for support, please visit http://www.exitecms.org                       *}
{*-------------------------------------------------------------------------*}
{* Released under the terms & conditions of v2 of the GNU General Public   *}
{* License. For details refer to the included gpl.txt file or visit        *}
{* http://gnu.org                                                          *}
{***************************************************************************}
{* $Id:: main.print.tpl 1935 2008-10-29 23:42:42Z WanWizard               $*}
{*-------------------------------------------------------------------------*}
{* Last modified by $Author:: WanWizard                                   $*}
{* Revision number $Rev:: 1935                                            $*}
{***************************************************************************}
{*                                                                         *}
{* Template for the mileage module 'print' function                        *}
{*                                                                         *}
{***************************************************************************}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>{$settings.sitename}</title>
		<meta http-equiv='Content-Type' content='text/html; charset={$settings.charset}' />
		<meta http-equiv="Content-Style-Type" content="text/css" />
		<meta name='description' content='{$settings.description}' />
		<meta name='keywords' content='{$settings.keywords}' />
	</head>

	<body>
	{if $report_option == 0}
		{include file="modules.mileage.mileage.print_layout1.tpl"}
	{elseif $report_option == 1}
		{include file="modules.mileage.mileage.print_layout1.tpl"}
	{elseif $report_option == 2}
		{include file="modules.mileage.mileage.print_layout1.tpl"}
	{elseif $report_option == 3}
		{include file="modules.mileage.mileage.print_layout2.tpl"}
	{elseif $report_option == 4}
		{include file="modules.mileage.mileage.print_layout3.tpl"}
	{/if}
	</body>

</html>
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}
