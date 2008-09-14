<?php
	/**
	 * VmtGroup.class.php
	 *
	 * Created on 11 Nov 2007
	 * @generator ZDF Class Generator
	 **/
	 
	 
	 class VmtGroup extends DBObj {
	 
		var $table = "vmt_group";
		var $tableAlias = "Vmt Group";
		var $joinTable = array();
		var $joinClass = array();
		var $showOnPivot = false;
		var $relationOnly = true;
		var $order = "vmt_group_id";
		var $caption = "vmt_group_nama";
		var $conn = "";

		var $primary_key = "vmt_group_id";
		
		var $VmtGroupId = "vmt_group_id";
		var $VmtGroupNama = "vmt_group_nama";

		/** Constructor **/
		function &VmtGroup() {
			global $db;
			$this->conn =& $db;
			parent::DBObj($this->table,$this->primary_key,$this->conn,$this->joinTable,$this->joinClass,$this->VmtGroupId);
		}
		/** Constructor **/
		

		function setVmtGroupId($val) {
			$this->setFieldValue($this->VmtGroupId,$val);
		}
		

		function setVmtGroupNama($val) {
			$this->setFieldValue($this->VmtGroupNama,$val);
		}
		

		/** Return VmtGroupId by id **/
		function getVmtGroupId($pk_val) {
			if ($pk_val != "") {
				$this->setVmtGroupId($pk_val);
				$rs = $this->selectRowById();

				return $rs->fields($this->VmtGroupId);
			}
		}
		/** Return VmtGroupId by id **/
		

		/** Return VmtGroupNama by id **/
		function getVmtGroupNama($pk_val) {
			if ($pk_val != "") {
				$this->setVmtGroupId($pk_val);
				$rs = $this->selectRowById();

				return $rs->fields($this->VmtGroupNama);
			}
		}
		/** Return VmtGroupNama by id **/
		
		/** Return Caption by id **/
		function getCaption($pk_val) {
			if ($pk_val != "") {
				$this->setVmtGroupId($pk_val);
				$rs = $this->selectRowById();

				return $rs->fields($this->caption);
			}
		}
		/** Return Caption by id **/

		// ADD NEW METHOD BELOW THIS LINE
		
		function findDetail($src1) {
			$usr_grp = new VmtUserGroup();

			$sql = "SELECT * FROM ".$this->table." INNER JOIN ".$usr_grp->table." ON ".$this->table.".".$this->VmtGroupId." = ".$usr_grp->table.".".$usr_grp->VmtGroupId." WHERE ".$usr_grp->table.".".$usr_grp->VmtUserId." = '".$src1."'";

			return $this->selectRow($sql);
		}
		
		function findNonAdmin() {
			$sql = "SELECT * FROM ".$this->table." WHERE ".$this->VmtGroupId." != '1'";

			return $this->selectRow($sql);
		}
		
		function findRow($src1,$limit,$show) {
			$WHERE = "WHERE ".$this->VmtGroupId." != '1' AND ".$this->VmtGroupId." != '2' ";
			if ($src1 != "") {
				$WHERE .= " AND ".$this->VmtGroupNama." LIKE '%".$src1."%' ";
			}
			$sql = "SELECT * FROM ".$this->table." ".$WHERE." ORDER BY ".$this->VmtGroupNama;

			return $this->selectRow($sql,$limit,$show);
		}
	}
	?>