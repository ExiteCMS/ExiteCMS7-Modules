<?php
	/**
	 * AccessRef.class.php
	 *
	 * Created on 17 Jul 2008
	 * @generator ZDF Class Generator
	 **/
	 
	 
	 class AccessRef extends DBObj {
	 
		var $table = "access_ref";
		var $tableAlias = "Access Ref";
		var $joinTable = array();
		var $joinClass = array();
		var $showOnPivot = false;
		var $relationOnly = true;
		var $order = "access_ref_id";
		var $caption = "access_ref_name";
		var $conn = "";

		var $primary_key = "access_ref_id";
		
		var $AccessRefId = "access_ref_id";
		var $AccessRefName = "access_ref_name";

		/** Constructor **/
		function &AccessRef() {
			global $db;
			$this->conn =& $db;
			parent::DBObj($this->table,$this->primary_key,$this->conn,$this->joinTable,$this->joinClass,$this->AccessRefId);
		}
		/** Constructor **/
		

		function setAccessRefId($val) {
			$this->setFieldValue($this->AccessRefId,$val);
		}
		

		function setAccessRefName($val) {
			$this->setFieldValue($this->AccessRefName,$val);
		}
		

		/** Return AccessRefId by id **/
		function getAccessRefId($pk_val) {
			if ($pk_val != "") {
				$this->setAccessRefId($pk_val);
				$rs = $this->selectRowById();

				return $rs->fields($this->AccessRefId);
			}
		}
		/** Return AccessRefId by id **/
		

		/** Return AccessRefName by id **/
		function getAccessRefName($pk_val) {
			if ($pk_val != "") {
				$this->setAccessRefId($pk_val);
				$rs = $this->selectRowById();

				return $rs->fields($this->AccessRefName);
			}
		}
		/** Return AccessRefName by id **/
		
		/** Return Caption by id **/
		function getCaption($pk_val) {
			if ($pk_val != "") {
				$this->setAccessRefId($pk_val);
				$rs = $this->selectRowById();

				return $rs->fields($this->caption);
			}
		}
		/** Return Caption by id **/

		// ADD NEW METHOD BELOW THIS LINE
				    
	}
	?>