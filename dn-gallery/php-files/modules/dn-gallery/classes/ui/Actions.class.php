<?php
/*
 * Actions.class.php
 *
 * Created on April 17, 2007, 2:16 AM
 *
 */

/**
 *
 * @author Adam
 */

class Actions {
	
	var $button = "";
	var $action = "";
	var $strButton = array("","");
	var $form = "";
	var $target = "";
	var $queryString = "";
	var $arrButton = array();
	var $arrName = array();

    function Actions($fr = null) 
	{
		if ($fr != null) {
			$this->form = $fr;
		}
    }
	
	function setTarget($act,$query) {
		$this->target = $act;
		$this->queryString = $query;
	}

	function addButton($btType = 0,$value = null,$pos = 1,$name = null,$act = null) 
	{
		switch ($btType) {
			case 1: //new
				$strButton = '
					<td>
					<input type="button"
					 class="Btn1Def" value="'.$value.'"
					 onmouseover="javascript: if (this.disabled==0) this.className=\'Btn1Hov\'" 
					onmouseout="javascript: if (this.disabled==0) this.className=\'Btn1\'" 
					onblur="javascript: if (this.disabled==0) this.className=\'Btn1\'" 
					onfocus="javascript: if (this.disabled==0) this.className=\'Btn1Hov\'"
					 name="newBtn"
					 id="newBtn"
					 onclick="javascript:submitForm(this);"
					 ></td>
					 <td><img src="images/spacer.gif" width="5"></td>';
				$name = "newBtn";
			break;
			case 2: //edit
				$strButton = '
					<td>
					<input type="button"
					 class="Btn1Def" value="'.$value.'"
					 onmouseover="javascript: if (this.disabled==0) this.className=\'Btn1Hov\'" 
					onmouseout="javascript: if (this.disabled==0) this.className=\'Btn1\'" 
					onblur="javascript: if (this.disabled==0) this.className=\'Btn1\'" 
					onfocus="javascript: if (this.disabled==0) this.className=\'Btn1Hov\'"
					 name="editBtn"
					 id="editBtn"
					 onclick="javascript:submitForm(this);"
					 ></td>
					 <td><img src="images/spacer.gif" width="5"></td>';
				$name = "editBtn";
			break;
			case 3: //delete
				$strButton = '
					<td>
					<input type="button"
					 class="Btn1Def" value="'.$value.'"
					 onmouseover="javascript: if (this.disabled==0) this.className=\'Btn1Hov\'" 
					onmouseout="javascript: if (this.disabled==0) this.className=\'Btn1\'" 
					onblur="javascript: if (this.disabled==0) this.className=\'Btn1\'" 
					onfocus="javascript: if (this.disabled==0) this.className=\'Btn1Hov\'"
					 name="deleteBtn"
					 id="deleteBtn"
					 onclick="javascript:submitForm(this);"
					 ></td>
					 <td><img src="images/spacer.gif" width="5"></td>';
				$name = "deleteBtn";
			break;
			case 4: //print
				$strButton = '
					<td>
					<input type="button"
					 class="Btn1Def" value="'.$value.'"
					onmouseover="javascript: if (this.disabled==0) this.className=\'Btn1Hov\'" 
					onmouseout="javascript: if (this.disabled==0) this.className=\'Btn1\'" 
					onblur="javascript: if (this.disabled==0) this.className=\'Btn1\'" 
					onfocus="javascript: if (this.disabled==0) this.className=\'Btn1Hov\'"
					 name="printBtn"
					 id="printBtn"
					 onclick="'.$act.'"
					 ></td>
					 <td><img src="images/spacer.gif" width="5"></td>';
				$name = "printBtn";
			break;
			case 5: //export
				$strButton = '
					<td>
					<input type="button"
					 class="Btn1Def" value="'.$value.'"
					onmouseover="javascript: if (this.disabled==0) this.className=\'Btn1Hov\'" 
					onmouseout="javascript: if (this.disabled==0) this.className=\'Btn1\'" 
					onblur="javascript: if (this.disabled==0) this.className=\'Btn1\'" 
					onfocus="javascript: if (this.disabled==0) this.className=\'Btn1Hov\'"
					 name="exportBtn"
					 id="exportBtn"
					 onclick="'.$act.'"
					 ></td>
					 <td><img src="images/spacer.gif" width="5"></td>';
				$name = "exportBtn";
			break;
			case 6: //export
				$strButton = '
					<td>
					<input type="button"
					 class="Btn1Def" value="'.$value.'"
					 onmouseover="javascript: if (this.disabled==0) this.className=\'Btn1Hov\'" 
					onmouseout="javascript: if (this.disabled==0) this.className=\'Btn1\'" 
					onblur="javascript: if (this.disabled==0) this.className=\'Btn1\'" 
					onfocus="javascript: if (this.disabled==0) this.className=\'Btn1Hov\'"
					 name="'.$name.'"
					 id="'.$name.'"
					 onclick="'.$act.'"
					 ></td>
					 <td><img src="images/spacer.gif" width="5"></td>';
			break;
			case 7: //export
				$strButton = '
					<td>
					<input type="button"
					 class="Btn1Def" value="'.$value.'"
					 onmouseover="javascript: if (this.disabled==0) this.className=\'Btn1Hov\'" 
					onmouseout="javascript: if (this.disabled==0) this.className=\'Btn1\'" 
					onblur="javascript: if (this.disabled==0) this.className=\'Btn1\'" 
					onfocus="javascript: if (this.disabled==0) this.className=\'Btn1Hov\'"
					 name="'.$name.'"
					 id="'.$name.'"
					 onclick="'.$act.'"
					 ></td>
					 <td><img src="images/spacer.gif" width="5"></td>';
			break;
			case 9: //edit
				$strButton = '
					<td>
					<input type="button"
					 class="Btn1Def" value="'.$value.'"
					 onmouseover="javascript: if (this.disabled==0) this.className=\'Btn1Hov\'" 
					onmouseout="javascript: if (this.disabled==0) this.className=\'Btn1\'" 
					onblur="javascript: if (this.disabled==0) this.className=\'Btn1\'" 
					onfocus="javascript: if (this.disabled==0) this.className=\'Btn1Hov\'"
					 name="edit2Btn"
					 id="edit2Btn"
					 onclick="javascript:submitForm(this);"
					 ></td>
					 <td><img src="images/spacer.gif" width="5"></td>';
				$name = "editBtn";
			break;
			case 10: //edit
				$strButton = '
					<td>
					<input type="button"
					 class="Btn1Def" value="'.$value.'"
					 onmouseover="javascript: if (this.disabled==0) this.className=\'Btn1Hov\'" 
					onmouseout="javascript: if (this.disabled==0) this.className=\'Btn1\'" 
					onblur="javascript: if (this.disabled==0) this.className=\'Btn1\'" 
					onfocus="javascript: if (this.disabled==0) this.className=\'Btn1Hov\'"
					 name="edit3Btn"
					 id="edit3Btn"
					 onclick="javascript:submitForm(this);"
					 ></td>
					 <td><img src="images/spacer.gif" width="5"></td>';
				$name = "editBtn";
			break;
			default: //other
				$strButton = '
					<td>
					<input type="button"
					 class="Btn1Def" value="'.$value.'"
					 onmouseover="javascript: if (this.disabled==0) this.className=\'Btn1Hov\'" 
					onmouseout="javascript: if (this.disabled==0) this.className=\'Btn1\'" 
					onblur="javascript: if (this.disabled==0) this.className=\'Btn1\'" 
					onfocus="javascript: if (this.disabled==0) this.className=\'Btn1Hov\'"
					 name="'.$name.'"
					 id="'.$name.'"
					 onclick="'.$act.'"
					 ></td>
					 <td><img src="images/spacer.gif" width="5"></td>';
			break;
		}
		$this->arrButton[] = $btType;
		$this->arrName[] = $name;
		$this->strButton[$pos - 1] .= $strButton;
	}
	
