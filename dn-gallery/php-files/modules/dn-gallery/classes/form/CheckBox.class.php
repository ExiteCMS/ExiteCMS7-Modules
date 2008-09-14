<?php

class CheckBox extends Form {

	var $options = array();
	var $selected = array();
	var $style = "";
	
	var $keyField = "";
	var $listField = "";

	function CheckBox($name="",$label="",$required=true) {
		parent::Form($name,"",$label);

		$this->required = $required;
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
		$readonly = "";
		if (!$this->isEnabled()) {
			$this->style = $this->style."Dis";
			$readonly = " readonly ";
		}

		$str = "";
		if (is_array($this->options) && sizeof($this->options) > 0 && $this->dataSource == null) {
			while (list($key,$val) = each($this->options)) {
				$sel = "";
				if (in_array($key,$this->selected)) {
					$sel = " checked";
				}
				$str .= '<input class="'.$this->style.'"'.$readonly.' type="checkbox" name="'.$this->name.'[]" value="'.$key.'"'.$sel.''.$this->renderEvent().'>'.$val.'<br>';
			}
		}
		elseif ($this->dataSource != null && $this->keyField != "") {
			if ($this->listField == "") {
				$this->listField = $this->keyField;
			}
			while (!$this->dataSource->EOF) {
				$sel = "";
				if (in_array($this->dataSource->fields($this->keyField),$this->selected)) {
					$sel = " checked";
				}
				$str .= '<input class="'.$this->style.'"'.$readonly.' type="checkbox" name="'.$this->name.'['.$this->dataSource->fields($this->keyField).']" value="'.$this->dataSource->fields($this->keyField).'"'.$sel.''.$this->renderEvent().'>'.$this->dataSource->fields($this->listField).'<br>';
				
				$this->dataSource->MoveNext();
			}
		}
		return $str;
	}

	
	function getComponent() {
		
		$comp = $this->renderOptions();

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