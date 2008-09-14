<?php
	/**
	 * GroupAccess.class.php
	 *
	 * Created on 17 Jul 2008
	 * @generator ZDF Class Generator
	 **/
	 
	 
	 class GroupAccess extends DBObj {
	 
		var $table = "group_access";
		var $tableAlias = "Group Access";
		var $joinTable = array("access_ref" => "access_ref_id","gallery_album" => "gallery_album_id","vmt_group" => "vmt_group_id");
		var $joinClass = array("access_ref" => "AccessRef","gallery_album" => "GalleryAlbum","vmt_group" => "VmtGroup");
		var $showOnPivot = false;
		var $relationOnly = true;
		var $order = "group_access_id";
		var $caption = "group_access_id";
		var $conn = "";

		var $primary_key = "group_access_id";
		
		var $GroupAccessId = "group_access_id";
		var $GalleryAlbumId = "gallery_album_id";
		var $VmtGroupId = "vmt_group_id";
		var $AccessRefId = "access_ref_id";

		/** Constructor **/
		function &GroupAccess() {
			global $db;
			$this->conn =& $db;
			parent::DBObj($this->table,$this->primary_key,$this->conn,$this->joinTable,$this->joinClass,$this->GroupAccessId);
		}
		/** Constructor **/
		

		function setGroupAccessId($val) {
			$this->setFieldValue($this->GroupAccessId,$val);
		}
		

		function setGalleryAlbumId($val) {
			$this->setFieldValue($this->GalleryAlbumId,$val);
		}
		

		function setVmtGroupId($val) {
			$this->setFieldValue($this->VmtGroupId,$val);
		}
		

		function setAccessRefId($val) {
			$this->setFieldValue($this->AccessRefId,$val);
		}
		

		/** Return GroupAccessId by id **/
		function getGroupAccessId($pk_val) {
			if ($pk_val != "") {
				$this->setGroupAccessId($pk_val);
				$rs = $this->selectRowById();

				return $rs->fields($this->GroupAccessId);
			}
		}
		/** Return GroupAccessId by id **/
		

		/** Return GalleryAlbumId by id **/
		function getGalleryAlbumId($pk_val) {
			if ($pk_val != "") {
				$this->setGroupAccessId($pk_val);
				$rs = $this->selectRowById();

				return $rs->fields($this->GalleryAlbumId);
			}
		}
		/** Return GalleryAlbumId by id **/
		

		/** Return VmtGroupId by id **/
		function getVmtGroupId($pk_val) {
			if ($pk_val != "") {
				$this->setGroupAccessId($pk_val);
				$rs = $this->selectRowById();

				return $rs->fields($this->VmtGroupId);
			}
		}
		/** Return VmtGroupId by id **/
		

		/** Return AccessRefId by id **/
		function getAccessRefId($pk_val) {
			if ($pk_val != "") {
				$this->setGroupAccessId($pk_val);
				$rs = $this->selectRowById();

				return $rs->fields($this->AccessRefId);
			}
		}
		/** Return AccessRefId by id **/
		
		/** Return Caption by id **/
		function getCaption($pk_val) {
			if ($pk_val != "") {
				$this->setGroupAccessId($pk_val);
				$rs = $this->selectRowById();

				return $rs->fields($this->caption);
			}
		}
		/** Return Caption by id **/

		// ADD NEW METHOD BELOW THIS LINE
		function findByAlbum($id = "-1",$id2 = "-1") {
			$grp = new VmtGroup();
			
			$sql = "SELECT * FROM ".$this->table." INNER JOIN ".$grp->table." ON ".$this->table.".".$this->VmtGroupId." = ".$grp->table.".".$grp->VmtGroupId." WHERE ".$this->table.".".$this->GalleryAlbumId." = '".$id."' AND ".$this->table.".".$this->VmtGroupId." = '".$id2."'";

			return $this->selectRow($sql);
		}

		function findAllGroup($id = "-1") {
			$grp = new VmtGroup();
			
			$sql = "SELECT * FROM ".$this->table." INNER JOIN ".$grp->table." ON ".$this->table.".".$this->VmtGroupId." = ".$grp->table.".".$grp->VmtGroupId." WHERE ".$this->table.".".$this->GalleryAlbumId." = '".$id."' AND ".$this->table.".".$this->VmtGroupId." != '1' GROUP BY ".$this->table.".".$this->VmtGroupId;

			return $this->selectRow($sql);
		}

		function remove($gal,$grp) {
			$sql = "DELETE FROM ".$this->table." WHERE ".$this->GalleryAlbumId." = '".$gal."' AND ".$this->VmtGroupId." NOT IN (".$grp.")";

			$this->executeQuery($sql);
		}
		
		function getAccess($groups,$gal) {
			$gid = "";
			while (list($key,$val) = each($groups)) {
				$gid .= "'".$key."',";
			}
			$gid = substr($gid,0,-1);

			$sql = "SELECT * FROM ".$this->table." WHERE ".$this->GalleryAlbumId." = '".$gal."' AND ".$this->VmtGroupId." IN (".$gid.") ";

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