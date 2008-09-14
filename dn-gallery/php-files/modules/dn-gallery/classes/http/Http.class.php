<?php
/*
 * Http.class.php
 *
 * Created on April 16, 2007, 2:05 AM
 *
 */

/**
 *
 * @author Adam
 */

class Http {

	var $alwaysOn = array();

    function Http() 
	{

    }
	
	function submitPostVars($data) 
	{
		global $_SESSION;
		$_SESSION["POST_VARS"] = $data;
	}
	
	function stripPostVars() 
	{
		global $_POST;
		global $_SESSION;
		while (list($key,$val) = each($_SESSION["POST_VARS"])) 
		{
			$_POST[$key] = $val;
		}
		unset($_SESSION["POST_VARS"]);
	}

	function doPost($data)	
	{	
		global $appsUrl;
		global $mod;
		global $act;
		global $do;
		if ($do == 1) {
			$do = 0;
		}
		while (list($key,$val) = each($this->alwaysOn)) {
			$str .= $val."=".$data[$val]."&";
		}
		$str = substr($str,0,-1);
		$url = $appsUrl."index.php?mod=".$mod."&act=".$act."&do=".$do."&errNum=1&".$str;
		$this->submitPostVars($data);
		header("Location: ".$url);
	}  

	function setAlwaysOn($arr = array()) {
		$this->alwaysOn = $arr;
	}
	
	function extractAllPostVars() 
	{
		global $_POST;
		while (list($key,$val) = each($_POST)) 
		{
			if (!is_array($val)) {
				eval('global $'.$key.';');
				eval('$'.$key.' = "'.$val.'";');
			}
			else {
				if (sizeof($val) > 0) {
					eval('global $'.$key.';');
					eval('$'.$key.' = $_POST['.$key.'];');
				}
			}
		}
		reset($_POST);
	}   

	function getVar($var,$val = "",$post = 0) {
		global $_POST;
		global $_GET;
		if ($post == 1) {
			$ret_val = $_POST[$var];
			if ($ret_val=="") {$ret_val=$_GET[$var];}
			if ($ret_val=="") {$ret_val=$val;}
		}
		else {
			$ret_val = $_GET[$var];
			if ($ret_val=="") {$ret_val=$_POST[$var];}
			if ($ret_val=="") {$ret_val=$val;}
		}
		return $ret_val;
	}
}
?>
