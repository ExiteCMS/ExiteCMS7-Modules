<?php

class ComboBox extends Form {

	var $options = array();
	var $multiple = false;
	var $selected = "";
	var $size = "";
	var $style = "TxtFld";
	
	var $keyField = "";
	var $listField = "";

	function ComboBox($name="",$label="",$required=true) {
		parent::Form($name,"",$label);

		$this->required = $required;
	}

	function setSize($val) {
		$this->size = $val;
	}

	function setMultiple($val) {
		$this->multiple = $val;
	}

	function isMultiple() {
		return $this->multiple;
	}

	function setSelected($val) {
		$this->selected = $val;
	}

	function getSelected() {
		return $this->selected;
	}
	
	function setStyle($val) {
		$this->style = $val;
	}
	
	function setKeyField($val) {
		$this->keyField = $val;
	}
	
	function setListField($val) {
		$this->listField = $val;
	}

	function addOption($key,$val) {
		$this->options[$key] = $val;
	}

	function getOption($key) {
		return $this->options[$key];
	}

	function setOptions($arr = array()) {
		$this->options = $arr;
	}

	function getOptions() {
		return $this->options;
	}
	
	function renderOptions() {
		$str = "";
		if (is_array($this->options) && sizeof($this->options) > 0 && $this->dataSource == null) {
			while (list($key,$val) = each($this->options)) {
				$sel = "";
				if ($this->selected == $key) {
					$sel = " selected";
				}
				$str .= '<option value="'.$key.'"'.$sel.'>'.$val.'</option>\n';
			}
		}
		elseif ($this->dataSource != null && $this->keyField != "") {
			if ($this->listField == "") {
				$this->listField = $this->keyField;
			}
			while (!$this->dataSource->EOF) {
				$sel = "";
				if ($this->selected == $this->dataSource->fields($this->keyField)) {
					$sel = " selected";
				}
				$str .= '<option value="'.$this->dataSource->fields($this->keyField).'"'.$sel.'>'.$this->dataSource->fields($this->listField).'</option>\n';
				
				$this->dataSource->MoveNext();
			}
		}
		return $str;
	}

	
	function getComponent() {
		$readonly = "";
		if (!$this->isEnabled()) {
			$this->style = $this->style."Dis";
			$readonly = " readonly ";
		}
		
		$multiple = "";
		if ($this->isMultiple()) {
			$multiple = " multiple ";
		}
		
		$comp = '<select class="'.$this->style.'"'.$readonly.''.$multiple.'size="'.$this->size.'" name="'.$this->name.'"'.$this->renderEvent().'>
			'.$this->renderOptions().'
			</select>';

		return $comp;
	}

	function render() {
		if ($this->isRequired()) {
			$img_req = "required.gif";
			$cap_req = "Required Field";
		}
		else {
			$img_req = "spacer.gif";
			$cap_req = "";
		}

		echo '
			
			<tr>
				<td valign="top" align="right" width="40%" nowrap>
					<img src="images/'.$img_req.'" alt="'.$cap_req.'" title="'.$cap_req.'" height="14" width="7">&nbsp;<span class="LblLev2Txt">'.$this->label.'</span>
				</td> 
				<td valign="top" nowrap align="left">
					'.$this->getComponent().'
				</td>
			</tr>
		';
	}

}
?>