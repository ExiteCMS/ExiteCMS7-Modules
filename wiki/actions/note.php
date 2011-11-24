<?php
/*
		note action
		Displays a sidebar note (like a post-it)
		Syntax: {{note text="text" width="width_in_pixels"}}
*/


$text = htmlspecialchars($vars['text']);
$width = htmlspecialchars($vars['width']);

if (!is_numeric($width)) {
		$width = "200";
}

?>

<DIV ID="note" STYLE="width: <?php echo $width; ?>px">
		<DIV ID="text">
				<?php echo $this->Format($text); ?>
		</DIV>
</DIV>