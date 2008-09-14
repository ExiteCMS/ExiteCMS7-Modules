<?php

$src1 = $http->getVar("src1");

// Retrieve Data
$obj = new VmtGroup();
$list = $obj->findRow($src1,$limit,$show);
// Retrieve Data

$detail = new VmtGroup();

// Action Button
$actions = new Actions("formApps1");
$actions->addButton(1,"New ..",1);
$actions->addButton(2,"Edit",1);
$actions->addButton(3,"Delete",1);
$actions->setTarget("frGroup","src1=".$src1."&src2=".$src2);
// Action Button

// Data Grid
$headers = array(
			"Group");
$fields = array(
			$obj->VmtGroupNama);

$dataGrid = new DataGrid("Groups",$list,$obj,$obj->VmtGroupId,$headers,$fields);
$dataGrid->setQueryString("src1=".$src1);
$dataGrid->setActions($actions);
$dataGrid->setEditable(true);
// Data Grid


$SearchPanel = new SearchPanel();
$frSrc1 = new TextField("src1",$src1,"Group");

$SearchPanel->addComponent($frSrc1);

?>
