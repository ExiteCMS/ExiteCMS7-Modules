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
 * $Id: albums.php 16803 2007-08-01 20:49:39Z jenst $
 */
?>
<?php

require_once(dirname(__FILE__) . '/init.php');
require_once(dirname(__FILE__) . '/includes/stats/stats.inc.php');

if (empty($gallery->session->username)) {
    /* Get the cached version if possible */
    $cache_file = "cache.html";
    if (!getRequestVar('gallery_nocache')) {
        $cache_now = time();
        $cacheFileBaseNames = array(sprintf("cache-%s.html", $_SERVER['HTTP_HOST']), "cache.html");
        foreach ($cacheFileBaseNames as $cache_file_basename) {
            $cache_file = dirname(__FILE__) . '/' . $cache_file_basename;
            if (fs_file_exists($cache_file)) {
                $cache_stat = @stat($cache_file);
                if ($cache_now - $cache_stat[9] < (20 * 60)) {
                    if ($fp = fopen($cache_file, "rb")) {
                        while (!feof($fp)) {
                            print fread($fp, 4096);
                        }
                        fclose($fp);
                        printf("<!-- From %s, created at %s -->",
                        $cache_file_basename, strftime("%D %T", $cache_stat[9]));
                        return;
                    }
                }
            }
        }
    }
}

$gallery->session->offlineAlbums["albums.php"] = true;

/* Read the album list */
$albumDB = new AlbumDB(FALSE);

$gallery->session->albumName = '';
$page = 1;

/* If there are albums in our list, display them in the table */
list ($numPhotos, $numAccess, $numAlbums) = $albumDB->numAccessibleItems($gallery->user);

if (empty($gallery->session->albumListPage) || $gallery->session->albumListPage < 1) {
	$gallery->session->albumListPage = 1;
}
$perPage = $gallery->app->albumsPerPage;
$maxPages = max(ceil($numAlbums / $perPage), 1);

if ($gallery->session->albumListPage > $maxPages) {
	$gallery->session->albumListPage = $maxPages;
}

$pixelImage = '<img src="' . getImagePath('pixel_trans.gif') . '" width="1" height="1" alt="pixel_trans">';
$borderColor = $gallery->app->default["bordercolor"];

$navigator["page"] = $gallery->session->albumListPage;
$navigator["pageVar"] = "set_albumListPage";
$navigator["url"] = makeGalleryUrl("albums.php");
$navigator["maxPages"] = $maxPages;
$navigator["spread"] = 6;
$navigator["fullWidth"] = 100;
$navigator["widthUnits"] = "%";
$navigator["bordercolor"] = $borderColor;
$displayCommentLegend = 0;  // this determines if we display "* Item contains a comment" at end of page

if (!$GALLERY_EMBEDDED_INSIDE) {
    $title = htmlspecialchars($gallery->app->galleryTitle);

    doctype();
?>
<html>
<head>
  <title><?php echo $title ?></title>
  <?php
	common_header() ;

	/* prefetching/navigation */
	$topUrl  = makeGalleryUrl('albums.php', array('set_albumListPage' => 1));
    $firstUrl = makeGalleryUrl('albums.php',array('set_albumListPage' => 1));
	$prevUrl = makeGalleryUrl('albums.php', array('set_albumListPage' => $navigator['page']-1));
	$nextUrl = makeGalleryUrl('albums.php', array('set_albumListPage' => $navigator['page']+1));
	$lastUrl = makeGalleryUrl('albums.php', array('set_albumListPage' => $maxPages));

	if ($navigator['page'] > 1) {
?>
  <link rel="top" href="<?php echo $topUrl ?>">
  <link rel="first" href="<?php echo $firstUrl ?>">
  <link rel="prev" href="<?php echo  $prevUrl?>">
<?php
    }
    if ($navigator['page'] < $maxPages) { ?>
  <link rel="next" href="<?php echo $nextUrl ?>">
  <link rel="last" href="<?php echo $lastUrl?>">
<?php
    }
    if ($gallery->app->rssEnabled == "yes" && !$gallery->session->offline) {
    	$rssTitle = sprintf(gTranslate('core', "%s RSS"), $title);
    	$rssHref = $gallery->app->photoAlbumURL . "/rss.php";

        echo "<link rel=\"alternate\" title=\"$rssTitle\" href=\"$rssHref\" type=\"application/rss+xml\">";
    }
?>
</head>
<body dir="<?php echo $gallery->direction ?>">
<?php
}

