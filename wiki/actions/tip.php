<?php
/*
		tip action
		Displays a sidebar tip (like a post-it)
		Syntax: {{tip text="text" width="width_in_pixels"}}
*/


$text = htmlspecialchars($vars['text']);
$width = htmlspecialchars($vars['width']);

if (!is_numeric($width)) {
		$width = "200";
}

?>

<DIV ID="tip" STYLE="width: <?php echo $width; ?>px">
		<DIV CLASS="title">TIP</DIV>
		<DIV ID="text">
				<?php echo $this->Format($text); ?>
		</DIV>
</DIV>