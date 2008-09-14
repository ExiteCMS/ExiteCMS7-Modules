<?php
/*
 * PivotTable.class.php
 *
 * Created on June 19, 2007, 2:04 AM
 *
 */

/**
 *
 * @author Adam
 */

class PivotTable {
	
	var $title = "";
	var $conn = "";
	var $tables = array();
	var $mainTable = "";
	var $rows = array();
	var $column = "";

    function PivotTable($title = "",$tables = array(),$rows = array(),$column = "") 
	{
		if (sizeof($tables) <= 0) {
			trigger_error('TABLES Not Set.', E_USER_ERROR);	
		}
		if (sizeof($rows) <= 0) {
			trigger_error('ROWS Not Set.', E_USER_ERROR);	
		}
		if ($column == "") {
			trigger_error('COLUMN Not Set.', E_USER_ERROR);	
		}

		global $db;
		$this->conn =& $db;
		$this->title = $title;
		$this->tables = $tables;
		$this->mainTable = $tables[0];
		$this->rows = $rows;
		$this->column = $column;
    }
	

	function execute($limit,$show) {
		$strTables = "";
		$tempTables = $this->tables;
		$arrJoinFields = array();
		while (list($key,$val) = each($this->tables)) {
			if (sizeof($val->joinTable) > 0) {
				while (list($key2,$val2) = each($val->joinTable)) {
					while (list($key3,$val3) = each($tempTables)) {
						if ($val3->table != $val->table) {
							if ($val3->table == $key2) {
								$joinField = $val->table.".".$val2." = ".$val3->table.".".$val3->primary_key;
								if (!in_array($joinField,$arrJoinFields)) {
									$arrJoinFields[] = $joinField;
								}
							}
						}
					}
					reset($tempTables);
				}
			}
			$strTables .= $val->table.",";
		}
		$strJoins = "";
		while (list($key,$val) = each($arrJoinFields)) {
			$strJoins .= $val." AND ";
		}
		$strJoins = substr($strJoins,0,-5);
		
		$strTables = substr($strTables,0,-1);

		$strRows = "";
		while (list($key,$val) = each($this->rows)) {
			$strRows .= $val.",";
		}

		$strRows = substr($strRows,0,-1);

		$sql = PivotTableSQL( 
					$this->conn,								# adodb connection 
					$strTables,									# tables 
					$strRows,									# rows (multiple fields allowed) 
					$this->column,								# column to pivot on 
					$strJoins									# joins/where 
				);
		return $this->mainTable->SelectRow($sql,$limit,$show);
	}
}
?>
