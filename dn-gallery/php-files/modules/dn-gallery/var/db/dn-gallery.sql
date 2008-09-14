-- phpMyAdmin SQL Dump
-- version 2.11.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 16, 2008 at 01:20 AM
-- Server version: 5.0.45
-- PHP Version: 5.2.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dn-gallery`
--

-- --------------------------------------------------------

--
-- Table structure for table `access_ref`
--

CREATE TABLE IF NOT EXISTS `access_ref` (
  `access_ref_id` mediumint(9) NOT NULL auto_increment,
  `access_ref_name` varchar(15) default NULL,
  PRIMARY KEY  (`access_ref_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `access_ref`
--

INSERT INTO `access_ref` (`access_ref_id`, `access_ref_name`) VALUES
(1, 'INSERT'),
(2, 'EDIT'),
(3, 'DELETE'),
(4, 'READ ONLY');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `comment_id` mediumint(9) NOT NULL auto_increment,
  `gallery_file_id` mediumint(9) default NULL,
  `comments_detail` varchar(255) default NULL,
  `vmt_user_id` mediumint(9) default NULL,
  `comments_date` datetime default NULL,
  PRIMARY KEY  (`comment_id`),
  KEY `gallery_id` (`gallery_file_id`),
  KEY `vmt_user_id` (`vmt_user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `gallery_file_id`, `comments_detail`, `vmt_user_id`, `comments_date`) VALUES
(2, 476, 'Some comments', 12, '2008-08-16 00:58:27');

-- --------------------------------------------------------

--
-- Table structure for table `gallery_album`
--

CREATE TABLE IF NOT EXISTS `gallery_album` (
  `gallery_album_id` mediumint(9) NOT NULL auto_increment,
  `gallery_album_title` varchar(255) default NULL,
  `gallery_album_desc` varchar(255) default NULL,
  `gallery_album_icon` varchar(255) default NULL,
  `gallery_album_date` date default NULL,
  `is_active` char(6) default NULL,
  `access` char(10) NOT NULL default 'PUBLIC',
  `owner` mediumint(9) NOT NULL default '1',
  `viewed` int(11) NOT NULL default '0',
  PRIMARY KEY  (`gallery_album_id`),
  KEY `full_text_content_title` (`gallery_album_title`),
  KEY `owner` (`owner`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `gallery_album`
--

INSERT INTO `gallery_album` (`gallery_album_id`, `gallery_album_title`, `gallery_album_desc`, `gallery_album_icon`, `gallery_album_date`, `is_active`, `access`, `owner`, `viewed`) VALUES
(9, 'DN-Gallery Screenshots', 'Some screenshots of DN-Gallery ', 'var/usr/images/Icon/clip_3.jpg', '2008-08-16', 'Active', 'PUBLIC', 12, 6),
(11, 'Some screenshots from my previous projects', ' ', NULL, '2008-08-16', 'Active', 'PUBLIC', 12, 0);

-- --------------------------------------------------------

--
-- Table structure for table `gallery_file`
--

CREATE TABLE IF NOT EXISTS `gallery_file` (
  `id` mediumint(9) NOT NULL auto_increment,
  `gallery_album_id` mediumint(9) default NULL,
  `photo_title` tinytext,
  `photo_desc` text,
  `thumb_file` varchar(255) default NULL,
  `file_name` varchar(255) default NULL,
  `keywords` varchar(255) default NULL,
  PRIMARY KEY  (`id`),
  KEY `gallery_album_id` (`gallery_album_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=542 ;

--
-- Dumping data for table `gallery_file`
--

INSERT INTO `gallery_file` (`id`, `gallery_album_id`, `photo_title`, `photo_desc`, `thumb_file`, `file_name`, `keywords`) VALUES
(476, 9, 'Sign in ', ' ', 'var/usr/images/Gallery/Thumbnail/clip.jpg', 'var/usr/images/Gallery/clip.jpg', 'dn gallery, sign in '),
(477, 9, 'sign up ', ' ', 'var/usr/images/Gallery/Thumbnail/clip_2.jpg', 'var/usr/images/Gallery/clip_2.jpg', 'dn gallery,  sign up '),
(478, 9, 'forgot username ', ' ', 'var/usr/images/Gallery/Thumbnail/clip_3.jpg', 'var/usr/images/Gallery/clip_3.jpg', 'dn gallery, forgot username '),
(479, 9, 'forgot password ', ' ', 'var/usr/images/Gallery/Thumbnail/clip_4.jpg', 'var/usr/images/Gallery/clip_4.jpg', 'dn gallery, forgot password '),
(480, 9, 'Album setup form ', ' ', 'var/usr/images/Gallery/Thumbnail/clip_5.jpg', 'var/usr/images/Gallery/clip_5.jpg', 'dn gallery, album setup, form '),
(481, 9, 'Album list ', ' ', 'var/usr/images/Gallery/Thumbnail/clip_6.jpg', 'var/usr/images/Gallery/clip_6.jpg', 'dn gallery, album, list '),
(482, 9, 'User / group privileges ', ' ', 'var/usr/images/Gallery/Thumbnail/clip_7.jpg', 'var/usr/images/Gallery/clip_7.jpg', 'dn gallery, user/group, privilege '),
(483, 9, 'Privilege Setup ', ' ', 'var/usr/images/Gallery/Thumbnail/clip_8.jpg', 'var/usr/images/Gallery/clip_8.jpg', 'dn gallery, privilege, setup '),
(484, 9, 'User / group privileges ', ' ', 'var/usr/images/Gallery/Thumbnail/clip_9.jpg', 'var/usr/images/Gallery/clip_9.jpg', 'dn gallery, user/group, privilege '),
(485, 9, 'Detail Privileges setup ', ' ', 'var/usr/images/Gallery/Thumbnail/clip_10.jpg', 'var/usr/images/Gallery/clip_10.jpg', 'dn gallery, detail privilege, setup '),
(486, 9, 'Main page ', ' ', 'var/usr/images/Gallery/Thumbnail/clip_11.jpg', 'var/usr/images/Gallery/clip_11.jpg', 'dn gallery, main page, index '),
(487, 9, 'Photo View ', ' ', 'var/usr/images/Gallery/Thumbnail/clip_12.jpg', 'var/usr/images/Gallery/clip_12.jpg', 'dn gallery, photo, view '),
(488, 9, 'Thumbnail View ', ' ', 'var/usr/images/Gallery/Thumbnail/clip_13.jpg', 'var/usr/images/Gallery/clip_13.jpg', 'dn gallery, thumbnail, view '),
(489, 9, 'Search Result ', ' ', 'var/usr/images/Gallery/Thumbnail/clip_14.jpg', 'var/usr/images/Gallery/clip_14.jpg', 'dn gallery, search result '),
(490, 9, 'Comment Form ', ' ', 'var/usr/images/Gallery/Thumbnail/clip_15.jpg', 'var/usr/images/Gallery/clip_15.jpg', 'dn gallery, comment, form '),
(491, 9, 'Comments ', ' ', 'var/usr/images/Gallery/Thumbnail/clip_16.jpg', 'var/usr/images/Gallery/clip_16.jpg', 'dn gallery, comments '),
(515, 11, ' ', ' ', 'var/usr/images/Gallery/Thumbnail/My_Clip000.jpg', 'var/usr/images/Gallery/My_Clip000.jpg', ' '),
(516, 11, ' ', ' ', 'var/usr/images/Gallery/Thumbnail/My_Clip001.jpg', 'var/usr/images/Gallery/My_Clip001.jpg', ' '),
(517, 11, ' ', ' ', 'var/usr/images/Gallery/Thumbnail/My_Clip002.jpg', 'var/usr/images/Gallery/My_Clip002.jpg', ' '),
(518, 11, ' ', ' ', 'var/usr/images/Gallery/Thumbnail/My_Clip003.jpg', 'var/usr/images/Gallery/My_Clip003.jpg', ' '),
(519, 11, ' ', ' ', 'var/usr/images/Gallery/Thumbnail/My_Clip004.jpg', 'var/usr/images/Gallery/My_Clip004.jpg', ' '),
(520, 11, ' ', ' ', 'var/usr/images/Gallery/Thumbnail/My_Clip005.jpg', 'var/usr/images/Gallery/My_Clip005.jpg', ' '),
(521, 11, ' ', ' ', 'var/usr/images/Gallery/Thumbnail/My_Clip006.jpg', 'var/usr/images/Gallery/My_Clip006.jpg', ' '),
(522, 11, ' ', ' ', 'var/usr/images/Gallery/Thumbnail/My_Clip007.jpg', 'var/usr/images/Gallery/My_Clip007.jpg', ' '),
(523, 11, ' ', ' ', 'var/usr/images/Gallery/Thumbnail/My_Clip008.jpg', 'var/usr/images/Gallery/My_Clip008.jpg', ' '),
(524, 11, ' ', ' ', 'var/usr/images/Gallery/Thumbnail/My_Clip009.jpg', 'var/usr/images/Gallery/My_Clip009.jpg', ' '),
(525, 11, ' ', ' ', 'var/usr/images/Gallery/Thumbnail/My_Clip010.jpg', 'var/usr/images/Gallery/My_Clip010.jpg', ' '),
(526, 11, ' ', ' ', 'var/usr/images/Gallery/Thumbnail/My_Clip011.jpg', 'var/usr/images/Gallery/My_Clip011.jpg', ' '),
(527, 11, ' ', ' ', 'var/usr/images/Gallery/Thumbnail/My_Clip012.jpg', 'var/usr/images/Gallery/My_Clip012.jpg', ' '),
(528, 11, ' ', ' ', 'var/usr/images/Gallery/Thumbnail/My_Clip013.jpg', 'var/usr/images/Gallery/My_Clip013.jpg', ' '),
(529, 11, ' ', ' ', 'var/usr/images/Gallery/Thumbnail/My_Clip014.jpg', 'var/usr/images/Gallery/My_Clip014.jpg', ' '),
(530, 11, ' ', ' ', 'var/usr/images/Gallery/Thumbnail/My_Clip015.jpg', 'var/usr/images/Gallery/My_Clip015.jpg', ' '),
(531, 11, ' ', ' ', 'var/usr/images/Gallery/Thumbnail/My_Clip016.jpg', 'var/usr/images/Gallery/My_Clip016.jpg', ' '),
(532, 11, ' ', ' ', 'var/usr/images/Gallery/Thumbnail/My_Clip017.jpg', 'var/usr/images/Gallery/My_Clip017.jpg', ' '),
(533, 11, ' ', ' ', 'var/usr/images/Gallery/Thumbnail/My_Clip018.jpg', 'var/usr/images/Gallery/My_Clip018.jpg', ' '),
(534, 11, ' ', ' ', 'var/usr/images/Gallery/Thumbnail/My_Clip019.jpg', 'var/usr/images/Gallery/My_Clip019.jpg', ' '),
(535, 11, ' ', ' ', 'var/usr/images/Gallery/Thumbnail/My_Clip020.jpg', 'var/usr/images/Gallery/My_Clip020.jpg', ' '),
(536, 11, ' ', ' ', 'var/usr/images/Gallery/Thumbnail/My_Clip021.jpg', 'var/usr/images/Gallery/My_Clip021.jpg', ' '),
(537, 11, ' ', ' ', 'var/usr/images/Gallery/Thumbnail/My_Clip022.jpg', 'var/usr/images/Gallery/My_Clip022.jpg', ' ');

-- --------------------------------------------------------

--
-- Table structure for table `group_access`
--

CREATE TABLE IF NOT EXISTS `group_access` (
  `group_access_id` mediumint(9) NOT NULL auto_increment,
  `gallery_album_id` mediumint(9) default NULL,
  `vmt_group_id` mediumint(9) default NULL,
  `access_ref_id` mediumint(9) default NULL,
  PRIMARY KEY  (`group_access_id`),
  KEY `gallery_album_id` (`gallery_album_id`),
  KEY `vmt_group_id` (`vmt_group_id`),
  KEY `access_ref_id` (`access_ref_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `group_access`
--

INSERT INTO `group_access` (`group_access_id`, `gallery_album_id`, `vmt_group_id`, `access_ref_id`) VALUES
(2, 9, 2, 4),
(4, 9, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_access`
--

CREATE TABLE IF NOT EXISTS `user_access` (
  `user_access_id` mediumint(9) NOT NULL auto_increment,
  `gallery_album_id` mediumint(9) default NULL,
  `vmt_user_id` mediumint(9) default NULL,
  `access_ref_id` mediumint(9) default NULL,
  PRIMARY KEY  (`user_access_id`),
  KEY `gallery_album_id` (`gallery_album_id`),
  KEY `vmt_user_id` (`vmt_user_id`),
  KEY `access_ref_id` (`access_ref_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `user_access`
--

INSERT INTO `user_access` (`user_access_id`, `gallery_album_id`, `vmt_user_id`, `access_ref_id`) VALUES
(9, 9, NULL, 4),
(10, 9, 12, 1),
(11, 9, 12, 2),
(12, 9, 12, 3),
(13, 9, 12, 4);

-- --------------------------------------------------------

--
-- Table structure for table `vmt_group`
--

CREATE TABLE IF NOT EXISTS `vmt_group` (
  `vmt_group_id` mediumint(9) NOT NULL auto_increment,
  `vmt_group_nama` varchar(100) default NULL,
  PRIMARY KEY  (`vmt_group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `vmt_group`
--

INSERT INTO `vmt_group` (`vmt_group_id`, `vmt_group_nama`) VALUES
(1, 'Administrator'),
(2, 'Public User');

-- --------------------------------------------------------

--
-- Table structure for table `vmt_user`
--

CREATE TABLE IF NOT EXISTS `vmt_user` (
  `vmt_user_id` mediumint(9) NOT NULL auto_increment,
  `vmt_user_login` varchar(100) default NULL,
  `vmt_user_password` char(32) default NULL,
  `vmt_user_nama` varchar(100) default NULL,
  `vmt_user_email` varchar(255) default NULL,
  `is_active` char(6) default NULL,
  `token` char(64) default NULL,
  `token_reset` char(64) default NULL,
  PRIMARY KEY  (`vmt_user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `vmt_user`
--

INSERT INTO `vmt_user` (`vmt_user_id`, `vmt_user_login`, `vmt_user_password`, `vmt_user_nama`, `vmt_user_email`, `is_active`, `token`, `token_reset`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Administrator', NULL, 'ACTIVE', NULL, NULL),
(12, 'displacesux', '871dd3f6879770aa95a104b23899e49f', 'Adam', 'adam@devel-nottie.com', 'ACTIVE', '92039a069ed9689f678f3bbbc34e485d700851242bd18941e5ea8c0500597db2', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vmt_user_group`
--

CREATE TABLE IF NOT EXISTS `vmt_user_group` (
  `vmt_user_group_id` mediumint(9) NOT NULL auto_increment,
  `vmt_group_id` mediumint(9) default NULL,
  `vmt_user_id` mediumint(9) default NULL,
  PRIMARY KEY  (`vmt_user_group_id`),
  KEY `vmt_group_id` (`vmt_group_id`),
  KEY `vmt_user_id` (`vmt_user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `vmt_user_group`
--

INSERT INTO `vmt_user_group` (`vmt_user_group_id`, `vmt_group_id`, `vmt_user_id`) VALUES
(1, 1, 1),
(12, 2, 12);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`vmt_user_id`) REFERENCES `vmt_user` (`vmt_user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_3` FOREIGN KEY (`gallery_file_id`) REFERENCES `gallery_file` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `gallery_album`
--
ALTER TABLE `gallery_album`
  ADD CONSTRAINT `gallery_album_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `vmt_user` (`vmt_user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `gallery_file`
--
ALTER TABLE `gallery_file`
  ADD CONSTRAINT `gallery_file_ibfk_1` FOREIGN KEY (`gallery_album_id`) REFERENCES `gallery_album` (`gallery_album_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `group_access`
--
ALTER TABLE `group_access`
  ADD CONSTRAINT `group_access_ibfk_1` FOREIGN KEY (`gallery_album_id`) REFERENCES `gallery_album` (`gallery_album_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `group_access_ibfk_2` FOREIGN KEY (`vmt_group_id`) REFERENCES `vmt_group` (`vmt_group_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `group_access_ibfk_3` FOREIGN KEY (`access_ref_id`) REFERENCES `access_ref` (`access_ref_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_access`
--
ALTER TABLE `user_access`
  ADD CONSTRAINT `user_access_ibfk_1` FOREIGN KEY (`gallery_album_id`) REFERENCES `gallery_album` (`gallery_album_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_access_ibfk_2` FOREIGN KEY (`vmt_user_id`) REFERENCES `vmt_user` (`vmt_user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_access_ibfk_3` FOREIGN KEY (`access_ref_id`) REFERENCES `access_ref` (`access_ref_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vmt_user_group`
--
ALTER TABLE `vmt_user_group`
  ADD CONSTRAINT `vmt_user_group_ibfk_1` FOREIGN KEY (`vmt_group_id`) REFERENCES `vmt_group` (`vmt_group_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vmt_user_group_ibfk_2` FOREIGN KEY (`vmt_user_id`) REFERENCES `vmt_user` (`vmt_user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
