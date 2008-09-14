<?php
/*
 * DBObj.class.php
 *
 * Created on January 3, 2006, 2:05 AM
 *
 */

/**
 *
 * @author Adam
 */

class DBObj {
	var $__table = "";
	var $__primary_key = "";
	var $__conn = "";
	var $__fields = array();
	var $__columns = "";
	var $__columns_name = "";
	var $__temp_sql = null;
	var $__last_sql = null;
	var $__last_rs = null;
	var $__row_per_page = null;
	var $__pager = null;
	var $__selected_field = array();
	var $__default_order = "";
	var $__ajax_pager = false;

	var $__joinTable = array();
	var $__joinClass = array();
    
    /** Creates a new instance of DBObj */

    function &DBObj($tableName,$primaryKey,&$db,$joinTable=array(),$joinClass=array(),$defaultOrder="") {
		if ($tableName != null && $primaryKey != null) {
			$this->__table = $tableName;
			$this->__primary_key = $primaryKey;
			$this->__conn =& $db;
			$this->__default_order = $defaultOrder;
			if ($this->__default_order == "") {
				$this->__default_order = $this->__primary_key;
			}
			$this->__columns = $this->__conn->MetaColumns($this->__table);

			$arrColumns = $this->__columns;
			while (list($key,$val) = each($arrColumns)) {
				$obj = $val;
				$retColumn[] = $val->name;
			}
			$this->__columns_name = $retColumn;

			$this->__temp_sql = "SELECT * FROM ".$this->__table;
			
			$this->__joinTable = $joinTable;
			$this->__joinClass = $joinClass;
			
			/*for ($i = 0;$i < sizeof($this->__joinTable); $i++) {
				eval('$this->__joinClass['.$this->__joinTable[$i].'] = new '.$this->__joinTable[$i].'();');			
			}*/
		}
		else {
			$this->__conn =& $db;
		}
    }

	function AjaxPager($stat=false) {
		$this->__ajax_pager = $stat;
	}

	function getColumns() {
		return $this->__columns_name;
	}

	function getJoinClass($i) {
		return $this->__joinClass[$this->__joinTable[$i]];
	}

	function getConn() 
	{
		return $this->__conn;
	}

	function setTable($val) 
	{
		$this->__table = $val;
	}

	function getTable() 
	{
		return $this->__table;
	}

	function setDefaultOrder($val) 
	{
		$this->__default_order = $val;
	}

	function getDefaultOrder() 
	{
		if ($this->__default_order == "") {
			$this->__default_order = $this->__primary_key;
		}
		return $this->__default_order;
	}

	function setFieldValue($key,$val) {
		/*if ($val == "") {
			$this->__fields[$key] = 'null';
		}
		else {*/
			$this->__fields[$key] = $val;
		//}
	}

	function setFieldsDef($key) {
		$this->__fields[$key] = "";
	}

	function getFieldsDef() {
		return $this->__fields;
	}

	function getFieldValue($key) {
		return $this->__fields[$key];
	}
	
	function __getEmptyRecordSet() {
		$sql = $this->__temp_sql;
			
		if ($this->__columns[strtoupper($this->__primary_key)]->type == "int") {
			$sql .= " WHERE ".$this->__primary_key." = -1";
		}
		else {
			$sql .= " WHERE ".$this->__primary_key." = '-1'";
		}
		return $this->__conn->Execute($sql);
	}
	
	function __getUpdateRecordSet($old_pk = null) {
		$sql = $this->__temp_sql;
		if ($old_pk != null) {	
			if ($this->__columns[strtoupper($this->__primary_key)]->type == "int") {
				$sql .= " WHERE ".$this->__primary_key." = ".$old_pk;
			}
			else {
				$sql .= " WHERE ".$this->__primary_key." = '".$old_pk."'";
			}
		}
		else {
			if ($this->__columns[strtoupper($this->__primary_key)]->type == "int") {
				$sql .= " WHERE ".$this->__primary_key." = ".$this->__fields[$this->__primary_key];
			}
			else {
				$sql .= " WHERE ".$this->__primary_key." = '".$this->__fields[$this->__primary_key]."'";
			}
		}
		return $this->__conn->Execute($sql);
	}

