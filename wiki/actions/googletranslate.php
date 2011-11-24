<?php
/*
		googletranslate action
		Displays the googletranslate gadget
		Syntax: {{googletranslate lang="en" title="this is the title"}}
*/


$lang = htmlspecialchars($vars['lang']);
$title = htmlspecialchars($vars['title']);

if (empty($lang)) {
		$lang = "en";
}

?>

<DIV ID="googletranslate" STYLE="">
		<DIV ID="text">
				<script src="http://www.gmodules.com/ig/ifr?url=http://www.google.com/ig/modules/translatemypage.xml&up_source_language=<?php echo $lang; ?>&w=160&h=60&title=<?php echo $title; ?>&border=&output=js"></script>
		</DIV>
</DIV>
