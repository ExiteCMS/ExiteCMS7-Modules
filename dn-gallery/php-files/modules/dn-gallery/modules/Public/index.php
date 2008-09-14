<?php
switch($frType) {
	case "0":
		$actType="insert";
	break;
	case "1":
		$actType="edit";
	break;
	case "2":
		$actType="delete";
	break;
}

$temp = "index";
switch($do) {
	case "0":	
		include_once(TEMPLATES.'index.tpl.php');
	break;
	case "1":
		include_once('modules/'.$mod.'/actions/'.$act.'.php');
	break;
	case "9":	
		include_once(TEMPLATES.'ajax.tpl.php');
	break;
}
?>
