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
 * $Id: admin-page.php 16803 2007-08-01 20:49:39Z jenst $
 *
 */
?>
<?php

if (!isset($gallery->version)) {
        require_once(dirname(__FILE__) . '/init.php');
}

// Security check
if (!$gallery->user->isAdmin()) {
	header('Location: ' . makeAlbumHeaderUrl());
	exit;
}

$adminOptions[] = array( 'text' => gTranslate('core', "Statistics"),
			 'url' => makeGalleryUrl('stats-wizard.php'),
			 'longtext' => gTranslate('core', "View some statistics about your Gallery. Such as most viewed pictures, or best rated photos etc."));

$adminOptions[] = array( 'text' => gTranslate('core', "Configuration wizard"),
			 'url' => $gallery->app->photoAlbumURL . '/setup/index.php',
			 'longtext' => gTranslate('core', "Use the config wizard to reconfigure or tweak your Gallery."));

$adminOptions[] = array( 'text' => gTranslate('core', "Find orphans"),
			 'url' => makeGalleryUrl('tools/find_orphans.php'),
			 'longtext' => gTranslate('core', "Find, remove or re-attach orphaned elements."));

$adminOptions[] = array( 'text' => gTranslate('core', "Find comment spam"),
			 'url' => makeGalleryUrl('tools/despam-comments.php'),
			 'longtext' => gTranslate('core', "Find and remove comments that contains spam."));

$adminOptions[] = array( 'text' => gTranslate('core', "Validate albums"),
			 'url' => makeGalleryUrl('tools/validate_albums.php'),
			 'longtext' => gTranslate('core', "Identify invalid albums, missing files, and other errors that may prevent you from migrating to Gallery 2."));

#$adminOptions[] = array( 'text' => gTranslate('core', "Gallery backup"),
#			 'url' => makeGalleryUrl('backup_albums.php'),
#			 'longtext' => gTranslate('core', "Make a backup of your Gallery."));

if (!$GALLERY_EMBEDDED_INSIDE) {
    $adminOptions[]  = array('text' => gTranslate('core', "Manage users"),
			 'popupFile' => 'manage_users.php',
			 'longtext' => gTranslate('core', "Manage your users."));
}

array_sort_by_fields($adminOptions, 'text', 'asc');

if (!$GALLERY_EMBEDDED_INSIDE) {
    doctype();
?>
<html>
<head>
<title><?php echo $gallery->app->galleryTitle; ?>::<?php echo gTranslate('core', "Admin options") ?></title>
<?php
	common_header() ;
?>
</head>
<body dir="<?php echo $gallery->direction ?>">
<?php
}

includeHtmlWrap('gallery.header');

$adminbox['text'] ='<span class="head">'. gTranslate('core', "Admin options") .'</span>';
$adminbox['commands'] = '[<a href="'. makeAlbumUrl() .'">'. gTranslate('core', "Return to gallery") .'</a>]';
$breadcrumb['text'][] = languageSelector();

includeLayout('navtablebegin.inc');
includeLayout('adminbox.inc');
includeLayout('navtablemiddle.inc');
includeLayout('breadcrumb.inc');
includeLayout('navtableend.inc');

if(!empty($adminOptions)) {
	echo "\n" .'<table style="width:100%; margin:10px; margin-bottom:50px">';
	foreach ($adminOptions as $option) {

		echo "\n<tr>";
		if (isset($option['url'])) {
			$link = '<a class="admin" href="'. $option['url'] .'">'. $option['text'] .'</a>';
		} else {
			$link = popup_link($option['text'], $option['popupFile'], false, true, 500, 500, 'admin');
		}
		echo "\n<td class=\"adm_options\" style=\"white-space:nowrap;\">$link</td>";
		echo "\n<td class=\"adm_options\">". $option['longtext'] ."</td>";
		echo "\n</tr>";
	}
	echo "\n</table>";
}

$validation_file = basename(__FILE__);
includeHtmlWrap("general.footer");

if (!$GALLERY_EMBEDDED_INSIDE) { ?>
</body>
</html>
<?php } ?>
