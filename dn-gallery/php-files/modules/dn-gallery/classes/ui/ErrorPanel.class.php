<?php
/*
 * ErrorPanel.class.php
 *
 * Created on April 19, 2007, 2:42 AM
 *
 */

/**
 *
 * @author Adam
 */

class ErrorPanel 

{
	
	var $errrorVar = "";

    function ErrorPanel($errrorVar = null) 
	{
		if ($errrorVar != null) 
		{
			$this->errrorVar = $errrorVar;
		}
    }
	
	function setErrorVar($var) {
		$this->errrorVar = $var;
	}

	function renderMessage($msg = "") 
	{
		echo '
				<br />
				<table class="alert-error-frame" border="0" cellpadding="2" cellspacing="1" width="90%" align="center"><tbody><tr><td class="alert-error-content">
				<div class="ErrorHdr">ERROR !!</div>
			';
		echo '<div class="ErrorTxt">'.$msg.'</div>';
		echo '
				</td></tr></tbody></table>
			';
	}

	function render($title="ERROR !!") 
	{
		if ($this->errrorVar != "" && $this->errrorVar != null && sizeof($this->errrorVar) > 0) {
			echo '
					<br />
					<table class="alert-error-frame" border="0" cellpadding="2" cellspacing="1" width="90%" align="center"><tbody><tr><td class="alert-error-content" nowrap>
					<div class="ErrorHdr">'.$title.'</div>
					<ul>
				';
			while (list($key,$val) = each($this->errrorVar)) {
				echo '<li><span class="ErrorTxt">'.$val.'</span></li>';
			}
			echo '
					</ul>
					</td></tr></tbody></table>
				';
		}
	}
}
?>
