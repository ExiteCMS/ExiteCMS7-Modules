<?php
	/**
	 * GalleryFile.class.php
	 *
	 * Created on 09 Jan 2008
	 * @generator ZDF Class Generator
	 **/
	 
	 
	 class GalleryFile extends DBObj {
	 
		var $table = "gallery_file";
		var $tableAlias = "Gallery File";
		var $joinTable = array("gallery_album" => "gallery_album_id");
		var $joinClass = array("gallery_album" => "GalleryAlbum");
		var $showOnPivot = false;
		var $relationOnly = true;
		var $order = "id";
		var $caption = "id";
		var $conn = "";

		var $primary_key = "id";
		
		var $Id = "id";
		var $GalleryAlbumId = "gallery_album_id";
		var $PhotoTitle = "photo_title";
		var $PhotoDesc = "photo_desc";
		var $ThumbFile = "thumb_file";
		var $FileName = "file_name";
		var $Keywords = "keywords";

		/** Constructor **/
		function &GalleryFile() {
			global $db;
			$this->conn =& $db;
			parent::DBObj($this->table,$this->primary_key,$this->conn,$this->joinTable,$this->joinClass,$this->Id);
		}
		/** Constructor **/
		

		function setKeywords($val) {
			$this->setFieldValue($this->Keywords,$val);
		}
		

		function setPhotoTitle($val) {
			$this->setFieldValue($this->PhotoTitle,$val);
		}
		

		function setPhotoDesc($val) {
			$this->setFieldValue($this->PhotoDesc,$val);
		}
		

		function setThumbFile($val) {
			$this->setFieldValue($this->ThumbFile,$val);
		}
		

		function setId($val) {
			$this->setFieldValue($this->Id,$val);
		}
		

		function setGalleryAlbumId($val) {
			$this->setFieldValue($this->GalleryAlbumId,$val);
		}
		

		function setFileName($val) {
			$this->setFieldValue($this->FileName,$val);
		}
		

		/** Return Id by id **/
		function getId($pk_val) {
			if ($pk_val != "") {
				$this->setId($pk_val);
				$rs = $this->selectRowById();

				return $rs->fields($this->Id);
			}
		}
		/** Return Id by id **/
		

		/** Return GalleryAlbumId by id **/
		function getGalleryAlbumId($pk_val) {
			if ($pk_val != "") {
				$this->setId($pk_val);
				$rs = $this->selectRowById();

				return $rs->fields($this->GalleryAlbumId);
			}
		}
		/** Return GalleryAlbumId by id **/
		

		/** Return FileName by id **/
		function getFileName($pk_val) {
			if ($pk_val != "") {
				$this->setId($pk_val);
				$rs = $this->selectRowById();

				return $rs->fields($this->FileName);
			}
		}
		/** Return FileName by id **/
		
		/** Return Caption by id **/
		function getCaption($pk_val) {
			if ($pk_val != "") {
				$this->setId($pk_val);
				$rs = $this->selectRowById();

				return $rs->fields($this->caption);
			}
		}
		/** Return Caption by id **/

		// ADD NEW METHOD BELOW THIS LINE
		function getFile($kat,$limit=4,$show=1) {
			$album = new GalleryAlbum();

			$sql = "SELECT ".$this->table.".* FROM ".$this->table." INNER JOIN ".$album->table." ON ".$this->table.".".$this->GalleryAlbumId." = ".$album->table.".".$album->GalleryAlbumId." WHERE ".$album->table.".".$album->GalleryAlbumId." = '".$kat."' AND ".$album->table.".".$album->IsActive." = 'Active' ";

			return $this->selectRow($sql,$limit,$show);
		}
		function searchFile($src1,$limit=4,$show=1) {
			$album = new GalleryAlbum();
			
			$expl = explode(',',$src1);
			$size = sizeof($expl);
			$WHERE = " WHERE ".$album->table.".".$album->IsActive." = 'Active' ";

			for ($i=0;$i<$size;$i++) {
				if (trim($expl[$i]) != "") {
					$RELATED .= " ".$this->Keywords." LIKE '%".trim($expl[$i])."%' OR ";
				}
			}
			$RELATED = substr($RELATED,0,-4);
			if (trim($RELATED) != "") {
				$WHERE = $WHERE ." AND (".$RELATED.") ";
			}

			$sql = "SELECT ".$this->table.".* FROM ".$this->table." INNER JOIN ".$album->table." ON ".$this->table.".".$this->GalleryAlbumId." = ".$album->table.".".$album->GalleryAlbumId." ".$WHERE." ";

			return $this->selectRow($sql,$limit,$show);
		}

		function getRelated($src1,$id,$limit=4,$show=1) {
			$album = new GalleryAlbum();
			
			$expl = explode(',',$src1);
			$size = sizeof($expl);
			$WHERE = " WHERE ".$album->table.".".$album->IsActive." = 'Active' ";

			for ($i=0;$i<$size;$i++) {
				if (trim($expl[$i]) != "") {
					$RELATED .= " ".$this->Keywords." LIKE '%".trim($expl[$i])."%' OR ";
				}
			}
			$RELATED = substr($RELATED,0,-4);
			if (trim($RELATED) != "") {
				$WHERE = $WHERE ." AND (".$RELATED.") AND ".$this->Id." != '".$id."'";
			}
			else {
				$WHERE = $WHERE ." AND ".$this->Id." = -1";
			}
			$sql = "SELECT ".$this->table.".* FROM ".$this->table." INNER JOIN ".$album->table." ON ".$this->table.".".$this->GalleryAlbumId." = ".$album->table.".".$album->GalleryAlbumId." ".$WHERE." ";
			
			return $this->selectRow($sql,$limit,$show);
		}

		function getRowNumber($gal_id,$photo_id) {
			$album = new GalleryAlbum();

			$sql = "SELECT COUNT(".$this->Id.") AS ROW_NUM FROM ".$this->table." INNER JOIN ".$album->table." ON ".$this->table.".".$this->GalleryAlbumId." = ".$album->table.".".$album->GalleryAlbumId." WHERE ".$this->Id." <= ".$photo_id." AND ".$this->table.".".$this->GalleryAlbumId." = '".$gal_id."' AND ".$album->table.".".$album->IsActive." = 'Active' ";

			$rs = $this->selectRow($sql);
			return $rs->fields("ROW_NUM");
		}
	}
	?>