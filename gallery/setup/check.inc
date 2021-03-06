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
 * $Id: check.inc 16862 2007-08-12 14:13:11Z jenst $
 */
?>

<script type="text/javascript" src="<?php echo makeGalleryUrl('js/toggle.js'); ?>"></script>

<input type="hidden" name="this_page" value="check">
<input type="hidden" name="next_page" value="constants">

<div class="header"><?php echo sprintf (gTranslate('config', "Gallery Configuration Wizard: Step %d"),1); ?></div>

<div class="sitedesc">
<?php 
	echo gTranslate('config', "This is the Gallery system check page.") . "  ";
	echo gTranslate('config', "This page will validate your installation to make sure that you have all the necessary components and permissions on this system and that everything is configured reasonably.") ;

	echo '<br><br>';

	$diagUrl='diagnostics.php';
        $diagnostics_page='<a href="'. $diagUrl .'">' . gTranslate('config', "Gallery Diagnostics Page").'</a>';
	$help_page='<a href="http://gallery.sourceforge.net/help.php">'. gTranslate('config', "Gallery Help Page"). '</a>';
	$docs_page = galleryDocs();

	if ($docs_page) {
		echo sprintf(gTranslate('config', "Having problems?  Try the %s, %s and %s."),
				'<a href="'. $docs_page .'">'. gTranslate('config', "documentation") .'</a>', $diagnostics_page, $help_page);
	} else {
		echo sprintf(gTranslate('config', "Having problems?  Try the %s and %s."),
			$diagnostics_page, $help_page);
	}

echo "</div>";
echo "<br>";

$configTestStatus = array(
	0 => array(
		'image' => gImage('green_trafficlight.gif', gTranslate('config', "Success!")),
		'text' => gTranslate('config', "Success!"),
	       	'border' => 'border: 1px solid #b2ffb2'
	),
	5 => array(
		'image' => gImage('yellow_trafficlight.gif', gTranslate('config', "Warning, but optional.")),
		'text' => gTranslate('config', "Warning, but optional."),
		'border' => 'border: 2px solid #ffff98'
	),
	10 => array(
		'image' => gImage('yellow_red_trafficlight.gif', gTranslate('config', "Serious warning, but optional.")),
		'text' => gTranslate('config', "Serious warning, but optional."),
		'border' => 'border: 2px solid #ff9898',
	),
	51 => array(
		'image' => gImage('red_trafficlight.gif', gTranslate('config', "Serious warning, no go!")),
		'text' => gTranslate('config', "Serious warning, no go!"),
		'border' => 'border: 4px solid #ec000a'
	),
	100 => array(
		'image' => gImage('red_trafficlight.gif', gTranslate('config', "Failure!")),
		'text' => gTranslate('config', "Failure!"),
		'border' => 'border: 4px solid #ec000a'
	)
);

