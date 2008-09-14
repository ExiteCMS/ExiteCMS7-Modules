<?php
		
		$mydir = "var/cache/captcha/"; 
		$d = dir($mydir); 
		while($entry = $d->read()) { 
			if ($entry!= "." && $entry!= ".." && !is_dir($mydir.$entry)) { 
				unlink($mydir.$entry); 
			} 
		} 
		$d->close(); 

		$captcha = new Captcha(135,48,6,true);
?>