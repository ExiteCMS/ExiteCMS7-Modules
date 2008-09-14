<?php

class PopupSelector extends TextField {
	
	var $keyField = "";
	var $keyValue = "";

	var $popupModule = "";
	var $popupAction = "";
	var $is_reset = true;

	var $buttonCaption = array("Browse ...","Reset");

	function PopupSelector($name="",$value="",$label="",$required=true) {
		parent::TextField($name,$value,$label,$required);

		global $mod;
		global $act;

		$this->popupModule = $mod;
		$this->popupAction = "sr".substr($act,2,strlen($act));
		$this->setEnabled(false);
	}
	
	function reset($val) {
		$this->is_reset = $val;
	}
	
	function setKeyField($val) {
		$this->keyField = $val;
	}
	
	function setKeyValue($val) {
		$this->keyValue = $val;
	}
	
	function setPopupModule($val) {
		$this->popupModule = $val;
	}
	
	function setPopupAction($val) {
		$this->popupAction = $val;
	}
	
	function setButtonCaption($val1,$val2) {
		if ($val1 != "") {
			$this->buttonCaption[0] = $val1;
		}
		if ($val2 != "") {
			$this->buttonCaption[1] = $val2;
		}
	}

	
	function getComponent() {
		
		$readonly = "";
		if (!$this->isEnabled()) {
			$this->style = $this->style."Dis";
			$readonly = " readonly ";
		}
		
		$comp = '<input type="hidden" name="'.$this->keyField.'" value="'.$this->keyValue.'">
					<input class="'.$this->style.'"'.$readonly.'size="'.$this->size.'" maxlength="'.$this->maxlength.'" type="text" name="'.$this->name.'" value="'.$this->value.'"'.$this->renderEvent().'>
				
					<input name="browseBtn" class="Btn1" 
					value="'.$this->buttonCaption[0].'" 
					onmouseover="javascript: if (this.disabled==0) this.className=\'Btn1Hov\'" 
					onmouseout="javascript: if (this.disabled==0) this.className=\'Btn1\'" 
					onblur="javascript: if (this.disabled==0) this.className=\'Btn1\'" 
					onfocus="javascript: if (this.disabled==0) this.className=\'Btn1Hov\'" 
					type="button"   
					 onclick="javascript:window.open(\'index.php?mod='.$this->popupModule.'&act='.$this->popupAction.'&frParent=\'+this.form.name+\'&frField=\'+this.form.'.$this->keyField.'.name+\'&do=3\',\'Win1\',\'toolbar=0,location=0,directories=0,status=0,scrollbars=1,menubar=0,copyhistory=0,width=\'+popUpWidth+\',height=\'+popUpHeight+\',left=\'+leftPos+\',top=\'+topPos);"
					>
		';
		if ($this->is_reset) {
			$comp .= '		<input name="clearBtn" class="Btn1" 
					value="'.$this->buttonCaption[1].'" 
					onmouseover="javascript: if (this.disabled==0) this.className=\'Btn1Hov\'" 
					onmouseout="javascript: if (this.disabled==0) this.className=\'Btn1\'" 
					onblur="javascript: if (this.disabled==0) this.className=\'Btn1\'" 
					onfocus="javascript: if (this.disabled==0) this.className=\'Btn1Hov\'" 
					type="button"   
					 onclick="javascript:this.form.'.$this->keyField.'.value=\'\';this.form.'.$this->name.'.value=\'\';"
					>';
		}

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
				<td valign="top" nowrap>
					'.$this->getComponent().'
				</td>
			</tr>
		';
	}

}
?>