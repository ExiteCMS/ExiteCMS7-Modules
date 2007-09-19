<?php
/*---------------------------------------------------+
| PLi-Fusion Content Management System               |
+----------------------------------------------------+
| Copyright 2007 WanWizard (wanwizard@gmail.com)     |
| http://www.pli-images.org/pli-fusion               |
+----------------------------------------------------+
| Some portions copyright ? 2002 - 2006 Nick Jones   |
| http://www.php-fusion.co.uk/                       |
| Released under the terms & conditions of v2 of the |
| GNU General Public License. For details refer to   |
| the included gpl.txt file or visit http://gnu.org  |
+----------------------------------------------------*/
require_once dirname(__FILE__)."/../../includes/core_functions.php";
require_once PATH_ROOT."/includes/theme_functions.php";

if (file_exists(PATH_MODULES."download_statistics_panel/locale/".$settings['locale'].".php")) {
        $locale_file = PATH_MODULES."download_statistics_panel/locale/".$settings['locale'].".php";
} else {
		$locale_file = PATH_MODULES."download_statistics_panel/locale/English.php";
}
include $locale_file;

// temp storage for template variables
$variables = array();

// Google Maps API key's for our sites
switch ($settings['siteurl']) {
	case "http://pli-images.homelinux.org:8000/":
		// webmasters' local development site
		$google_key = "ABQIAAAAFzkUNDqkbip9qSbDE2RcWRSBmjVYl9U2GJ7GeYCnURSe-RS2TRQ8LEo9a-gvPh7z8GPd8XjmT0vtlQ";
		break;
	case "http://pli-new.homelinux.org:8000/":
		// webmasters' alternate development site
		$google_key = "ABQIAAAAFzkUNDqkbip9qSbDE2RcWRST71raTwcWQC8XtglbytRBQQawaBTpJ0oj66Ziwvc-Ec4Zq3JObm1ubA";
		break;
	case "http://dev.pli-images.org/":
		// official development site
		$google_key = "ABQIAAAAFzkUNDqkbip9qSbDE2RcWRSfMaYbIpzkuyJo11yMlT3DW5bJbRQVIXK_m2e9KLf1HeVGtHUyCJ_HcA";
		break;
	case "http://www.pli-images.org/":
		// production site
		$google_key = "ABQIAAAAFzkUNDqkbip9qSbDE2RcWRT4ekYYALPlSY1Y_MUwiCAitmkQ4hRzQsuNfqp0XrVNt0bEESkKOJtZOA";
		break;
	default:
		$google_key = "";
}
$variables['google_key'] = $google_key;
if ($google_key != "") {
	if (!isset($_headparms)) $_headparms = "";
	$_headparms .= "<script src='http://maps.google.com/maps?file=api&amp;v=2&amp;key=".$google_key."' type='text/javascript'></script>\n";
	if (!isset($_bodyparms)) $_bodyparms = "";
	$_bodyparms .= "onload='Gload()' onunload='GUnload()'";
}

