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
$gallery->app->config_version = '1';

// Settings defined through the admin panel
$gallery->app->feature["zip"] = isset($settings['gallery_zip']) ? $settings['gallery_zip'] : 1;
$gallery->app->galleryTitle = isset($settings['gallery_title']) ? $settings['gallery_title'] : "ExiteCMS Photo Gallery";
$gallery->app->albumDir = isset($settings['gallery_albumdir']) ? PATH_ROOT.$settings['gallery_albumdir'] : PATH_ROOT . "images/gallery";
$gallery->app->photoAlbumURL = $settings['siteurl']."modules/gallery";
$gallery->app->albumDirURL = $settings['siteurl'].(isset($settings['gallery_albumdir']) ? $settings['gallery_albumdir'] : BASEDIR . "images/gallery");
$gallery->app->albumTreeDepth = isset($settings['gallery_albumtreedepth']) ? $settings['gallery_albumtreedepth'] : "2";
$gallery->app->microTree = isset($settings['gallery_microtree']) ? $settings['gallery_microtree'] : "yes";
$gallery->app->highlight_size = isset($settings['gallery_highlight_size']) ? $settings['gallery_highlight_size'] : "200";
$gallery->app->highlight_ratio = isset($settings['gallery_highlight_ratio']) ? $settings['gallery_highlight_ratio'] : "0";
$gallery->app->showOwners = isset($settings['gallery_showowners']) ? $settings['gallery_showowners'] : "yes";
$gallery->app->albumsPerPage = isset($settings['gallery_albumsperpage']) ? $settings['gallery_albumsperpage'] : "5";
$gallery->app->showSearchEngine = isset($settings['gallery_showsearchengine']) ? $settings['gallery_showsearchengine'] : "yes";
$gallery->app->gallery_thumb_frame_style = isset($settings['gallery_framestyle']) ? $settings['gallery_framestyle'] : "shadows";
if (isset($settings['gallery_zipinfo'])) $gallery->app->zipinfo = $settings['gallery_zipinfo'];
if (isset($settings['gallery_zip'])) $gallery->app->zipinfo = $settings['gallery_zip'];
if (isset($settings['gallery_unzip'])) $gallery->app->zipinfo = $settings['gallery_unzip'];
if (isset($settings['gallery_rar'])) $gallery->app->zipinfo = $settings['gallery_rar'];
if (isset($settings['gallery_use_exif'])) $gallery->app->zipinfo = $settings['gallery_use_exif'];
if (isset($settings['gallery_jpegtran'])) $gallery->app->zipinfo = $settings['gallery_jpegtran'];
$gallery->app->cacheExif = isset($settings['gallery_cacheexif']) ? $settings['gallery_cacheexif'] : "no";
$gallery->app->dateString = $settings['shortdate'];
$gallery->app->dateTimeString = $settings['subheaderdate'];
$gallery->app->gallery_slideshow_type = isset($settings['gallery_slideshow_type']) ? $settings['gallery_slideshow_type'] : "ordered";
$gallery->app->gallery_slideshow_length = isset($settings['gallery_slideshow_length']) ? $settings['gallery_slideshow_length'] : "0";
$gallery->app->gallery_slideshow_loop = isset($settings['gallery_slideshow_loop']) ? $settings['gallery_slideshow_loop'] : "yes";
$gallery->app->slideshowMode = isset($settings['gallery_slideshowmode']) ? $settings['gallery_slideshowmode'] : "high";
$gallery->app->comments_enabled = isset($settings['gallery_comments_enabled']) ? $settings['gallery_comments_enabled'] : "yes";
$gallery->app->comments_indication = isset($settings['gallery_comments_indication']) ? $settings['gallery_comments_indication'] : "both";
$gallery->app->comments_indication_verbose = isset($settings['gallery_comments_verbose']) ? $settings['gallery_comments_verbose'] : "yes";
$gallery->app->comments_anonymous = isset($settings['gallery_comments_anonymous']) ? $settings['gallery_comments_anonymous'] : "no";
$gallery->app->comments_display_name = isset($settings['gallery_comments_displayname']) ? $settings['gallery_comments_displayname'] : "!!USERNAME!!";
$gallery->app->comments_addType = isset($settings['gallery_comments_addtype']) ? $settings['gallery_comments_addtype'] : "inside";
$gallery->app->comments_length = isset($settings['gallery_comments_length']) ? $settings['gallery_comments_length'] : "300";
$gallery->app->comments_overview_for_all = isset($settings['gallery_comments_overview_all']) ? $settings['gallery_comments_overview_all'] : "yes";
$gallery->app->watermarkDir = $gallery->app->albumDir;
$gallery->app->debuglevel = empty($settings['debug_querylog']) ? "0" : (checkgroup($settings['debug_querylog']) ? "2" : "0");
$gallery->app->devMode = empty($settings['debug_querylog']) ? "no" : (checkgroup($settings['debug_querylog']) ? "yes" : "no");
$gallery->app->rssEnabled = isset($settings['gallery_rssenabled']) ? $settings['gallery_rssenabled'] : "yes";
$gallery->app->rssMode = isset($settings['gallery_rssmode']) ? $settings['gallery_rssmode'] : "highlight";
$gallery->app->rssHighlight = isset($settings['gallery_rsshighlight']) ? $settings['gallery_rsshighlight'] : "";
$gallery->app->rssMaxAlbums = isset($settings['gallery_rssmaxalbums']) ? $settings['gallery_rssmaxalbums'] : "25";
$gallery->app->rssVisibleOnly = isset($settings['gallery_rssvisibleonly']) ? $settings['gallery_rssvisibleonly'] : "yes";
$gallery->app->rssDCDate = isset($settings['gallery_rssdcdate']) ? $settings['gallery_rssdcdate'] : "no";
$gallery->app->rssBigPhoto = isset($settings['gallery_rssbigphoto']) ? $settings['gallery_rssbigphoto'] : "no";
$gallery->app->rssPhotoTag = isset($settings['gallery_rssphototag']) ? $settings['gallery_rssphototag'] : "yes";

