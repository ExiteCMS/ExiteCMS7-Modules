<!--begin of main content -->
	<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
	<td valign="top" class="bodytext" width="100%" height="100%">
	<? if ($templateContentError == "") { ?>
	<?php include_once('modules/'.$mod.'/views/'.$act.'.php'); ?>
	<?php 
	if (file_exists('modules/'.$mod.'/templates/'.$act.'.tpl.php')) {
		include_once('modules/'.$mod.'/templates/'.$act.'.tpl.php'); 
	}
	else {
		if (substr($act,0,2) == "ls" || substr($act,0,4) == "list" || substr($act,0,2) == "sr") {
			include_once('templates/list_template.tpl.php'); 
		}
		elseif (substr($act,0,2) == "fr") {
			include_once('templates/form_template.tpl.php'); 
		}
	}
	?>
	<? }
	else { ?>
	<?php include_once($templateContentError); ?>
	
	<? } ?>
	</td>
  </tr>
</table>
<!--end of main content -->