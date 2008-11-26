<div class="pagefooter">
<?php
echo $this->FormOpen("", "TextSearch", "get");
?>
<table width='100%'>
	<tr>
		<td>
<?php 
	echo $this->HasAccess("write") ? "<a href=\"".$this->href("edit")."\" title=\"Click to edit this page\">Edit page</a> |\n" : "";
	echo $this->HasAccess("write") ? "<a href=\"".$this->href("upload")."\" title=\"Click to upload new files\">Upload File</a> |\n" : "";
	echo "<a href=\"".$this->href("history")."\" title=\"Click to view recent edits to this page\">Page History</a> |\n";
	echo $this->GetPageTime() ? "<a href=\"".$this->href("revisions")."\" title=\"Click to view recent revisions list for this page\">Revisions</a> |\n" : "";
//	echo $this->GetPageTime() ? "<a href=\"".$this->href("revisions")."\" title=\"Click to view recent revisions list for this page\">".$this->GetPageTime()."</a> |\n" : "";
	echo ($this->GetUser() ? "<a href='".$this->href("referrers")."' title='Click to view a list of URLs referring to this page.'>Referrers</a> |\n" : "");
	// if this page exists
	if ($this->page)
	{
		$owner = $this->GetPageOwner();
		if ($owner == "(Public)") {
			print("Public page\n");
		} elseif ($owner == false) {
			print("Nobody".($this->GetUser() ? " (<a href=\"".$this->href("claim")."\">Take Ownership</a>)\n" : "\n"));
		} elseif (iMEMBER && $GLOBALS['userdata']['user_name'] == $owner) {
			print("You own this page\n");
		} else {
			if (iMEMBER) {
				print("Owner: <a href='".BASEDIR."profile.php?lookup=$owner'>".$owner."</a>\n");
			} else {
				print("Owner: $owner\n");
			}
		}
		if ($this->IsAdmin()) {
			echo "| <a href=\"".$this->href("acls")."\">ACLs</a>\n";
			if ($this->LoadACL($this->tag, "read", false)) {
				echo "<img src='images/lock.gif' alt='' title='There is an ACL defined for this page' style='vertical-align:bottom;'/>";
			}
			echo "| <a href=\"".$this->href("aliases")."\">Aliases</a>\n";
		}
	}
?>
	</td>
</tr>
</table>
<table width='100%'>
<tr>
	<td width='100%' style='white-space:nowrap;'>
		Search: <input name="phrase" style='width:90%;' class="searchbox" />
	</td>
	<td width='25' align='right'>
<?php 
echo $this->GetPageTime() ? " <a href=\"".$this->href("revisions.xml")."\" title=\"Click to view recent page revisions in XML format.\"><img src=\"images/xml.png\" width=\"36\" height=\"14\" align=\"bottom\" style=\"border : 0px;\" alt=\"XML\" /></a>\n" : "&nbsp;";
?>
	</td>
</tr>
<tr>
	<td colspan='2' width='100%' align='right'>
		<div class="smallprint">
		<?php echo $this->Link("http://validator.w3.org/check/referer", "", "Valid XHTML 1.0 Transitional") ?> |
		<?php echo $this->Link("http://jigsaw.w3.org/css-validator/check/referer", "", "Valid CSS") ?> |
		Powered by <?php echo $this->Link("http://wikkawiki.org/", "", "Wikka Wakka Wiki") ?>
		</div>
	</td>
</tr>
</table>
<?php
echo $this->FormClose(); 
?>
</div>
<?php
	if ($this->GetConfigValue("sql_debugging"))
	{
		print("<div class=\"smallprint\"><strong>Query log:</strong><br />\n");
		foreach ($this->queryLog as $query)
		{
			print($query["query"]." (".$query["time"].")<br />\n");
		}
		print("</div>");
	}

	// page hit counter code
	$thispage=$this->GetPageTag();

	// Hot count is incremented if not your own page and we think it's a user
	if (!CMS_IS_BOT && $this->GetUserName() != $this->GetPageOwner($tag))
	{
		// Update Hit counter
		$sql = "UPDATE `".$this->config["table_prefix"]."pages` SET `hits` = `hits`+1 WHERE tag='$thispage' AND latest='Y'";
		// $sql .= " WHERE `ref` = $ref";
		mysql_query($sql) or die("Unable to process query: " . mysql_error());
	}
?>