includeHtmlWrap("gallery.header");

if (!$gallery->session->offline &&
  ( ($gallery->app->showSearchEngine == 'yes' && $numPhotos != 0) ||
  $GALLERY_EMBEDDED_INSIDE == 'phpBB2')) {
?>
<table width="100%" border="0" cellspacing="0" style="margin-bottom:2px">
<tr>
<?php
    if ($GALLERY_EMBEDDED_INSIDE == 'phpBB2') {
        echo '<td class="nav"><a href="index.php">'. sprintf($lang['Forum_Index'], $board_config['sitename']) . '</a></td>';
    }
    if ($numPhotos != 0) {
        echo '<td align="'. langRight() .'">'. addSearchForm('', 'right') .'</td>';
    }
?>
</tr>
</table>
<?php
}
?>

<!-- admin section begin -->
<?php
/* Admin Text (left side) */
$adminText = '';
if ($numAccess == $numAlbums) {
	$toplevel_str = gTranslate('core', "1 album","%d albums", $numAlbums, gTranslate('core', "No albums"));
} else {
	$toplevel_str = gTranslate('core', "1 top-level album","%d top-level albums", $numAlbums, gTranslate('core', "No top-level albums"));
}

$total_str = sprintf(gTranslate('core', "%d total"), $numAccess);
$image_str = gTranslate('core', "1 image", "%d images", $numPhotos, gTranslate('core', "no images"));
$page_str = gTranslate('core', "1 page", "%d pages", $maxPages, gTranslate('core', "no pages"));

if (($numAccess != $numAlbums) && $maxPages > 1) {
	$adminText .= sprintf(gTranslate('core', "%s (%s), %s on %s"), $toplevel_str, $total_str, $image_str, $page_str);
}
else if ($numAccess != $numAlbums) {
	$adminText .= sprintf(gTranslate('core', "%s (%s), %s"), $toplevel_str, $total_str, $image_str);
} else if ($maxPages > 1) {
	$adminText .= sprintf(gTranslate('core', "%s, %s on %s"), $toplevel_str, $image_str, $page_str);
} else {
	$adminText .= sprintf(gTranslate('core', "%s, %s"), $toplevel_str, $image_str);
}

if (!empty($gallery->app->stats_foruser) && $numPhotos != 0) {
	$adminText .= "\n<br>". generateStatsLinks();
}

/* Admin Text (right side) */

$adminCommands = '';
$iconElements = array();

if ($gallery->user->isLoggedIn() && !$gallery->session->offline) {

//	$displayName = $gallery->user->displayName();
//	$adminCommands .= sprintf(gTranslate('core', "Welcome, %s"), $displayName) . "&nbsp;&nbsp;<br>";
}

if ($gallery->app->gallery_slideshow_type != "off" && $numPhotos != 0) {
    $iconText = getIconText('display.gif', gTranslate('core', "Slideshow"));
    $iconElements[] = '<a href="'. makeGalleryUrl("slideshow.php",array("set_albumName" => null)) .'">'. $iconText .'</a>';
}

if ($gallery->user->canCreateAlbums() && !$gallery->session->offline) {
    $iconText = getIconText('folder_new.gif', gTranslate('core', "New album"));
    $iconElements[] = '<a href="' . doCommand("new-album", array(), "view_album.php") .'">'. $iconText .'</a>';
}

