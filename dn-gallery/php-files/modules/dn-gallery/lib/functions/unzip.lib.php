<?
function unzip($zipfile,$target_dir)
{
    $zip = zip_open($zipfile);
    while ($zip_entry = zip_read($zip))    {
        zip_entry_open($zip, $zip_entry);
        if (substr(zip_entry_name($zip_entry), -1) == '/') {

        }
        else {
            $name = zip_entry_name($zip_entry);
			$expl = explode("/",$name);
			$file_name = $expl[sizeof($expl) - 1];
            if (file_exists($target_dir.$file_name)) {
                unlink($target_dir.$file_name);
            }
            $fopen = fopen($target_dir.$file_name, "w");
            fwrite($fopen, zip_entry_read($zip_entry, zip_entry_filesize($zip_entry)), zip_entry_filesize($zip_entry));
			$arr_file[] = $file_name;
        }
        zip_entry_close($zip_entry);
    }
    zip_close($zip);
    return $arr_file;
}
?>