// Fixed settings for ExiteCMS
$gallery->app->feature["rewrite"] = 0;	
$gallery->app->feature["mirror"] = 0;
$gallery->app->useIcons = "yes";
$gallery->app->skinname = "none";
$gallery->app->uploadMode = "form";
$gallery->app->tmpDir = "/tmp";
$gallery->app->movieThumbnail = PATH_ROOT."modules/gallery/images/movie.thumb.jpg";
$gallery->app->slowPhotoCount = "no";
$gallery->app->ML_mode = "1";
$gallery->app->show_flags = "no";
$gallery->app->emailOn = "no";
$gallery->app->adminEmail = "";
$gallery->app->senderEmail = "";
$gallery->app->emailSubjPrefix = "";
$gallery->app->emailGreeting = "";
$gallery->app->selfReg = "no";
$gallery->app->selfRegCreate = "no";
$gallery->app->multiple_create = "no";
$gallery->app->adminCommentsEmail = "no";
$gallery->app->adminOtherChangesEmail = "no";
$gallery->app->email_notification = "no";
$gallery->app->useOtherSMTP = "no";
$gallery->app->smtpHost = "";
$gallery->app->smtpFromHost = "";
$gallery->app->smtpPort = "";
$gallery->app->smtpUserName = "";
$gallery->app->smtpPassword = "";
$gallery->app->watermarkSizes = "2";
$gallery->app->stats_foruser = "0";
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
$gallery->app->skipRegisterGlobals = "no";
$gallery->app->timeLimit = "30";
$gallery->app->sessionVar = "gallery";
$gallery->app->userDir = "";
$gallery->app->blockRandomCache = "86400";	// not used
$gallery->app->blockRandomAttempts = "2";	// not used
$gallery->app->useSyslog = "no";
$gallery->app->use_flock = "yes";
$gallery->app->expectedExecStatus = "0";

// These values are placeholders, and will be filled in at runtime in the code
$gallery->app->default_language = "en_US";
$gallery->app->available_lang[] = "en_US";

// ** TODO ** check for Netpbm of ImageMagick!
$gallery->app->graphics = "Netpbm";
$gallery->app->pnmDir = "/usr/bin";
$gallery->app->pnmtojpeg = "pnmtojpeg";
$gallery->app->pnmcomp = "pnmcomp";
$gallery->app->autorotate = "yes";
$gallery->app->jpegImageQuality = "90";
$gallery->app->highlightJpegImageQuality = "70";
$gallery->app->thumbJpegImageQuality = "50";
$gallery->app->IM_HQ = "yes";	// ImageMagick High Quality

/* Album Defaults */
$gallery->app->default["cols"] = "2";
$gallery->app->default["rows"] = "4";
$gallery->app->default["bordercolor"] = "#0C386F";
$gallery->app->default["border"] = "1";
$gallery->app->default["font"] = "arial";
$gallery->app->default["thumb_size"] = "150";
$gallery->app->default["thumb_ratio"] = "0";
$gallery->app->default["resize_size"] = "600";
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
