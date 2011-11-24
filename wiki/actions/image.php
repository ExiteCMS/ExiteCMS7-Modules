<?php
/*
	"image" action

	Parameters:
		url		- URL of image to be embedded
		link		- target link for image (optional). Supports URL, WikiName links, InterWiki links etc.
		title		- title text displayed when mouse hovers above image
		class		- a class for the image
		alt         - an alt text
		width		- optional width of the image
		height		- optional height of the image
		style       - optional image style
*/

$title = 'WikiImage';
$class = $link = $style = '';
$alt = 'image';

if (is_array($vars))
{
    foreach ($vars as $param => $value)
    {
    	if ($param == 'src' and $vars['url'] == '') {$vars['url']=$value;}
    	if ($param == 'title') {$title = $this->htmlspecialchars_ent($vars['title']);}
    	if ($param == 'class') {$class = $this->htmlspecialchars_ent($vars['class']);}
    	if ($param == 'alt') {$alt = $this->htmlspecialchars_ent($vars['alt']);}
    	if ($param == 'link') {$link = $this->htmlspecialchars_ent($vars['link']);}
    	if ($param == 'width') {$width = $this->htmlspecialchars_ent($vars['width']);}
    	if ($param == 'height') {$width = $this->htmlspecialchars_ent($vars['height']);}
    	if ($param == 'style') {$style = $this->htmlspecialchars_ent($vars['style']);}
	}
}
$url = $this->cleanUrl(trim($vars['url']));

// no path given? Then add the default wiki path
if (strpos($url, "/") === false) $url = IMAGES."wiki/".$url;

$output = '<img class="'.$class.'" src="'.$url.'"';
if (isset($width)) $output .= ' width="'.$width.'"';
if (isset($height)) $output .= ' height="'.$height.'"'; 
$output .= ' style="'.$style.'" alt="'.$alt.'" title="'.$title.'" />';

// link?
if ($link !== '')
{
	$output = $this->Link($link, "", $output, 1, 0, 0);
}

$output = $this->ReturnSafeHTML($output);
print($output);

?>
