<?php
/*
 * DataGrid.class.php
 *
 * Created on April 17, 2007, 1:44 AM
 *
 */

/**
 *
 * @author Adam
 */

class DataGrid {
	
	var $title = "";
	var $dataSource = "";
	var $entity = "";
	var $primaryKey = "";
	var $editable = true;

	var $actionForm = "document.formApps1";
	var $headers = "";
	var $fields = "";
	var $queryString = "";
	var $linkAction = "";
	var $breadCrump = "";
	var $useRadio = false;

	var $numberFields = "";
	var $imageFields = "";

	var $actions = "";

	var $showPager = true;

    function DataGrid(
		$title = null, $ds = null,$et = null, $pk = null, $head = null, $fld = null, $fr = "document.formApps1", $query = null,$editable = true) 
	{
		if ($title != null) 
		{
			$this->title = $title;
		}

		if ($ds != null) 
		{
			$this->dataSource = $ds;
		}

		if ($et != null) 
		{
			$this->entity = $et;
		}

		if ($pk != null)
		{
			$this->primaryKey = $pk;
		}

		if ($head != null)
		{
			$this->headers = $head;
		}

		if ($fld != null)
		{
			$this->fields = $fld;
		}

		if ($fr != null)
		{
			$this->actionForm = $fr;
		}

		if ($query != null)
		{
			$this->queryString = $query;
		}
		$this->editable = $editable;
    }
	
	function showPager($var = true) {
		$this->showPager = $var;
	}
	
	function setActions($actions) {
		$this->actions = $actions;
	}
	
	function setUseRadio($useRadio) {
		$this->useRadio = $useRadio;
	}
	
	function setTitle($title) {
		$this->title = $title;
	}
	
	function setBreadCrump($breadCrump) {
		$this->breadCrump = $breadCrump;
	}
	
	function setHeaders($arrHeader) {
		$this->headers = $arrHeader;
	}
	
	function setDataSource($ds) {
		$this->dataSource = $ds;
	}
	
	function setEntity($et) {
		$this->entity = $et;
	}
	
	function setFields($arrFields) {
		$this->fields = $arrFields;
	}
	
	function setActionForm($actionForm) {
		$this->actionForm = $actionForm;
	}

	function setQueryString($query) {
		$this->queryString = $query;
	}

	function setEditable($editable) {
		$this->editable = $editable;
	}

	function setLinkAction($field,$url,$caption,$type) {
		$this->linkAction[0] = $field;
		$this->linkAction[1] = $url;
		$this->linkAction[2] = $caption;
		$this->linkAction[3] = $type;
	}
	
	function setNumberFields($fields) {
		$this->numberFields = $fields;
	}
	
	function setImageFields($fields) {
		$this->imageFields = $fields;
	}

	function renderPager($className="") 
	{
		global $mod;
		global $act;
		global $ref;
		global $do;
		
		if ($do == 3) {
			$do = 4;
		}
		if ($className == "") {
			$className = "TblTdSrtPager";
		}
		/*echo '	
				<Tr>';
		if ($this->editable) {
			echo '
				<td colspan="'.strval(sizeof($this->headers) + 1).'" class="TblActTd">';
		}
		else {
			echo '
				<td colspan="'.strval(sizeof($this->headers)).'" class="TblActTd">';
		}*/
		echo '
				<!--TABLE NAVIGATION -->
				<div class="TblMgn">
				<table class="TblNav" border="0" cellpadding="0" cellspacing="0" width="100%" align="Center">
				<tr>
							
					<td align="right" class="'.$className.'">';
						 
		$pageUrl = $_SERVER["PHP_SELF"];
		$this->entity->renderFirst($pageUrl."?do=".$do."&mod=".$mod."&act=".$act."&ref=".$ref."&".$this->queryString,"images/table/pagination_first.gif","images/table/pagination_first_dis.gif");
		$this->entity->renderPrevious($pageUrl."?do=".$do."&mod=".$mod."&act=".$act."&ref=".$ref."&".$this->queryString,"images/table/pagination_prev.gif","images/table/pagination_prev_dis.gif");
		
		$this->entity->renderPageCombo($pageUrl."?do=".$do."&mod=".$mod."&act=".$act."&ref=".$ref."&".$this->queryString);
		$this->entity->renderNext($pageUrl."?do=".$do."&mod=".$mod."&act=".$act."&ref=".$ref."&".$this->queryString,"images/table/pagination_next.gif","images/table/pagination_next_dis.gif");
						
		$this->entity->renderLast($pageUrl."?do=".$do."&mod=".$mod."&act=".$act."&ref=".$ref."&".$this->queryString,"images/table/pagination_last.gif","images/table/pagination_last_dis.gif");
		
		echo '
					</td>
				  </tr>
				</table>
			</div>';
	}

