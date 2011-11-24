<?php
/**
 * Displays the system time, optionally with an offset. 
 */

$offset = trim($vars['offset']);
$format = trim($vars['format']);
$format = $format == "" ? "H:i:s" : $format;

if ($offset == "") {
	echo date("H:i:s", time());
} else {
	echo date("H:i:s", time()+(60*60*$offset));
}
?>