<?
$ref = $_GET["ref"];

if ($ref == "") {$ref = "-1"; }

$usr = new VmtUser();
$usr->setTokenReset($ref);
$ls = $usr->selectRowByCriteria();
?>