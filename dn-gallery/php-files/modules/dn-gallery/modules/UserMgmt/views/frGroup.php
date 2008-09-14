
	<?php
		
		$src1 = $http->getVar("src1");
		

		$obj =& new VmtGroup();
		$obj->setVmtGroupId($_ID);
		$list =& $obj->selectRowById();
		
		$form = new Form();
		if ($isSubmitted == 0) {
			$form->generateValues($list,0,$obj);
		}
		else {
			$form->generateValues($_POST,1,$obj);
			$errorPanel->setErrorVar($form->fields["errorVar"]);
		}

		$frSrc1 = new HiddenField("src1",$src1);
		$frComp1 = new HiddenField("VmtGroupId",$http->getVar("VmtGroupId",$form->fields[$obj->VmtGroupId]));
		$frComp2 = new TextField("VmtGroupNama",$http->getVar("VmtGroupNama",$form->fields[$obj->VmtGroupNama]),"Group");

		$form->addComponent($frSrc1);
		$form->addComponent($frComp1);
		$form->addComponent($frComp2);
	?>
	