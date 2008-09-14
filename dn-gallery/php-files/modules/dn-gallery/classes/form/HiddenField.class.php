<?php

class HiddenField extends Form {

	function HiddenField($name="",$value="") {
		parent::Form($name,"");

		$this->value = $value;
		$this->hidden = true;
	}

	function getComponent() {
		
		$comp = '<input type="hidden" name="'.$this->name.'" value="'.$this->value.'">';

		return $comp;
	}

	function render() {

		echo $this->getComponent();
	}

}
?>