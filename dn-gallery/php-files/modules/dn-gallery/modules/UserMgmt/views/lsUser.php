<?php
/*
 * Created on 10 Okt 06
 *
 * Author Adam
 * FileName main.php
 */

$src1 = $http->getVar("src1");
$masterValue = $http->getVar("masterValue");

// Retrieve Data
$obj = new VmtUser();
$list = $obj->findRow($src1,$limit,$show);
// Retrieve Data

$detail = new VmtGroup();

// Action Button
$actions = new Actions("formApps1");
$actions->addButton(1,"New ..",1);
$actions->addButton(2,"Edit",1);
$actions->addButton(3,"Delete",1);
$actions->addButton(7,"Activate",1,"btAktif","this.form.action='index.php?mod=UserMgmt&act=frUser&do=1&frType=3&src1=".$src1."';this.form.submit();");
$actions->addButton(7,"Deactivate",1,"btAktif2","this.form.action='index.php?mod=UserMgmt&act=frUser&do=1&frType=4&src1=".$src1."';this.form.submit();");
$actions->setTarget("frUser","src1=".$src1."&src2=".$src2);
// Action Button

// Data Grid
$headers = array(
			"Name",
			"Username",
			"E-mail",
			"Status");
$fields = array(
			$obj->VmtUserNama,
			$obj->VmtUserLogin,
			$obj->VmtUserEmail,
			$obj->IsActive);

$dataGrid = new MasterDetail("Users",$list,$obj,$obj->VmtUserId,$headers,$fields);
$dataGrid->setQueryString("src1=".$src1);
$dataGrid->setActions($actions);
$dataGrid->setEditable(true);
$dataGrid->setMasterField($obj->VmtUserId);
$dataGrid->setDetailObject($detail);
$dataGrid->setDetailMethod("findDetail");
$dataGrid->setSelected($masterValue);
$dataGrid->setDetailHeaders(
	array(
			"Group"
			)
);
$dataGrid->setDetailFields(
	array(
			$detail->VmtGroupNama
			)
);
// Data Grid


$SearchPanel = new SearchPanel();
$frSrc1 = new TextField("src1",$src1,"User");

$SearchPanel->addComponent($frSrc1);
?>