if ($gallery->user->isLoggedIn() && !$gallery->session->offline) {
    if ($gallery->user->isAdmin()) {

/*        $iconText = getIconText('unsortedList.gif', gTranslate('core', "Administer startpage"));
        $linkurl = makeGalleryUrl('administer_startpage.php', array('type' => 'popup'));
        $iconElements[] = popup_link($iconText, $linkurl, true);

        $iconText = getIconText('kdf.gif', gTranslate('core', "Admin page"));
        $iconElements[] = '<a href="'. makeGalleryUrl('admin-page.php') .'">'. $iconText .'</a> ';
*/
        $docsUrl = galleryDocs('admin');
        if ($docsUrl && file_exists("docs/index.html")) {
	        $iconText = getIconText('info.gif', gTranslate('core', "Documentation"));
    	    $linkurl = makeGalleryUrl($docsUrl, array());
//        	$iconElements[] = popup_link($iconText, $linkurl, true);
		    $iconElements[] = '<a href="' . doCommand("", array(), "docs/index.html") .'" target="_blank">'. $iconText .'</a>';
        }
    }

    if ($gallery->userDB->canModifyUser()) {
        $iconText = getIconText('yast_sysadmin.gif', gTranslate('core', "Preferences"));
        $iconElements[] = popup_link($iconText, "user_preferences.php", false, true, 500, 500);
    }

    if (!$GALLERY_EMBEDDED_INSIDE) {
        $iconText = getIconText('exit.gif', gTranslate('core', "Logout"));
        $iconElements[] = '<a href="'. doCommand("logout", array(), "albums.php") .'">'. $iconText .'</a>';
    }
} else {
    if (!$GALLERY_EMBEDDED_INSIDE) {
        $iconText = getIconText('identity.gif', gTranslate('core', "Login"));
        $iconElements[] = popup_link($iconText, "login.php", false, true, 500, 500);

        if (!strcmp($gallery->app->selfReg, 'yes')) {
            $iconText = getIconText('yast_sysadmin2.gif', gTranslate('core', "Register"));
            $iconElements[] = popup_link($iconText, "register.php", false, true, 500, 500);
        }
    }
}

$adminbox["text"] = $adminText;
$adminbox["commands"] = $adminCommands . makeIconMenu($iconElements, 'right');
$adminbox["bordercolor"] = $borderColor;

includeLayout('navtablebegin.inc');
includeLayout('adminbox.inc');
if ($navigator["maxPages"] > 1) {
    includeLayout('navtablemiddle.inc');
    echo "<!-- Begin top nav -->";
    includeLayout('navigator.inc');
}
includeLayout('navtableend.inc');

echo languageSelector();
echo "<!-- End top nav -->";

/* Display warnings about broken albums */
if ( (sizeof($albumDB->brokenAlbums) || sizeof($albumDB->outOfDateAlbums)) && $gallery->user->isAdmin()) {

	echo "\n<center><div style=\"width:60%; border-style:outset; border-width:5px; border-color:red; padding: 5px;\">";
	echo "\n<p class=\"head\"><u>". gTranslate('core', "Attention Gallery administrator!") ."</u></p>";

	if (sizeof($albumDB->brokenAlbums)) {
		echo sprintf(gTranslate('core', "%s has detected the following %d invalid album(s) in your albums directory<br>(%s):"),
		    Gallery(), sizeof($albumDB->brokenAlbums), $gallery->app->albumDir);
		echo "\n<p>";
		foreach ($albumDB->brokenAlbums as $tmpAlbumName) {
			echo "<br>$tmpAlbumName\n";
		}
	echo "\n</p>". gTranslate('core', "Please move it/them out of the albums directory.") ;
	}

	if(sizeof($albumDB->outOfDateAlbums)) {
		echo sprintf(gTranslate('core', "%s has detected that %d of your albums are out of date."),
			Gallery(), sizeof($albumDB->outOfDateAlbums));

		echo "\n<br>";
		echo sprintf(gTranslate('core', "Please %s."), popup_link(gTranslate('core', "upgrade those albums"), "upgrade_album.php",0,0,500,500,"error"));
	}
	echo "\n</div></center>\n";
}

if (getRequestVar('gRedir') == 1 && ! $gallery->session->gRedirDone) {
    echo "\n<center><div style=\"width:60%; border-style:outset; border-width:5px; border-color:red; padding: 5px\">";
    echo "\n<p class=\"head\"><u>". gTranslate('core', "Attention!") ."</u></p>";

    echo sprintf(gTranslate('core', 'The album or photo that you were attempting to view either does not exist, or requires user privileges that you do not possess. %s'), ($gallery->user->isLoggedIn() && !$GALLERY_EMBEDDED_INSIDE ? '' : sprintf(gTranslate('core', "%s and try again."),
    popup_link(gTranslate('core', "Log in"), "login.php", false, true, 500, 500))));
    echo "\n</div></center>\n";
    $gallery->session->gRedirDone = true;
}
?>

<!-- album table begin -->
<table width="100%" border="0" cellpadding="0" cellspacing="7">