	function insertRow() {
		$arrIns = array();
		while (list($key,$val)=each($this->__fields)) {
			if ($this->__fields[$key] != "") {
				$arrIns[$key] = $this->__fields[$key];
			}
		}
		$rs = $this->__getEmptyRecordSet();
		
		$insertSQL = $this->__conn->GetInsertSQL($rs,$arrIns);
		reset($this->__columns);
		reset($this->__fields);
		unset($arrIns);
		unset($rs);
		if ($this->__conn->Execute($insertSQL)) {
			$this->__last_sql = $insertSQL;
			return $this->__conn->Affected_Rows();
		}
	}

	function updateRow($old_pk = null) {
		$arrUpd = array();
		while (list($key,$val)=each($this->__fields)) {
			if ($this->__fields[$key] != "") {
				$arrUpd[$key] = $this->__fields[$key];
			}
		}
		$rs = $this->__getUpdateRecordSet($old_pk);
		$updateSQL = $this->__conn->GetUpdateSQL($rs,$arrUpd);
		reset($this->__columns);
		reset($this->__fields);
		unset($arrUpd);
		unset($rs);
		if ($this->__conn->Execute($updateSQL)) {
			$this->__last_sql = $updateSQL;
			return $this->__conn->Affected_Rows();
		}
	}

	function deleteRow() {
		if ($this->__fields[$this->__primary_key] != "") {			
			if ($this->__columns[strtoupper($this->__primary_key)]->type == "int") {
				$deleteSQL = "DELETE FROM ".$this->__table." WHERE ".$this->__primary_key." = ".$this->__fields[$this->__primary_key];
			}
			else {
				$deleteSQL = "DELETE FROM ".$this->__table." WHERE ".$this->__primary_key." = '".$this->__fields[$this->__primary_key]."'";
			}
			
			if ($this->__conn->Execute($deleteSQL)) {
				$this->__last_sql = $deleteSQL;
				reset($this->__fields);
				return $this->__conn->Affected_Rows();
			}
		}
		else {
			reset($this->__fields);
			trigger_error('Prymary Key Not Set.', E_USER_ERROR);		
		}
	}
	
	function __generateCriteria() {
		$str = " WHERE ";
		while (list($key,$val) = each($this->__fields)) {
			if ($val != "") {
				if ($this->__columns[strtoupper($key)]->type == "int") {
					$str .= $key." = ".$val." AND ";
				}
				else {
					$str .= $key." = '".$val."' AND ";

				}
			}
		}
		$str = substr($str,0,-5);
		return $str;
	}

	function deleteRowByCriteria() {
		$deleteSQL = "DELETE FROM ".$this->__table.$this->__generateCriteria();
		if ($this->__conn->Execute($deleteSQL)) {
			$this->__last_sql = $deleteSQL;
			reset($this->__fields);
			return $this->__conn->Affected_Rows();
		}
	}

	function optimizeTable() {
		$optSQL = "OPTIMIZE TABLE `".$this->__table."`";
		$this->__conn->Execute($optSQL);
	}
	
	function __select($sql, $limit = "", $show = "") {
		if ($sql != "") {
			if ($limit != "") {
				if ($show != "") {
					if ($rs = $this->__conn->PageExecute($sql,$limit,$show)) {
						$this->__last_sql = $sql;
						$this->__row_per_page = $limit;
						reset($this->__fields);
						$this->__last_rs = $rs;
						return $rs;
					}
				}
				else {
					if ($rs = $this->__conn->PageExecute($sql,$limit,1)) {
						$this->__last_sql = $sql;
						$this->__row_per_page = $limit;
						reset($this->__fields);
						$this->__last_rs = $rs;
						return $rs;
					}
				}
			}
			else {
				if ($rs = $this->__conn->Execute($sql)) {
					$this->__last_sql = $sql;
					$this->__row_per_page = $limit;
					reset($this->__fields);
					$this->__last_rs = $rs;
					return $rs;
				}
			}
		}
		else {
			reset($this->__fields);
			trigger_error('<b>Select</b> Statement required '.$sql, E_USER_ERROR);	
		}
	}


