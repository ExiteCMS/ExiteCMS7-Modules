<?php
/**
 * Gallery SVN info
 * $Id: adminAlbumCommands.inc 16803 2007-08-01 20:49:39Z jenst $
*/
?>
<!-- Begin adminAlbumCommands -->
<?php
$has_commands=false;
/* User is allowed to delete the album */
if ($gallery->user->canDeleteAlbum($gallery->album)) {
    $iconText = getIconText('page_delete.gif', gTranslate('core',"Delete album"), 'yes');
	echo "\n\t". popup_link($iconText, "delete_album.php?set_albumName={$tmpAlbumName}");
	$has_commands = true;
}

/* User is allowed to change the album */
if ($gallery->user->canWriteToAlbum($gallery->album)) {
    $iconText = getIconText('page_go.gif', gTranslate('core',"Move album"), 'yes');
	echo "\n\t". popup_link($iconText, "move_album.php?set_albumName={$tmpAlbumName}&index=$i&reorder=0");
    $iconText = getIconText('page_refresh.gif', gTranslate('core',"Reorder album"), 'yes');
	echo "\n\t". popup_link($iconText, "move_album.php?set_albumName={$tmpAlbumName}&index=$i&reorder=1");
    $iconText = getIconText('page_save.gif', gTranslate('core',"Rename album"), 'yes');
	echo "\n\t". popup_link($iconText, "rename_album.php?set_albumName={$tmpAlbumName}&index=$i");
	$has_commands = true;
}

/* User ist allowed to change album captions */
/* Should this be into the above group ? */
if ($gallery->user->canChangeTextOfAlbum($gallery->album) && !$gallery->session->offline) {
	echo "\n\t". '<a href="'. makeGalleryUrl("captionator.php", array("set_albumName" => $tmpAlbumName)) . '">' . 
		getIconText('picture_edit.gif', gTranslate('core',"Edit captions"), 'yes') . '</a>';
	$has_commands = true;
}

/* User is Admin or Owner */
if ($gallery->user->isAdmin() || $gallery->user->isOwnerOfAlbum($gallery->album)) {

	/* User is allowed to change Album Permissions */
    $iconText = getIconText('lock_edit.gif', gTranslate('core',"Permissions"), 'yes');
	echo "\n\t". popup_link($iconText, "album_permissions.php?set_albumName={$tmpAlbumName}");
    $iconText = getIconText('table_edit.gif', gTranslate('core',"Properties"), 'yes');
	echo "\n\t". popup_link($iconText, "edit_appearance.php?set_albumName={$tmpAlbumName}", 0, true, 500, 600);

	/* User is allowed to view ALL comments */
	if ($gallery->user->canViewComments($gallery->album)
		&& ($gallery->app->comments_enabled == 'yes')
		&& ($gallery->album->lastCommentDate("no") != -1)) {
	    	echo "\n\t". '<a href="'. makeGalleryUrl("view_comments.php", array("set_albumName" => $tmpAlbumName)) . '">' .
				getIconText('comments.gif', gTranslate('core',"View&nbsp;comments"), 'yes') . '</a>';
	}

	/* Watermarking support is enabled and user is allowed to watermark images/albums */
	if (!empty($gallery->app->watermarkDir) && $gallery->album->numPhotos(1)) {
	    $iconText = getIconText('image_edit.gif', gTranslate('core',"Watermark&nbsp;album"), 'yes');
		echo "\n\t". popup_link($iconText, "watermark_album.php?set_albumName={$tmpAlbumName}");
	}
	$has_commands = true;
}

/* user can download this album */
if ($gallery->user->canDownloadAlbum($gallery->album) && $gallery->album->numPhotos(1)) {
    $iconText = getIconText('compress.gif', gTranslate('core', "Download entire album as archive"), 'yes');
    echo "\n\t". popup_link($iconText, "download.php?set_albumName=$tmpAlbumName",false,false,500,500);
	$has_commands = true;
}
if ($has_commands) echo "<hr />";
?>
<!-- End adminAlbumCommands -->