$warning = 0;
echo '<table class="inner" width="100%" cellspacing="0">';
foreach ($checklist as $short => $check) {
    if( isset($check["enabled"]) && $check["enabled"] == "no") continue;

    $func = $check["func"];
    $result = $func();
    
    list($success, $fail, $warn) = $result;
    $status = getCheckStatus($result, $check);
    $usedStatus[$status] = $status;
    
    // new Line //
    echo "\n<tr style=\"margin-top: 2px\">";
    // shortdesc
    echo "\n\t<td class=\"desc\" width=\"40%\" style=\"font-weight: bold; vertical-align: top; border-bottom: 2px solid #ececec;\">". $check['prompt'];
    echo "\n\t\t". '<br><div style="font-weight: normal; display:none;" id="toogleFrame_'. $short .'">'. $check["desc"] .'</div>';
    echo "\n</td>"; 
    
    // toogle button
    echo "\n\t<td class=\"desc\" style=\"vertical-align: top; border-right: 2px solid #ececec; border-bottom: 2px solid #ececec;\">" .
        "\n\t\t<a href=\"#\" onClick=\"gallery_toggle('$short'); return false;\">" .
        gImage('expand.gif', gTranslate('config', "Show/hide more information"), array('id' => "toogleBut_$short")) .
        '</a>';
    echo "\n\t</td>";
    
    // traffic light
    echo "\n\t<td class=\"desc\" style=\"border-right: 2px solid #ececec; border-bottom: 2px solid #ececec;\">";
    echo $configTestStatus[$status]['image'];
    echo "\n\t</td>";
    
    // result
    echo "\n\t<td class=\"desc\" style=\"vertical-align: top;border-bottom: 2px solid #ececec;\">";
    echo "\n\t<div style=\"padding: 2px; ". $configTestStatus[$status]['border'] .'">';
    foreach ($success as $key) {
		if ($key != '') {
		    echo $key;
		}
    }
	
	$openBasedir = ini_get('open_basedir');
	foreach ($fail as $key => $val) {
	    if (isset($check['optional']) && $check['optional'] == 1) {
	        if (isset($check["serious"]) && $check["serious"] == 1) {
	            $serious_warning = true;
	        }
	        if (isset($check) && isset($check[$key])) {
	            echo "\n\t\t\t". $check[$key];
	        }
	        $warning++;
	    } else {
	        if (isset($check["serious"]) && $check["serious"] == 1) {
	            $serious_warning = true;
	        }

	        if (isset($check) && isset($check[$key])) {
	            echo "\n\t\t\t". $check[$key];
	        }
	        $error = 1;
	    }

	    if (isset($check["open-basedir-note"]) && !empty($openBasedir)) {
	        print '<p>'. $check["open-basedir-note"] . '</p>';
	    }

	    if (is_array($val)) {
	        foreach ($val as $msg) {
	            if ($val) {
	                echo $msg;
	            }
	        }
	    }
	    else if (is_string($val)) {
	        echo $val;
	    }
	}

	// Nothing failed, just warnings
	if (isset($warn) && !empty($warn)) {
	    foreach ($warn as $key => $val) {
	        if (isset($check[$key])) {
	            echo "\t\t\t". $check[$key];
	        } else {
	            echo "\n\t\t\t". $val;
	        }
	        $warning++;
	    }
	}

	
    echo "\n</div></td>"; 
	
	echo "\n</tr>";
}
echo "\n</table>";

echo "\n<table width=\"100%\">";
echo "\n<tr><td>";

echo "\n<table>";
echo "\n<tr><td colspan=\"2\" align=\"left\">". gTranslate('config', "Legend:") . '</td></tr>';
foreach ($usedStatus as $status) {
    echo "\n<tr><td>". $configTestStatus[$status]['image'] .'</td>';
    echo "<td style=\"padding: 2px; ". $configTestStatus[$status]['border'] .'">'. $configTestStatus[$status]['text'] .'</td></tr>';
}
echo "\n</table>";

echo "\n</td>";
echo "\n<td align=\"center\">";
	if (isset($error)) {
		echo '<p class="error" id="bottom">';
		echo gTranslate('config', "There are errors in your configuration that will prevent Gallery from functioning properly.");
		echo '<br>';
		echo gTranslate('config', "You must fix them before you can continue.");
	} else {
		if ($warning > 0) {
			if (isset($serious_warning)) {
				echo '<p class="error" id="bottom">';
				echo gTranslate('config', "Your installation has <b>serious warnings</b>!<br>Continue at your own risk...");
			} else {
				echo '<p class="warning" id="bottom">';
				echo gTranslate('config', "Your installation has warnings, but this is usually OK.  Keep going!");
			}
		} else {
			echo '<p class="success" id="bottom">';
			echo gTranslate('config', "Your installation passed with flying colors!  Go go go!");
		}
		echo '</p><p>';
		echo '<input type="submit" name="go_next" disabled="disabled" value="'. gTranslate('config', "Next Step") . ' ->">';
		echo '</p>';
}
?>
</td></tr></table>
