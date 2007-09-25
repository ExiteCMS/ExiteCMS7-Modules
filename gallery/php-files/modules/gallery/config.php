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
 * $Id: gpl.txt 15632 2007-01-02 06:01:08Z jenst $
 */
?>
<?php
/* 
 * Protect against very old versions of 4.0 (like 4.0RC1) which  
 * don't implicitly create a new stdClass() when you use a variable 
 * like a class. 
 */ 
if (!isset($gallery)) { 
        $gallery = new stdClass(); 
}
if (!isset($gallery->app)) { 
        $gallery->app = new stdClass(); 
}

/* Version  */
$gallery->app->config_version = '96';

/* Features */
$gallery->app->feature["zip"] = 1;
$gallery->app->feature["rewrite"] = 0; // (missing <i>GALLERY_REWRITE_OK</i> -- it's optional)
$gallery->app->feature["mirror"] = 0; // (missing <i>mirrorSites</i> -- it's optional)

/* Constants */
$gallery->app->galleryTitle = "";
$gallery->app->useIcons = "yes";
$gallery->app->skinname = "none";
$gallery->app->uploadMode = "form";
$gallery->app->albumDir = "/var/www/virtual/pli-images.office.vnvadvies.nl/files/gallery";
$gallery->app->tmpDir = "/tmp";
$gallery->app->photoAlbumURL = "http://pli-images.homelinux.org:8000/modules/gallery";
$gallery->app->albumDirURL = "http://pli-images.homelinux.org:8000/files/gallery";
$gallery->app->movieThumbnail = "/data/www/virtual/pli-images.office.vnvadvies.nl/modules/gallery/images/movie.thumb.jpg";
// optional <i>mirrorSites</i> missing
$gallery->app->graphics = "Netpbm";
// optional <i>ImPath</i> missing
$gallery->app->pnmDir = "/usr/bin";
$gallery->app->pnmtojpeg = "pnmtojpeg";
$gallery->app->pnmcomp = "pnmcomp";
$gallery->app->autorotate = "yes";
$gallery->app->jpegImageQuality = "90";
$gallery->app->highlightJpegImageQuality = "70";
$gallery->app->thumbJpegImageQuality = "50";
// optional <i>geeklog_dir</i> missing
$gallery->app->albumTreeDepth = "2";
$gallery->app->microTree = "no";
$gallery->app->highlight_size = "200";
$gallery->app->highlight_ratio = "0";
$gallery->app->showOwners = "no";
$gallery->app->albumsPerPage = "5";
$gallery->app->showSearchEngine = "yes";
$gallery->app->slowPhotoCount = "no";
$gallery->app->gallery_thumb_frame_style = "shadows";
$gallery->app->zipinfo = "/usr/bin/zipinfo";
$gallery->app->unzip = "/usr/bin/unzip";
$gallery->app->zip = "/usr/bin/zip";
// optional <i>rar</i> missing
// optional <i>use_exif</i> missing
// optional <i>exiftags</i> missing
$gallery->app->use_jpegtran = "/usr/bin/jpegtran";
$gallery->app->default_language = "en_US";
$gallery->app->ML_mode = "0";
$gallery->app->available_lang[] = "en_US";
$gallery->app->show_flags = "no";
$gallery->app->dateString = "%x";
$gallery->app->dateTimeString = "%c";
$gallery->app->emailOn = "no";
$gallery->app->adminEmail = "webmaster@pli-images.org";
$gallery->app->senderEmail = "noreply@pli-images.org";
$gallery->app->emailSubjPrefix = "[ExiteCMS Gallery]";
// optional <i>emailGreeting</i> missing
$gallery->app->selfReg = "no";
$gallery->app->selfRegCreate = "no";
$gallery->app->multiple_create = "no";
$gallery->app->adminCommentsEmail = "no";
$gallery->app->adminOtherChangesEmail = "no";
// optional <i>email_notification</i> missing
$gallery->app->useOtherSMTP = "yes";
$gallery->app->smtpHost = "localhost";
$gallery->app->smtpFromHost = "smtp.pli-images.org";
$gallery->app->smtpPort = "25";
// optional <i>smtpUserName</i> missing
// optional <i>smtpPassword</i> missing
$gallery->app->gallery_slideshow_type = "ordered";
$gallery->app->gallery_slideshow_length = "0";
$gallery->app->gallery_slideshow_loop = "yes";
$gallery->app->slideshowMode = "high";
$gallery->app->comments_enabled = "yes";
$gallery->app->comments_indication = "both";
$gallery->app->comments_indication_verbose = "yes";
$gallery->app->comments_anonymous = "no";
$gallery->app->comments_display_name = "!!USERNAME!!";
$gallery->app->comments_addType = "inside";
$gallery->app->comments_length = "300";
$gallery->app->comments_overview_for_all = "yes";
$gallery->app->watermarkDir = "/data/www/virtual/pli-images.office.vnvadvies.nl/images/watermark.gif";
$gallery->app->watermarkSizes = "2";
// optional <i>stats_foruser</i> missing
$gallery->app->stats_viewsCacheOn = "0";
$gallery->app->stats_viewsCacheExpireSecs = "60";
$gallery->app->stats_commentsCacheOn = "0";
$gallery->app->stats_commentsCacheExpireSecs = "600";
$gallery->app->stats_dateCacheOn = "0";
$gallery->app->stats_dateCacheExpireSecs = "-1";
$gallery->app->stats_votesCacheOn = "0";
$gallery->app->stats_votesCacheExpireSecs = "3600";
$gallery->app->stats_ratingsCacheOn = "0";
$gallery->app->stats_ratingsCacheExpireSecs = "3600";
$gallery->app->stats_cDateCacheOn = "0";
$gallery->app->stats_cDateCacheExpireSecs = "-1";
$gallery->app->debuglevel = "0";
$gallery->app->skipRegisterGlobals = "no";
$gallery->app->timeLimit = "30";
$gallery->app->IM_HQ = "yes";
$gallery->app->blockRandomCache = "86400";
$gallery->app->blockRandomAttempts = "2";
$gallery->app->cacheExif = "no";
$gallery->app->devMode = "yes";
$gallery->app->useSyslog = "no";
$gallery->app->use_flock = "yes";
$gallery->app->expectedExecStatus = "0";
$gallery->app->sessionVar = "gallery_session";
$gallery->app->rssEnabled = "yes";
$gallery->app->rssMode = "highlight";
// optional <i>rssHighlight</i> missing
$gallery->app->rssMaxAlbums = "25";
$gallery->app->rssVisibleOnly = "yes";
$gallery->app->rssDCDate = "no";
$gallery->app->rssBigPhoto = "no";
$gallery->app->rssPhotoTag = "yes";
$gallery->app->userDir = "/var/www/virtual/pli-images.office.vnvadvies.nl/files/gallery/.users";

