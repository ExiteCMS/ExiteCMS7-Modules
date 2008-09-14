<?php
	/**
	 * Comments.class.php
	 *
	 * Created on 23 Jul 2008
	 * @generator ZDF Class Generator
	 **/
	 
	 
	 class Comments extends DBObj {
	 
		var $table = "comments";
		var $tableAlias = "Comments";
		var $joinTable = array("gallery_file" => "gallery_file_id","vmt_user" => "vmt_user_id");
		var $joinClass = array("gallery_file" => "GalleryFile","vmt_user" => "VmtUser");
		var $showOnPivot = false;
		var $relationOnly = true;
		var $order = "comments_date";
		var $caption = "comment_id";
		var $conn = "";

		var $primary_key = "comment_id";
		
		var $CommentId = "comment_id";
		var $GalleryFileId = "gallery_file_id";
		var $CommentsDetail = "comments_detail";
		var $VmtUserId = "vmt_user_id";
		var $CommentsDate = "comments_date";

		/** Constructor **/
		function &Comments() {
			global $db;
			$this->conn =& $db;
			parent::DBObj($this->table,$this->primary_key,$this->conn,$this->joinTable,$this->joinClass,$this->CommentsDate." DESC");
		}
		/** Constructor **/
		

		function setCommentId($val) {
			$this->setFieldValue($this->CommentId,$val);
		}
		

		function setGalleryFileId($val) {
			$this->setFieldValue($this->GalleryFileId,$val);
		}
		

		function setCommentsDetail($val) {
			$this->setFieldValue($this->CommentsDetail,$val);
		}
		

		function setVmtUserId($val) {
			$this->setFieldValue($this->VmtUserId,$val);
		}
		

		function setCommentsDate($val) {
			$this->setFieldValue($this->CommentsDate,$val);
		}
		

		/** Return CommentId by id **/
		function getCommentId($pk_val) {
			if ($pk_val != "") {
				$this->setCommentId($pk_val);
				$rs = $this->selectRowById();

				return $rs->fields($this->CommentId);
			}
		}
		/** Return CommentId by id **/
		

		/** Return GalleryFileId by id **/
		function getGalleryFileId($pk_val) {
			if ($pk_val != "") {
				$this->setCommentId($pk_val);
				$rs = $this->selectRowById();

				return $rs->fields($this->GalleryFileId);
			}
		}
		/** Return GalleryFileId by id **/
		

		/** Return CommentsDetail by id **/
		function getCommentsDetail($pk_val) {
			if ($pk_val != "") {
				$this->setCommentId($pk_val);
				$rs = $this->selectRowById();

				return $rs->fields($this->CommentsDetail);
			}
		}
		/** Return CommentsDetail by id **/
		

		/** Return VmtUserId by id **/
		function getVmtUserId($pk_val) {
			if ($pk_val != "") {
				$this->setCommentId($pk_val);
				$rs = $this->selectRowById();

				return $rs->fields($this->VmtUserId);
			}
		}
		/** Return VmtUserId by id **/
		

		/** Return CommentsDate by id **/
		function getCommentsDate($pk_val) {
			if ($pk_val != "") {
				$this->setCommentId($pk_val);
				$rs = $this->selectRowById();

				return $rs->fields($this->CommentsDate);
			}
		}
		/** Return CommentsDate by id **/
		
		/** Return Caption by id **/
		function getCaption($pk_val) {
			if ($pk_val != "") {
				$this->setCommentId($pk_val);
				$rs = $this->selectRowById();

				return $rs->fields($this->caption);
			}
		}
		/** Return Caption by id **/

		// ADD NEW METHOD BELOW THIS LINE
				    
	}
	?>