<?php
header("Content-type: text/xml");

function in_iarray ($item, $array) {
   $item = &strtoupper($item);
   foreach($array as $element) {
       if ($item == strtoupper($element)) {
           return true;
       }
   }
   return false;
}

$xml = "<map version=\"0.7.1\">\n";
$xml .= "<node TEXT=\"Recent Changes\">\n";
$xml .= "<node TEXT=\"Date\" POSITION=\"right\">\n";

if ($pages = $this->LoadRecentlyChanged())
{
	$users = array();
	$curday = "";
	$max = 20;
	// $max = $this->GetConfigValue("xml_recent_changes");
	//if ($user = $this->GetUser()) {
	//	$max = $user["changescount"];
	//} else {
	//	$max = 50;
	//}
	
	$c = 0;
	foreach ($pages as $page)
	{
		$c++;
		if (($this->HasAccess('read', $page['tag']))  && (($c <= $max) || !$max))
		{

			// day header
			list($day, $time) = explode(" ", $page["time"]);
			if ($day != $curday)
			{
				if ($curday) $xml .= "</node>\n";
				$xml .= "<node TEXT=\"$day\">\n";
				$curday = $day;
			}


            	$xml .= "<node TEXT=\"".$page["tag"]."\">\n";
			// $xml .= "<arrowlink ENDARROW=\"Default\" DESTINATION=\"Freemind_Link_".$page["user"]."\" STARTARROW=\"None\"/>\n";
            	$xml .= "</node>\n";
			if (is_array($users[$page["user"]])) {
				$u_count = count($users[$page["user"]]);
				$users[$page["user"]][$u_count] = $page["tag"];
			} else {
				$users[$page["user"]][0] = $page["user"];
				$users[$page["user"]][1] = $page["tag"];
			}

		//	if (!in_iarray($page["user"], $users)) {
		//		$users[$c] = $page["user"];
		//	} else {
		//		$u_count = count($users[$c]);
		//		$users[$c][$u_count] = $page["tag"];
		//	}
		}
	}

	$xml .= "</node></node><node TEXT=\"Author\" POSITION=\"left\">\n";
	// $pages = $this->LoadAll("select DISTINCT user from ".$this->config["table_prefix"]."pages where latest = 'Y' order by time desc");
    	foreach ($users as $user)
    	{
			$start_loop = true;
			foreach ($user as $user_page) {
				if (!$start_loop) {
					$xml .= "<node TEXT=\"".$user_page."\"/>\n";
				} else {
					$xml .= "<node TEXT=\"$user_page\">\n";
					$start_loop = false;
				}
			}				
			$xml .= "</node>\n";
		// $xml .= "<node ID=\"Freemind_Link_".$user["user"]."\" TEXT=\"".$page["user"]."\"/>\n";
	}

}
else
{
    $xml .= "<item>\n";
    $xml .= "<title>Error</title>\n";
    $xml .= "<link>".$this->Href("show")."</link>\n";
    $xml .= "<description>You're not allowed to access this information.</description>\n";
    $xml .= "</item>\n";
}

$xml .= "</node></node>\n";
$xml .= "</map>\n";

print($xml);

?>