	function selectAll($limit = "",$show = "") {
		$selectSQL = "SELECT * FROM ".$this->__table." ORDER BY ".$this->getDefaultOrder();

		$this->__row_per_page = $limit;
		return $this->__select($selectSQL,$limit,$show);
	}

	function selectRowByCriteria($limit = "",$show = "") {
		$selectSQL = "SELECT * FROM ".$this->__table.$this->__generateCriteria()." ORDER BY ".$this->getDefaultOrder();
		$this->__row_per_page = $limit;
		return $this->__select($selectSQL,$limit,$show);
	}

	function selectRowByID($limit = "",$show = "") {
		if ($this->__fields[$this->__primary_key] != "") {
			$tempPK = $this->__fields[$this->__primary_key];
			$this->clearFieldValue();
			$this->__fields[$this->__primary_key] = $tempPK;
			$this->__row_per_page = $limit;

			return $this->selectRowByCriteria($limit,$show);
		}
		else {
			reset($this->__fields);
			trigger_error('Prymary Key Not Set.', E_USER_ERROR);	
			//return $this->__getEmptyRecordSet();
		}
	}

	function selectRow($sql,$limit = "",$show = "") {
		$this->__row_per_page = $limit;
		return $this->__select($sql,$limit,$show);
	}

	function executeQuery($sql) {
		if ($this->__conn->Execute($sql)) {
			$this->__last_sql = $sql;
			reset($this->__fields);
			return $this->__conn->Affected_Rows();
		}
	}

	function getLastInsertedId() {
		return $this->__conn->Insert_ID();
	}

	function clearFieldValue() {		
		while (list($key,$val) = each($this->__fields)) {
			$this->__fields[$key] = "";
		}
		reset($this->__fields);
	}

	function getAffectedRows() {
		return $this->__conn->Affected_Rows();
	}

	function getLastQuery() {
		return $this->__last_sql;
	}

	function getPrimaryKey() {
		return $this->__primary_key;
	}

	function lastInsertedId() {
		return $this->__conn->Insert_ID();
	}
	
	function renderFirst($url,$img1,$img2,$div) {
		if ($this->__last_rs->AbsolutePage() > 1) {
			if (!$this->__ajax_pager) {
				$str = "<a href=\"".$url."&show=1\"><img src=\"".$img1."\" border=\"0\" align=\"absmiddle\"></a>";
			}
			else {
				$str = "<span style=\"cursor:pointer;\" onclick=\"getRequest('null','".$url."&show=1&do=9','".$div."');\"><img src=\"".$img1."\" border=\"0\" align=\"absmiddle\"></span>";
			}
		}		
		else {
			$str = "<img src=\"".$img2."\" border=\"0\" align=\"absmiddle\">";			
		}
		echo $str;
	}
	
	function renderPrevious($url,$img1,$img2,$div) {
		if ($this->__last_rs->AbsolutePage() > 1) {
			if (!$this->__ajax_pager) {
				$str = "<a href=\"".$url."&show=".intval($this->__last_rs->AbsolutePage() - 1)."\"><img src=\"".$img1."\" border=\"0\" align=\"absmiddle\"></a>";
			}
			else {
				$str = "<span style=\"cursor:pointer;\" onclick=\"getRequest('null','".$url."&show=".intval($this->__last_rs->AbsolutePage() - 1)."&do=9','".$div."');\"><img src=\"".$img1."\" border=\"0\" align=\"absmiddle\"></span>";
			}
		}		
		else {
			$str = "<img src=\"".$img2."\" border=\"0\" align=\"absmiddle\">";			
		}
		echo $str;		
	}
	
