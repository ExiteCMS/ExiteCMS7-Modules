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
 * $Id: index.php 15919 2007-03-05 15:14:55Z jenst $
 */
?>
<?php
// Hack prevention.

global $GALLERY_EMBEDDED_INSIDE;
global $GALLERY_EMBEDDED_INSIDE_TYPE;
global $GALLERY_MODULENAME;
global $MOS_GALLERY_PARAMS;

// Mambo / Joomla calls index.php directly for popups - we need to make
// sure that the option var has been extracted into the environment
// otherwise it just won't work.
$option = isset($_REQUEST['option']) ? $_REQUEST['option'] : null;
$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : null;
$mop = isset($_REQUEST['mop']) ? $_REQUEST['mop'] : null;
$name = isset($_REQUEST['name']) ? $_REQUEST['name'] : null;
$include = isset($_REQUEST['include']) ? $_REQUEST['include'] : null;

// default Gallery entry point
if (empty($include)) {
	$include = "albums.php";
}

/*
 * As a security precaution, only allow one of the following files to be included.
 * If you want Gallery to allow you to include other files (such as the random photo block)
 * then you need to add the name of the file including any relevant path components to this
 * array.
 */
$safe_to_include =
	 array(
	       "add_comment.php",
	       "add_photos.php",
	       "add_photos_frame.php",
	       "admin-page.php",
	       "administer_startpage.php",
	       "album_permissions.php",
	       "albums.php",
	       "block-random.php",
	       "captionator.php",
	       "copy_photo.php",
	       "create_user.php",
	       "delete_album.php",
	       "delete_photo.php",
	       "delete_user.php",
	       "do_command.php",
	       "download.php",
	       "ecard_form.php",
	       "edit_appearance.php",
	       "edit_caption.php",
	       "edit_field.php",
	       "edit_thumb.php",
	       "edit_watermark.php",
	       "extra_fields.php",
	       "gallery_remote.php",
	       "gallery_remote2.php",
	       "help/imagemap.php",
	       "help/metadataOnUpload.php",
	       "highlight_photo.php",
	       "imagemap.php",
	       "lib/colorpicker.php",
	       "login.php",
	       "manage_users.php",
	       "modify_user.php",
	       "move_album.php",
	       "move_photo.php",
	       "multi_create_user.php",
	       "photo_owner.php",
	       "poll_properties.php",
	       "poll_results.php",
	       "progress_uploading.php",
	       "publish_xp.php",
	       "publish_xp_docs.php",
	       "rearrange.php",
	       "rebuild_capture_dates.php",
	       "register.php",
	       "rename_album.php",
	       "reset_votes.php",
	       "resize_photo.php",
	       "rotate_photo.php",
	       "rss.php",
	       "save_photos.php",
	       "search.php",
	       "slideshow.php",
	       "slideshow_high.php",
	       "slideshow_low.php",
	       "sort_album.php",
	       "stats-wizard.php",
	       "stamp_preview.php",
	       "stats.php",
	       "tools/find_orphans.php",
	       "tools/despam-comments.php",
	       "tools/validate_albums.php",
	       "upgrade_album.php",
	       "upgrade_users.php",
	       "user_preferences.php",
	       "view_album.php",
	       "view_comments.php",
	       "view_photo.php",
	       "view_photo_properties.php",
	       "watermark_album.php",
	       );

if (!in_array($include, $safe_to_include)) {
    $include = htmlentities($include);
    print sprintf(_("Security error!  The file you tried to include is not on the <b>approved file list</b>.  To include this file you must edit %s's index.php and add <b>%s</b> to the <i>\$safe_to_include</i> array"),
		    'Gallery', $include);
} else {
	include(dirname(__FILE__) . "/$include");
}
?>