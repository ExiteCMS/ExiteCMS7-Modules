<?php
/*
 * Created on 10 Okt 06
 *
 * Author Adam
 * FileName string.lib.php
 */
 
function unhtmlspecialchars($str) {
	$trans = get_html_translation_table(HTML_SPECIALCHARS);
	$trans =array_flip($trans);
	$decoded = strtr($str, $trans);
	
	return $decoded;
}
 
function br2nl($str) {
	$str = eregi_replace("<br />","",$str);
	
	return $str;
}
?>
