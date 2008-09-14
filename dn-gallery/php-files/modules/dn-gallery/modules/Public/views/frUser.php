<?php
		$mydir = "var/cache/captcha/"; 
		$d = dir($mydir); 
		while($entry = $d->read()) { 
			if ($entry!= "." && $entry!= ".." && !is_dir($mydir.$entry)) { 
				unlink($mydir.$entry); 
			} 
		} 
		$d->close(); 

		$captcha = new Captcha(135,48,6,true);

		$src1 = $http->getVar("src1");
		
		$_ID = "-1";

		$obj =& new VmtUser();
		$obj->setVmtUserId($_ID);
		$list =& $obj->selectRowById();
		
		$form = new Form();
		if ($isSubmitted == 0) {
			$form->generateValues($list,0,$obj);
		}
		else {
			$form->generateValues($_POST,1,$obj);
			$errorPanel->setErrorVar($form->fields["errorVar"]);
		}
		
		if ($_ID != "") {
			$usr_grp = new VmtUserGroup();
			$usr_grp->setVmtUserId($_ID);
			$ls_usr = $usr_grp->selectRowByCriteria();
			while (!$ls_usr->EOF) {
				$usr_group[] = $ls_usr->fields($usr_grp->VmtGroupId);
				$ls_usr->MoveNext();
			}

		}
		

		$frSrc1 = new HiddenField("src1",$src1);
		$frComp1 = new HiddenField("VmtUserId",$http->getVar("VmtUserId",$form->fields[$obj->VmtUserId]));
		$frComp2 = new TextField("VmtUserNama",$http->getVar("VmtUserNama",$form->fields[$obj->VmtUserNama]),"Name");
		$frComp3 = new TextField("VmtUserLogin",$http->getVar("VmtUserLogin",$form->fields[$obj->VmtUserLogin]),"Username");
		$frComp3->setSize(20);
		$frComp4 = new Password("VmtUserPassword","","Password");
		$frComp4->setSize(20);
		$frComp5 = new Password("VmtUserPassword2","","Confirm Password");
		$frComp5->setSize(20);

		$group = new VmtGroup();
		$ls_grp = $group->selectAll();

		$frComp6 = new CheckBox("VmtGroupId","Group");
		while (!$ls_grp->EOF) {
			$frComp6->addOption($ls_grp->fields($group->VmtGroupId),$ls_grp->fields($group->VmtGroupNama));
			$ls_grp->MoveNext();
		}
		if ($_ID != "") {
			$frComp6->setSelected($usr_group);
		}
		$form->addComponent($frSrc1);
		$form->addComponent($frComp1);
		$form->addComponent($frComp2);
		$form->addComponent($frComp3);
		$form->addComponent($frComp4);
		$form->addComponent($frComp5);
		$form->addComponent($frComp6);
	?>
	