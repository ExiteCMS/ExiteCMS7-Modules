<div class="pagefooter">
<table width='100%'>
	<tr>
		<td>
<?php 
	echo $this->HasAccess("write") ? "<a href=\"".$this->href("edit")."\" title=\"Click to edit this page\">Edit page</a> |\n" : "";
	echo "<a href=\"".$this->href("history")."\" title=\"Click to view recent edits to this page\">Page History</a> |\n";
	echo $this->GetPageTime() ? "<a href=\"".$this->href("revisions")."\" title=\"Click to view recent revisions list for this page\">".$this->GetPageTime()."</a> |\n" : "";
	echo ($this->GetUser() ? "<a href='".$this->href("referrers")."' title='Click to view a list of URLs referring to this page.'>Referrers</a> |\n" : "");
	// if this page exists
	if ($this->page)
	{
		if ($owner = $this->GetPageOwner())
		{
			if ($owner == "(Public)")
			{
				print("Public page ".($this->IsAdmin() ? "<a href=\"".$this->href("acls")."\">(Edit ACLs)</a>\n" : "\n"));
			}
			// if owner is current user
			elseif ($this->UserIsOwner())
			{
           			if ($this->IsAdmin())
           			{
					print("Owner: ".$this->Link($owner, "", "", 0)." | <a href=\"".$this->href("acls")."\">Edit ACLs</a>\n");
            		} 
            		else 
            		{
					print("You own this page | <a href=\"".$this->href("acls")."\">Edit ACLs</a>\n");
				}
			}
			else
			{
				print("Owner: ".$this->Link($owner, "", "", 0)."\n");
			}
		}
		else
		{
			print("Nobody".($this->GetUser() ? " (<a href=\"".$this->href("claim")."\">Take Ownership</a>)\n" : "\n"));
		}
	}

	print "</td><td width='1%' align='right' style='white-space:nowrap;'>";
	echo $this->FormOpen("", "TextSearch", "get"); 
?>
Search: <input name="phrase" size="15" class="searchbox" />
<?php
echo $this->FormClose(); 
?>
	</td>
</tr>
</table>
<table width='100%'>
<tr>
	<td width='1%'>
<?php 
echo $this->GetPageTime() ? " <a href=\"".$this->href("revisions.xml")."\" title=\"Click to view recent page revisions in XML format.\"><img src=\"images/xml.png\" width=\"36\" height=\"14\" align=\"bottom\" style=\"border : 0px;\" alt=\"XML\" /></a>\n" : "&nbsp;";
?>
	</td>
	<td width='99%' align='right'>
		<div class="smallprint">
		<?php echo $this->Link("http://validator.w3.org/check/referer", "", "Valid XHTML 1.0 Transitional") ?> |
		<?php echo $this->Link("http://jigsaw.w3.org/css-validator/check/referer", "", "Valid CSS") ?> |
		Powered by <?php echo $this->Link("http://wikkawiki.org/", "", "Wikka Wakka Wiki") ?>
		</div>
	</td>
</tr>
</table>
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
	// Get hit count
	$result2 = mysql_query( "SELECT hits FROM ".$this->config["table_prefix"]."pages WHERE tag='$thispage' AND latest='Y'" );
	$row2 = mysql_fetch_array($result2);
	$hit_count1 = $row2[hits];
	// Count is incremented if not your own page
	if ($this->GetUserName() != $this->GetPageOwner($tag))
	{
		// End Get hit Count   Start adding hits
		$hit_count2 = $hit_count1 + 1;
		// End adding hits   Start Update Hit
		$sql = "UPDATE `".$this->config["table_prefix"]."pages` SET `hits` = '$hit_count2' WHERE tag='$thispage' AND latest='Y'";
		// $sql .= " WHERE `ref` = $ref";
		mysql_query($sql) or die("Unable to process query: " . mysql_error());
	}
?>