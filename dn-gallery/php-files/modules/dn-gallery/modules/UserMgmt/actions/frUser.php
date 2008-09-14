<?php
		
		$src1 = $_POST["src1"];
		
		$VmtUserNama = $_POST["VmtUserNama"];
		$VmtUserLogin = $_POST["VmtUserLogin"];
		$VmtUserPassword = $_POST["VmtUserPassword"];
		$VmtUserPassword2 = $_POST["VmtUserPassword2"];
		$VmtGroupId = $_POST["VmtGroupId"];
		$VmtUserEmail = $_POST["VmtUserEmail"];
		
		$obj =& new VmtUser();

		if ($frType != "2" && $frType != "3" && $frType != "4") {
			$error = false;
		
			if ($VmtUserNama == "") {
				$error = true;
				$errorVar["VmtUserNama"] = "Name is required";
			}
		
			if ($VmtUserLogin == "") {
				$error = true;
				$errorVar["VmtUserLogin"] = "Username is required";
			}
			
			if ($VmtUserEmail == "") {
				$error = true;
				$errorVar["VmtUserEmail"] = "E-mail address is required";
			}
			else {
				$mail_error = false;
				if (!eregi("@",$VmtUserEmail)) {
					$mail_error = true;
				}
				else {
					$expl = explode("@",$VmtUserEmail);
					if (strlen($expl[0]) < 1) {
						$mail_error = true;
					}
					else {
						$expl2 = explode(".",$expl[1]);
						if (sizeof($expl2) < 2) {
							$mail_error = true;
						}
					}
				}
				if ($mail_error) {
					$errorVar["VmtUserEmail"] = "Invalid e-mail address";
					$error = true;
				}
			}

			if ($VmtUserPassword == "" && $frType != "1") {
				$error = true;
				$errorVar["VmtUserPassword"] = "Password is required";
			}
		
			if ($VmtUserPassword2 == "" && $frType != "1") {
				$error = true;
				$errorVar["VmtUserPassword2"] = "Re-type is required";
			}
		
			if (($VmtUserPassword != "") && ($VmtUserPassword2 != "") && ($VmtUserPassword != $VmtUserPassword2)) {
				$error = true;
				$errorVar["VmtUserPassword"] = "Password & Re-type Password  do not match";
			}
		
			if (sizeof($VmtGroupId) <= 0) {
				$error = true;
				$errorVar["VmtGroupId"] = "You have to choose at least one group";
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

		switch($frType) {
			case "0":
				$obj->clearFieldValue();
				$obj->setVmtUserNama($VmtUserNama);
				$obj->setVmtUserLogin($VmtUserLogin);
				$obj->setVmtUserPassword($VmtUserPassword);
				$obj->setVmtUserEmail($VmtUserEmail);
				$obj->setIsActive("ACTIVE");
				$obj->insertRow();
				

				$user_id = $obj->getLastInsertedId();
				$usr_grp = new VmtUserGroup();
				while (list($key,$val) = each($VmtGroupId)) {
					$usr_grp->clearFieldValue();
					$usr_grp->setVmtGroupId($val);
					$usr_grp->setVmtUserId($user_id);
					$usr_grp->insertRow();
				}
			break;
			case "1":
				$obj->clearFieldValue();
				$obj->setVmtUserNama($VmtUserNama);
				$obj->setVmtUserLogin($VmtUserLogin);
				$obj->setVmtUserEmail($VmtUserEmail);
				if ($VmtUserPassword != "") {
					$obj->setVmtUserPassword($VmtUserPassword);
				}
				$obj->updateRow($_ID);
				$usr_grp = new VmtUserGroup();
				$usr_grp->setVmtUserId($_ID);
				$usr_grp->deleteRowByCriteria();

				$usr_grp->clearFieldValue();
				while (list($key,$val) = each($VmtGroupId)) {
					$usr_grp->clearFieldValue();
					$usr_grp->setVmtGroupId($val);
					$usr_grp->setVmtUserId($_ID);
					$usr_grp->insertRow();
				}
			break;
			case "2":
				$src1 = $_GET["src1"];
				$params=$_POST["params"];
				if (sizeof($params) >= 1) {
					while (list($key,$val)=each($params)) {
						$obj->clearFieldValue();
						$obj->setVmtUserId($val);
						$obj->deleteRow();
					}
				}
				$obj->optimizeTable();
			break;
			case "3":
				$params=$_POST["params"];
				$src1=$_GET["src1"];
				if (sizeof($params) >= 1) {
					while (list($key,$val)=each($params)) {
						$obj->clearFieldValue();
						$obj->setActive($val);	
					}
				}
			break;
			case "4":
				$params=$_POST["params"];
				$src1=$_GET["src1"];
				if (sizeof($params) >= 1) {
					while (list($key,$val)=each($params)) {
						$obj->clearFieldValue();
						$obj->setDeactive($val);	
					}
				}
			break;
		}
		
		echo "<script>location.href='index.php?mod=".$mod."&act=lsUser&frType=0&ref=".$ref."&src1=".$src1."&do=0';</script>";
		
	?>
	