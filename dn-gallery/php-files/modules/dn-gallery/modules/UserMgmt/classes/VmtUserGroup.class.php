<?php
	/**
	 * VmtUserGroup.class.php
	 *
	 * Created on 11 Nov 2007
	 * @generator ZDF Class Generator
	 **/
	 
	 
	 class VmtUserGroup extends DBObj {
	 
		var $table = "vmt_user_group";
		var $tableAlias = "Vmt User Group";
		var $joinTable = array("vmt_group" => "vmt_group_id","vmt_user" => "vmt_user_id");
		var $joinClass = array("vmt_group" => "VmtGroup","vmt_user" => "VmtUser");
		var $showOnPivot = false;
		var $relationOnly = true;
		var $order = "vmt_user_group_id";
		var $caption = "vmt_user_group_id";
		var $conn = "";

		var $primary_key = "vmt_user_group_id";
		
		var $VmtUserGroupId = "vmt_user_group_id";
		var $VmtGroupId = "vmt_group_id";
		var $VmtUserId = "vmt_user_id";

		/** Constructor **/
		function &VmtUserGroup() {
			global $db;
			$this->conn =& $db;
			parent::DBObj($this->table,$this->primary_key,$this->conn,$this->joinTable,$this->joinClass,$this->VmtUserGroupId);
		}
		/** Constructor **/
		

		function setVmtUserGroupId($val) {
			$this->setFieldValue($this->VmtUserGroupId,$val);
		}
		

		function setVmtGroupId($val) {
			$this->setFieldValue($this->VmtGroupId,$val);
		}
		

		function setVmtUserId($val) {
			$this->setFieldValue($this->VmtUserId,$val);
		}
		

		/** Return VmtUserGroupId by id **/
		function getVmtUserGroupId($pk_val) {
			if ($pk_val != "") {
				$this->setVmtUserGroupId($pk_val);
				$rs = $this->selectRowById();

				return $rs->fields($this->VmtUserGroupId);
			}
		}
		/** Return VmtUserGroupId by id **/
		

		/** Return VmtGroupId by id **/
		function getVmtGroupId($pk_val) {
			if ($pk_val != "") {
				$this->setVmtUserGroupId($pk_val);
				$rs = $this->selectRowById();

				return $rs->fields($this->VmtGroupId);
			}
		}
		/** Return VmtGroupId by id **/
		

		/** Return VmtUserId by id **/
		function getVmtUserId($pk_val) {
			if ($pk_val != "") {
				$this->setVmtUserGroupId($pk_val);
				$rs = $this->selectRowById();

				return $rs->fields($this->VmtUserId);
			}
		}
		/** Return VmtUserId by id **/
		
		/** Return Caption by id **/
		function getCaption($pk_val) {
			if ($pk_val != "") {
				$this->setVmtUserGroupId($pk_val);
				$rs = $this->selectRowById();

				return $rs->fields($this->caption);
			}
		}
		/** Return Caption by id **/

		// ADD NEW METHOD BELOW THIS LINE
				    
	}
	?>