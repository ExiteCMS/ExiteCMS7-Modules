<?php

if ($aliases = $this->LoadAliasedPages())
{
	foreach ($aliases as $pages)
	{
		print("Aliases for ".$this->Link($pages["to_tag"], "", "", 0).":<br />\n");
	
		foreach ($pages['from_tags'] as $page)
		{
			print("&middot;&nbsp;".$this->Link($page['from_tag'], "", "", 0)."<br />\n");
		}
		print("<br />");
	}
}
else
{
	print("<em>No aliased pages.</em>");
}

?>