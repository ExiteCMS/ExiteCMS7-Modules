<?php
/*
 * History.class.php
 *
 * Created on April 23, 2007, 11:18 PM
 *
 */

/**
 *
 * @author Adam
 */

class History {
	var $max_length = 10;

    function History() 
	{
		global $_SESSION;
		if ($_SESSION["HTTP_HISTORY"]["CURSOR"] == "" || $_SESSION["HTTP_HISTORY"]["CURSOR"] == null) {
			$_SESSION["HTTP_HISTORY"]["CURSOR"] = 0;
		}
    }
	
	function addAddress($url) 
	{
		global $_SESSION;
		global $mod;
		global $act;
		if (eregi("errNum",$url)) {
			$expl = explode("&errNum",$url);
			$url = $expl[0];
		}
		if (eregi("do=1",$url) || eregi("do=0",$url) || !eregi("do=",$url)) {
			if (!eregi($act,$_SESSION["HTTP_HISTORY"]["URL"][sizeof($_SESSION["HTTP_HISTORY"]["URL"]) -1])) 
			{
				if (sizeof($_SESSION["HTTP_HISTORY"]["URL"]) >= $this->max_length) 
				{
					for ($i=0;$i < ($this->max_length - 1);$i++) 
					{
						$_SESSION["HTTP_HISTORY"]["URL"][$i] = $_SESSION["HTTP_HISTORY"]["URL"][$i + 1];
					}
				}
				$_SESSION["HTTP_HISTORY"]["URL"][] = $url;
				$_SESSION["HTTP_HISTORY"]["CURSOR"] = sizeof($_SESSION["HTTP_HISTORY"]["URL"]) - 1;
			}
		}
	}
	
	function browsePrevious() 
	{
		if ($_SESSION["HTTP_HISTORY"]["CURSOR"] > 0) 
		{
			//$_SESSION["HTTP_HISTORY"]["CURSOR"] = $_SESSION["HTTP_HISTORY"]["CURSOR"] - 1;
			$cursor = $_SESSION["HTTP_HISTORY"]["CURSOR"] - 1;
			return $_SESSION["HTTP_HISTORY"]["URL"][$cursor];
		}
	}

	function browseNext()	
	{	
		if ($_SESSION["HTTP_HISTORY"]["CURSOR"] < ($this->max_length - 1)) 
		{
			//$_SESSION["HTTP_HISTORY"]["CURSOR"] = $_SESSION["HTTP_HISTORY"]["CURSOR"] + 1;
			$cursor = $_SESSION["HTTP_HISTORY"]["CURSOR"] + 1;
			return $_SESSION["HTTP_HISTORY"]["URL"][$cursor];
		}
	}     

	function setMaxLength($max) {
		$this->max_length = $max;
	}
}
?>
