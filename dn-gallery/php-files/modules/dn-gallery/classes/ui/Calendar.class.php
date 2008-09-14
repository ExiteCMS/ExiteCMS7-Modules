<?php
/*
 * Calendar.class.php
 *
 * Created on April 19, 2007, 2:42 AM
 *
 */

/**
 *
 * @author Adam
 */

class Calendar 

{
	
	var $displayVar = "";
	var $hiddenVar = "";
	var $value = "";
	var $concat = "";

    function Calendar($displayVar = null, $hiddenVar = null, $calValue = null,$concat = null) 
	{
		if ($displayVar != null) 
		{
			$this->displayVar = $displayVar;
		}

		if ($hiddenVar != null) 
		{
			$this->hiddenVar = $hiddenVar;
		}

		if ($calValue != null) 
		{
			$this->value = $calValue;
		}
		else 
		{
			$this->value = date("Y-m-d");
		}

		if ($concat != null) 
		{
			$this->concat = $concat;
		}
    }

	function setValue($val = "") 
	{
		$this->value = $val;
	}

	function renderScript() {

		echo '			
			<link rel="stylesheet" type="text/css" media="all" href="classes/ext/jscalendar-1.0/calendar-blue2.css" title="win2k-cold-1" />
			<script type="text/javascript" src="classes/ext/jscalendar-1.0/calendar.js"></script>
			<script type="text/javascript" src="classes/ext/jscalendar-1.0/lang/calendar-en.js"></script>
			<script type="text/javascript" src="classes/ext/jscalendar-1.0/calendar-setup.js"></script>
			';
	}
	function render($script = 0) 
	{
			$val2 = $this->value;
			$timestamp = strtotime($this->value);
			$val1 = date("F j, Y", $timestamp);

		if ($script == 0) {		
			$this->renderScript();
		}

		echo '			
			<input type="text" class="TxtFldDis" name="'.$this->displayVar.'" id="'.$this->displayVar.'" readonly="1" value="'.$val1.'" size="15" />		

			<input type="hidden" name="'.$this->hiddenVar.'" id="'.$this->hiddenVar.'" value="'.$val2.'"/>
		  
			<img src="classes/ext/jscalendar-1.0/icon_calendar.gif" id="f_trigger_c_'.$this->concat.'" border="0" style="cursor: pointer;" title="Date selector" height="14" width="20"/>

			<script type="text/javascript">
				function catcalc_'.$this->concat.'(cal) {
					var date = cal.date;

					var field2 = document.getElementById("'.$this->hiddenVar.'");
					
					field2.value = date.print("%Y-%m-%d");
				}
				Calendar.setup({
					inputField     :    "'.$this->displayVar.'",    
					ifFormat       :    "%B %e, %Y",      
					daFormat       :    "%B %e, %Y",
					button         :    "f_trigger_c_'.$this->concat.'",  
					align          :    "Br",           
					singleClick    :    true,
					onUpdate       :    catcalc_'.$this->concat.'
				});
				Calendar.setup({
					inputField     :    "'.$this->hiddenVar.'",
					ifFormat       :    "%Y-%m-%d",
					daFormat       :    "%Y-%m-%d",
					showsTime      :    true
				});
			</script>
			';
	}
}
?>
