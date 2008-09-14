<?php

class FileUpload extends Form {

	var $size = 57;
	var $maxlength = 255;
	var $style = "TxtFld";

	function FileUpload($name="",$label="",$required=true) {
		parent::Form($name,"",$label);

		$this->required = $required;
	}

	function setSize($val) {
		$this->size = $val;
	}

	function setMaxLength($val) {
		$this->maxlength = $val;
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
		
		$comp = '<input class="'.$this->style.'"'.$readonly.'size="'.$this->size.'" maxlength="'.$this->maxlength.'" type="file" name="'.$this->name.'">';

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