	function render() 
	{
		global $show;
		global $ref;
		global $frType;
		$numCol = sizeof($this->headers);
		if ($this->editable) {
			$numCol++;
		}
		echo '
			<form name="formApps1" method="post" action="#">

			<input type="hidden" name="ref" value="'.$ref.'">
			<input type="hidden" name="frType" value="'.$frType.'">';

		if ($this->actions != "") {
			$this->actions->renderScript();
			echo '
				<table border="0" cellpadding="0" cellspacing="0" width="100%" align="Center">
				<tr>
					<td width="100%" align="left">';
			$this->actions->renderButton();
			echo '	</td>
					<td align="right" nowrap="nowrap">';
			if ($this->entity->getLastPageNumber() >= 1) { 
				echo '
					<B>Page '.$show.' / '.$this->entity->getLastPageNumber().'</B>';
			}
			else {
				echo '&nbsp;';
			}
			echo '
					</td>
				</tr>
				</table>';
		}
		else {
			echo '
				<table border="0" cellpadding="0" cellspacing="0" width="100%" align="Center">
				<tr>
					<td width="100%" align="left">';
			
			echo '	</td>
					<td align="right" >';
			if ($this->entity->getLastPageNumber() >= 1) { 
				echo '
					<B>Page '.$show.' / '.$this->entity->getLastPageNumber().'</B>';
			}
			else {
				echo '&nbsp;';
			}
			echo '
					</td>
				</tr>
				</table>';

		}
		echo '
				<div class="TblMgn">
				<table class="Tbl" title="'.$this->title.'" border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
				<caption class="TblTtlTxt">'.$this->title.'</caption>
				<tbody>';
		if ($this->breadCrump != "") {
			echo '
				<!-- BreadCrump -->
				<tr>
				<th colspan="'.intval($numCol + 1).'" align="left">
				'.$this->breadCrump.'
				</td></tr>
				<!-- End BreadCrump -->';
		}
		echo '
				<!--TABLE HEADER -->
				<tr>
			 ';
		if ($this->editable) {
			if (!$this->useRadio) {
			echo '
					<th class="TblColHdrSrt" scope="col" align="center"  width="3%" nowrap><div class="TblHeader"><a href="#" title="Select All"><img src="images/check_all.gif" onclick="javascript:formCheckAll('.$this->actionForm.');" border="0" style="cursor:pointer;" alt="Select All"></a><a href="#" title="Deselect All"><img src="images/uncheck_all.gif" onclick="javascript:formUnCheckAll('.$this->actionForm.');" style="cursor:pointer;" border="0" alt="Deselect All"></a></div></th>
			';
			} else {
			echo '
					<th class="TblColHdrSrt" scope="col" align="center"  width="3%"><div class="TblHeader">&nbsp;</div></th>
			';

			}
		}
		while (list($key,$val) = each($this->headers)) 
		{
			echo '
					<th class="TblColHdrSrt" scope="col" align="left" >
						<div class="TblHeader">'.$val.'</div>
					</th>';
		}
		echo '</tr>';
		$rowCount = 1;
		$rowFound = 0;
		global $limit;
		
		$startCount = ($limit * ($show - 1)) + 1;
		while (!$this->dataSource->EOF) 
		{ 
			if ($rowCount % 2 == 0) {
				$classTd = "TblTdSrt2";
			}
			else {
				$classTd = "TblTdSrt";
			}
			if ($this->linkAction[0] != "") {
				echo '<tr onmouseover="javascript:this.className=\'highlight-on\';" onmouseout="javascript:this.className=\'TblActTdLst\';">';
			}
			else {
				echo '<tr>';
			}
			if ($this->editable) {
				if ($this->useRadio) {
					echo '<td class="'.$classTd.'" align="center"  valign="top" width="30">
						<input class="Cb" type="radio" name="params[]" value="'.$this->dataSource->fields($this->primaryKey).'" onclick="javascript:strId=this.value;toggleDisableButton(this.form,this);">
					</td>';
				}
				else {
					echo '<td class="'.$classTd.'" align="center"  valign="top" width="30">
						<input class="Cb" type="checkbox" name="params[]" value="'.$this->dataSource->fields($this->primaryKey).'" onclick="javascript:toggleDisableButton(this.form,this);">
					</td>';
					
				}
			}
			while (list($key,$val) = each($this->fields)) 
			{
				if (!is_array($val)) {
					$align="left";
					$fieldValue = $this->dataSource->fields($val);
					if (in_array($val,$this->numberFields)) {
						$fieldValue = number_format($this->dataSource->fields($val),"0",",",".");
						$align="right";
					}
					elseif (in_array($val,$this->imageFields)) {
						if ($this->dataSource->fields($val) != "") {
							$fieldValue = "<img src='".$this->dataSource->fields($val)."'>";
						}
						else {
							$fieldValue = "";
						}
					}
					if ($this->linkAction[0] != "") {
						if ($this->linkAction[3] == "" || $this->linkAction[3] == 0) {
							echo '<td class="'.$classTd.'" align="'.$align.'"  valign="top" onclick="javascript:location.href=\''.$this->linkAction[1].'&ref='.$this->dataSource->fields($this->primaryKey).'\';" title="'.$this->linkAction[2].'" style="cursor:pointer;">
								'.$fieldValue.'
							</td>';
						}
						elseif ($this->linkAction[3] == 1) {
							echo '<td class="'.$classTd.'" align="'.$align.'"  valign="top" onclick="javascript:window.open(\''.$this->linkAction[1].'&ref='.$this->dataSource->fields($this->primaryKey).'&do=2\',\'Win1\',\'toolbar=0,location=0,directories=0,status=0,scrollbars=1,menubar=0,copyhistory=0,width=\'+popUpWidth+\',height=\'+popUpHeight+\',left=\'+leftPos+\',top=\'+topPos);" title="'.$this->linkAction[2].'" style="cursor:pointer;">
								'.$fieldValue.'
							</td>';
						}
					}
					else {
						echo '<td class="'.$classTd.'" align="'.$align.'"  valign="top">
							'.$fieldValue.'
						</td>';
					}
				}
				else {
					$temp_obj = $val["object"];
					$temp_obj->clearFieldValue();
					$str_param = '"'.$this->dataSource->fields($this->primaryKey).'"';
					while (list($key1,$val1) = each($val["param"])) {
						$str_param .= ',"'.$val1.'"';
					}
					$temp_eval = '$temp_value = $temp_obj->'.$val["method"].'('.$str_param.');';
					eval($temp_eval);

					
					$align="left";
					$fieldValue = $temp_value;

					if ($this->linkAction[0] != "") {
						if ($this->linkAction[3] == "" || $this->linkAction[3] == 0) {
							echo '<td class="'.$classTd.'" align="'.$align.'"  valign="top" onclick="javascript:location.href=\''.$this->linkAction[1].'&ref='.$this->dataSource->fields($this->primaryKey).'\';" title="'.$this->linkAction[2].'" style="cursor:pointer;">
								'.$temp_value.'
							</td>';
						}
						elseif ($this->linkAction[3] == 1) {
							echo '<td class="'.$classTd.'" align="'.$align.'"  valign="top" onclick="javascript:window.open(\''.$this->linkAction[1].'&ref='.$this->dataSource->fields($this->primaryKey).'&do=2\',\'Win1\',\'toolbar=0,location=0,directories=0,status=0,scrollbars=1,menubar=0,copyhistory=0,width=\'+popUpWidth+\',height=\'+popUpHeight+\',left=\'+leftPos+\',top=\'+topPos);" title="'.$this->linkAction[2].'" style="cursor:pointer;">
								'.$temp_value.'
							</td>';
						}
					}
					else {
						echo '<td class="'.$classTd.'" align="'.$align.'"  valign="top">
							'.$temp_value.'
						</td>';
					}
				}
			}
			echo '</tr>';
			$rowCount++;
			$rowFound++;
			reset($this->fields);
			$this->dataSource->MoveNext();
		}
		if ($rowFound <= 0) {

		}
		if ($this->showPager) {
echo '	
				<Tr>';

		if ($rowCount % 2 == 0) {
			$classTd = "TblTdSrt2";
		}
		else {
			$classTd = "TblTdSrt";
		}

		if ($this->editable) {
			echo '
				<td class="'.$classTd.'" colspan="'.strval(sizeof($this->headers) + 1).'">';
				
				$this->renderPager($classTd);
			
				echo '</td>';
		}
		else {
			echo '
				<td class="'.$classTd.'" colspan="'.strval(sizeof($this->headers)).'">';
			$this->renderPager($classTd);
			echo '</td>';
		}
		echo '</tr>';
		}
		echo '
			</tbody></table>
			</div>';
echo '
</form>';
		
	}
	
}
?>