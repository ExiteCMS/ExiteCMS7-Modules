<?php
/*
 * Gallery - a web based photo album viewer and editor
 * Copyright (C) 2000-2007 Bharat Mediratta
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or (at
 * your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street - Fifth Floor, Boston, MA  02110-1301, USA.
 *
 * $Id: Form.php 15881 2007-02-27 20:40:34Z jenst $
 */
?>
<?php

/**
 * @package Forms
 *
 * Function for HTML forms
 */
?>
<?php

function insertFormJS($formName) {

?>
<script type="text/javascript" language="javascript">
// <!--
function setCheck(val,elementName) {
	ufne = document.<?php echo $formName; ?>;
	for(i = 0 ; i < ufne.elements.length; i++) {
		if (ufne.elements[i].name == elementName) {
			if (ufne.elements[i].type == 'select-multiple') {
				for (j = 0; j < ufne.elements[i].length; j++) {
					ufne.elements[i].options[j].selected = val;
				}
			}
			else {
				ufne.elements[i].checked = val;
			}
		}
	}
}

function invertCheck(elementName) {
	ufne = document.<?php echo $formName; ?>;
	len = ufne.elements.length;
	for(i = 0 ; i < ufne.elements.length; i++) {
		if (ufne.elements[i].name==elementName) {
			if (ufne.elements[i].type == 'select-multiple') {
				for (j = 0; j < ufne.elements[i].length; j++) {
					ufne.elements[i].options[j].selected = !(ufne.elements[i].options[j].selected);
				}
			}
			else {
				ufne.elements[i].checked = !(ufne.elements[i].checked);
			}
		}
	}
}
// -->
</script>
<?php
}

function insertFormJSLinks($elementName) {
	$buf='
	<a href="javascript:setCheck(1,\'' . $elementName . '\')">'. gTranslate('common', "Check All") . '</a>
	-
	<a href="javascript:setCheck(0,\'' . $elementName . '\')">'. gTranslate('common', "Clear All") . '</a>
	-
	<a href="javascript:invertCheck(\'' . $elementName . '\')">'. gTranslate('common', "Invert Selection") .'</a>';

	return $buf;
}

/**
 * $opts is now a name/value array, where $key is the value returned, and $name
 * is the value displayed (and translated).
*/
function selectOptions($album, $field, $opts) {
	foreach ($opts as $key => $value) {
		$sel = '';
		if (isset($album->fields[$field]) && !strcmp($key, $album->fields[$field])) {
			$sel = 'selected';
		}
		echo "\n\t<option value=\"$key\" $sel>$value</option>";
	}
	echo "\n";
}

/**
 * Returns the partitial HTML code for HTML tags attributes
 *
 * @param	array	$attrList	Format: 'key' => 'value'
 * @return	string	$attrList
 * @author	Jens Tkotz
 */
function generateAttrs($attrList) {
	$attrs = '';

	if(!empty($attrList) && is_array($attrList)) {
		foreach ($attrList as $key => $value) {
			if ($value === false) {
				continue;
			}
			elseif ($value === NULL) {
				$attrs .= " $key";
			}
			else {
				$attrs .= " $key=\"$value\"";
			}
		}
	}

	return $attrs;
}

/**
 * Returns the HTML code for a selectbox
 *
 * @param string  $name		 Name attribute of the selectbox
 * @param array   $options	 Array of options. Format 'value' => 'text'
 * @param mixed   $selected	 String or integer, if a value or key is equal this, the entry is selected.
 * @param integer $size		 Size of the box, default 1
 * @param array   $attrList	 Optional Attributs for the selectbox
 * @return string $html
 */
function drawSelect($name, $options, $selected, $size, $attrList = array(), $prettyPrinting = false) {
    $crlf = ($prettyPrinting) ? "\n\t" : '';
    $attrs = generateAttrs($attrList);
    $buf = "<select name=\"$name\" size=\"$size\"$attrs>" . $crlf;

	if(!empty($options)) {
		foreach ($options as $value => $text) {
			$sel = '';
			if (is_array($selected)) {
				if (in_array($value, $selected)) {
					$sel = ' selected';
				}
			}
			else if (!strcmp($value, $selected) || !strcmp($text, $selected) || $selected === '__ALL__') {
				$sel = ' selected';
			}
			$buf .= "<option value=\"$value\"$sel>". $text ."</option>" . $crlf;
		}
    }
    $buf .= '</select>'. $crlf;

    return $buf;
}

/**
 * Returns the HTML code for a selectbox
 *
 * @param string  $name		 Name attribute of the selectbox
 * @param array   $options	 Array of options. Format 'trash' => array('text' => .., 'value' => '', 'selected' => set/not set
 * @param array   $attrList	 Optional Attributs for the selectbox
 * @return string $html
 * @author Jens Tkotz
 */
function drawSelect2($name, $options, $attrList = array(), $args = array()) {
    $crlf = (isset($args['prettyPrinting'])) ? "\n\t" : '';

	if (!isset($attrList['size'])) {
		$attrList['size'] = 1;
	}

    $attrs = generateAttrs($attrList);

    $buf = "$crlf<select name=\"$name\" $attrs>";

    if(!empty($options)) {
        foreach ($options as $nr => $option) {
            $sel = isset($option['selected']) ? ' selected' : '';
            $optAttrs = isset($option['attrs']) ? generateAttrs($option['attrs']) : '';
            $buf .= "\n\t". "<option $optAttrs value=\"". $option['value'] ."\" $sel>". $option['text'] ."</option>$crlf";
        }
    }

    $buf .= "</select>". $crlf;

    return $buf;
}

