<?php
    /**
    * stub.php
    * Insert stub explanation text.
    *
    * Usage {{stubtext}}
    * (no parameters)
    *
    * DavePreston (www.davepreston.me.uk)
    */
	$stub = ">>@@This page is a **WikiStub**@@>>";
	if ($this->HasAccess("write")) {
		$stub .= "===Be the first to edit this page!===\n\n\n";
		$stub .= "You can help to make this Wiki more useful by adding information to it.\n\nJust click on the \"Edit page\" link at the bottom left of the page or double-click on the page text.\n\n";
		$stub .= "If this is the first time you add information to this Wiki, please make sure you are familiar with the WikiRules and the FormattingRules. This will create a consistent look-and-feel, and saves us the work of correcting your text!\n\n";
		$stub .= "Thank you for your efforts in making this Wiki grow!";
	} else {
		$stub .= "===No text has been entered for this page!===\n\n\n";
		$stub .= "There is no text available for the Wiki Name you selected.";
	}
	
    echo $this->Format($stub);
?>
