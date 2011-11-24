<?
// Start output of counter
$thispage=$this->GetPageTag();
$result = mysql_query("SELECT hits FROM ".$this->config["table_prefix"]."pages WHERE tag='$thispage' AND latest='Y'");
$row = mysql_fetch_array($result);
$pagehits = $row['hits'];
print "$pagehits";
// End Output of counter
?>