// country locations (in case we can't map an IP address, but do know the country)
$countries = array();
$countries['AP'] = array('35.0000', '105.0000', 0);
$countries['EU'] = array('47.0000', '8.0000', 0);
$countries['AD'] = array('42.5000', '1.5000', 0);
$countries['AE'] = array('24.0000', '54.0000', 0);
$countries['AF'] = array('33.0000', '65.0000', 0);
$countries['AG'] = array('17.0500', '-61.8000', 0);
$countries['AI'] = array('18.2500', '-63.1667', 0);
$countries['AL'] = array('41.0000', '20.0000', 0);
$countries['AM'] = array('40.0000', '45.0000', 0);
$countries['AN'] = array('12.2500', '-68.7500', 0);
$countries['AO'] = array('-12.5000', '18.5000', 0);
$countries['AQ'] = array('-90.0000', '0.0000', 0);
$countries['AR'] = array('-34.0000', '-64.0000', 0);
$countries['AS'] = array('-14.3333', '-170.0000', 0);
$countries['AT'] = array('47.3333', '13.3333', 0);
$countries['AU'] = array('-27.0000', '133.0000', 0);
$countries['AW'] = array('12.5000', '-69.9667', 0);
$countries['AZ'] = array('40.5000', '47.5000', 0);
$countries['BA'] = array('44.0000', '18.0000', 0);
$countries['BB'] = array('13.1667', '-59.5333', 0);
$countries['BD'] = array('24.0000', '90.0000', 0);
$countries['BE'] = array('50.8333', '4.0000', 0);
$countries['BF'] = array('13.0000', '-2.0000', 0);
$countries['BG'] = array('43.0000', '25.0000', 0);
$countries['BH'] = array('26.0000', '50.5500', 0);
$countries['BI'] = array('-3.5000', '30.0000', 0);
$countries['BJ'] = array('9.5000', '2.2500', 0);
$countries['BM'] = array('32.3333', '-64.7500', 0);
$countries['BN'] = array('4.5000', '114.6667', 0);
$countries['BO'] = array('-17.0000', '-65.0000', 0);
$countries['BR'] = array('-10.0000', '-55.0000', 0);
$countries['BS'] = array('24.2500', '-76.0000', 0);
$countries['BT'] = array('27.5000', '90.5000', 0);
$countries['BV'] = array('-54.4333', '3.4000', 0);
$countries['BW'] = array('-22.0000', '24.0000', 0);
$countries['BY'] = array('53.0000', '28.0000', 0);
$countries['BZ'] = array('17.2500', '-88.7500', 0);
$countries['CA'] = array('60.0000', '-95.0000', 0);
$countries['CC'] = array('-12.5000', '96.8333', 0);
$countries['CF'] = array('7.0000', '21.0000', 0);
$countries['CG'] = array('-1.0000', '15.0000', 0);
$countries['CH'] = array('47.0000', '8.0000', 0);
$countries['CI'] = array('8.0000', '-5.0000', 0);
$countries['CK'] = array('-21.2333', '-159.7667', 0);
$countries['CL'] = array('-30.0000', '-71.0000', 0);
$countries['CM'] = array('6.0000', '12.0000', 0);
$countries['CN'] = array('35.0000', '105.0000', 0);
$countries['CO'] = array('4.0000', '-72.0000', 0);
$countries['CR'] = array('10.0000', '-84.0000', 0);
$countries['CS'] = array('44.8186', '20.4681', 0);
$countries['CU'] = array('21.5000', '-80.0000', 0);
$countries['CV'] = array('16.0000', '-24.0000', 0);
$countries['CX'] = array('-10.5000', '105.6667', 0);
$countries['CY'] = array('35.0000', '33.0000', 0);
$countries['CZ'] = array('49.7500', '15.5000', 0);
$countries['DE'] = array('51.0000', '9.0000', 0);
$countries['DJ'] = array('11.5000', '43.0000', 0);
$countries['DK'] = array('56.0000', '10.0000', 0);
$countries['DM'] = array('15.4167', '-61.3333', 0);
$countries['DO'] = array('19.0000', '-70.6667', 0);
$countries['DZ'] = array('28.0000', '3.0000', 0);
$countries['EC'] = array('-2.0000', '-77.5000', 0);
$countries['EE'] = array('59.0000', '26.0000', 0);
$countries['EG'] = array('27.0000', '30.0000', 0);
$countries['EH'] = array('24.5000', '-13.0000', 0);
$countries['ER'] = array('15.0000', '39.0000', 0);
$countries['ES'] = array('40.0000', '-4.0000', 0);
$countries['ET'] = array('8.0000', '38.0000', 0);
$countries['FI'] = array('64.0000', '26.0000', 0);
$countries['FJ'] = array('-18.0000', '175.0000', 0);
$countries['FK'] = array('-51.7500', '-59.0000', 0);
$countries['FM'] = array('6.9167', '158.2500', 0);
$countries['FO'] = array('62.0000', '-7.0000', 0);
$countries['FR'] = array('46.0000', '2.0000', 0);
$countries['GA'] = array('-1.0000', '11.7500', 0);
$countries['GB'] = array('54.0000', '-2.0000', 0);
$countries['GD'] = array('12.1167', '-61.6667', 0);
$countries['GE'] = array('42.0000', '43.5000', 0);
$countries['GF'] = array('4.0000', '-53.0000', 0);
$countries['GH'] = array('8.0000', '-2.0000', 0);
$countries['GI'] = array('36.1833', '-5.3667', 0);
$countries['GL'] = array('72.0000', '-40.0000', 0);
$countries['GM'] = array('13.4667', '-16.5667', 0);
$countries['GN'] = array('11.0000', '-10.0000', 0);
$countries['GP'] = array('16.2500', '-61.5833', 0);
$countries['GQ'] = array('2.0000', '10.0000', 0);
$countries['GR'] = array('39.0000', '22.0000', 0);
$countries['GS'] = array('-54.5000', '-37.0000', 0);
$countries['GT'] = array('15.5000', '-90.2500', 0);
$countries['GU'] = array('13.4667', '144.7833', 0);
$countries['GW'] = array('12.0000', '-15.0000', 0);
$countries['GY'] = array('5.0000', '-59.0000', 0);
$countries['HK'] = array('22.2500', '114.1667', 0);
$countries['HM'] = array('-53.1000', '72.5167', 0);
$countries['HN'] = array('15.0000', '-86.5000', 0);
$countries['HR'] = array('45.1667', '15.5000', 0);
$countries['HT'] = array('19.0000', '-72.4167', 0);
$countries['HU'] = array('47.0000', '20.0000', 0);
$countries['ID'] = array('-5.0000', '120.0000', 0);
$countries['IE'] = array('53.0000', '-8.0000', 0);
$countries['IL'] = array('31.5000', '34.7500', 0);
$countries['IN'] = array('20.0000', '77.0000', 0);
$countries['IO'] = array('-6.0000', '71.5000', 0);
$countries['IQ'] = array('33.0000', '44.0000', 0);
$countries['IR'] = array('32.0000', '53.0000', 0);
$countries['IS'] = array('65.0000', '-18.0000', 0);
$countries['IT'] = array('42.8333', '12.8333', 0);
$countries['JM'] = array('18.2500', '-77.5000', 0);
$countries['JO'] = array('31.0000', '36.0000', 0);
$countries['JP'] = array('36.0000', '138.0000', 0);
$countries['KE'] = array('1.0000', '38.0000', 0);
$countries['KG'] = array('41.0000', '75.0000', 0);
$countries['KH'] = array('13.0000', '105.0000', 0);
$countries['KI'] = array('1.4167', '173.0000', 0);
$countries['KM'] = array('-12.1667', '44.2500', 0);
$countries['KN'] = array('17.3333', '-62.7500', 0);
$countries['KP'] = array('40.0000', '127.0000', 0);
$countries['KR'] = array('37.0000', '127.5000', 0);
$countries['KW'] = array('29.5000', '45.7500', 0);
$countries['KY'] = array('19.5000', '-80.5000', 0);
$countries['KZ'] = array('48.0000', '68.0000', 0);
$countries['LA'] = array('18.0000', '105.0000', 0);
$countries['LB'] = array('33.8333', '35.8333', 0);
$countries['LC'] = array('13.8833', '-61.1333', 0);
$countries['LI'] = array('47.1667', '9.5333', 0);
$countries['LK'] = array('7.0000', '81.0000', 0);
$countries['LR'] = array('6.5000', '-9.5000', 0);
$countries['LS'] = array('-29.5000', '28.5000', 0);
$countries['LT'] = array('56.0000', '24.0000', 0);
$countries['LU'] = array('49.7500', '6.1667', 0);
$countries['LV'] = array('57.0000', '25.0000', 0);
$countries['LY'] = array('25.0000', '17.0000', 0);
$countries['MA'] = array('32.0000', '-5.0000', 0);
$countries['MC'] = array('43.7333', '7.4000', 0);
$countries['MD'] = array('47.0000', '29.0000', 0);
$countries['MG'] = array('-20.0000', '47.0000', 0);
$countries['MH'] = array('9.0000', '168.0000', 0);
$countries['MK'] = array('41.8333', '22.0000', 0);
$countries['ML'] = array('17.0000', '-4.0000', 0);
$countries['MN'] = array('46.0000', '105.0000', 0);
$countries['MM'] = array('16.7830', '96.1670', 0);
$countries['MO'] = array('22.1667', '113.5500', 0);
$countries['MP'] = array('15.2000', '145.7500', 0);
$countries['MQ'] = array('14.6667', '-61.0000', 0);
$countries['MR'] = array('20.0000', '-12.0000', 0);
$countries['MS'] = array('16.7500', '-62.2000', 0);
$countries['MT'] = array('35.8333', '14.5833', 0);
$countries['MU'] = array('-20.2833', '57.5500', 0);
$countries['MV'] = array('4.1000', '73.3000', 0);
$countries['MW'] = array('-13.5000', '34.0000', 0);
$countries['MX'] = array('23.0000', '-102.0000', 0);
$countries['MY'] = array('2.5000', '112.5000', 0);
$countries['MZ'] = array('-18.2500', '35.0000', 0);
$countries['NA'] = array('-22.0000', '17.0000', 0);
$countries['NC'] = array('-21.5000', '165.5000', 0);
$countries['NE'] = array('16.0000', '8.0000', 0);
$countries['NF'] = array('-29.0333', '167.9500', 0);
$countries['NG'] = array('10.0000', '8.0000', 0);
$countries['NI'] = array('13.0000', '-85.0000', 0);
$countries['NL'] = array('52.5000', '5.7500', 0);
$countries['NO'] = array('62.0000', '10.0000', 0);
$countries['NP'] = array('28.0000', '84.0000', 0);
$countries['NR'] = array('-0.5333', '166.9167', 0);
$countries['NU'] = array('-19.0333', '-169.8667', 0);
$countries['NZ'] = array('-41.0000', '174.0000', 0);
$countries['OM'] = array('21.0000', '57.0000', 0);
$countries['PA'] = array('9.0000', '-80.0000', 0);
$countries['PE'] = array('-10.0000', '-76.0000', 0);
$countries['PF'] = array('-15.0000', '-140.0000', 0);
$countries['PG'] = array('-6.0000', '147.0000', 0);
$countries['PH'] = array('13.0000', '122.0000', 0);
$countries['PK'] = array('30.0000', '70.0000', 0);
$countries['PL'] = array('52.0000', '20.0000', 0);
$countries['PM'] = array('46.8333', '-56.3333', 0);
$countries['PR'] = array('18.2500', '-66.5000', 0);
$countries['PS'] = array('32.0000', '35.2500', 0);
$countries['PT'] = array('39.5000', '-8.0000', 0);
$countries['PW'] = array('7.5000', '134.5000', 0);
$countries['PY'] = array('-23.0000', '-58.0000', 0);
$countries['QA'] = array('25.5000', '51.2500', 0);
$countries['RE'] = array('-21.1000', '55.6000', 0);
$countries['RO'] = array('46.0000', '25.0000', 0);
$countries['RU'] = array('60.0000', '100.0000', 0);
$countries['RW'] = array('-2.0000', '30.0000', 0);
$countries['SA'] = array('25.0000', '45.0000', 0);
$countries['SB'] = array('-8.0000', '159.0000', 0);
$countries['SC'] = array('-4.5833', '55.6667', 0);
$countries['SD'] = array('15.0000', '30.0000', 0);
$countries['SE'] = array('62.0000', '15.0000', 0);
$countries['SG'] = array('1.3667', '103.8000', 0);
$countries['SH'] = array('-15.9333', '-5.7000', 0);
$countries['SI'] = array('46.0000', '15.0000', 0);
$countries['SJ'] = array('78.0000', '20.0000', 0);
$countries['SK'] = array('48.6667', '19.5000', 0);
$countries['SL'] = array('8.5000', '-11.5000', 0);
$countries['SM'] = array('43.7667', '12.4167', 0);
$countries['SN'] = array('14.0000', '-14.0000', 0);
$countries['SO'] = array('10.0000', '49.0000', 0);
$countries['SR'] = array('4.0000', '-56.0000', 0);
$countries['ST'] = array('1.0000', '7.0000', 0);
$countries['SV'] = array('13.8333', '-88.9167', 0);
$countries['SY'] = array('35.0000', '38.0000', 0);
$countries['SZ'] = array('-26.5000', '31.5000', 0);
$countries['TC'] = array('21.7500', '-71.5833', 0);
$countries['TD'] = array('15.0000', '19.0000', 0);
$countries['TG'] = array('8.0000', '1.1667', 0);
$countries['TH'] = array('15.0000', '100.0000', 0);
$countries['TJ'] = array('39.0000', '71.0000', 0);
$countries['TK'] = array('-9.0000', '-172.0000', 0);
$countries['TM'] = array('40.0000', '60.0000', 0);
$countries['TN'] = array('34.0000', '9.0000', 0);
$countries['TO'] = array('-20.0000', '-175.0000', 0);
$countries['TR'] = array('39.0000', '35.0000', 0);
$countries['TT'] = array('11.0000', '-61.0000', 0);
$countries['TV'] = array('-8.0000', '178.0000', 0);
$countries['TW'] = array('23.5000', '121.0000', 0);
$countries['TZ'] = array('-6.0000', '35.0000', 0);
$countries['UA'] = array('49.0000', '32.0000', 0);
$countries['UG'] = array('1.0000', '32.0000', 0);
$countries['UM'] = array('19.2833', '166.6000', 0);
$countries['US'] = array('38.0000', '-97.0000', 0);
$countries['UY'] = array('-33.0000', '-56.0000', 0);
$countries['UZ'] = array('41.0000', '64.0000', 0);
$countries['VA'] = array('41.9000', '12.4500', 0);
$countries['VC'] = array('13.2500', '-61.2000', 0);
$countries['VE'] = array('8.0000', '-66.0000', 0);
$countries['VG'] = array('18.5000', '-64.5000', 0);
$countries['VI'] = array('18.3333', '-64.8333', 0);
$countries['VN'] = array('16.0000', '106.0000', 0);
$countries['VU'] = array('-16.0000', '167.0000', 0);
$countries['WF'] = array('-13.3000', '-176.2000', 0);
$countries['WS'] = array('-13.5833', '-172.3333', 0);
$countries['YE'] = array('15.0000', '48.0000', 0);
$countries['YT'] = array('-12.8333', '45.1667', 0);
$countries['YU'] = array('44.0000', '21.0000', 0);
$countries['ZA'] = array('-29.0000', '24.0000', 0);
$countries['ZM'] = array('-15.0000', '30.0000', 0);
$countries['ZR'] = array('0.0000', '25.0000', 0);
$countries['ZW'] = array('-20.0000', '30.0000', 0);
$countries['??'] = array('0.0000', '0.0000', 0);

