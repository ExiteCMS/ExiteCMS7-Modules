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
{* $Id:: modules.tracsvn.svn.tpl 2043 2008-11-16 14:25:18Z WanWizard      $*}
{*-------------------------------------------------------------------------*}
{* Last modified by $Author:: WanWizard                                   $*}
{* Revision number $Rev:: 2043                                            $*}
{***************************************************************************}
{*                                                                         *}
{* This template generates the tracsvn svn panel                           *}
{*                                                                         *}
{***************************************************************************}
{include file="_opentable_x.tpl" name=$_name title=$locale.400 state=$_state style=$_style}
{if $file}
	<table cellspacing='0' cellpadding='0' align='center' width='100%'>
		<tr>
			<td class='infobar' style='font-weight:bold;'>
				{$locale.500} {$rev}
			</td>
		</tr>
		<tr>
			<td class='tbl2' align='left'>
				<b>{$file}</b>
			</td>
		</tr>
	</table>
	{if $is_source}
		{literal}
		<style type='text/css'>
			.code {
				color: black;
				font-size: 11px;
				font-family: "Lucida Console", Monaco, monospace;
				margin: auto;
				padding: 6px 3px 13px 3px;	/* padding-bottom solves hor. scrollbar hiding single line of code in IE6 but causes vert. scrollbar... */
				text-align: left;			/* override justify on body */
				overflow: auto;				/* allow scroll bar in case of long lines - goes together with white-space: nowrap! */
				white-space: nowrap;		/* prevent line wrapping */
			}
			/* syntax highlighting code - GeSHi */
			.code ol {
				margin-top: 6px;
				margin-bottom: 6px;			/* prevent vertical scroll bar in case of overflow */
			}
			.code li {
				font-size: 11px;
				font-family: "Lucida Console", Monaco, monospace;
			}
			.code .br0	{ color: #66cc66; }
			.code .co1	{ color: #808080; font-style: italic; }
			.code .co2	{ color: #808080; font-style: italic; }
			.code .coMULTI	{ color: #808080; font-style: italic; }
			.code .es0	{ color: #000099; font-weight: bold; }
			.code .kw1	{ color: #b1b100; }
			.code .kw2	{ color: #000000; font-weight: bold; }
			.code .kw3	{ color: #000066; }
			.code .kw4	{ color: #993333; }
			.code .kw5	{ color: #0000ff; }
			.code .me0	{ color: #006600; }
			.code .nu0	{ color: #cc66cc; }
			.code .re0	{ color: #0000ff; }
			.code .re1	{ color: #0000ff; }
			.code .re2	{ color: #0000ff; }
			.code .re4	{ color: #009999; }
			.code .sc0	{ color: #00bbdd; }
			.code .sc1	{ color: #ddbb00; }
			.code .sc2	{ color: #009900; }
			.code .st0	{ color: #ff0000; }
		</style>
		{/literal}
		<div id='codeblock.0.0' style='width:400px;'>{$output}</div>
	{else}
		<table cellspacing='0' cellpadding='0' align='center' width='100%'>
			<tr>
				<td class='tbl' align='center'>
					<div id='codeblock.0.0' style='width:400px;'>{$output.0}</div>
				</td>
			</tr>
		</table>
		<br />
	{/if}
{elseif $rev}
	<table cellspacing='0' cellpadding='0' align='center' width='100%'>
		<tr>
			<td colspan='2' class='infobar' style='font-weight:bold;'>
				{$locale.500} {$rev}
			</td>
		</tr>
		{section name=rev loop=$revs}
			<tr>
				<td class='tbl' align='right'>
					<b>{$locale.501}</b>:
				</td>
				<td class='tbl' align='left'>
					{$revs[rev].time|date_format:"longdate"} ({$revs[rev].timediff} {$locale.420})
				</td>
			</tr>
			<tr>
				<td class='tbl' align='right'>
					<b>{$locale.502}</b>:
				</td>
				<td class='tbl' align='left'>
					{if $revs[rev].author.user_id}
						<a href='{$smarty.const.BASEDIR}profile.php?lookup={$revs[rev].author.user_id}' title=''>{$revs[rev].author.user_name}</a>
					{else}
						{$revs[rev].author.user_name}
					{/if}
				</td>
			</tr>
			<tr>
				<td class='tbl' align='right' valign='top'>
					<b>{$locale.503}</b>:
				</td>
				<td class='tbl' align='left'>
					{$revs[rev].message|default:$locale.520}
				</td>
			</tr>
			<tr>
				<td class='tbl' align='right' valign='top'>
					<b>{$locale.504}</b>:
				</td>
				<td class='tbl' align='left'>
					{section name=id loop=$nodes}
						{if $nodes[id].change_type == "A"}			{* Added  *}
							<div style='float:left;background-color:#bbffbb;height:7px;width:7px;margin-top:3px;margin-right:4px;border:1px solid #000;'></div>
						{elseif $nodes[id].change_type == "C"}		{* Copied *}
							<div style='float:left;background-color:#8888ff;height:7px;width:7px;margin-top:3px;margin-right:4px;border:1px solid #000;'></div>
						{elseif $nodes[id].change_type == "D"}		{* Deleted *}
							<div style='float:left;background-color:#ff8888;height:7px;width:7px;margin-top:3px;margin-right:4px;border:1px solid #000;'></div>
						{elseif $nodes[id].change_type == "E"}		{* Edited *}
							<div style='float:left;background-color:#ffdd88;height:7px;width:7px;margin-top:3px;margin-right:4px;border:1px solid #000;'></div>
						{elseif $nodes[id].change_type == "M"}		{* Moved *}
							<div style='float:left;background-color:#cccccc;height:7px;width:7px;margin-top:3px;margin-right:4px;border:1px solid #000;'></div>
						{else}										{* Unknown *}
							<div style='float:left;background-color:#ffffff;height:7px;width:7px;margin-top:3px;margin-right:4px;border:1px solid #000;'></div>
						{/if}
						{if !$nodes[id].change_filtered && $nodes[id].change_type != "D" && $view_file}
							<a href='{$smarty.const.FUSION_SELF}?rev={$rev}&amp;file={$nodes[id].path}' title='{$locale.517}'>{$nodes[id].s_path}</a>
						{else}
							{if $nodes[id].change_filtered}
								{$locale.519}
							{else}
								{$nodes[id].s_path}
							{/if}
						{/if}
						{if $nodes[id].change_type == "C"}
							<br />
							&nbsp;&nbsp;&nbsp;(<span class='small2'>{$locale.505}</span> {if !$nodes[id].base_filtered}<a href='{$smarty.const.FUSION_SELF}?rev={$nodes[id].base_rev}' title='{$locale.518|sprintf:$nodes[id].base_rev}'>{$nodes[id].s_base_path}</a>{else}{$locale.519}{/if})
						{elseif $nodes[id].change_type == "M"}
							<br />
							&nbsp;&nbsp;&nbsp;(<span class='small2'>{$locale.506}</span> <a href='{$smarty.const.FUSION_SELF}?rev={$nodes[id].base_rev}' title='{$locale.518|sprintf:$nodes[id].base_rev}'>{$nodes[id].s_base_path}</a>)
						{/if}
						{if $nodes[id].diffs}
							(<a href='#diff_{$nodes[id].diff_nr}' title='{$locale.514}'>{$nodes[id].diffs} {$locale.513}</a>)
						{/if}
						<br />
					{sectionelse}
					{/section}
				</td>
			</tr>
		{sectionelse}
			<tr>
				<td colspan='2' class='tbl' align='center'>
					<b>{$locale.453}</b>
				</td>
			</tr>
		{/section}
	</table>
	<hr />
	<table cellspacing='0' cellpadding='1' align='center'>
		<tr>
			<td>
				<div style='float:left;background-color:#ffffff;height:7px;width:7px;margin-top:3px;margin-right:4px;border:1px solid #000;'></div> {$locale.507}
			</td>
			<td>
				<div style='float:left;background-color:#bbffbb;height:7px;width:7px;margin-top:3px;margin-left:10px;margin-right:4px;border:1px solid #000;'></div> {$locale.508}
			</td>
			<td>
				<div style='float:left;background-color:#8888ff;height:7px;width:7px;margin-top:3px;margin-left:10px;margin-right:4px;border:1px solid #000;'></div> {$locale.510}
			</td>
			<td>
				<div style='float:left;background-color:#ff8888;height:7px;width:7px;margin-top:3px;margin-left:10px;margin-right:4px;border:1px solid #000;'></div> {$locale.509}
			</td>
			<td>
				<div style='float:left;background-color:#ffdd88;height:7px;width:7px;margin-top:3px;margin-left:10px;margin-right:4px;border:1px solid #000;'></div> {$locale.511}
			</td>
			<td>
				<div style='float:left;background-color:#cccccc;height:7px;width:7px;margin-top:3px;margin-left:10px;margin-right:4px;border:1px solid #000;'></div> {$locale.512}
			</td>
		</tr>
	</table>
	{section name=id loop=$diffs}
		{if $smarty.section.id.first}
			<br />
			<table cellspacing='1' cellpadding='0' align='center' class='tbl-border'>
		{/if}
		<tr>
			<td colspan='3' class='tbl2'>
				<a name="diff_{$diffs[id].nr}" id="diff_{$diffs[id].nr}"></a>
			</td>
		</tr>
		<tr>
			<td colspan='3' class='infobar' style='font-weight:bold;'>
				<a href='{$smarty.const.FUSION_SELF}' title='{$locale.515|sprintf:$rev}'>{$diffs[id].path}</a>
			</td>
		</tr>
		<tr>
			<td class='tbl2' align='center' width='1%' style='font-size:90%;white-space:nowrap;'>
				<span class='small2'><a href='svn.php?rev={$diffs[id].base_rev}'>r{$diffs[id].base_rev}</a></span>
			</td>
			<td class='tbl2' align='center' width='1%' style='font-size:90%;white-space:nowrap;'>
				<a href='svn.php?rev={$diffs[id].rev}'>r{$diffs[id].rev}</a>
			</td>
			<td class='tbl2'>
			</td>
		</tr>
		{assign var=id_line value=0}
		{section name=nr loop=$diffs[id].output}
		<tr style='height:15px;margin:0px;padding:0px;'>
			<td class='tbl1' align='right' width='3%' style='white-space:nowrap;font-size:70%;'>
				{$diffs[id].output[nr].left}
			</td>
			<td class='tbl1' align='right' width='3%' style='white-space:nowrap;font-size:70%'>
				{$diffs[id].output[nr].right}
			</td>
			{if $diffs[id].output[nr].left == "" && $diffs[id].output[nr].right != ""}
				{assign var=linecolor value="background-color:#ddffdd;"}
			{elseif $diffs[id].output[nr].left != "" && $diffs[id].output[nr].right == ""}
				{assign var=linecolor value="background-color:#ffdddd;"}
			{else}
				{assign var=linecolor value=""}
			{/if}
			<td class='tbl1' align='left' width='94%' style='font-family:monospace;font-size:120%;{$linecolor}'>
				{if $diffs[id].output[nr].line != ""}
					<div id='codeblock.{$smarty.section.id.index}.{$id_line}' style='float:left;width:400px;white-space:nowrap;overflow:hidden;text-overflow:clip;'>{$diffs[id].output[nr].line}</div>
					{assign var=id_line value=$id_line+1}
				{/if}
			</td>
		</tr>
		{/section}
		{if $smarty.section.id.last}
				<tr>
					<td colspan='3' class='tbl2'>
					</td>
				</tr>
			</table>
			<table cellspacing='0' cellpadding='1' align='center'>
				<tr>
					<td>
						<div style='float:left;background-color:#ddffdd;height:7px;width:7px;margin-top:3px;margin-left:10px;margin-right:4px;border:1px solid #000;'></div> {$locale.508}
					</td>
					<td>
						<div style='float:left;background-color:#ffdddd;height:7px;width:7px;margin-top:3px;margin-left:10px;margin-right:4px;border:1px solid #000;'></div> {$locale.509}
					</td>
				</tr>
			</table>
		{/if}
	{/section}
{else}
	<table cellspacing='0' cellpadding='0' align='center' width='100%'>
	{section name=id loop=$revs}
		{if $revs[id].newdate}
			<tr>
				<td colspan='2' class='infobar' style='font-weight:bold;'>
					{$revs[id].time|date_format:"shortdate"}
				</td>
			</tr>
		{/if}
		<tr>
			<td class='tbl2' align='right' valign='top' width='1%' style='white-space:nowrap;'>
				<img src='{$smarty.const.THEME}images/bullet.gif' alt='' />
				<span class='small'>{$revs[id].time|date_format:"%H:%M"}</span>
			</td>
			<td class='tbl2'>
				{$locale.500}
				[<a href='{$smarty.const.FUSION_SELF}?rev={$revs[id].rev}' title='{$locale.516}'>{$revs[id].rev}</a>]
				{$locale.404}
				{if $revs[id].author.user_id}
					<a href='{$smarty.const.BASEDIR}profile.php?lookup={$revs[id].author.user_id}' title=''>{$revs[id].author.user_name}</a>
				{else}
					{$revs[id].author.user_name}
				{/if}
			</td>
		</tr>
		<tr>
			<td class='tbl2' align='right' valign='top' width='1%' style='white-space:nowrap;'>
			</td>
			<td class='tbl' width='99%' style=''>
				<img src='{$smarty.const.THEME}images/bullet.gif' alt='' /> {$revs[id].message|default:$locale.520}
			</td>
		</tr>
	{sectionelse}
	{/section}
	</table>
{/if}
{include file="_closetable_x.tpl"}
<script type='text/javascript'>
{literal}
// Dean Edwards/Matthias Miller/John Resig
function init() {
	// quit if this function has already been called
	if (arguments.callee.done) return;

	// flag this function so we don't do the same thing twice
	arguments.callee.done = true;

	// kill the timer
	if (_timer) clearInterval(_timer);

	// needed inside the loop
	var parent_left = 0;
	var parent_width = 0;
	var obj = 1;
	var i = 0;
	var j = 0;

	// set the width correctly
	while (document.getElementById("codeblock." + i + ".0") != null) {
		j = 0;
		while (document.getElementById("codeblock." + i + "." + j) != null) {
			// get the info about the objects parent
			obj = document.getElementById("codeblock." + i + "." + j).parentNode;
			// fall back gracefully if the parentNode can not be found
			if (obj == null) obj = document.getElementById("codeblock." + i + "." + j).offsetParent;
			parent_left = findPosX(obj);
			parent_width = obj.offsetWidth;
			// calculate the new width of the block, leave plenty of space to handle browser subtleties 
			block_width = parent_left + parent_width - findPosX(document.getElementById("codeblock." + i + "." + j)) - 20;
			// adjust the width of the code blocks
			document.getElementById("codeblock." + i + "." + j).style.width = block_width + "px";
			j++;
		}
		i++;
	}
};

/* for Mozilla/Opera9 */
if (document.addEventListener) {
	document.addEventListener("DOMContentLoaded", init, false);
}

/* for Internet Explorer */
/*@cc_on @*/
/*@if (@_win32)
	document.write("<script id=__ie_onload defer src=javascript:void(0)><\/script>");
	var script = document.getElementById("__ie_onload");
	script.onreadystatechange = function() {
		if (this.readyState == "complete") {
			init(); // call the onload handler
		}
	};
/*@end @*/

/* for Safari and Konqueror */
if (/KHTML|WebKit/i.test(navigator.userAgent)) { // sniff
	var _timer = setInterval(function() {
		if (/loaded|complete/.test(document.readyState)) {
			init(); // call the onload handler
		}
	}, 10);
}

/* other alternatives */
if (window.attachEvent) {
	window.attachEvent('onload', init);
} else if (window.addEventListener) {
	window.addEventListener('load', init, false);
}

/* if all else fails try this */
window.onload = init;
{/literal}
</script>
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}
