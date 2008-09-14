
<?
if ($tab != "" && $tab != null) {
	$tab->render(); 
	if ($SearchPanel == "" || $SearchPanel == null) {
		echo "<br><BR>";
	}
}
if ($SearchPanel != "" && $SearchPanel != null) {
	$SearchPanel->render(); 
}
if ($dataGrid != "" && $dataGrid != null) {
	$dataGrid->render(); 
}

?>