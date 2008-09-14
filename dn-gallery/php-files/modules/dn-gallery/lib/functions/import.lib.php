<?
function import_all($root = "")
{
	$dir = dir($root."modules/");
	while (false !== ($entry = $dir->read())) {
		if ($entry != "." && $entry != "..") {
			$mod_dir = dir($root."modules/".$entry."/classes/");
			while (false !== ($mod_entry = $mod_dir->read())) {
				if ($mod_entry != "." && $mod_entry != "..") {
					include_once($root."modules/".$entry."/classes/".$mod_entry);
				}
			}
		}
	}
	$dir->close();
}
?>