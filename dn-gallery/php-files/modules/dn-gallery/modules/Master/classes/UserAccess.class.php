<?php
	/**
	 * UserAccess.class.php
	 *
	 * Created on 17 Jul 2008
	 * @generator ZDF Class Generator
	 **/
	 
	 
	 class UserAccess extends DBObj {
	 
		var $table = "user_access";
		var $tableAlias = "User Access";
		var $joinTable = array("access_ref" => "access_ref_id","gallery_album" => "gallery_album_id","vmt_user" => "vmt_user_id");
		var $joinClass = array("access_ref" => "AccessRef","gallery_album" => "GalleryAlbum","vmt_user" => "VmtUser");
		var $showOnPivot = false;
		var $relationOnly = true;
		var $order = "user_access_id";
		var $caption = "user_access_id";
		var $conn = "";

		var $primary_key = "user_access_id";
		
		var $UserAccessId = "user_access_id";
		var $GalleryAlbumId = "gallery_album_id";
		var $VmtUserId = "vmt_user_id";
		var $AccessRefId = "access_ref_id";

		/** Constructor **/
		function &UserAccess() {
			global $db;
			$this->conn =& $db;
			parent::DBObj($this->table,$this->primary_key,$this->conn,$this->joinTable,$this->joinClass,$this->UserAccessId);
		}
		/** Constructor **/
		

		function setUserAccessId($val) {
			$this->setFieldValue($this->UserAccessId,$val);
		}
		

		function setGalleryAlbumId($val) {
			$this->setFieldValue($this->GalleryAlbumId,$val);
		}
		

		function setVmtUserId($val) {
			$this->setFieldValue($this->VmtUserId,$val);
		}
		

		function setAccessRefId($val) {
			$this->setFieldValue($this->AccessRefId,$val);
		}
		

		/** Return UserAccessId by id **/
		function getUserAccessId($pk_val) {
			if ($pk_val != "") {
				$this->setUserAccessId($pk_val);
				$rs = $this->selectRowById();

				return $rs->fields($this->UserAccessId);
			}
		}
		/** Return UserAccessId by id **/
		

		/** Return GalleryAlbumId by id **/
		function getGalleryAlbumId($pk_val) {
			if ($pk_val != "") {
				$this->setUserAccessId($pk_val);
				$rs = $this->selectRowById();

				return $rs->fields($this->GalleryAlbumId);
			}
		}
		/** Return GalleryAlbumId by id **/
		

		/** Return VmtUserId by id **/
		function getVmtUserId($pk_val) {
			if ($pk_val != "") {
				$this->setUserAccessId($pk_val);
				$rs = $this->selectRowById();

				return $rs->fields($this->VmtUserId);
			}
		}
		/** Return VmtUserId by id **/
		

		/** Return AccessRefId by id **/
		function getAccessRefId($pk_val) {
			if ($pk_val != "") {
				$this->setUserAccessId($pk_val);
				$rs = $this->selectRowById();

				return $rs->fields($this->AccessRefId);
			}
		}
		/** Return AccessRefId by id **/
		
		/** Return Caption by id **/
		function getCaption($pk_val) {
			if ($pk_val != "") {
				$this->setUserAccessId($pk_val);
				$rs = $this->selectRowById();

				return $rs->fields($this->caption);
			}
		}
		/** Return Caption by id **/

		// ADD NEW METHOD BELOW THIS LINE
		function findByAlbum($id = "-1",$id2 = "-1") {
			$grp = new VmtUser();
			
			$sql = "SELECT * FROM ".$this->table." INNER JOIN ".$grp->table." ON ".$this->table.".".$this->VmtUserId." = ".$grp->table.".".$grp->VmtUserId." WHERE ".$this->table.".".$this->GalleryAlbumId." = '".$id."' AND ".$this->table.".".$this->VmtUserId." = '".$id2."'";

			return $this->selectRow($sql);
		}

		function findAllUser($id = "-1") {
			$usr_grp = new VmtUserGroup();

			$usr = new VmtUser();
			$uid = $usr->getIdByLogin($_SESSION["uid"]);

			$grp = new VmtUser();
			
			$sql = "SELECT * FROM ".$this->table." INNER JOIN ".$grp->table." ON ".$this->table.".".$this->VmtUserId." = ".$grp->table.".".$grp->VmtUserId."  WHERE ".$this->table.".".$this->GalleryAlbumId." = '".$id."' AND ".$this->table.".".$this->VmtUserId." != '".$uid."' AND ".$grp->table.".".$grp->IsActive." = 'ACTIVE' AND ".$this->table.".".$this->VmtUserId." NOT IN (SELECT ".$usr_grp->table.".".$usr_grp->VmtUserId." FROM ".$usr_grp->table." WHERE ".$usr_grp->table.".".$usr_grp->VmtGroupId." = '1') GROUP BY ".$this->table.".".$this->VmtUserId;
			
			return $this->selectRow($sql);
		}

		function remove($gal,$usr) {
			$sql = "DELETE FROM ".$this->table." WHERE ".$this->GalleryAlbumId." = '".$gal."' AND ".$this->VmtUserId." NOT IN (".$usr.")";

			$this->executeQuery($sql);
		}
		
		function getAccess($login,$gal) {
			$usr = new VmtUser();
			$uid = $usr->getIdByLogin($login);

			$sql = "SELECT * FROM ".$this->table." WHERE ".$this->GalleryAlbumId." = '".$gal."' AND ".$this->VmtUserId." = '".$uid."' ";

			$rs = $this->selectRow($sql);

			$priv["INSERT"] = false;
			$priv["EDIT"] = false;
			$priv["DELETE"] = false;
			$priv["READ_ONLY"] = false;
			while (!$rs->EOF) {
				switch($rs->fields($this->AccessRefId)) {
					case 1:
						$priv["INSERT"] = true;
					break;
					case 2:
						$priv["EDIT"] = true;
					break;
					case 3:
						$priv["DELETE"] = true;
					break;
					case 4:
						$priv["READ_ONLY"] = true;
					break;
				}	
				$rs->MoveNext();
			}

			return $priv;
		}
	}
	?>