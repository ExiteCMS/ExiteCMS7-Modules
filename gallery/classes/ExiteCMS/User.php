<?php
/*
 * Gallery - a web based photo album viewer and editor
 * Copyright (C) 2000-2007 Bharat Mediratta
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or (at
 * your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street - Fifth Floor, Boston, MA  02110-1301, USA.
 *
 * $Id: User.php 15632 2007-01-02 06:01:08Z jenst $
 */

/* This class is written for ExiteCMS and provides full integration of the users database
 * Instead of using or duplicating memberships manually in Gallery.
 *
 * Gallery <-> ExiteCMS integration
 * Written by Harro 'WanWizard' Verton  <wanwizard@gmail.com>
 *
*/

class ExiteCMS_User extends Abstract_User {
	var $db;

	function ExiteCMS_User() {
		global $gallery;
		$this->db = $gallery->database{"ExiteCMS"};
	}

	function loadByUid($uid) {
		global $db_prefix, $locale, $settings;

		if ($uid > 0) {
			if ($row = dbarray(dbquery("SELECT user_name, user_fullname, user_email FROM ".$db_prefix."users WHERE user_id='$uid'"))) {
				$this->username = $row['user_name'];
				$this->fullname = $row['user_fullname'];
				$this->email = $row['user_email'];
				$this->uid = $uid;
				$this->isAdmin = checkgroup($settings['gallery_admingroup']);
				$this->canCreateAlbums = checkgroup($settings['gallery_admingroup']);
			} else {
				$this->uid = -1;
			}
		} else {
			switch ($uid) {
				case 0:
					$this->username = $locale['user0'];
					$this->fullname = $locale['user0'];
					$this->email = "";
					$this->uid = $uid;
					break;
				case -100:
					$this->username = $locale['usera'];
					$this->fullname = $locale['usera'];
					$this->email = "";
					$this->uid = $uid;
					break;
				case -101:
					$this->username = $locale['user1'];
					$this->fullname = $locale['user1'];
					$this->email = "";
					$this->uid = $uid;
					break;
				case -102:
					$this->username = $locale['user2'];
					$this->fullname = $locale['user2'];
					$this->email = "";
					$this->uid = $uid;
					break;
				case -103:
					$this->username = $locale['user3'];
					$this->fullname = $locale['user3'];
					$this->email = "";
					$this->uid = $uid;
					break;
				default:
					if ($row = dbarray(dbquery("SELECT group_name FROM ".$db_prefix."user_groups WHERE group_id='".abs($uid)."'"))) {
					$this->username = $row['group_name'];
					$this->fullname = $row['group_name'];
					$this->email = "";
					$this->uid = $uid;
					// WANWIZARD => Needs to be a group membership check
					$this->isAdmin = iSUPERADMIN ? 1 : 0;
					$this->canCreateAlbums = iSUPERADMIN ? 1 : 0;
				} else {
					$this->uid = -1;
				}
		}
		}
	}

	function loadByUserName($uname) {
		global $db_prefix;
		if ($row = dbarray(dbquery("SELECT user_id, user_fullname, user_email FROM ".$db_prefix."users WHERE user_name='$uname'"))) {
			$this->uid = $row['user_id'];
			$this->fullname = $row['user_fullname'];
			$this->email = $row['user_email'];
			$this->username = $uname;
		
			// WANWIZARD => Needs to be a group membership check
			$this->isAdmin = iSUPERADMIN ? 1 : 0;
			$this->canCreateAlbums = iSUPERADMIN ? 1 : 0;
		} else {
			$this->uid = -1;
		}
	}

	function isLoggedIn() {
		if ($this->uid != -1) {
			return true;
		} else {
			return false;
		}
	}
}

?>
