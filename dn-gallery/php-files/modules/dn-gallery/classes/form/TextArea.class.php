<?php

class TextArea extends Form {

	var $rows = 5;
	var $cols = 53;
	var $style = "TxtFld";

	function TextArea($name="",$value="",$label="",$required=true) {
		parent::Form($name,"",$label);

		$this->value = $value;
		$this->required = $required;
	}

	function setRows($val) {
		$this->rows = $val;
	}

	function setCols($val) {
		$this->cols = $val;
	}
	
	function setStyle($val) {
		$this->style = $val;
	}

	
	function getComponent() {
		
		$readonly = "";
		if (!$this->isEnabled()) {
			$this->style = $this->style."Dis";
			$readonly = " readonly ";
		}
		
		$comp = '<textarea class="'.$this->style.'"'.$readonly.'rows="'.$this->rows.'" cols="'.$this->cols.'" name="'.$this->name.'"'.$this->renderEvent().'>'.br2nl($this->value).'</textarea>';

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