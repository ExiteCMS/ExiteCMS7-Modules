<?php
	/**
	 * DBConnection.class.php
	 *
	 * Created on 20 Jun 2007
	 * @author Adam
	 **/
	 
	 
	 class DBConnection extends DBObj {
	 
		var $conn = "";
	
		function &DBConnection() {
			global $db;
			$this->conn =& $db;
			parent::DBObj(null,null,$this->conn);
		}  
		
		function connect($database,$server,$user,$password) {
			if ($database == "") {
				global $database;
			}
			if ($server == "") {
				global $server;
			}
			if ($user == "") {
				global $user;
			}
			if ($password == "") {
				global $password;
			}
			$driver="mysqlt";
			$debug=false;
			$db_temp = &ADONewConnection($driver); 
			$db_temp->debug = $debug;

			/* MySQL */
			$db_temp->PConnect($server, $user, $password, $database);
			$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;

			$this->conn =& $db_temp;
		}

		function getTables() {
			$rs = $this->conn->Execute($this->conn->metaTablesSQL);
			$fields = $rs->fields;
			while (!$rs->EOF) {
				while (list($key,$val) = each($fields)) {
					$arrTable[] = $rs->fields($key);
				}
				reset($fields);
				$rs->MoveNext();
			}

			return $arrTable;
		}

		function getColumns($table) {
			$columns = $this->conn->MetaColumns($table);
			unset($retColumn);
			while (list($key,$val) = each($columns)) {
				$obj = $val;
				$retColumn[] = $val->name;
			}

			return $retColumn;
		}

		function createInstance($tab_name) {
			
			$d = dir("./modules/");
			while (false !== ($entry = $d->read())) {
				if ($entry != "." && $entry != "..") {
					$className = eregi_replace(" ","",ucwords(strtolower(eregi_replace("_"," ",$tab_name))));
					if (file_exists("./modules/".$entry."/classes/".$className.".class.php")) {
						$path = "./modules/".$entry."/classes/".$className.".class.php";
						$strImport = 'include_once("'.$path.'");';
						$strInstance = '$instance =& new '.$className.'();';
					}
				}
			}
			$d->close();

			eval($strImport);
			eval($strInstance);

			return $instance;
		}
	}
?>