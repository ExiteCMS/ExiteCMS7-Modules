<?php
	/**
	 * GalleryAlbum.class.php
	 *
	 * Created on 10 Dec 2007
	 * @generator ZDF Class Generator
	 **/
	 
	 
	 class GalleryAlbum extends DBObj {
	 
		var $table = "gallery_album";
		var $tableAlias = "Full Text Content";
		var $joinTable = array("kategori" => "kategori_id");
		var $joinClass = array("kategori" => "Kategori");
		var $showOnPivot = false;
		var $relationOnly = true;
		var $order = "gallery_album_id";
		var $caption = "gallery_album_title";
		var $conn = "";

		var $primary_key = "gallery_album_id";
		
		var $GalleryAlbumId = "gallery_album_id";
		var $KategoriId = "kategori_id";
		var $GalleryAlbumTitle = "gallery_album_title";
		var $GalleryAlbumIcon = "gallery_album_icon";
		var $GalleryAlbumDesc = "gallery_album_desc";
		var $GalleryAlbumDate = "gallery_album_date";
		var $GalleryAlbumFile = "gallery_album_file";
		var $IsActive = "is_active";
		var $Access = "access";
		var $Owner = "owner";
		var $Viewed = "viewed";

		/** Constructor **/
		function &GalleryAlbum() {
			global $db;
			$this->conn =& $db;
			parent::DBObj($this->table,$this->primary_key,$this->conn,$this->joinTable,$this->joinClass,$this->GalleryAlbumDate);
		}
		/** Constructor **/
		

		function setViewed($val) {
			$this->setFieldValue($this->Viewed,$val);
		}
		

		function setOwner($val) {
			$this->setFieldValue($this->Owner,$val);
		}
		

		function setAccess($val) {
			$this->setFieldValue($this->Access,$val);
		}
		

		function setIsActive($val) {
			$this->setFieldValue($this->IsActive,$val);
		}
		

		function setGalleryAlbumId($val) {
			$this->setFieldValue($this->GalleryAlbumId,$val);
		}
		

		function setKategoriId($val) {
			$this->setFieldValue($this->KategoriId,$val);
		}
		

		function setGalleryAlbumTitle($val) {
			$this->setFieldValue($this->GalleryAlbumTitle,$val);
		}
		

		function setGalleryAlbumDesc($val) {
			$this->setFieldValue($this->GalleryAlbumDesc,$val);
		}
		

		function setGalleryAlbumIcon($val) {
			$this->setFieldValue($this->GalleryAlbumIcon,$val);
		}
		

		function setGalleryAlbumDate($val) {
			$this->setFieldValue($this->GalleryAlbumDate,$val);
		}
		

		function setGalleryAlbumFile($val) {
			$this->setFieldValue($this->GalleryAlbumFile,$val);
		}
		

		/** Return GalleryAlbumId by id **/
		function getGalleryAlbumId($pk_val) {
			if ($pk_val != "") {
				$this->setGalleryAlbumId($pk_val);
				$rs = $this->selectRowById();

				return $rs->fields($this->GalleryAlbumId);
			}
		}
		/** Return GalleryAlbumId by id **/
		

		/** Return KategoriId by id **/
		function getKategoriId($pk_val) {
			if ($pk_val != "") {
				$this->setGalleryAlbumId($pk_val);
				$rs = $this->selectRowById();

				return $rs->fields($this->KategoriId);
			}
		}
		/** Return KategoriId by id **/
		

		/** Return GalleryAlbumTitle by id **/
		function getGalleryAlbumTitle($pk_val) {
			if ($pk_val != "") {
				$this->setGalleryAlbumId($pk_val);
				$rs = $this->selectRowById();

				return $rs->fields($this->GalleryAlbumTitle);
			}
		}
		/** Return GalleryAlbumTitle by id **/
		

		/** Return GalleryAlbumDesc by id **/
		function getGalleryAlbumDesc($pk_val) {
			if ($pk_val != "") {
				$this->setGalleryAlbumId($pk_val);
				$rs = $this->selectRowById();

				return $rs->fields($this->GalleryAlbumDesc);
			}
		}
		/** Return GalleryAlbumDesc by id **/
		

		/** Return GalleryAlbumIcon by id **/
		function getGalleryAlbumIcon($pk_val) {
			if ($pk_val != "") {
				$this->setGalleryAlbumId($pk_val);
				$rs = $this->selectRowById();

				return $rs->fields($this->GalleryAlbumIcon);
			}
		}
		/** Return GalleryAlbumIcon by id **/
		

		/** Return GalleryAlbumDate by id **/
		function getGalleryAlbumDate($pk_val) {
			if ($pk_val != "") {
				$this->setGalleryAlbumId($pk_val);
				$rs = $this->selectRowById();

				return $rs->fields($this->GalleryAlbumDate);
			}
		}
		/** Return GalleryAlbumDate by id **/
		
		/** Return Caption by id **/
		function getCaption($pk_val) {
			if ($pk_val != "") {
				$this->setGalleryAlbumId($pk_val);
				$rs = $this->selectRowById();

				return $rs->fields($this->caption);
			}
		}
		/** Return Caption by id **/

		// ADD NEW METHOD BELOW THIS LINE
		function getNewest($limit = 3) {
			$WHERE = " WHERE ".$this->IsActive." = 'Active'";

			$sql = "SELECT * FROM ".$this->table." ".$WHERE." ORDER BY ".$this->GalleryAlbumDate." DESC";
			
			return $this->selectRow($sql,$limit,1);
		}

		function getActive($limit = 3) {
			$WHERE = " WHERE ".$this->IsActive." = 'Active'";

			$sql = "SELECT * FROM ".$this->table." ".$WHERE." ORDER BY ".$this->GalleryAlbumDate." DESC";
			
			return $this->selectRow($sql,$limit,1);
		}

		function findRow($limit,$show) {

			$sql = "SELECT ".$this->table.".*,CONCAT('<span style=\"color:#000080;font-weight:bold;font-size:14px;\">',".$this->GalleryAlbumTitle.",'</span>','<br />',".$this->GalleryAlbumDesc.") AS CONTENTS FROM ".$this->table." ".$WHERE." ORDER BY ".$this->GalleryAlbumDate." DESC";
			
			return $this->selectRow($sql,$limit,$show);
		}

		function findRowAll($src,$limit,$show) {
			if ($src != "") {

				$WHERE = " WHERE (".$this->GalleryAlbumTitle." LIKE '%".$src."%' OR ".$this->GalleryAlbumDesc." LIKE '%".$src."%') AND ".$this->IsActive." = 'Active'" ;
			}
			$sql = "SELECT ".$this->table.".* FROM ".$this->table." ".$WHERE." ORDER BY ".$this->GalleryAlbumDate." DESC";
			
			return $this->selectRow($sql,$limit,$show);
		}

		function getContent($limit,$show) {
			$usr_acc = new UserAccess();
			$grp_acc = new GroupAccess();
			if (!array_key_exists("1",$_SESSION["gid"]) && sizeof($_SESSION["gid"]) >= 1 && is_array($_SESSION["gid"])) {
				$usr = new VmtUser();
				$uid = $usr->getIdByLogin($_SESSION["uid"]);
				$str_grp = "";
				$grp_array = $_SESSION["gid"];
				while (list($key,$val) = each($grp_array)) {
					$str_grp .= "'".$key."',";
				}
				$str_grp = substr($str_grp,0,-1);

				$WHERE = " WHERE ((".$this->Access." = 'PUBLIC') OR (".$this->Owner." = '".$uid."' OR (".$usr_acc->VmtUserId." = '".$uid."' AND ".$usr_acc->table.".".$usr_acc->AccessRefId." = '4')  OR (".$grp_acc->VmtGroupId." IN (".$str_grp.") AND ".$grp_acc->table.".".$grp_acc->AccessRefId." = '4'))) ";
			}
			else {
				if (!array_key_exists("1",$_SESSION["gid"])) {
					$WHERE = " WHERE ".$this->Access." = 'PUBLIC' ";
				}
			}
			if ($WHERE == "") {
				$WHERE .= " WHERE ".$this->IsActive." = 'Active'";
			}
			else {
				$WHERE .= " AND ".$this->IsActive." = 'Active'";
			}
			

			$sql = "SELECT ".$this->table.".* FROM ".$this->table." LEFT OUTER JOIN ".$usr_acc->table." ON ".$this->table.".".$this->GalleryAlbumId." = ".$usr_acc->table.".".$usr_acc->GalleryAlbumId." LEFT OUTER JOIN ".$grp_acc->table." ON ".$this->table.".".$this->GalleryAlbumId." = ".$grp_acc->table.".".$usr_acc->GalleryAlbumId." ".$WHERE." GROUP BY ".$this->table.".".$this->GalleryAlbumId." ORDER BY ".$this->GalleryAlbumDate." DESC";
			
			return $this->selectRow($sql,$limit,$show);
		}

		function searchContent($src1,$limit,$show) {
			$usr_acc = new UserAccess();
			$grp_acc = new GroupAccess();
			if (!array_key_exists("1",$_SESSION["gid"]) && sizeof($_SESSION["gid"]) >= 1 && is_array($_SESSION["gid"])) {
				$usr = new VmtUser();
				$uid = $usr->getIdByLogin($_SESSION["uid"]);
				$str_grp = "";
				$grp_array = $_SESSION["gid"];
				while (list($key,$val) = each($grp_array)) {
					$str_grp .= "'".$key."',";
				}
				$str_grp = substr($str_grp,0,-1);

				$WHERE = " WHERE ((".$this->Access." = 'PUBLIC') OR (".$this->Owner." = '".$uid."' OR (".$usr_acc->VmtUserId." = '".$uid."' AND ".$usr_acc->table.".".$usr_acc->AccessRefId." = '4')  OR (".$grp_acc->VmtGroupId." IN (".$str_grp.") AND ".$grp_acc->table.".".$grp_acc->AccessRefId." = '4'))) ";
			}
			else {
				if (!array_key_exists("1",$_SESSION["gid"])) {
					$WHERE = " WHERE ".$this->Access." = 'PUBLIC' ";
				}
			}
			if ($WHERE == "") {
				$WHERE .= " WHERE ".$this->IsActive." = 'Active'";
			}
			else {
				$WHERE .= " AND ".$this->IsActive." = 'Active'";
			}
			
			if ($src1 != "") {
				if ($WHERE == "") {
					$WHERE .= " WHERE (".$this->GalleryAlbumTitle." LIKE '%".$src1."%' OR ".$this->Keywords." LIKE '%".$src1."%') ";
				}
				else {
					$WHERE .= " AND (".$this->GalleryAlbumTitle." LIKE '%".$src1."%' OR ".$this->Keywords." LIKE '%".$src1."%') ";
				}
			}

			$sql = "SELECT ".$this->table.".* FROM ".$this->table." LEFT OUTER JOIN ".$usr_acc->table." ON ".$this->table.".".$this->GalleryAlbumId." = ".$usr_acc->table.".".$usr_acc->GalleryAlbumId." LEFT OUTER JOIN ".$grp_acc->table." ON ".$this->table.".".$this->GalleryAlbumId." = ".$grp_acc->table.".".$usr_acc->GalleryAlbumId." ".$WHERE." GROUP BY ".$this->table.".".$this->GalleryAlbumId." ORDER BY ".$this->GalleryAlbumDate." DESC";
			
			return $this->selectRow($sql,$limit,$show);
		}

		function getRandom($limit,$show) {

			$usr_acc = new UserAccess();
			$grp_acc = new GroupAccess();
			if (!array_key_exists("1",$_SESSION["gid"]) && sizeof($_SESSION["gid"]) >= 1 && is_array($_SESSION["gid"])) {
				$usr = new VmtUser();
				$uid = $usr->getIdByLogin($_SESSION["uid"]);
				$str_grp = "";
				$grp_array = $_SESSION["gid"];
				while (list($key,$val) = each($grp_array)) {
					$str_grp .= "'".$key."',";
				}
				$str_grp = substr($str_grp,0,-1);

				$WHERE = " WHERE ((".$this->Access." = 'PUBLIC') OR (".$this->Owner." = '".$uid."' OR (".$usr_acc->VmtUserId." = '".$uid."' AND ".$usr_acc->table.".".$usr_acc->AccessRefId." = '4')  OR (".$grp_acc->VmtGroupId." IN (".$str_grp.") AND ".$grp_acc->table.".".$grp_acc->AccessRefId." = '4'))) ";
			}
			else {
				if (!array_key_exists("1",$_SESSION["gid"])) {
					$WHERE = " WHERE ".$this->Access." = 'PUBLIC' ";
				}
			}
			if ($WHERE == "") {
				$WHERE .= " WHERE ".$this->IsActive." = 'Active'";
			}
			else {
				$WHERE .= " AND ".$this->IsActive." = 'Active'";
			}
			

			$sql = "SELECT ".$this->table.".* FROM ".$this->table." LEFT OUTER JOIN ".$usr_acc->table." ON ".$this->table.".".$this->GalleryAlbumId." = ".$usr_acc->table.".".$usr_acc->GalleryAlbumId." LEFT OUTER JOIN ".$grp_acc->table." ON ".$this->table.".".$this->GalleryAlbumId." = ".$grp_acc->table.".".$usr_acc->GalleryAlbumId." ".$WHERE." GROUP BY ".$this->table.".".$this->GalleryAlbumId." ORDER BY RAND()";
			
			return $this->selectRow($sql,$limit,$show);
		}

		function getMostViewed($limit,$show) {
			$usr_acc = new UserAccess();
			$grp_acc = new GroupAccess();
			if (!array_key_exists("1",$_SESSION["gid"]) && sizeof($_SESSION["gid"]) >= 1 && is_array($_SESSION["gid"])) {
				$usr = new VmtUser();
				$uid = $usr->getIdByLogin($_SESSION["uid"]);
				$str_grp = "";
				$grp_array = $_SESSION["gid"];
				while (list($key,$val) = each($grp_array)) {
					$str_grp .= "'".$key."',";
				}
				$str_grp = substr($str_grp,0,-1);

				$WHERE = " WHERE ((".$this->Access." = 'PUBLIC') OR (".$this->Owner." = '".$uid."' OR (".$usr_acc->VmtUserId." = '".$uid."' AND ".$usr_acc->table.".".$usr_acc->AccessRefId." = '4')  OR (".$grp_acc->VmtGroupId." IN (".$str_grp.") AND ".$grp_acc->table.".".$grp_acc->AccessRefId." = '4'))) ";
			}
			else {
				if (!array_key_exists("1",$_SESSION["gid"])) {
					$WHERE = " WHERE ".$this->Access." = 'PUBLIC' ";
				}
			}
			if ($WHERE == "") {
				$WHERE .= " WHERE ".$this->IsActive." = 'Active' AND ".$this->Viewed." > 0 ";
			}
			else {
				$WHERE .= " AND ".$this->IsActive." = 'Active' AND ".$this->Viewed."  > 0 ";
			}
			

			$sql = "SELECT ".$this->table.".* FROM ".$this->table." LEFT OUTER JOIN ".$usr_acc->table." ON ".$this->table.".".$this->GalleryAlbumId." = ".$usr_acc->table.".".$usr_acc->GalleryAlbumId." LEFT OUTER JOIN ".$grp_acc->table." ON ".$this->table.".".$this->GalleryAlbumId." = ".$grp_acc->table.".".$usr_acc->GalleryAlbumId." ".$WHERE." GROUP BY ".$this->table.".".$this->GalleryAlbumId." ORDER BY ".$this->Viewed." DESC";
			return $this->selectRow($sql,$limit,$show);
		}
		
		function countRow() {
			$sql = "SELECT COUNT(".$this->GalleryAlbumId.") AS TOTAL FROM ".$this->table." WHERE ".$this->IsActive." = 'Active'";

			$rs = $this->selectRow($sql);

			return $rs->fields("TOTAL");
		}

		function findRowGal($kat,$src1,$limit,$show) {
			$usr_acc = new UserAccess();
			$grp_acc = new GroupAccess();
			if (!array_key_exists("1",$_SESSION["gid"]) && sizeof($_SESSION["gid"]) >= 1 && is_array($_SESSION["gid"])) {
				$usr = new VmtUser();
				$uid = $usr->getIdByLogin($_SESSION["uid"]);
				$str_grp = "";
				$grp_array = $_SESSION["gid"];
				while (list($key,$val) = each($grp_array)) {
					$str_grp .= "'".$key."',";
				}
				$str_grp = substr($str_grp,0,-1);

				$WHERE = " WHERE (".$this->Owner." = '".$uid."' OR (".$usr_acc->VmtUserId." = '".$uid."' AND ".$usr_acc->table.".".$usr_acc->AccessRefId." IN ('1','2','3'))  OR (".$grp_acc->VmtGroupId." IN (".$str_grp.") AND ".$grp_acc->table.".".$grp_acc->AccessRefId." IN ('1','2','3'))) ";
			}
			if ($src1 != "") {
				if ($WHERE == "") {
					$WHERE .= " WHERE ".$this->GalleryAlbumTitle." LIKE '%".$src1."%' ";
				}
				else {
					$WHERE .= " AND ".$this->GalleryAlbumTitle." LIKE '%".$src1."%' ";
				}
			}
			$sql = "SELECT ".$this->table.".*,CONCAT('<span style=\"color:#000080;font-weight:bold;font-size:14px;\">',".$this->GalleryAlbumTitle.",'</span>','<br />',".$this->GalleryAlbumDesc.") AS CONTENTS FROM ".$this->table." LEFT OUTER JOIN ".$usr_acc->table." ON ".$this->table.".".$this->GalleryAlbumId." = ".$usr_acc->table.".".$usr_acc->GalleryAlbumId." LEFT OUTER JOIN ".$grp_acc->table." ON ".$this->table.".".$this->GalleryAlbumId." = ".$grp_acc->table.".".$usr_acc->GalleryAlbumId." ".$WHERE." GROUP BY ".$this->table.".".$this->GalleryAlbumId." ORDER BY ".$this->GalleryAlbumDate." DESC";
			
			return $this->selectRow($sql,$limit,$show);
		}
		
		function findRowAccess($kat,$src1,$limit,$show) {
			$usr_acc = new UserAccess();
			$grp_acc = new GroupAccess();
			if (!array_key_exists("1",$_SESSION["gid"]) && sizeof($_SESSION["gid"]) >= 1 && is_array($_SESSION["gid"])) {
				$usr = new VmtUser();
				$uid = $usr->getIdByLogin($_SESSION["uid"]);

				$WHERE = " WHERE ".$this->Owner." = '".$uid."' ";
			}
			if ($src1 != "") {
				if ($WHERE == "") {
					$WHERE .= " WHERE ".$this->GalleryAlbumTitle." LIKE '%".$src1."%' ";
				}
				else {
					$WHERE .= " AND ".$this->GalleryAlbumTitle." LIKE '%".$src1."%' ";
				}
			}
			$sql = "SELECT ".$this->table.".*,CONCAT('<span style=\"color:#000080;font-weight:bold;font-size:14px;\">',".$this->GalleryAlbumTitle.",'</span>','<br />',".$this->GalleryAlbumDesc.") AS CONTENTS FROM ".$this->table." ".$WHERE." ORDER BY ".$this->GalleryAlbumDate." DESC";
			
			return $this->selectRow($sql,$limit,$show);
		}

		function updateViewed($id) {
			$sql = "UPDATE ".$this->table." SET ".$this->Viewed." = (".$this->Viewed." + 1) WHERE ".$this->GalleryAlbumId." = '".$id."'";
			$this->executeQuery($sql);
		}
	}
	?>