	function renderNext($url,$img1,$img2,$div) {
		if ($this->__last_rs->AbsolutePage() < $this->__last_rs->LastPageNo()) {
			if (!$this->__ajax_pager) {
				$str = "<a href=\"".$url."&show=".intval($this->__last_rs->AbsolutePage() + 1)."\"><img src=\"".$img1."\" border=\"0\" align=\"absmiddle\"></a>";
			}
			else {
				$str = "<span style=\"cursor:pointer;\" onclick=\"getRequest('null','".$url."&show=".intval($this->__last_rs->AbsolutePage() + 1)."&do=9','".$div."');\"><img src=\"".$img1."\" border=\"0\" align=\"absmiddle\"></span>";
			}
		}		
		else {
			$str = "<img src=\"".$img2."\" border=\"0\" align=\"absmiddle\">";			
		}
		echo $str;	
		
	}
	
	function renderLast($url,$img1,$img2,$div) {
		if ($this->__last_rs->AbsolutePage() < $this->__last_rs->LastPageNo()) {
			if (!$this->__ajax_pager) {
				$str = "<a href=\"".$url."&show=".$this->__last_rs->LastPageNo()."\"><img src=\"".$img1."\" border=\"0\" align=\"absmiddle\"></a>";
			}
			else {
				$str = "<span style=\"cursor:pointer;\" onclick=\"getRequest('null','".$url."&show=".$this->__last_rs->LastPageNo()."&do=9','".$div."');\"><img src=\"".$img1."\" border=\"0\" align=\"absmiddle\"></span style=\"cursor:pointer;\">";
			}
		}		
		else {
			$str = "<img src=\"".$img2."\" border=\"0\" align=\"absmiddle\">";			
		}
		echo $str;			
	}
	
	function renderPageCombo($url,$div) {
		$_this_page = $this->__last_rs->AbsolutePage();
		$min_page = $_this_page - 10;
		if ($min_page < 0) {
			$min_page = 1;
		}
		
		$max_page = $_this_page + 10;
		if ($max_page > $this->__last_rs->LastPageNo()) {
			$max_page = $this->__last_rs->LastPageNo();
		}
		if ($this->__last_rs->LastPageNo() < 1) {
			$disabled = ' disabled';
		}
		else {
			$disabled = "";
		}
		if (!$this->__ajax_pager) {
			$str = '&nbsp;&nbsp;Page&nbsp;<select name="page_combo" onchange="javascript:location.href=\''.$url.'&show=\'+this.value;" class="TxtFld"'.$disabled.'>';
		}
		else {
			$str = '&nbsp;&nbsp;Page&nbsp;<select name="page_combo" onchange="javascript:getRequest(\'null\',\''.$url.'&do=9&show=\'+this.value,\''.$div.'\');" class="TxtFld"'.$disabled.'>';
		}
		for ($i=$min_page;$i<=$max_page;$i++) {
			if ($i == $_this_page) {
				$str .= '<option value="'.$i.'" selected>'.$i.'</option>';
			}
			else {
				$str .= '<option value="'.$i.'">'.$i.'</option>';
			}
		}
		$str .= '</select>&nbsp;&nbsp;';
		
		/*if ($this->__last_rs->AbsolutePage() < $this->__last_rs->LastPageNo()) {
			$str = "<a href=\"".$url."&show=".intval($this->__last_rs->AbsolutePage() + 1)."\"><img src=\"".$img1."\" border=\"0\"></a>";
		}		
		else {
			$str = "<img src=\"".$img2."\" border=\"0\">";			
		}*/
		echo $str;	
		
	}

	function getLastPageNumber() {
		return $this->__last_rs->LastPageNo();
	}
	    
}
?>
