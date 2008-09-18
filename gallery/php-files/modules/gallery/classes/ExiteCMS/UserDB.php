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
 * $Id: UserDB.php 15632 2007-01-02 06:01:08Z jenst $
 */

/* This class is written for ExiteCMS and provides full integration of the users database
 * Instead of using or duplicating memberships manually in Gallery.
 *
 * Gallery <-> ExiteCMS integratio
 * Written by Harro 'WanWizard' Verton <wanwizard@gmail.com>
 *
*/

class ExiteCMS_UserDB extends Abstract_UserDB {
	var $db;

	function ExiteCMS_UserDB() {
		global $gallery;
		$this->db = $gallery->database{"ExiteCMS"};
		$this->nobody = new NobodyUser();
		$this->everybody = new EverybodyUser();
		$this->loggedIn = new LoggedInUser();
	}

	function getUidList() {
		global $db_prefix, $locale;

		$uidList = array();
		$db = $this->db;

		$result = dbquery("select user_id from ".$db_prefix."users");
		while ($row = dbarray($result)) {
			array_push($uidList, $row['user_id']);
		}

		// add the system groups
		array_push($uidList, -0);
		array_push($uidList, -100);
		array_push($uidList, -101);
		array_push($uidList, -102);
		array_push($uidList, -103);

		// get all other groups
		$result = dbquery("select group_id from ".$db_prefix."user_groups");
		while ($row = dbarray($result)) {
			array_push($uidList, -$row['group_id']);
		}

		sort($uidList);
		return $uidList;
	}

	function getUserByUsername($username, $level=0) {

		if (!strcmp($username, $this->nobody->getUsername())) {
			return $this->nobody;
		} else if (!strcmp($username, $this->everybody->getUsername())) {
			return $this->everybody;
		} else if (!strcmp($username, $this->loggedIn->getUsername())) {
			return $this->loggedIn;
		} 

		$user = new ExiteCMS_User();
		$user->loadByUsername($username);
		return $user;
	}

	function getUserByUid($uid) {
		global $gallery;

		$userDir = $gallery->app->userDir;
		if ($uid === false) return $this->nobody;
		$user = new ExiteCMS_User();

		if ($uid > 0) {
			$user->loadByUid($uid);
		} else {
			$user->username = "@".getgroupname(abs($uid), 1 or 2);
			$user->fullname = $user->username;
			$user->uid = $uid;
		}
		return $user;
	}

}

?>
