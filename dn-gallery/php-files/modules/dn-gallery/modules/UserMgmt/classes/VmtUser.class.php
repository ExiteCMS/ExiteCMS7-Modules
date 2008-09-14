<?php
	/**
	 * VmtUser.class.php
	 *
	 * Created on 11 Nov 2007
	 * @generator ZDF Class Generator
	 **/
	 
	 
	 class VmtUser extends DBObj {
	 
		var $table = "vmt_user";
		var $tableAlias = "Vmt User";
		var $joinTable = array("");
		var $joinClass = array("");
		var $showOnPivot = false;
		var $relationOnly = true;
		var $order = "vmt_user_nama";
		var $caption = "vmt_user_nama";
		var $conn = "";

		var $primary_key = "vmt_user_id";
		
		var $VmtUserId = "vmt_user_id";
		var $VmtUserLogin = "vmt_user_login";
		var $VmtUserPassword = "vmt_user_password";
		var $VmtUserNama = "vmt_user_nama";
		var $VmtUserEmail = "vmt_user_email";
		var $IsActive = "is_active";
		var $Token = "token";
		var $TokenReset = "token_reset";

		/** Constructor **/
		function &VmtUser() {
			global $db;
			$this->conn =& $db;
			parent::DBObj($this->table,$this->primary_key,$this->conn,$this->joinTable,$this->joinClass,$this->VmtUserNama);
		}
		/** Constructor **/
		

		function setTokenReset($val) {
			$this->setFieldValue($this->TokenReset,$val);
		}
		

		function setToken($val) {
			$this->setFieldValue($this->Token,$val);
		}
		

		function setIsActive($val) {
			$this->setFieldValue($this->IsActive,$val);
		}
		

		function setVmtUserEmail($val) {
			$this->setFieldValue($this->VmtUserEmail,$val);
		}
		

		function setVmtUserId($val) {
			$this->setFieldValue($this->VmtUserId,$val);
		}
		

		function setVmtUserLogin($val) {
			$this->setFieldValue($this->VmtUserLogin,$val);
		}
		

		function setVmtUserPassword($val) {
			$this->setFieldValue($this->VmtUserPassword,$val);
		}
		

		function setVmtUserNama($val) {
			$this->setFieldValue($this->VmtUserNama,$val);
		}
		

		/** Return VmtUserId by id **/
		function getVmtUserId($pk_val) {
			if ($pk_val != "") {
				$this->setVmtUserId($pk_val);
				$rs = $this->selectRowById();

				return $rs->fields($this->VmtUserId);
			}
		}
		/** Return VmtUserId by id **/
		

		

		/** Return VmtUserLogin by id **/
		function getVmtUserLogin($pk_val) {
			if ($pk_val != "") {
				$this->setVmtUserId($pk_val);
				$rs = $this->selectRowById();

				return $rs->fields($this->VmtUserLogin);
			}
		}
		/** Return VmtUserLogin by id **/
		

		/** Return VmtUserPassword by id **/
		function getVmtUserPassword($pk_val) {
			if ($pk_val != "") {
				$this->setVmtUserId($pk_val);
				$rs = $this->selectRowById();

				return $rs->fields($this->VmtUserPassword);
			}
		}
		/** Return VmtUserPassword by id **/
		

		/** Return VmtUserNama by id **/
		function getVmtUserNama($pk_val) {
			if ($pk_val != "") {
				$this->setVmtUserId($pk_val);
				$rs = $this->selectRowById();

				return $rs->fields($this->VmtUserNama);
			}
		}
		/** Return VmtUserNama by id **/
		
		/** Return Caption by id **/
		function getCaption($pk_val) {
			if ($pk_val != "") {
				$this->setVmtUserId($pk_val);
				$rs = $this->selectRowById();

				return $rs->fields($this->caption);
			}
		}
		/** Return Caption by id **/

		// ADD NEW METHOD BELOW THIS LINE

		function getIdByLogin($val) {
			if ($val != "") {
				$this->setVmtUserLogin($val);
				$rs = $this->selectRowByCriteria();

				return $rs->fields($this->VmtUserId);
			}
		}


		function getNameByLogin($val) {
			if ($val != "") {
				$this->setVmtUserLogin($val);
				$rs = $this->selectRowByCriteria();

				return $rs->fields($this->VmtUserNama);
			}
		}

		function authenticate($user,$pass) {
			$sql = "SELECT * FROM ".$this->table." WHERE ".$this->VmtUserLogin." = '".stripslashes($user)."' AND ".$this->VmtUserPassword." = MD5('".stripslashes($pass)."') AND ".$this->table.".".$this->IsActive." = 'ACTIVE' ";
			
			$res = $this->selectRow($sql);
			if ($res->RecordCount() > 0) {
				$grpObj = new VmtGroup();

				$grp = new VmtUserGroup();
				$grp->setVmtUserId($res->fields($this->VmtUserId));
				$res2 = $grp->selectRowByCriteria();
				while (!$res2->EOF) {
					$group[$res2->fields($grp->VmtGroupId)] = $grpObj->getCaption($res2->fields($grp->VmtGroupId));
					$res2->MoveNext();
				}
			}
			return $group;
		}				
		
	
		function findRow($src1 = "",$limit,$show) {
				
			if ($src1 != "") { 
				if ($WHERE == "") {
					$WHERE .= " WHERE ".$this->VmtUserNama." LIKE '%".$src1."%' OR ".$this->VmtUserLogin." LIKE '%".$src1."%' ";
				}
				else {
					$WHERE .= " AND ".$this->VmtUserNama." LIKE '%".$src1."%' OR ".$this->VmtUserLogin." LIKE '%".$src1."%' ";
				}
			}
			
			$sql = "SELECT * FROM ".$this->table." ".$WHERE." ORDER BY ".$this->VmtUserNama;
			
			return $this->SelectRow($sql,$limit,$show);
		}	    

		function insertRow() {
			$sql = "INSERT INTO ".$this->table." VALUES (NULL,'".$this->getFieldValue($this->VmtUserLogin)."',MD5('".$this->getFieldValue($this->VmtUserPassword)."'),'".$this->getFieldValue($this->VmtUserNama)."','".$this->getFieldValue($this->VmtUserEmail)."',NULL,'".$this->getFieldValue($this->Token)."',NULL)";
			$this->executeQuery($sql);
		}

		function updateRow($id) {
			if ($this->getFieldValue($this->VmtUserPassword) != "") {
				$sql = "UPDATE ".$this->table." SET ".$this->VmtUserLogin." = '".$this->getFieldValue($this->VmtUserLogin)."',".$this->VmtUserPassword." = MD5('".$this->getFieldValue($this->VmtUserPassword)."'),".$this->VmtUserNama." = '".$this->getFieldValue($this->VmtUserNama)."',".$this->VmtUserEmail." = '".$this->getFieldValue($this->VmtUserEmail)."' WHERE ".$this->VmtUserId." = '".$id."'";
			}
			else {
				$sql = "UPDATE ".$this->table." SET ".$this->VmtUserLogin." = '".$this->getFieldValue($this->VmtUserLogin)."',".$this->VmtUserNama." = '".$this->getFieldValue($this->VmtUserNama)."',".$this->VmtUserEmail." = '".$this->getFieldValue($this->VmtUserEmail)."' WHERE ".$this->VmtUserId." = '".$id."'";
			}

			$this->executeQuery($sql);
		}

		function setActive($id) {
			$sql = "UPDATE ".$this->table." SET ".$this->IsActive." = 'ACTIVE' WHERE ".$this->VmtUserId." = '".$id."'";

			$this->executeQuery($sql);
		}

		function setDeactive($id) {
			$sql = "UPDATE ".$this->table." SET ".$this->IsActive." = NULL WHERE ".$this->VmtUserId." = '".$id."'";

			$this->executeQuery($sql);
		}
		
		function findNonAdmin() {

			$usr = new VmtUser();
			$uid = $usr->getIdByLogin($_SESSION["uid"]);

			$usr_grp = new VmtUserGroup();
			$sql = "SELECT * FROM ".$this->table." WHERE ".$this->table.".".$this->VmtUserId." NOT IN (SELECT ".$usr_grp->table.".".$usr_grp->VmtUserId." FROM ".$usr_grp->table." WHERE ".$usr_grp->VmtGroupId." = '1') AND ".$this->table.".".$this->VmtUserId." != '".$uid."' AND ".$this->table.".".$this->IsActive." = 'ACTIVE'";
			
			return $this->selectRow($sql);
		}
		
		function resetPass($uid,$token) {
			$sql = "UPDATE ".$this->table." SET ".$this->TokenReset." = '".$token."' WHERE ".$this->VmtUserId." = '".$uid."'";

			$this->executeQuery($sql);
		}
		
		function changePassword($uid,$password) {
			$sql = "UPDATE ".$this->table." SET ".$this->TokenReset." = NULL, ".$this->VmtUserPassword."=MD5('".$password."') WHERE ".$this->VmtUserId." = '".$uid."'";

			$this->executeQuery($sql);
		}
	}
	?>