	function clearButtons() {
		$this->strButton = array("","");
	}
	
	function renderScript() {
		global $mod;
		global $ref;

		echo '						
			<script type="text/javascript">
			var strId = "";
			function formCheckAll(fr) {
				for (i = 0; i < fr.length; i++) {
					var e = fr.elements[i];
					if (e.checked == false) {
						e.checked = true;
					}
				}';
		if (in_array("3",$this->arrButton)) {
			echo '	
				fr.deleteBtn.disabled=false;
				fr.deleteBtn.className="Btn1";';
		}
		if (in_array("7",$this->arrButton)) {
			for ($i=0;$i<sizeof($this->arrButton);$i++) {
				if ($this->arrButton[$i] == "7") {
			echo '	
				fr.'.$this->arrName[$i].'.disabled=false;
				fr.'.$this->arrName[$i].'.className="Btn1";';
				}
			}
		}
		if (in_array("2",$this->arrButton)) {
			echo '		
				fr.editBtn.disabled = true;	
				fr.editBtn.className="Btn1Dis";	';
		}
		if (in_array("9",$this->arrButton)) {
			echo '		
				fr.edit2Btn.disabled = true;	
				fr.edit2Btn.className="Btn1Dis";	';
		}
		if (in_array("10",$this->arrButton)) {
			echo '		
				fr.edit3Btn.disabled = true;	
				fr.edit3Btn.className="Btn1Dis";	';
		}
		if (in_array("6",$this->arrButton)) {
			for ($i=0;$i<sizeof($this->arrButton);$i++) {
				if ($this->arrButton[$i] == "6") {
			echo '	
				fr.'.$this->arrName[$i].'.disabled=true;
				fr.'.$this->arrName[$i].'.className="Btn1Dis";';
				}
			}
		}

		echo '	
			}

			function formUnCheckAll(fr) {
				for (i = 0; i < fr.length; i++) {
					var e = fr.elements[i];
					if (e.checked == true) {
						e.checked = false;
					}
				}
			';
		if (in_array("3",$this->arrButton)) {
			echo '	
				fr.deleteBtn.disabled=true;
				fr.deleteBtn.className="Btn1Dis";
			';
		}
		if (in_array("7",$this->arrButton)) {
			for ($i=0;$i<sizeof($this->arrButton);$i++) {
				if ($this->arrButton[$i] == "7") {
			echo '	
				fr.'.$this->arrName[$i].'.disabled=true;
				fr.'.$this->arrName[$i].'.className="Btn1Dis";';
				}
			}
		}
		if (in_array("2",$this->arrButton)) {
			echo '		
				fr.editBtn.disabled = true;	
				fr.editBtn.className="Btn1Dis";	';
		}
		if (in_array("9",$this->arrButton)) {
			echo '		
				fr.edit2Btn.disabled = true;	
				fr.edit2Btn.className="Btn1Dis";	';
		}
		if (in_array("10",$this->arrButton)) {
			echo '		
				fr.edit3Btn.disabled = true;	
				fr.edit3Btn.className="Btn1Dis";	';
		}
		if (in_array("6",$this->arrButton)) {
			for ($i=0;$i<sizeof($this->arrButton);$i++) {
				if ($this->arrButton[$i] == "6") {
			echo '	
				fr.'.$this->arrName[$i].'.disabled=true;
				fr.'.$this->arrName[$i].'.className="Btn1Dis";';
				}
			}
		}
		echo '	
			}
			function disableAllBtn() {
			';
		if (in_array("2",$this->arrButton)) {
			echo '
				document.forms["'.$this->form.'"].editBtn.disabled = true;		
				document.forms["'.$this->form.'"].editBtn.className="Btn1Dis";';
		}
		if (in_array("9",$this->arrButton)) {
			echo '
				document.forms["'.$this->form.'"].edit2Btn.disabled = true;		
				document.forms["'.$this->form.'"].edit2Btn.className="Btn1Dis";';
		}
		if (in_array("10",$this->arrButton)) {
			echo '
				document.forms["'.$this->form.'"].edit3Btn.disabled = true;		
				document.forms["'.$this->form.'"].edit3Btn.className="Btn1Dis";';
		}
		if (in_array("6",$this->arrButton)) {
			for ($i=0;$i<sizeof($this->arrButton);$i++) {
				if ($this->arrButton[$i] == "6") {
			echo '	
				document.forms["'.$this->form.'"].'.$this->arrName[$i].'.disabled = true;		
				document.forms["'.$this->form.'"].'.$this->arrName[$i].'.className="Btn1Dis";';
				}
			}
		}
		if (in_array("3",$this->arrButton)) {
			echo '
				document.forms["'.$this->form.'"].deleteBtn.disabled = true;		
				document.forms["'.$this->form.'"].deleteBtn.className="Btn1Dis";';
		}
		if (in_array("7",$this->arrButton)) {
			for ($i=0;$i<sizeof($this->arrButton);$i++) {
				if ($this->arrButton[$i] == "7") {
			echo '	
				document.forms["'.$this->form.'"].'.$this->arrName[$i].'.disabled = true;		
				document.forms["'.$this->form.'"].'.$this->arrName[$i].'.className="Btn1Dis";';
				}
			}
		}
		echo '
			}

			function toggleDisableButton(fr,el) {
				var count = 0;
				for (i = 0; i < fr.length; i++) {
					var e = fr.elements[i];
					if (e.name == "params[]" && e.checked == true) {
						count++;
					}
				}
				if (count > 0) {
				';
		if (in_array("3",$this->arrButton)) {
			echo '
					fr.deleteBtn.disabled=false;
					fr.deleteBtn.className="Btn1";
				';
		}
		if (in_array("7",$this->arrButton)) {
			for ($i=0;$i<sizeof($this->arrButton);$i++) {
				if ($this->arrButton[$i] == "7") {
			echo '	
					fr.'.$this->arrName[$i].'.disabled=false;
					fr.'.$this->arrName[$i].'.className="Btn1";';
				}
			}
		}
		if (in_array("2",$this->arrButton)) {
			echo '
					if (count < 2) {
						fr.editBtn.disabled=false;	
						fr.editBtn.className="Btn1";';
			echo '
					}
					else {
						fr.editBtn.disabled = true;	
						fr.editBtn.className="Btn1Dis";		';
			echo '
					}';
		}
		if (in_array("9",$this->arrButton)) {
			echo '
					if (count < 2) {
						fr.edit2Btn.disabled=false;	
						fr.edit2Btn.className="Btn1";';
			echo '
					}
					else {
						fr.edit2Btn.disabled = true;	
						fr.edit2Btn.className="Btn1Dis";		';
			echo '
					}';
		}
		if (in_array("10",$this->arrButton)) {
			echo '
					if (count < 2) {
						fr.edit3Btn.disabled=false;	
						fr.edit3Btn.className="Btn1";';
			echo '
					}
					else {
						fr.edit3Btn.disabled = true;	
						fr.edit3Btn.className="Btn1Dis";		';
			echo '
					}';
		}
		if (in_array("6",$this->arrButton)) {
			echo '
					if (count < 2) {';
			for ($i=0;$i<sizeof($this->arrButton);$i++) {
				if ($this->arrButton[$i] == "6") {
			echo '	
					fr.'.$this->arrName[$i].'.disabled=false;
					fr.'.$this->arrName[$i].'.className="Btn1";';
				}
			}
			echo '
					}
					else {';
			for ($i=0;$i<sizeof($this->arrButton);$i++) {
				if ($this->arrButton[$i] == "6") {
			echo '	
					fr.'.$this->arrName[$i].'.disabled=true;
					fr.'.$this->arrName[$i].'.className="Btn1Dis";';
				}
			}
			echo '
					}';
		}
		echo '
				}
				else {
			';
		if (in_array("3",$this->arrButton)) {
			echo '
					fr.deleteBtn.disabled = true;	
					fr.deleteBtn.className="Btn1Dis";
			';
		}
		if (in_array("7",$this->arrButton)) {
			for ($i=0;$i<sizeof($this->arrButton);$i++) {
				if ($this->arrButton[$i] == "7") {
			echo '	
					fr.'.$this->arrName[$i].'.disabled=true;
					fr.'.$this->arrName[$i].'.className="Btn1Dis";';
				}
			}
		}
		if (in_array("2",$this->arrButton)) {
			echo '
					fr.editBtn.disabled = true;		
					fr.editBtn.className="Btn1Dis";
				';
		}
		if (in_array("9",$this->arrButton)) {
			echo '
					fr.edit2Btn.disabled = true;		
					fr.edit2Btn.className="Btn1Dis";
				';
		}
		if (in_array("10",$this->arrButton)) {
			echo '
					fr.edit3Btn.disabled = true;		
					fr.edit3Btn.className="Btn1Dis";
				';
		}
		if (in_array("6",$this->arrButton)) {
			for ($i=0;$i<sizeof($this->arrButton);$i++) {
				if ($this->arrButton[$i] == "6") {
			echo '	
					fr.'.$this->arrName[$i].'.disabled=true;
					fr.'.$this->arrName[$i].'.className="Btn1Dis";';
				}
			}
		}
		echo '
				}
			}


			function submitForm(btn) {
				var answer = true;
				if (btn.name=="newBtn") {
					btn.form.action="index.php?mod='.$mod.'&act='.$this->target.'&do=0&frType=0&ref='.$ref.'&'.$this->queryString.'";		
				}
				else if (btn.name=="editBtn") {
					btn.form.action="index.php?mod='.$mod.'&act='.$this->target.'&do=0&frType=1&ref='.$ref.'&'.$this->queryString.'";
				}
				else if (btn.name=="edit2Btn") {
					btn.form.action="index.php?mod='.$mod.'&act='.$this->target.'Upd1&do=0&frType=9&ref='.$ref.'&'.$this->queryString.'";
				}
				else if (btn.name=="edit3Btn") {
					btn.form.action="index.php?mod='.$mod.'&act='.$this->target.'Upd2&do=0&frType=10&ref='.$ref.'&'.$this->queryString.'";
				}
				else if (btn.name=="deleteBtn") {
						answer = confirm("Are you sure ?");
						if (answer) {									
							btn.form.action="index.php?mod='.$mod.'&act='.$this->target.'&do=1&frType=2&ref='.$ref.'&'.$this->queryString.'";
						}
				}	
				if (answer) {
					btn.form.submit();
				}
			}
			</script>';
	}

	function renderButton() 
	{
		echo '					
			<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
			<tr>
			<td align="left" width="50%">
				<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					
				'.$this->strButton[0].'

				 </tr>
				 <tr><td colspan="5"><img src="images/spacer.gif" height="5"></td></tr>
				 </table>
			</td>
			<td align="right" width="50%">

				<table border="0" cellpadding="0" cellspacing="0">
				<tr>

				'.$this->strButton[1].'

				 </tr>
				 <tr><td colspan="5"><img src="images/spacer.gif" height="5"></td></tr>
				 </table>
			</td>
			</tr>
			</table>
			
			<script>
			disableAllBtn();
			</script>		 
			';
	}
}
?>
