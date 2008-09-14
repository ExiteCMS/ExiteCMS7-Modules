<?php
		
		$src1 = $_POST["src1"];
		
		$VmtGroupNama = $_POST["VmtGroupNama"];
		

		$obj =& new VmtGroup();
		

		if ($frType != "2") {
			$error = false;
		
			if ($VmtGroupNama == "") {
				$error = true;
				$errorVar["VmtGroupNama"] = "Group is required";
			}
		

			if ($error) {
				$query = "";
				while (list($key,$val) = each($_POST)) {
					$query[$key] = $val;
				}
				$query["isSubmitted"] = "1";
				$query["errorVar"] = $errorVar;
				$http = new Http();
				$http->doPost($query);
				exit;
			}
		}
		

		$obj->clearFieldValue();
		$obj->setVmtGroupNama($VmtGroupNama);
		

		switch($frType) {
			case "0":
				$obj->insertRow();
				$src1 = $VmtGroupNama;
			break;
			case "1":
				$obj->updateRow($_ID);
			break;
			case "2":
				$src1 = $_GET["src1"];
				$params=$_POST["params"];
				if (sizeof($params) >= 1) {
					while (list($key,$val)=each($params)) {
						$obj->clearFieldValue();
						$obj->setVmtGroupId($val);
						$obj->deleteRow();
					}
				}
				$obj->optimizeTable();
			break;
		}
		
		echo "<script>location.href='index.php?mod=".$mod."&act=lsGroup&frType=0&ref=".$ref."&src1=".$src1."&do=0';</script>";
		
	?>
	