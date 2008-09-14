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

class MasterDetail extends DataGrid {

	var $detailObject = "";
	var $detailMethod = "";
	var $detailFields = array();
	var $detailHeaders = array();
	var $masterField = "";
	var $selected = "";


    function MasterDetail(
		$title = null, $ds = null,$et = null, $pk = null, $head = null, $fld = null, $fr = "document.formApps1", $query = null,$editable = true) 
	{
		parent::DataGrid($title, $ds,$et, $pk, $head, $fld, $fr, $query,$editable);
    }
	
	function setDetailObject($obj) {
		$this->detailObject = $obj;
	}
	
	function setDetailMethod($mtd) {
		$this->detailMethod = $mtd;
	}
	
	function setMasterField($fld) {
		$this->masterField = $fld;
	}
	
	function setDetailFields($flds) {
		$this->detailFields = $flds;
	}
	
	function setDetailHeaders($hrds) {
		$this->detailHeaders = $hrds;
	}
	
	function setSelected($val) {
		$this->selected = $val;
	}

	function render() 
	{
		global $mod;
		global $act;
		global $ref;
		global $do;
		global $frType;
		global $show;
		$pageUrl = $_SERVER["PHP_SELF"];
		$pageAction = $pageUrl."?do=".$do."&mod=".$mod."&act=".$act."&ref=".$ref."&".$this->queryString;
		$numCol = sizeof($this->headers);
		if ($this->editable) {
			$numCol++;
		}
		echo '
			<form name="formApps1" method="post" action="#">

			<input type="hidden" name="ref" value="'.$ref.'">
			<input type="hidden" name="frType" value="'.$frType.'">';

		if ($this->actions != "" && $this->editable) {
			$this->actions->renderScript();
			echo '
				<table border="0" cellpadding="0" cellspacing="0" width="100%" align="Center">
				<tr>
					<td width="50%" align="left">';
			$this->actions->renderButton();
			echo '	</td>
					<td width="50%" align="right">
					<B>Page '.$show.' / '.$this->entity->getLastPageNumber().'</B>
					</td>
				</tr>
				</table>';
		}
		else {
			echo '
				<table border="0" cellpadding="0" cellspacing="0" width="100%" align="Center">
				<tr>
					<td width="50%" align="left">';
			
			echo '	</td>
					<td width="50%" align="right">
					<B>Page '.$show.' / '.$this->entity->getLastPageNumber().'</B>
					</td>
				</tr>
				</table>';

		}
		echo '
				<input type="hidden" name="masterValue" value="'.$this->selected.'">
				<div class="TblMgn">
				<table class="Tbl" title="'.$this->title.'" border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
				<caption class="TblTtlTxt">'.$this->title.'</caption>
				<tbody>';
		if ($this->breadCrump != "") {
			if ($this->editable) {
			echo '
				<!-- BreadCrump -->
				<tr>
				<th colspan="'.$numCol.'" nowrap="nowrap" align="left">
				<B>'.$this->breadCrump.'</b>
				</td></tr>
				<!-- End BreadCrump -->';
			}
			else {
			echo '
				<!-- BreadCrump -->
				<tr>
				<th colspan="'.intval($numCol + 1).'" nowrap="nowrap" align="left">
				<B>'.$this->breadCrump.'</b>
				</td></tr>
				<!-- End BreadCrump -->';
			}
		}
		echo '
				<!--TABLE HEADER -->
				<tr>
			 ';
		if ($this->editable) {
			if (!$this->useRadio) {
			echo '
					<th class="TblColHdrSrt" scope="col" align="center" nowrap width="3%"><div class="TblHeader"><a href="#" title="Select All"><img src="images/check_all.gif" onclick="javascript:formCheckAll('.$this->actionForm.');" border="0" style="cursor:pointer;" alt="Select All"></a><a href="#" title="Deselect All"><img src="images/uncheck_all.gif" onclick="javascript:formUnCheckAll('.$this->actionForm.');" style="cursor:pointer;" border="0" alt="Deselect All"></a></div></th>
			';
			} else {
			echo '
					<th class="TblColHdrSrt" scope="col" align="center" nowrap width="3%"><div class="TblHeader">&nbsp;</div></th>
			';

			}
		}
		else {
			if (!$this->useRadio) {
			echo '
					<th class="TblColHdrSrt" scope="col" align="center" nowrap width="3%"><div class="TblHeader">&nbsp;</div></th>
			';
			} else {
			echo '
					<th class="TblColHdrSrt" scope="col" align="center" nowrap width="3%"><div class="TblHeader">&nbsp;</div></th>
			';

			}
		}
		while (list($key,$val) = each($this->headers)) 
		{
			echo '
					<th class="TblColHdrSrt" scope="col" align="left" nowrap>
						<div class="TblHeader">'.$val.'</div>
					</th>';
		}
		echo '</tr>';
		$rowCount = 1;
		$rowFound = 0;
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
					if ($this->dataSource->fields($this->primaryKey) != $this->selected) {
					echo '<td class="'.$classTd.'" align="center" nowrap valign="top" width="30">
						<input class="Cb" type="radio" name="params[]" value="'.$this->dataSource->fields($this->primaryKey).'" onclick="javascript:strId=this.value;toggleDisableButton(this.form,this);"><input type="image" src="images/expand.gif" onclick="javascript:this.form.masterValue.value=\''.$this->dataSource->fields($this->primaryKey).'\';this.form.action=\''.$pageAction.'\';this.form.submit();">
					</td>';
					}
					else {
					echo '<td class="'.$classTd.'" align="center" nowrap valign="top" width="30">
						<input class="Cb" type="radio" name="params[]" value="'.$this->dataSource->fields($this->primaryKey).'" onclick="javascript:strId=this.value;toggleDisableButton(this.form,this);"><input type="image" src="images/collapse.gif" onclick="javascript:this.form.masterValue.value=\'\';this.form.action=\''.$pageAction.'\';this.form.submit();">
					</td>';
					}
				}
				else {
					if ($this->dataSource->fields($this->primaryKey) != $this->selected) {
						echo '<td class="'.$classTd.'" align="center" nowrap valign="top" width="30">
							<input class="Cb" type="checkbox" name="params[]" value="'.$this->dataSource->fields($this->primaryKey).'" onclick="javascript:toggleDisableButton(this.form,this);"><input type="image" src="images/expand.gif" onclick="javascript:this.form.masterValue.value=\''.$this->dataSource->fields($this->primaryKey).'\';this.form.action=\''.$pageAction.'\';this.form.submit();">
						</td>';
					}
					else {
						echo '<td class="'.$classTd.'" align="center" nowrap valign="top" width="30">
							<input class="Cb" type="checkbox" name="params[]" value="'.$this->dataSource->fields($this->primaryKey).'" onclick="javascript:toggleDisableButton(this.form,this);"><input type="image" src="images/collapse.gif" onclick="javascript:this.form.masterValue.value=\'\';this.form.action=\''.$pageAction.'\';this.form.submit();">
						</td>';

					}
					
				}
			}
			else {
				if ($this->useRadio) {
					if ($this->dataSource->fields($this->primaryKey) != $this->selected) {
					echo '<td class="'.$classTd.'" align="center" nowrap valign="top" width="30">
						<input type="image" src="images/expand.gif" onclick="javascript:this.form.masterValue.value=\''.$this->dataSource->fields($this->primaryKey).'\';this.form.action=\''.$pageAction.'\';this.form.submit();">
					</td>';
					}
					else {
					echo '<td class="'.$classTd.'" align="center" nowrap valign="top" width="30">
						<input type="image" src="images/collapse.gif" onclick="javascript:this.form.masterValue.value=\'\';this.form.action=\''.$pageAction.'\';this.form.submit();">
					</td>';
					}
				}
				else {
					if ($this->dataSource->fields($this->primaryKey) != $this->selected) {
						echo '<td class="'.$classTd.'" align="center" nowrap valign="top" width="30">
							<input type="image" src="images/expand.gif" onclick="javascript:this.form.masterValue.value=\''.$this->dataSource->fields($this->primaryKey).'\';this.form.action=\''.$pageAction.'\';this.form.submit();">
						</td>';
					}
					else {
						echo '<td class="'.$classTd.'" align="center" nowrap valign="top" width="30">
							<input type="image" src="images/collapse.gif" onclick="javascript:this.form.masterValue.value=\'\';this.form.action=\''.$pageAction.'\';this.form.submit();">
						</td>';

					}
					
				}
			}
			while (list($key,$val) = each($this->fields)) 
			{
				$align="left";
				$fieldValue = $this->dataSource->fields($val);
				if (in_array($val,$this->numberFields)) {
					$fieldValue = number_format($this->dataSource->fields($val),"0",",",".");
					$align="right";
				}
				if ($this->linkAction[0] != "") {
					if ($this->linkAction[3] == "" || $this->linkAction[3] == 0) {
						echo '<td class="'.$classTd.'" align="'.$align.'" nowrap valign="top" onclick="javascript:location.href=\''.$this->linkAction[1].'&ref='.$this->dataSource->fields($this->primaryKey).'\';" title="'.$this->linkAction[2].'" style="cursor:pointer;">
							'.$fieldValue.'
						</td>';
					}
					elseif ($this->linkAction[3] == 1) {
						echo '<td class="'.$classTd.'" align="'.$align.'" nowrap valign="top" onclick="javascript:window.open(\''.$this->linkAction[1].'&ref='.$this->dataSource->fields($this->primaryKey).'&do=3\',\'Win1\',\'toolbar=0,location=0,directories=0,status=0,scrollbars=1,menubar=0,copyhistory=0,width=\'+popUpWidth+\',height=\'+popUpHeight+\',left=\'+leftPos+\',top=\'+topPos);" title="'.$this->linkAction[2].'" style="cursor:pointer;">
							'.$fieldValue.'
						</td>';
					}
				}
				else {
					echo '<td class="'.$classTd.'" align="'.$align.'" nowrap valign="top">
						'.$fieldValue.'
					</td>';
				}
			}
			echo '</tr>';
			if ($this->dataSource->fields($this->masterField) == $this->selected) { 
				if ($this->editable) {
					echo '<tr><Td>&nbsp;</td><td colspan='.intval($numCol - 1).'>';
				}
				else {
					echo '<tr><Td>&nbsp;</td><td colspan='.intval($numCol).'>';
				}
				$detail = '$listDetail = $this->detailObject->'.$this->detailMethod.'("'.$this->dataSource->fields($this->masterField).'");';
				eval($detail);
					echo '<table width="100%" border="0" cellpadding="0" cellspacing="0">';
					echo '<tr>';
					for ($det = 0;$det < sizeof($this->detailHeaders); $det++) {
						echo '<th class="TblColHdrSrt" scope="col" align="left" nowrap><div class="TblHeader">'.$this->detailHeaders[$det].'</div></th>';
					}
					echo '</tr>';
				while (!$listDetail->EOF) { 
					echo '<tr>';
					for ($det = 0;$det < sizeof($this->detailFields); $det++) {
						if (is_numeric($listDetail->fields($this->detailFields[$det]))) {
							echo '<td class="TblTdSrt2" align="right">'.number_format($listDetail->fields($this->detailFields[$det]),"0",",",".")."</td>";
						}
						else {
							echo '<td class="TblTdSrt2">'.$listDetail->fields($this->detailFields[$det])."</td>";
						}
					}
					echo '</tr>';
					$listDetail->MoveNext();
				}
					echo '</table><BR>';
				echo '</td></tr>';
			}
			$rowCount++;
			$rowFound++;
			reset($this->fields);
			$this->dataSource->MoveNext();
		}
		if ($rowFound <= 0) {

		}

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
		echo '</tr>
			</tbody></table>
			</div>';
echo '
</form>';
		
	}

	
}
?>
