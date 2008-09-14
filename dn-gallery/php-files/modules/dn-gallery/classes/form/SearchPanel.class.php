<?php

class SearchPanel extends Form {

	function SearchPanel($name = "") {

		if ($name == "") {
			$name = "formSearch";
		}
		parent::Form($name,"","");
	}
	
	function render() {
		global $mod;
		global $act;
		global $do;
		if ($do == "3") {$do = "2";}
		echo '
			
		<table border="0" cellpadding="0" cellspacing="0" width="100%" align="Center">
		<tbody>
		<tr valign="bottom"> 
		  <td valign="bottom" align="left"><div class="TtlTxtDiv">
		  <form name="'.$this->name.'" action="'.$_SERVER["PHP_SELF"].'?mod='.$mod.'&act='.$act.'&do='.$do.'" method="post">
			<input type="hidden" name="isSubmitted" value="0">
		  <table>';
		
		$strReset = '';
		while (list($key,$val) = each($this->components)) {
			if (!$val->isHidden()) {
				echo '
					<tr>
					<td colspan="3"><div class="LblLev2Txt">'.$val->getLabel().'</div></td>
				</tr>
				<tr>
					<td>'.$val->getComponent().'
					</td>
					<td colspan="2"><div class="LblLev2Txt">&nbsp;</div></td>
					<td>&nbsp;
					</td>
				</tr>';
				if ($val->keyField != '') {
					$strReset .= 'this.form.'.$val->keyField.'.value=\'\';';
				}
				$strReset .= 'this.form.'.$val->getName().'.value=\'\';';
			}
			else {
				echo $val->getComponent();
			}
		}
		
		echo '
			<tr>
				<td colspan="3"><input type="Submit" value="Search" class="Btn1" onmouseover="javascript: this.className=\'Btn1Hov\'" onmouseout="javascript: this.className=\'Btn1\'" onblur="javascript: this.className=\'Btn1\'" onfocus="javascript: this.className=\'Btn1Hov\'">
				<input type="Button" value="Reset" class="Btn1" onmouseover="javascript: this.className=\'Btn1Hov\'" onmouseout="javascript: this.className=\'Btn1\'" onblur="javascript: this.className=\'Btn1\'" onfocus="javascript: this.className=\'Btn1Hov\'" onclick="javascript:'.$strReset.'this.form.submit();">
				</td>
			</tr>
			<tr>
				<td colspan="3">&nbsp;</td>
			</tr>
			</table>
			</form>
		 </td>
		 </tr>
		<tr> 
		  <td><img src="images/spacer.gif" height="5"></td> 
		</tr>
		</tbody></table>';
	}

}
?>