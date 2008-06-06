<?php
/*
        warn action
        Displays a sidebar warning (like a post-it)
        Syntax: {{warn text="text" width="width_in_pixels"}}
*/


$text = htmlspecialchars($vars['text']);
$width = htmlspecialchars($vars['width']);

if (is_numeric($width) ? intval($width) == $width : false) {
        $width = "200";
}

?>

<DIV ID="warn" STYLE="width: <?php echo $width; ?>px">
        <DIV CLASS="title">WARNING</DIV>
        <DIV ID="text">
                <?php echo $this->Format($text); ?>
        </DIV>
</DIV>