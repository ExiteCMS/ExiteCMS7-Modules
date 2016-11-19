<?php
    /*
        @filename:        mostvisited.php
        @author:         George Petsagourakis
        @email:         petsagouris@hotmail.com
        @date:            24 Dec 2004
        @license:        GPL

            @description:     this file assumes that you are running
                            the counter.php by GmBowen on your Wakka
                            // config vars //
                                $hitlist_limit : how many pages are going to be displayed in the list.
                                $table_alignment : accepts the values that the "align" attr of a <table> accepts.
                                $show_ranking : show the numbers on the side of the list ( starting from 1 ).
                                $show_owner : show the page"s owner along with the page title.
                                $show_current_version_hits : show the hits that the page received in its current version.

        @usage:         insert {{mostvisited}} any where in a wakka page.
    */
    // Configuration variables ...
    $hitlist_limit = isset($vars['length']) ? $vars['length'] : 10;
    $table_alignment = isset($vars['align']) ? $vars['align'] : "center";
    $show_header = isset($vars['header']) && strtolower($vars['header']) == "yes" ? true : false;
    $show_ranking = isset($vars['rank']) && strtolower($vars['rank']) == "no" ? false : true;
    $show_owner = isset($vars['owner']) && strtolower($vars['owner']) == "no" ? false : true;
    $show_current_version_hits = isset($vars['cvhits']) && strtolower($vars['cvhits']) == "no" ? false	 : true;

    // mysql query ...
    $hitlistQuery = $this->Query( "SELECT id,hits,tag,owner,latest FROM ".$this->config['table_prefix']."pages; " );

    // initialising variables ...
    $hitlist = array();
    $i = 0;

    // assign the resultset of the msyql query to $hitlist in a custom way ...
    while( $row = mysqli_fetch_array($hitlistQuery) )
    {
        if (!$hitlist[$row['tag']]){
            $hitlist[$row['tag']] = array("owner" => $row['owner'],"hits" => $row['hits']);
            if ($row['latest'] == "Y")
				$hitlist[$row['tag']]['latest'] = $row['hits']+0;
			else
				$hitlist[$row['tag']]['latest'] = "N/A";
        }
        else {
            $hitlist[$row['tag']]['hits'] += $row['hits'];
            if ( ($row['latest'] == "Y") && (!$hitlist[$row['latest']]) ) $hitlist[$row['tag']]['latest'] = $row['hits'];
        }
    }

    // sorting the array ...
	if (!function_exists("hitlistsort")) {
		function hitlistsort( $a, $b ) {
			if ($a['hits'] == $b['hits']) return 0;
			return ($a['hits'] > $b['hits']) ? -1 : 1;
		}
	}
    uasort($hitlist, "hitlistsort");

    // creating the output ...
	if ($show_header)
	{
	    $str = "<table align=\"".$table_alignment."\">\n";
	    $str .= "\t<tr>\n";
	    $str .= "\t\t<td align=\"center\"><h4>Most Visited Pages</h4></td>\n";
	    $str .= "\t</tr>\n";
	    $str .= "</table>";
	}
	else {
		$str = "";
	}

    $str .= "<table align=\"".$table_alignment."\" cellpadding='2' cellspacing='1' class='tbl-border'>\n";
    $str .= "\t<tr>\n";
    if ($show_ranking) $str .= "\t\t<th align=\"center\" class='tbl2'>Rank</th>\n";
    $str .= "\t\t<th align=\"center\" class='tbl2'>PageName</th>\n";
    if ($show_owner) $str .= "\t\t<th align=\"center\" class='tbl2'>Owner</th>\n";
    if ($show_current_version_hits) $str .= "\t\t<th align=\"center\" class='tbl2'>Current Version</th>\n";
    $str .= "\t\t<th align=\"center\" class='tbl2'>Total Hits</th>\n";
    $str .= "\t</tr>\n";
    // creating the listing ...
	$i = 0;
    foreach($hitlist as $pag => $arr){

        if ( ($i < $hitlist_limit) && ( $arr['hits'] !== 0) )
        {
            $str .= "\t<tr>\n";
            $i++;
            if ($show_ranking)
			{
                $str .= "\t\t<td class='tbl2' align=\"right\">".$i."</td>\n";
			}
            $str .= "\t\t<td class='tbl1'>".$this->Link($pag)."</td>\n";
            if ($show_owner)
			{
            	$arr['owner'] = ($arr['owner'] == "") ? "<span class='small'>not owned</span>" : $arr['owner'];
				if ($arr['owner'] == "(Public)") $arr['owner'] = "<span class='small'>".$arr['owner']."</span>";
	            $str .= "\t\t<td align=\"center\" class='tbl1'>".$arr['owner']."</td>\n";
			}
            if ($show_current_version_hits)
			{
                $str .= "\t\t<td class='tbl1' align=\"center\">".$arr['latest']."</td>\n";
			}
            $str .= "\t\t<td class='tbl1' align=\"center\">".$arr['hits']."</td>\n";
            $str .= "\t</tr>\n";
        }
        else break;

    }
    $str .= "</table>";
    // displaying the output ...
    print $this->ReturnSafeHTML($str);
?>
