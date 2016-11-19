<?
// Start output of counter
$thispage=$this->GetPageTag();
$result = mysqli_query($this->dblink, "SELECT hits FROM ".$this->config["table_prefix"]."pages WHERE tag='$thispage' AND latest='Y'");
$row = mysqli_fetch_array($result);
$pagehits = $row['hits'];
print "$pagehits";
// End Output of counter
?>