<?php
$start = ($gallery->session->albumListPage - 1) * $perPage + 1;
$end = min($start + $perPage - 1, $numAlbums);
for ($i = $start; $i <= $end; $i++) {
    if(!$gallery->album = $albumDB->getAlbum($gallery->user, $i)) {
        echo gallery_error(sprintf(gTranslate('core', "The requested album with index %s is not valid."), $i));
        continue;
    }
    $isRoot = $gallery->album->isRoot(); // Only display album if it is a root album
    if($isRoot) {
        if (strcmp($gallery->app->showOwners, "no")) {
            $owner = $gallery->album->getOwner();
        }
        $tmpAlbumName = $gallery->album->fields["name"];
        $albumURL = makeAlbumUrl($tmpAlbumName);
?>

  <!-- Begin Album Column Block -->
  <tr>
  <td height="1"><?php echo $pixelImage ?></td>
  <td height="1"><?php echo $pixelImage ?></td>
<?php
  if (isset($gallery->app->albumTreeDepth) && $gallery->app->albumTreeDepth >0) {
?>
  <td height="1"><?php echo $pixelImage ?></td>

<?php
  }
?>
  </tr>
  <tr>
  <!-- Begin Image Cell -->
  <td align="center" valign="top">
	<hr />
<?php
      $gallery->html_wrap['borderColor'] = $borderColor;
      $gallery->html_wrap['borderWidth'] = 1;
      $gallery->html_wrap['pixelImage'] = getImagePath('pixel_trans.gif');
      $scaleTo = $gallery->app->highlight_size;
      list($iWidth, $iHeight) = $gallery->album->getHighlightDimensions($scaleTo);
      if (empty($iWidth)) {
          $iWidth = $gallery->app->highlight_size;
          $iHeight = 100;
      }
      $gallery->html_wrap['imageWidth'] = $iWidth;
      $gallery->html_wrap['imageHeight'] = $iHeight;
      $gallery->html_wrap['imageTag'] = $gallery->album->getHighlightTag($scaleTo,'', gTranslate('core', "Highlight for album:") ." ". $gallery->album->fields["title"]);
      $gallery->html_wrap['imageHref'] = $albumURL;
      $gallery->html_wrap['frame'] = $gallery->app->gallery_thumb_frame_style;
      includeHtmlWrap('inline_gallerythumb.frame');
?>
  </td>
  <!-- End Image Cell -->
  <!-- Begin Text Cell -->
  <td align="<?php echo langLeft() ?>" valign="top" class="albumdesc">
    <table cellpadding="0" cellspacing="0" width="100%" border="0" align="center">
	  <tr valign="top">
        <td class="" style='white-space:nowrap;text-align:right;' colspan='2'>
		  <hr />
          <?php
			include(dirname(__FILE__) . '/layout/adminAlbumCommands.inc');
          ?>
		</td>
	  </tr>
      <tr valign="middle">
        <td class="leftspacer"></td>
        <td>
          <table cellspacing="0" cellpadding="0" border="0" width='100%' class="mod_title_bg">
            <tr>
              <td class="mod_title_left"></td>
              <td class="title">
                <?php
			echo editField($gallery->album, "title", $albumURL),"&nbsp;";
		?>
              </td>
              <td class="mod_title_right"></td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
      <tr>
        <td class="mod_titleunder_hl"></td>
      </tr>
    </table>

  <?php
	/*
	* Description
	*/
	$description = editField($gallery->album, "description") ;
	if (!empty($description)) {
		echo "\n<div class=\"desc\">";
		echo "\n\t$description";
		echo "\n</div>";
	}
	/*
	* Owner
	*/
	if (strcmp($gallery->app->showOwners, "no")) {
		echo "\n<hr /><div class=\"desc\">";
		echo sprintf(gTranslate('core', "Owner: %s"),showOwner($owner));
		echo '</div>';
	}

	/*
	* Comment Indicator
	*/
	if($gallery->app->comments_enabled == 'yes') {
		// if comments_indication are "albums" or "both"
		switch ($gallery->app->comments_indication) {
			case "albums":
			case "both":
			$lastCommentDate = $gallery->album->lastCommentDate($gallery->app->comments_indication_verbose);
			print lastCommentString($lastCommentDate, $displayCommentLegend);
		} // end switch
	}

	// End Album Infos

?> </tr>
  <tr>
 <?php

 // Start tree
 	$_tree = false;
    if (isset($gallery->app->albumTreeDepth) && $gallery->app->albumTreeDepth > 0)
	if (isset($gallery->app->microTree) && $gallery->app->microTree == 'yes') {
		$_tree = true;
	?>
  <td colspan='2'><div style="width: 100%;">
  <?php echo printMicroChildren2(createTreeArray($gallery->album->fields["name"],$depth = 0)); ?>
  </div>
<?php } else { ?>
  <td valign="top" class="albumdesc" colspan='2'>
<?php echo "<hr />";printChildren(createTreeArray($gallery->album->fields["name"],$depth = 0)); ?>
<?php } ?>
		<?php
	/*
	* Url (only for admins and owner)
	*/
	if ($gallery->user->isAdmin() || $gallery->user->isOwnerOfAlbum($gallery->album)) {
		echo "<hr />" . gTranslate('core', "URL:") . ' <a href="'. $albumURL . '">';
		if (!$gallery->session->offline) {
			echo breakString(urldecode($albumURL), 80, '&', 5);
		} else {
			echo $tmpAlbumName;
		}
		echo '</a>';

		if (preg_match("~album[[:digit:]]+$~", $albumURL)) {
			if (!$gallery->session->offline) {
				echo '<br /><span class="error">'.
				gTranslate('core', "Hey!") .
				sprintf(gTranslate('core', "%s so that the URL is not so generic!"),
				popup_link(gTranslate('core', "Rename this album"), "rename_album.php?set_albumName={$tmpAlbumName}&index=$i",0,0,500,500,"error"));
				echo '</span>';
			}
		}

	}

	echo "\n<hr /><span class=\"fineprint\">";

	/*
	* Created / Last Changed
	*/
	$creationDate = $gallery->album->getCreationDate();
	$lastModifiedDate = $gallery->album->getLastModificationDate();
	if($creationDate) {
		printf(gTranslate('core', "Created on %s, last changed on %s."), $creationDate, $lastModifiedDate);
	}
	else {
		printf(gTranslate('core', "Last changed on %s."), $lastModifiedDate);
	}

	/*
	* Amount of items
	*/
	echo ' '; // Need a space between these two text blocks
	list($visibleItems) = $gallery->album->numItems($gallery->user, true);

	echo gTranslate('core', "This album contains 1 item.", "This album contains %d items.", $visibleItems);

	/*
	* Click counter + reset for it
	*/
	if (!($gallery->album->fields["display_clicks"] == "no") && !$gallery->session->offline) {
		$clickCount = $gallery->album->getClicks();

		echo "\n<br>";
		printf(gTranslate('core', "This album has been viewed %s since %s."),
		  gTranslate('core', "1 time", "%d times", $clickCount, gTranslate('core', "0 times")),
		  $gallery->album->getClicksDate());
	}
	$albumName = $gallery->album->fields["name"];
	if ($gallery->user->canWriteToAlbum($gallery->album) &&
	(!($gallery->album->fields["display_clicks"] == "no"))) {
		echo " ".popup_link("[" . gTranslate('core', "reset counter") ."]", doCommand("reset-album-clicks", array("set_albumName" => $albumName), "albums.php"), 1);
	}

	echo "\n</span>";

		?>
	</td>
  </tr>
  <!-- End Text Cell -->
  <!-- End Album Column Block -->

<?php
    } // if isRoot() close
} // for() loop
?>
</table>
<!-- album table end -->
<?php
if ($displayCommentLegend) {
	//display legend for comments
	echo '<p><span class="commentIndication">*</span>';
	echo '<span class="fineprint">'. gTranslate('core', "Comments available for this item.") .'</span></p>';
}
?>
<!-- bottom nav -->
<?php

if ($navigator["maxPages"] > 1) {
    includeLayout('navtablebegin.inc');
    includeLayout('navigator.inc');
    includeLayout('navtableend.inc');
} else {
    echo '<hr width="100%">';
}
?>
<p>
<!-- gallery.footer begin -->
<?php

includeHtmlWrap("gallery.footer");
?>
<!-- gallery.footer end -->

<?php if (!$GALLERY_EMBEDDED_INSIDE) { ?>
</body>
</html>
<?php } ?>