/* Defaults */
$gallery->app->default["cols"] = "3";
$gallery->app->default["rows"] = "4";
$gallery->app->default["bordercolor"] = "#0C386F";
$gallery->app->default["border"] = "1";
$gallery->app->default["font"] = "arial";
$gallery->app->default["thumb_size"] = "150";
$gallery->app->default["thumb_ratio"] = "0";
$gallery->app->default["resize_size"] = "640";
$gallery->app->default["resize_file_size"] = "0";
$gallery->app->default["max_size"] = "0";
$gallery->app->default["max_file_size"] = "0";
$gallery->app->default["useOriginalFileNames"] = "yes";
$gallery->app->default["add_to_beginning"] = "no";
$gallery->app->default["fit_to_window"] = "no";
$gallery->app->default["use_fullOnly"] = "no";
$gallery->app->default["print_photos"] = "";
$gallery->app->default["mPUSHAccount"] = "gallery";
$gallery->app->default["ecards"] = "no";
$gallery->app->default["returnto"] = "yes";
$gallery->app->default["defaultPerms"] = "nobody";
$gallery->app->default["display_clicks"] = "yes";
$gallery->app->default["extra_fields"] = "Description";
$gallery->app->default["showDimensions"] = "yes";
$gallery->app->default["item_owner_modify"] = "yes";
$gallery->app->default["item_owner_delete"] = "yes";
$gallery->app->default["item_owner_display"] = "no";
$gallery->app->default["voter_class"] = "Logged in";
$gallery->app->default["poll_type"] = "rank";
$gallery->app->default["poll_scale"] = "3";
$gallery->app->default["poll_hint"] = "Vote for this image";
$gallery->app->default["poll_show_results"] = "yes";
$gallery->app->default["poll_num_results"] = "5";
$gallery->app->default["poll_orientation"] = "vertical";
$gallery->app->default["poll_nv_pairs"][0]["name"] = "Excellent";
$gallery->app->default["poll_nv_pairs"][0]["value"] = "5";
$gallery->app->default["poll_nv_pairs"][1]["name"] = "Very Good";
$gallery->app->default["poll_nv_pairs"][1]["value"] = "4";
$gallery->app->default["poll_nv_pairs"][2]["name"] = "Good";
$gallery->app->default["poll_nv_pairs"][2]["value"] = "3";
$gallery->app->default["poll_nv_pairs"][3]["name"] = "Average";
$gallery->app->default["poll_nv_pairs"][3]["value"] = "2";
$gallery->app->default["poll_nv_pairs"][4]["name"] = "Poor";
$gallery->app->default["poll_nv_pairs"][4]["value"] = "1";
$gallery->app->default["poll_nv_pairs"][5]["name"] = "";
$gallery->app->default["poll_nv_pairs"][5]["value"] = "";
$gallery->app->default["poll_nv_pairs"][6]["name"] = "";
$gallery->app->default["poll_nv_pairs"][6]["value"] = "";
$gallery->app->default["poll_nv_pairs"][7]["name"] = "";
$gallery->app->default["poll_nv_pairs"][7]["value"] = "";
$gallery->app->default["poll_nv_pairs"][8]["name"] = "";
$gallery->app->default["poll_nv_pairs"][8]["value"] = "";
$gallery->app->default["slideshow_type"] = "ordered";
$gallery->app->default["slideshow_recursive"] = "no";
$gallery->app->default["slideshow_loop"] = "yes";
$gallery->app->default["slideshow_length"] = "0";
$gallery->app->default["nav_thumbs"] = "no";
$gallery->app->default["nav_thumbs_style"] = "fixed";
$gallery->app->default["nav_thumbs_first_last"] = "no";
$gallery->app->default["nav_thumbs_prev_shown"] = "1";
$gallery->app->default["nav_thumbs_next_shown"] = "1";
$gallery->app->default["nav_thumbs_location"] = "top";
$gallery->app->default["nav_thumbs_size"] = "45";
$gallery->app->default["nav_thumbs_current_bonus"] = "15";
$gallery->app->default["album_frame"] = "simple_book";
$gallery->app->default["thumb_frame"] = "solid";
$gallery->app->default["image_frame"] = "solid";
?>
