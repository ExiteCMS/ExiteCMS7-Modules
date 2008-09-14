<?php

$src1 = $http->getVar("src1");

// Retrieve Data
$obj = new GalleryAlbum();
$list = $obj->findRowGal($ref,$src1,$limit,$show);
// Retrieve Data


// Action Button
$actions = new Actions("formApps1");
$actions->addButton(1,"New ..",1);
$actions->addButton(2,"Edit",1);
$actions->addButton(3,"Delete",1);
$actions->addButton(7,"Activate",1,"btAktif","this.form.action='index.php?mod=Master&act=frGal&do=1&frType=3&src1=".$src1."';this.form.submit();");
$actions->addButton(7,"Deactivate",1,"btAktif2","this.form.action='index.php?mod=Master&act=frGal&do=1&frType=4&src1=".$src1."';this.form.submit();");
$actions->setTarget("frGal","src1=".$src1);
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
