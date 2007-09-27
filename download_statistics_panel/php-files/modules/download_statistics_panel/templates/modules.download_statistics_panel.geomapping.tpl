{***************************************************************************}
{*                                                                         *}
{* PLi-Fusion CMS template: infusions.downloadstats.geomapping.tpl         *}
{*                                                                         *}
{***************************************************************************}
{*                                                                         *}
{* Author: WanWizard <wanwizard@gmail.com>                                 *}
{*                                                                         *}
{* Revision History:                                                       *}
{* 2007-07-09 - WW - Initial version                                       *}
{*                                                                         *}
{***************************************************************************}
{*                                                                         *}
{* This template generates the Google GeoMap from the download statistics  *}
{*                                                                         *}
{***************************************************************************}
{include file="_opentable.tpl" name=$_name title=$locale.dls400 state=$_state style=$_style}
{if $google_key|default:"" == ""}
	{$settings.siteurl|string_format:$locale.dls900}
{else}
<table cellpadding='0' cellspacing='1' width='790' class='tbl-border'>
	<tr>
		<td class='tbl1'>
			<div id='map' style='width: 790px; height: 550px; z-index:1;'>
{literal}				<script type='text/javascript'>
//<![CDATA[

function Gload() {

	function createMarker(point, color, cc, cn, users) {
		icon.image = '/modules/download_statistics_panel/icons/' + color + '.png';
		var mymarker = new GMarker(point, icon);
		GEvent.addListener(mymarker, 'mouseover', function() {
			mymarker.openInfoWindowHtml('<span style="height:50px;font-size:10pt"><img width="18" height="12" src="{/literal}{$smarty.const.IMAGES}{literal}flags/' + cc + '.gif" alt="" />&nbsp;' + cn + '<br /><br />' + users + ' user(s)<\/span>');
		});
		GEvent.addListener(mymarker, 'mouseout', function() {
			//map.closeInfoWindow();
		});
		map.addOverlay(mymarker, icon);
		return mymarker;
	}

	if (GBrowserIsCompatible()) {

		var icon = new GIcon();
		icon.shadow = '/modules/download_statistics_panel/icons/shadow.png';
		icon.iconSize = new GSize(12, 20);
		icon.shadowSize = new GSize(22, 20);
		icon.iconAnchor = new GPoint(6, 20);
		icon.infoWindowAnchor = new GPoint(5, 1);

		var map = new GMap2(document.getElementById('map'));
		map.addControl(new GSmallMapControl());
//		map.addControl(new GMapTypeControl());
		map.setCenter(new GLatLng(10, 17), 2);
{/literal}
{section name=mark loop=$markers}
		var marker = createMarker(new GLatLng({$markers[mark].lat}, {$markers[mark].lng}), '{$markers[mark].icon}', '{$markers[mark].cc}', '{$markers[mark].cn}', '{$markers[mark].count}');
{/section}
{literal}	} else {
		alert('Sorry, the Google Maps API is not compatible with this browser');
	}
}
//]]>
					</script>{/literal}
				</div>
			</td>
		</tr>
	<tr>
		<td class='tbl2' align='center'>
			<b>{$mapped|string_format:$locale.dls901} {$unknown|string_format:$locale.dls904}</b>
		</td>
	</tr>
	<tr>
		<td class='tbl1' align='center'>
		{section name=cat loop=$mapping}
			<img src='{$smarty.const.MODULES}download_statistics_panel/icons/{$mapping[cat].icon}.png' alt='' />{$mapping[cat].start} - {$mapping[cat].end}
		{/section}
		</td>
	</tr>
	<tr>
		<td class='tbl2' align='center'>
			<b>{$locale.dls902}</b>
		</td>
	</tr>
</table>
{/if}
{include file="_closetable.tpl"}
{***************************************************************************}
{* End of template                                                         *}
{***************************************************************************}