$icons = array('yellow', 'orange', 'red', 'cyan', 'blue', 'purple', 'green');

// we need a valid Google Maps key to continue
if ($google_key != "") {

	// consolidate the IP statistics per country
	$result = dbquery("SELECT DISTINCT ds_ip, ds_cc FROM ".$db_prefix."dls_statistics WHERE ds_file LIKE '%software.ver'");
	// and add them to the country table
	while ($data = dbarray($result)) {
		if (isset($countries[$data['ds_cc']])) {
			$countries[$data['ds_cc']][2]++;
			if (!isset($countries[$data['ds_cc']][3])) {
				$result2 = dbquery("SELECT ip_name FROM ".$db_prefix."GeoIP WHERE ip_code = '".$data['ds_cc']."' LIMIT 1");
				if (dbrows($result2)) {
					$data2 = dbarray($result2);
					$countries[$data['ds_cc']][3] = $data2['ip_name'];
				}
			}

		} else {
			$countries['??'][2]++;
		}
	}

	// calculate the divider
	$max = 0;
	foreach($countries as $key => $country) {
		if ($country[2] > $max) $max = $country[2];
		if (!isset($countries[$key][3])) $countries[$key][3] = "";
	}
	define('DIVIDER', intval($max / count($icons)+1));

	// add the data found to the map
	$mapped = 0;
	$i = 0;
	$variables['markers'] = array();
	foreach($countries as $cc => $country) {
		if ($cc != "??" && $country[2] > 0) {
			$icon = intval($country[2] / DIVIDER);
			$variables['markers'][] = array('lat' => $country[0], 'lng' => $country[1], 'icon' => $icons[$icon], 'cc' => strtolower($cc), 'cn' => $country[3], 'count' => $country[2]);
			$mapped += $country[2];
		}
	}	
	$variables['mapped'] = $mapped;
	$variables['unknown'] = $countries['??'][2];

	$variables['mapping'] = array();
	foreach($icons as $key => $icon) {
		$l = $key == 0 ? 1 : $key * DIVIDER + 1;
		$u = (($key + 1) * DIVIDER);
		$variables['mapping'][] = array('icon' => $icon, 'start' => $l, 'end' => $u);
	}
}

// define the body panel variables
$template_panels[] = array('type' => 'body', 'name' => 'modules.downloadstats.geomapping', 'template' => 'modules.download_statistics_panel.geomapping.tpl', 'locale' => $locale_file);
$template_variables['modules.downloadstats.geomapping'] = $variables;

// Call the theme code to generate the output for this webpage
require_once PATH_THEME."/theme.php";
?>