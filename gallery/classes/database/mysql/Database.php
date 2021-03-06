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
 * $Id: Database.php 15632 2007-01-02 06:01:08Z jenst $
 */
?>
<?php
class MySQL_Database extends Abstract_Database {
	var $link;

	function MySQL_Database($host, $uname, $pass, $dbname) {
		$this->link = mysqli_connect($host, $uname, $pass);
		mysqli_select_db($dbname, $this->link);
	}

	function query($sql) {
		return mysqli_query($sql, MYSQLI_STORE_RESULT, $this->link);
	}

	function fetch_row($results) {
		$row = mysqli_fetch_row($results);
		return $row;
	}
}
?>
