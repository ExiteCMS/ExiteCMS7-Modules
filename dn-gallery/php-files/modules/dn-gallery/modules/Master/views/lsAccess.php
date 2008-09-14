<?php

$src1 = $http->getVar("src1");

// Retrieve Data
$obj = new GalleryAlbum();
$list = $obj->findRowAccess($ref,$src1,$limit,$show);

$grp_access = new GroupAccess();
$usr_access = new UserAccess();

$obj2 = new VmtGroup();
$obj3 = new VmtUser();
// Retrieve Data


// Action Button
$actions = new Actions("formApps1");
$actions->addButton(2,"Set Access",1);
$actions->setTarget("frAccess","src1=".$src1);
// Action Button

$headers = array(
			"Album",
			"Date",
			"Status");
$fields = array(
			"CONTENTS",
			$obj->GalleryAlbumDate,
			$obj->IsActive);
$dataGrid = new DataGrid("Gallery",$list,$obj,$obj->GalleryAlbumId,$headers,$fields);
$dataGrid->setQueryString("src1=".$src1);
$dataGrid->setActions($actions);
// Data Grid


$SearchPanel = new SearchPanel();
$frSrc1 = new TextField("src1",$src1,"Album");
$SearchPanel->addComponent($frSrc1);


?>
