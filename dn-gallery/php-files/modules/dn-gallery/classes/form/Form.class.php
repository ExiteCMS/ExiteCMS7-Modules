<?php
/*
 * Form.class.php
 *
 * Created on April 16, 2007, 10:18 AM
 *
 */

/**
 *
 * @author Adam
 */

class Form {
	
	var $components = array();
	var $name = "";
	var $action = "";
	var $value = "";
	var $label = "";

	var $dataSource = null;
	var $entity = null;
	var $enabled = true;
	var $required = true;
	
	var $queryString = "";

	var $event = array();

	/** get rid **/
	var $fields = "";
	var $backAction = "";
	/** get rid **/

	var $hidden = false;

	var $saveButton = "";
	var $resetButton = "";
	

    function Form($name = "",$action="",$label="") 
	{
		if ($name != "") {
			$this->name = $name;
		}
		else {
			$this->name = "formApps1";
		}
		if ($action != "") {
			$this->action = $action;
		}

		if ($label != "") {
			$this->label = $label;
		}
		else {
			$this->label = $name;
		}
    }
	
	function setSaveButton($val = "") {
		$this->saveButton = $val;
	}
	
	function setResetButton($val = "") {
		$this->resetButton = $val;
	}
	
	function setName($val = "") {
		$this->name = $val;
	}

	function getName() {
		return $this->name;
	}
	
	function setDataSource($val) {
		$this->dataSource = $val;
	}

	function getDataSource() {
		return $this->dataSource;
	}

	function setEntity($val) {
		return $this->entity;
	}

	function getEntity() {
		return $this->entity;
	}

	function setValue($val) {
		$this->value = $val;
	}

	function getValue() {
		return $this->value;
	}

	function setLabel($val) {
		$this->label = $val;
	}

	function getLabel() {
		return $this->label;
	}

	function setEnabled($val = true) {
		$this->enabled = $val;
	}

	function isEnabled() {
		return $this->enabled;
	}

	function setRequired($val = true) {
		$this->required = $val;
	}

	function isRequired() {
		return $this->required;
	}

	function addComponent($component) {
		$this->components[$component->getName()] = $component;
	}
	
	function getComponent($name = "") {
		if ($name != "") {
			return $this->components[$name];
		}
	}
	
	function getComponents() {
		return $this->components;
	}

	function addEvent($evt,$action) {
		if ($evt != "" && $action != "") {
			$this->event[$evt][] = $action;
		}
	}

	function setQueryString($val = "") {
		$this->queryString = $val;
	}

	function getQueryString() {
		return $this->queryString;
	}
	
	function isHidden() {
		return $this->hidden;
	}
	
	function renderEvent() {
		$str = "";
		while (list($key,$val) = each($this->event)) {
			$str .= $key.'="javascript:';
			while (list($key2,$val2) = each($val)) {
				$str .= $val2.';';
			}
			$str .= '"';
		}

		return $str;
	}
	
	function render() {
		global $isSubmitted;
		global $_ID;
		global $frType;
		global $ref;
		global $errorPanel;
		
		$action = "";
		if ($this->action != "") {
			$action = ' action="'.$this->action.'"';
		}
		
		$this->renderScript();

		echo '
			<form name="'.$this->name.'" enctype="multipart/form-data" method="POST"'.$action.'>
			<input type="hidden" name="isSubmitted" value="'.$isSubmitted.'">
			<input type="hidden" name="_ID" value="'.$_ID.'">
			<input type="hidden" name="frType" value="'.$frType.'">
			<input type="hidden" name="ref" value="'.$ref.'">
			';

		$this->renderAction("top");
		
		$errorPanel->render();

		echo '

			<table width="90%" align="center" border="0" cellspacing="2" cellpadding="2">
				<tr>
					<td valign="top" align="right" colspan="2">
						<div class="LblRqdDiv" style="margin: 5px 10px 5px 0px;" align="right">
							<img src="images/required.gif" alt="Required Field" height="14" width="7">&nbsp;<B>Indicates required field</B>
						</div>
					</td>
				</tr>';
		while (list($key,$val) = each($this->components)) {
			$val->render();
		}

		echo '</table>';
		
		$this->renderAction();

		echo '</form>';

	}


	/** get rid **/
	function setBackAction($action) {
		$this->backAction = $action;
	}