/**
 * makeFormIntro() is a wrapper around makeGalleryUrl() that will generate
 * a <form> tag suitable for usage in either standalone or embedded mode.
 * You can specify the additional attributes you want in the optional second
 * argument.  Eg:
 *
 * makeFormIntro("add_photos.php",
 *					  array("name" => "count_form",
 *							  "enctype" => "multipart/form-data",
 *							  "method" => "post"));
 *
 * If no method is given in attrList, then "post" is used.
 * @param string	$target
 * @param array()   $attrList
 * @param array()   $urlargs
 * @return string   $form
 */
function makeFormIntro($target, $attrList = array(), $urlargs = array()) {
	static $usedIDs = array();
	static $idCounter = 0;

	// We don't want the result HTML escaped since we split on "&", below
	// use the header version of makeGalleryUrl()
	if(urlIsRelative($target)) {
		$url = makeGalleryHeaderUrl($target, $urlargs);
	}
	else {
		$url = unhtmlentities($target);
	}

	$result = split("\?", $url);
	$target = $result[0];
	$tmp = (sizeof($result) > 1) ? $result[1] :'';

	$defaults = array(
		'method' => 'post',
		'name'	 => 'g1_form'
	);

	foreach($defaults as $attr => $value) {
		if(!isset($attrList[$attr])) {
			$attrList[$attr] = $value;
		}
	}

	$attrs = generateAttrs($attrList);

	$form = "\n<form action=\"$target\"$attrs>\n";

	$args = split("&", $tmp);
	foreach ($args as $arg) {
		if (strlen($arg) == 0) {
			continue;
		}
		list($key, $val) = split("=", $arg);
		if(in_array($key, $usedIDs)) {
			$id = "${key}_${idCounter}";
			$idCounter++;
		}
		else {
			$id = $key;
			$usedIDs[] = $id;
		}

		$form .= "<input type=\"hidden\" id=\"$id\" name=\"$key\" value=\"$val\">\n";
	}

	return $form;
}

function formVar($name) {
	if (!strncmp($_REQUEST[$name], 'false', 5)) {
		return false;
	} else {
		return getRequestVar($name);
	}
}

function emptyFormVar($name) {
	return !isset($_REQUEST[$name]);
}

/**
 * The code below was inspired from the Horde Framework (http://www.horde.org)
 * It was taken from: framework/UI/UI/VarRenderer/html.php,v 1.106
 * Copyright 2003-2005 Jason M. Felice <jfelice@cronosys.com>
 *
 * Jens Tkotz 25.04.2005
*/
function showColorpicker($attrs = array()) {
	$args = array(
		'target' => $attrs['name'],
		'gallery_popup' => true
	);

	$colorPickerUrl = makeGalleryUrl('lib/colorpicker.php', $args);
	$imgColorpicker = '<img src="'. getImagePath('colorpicker.png') .'" height="16" alt="colorpicker">';

	$html = "\n<table cellspacing=\"0\" style=\"margin-top: 1px\">";
	$html .= "\n<tr>";
	$html .= "\n". '<td><input type="text" size="10" maxlength="7" name="'. $attrs['name'] .'" id="'. $attrs['name'] .'" value="'. $attrs['value'] .'"></td>';
	$html .= "\n". '<td width="20" id="colordemo_' . $attrs['name'] . '" style="background-color:' . $attrs['value'] . '"> </td>';
	$html .= "\n<td><a href=\"$colorPickerUrl\" onclick=\"window.open('$colorPickerUrl', 'colorpicker', 'toolbar=no,location=no,status=no,scrollbars=no,resizable=no,width=120,height=250,left=100,top=100'); return false;\" onmouseout=\"window.status='';\" onmouseover=\"window.status='". _("Colorpicker") ."'; return true;\" target=\"colorpicker\">".  $imgColorpicker .'</a></td>';
	$html .= "\n". '<td><div id="colorpicker_' . $attrs['name'] . '"></div></td>';
	$html .= "\n</tr></table>\n";

	return $html;
}

function showChoice2($target, $args, $popup = true) {
	global $gallery;

	if (empty($args['set_albumName'])) {
		$args['set_albumName'] = $gallery->session->albumName;
	}
	if($popup) {
		$args['type'] = 'popup';
	}
	return makeGalleryUrl($target, $args);
}

/**
 * Returns the HTML Code for a submit button (<input type="submit">).
 *
 * @param string	$name			 Name of the button.
 * @param string	$value			Value shown on the button.
 * @param array	 $additionalAttrs  Additional HTML attributes
 * @return string   $html			 The HTML code.
 * @author Jens Tkotz
 */
function gSubmit($name, $value, $additionalAttrs = array()) {
	static $ids = array();

	if(!in_array($name, $ids)) {
		$attrList['name'] = $attrList['id'] = $name;
		$ids[] = $name;
	}
	else {
		$attrList['name'] = $name;
	}

	$attrList['type'] = 'submit';
	$attrList['value'] = $value;
	$attrList['class'] = 'button';
	$attrList['title'] = isset($additionalAttrs['title']) ? $additionalAttrs['title'] : $value;

	$attrList = array_merge($attrList, $additionalAttrs);
	$attrs = generateAttrs($attrList);

	$html = "<input$attrs>\n";

	return $html;
}

function gButton($name, $value, $onClick, $additionalAttrs = array()) {
	$attrList['name'] = $attrList['id'] = $name;
	$attrList['type'] = 'button';
	$attrList['value'] = $value;
	$attrList['class'] = 'button';
	$attrList['onClick'] = $onClick;
	$attrList['title'] = isset($additionalAttrs['title']) ? $additionalAttrs['title'] : $value;

	$attrList = array_merge($attrList, $additionalAttrs);

	$attrs = generateAttrs($attrList);

	$html = "<input$attrs>\n";

	return $html;
}
?>
