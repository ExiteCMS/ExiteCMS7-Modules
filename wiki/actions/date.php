<?php
/**
 * Displays the system time, optionally with an offset, and a format. 
 */

$offset = trim($vars['offset']);
$format = trim($vars['format']);
$format = $format == "" ? "M d, Y" : $format;

if ($offset == "") {
	echo date("M d, Y", time());
} else {
	echo date("M d, Y", time()+(60*60*$offset));
}
?>