	function renderAction($pos = "bottom", $okName = "Save",$cancelName = " Back ") {
		if ($this->resetButton != "") {
			$cancelName = $this->resetButton;
		}
		echo '					
			<br>
			<table width="90%" align="center" cellpadding=0 cellspacing=0>';
		if ($pos == "bottom") {
			echo '<tr><td valign="middle" align="right" width="100%" bgcolor="#e9e9e9"><img src="images/spacer.gif" height="1" width="1"></td></tr>';
			echo '<tr><td valign="middle" align="right" width="100%"><img src="images/spacer.gif" height="5" width="1"></td></tr>';
		}
		echo '<tr>
					<td valign="middle" align="right">
					<input name="saveBtn" class="Btn1" 
					value="'.$okName.'" 
					onmouseover="javascript: if (this.disabled==0) this.className=\'Btn1Hov\'" 
					onmouseout="javascript: if (this.disabled==0) this.className=\'Btn1\'" 
					onblur="javascript: if (this.disabled==0) this.className=\'Btn1\'" 
					onfocus="javascript: if (this.disabled==0) this.className=\'Btn1Hov\'" 
					type="button"  onclick="javascript:submitForm(this);" tabindex=40>&nbsp;
					
					<input name="backBtn" class="Btn1" value="'.$cancelName.'" 
					onmouseover="javascript: if (this.disabled==0) this.className=\'Btn1Hov\'" 
					onmouseout="javascript: if (this.disabled==0) this.className=\'Btn1\'" 
					onblur="javascript: if (this.disabled==0) this.className=\'Btn1\'" 
					onfocus="javascript: if (this.disabled==0) this.className=\'Btn1Hov\'" 
					type="button"  
					onclick="javascript:submitForm(this);" tabindex=41></td>
				</tr>';
		
		if ($pos == "top") {
			echo '<tr><td valign="middle" align="right" width="100%"><img src="images/spacer.gif" height="5" width="1"></td></tr>';
			echo '<tr><td valign="middle" align="right" width="100%" bgcolor="#e9e9e9"><img src="images/spacer.gif" height="1" width="1"></td></tr>';
			
		}
		echo '	</table>
			';
	}


	function renderScript() {
		global $mod;
		global $act;
		global $_SERVER;
		global $history;
		if ($this->backAction != "" && !eregi("javascript:",$this->backAction)) {
			echo '
					<script>
					function submitForm(btn) {
						if (btn.name=="saveBtn") {
							btn.form.action="index.php?mod='.$mod.'&act='.$act.'&do=1";		
						}
						else if (btn.name=="backBtn") {
							btn.form.action="'.$this->backAction.'";
						}
						btn.form.submit();
					}
					</script>
			';
		}
		elseif ($this->backAction != "" && eregi("javascript:",$this->backAction)) {
			echo '
					<script>
					function submitForm(btn) {
						if (btn.name=="saveBtn") {
							btn.form.action="index.php?mod='.$mod.'&act='.$act.'&do=1";		
							btn.form.submit();
						}
						else if (btn.name=="backBtn") {
							'.eregi_replace("javascript:","",$this->backAction).';
						}
					}
					</script>
			';
		}
		else {
			echo '
					<script>
					function submitForm(btn) {
						if (btn.name=="saveBtn") {
							btn.form.action="index.php?mod='.$mod.'&act='.$act.'&do=1";		
						}
						else if (btn.name=="backBtn") {
							btn.form.action="'.$history->browsePrevious().'";
						}
						btn.form.submit();
					}
					</script>
			';
		}
	}


	function renderCombo($varName,$listSource,$fieldKey,$selected = null,$fieldCaption = null, $submit = false, $tabIndex="") {
		if ($fieldCaption == null) {
			$fieldCaption = $fieldKey;
		}
		if ($tabIndex != "") {
			$str_tab = ' tabindex="'.$tabIndex.'"';
		}
		if ($submit) {
			echo '
				<input type="hidden" name="isSubmitted" value="1">
				<select name = "'.$varName.'" class="TxtFld" onchange="javascript:this.form.submit();"'.$str_tab.'>
			';
		}
		else {
			echo '
				<select name = "'.$varName.'" class="TxtFld"'.$str_tab.'>
			';
		}
		while (!$listSource->EOF) {
			echo '
				<option value='.$listSource->fields($fieldKey);
			if ($selected == $listSource->fields($fieldKey)) {
				echo ' selected>';
			}
			else {
				echo '>';
			}
			echo $listSource->fields($fieldCaption).'</option>';

			$listSource->MoveNext();
		}
		echo '</select>';
	}

	function generateValues($data,$isSubmitted,$obj=null) 
	{
		if ($isSubmitted == 0) {
			while (list($key,$val) = each($data->fields)) {				
				$vars .= '$this->fields["'.$key.'"] = "'.$data->fields($key).'";';
			}
		}
		else {
			while (list($key,$val) = each($data)) {	
				eval('$checkField = $obj->'.$key.';');
				if ($checkField != "") { 
					if (is_array($val)) {
						while (list($key2,$val2) = each($val)) {
							$vars .= '$this->fields[$obj->'.$key.']['.$key2.'] = "'.$val2.'";';
						}
					}
					else {
						$vars .= '$this->fields[$obj->'.$key.'] = "'.$val.'";';
					}
				}
				else {
					if (is_array($val)) {
						while (list($key2,$val2) = each($val)) {
							$vars .= '$this->fields['.$key.']['.$key2.'] = "'.$val2.'";';
						}
					}
					else {
						$vars .= '$this->fields['.$key.'] = "'.$val.'";';
					}
				}
			}
		}
		eval($vars);
	}
   /** get rid **/  
}
?>
