<link rel="stylesheet" type="text/css" href="style/css_ns6up.css">
<script type="text/javascript" src="js/js_lib.js"></script>
<script type="text/javascript" src="js/internal_request.js"></script>

<script>
function checkThisForm(fr) {
	if (!cek_empty(fr.SaranNama,"Nama")) {
		return false;
	}
	if (!cek_empty(fr.SaranAlamat,"Email")) {
		return false;
	}
	if (!validEmail(fr.SaranAlamat,"Email",true)) {
		return false;
	}
	if (!cek_empty(fr.SaranMessage,"Pesan")) {
		return false;
	}
	return true;
}
</script>
<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center" height="100%">
<tr>
<td width="100%" align="center" valign="top" height="100%" align="Center">
<div align="left">
	<?php include_once(TEMPLATES."content.tpl.php"); ?>
</div>
</td>
</tr>
</table>