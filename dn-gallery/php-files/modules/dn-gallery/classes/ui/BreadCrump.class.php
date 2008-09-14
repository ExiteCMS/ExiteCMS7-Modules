<?php
/*
 * ErrorPanel.class.php
 *
 * Created on April 19, 2007, 2:42 AM
 *
 */

/**
 *
 * @author Adam
 */

class BreadCrump 

{
	var $bc = array();
	var $horz = 1;
	var $rootName = 1;
	var $query = 1;

    function BreadCrump($arr = array(""),$rootName = "Root",$query = "") 
	{
		$this->bc = $arr;
		$this->horz = $horz;
		$this->rootName = $rootName;
		$this->query = $query;
    }

	function render() 
	{
		$strBC = $this->getComponent();
		echo $strBC;
	}

	function getComponent() 
	{
		global $mod;
		global $act;
		global $do;

		if ($do == "3") {$do = "4";}
		$bc = $this->bc;
		$size = sizeof($bc);
		$count = 1;
		while (list($key,$val) = each($bc)) {
			if ($key == "" || $val == "") {
				$strBC .= "<a class=\"BcmLnk\" href = '".$_SERVER["PHP_SELF"]."?mod=".$mod."&act=".$act."&ref=".$val."&do=".$do."&".$this->query."'>".$this->rootName." </A> : ";
			}
			elseif ($key != "" && $val != "") {
				if ($count < $size) {
					$strBC .= "<a class=\"BcmLnk\" href = '".$_SERVER["PHP_SELF"]."?mod=".$mod."&act=".$act."&ref=".$key."&do=".$do."&".$this->query."'>".$val."</A> >> ";
				}
				else {
					$strBC .= $val." >> ";
				}
			}
			$count++;
		}
		
		$strBC = substr($strBC,0,-4);
		return $strBC;
	}
}
?>
