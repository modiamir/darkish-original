-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 26, 2014 at 09:49 AM
-- Server version: 5.5.39
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `darkish`
--

-- --------------------------------------------------------

--
-- Table structure for table `acl_classes`
--

CREATE TABLE IF NOT EXISTS `acl_classes` (
`id` int(10) unsigned NOT NULL,
  `class_type` varchar(200) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `acl_entries`
--

CREATE TABLE IF NOT EXISTS `acl_entries` (
`id` int(10) unsigned NOT NULL,
  `class_id` int(10) unsigned NOT NULL,
  `object_identity_id` int(10) unsigned DEFAULT NULL,
  `security_identity_id` int(10) unsigned NOT NULL,
  `field_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ace_order` smallint(5) unsigned NOT NULL,
  `mask` int(11) NOT NULL,
  `granting` tinyint(1) NOT NULL,
  `granting_strategy` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `audit_success` tinyint(1) NOT NULL,
  `audit_failure` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `acl_object_identities`
--

CREATE TABLE IF NOT EXISTS `acl_object_identities` (
`id` int(10) unsigned NOT NULL,
  `parent_object_identity_id` int(10) unsigned DEFAULT NULL,
  `class_id` int(10) unsigned NOT NULL,
  `object_identifier` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `entries_inheriting` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `acl_object_identity_ancestors`
--

CREATE TABLE IF NOT EXISTS `acl_object_identity_ancestors` (
  `object_identity_id` int(10) unsigned NOT NULL,
  `ancestor_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `acl_security_identities`
--

CREATE TABLE IF NOT EXISTS `acl_security_identities` (
`id` int(10) unsigned NOT NULL,
  `identifier` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `username` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `classified`
--

CREATE TABLE IF NOT EXISTS `classified` (
`id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_date` datetime DEFAULT NULL,
  `publish_date` int(11) DEFAULT NULL,
  `expire_date` int(11) DEFAULT NULL,
  `body` longtext COLLATE utf8_unicode_ci,
  `user_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `category` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `classifiedtree_id` int(11) DEFAULT NULL,
  `first_phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `second_phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `unit_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `first_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `second_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `third_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `banner` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `classified`
--

INSERT INTO `classified` (`id`, `title`, `created_date`, `publish_date`, `expire_date`, `body`, `user_id`, `status`, `category`, `classifiedtree_id`, `first_phone`, `second_phone`, `email`, `unit_number`, `first_image`, `second_image`, `third_image`, `banner`) VALUES
(1, 'شسشی', '2014-10-19 16:43:23', 2313, 123, '<p>سیشی سشی</p>\n', 1, 1, '00', 1, '123', '3123', '3123', '123', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `classifiedtree`
--

CREATE TABLE IF NOT EXISTS `classifiedtree` (
`id` int(11) NOT NULL,
  `up_tree_index` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tree_index` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sub_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `back_key_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `search_keywords` longtext COLLATE utf8_unicode_ci,
  `show_subtree_as_filter` tinyint(1) DEFAULT NULL,
  `show_sponsor_box` tinyint(1) DEFAULT NULL,
  `sponsor_group` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `icon_file_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `icon_set_files_name` longtext COLLATE utf8_unicode_ci COMMENT '(DC2Type:array)',
  `font_color` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `back_color` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sub_pic_show` tinyint(1) DEFAULT NULL,
  `sub_background` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sub_unit_height_scale` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hidden_tree` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `classifiedtree`
--

INSERT INTO `classifiedtree` (`id`, `up_tree_index`, `tree_index`, `sort`, `title`, `sub_title`, `back_key_title`, `search_keywords`, `show_subtree_as_filter`, `show_sponsor_box`, `sponsor_group`, `icon_file_name`, `icon_set_files_name`, `font_color`, `back_color`, `sub_pic_show`, `sub_background`, `sub_unit_height_scale`, `hidden_tree`) VALUES
(1, '#', '00', 1, 'گروه یک', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, '#', '01', 1, 'گروه دو', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dbasetype`
--

CREATE TABLE IF NOT EXISTS `dbasetype` (
`id` int(11) NOT NULL,
  `Name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE IF NOT EXISTS `files` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `file_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `filemime` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `filesize` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `timestamp` datetime NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entity_id` int(11) DEFAULT NULL,
  `upload_dir` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `upload_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=46 ;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `user_id`, `file_name`, `path`, `filemime`, `filesize`, `status`, `timestamp`, `type`, `entity_id`, `upload_dir`, `upload_key`) VALUES
(1, 1, 'tehranpayment.png', 'tehranpayment.png', 'image/png', '255288', 0, '2014-10-25 16:26:36', '234', 15, 'image', NULL),
(2, 1, 'tehranpayment.png', 'tehranpayment.png', 'image/png', '255288', 0, '2014-10-25 16:29:40', '234', 2, 'image', NULL),
(3, 1, '1383271_715228791896308_8678229324193851251_n.jpg', '1383271_715228791896308_8678229324193851251_n.jpg', 'image/jpeg', '42626', 0, '2014-10-26 08:43:10', 'news', 50, 'image', NULL),
(4, 1, 'Abd0001.JPG', 'Abd0001.JPG', 'image/jpeg', '432581', 0, '2014-10-28 17:27:40', 'news', 15, 'image', NULL),
(5, 1, 'Abd0001.JPG', 'Abd0001.JPG', 'image/jpeg', '432581', 0, '2014-10-28 17:29:37', 'news', 50, 'image', NULL),
(6, 1, 'Abd0001.JPG', 'Abd0001.JPG', 'image/jpeg', '432581', 0, '2014-10-28 17:29:44', 'news', 15, 'image', NULL),
(7, 1, 'Abd0001.JPG', 'Abd0001.JPG', 'image/jpeg', '432581', 0, '2014-10-29 15:48:43', 'news', 2, 'image', NULL),
(8, 1, '1383271_715228791896308_8678229324193851251_n.jpg', '1383271_715228791896308_8678229324193851251_n.jpg', 'image/jpeg', '42626', 0, '2014-10-29 19:28:28', 'news', 2, 'image', NULL),
(9, 1, 'beautiful-ocean-wallpaper-hd-42.jpg', 'beautiful-ocean-wallpaper-hd-42.jpg', 'image/jpeg', '516952', 0, '2014-10-29 19:28:44', 'news', 2, 'image', NULL),
(10, 1, 'beautiful-ocean-wallpaper-hd-42.jpg', 'beautiful-ocean-wallpaper-hd-42.jpg', 'image/jpeg', '516952', 0, '2014-10-29 19:29:08', 'news', 2, 'image', NULL),
(11, 1, 'beautiful-ocean-wallpaper-hd-42.jpg', 'beautiful-ocean-wallpaper-hd-42.jpg', 'image/jpeg', '516952', 0, '2014-10-29 19:37:45', 'news', 49, 'image', NULL),
(12, 1, 'beautiful-ocean-wallpaper-hd-42.jpg', 'beautiful-ocean-wallpaper-hd-42.jpg', 'image/jpeg', '516952', 0, '2014-10-29 19:40:12', 'news', 50, 'image', NULL),
(13, 1, '10434313_10204946910097032_6009711409660298638_n.jpg', '10434313_10204946910097032_6009711409660298638_n.jpg', 'image/jpeg', '9280', 0, '2014-10-29 22:21:02', 'news', 50, 'image', NULL),
(14, 1, '10434313_10204946910097032_6009711409660298638_n.jpg', '10434313_10204946910097032_6009711409660298638_n.jpg', 'image/jpeg', '9280', 0, '2014-10-29 22:21:59', 'news', 0, 'image', NULL),
(15, 1, '10434313_10204946910097032_6009711409660298638_n.jpg', '10434313_10204946910097032_6009711409660298638_n.jpg', 'image/jpeg', '9280', 0, '2014-10-29 22:22:13', 'news', 0, 'image', NULL),
(16, 1, '10434313_10204946910097032_6009711409660298638_n.jpg', '10434313_10204946910097032_6009711409660298638_n.jpg', 'image/jpeg', '9280', 0, '2014-10-29 22:23:07', 'news', 0, 'image', NULL),
(17, 1, '10434313_10204946910097032_6009711409660298638_n.jpg', '10434313_10204946910097032_6009711409660298638_n.jpg', 'image/jpeg', '9280', 0, '2014-10-29 22:24:00', 'news', 0, 'image', NULL),
(18, 1, '10434313_10204946910097032_6009711409660298638_n.jpg', '10434313_10204946910097032_6009711409660298638_n.jpg', 'image/jpeg', '9280', 0, '2014-10-29 22:50:28', 'news', 0, 'image', NULL),
(19, 1, '10434313_10204946910097032_6009711409660298638_n.jpg', '10434313_10204946910097032_6009711409660298638_n.jpg', 'image/jpeg', '9280', 0, '2014-10-29 22:55:15', 'news', 0, 'image', NULL),
(20, 1, '10434313_10204946910097032_6009711409660298638_n.jpg', '10434313_10204946910097032_6009711409660298638_n.jpg', 'image/jpeg', '9280', 0, '2014-10-29 23:01:34', 'news', 0, 'image', NULL),
(21, 1, '10434313_10204946910097032_6009711409660298638_n.jpg', '10434313_10204946910097032_6009711409660298638_n.jpg', 'image/jpeg', '9280', 0, '2014-10-29 23:02:06', 'news', 0, 'image', NULL),
(22, 1, '10434313_10204946910097032_6009711409660298638_n.jpg', '10434313_10204946910097032_6009711409660298638_n.jpg', 'image/jpeg', '9280', 0, '2014-10-29 23:02:39', 'news', 0, 'image', NULL),
(23, 1, '10434313_10204946910097032_6009711409660298638_n.jpg', '10434313_10204946910097032_6009711409660298638_n.jpg', 'image/jpeg', '9280', 0, '2014-10-29 23:03:23', 'news', 0, 'image', NULL),
(24, 1, '10434313_10204946910097032_6009711409660298638_n.jpg', '10434313_10204946910097032_6009711409660298638_n.jpg', 'image/jpeg', '9280', 0, '2014-10-29 23:04:02', 'news', 0, 'image', NULL),
(25, 1, '10434313_10204946910097032_6009711409660298638_n.jpg', '10434313_10204946910097032_6009711409660298638_n.jpg', 'image/jpeg', '9280', 0, '2014-10-29 23:04:34', 'news', 0, 'image', NULL),
(26, 1, '10434313_10204946910097032_6009711409660298638_n.jpg', '10434313_10204946910097032_6009711409660298638_n.jpg', 'image/jpeg', '9280', 0, '2014-10-29 23:05:57', 'news', 0, 'image', NULL),
(27, 1, '10434313_10204946910097032_6009711409660298638_n.jpg', '10434313_10204946910097032_6009711409660298638_n.jpg', 'image/jpeg', '9280', 0, '2014-10-29 23:06:46', 'news', 0, 'image', NULL),
(28, 1, '10434313_10204946910097032_6009711409660298638_n.jpg', '10434313_10204946910097032_6009711409660298638_n.jpg', 'image/jpeg', '9280', 0, '2014-10-29 23:20:30', 'news', 0, 'image', NULL),
(29, 1, '10434313_10204946910097032_6009711409660298638_n.jpg', '10434313_10204946910097032_6009711409660298638_n.jpg', 'image/jpeg', '9280', 0, '2014-10-29 23:21:47', 'news', 0, 'image', NULL),
(30, 1, '10434313_10204946910097032_6009711409660298638_n.jpg', '10434313_10204946910097032_6009711409660298638_n.jpg', 'image/jpeg', '9280', 0, '2014-10-29 23:22:08', 'news', 0, 'image', NULL),
(31, 1, '10434313_10204946910097032_6009711409660298638_n.jpg', '10434313_10204946910097032_6009711409660298638_n.jpg', 'image/jpeg', '9280', 0, '2014-10-29 23:22:35', 'news', 0, 'image', NULL),
(32, 1, '10434313_10204946910097032_6009711409660298638_n.jpg', '10434313_10204946910097032_6009711409660298638_n.jpg', 'image/jpeg', '9280', 0, '2014-10-29 23:22:53', 'news', 0, 'image', NULL),
(33, 1, '10434313_10204946910097032_6009711409660298638_n.jpg', '10434313_10204946910097032_6009711409660298638_n.jpg', 'image/jpeg', '9280', 0, '2014-10-29 23:26:03', 'news', 0, 'image', NULL),
(34, 1, '10434313_10204946910097032_6009711409660298638_n.jpg', '10434313_10204946910097032_6009711409660298638_n.jpg', 'image/jpeg', '9280', 0, '2014-10-29 23:29:52', 'news', 2147483647, 'image', NULL),
(35, 1, '10434313_10204946910097032_6009711409660298638_n.jpg', '10434313_10204946910097032_6009711409660298638_n.jpg', 'image/jpeg', '9280', 0, '2014-10-29 23:40:21', 'news', 0, 'image', NULL),
(36, 1, '10434313_10204946910097032_6009711409660298638_n.jpg', '10434313_10204946910097032_6009711409660298638_n.jpg', 'image/jpeg', '9280', 0, '2014-10-29 23:42:48', 'news', 0, 'image', NULL),
(37, 1, '10434313_10204946910097032_6009711409660298638_n.jpg', '10434313_10204946910097032_6009711409660298638_n.jpg', 'image/jpeg', '9280', 0, '2014-10-29 23:43:18', 'news', 0, 'image', '114146224113703'),
(38, 1, '10703972_716217588464095_2471459639939712759_n.jpg', '10703972_716217588464095_2471459639939712759_n.jpg', 'image/jpeg', '55461', 0, '2014-10-30 07:40:17', 'news', 49, 'image', NULL),
(39, 1, '10703972_716217588464095_2471459639939712759_n.jpg', '10703972_716217588464095_2471459639939712759_n.jpg', 'image/jpeg', '55461', 0, '2014-10-30 07:40:19', 'news', 49, 'image', NULL),
(40, 1, '10703972_716217588464095_2471459639939712759_n.jpg', '10703972_716217588464095_2471459639939712759_n.jpg', 'image/jpeg', '55461', 0, '2014-10-30 07:40:25', 'news', 49, 'image', NULL),
(41, 1, '10703972_716217588464095_2471459639939712759_n.jpg', '10703972_716217588464095_2471459639939712759_n.jpg', 'image/jpeg', '55461', 0, '2014-10-30 07:40:26', 'news', 49, 'image', NULL),
(42, 1, '10703972_716217588464095_2471459639939712759_n.jpg', '10703972_716217588464095_2471459639939712759_n.jpg', 'image/jpeg', '55461', 0, '2014-10-30 07:40:29', 'news', 49, 'image', NULL),
(43, 1, '10703972_716217588464095_2471459639939712759_n.jpg', '10703972_716217588464095_2471459639939712759_n.jpg', 'image/jpeg', '55461', 0, '2014-10-30 07:40:30', 'news', 49, 'image', NULL),
(44, 1, '10703972_716217588464095_2471459639939712759_n.jpg', '10703972_716217588464095_2471459639939712759_n.jpg', 'image/jpeg', '55461', 0, '2014-10-30 07:40:38', 'news', 49, 'image', NULL),
(45, 1, '10703972_716217588464095_2471459639939712759_n.jpg', '10703972_716217588464095_2471459639939712759_n.jpg', 'image/jpeg', '55461', 0, '2014-10-30 07:41:04', 'news', 49, 'image', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fos_user_group`
--

CREATE TABLE IF NOT EXISTS `fos_user_group` (
`id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fos_user_user`
--

CREATE TABLE IF NOT EXISTS `fos_user_user` (
`id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `locked` tinyint(1) NOT NULL,
  `expired` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `confirmation_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `credentials_expired` tinyint(1) NOT NULL,
  `credentials_expire_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `date_of_birth` datetime DEFAULT NULL,
  `firstname` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastname` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `biography` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `locale` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `timezone` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facebook_uid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facebook_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facebook_data` longtext COLLATE utf8_unicode_ci COMMENT '(DC2Type:json)',
  `twitter_uid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `twitter_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `twitter_data` longtext COLLATE utf8_unicode_ci COMMENT '(DC2Type:json)',
  `gplus_uid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gplus_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gplus_data` longtext COLLATE utf8_unicode_ci COMMENT '(DC2Type:json)',
  `token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `two_step_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `fos_user_user`
--

INSERT INTO `fos_user_user` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `locked`, `expired`, `expires_at`, `confirmation_token`, `password_requested_at`, `roles`, `credentials_expired`, `credentials_expire_at`, `created_at`, `updated_at`, `date_of_birth`, `firstname`, `lastname`, `website`, `biography`, `gender`, `locale`, `timezone`, `phone`, `facebook_uid`, `facebook_name`, `facebook_data`, `twitter_uid`, `twitter_name`, `twitter_data`, `gplus_uid`, `gplus_name`, `gplus_data`, `token`, `two_step_code`) VALUES
(1, 'admin', 'admin', 'admin@darkish.ir', 'admin@darkish.ir', 1, 'q2vdhsg8qk0s0o4sg8c0kw4k0ookoo4', 'KgZhMfcxwkcWPJmk42BdvSYzoNA8Y4QtErWhlmPklfSiVngHeQwyDvUY2OLxM1HN5h8bD/UCOXlbm8epAT7iTw==', '2014-11-25 19:02:14', 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:16:"ROLE_SUPER_ADMIN";}', 0, NULL, '2014-09-11 12:44:17', '2014-11-25 19:02:14', NULL, NULL, NULL, NULL, NULL, 'u', NULL, NULL, NULL, NULL, NULL, 'null', NULL, NULL, 'null', NULL, NULL, 'null', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fos_user_user_group`
--

CREATE TABLE IF NOT EXISTS `fos_user_user_group` (
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `maintree`
--

CREATE TABLE IF NOT EXISTS `maintree` (
`id` int(11) NOT NULL,
  `UpTreeIndex` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `TreeIndex` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Sort` int(11) NOT NULL,
  `Title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `SubTitle` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `BackKeyTitle` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `SearchKeywords` longtext COLLATE utf8_unicode_ci,
  `ShowInfoKey` tinyint(1) DEFAULT NULL,
  `InfoKeyTitle` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `InfoHtmlIndex` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ShowSubtreeAsFilter` tinyint(1) DEFAULT NULL,
  `ShowDistanceFilter` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DistanceFilterWithArea` tinyint(1) DEFAULT NULL,
  `ShowBrandsKey` tinyint(1) DEFAULT NULL,
  `ShowMessagesKey` tinyint(1) DEFAULT NULL,
  `ShowSponsorBox` tinyint(1) DEFAULT NULL,
  `SponsorGroup` int(11) DEFAULT NULL,
  `ShowCenters` tinyint(1) DEFAULT NULL,
  `CentersKeyTitle` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CentersGroupIndex` int(11) DEFAULT NULL,
  `CentersShowAsDefault` tinyint(1) DEFAULT NULL,
  `CentersListAfterGroup` tinyint(1) DEFAULT NULL,
  `DbaseType` int(11) DEFAULT NULL,
  `ShowDbaseKey` tinyint(1) DEFAULT NULL,
  `DbaseKeyTitle` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ShowDbaseUpdate` tinyint(1) DEFAULT NULL,
  `DbaseUpdateKeyTitle` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `IconFileName` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `IconSetFilesName` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `FontColor` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `BackColor` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `SubPicShow` tinyint(1) DEFAULT NULL,
  `SubBackground` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `SubUnitHeightScale` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `HiddenTree` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=118 ;

--
-- Dumping data for table `maintree`
--

INSERT INTO `maintree` (`id`, `UpTreeIndex`, `TreeIndex`, `Sort`, `Title`, `SubTitle`, `BackKeyTitle`, `SearchKeywords`, `ShowInfoKey`, `InfoKeyTitle`, `InfoHtmlIndex`, `ShowSubtreeAsFilter`, `ShowDistanceFilter`, `DistanceFilterWithArea`, `ShowBrandsKey`, `ShowMessagesKey`, `ShowSponsorBox`, `SponsorGroup`, `ShowCenters`, `CentersKeyTitle`, `CentersGroupIndex`, `CentersShowAsDefault`, `CentersListAfterGroup`, `DbaseType`, `ShowDbaseKey`, `DbaseKeyTitle`, `ShowDbaseUpdate`, `DbaseUpdateKeyTitle`, `IconFileName`, `IconSetFilesName`, `FontColor`, `BackColor`, `SubPicShow`, `SubBackground`, `SubUnitHeightScale`, `HiddenTree`) VALUES
(1, '0003', '000308', 8, 'پارک و سواحل تفريحي', 'پارک ساحلي مرجان - پارک شهر - ساحل کشتي يوناني', 'تفريحات', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(2, '0003', '000309', 9, 'اماکن و تورهاي گردشگري', 'شهر حريره - کاريز - تور هندورابي - گشت دور جزيره', 'تفريحات', '', 0, 'اطلاعات کاربردي', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(3, '0008', '000800', 0, 'نمايشگاه هاي ماشين', 'جستجو در همه نمايشگاه هاي جزيره - نمايشگاه ها', 'خودرو', '', 0, 'اطلاعات کاربردي', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(4, '0008', '000801', 1, 'کرايه اتومبيل', 'رنت - شرکت هاي مجاز کرايه اتومبيل - قيمت ها', 'خودرو', '', 0, 'اطلاعات کاربردي', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(5, '0008', '000802', 2, 'خدمات خودرو', 'مراکز خدماتي - صافکاري و نقاشي - تعميرگاه', 'خودرو', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(6, '0008', '000803', 3, 'نمايندگي هاي مجاز', 'ايرتويا - کيا و هيوندا - فرد', 'خودرو', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(7, '0008', '000804', 4, 'پمپ بنزين', 'آدرس - خدمات - ساعات کار', 'خودرو', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(8, '0008', '000805', 5, 'بيمه ثالث و بدنه اتومبيل', 'بيمه ايران - بيمه دنا - بيمه پارسيان', 'خودرو', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(9, '0008', '000806', 6, 'آموزشگاه رانندگي', 'تعليم و آموزش رانندگي - مجري آزمون رانندگي', 'خودرو', '', 0, 'اطلاعات کاربردي', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(10, '0010', '001000', 0, 'بيمارستان', 'بيمارستان هاي کيش - خدمات و امکانات', 'مراکز بهداشتي', '', 0, 'اطلاعات کاربردي', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(11, '0010', '001001', 1, 'کلينيک و مراکز درماني', 'کلينيک دندانپزشکي - مرکز بهداشت بوعلي', 'مراکز بهداشتي', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(12, '0010', '001002', 2, 'مطب پزشکان', 'دندانپزشکي - پوست و مو - کودکان - داخلي', 'مراکز بهداشتي', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(13, '0010', '001003', 3, 'خدمات بهداشتي و تناسب اندام', 'ليزر مو - ساکشن - کاشت مو - ترميم پوست', 'مراکز بهداشتي', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(14, '0010', '001004', 4, 'داروخانه', 'آدرس - ساعات کاري', '', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(15, '0011', '001100', 0, 'مهد کودک و پيش دبستاني', 'آدرس - شماره تماس - خدمات و توضيحات تکميلي', 'مراکز آموزشي', '', 0, 'اطلاعات تکميلي', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(16, '0011', '001101', 1, 'مدارس', 'ابتدايي - راهنمايي - متوسطه - هنرستان', 'مراکز آموزشي', '', 0, 'اطلاعات تکميلي', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(17, '0011', '001102', 2, 'دانشگاه', 'آدرس - رشته هاي آموزشي - توضيحات تکميلي', 'مراکز آموزشي', '', 0, 'اطلاعات کاربردي', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(18, '#', '0000', 0, 'درباره کيش', '', 'صفحه اول', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(19, '#', '0001', 1, 'بازارهاي تجاري', 'برندها - واحدهاي مراکز تجاري', 'صفحه اول', 'بازار تجاري خريد برند جنس مراکز پاساژ', 0, '', '', 0, '0', 0, 1, 1, 0, 0, 0, 'نام مراکز تجاري', 1, 1, 1, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(20, '#', '0002', 2, 'رستوران و کافي شاپ', 'موسيقي زنده - فست فود - طباخي - آبميوه و بستني', 'صفحه اول', '', 0, 'اطلاعات کاربردي', '', 0, '0', 0, 0, 1, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(21, '#', '0003', 3, 'مراکز تفريحي و ورزشي', 'بازي هاي دريايي - اماکن ورزشي و تفريحي - سافاري', 'صفحه اول', '', 0, 'قيمت تفريحات', '', 0, '0', 0, 0, 1, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(22, '#', '0004', 4, 'نيازهاي روزانه', 'سوپرمارکت - نانوايي - ميوه - آرايشگاه - تاکسي', 'صفحه اول', 'سوپر مارکت نان نانوايي شيريني فانتزي ميوه سبزي آرايشگاه تاکسي گاز آب خياطي کفاشي', 0, 'اطلاعات کاربردي', '', 0, '0', 0, 0, 1, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(23, '#', '0005', 5, 'هتل و مراکز اقامتي', 'هتل هاي 5 ستاره - اقامت در جزيره کيش', 'صفحه اول', '', 0, 'اطلاعات کاربردب', '', 0, '1', 1, 0, 1, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(24, '#', '0006', 6, 'آژانس هاي مسافرتي', 'بليط هواپيما - سفر دريايي - رزرو بليط', 'صفحه اول', '', 0, 'اطلاعات کاربردي', '', 0, '1', 1, 0, 1, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(25, '#', '0007', 7, 'آژانس هاي مسکن', 'املاک و مستغلات - خريد، رهن و اجاره منزل - مشاورين', 'صفحه اول', '', 0, 'اطلاعات کاربردي', '', 0, '1', 1, 0, 1, 0, 0, 0, '', 0, 0, 0, 1, 1, 'جستجو فايل در همه املاک', 1, 'بروزرساني همه', '', '', '16711680', '16777215', 0, '', '', 0),
(26, '#', '0008', 8, 'خودرو', 'نمايشگاه ماشين - کرايه اتومبيل - مراکز خدماتي', 'صفحه اول', '', 0, 'معرفي خودروهاي روز', '', 0, '0', 0, 0, 1, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(27, '#', '0009', 9, 'مراکز خدماتي', 'لوازم و دکوراسيون ساختماني - دفاتر حقوقي و اداري', 'صفحه اول', '', 0, 'اطلاعات کاربردي', '', 0, '0', 0, 0, 1, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(28, '#', '0010', 10, 'مراکز بهداشتي و درماني', 'بيمارستان - درمانگاه - مطب پزشکان - تناسب اندام', 'صفحه اول', '', 0, 'اطلاعات کاربردي', '', 0, '0', 0, 0, 1, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(29, '#', '0011', 11, 'مراکز آموزشي، فرهنگي و هنري', 'مدارس - دانشگاه - آموزشگاه - اساتيد خصوصي', 'صفحه اول', '', 0, 'اطلاعات کاربردي', '', 0, '0', 0, 0, 1, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(30, '0011', '001103', 3, 'آموزشگاه', 'زبان - تخصصي - کمک درسي - هنري', 'مراکز آموزشي', '', 0, 'اطلاعات کاربردي', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(31, '0011', '001104', 4, 'آموزش خصوصي', 'کمک درسي - زبان - هنري', 'مراکز آموزشي', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(32, '0011', '001105', 5, 'فرهنگسرا', 'آدرس - خدمات و امکانات - ساعات کاري', 'مراکز آموزشي', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(33, '0011', '001106', 6, 'کتابخانه', 'آدرس - ساعات کاري', '', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(34, '0001', '000100', 0, 'لباس مردانه', 'لباس مردانه - کت و شلوار - لباس زير', 'بازارهاي تجاري', '', 0, '', '', 1, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(35, '0001', '000101', 1, 'لباس زنانه', 'مانتو - روسري - لباس مجلسي - لباس زير', 'بازارهاي تجاري', '', 0, '', '', 1, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(36, '0001', '000102', 2, 'پوشاک و لوازم کودک، اسباب بازي', 'لباس بچه - سيسموني و کالاي اتاق کودک - اسباب بازي', 'بازارهاي تجاري', '', 0, '', '', 1, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(37, '0001', '000103', 3, 'کيف و کفش - چمدان', 'کفش مردانه - کيف و کفش زنانه - چمدان', 'بازارهاي تجاري', '', 0, '', '', 1, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(38, '0001', '000104', 4, 'آرايشي، بهداشتي و دارويي', 'لوازم آرايشي - مکمل هاي غذايي - داردهاي گياهي', 'بازارهاي تجاري', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(39, '0001', '000105', 5, 'عطر و ادکلن', 'برندها - معرفي محصولات روز - ادکلن هاي اصل', 'بازارهاي تجاري', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(40, '0001', '000106', 6, 'ورزشي', 'پوشاک ورزشي - لوازم و تجهيزات - نماينگي هاي معتبر', 'بازارهاي تجاري', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(41, '0001', '000107', 7, 'رايانه، موبايل و دوربين', 'تلفن - موبايل - نوت بوک - دوربين', 'بازارهاي تجاري', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(42, '0001', '000108', 8, 'زيورآلات', 'طلا و جواهر - ساعت - عينک - بدليجات', 'بازارهاي تجاري', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(43, '0001', '000109', 9, 'لوازم منزل و تزئيني', 'لوازم منزل و آشپزخانه - تصويري - لوازم تزئيني', 'بازارهاي تجاري', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(44, '0001', '000110', 10, 'بانک و موسسات مالي', 'بانک - موسسات مالي و اعتباري - صرافي', 'بازارهاي تجاري', '', 0, '', '', 1, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(45, '0001', '000111', 11, 'آژانس هاي مسافرتي', 'خريد و رزرو بليط هواپيما - تورهاي مسافرتي', 'بازارهاي تجاري', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(46, '0001', '000112', 12, 'رستوران و کافي شاپ', 'آبميوه - فست فود - کافي شاپ و رستوران داخل بازار', 'بازارهاي تجاري', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(47, '0001', '000113', 13, 'شکلات فروشي', 'برندهاي معتبر - قرعه کشي ها و جوايز - محصولات', 'بازارهاي تجاري', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(48, '0001', '000114', 14, 'لوازم التحرير، مواد مصرفي و ماشين هاي اداري', 'برندها - محصولات - لوازم و تجهيزات دفترهاي اداري', 'بازارهاي تجاري', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(49, '0001', '000115', 15, 'کانتر و ديگر واحدهاي بازار', 'کانترهاي گردشگري - ماشين کودک - کافي نت و غيره', '', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(50, '0009', '000900', 0, 'راه و ساختمان', 'مصالح - پيمانکاران - تاسيساتي و بهداشتي - آسانسور', 'مراکز خدماتي', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(51, '0009', '000901', 1, 'مبلمان و دکوراسيون', 'مبلمان اداري و خانگي - فرش و موکت - پرده - روشنايي', 'مراکز خدماتي', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(52, '0009', '000902', 2, 'لوازم و خدمات فردي و خانگي', 'سمساري - قاليشويي - کليدسازي - گل فروشي', 'مراکز خدماتي', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(53, '0009', '000903', 3, 'دفاتر اداري، حقوقي و بيمه', 'پست - پليس+10 - بيمه - ثبت اسناد - ثبت احوال', 'مراکز خدماتي', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(54, '0009', '000904', 4, 'تعميرات و خدمات فني', 'تعمير لوازم منزل - نمايندگي مجاز - تعمير موبايل', 'مراکز خدماتي', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(55, '0009', '000905', 5, 'بانک و موسسات مالي', 'موسسات مالي و اعتباري - صرافي', 'مراکز خدماتي', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(56, '0009', '000906', 6, 'اينترنت، شبکه و خدمات آي تي', 'اينترنت - خدمات پس از فروش - طراحي سايت', 'مراکز خدماتي', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(57, '0009', '000907', 7, 'حفاظتي، نظارتي و ايمني', 'فروش، نصب و خدمات پس از فروش', 'مراکز خدماتي', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(58, '0009', '000908', 8, 'تامين، ترخيص و پخش کالا', 'سردخانه مواد غذايي - صادرات و واردات - ترخيص کالا', 'مراکز خدماتي', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(59, '0009', '000909', 9, 'حمل و نقل و باربري', 'حمل بار - پست هوايي - 6 چرخ - هايس', 'مراکز خدماتي', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(60, '0009', '000910', 10, 'مطبوعات، تبليغات، چاپ و تکثير', 'نشريات - خدمات فني - طراحي و خدمات تبليغاتي', 'مراکز خدماتي', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(61, '0009', '000911', 11, 'خدمات و فعاليت هاي صنعتي', 'تراشکاري - نجاري - نقاشي ساختمان - سيم پيچي', 'مراکز خدماتي', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(62, '0009', '000912', 12, 'شرکت ها و کارخانجات', 'نفتي - صنعتي - کاريابي - توليدي - بازرگاني', 'مراکز خدماتي', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(63, '0005', '000502', 2, '3 ستاره', '', '', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(64, '0005', '000503', 3, 'مهمانپذير', '', '', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(65, '#', '0012', 12, 'فرصت هاي سرمايه گذاري', 'سرمايه گذاري در پروژه - معرفي فايل هاي اکازيون', 'صفحه اول', '', 0, 'اطلاعات کاربردي', '', 0, '0', 0, 0, 1, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(66, '0000', '000000', 0, 'معرفي جزيره کيش', 'تاريخچه - طبيعت - گونه هاي جانوري - بوميان کيش', 'درباره کيش', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(67, '0000', '000001', 1, 'اطلاعات کاربردي', 'سفر به کيش - زندگي، کسب و کار در کيش', 'درباره کيش', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(68, '0000', '000002', 2, 'سازمان منطقه آزاد', 'معرفي - معاونت ها و ادارات - برنامه ها', 'درباره کيش', '', 1, 'معرفي سازمان', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(69, '0000', '000003', 3, 'ديگر ادارات و سازمان هاي دولتي', 'دادگستري - مخابرات - آب و برق - نيروي انتظامي', 'درباره کيش', '', 1, 'اطلاعات کاربردي', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(70, '0000', '000004', 4, 'اماکن عمومي', 'نمايشگاه - تالار شهر - فرودگاه - بندرگاه - مصلي', 'درباره کيش', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(71, '0000', '000005', 5, 'اماکن گردشگري و جاذبه هاي توريستي', 'ابنيه تاريخي کيش - پارک ها و امکن توريستي', 'درباره کيش', '', 0, '', '', 0, '1', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(72, '0000', '000006', 6, 'قوانين و ضوابط اداري در کيش', 'قوانين رانندگي - ثبت شرکت - مجوز فعاليت اقتصادي', 'درباره کيش', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(73, '0000', '000007', 7, 'تلفن هاي ضروري کيش', 'سازمان - دادگستري - نيروي انتظامي - فرودگاه', 'درباره کيش', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(74, '0000', '000008', 8, 'پروژه ها و طرح هاي در حال اجرا', 'موزه و نماد شهري', 'درباره کيش', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(75, '0000', '000009', 9, 'انجمن هاي صنفي و تشکل ها', 'جامعه هتلداران - مراکز پذيرايي - مجمع رنت کاران', 'درباره کيش', '', 0, '', '', 0, '0', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(76, '0002', '000200', 0, 'موسيقي زنده', 'رستوران هاي داراي موسيقي زنده', 'رستوران', '', 0, '', '', 0, '1', 1, 0, 1, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(77, '0002', '000201', 1, 'رستوران هاي ايراني', 'چلوکبابي - رستوران هاي هتل', 'رستوران', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(78, '0002', '000202', 2, 'سنتي', 'سفره خانه - ديزي سرا', 'رستوران', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(79, '0002', '000203', 3, 'فست فود', 'پيتزا - مرغ سوخاري - همبرگر و ساندويچ', 'رستوران', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(80, '0004', '000400', 0, 'سوپر مارکت', 'آدرس - نمايش روي نقشه - ساعات کاري - محصولات', 'نيازهاي روزانه', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(81, '0004', '000401', 1, 'ميوه فروشي', 'آدرس - نمايش روي نقشه - ساعات کاري', 'نيازهاي روزانه', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(82, '0004', '000402', 2, 'قصابي و مواد پروتئيني', 'گوشت و مرغ - سوسيس و کالباس - فرآورده هاي گوشتي', 'نيازهاي روزانه', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(83, '0004', '000403', 3, 'نانوايي', 'سنگک - لواش - بربري - آدرس و نمايش بروي نقشه', 'نيازهاي روزانه', '', 0, '', '', 1, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(84, '0004', '000404', 4, 'شيريني و نان فانتزي', 'خشکبار - نان هاي رژيمي - آدرس و نمايش بر روي نقشه', 'نيازهاي روزانه', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(85, '0004', '000405', 5, 'آرايشگاه', 'مردانه - زنانه - آدرس و نمايش بر روي نقشه', 'نيازهاي روزانه', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(86, '000405', '00040500', 0, 'مردانه', 'آدرس - خدمات - ساعت کار - نمايش بر روي نقشه', 'آرايشگاه', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(87, '000405', '00040501', 1, 'زنانه', 'آدرس - خدمات - ساعات کاري - نمايش بر روي نقشه', 'آرايشگاه', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(88, '000403', '00040300', 0, 'بربري', '', '', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(89, '000403', '00040301', 1, 'لواش', '', '', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(90, '000403', '00040302', 2, 'سنگک', '', '', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(91, '000403', '00040303', 3, 'غيره', '', '', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(92, '0004', '000406', 6, 'خياطي و کفاشي', 'دوزندگي - تعميرات لباس - تعميرات کفش', 'نيازهاي روزانه', '', 0, '', '', 1, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(93, '000406', '00040600', 0, 'خياطي و دوزندگي', '', '', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(94, '000406', '00040601', 1, 'کفاشي', '', '', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(95, '0004', '000407', 7, 'ويدئو کلوپ و کحصولات فرهنگي', 'محصولات رسانه هاي تصويري - آدرس - محصولات', 'نيازهاي روزانه', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(96, '0004', '000408', 8, 'خشکشويي', 'آدرس - نمايش بر روي نقشه - ساعات کاري', 'نيازهاي روزانه', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(97, '0004', '000409', 9, 'تاکسي', 'شماره تلفن -نرخ کرايه تاکسي در جزيره کيش', 'نيازهاي روزانه', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(98, '0004', '000410', 10, 'پخش آب', 'شماره تلفن - نرخ محصولات', 'نيازهاي روزانه', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(99, '0004', '000411', 11, 'پخش گاز', 'شماره تلفن - نرخ محصولات', 'نيازهاي روزانه', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(100, '0005', '000500', 0, '5 ستاره', '', '', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(101, '0005', '000501', 1, '4 ستاره', '', '', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(102, '0002', '000204', 4, 'رستوران ملل', 'ايتاليايي - هندي - عربي - فرنگي', 'رستوران', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(103, '0002', '000205', 5, 'دريايي', 'ماهي - ميگو', 'رستوران', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(104, '0002', '000206', 6, 'آشپزخانه', 'مراکز تهيه غذا - غذاي شرکتي و پرسنلي', 'رستوران', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(105, '0002', '000207', 7, 'کافي شاپ و کافه', 'کافه - بوفه - قهوه - هات چاکلت', 'رستوران', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(106, '0002', '000208', 8, 'آبميوه و بستني', 'آب اناري - بستني سنتي و ميوه اي - فالوده', 'رستوران', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(107, '0002', '000209', 9, 'کبابي و جگرکي', 'کباب بناب - جوجه کباب - دل و جگر', 'رستوران', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(108, '0002', '000210', 10, 'طباخي', 'کله و پاچه - سيرابي', 'رستوران', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(109, '0002', '000211', 11, 'چايخانه و قهوه خانه', 'چاي - قليان - نيمرو - املت', 'رستوران', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(110, '0003', '000300', 0, 'تفريحات دريايي', 'کلوپ هاي دريايي - غواصي - جت اسکي', 'تفريحات', '', 0, 'قيمت تفريحات دريايي', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(111, '0003', '000301', 1, 'کشتي تفريحي', 'موسيقي دار - گردشي - آکواريومي', 'تفريحات', '', 0, 'قيمت انواع کشتي', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(112, '0003', '000302', 2, 'تفريحات ورزشي', 'بولينگ - بيليارد - کارتينگ - دوچرخه و اسکوتر', 'تفريحات', '', 0, 'قيمت تفريحات', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(113, '0003', '000303', 3, 'مراکز تفريحي', 'پارک دولفين ها - پارس سافاري کيش - بولينگ مريم', 'تفريحات', '', 0, 'قيمت تفريحات', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(114, '0003', '000304', 4, 'تفريحات هيجاني', 'سينما 3 و 4 بعدي - تلسم موميايي - قلعه وحشت', 'تفريحات', '', 0, 'قيمت تفريحات', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(115, '0003', '000305', 5, 'ماساژ و اسپا', 'ماساژ سنگ - ماساژ تايلندي - ماساژورها', 'تفريحات', '', 0, 'قيمت خدمات', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(116, '0003', '000306', 6, 'پلاژ', 'آقايان - بانوان', 'تفريحات', '', 0, 'اطلاعات', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(117, '0003', '000307', 7, 'مراکز ورزشي', 'مجموعه المپيک - استخر کرانه - اسپرت کلاپ', 'تفريحات', '', 0, 'اطلاعات کاربردي', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
`id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_date` datetime DEFAULT NULL,
  `expire_date` int(11) DEFAULT NULL,
  `body` longtext COLLATE utf8_unicode_ci,
  `user_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `category` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `newstree_id` int(11) DEFAULT NULL,
  `sub_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_competition` tinyint(1) DEFAULT NULL,
  `true_answer` int(11) DEFAULT NULL,
  `rate` int(11) DEFAULT NULL,
  `publish_date` int(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=77 ;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `created_date`, `expire_date`, `body`, `user_id`, `status`, `category`, `newstree_id`, `sub_title`, `is_competition`, `true_answer`, `rate`, `publish_date`) VALUES
(10, 'sadsad asd', '2014-10-23 00:00:00', 2, NULL, NULL, 1, '00', 2, 'sub 2', NULL, NULL, NULL, NULL),
(11, 'das dsa', '2014-10-15 00:00:00', 63, NULL, NULL, 1, '00', 2, 'sub3', NULL, NULL, NULL, NULL),
(12, 'asd da sad', '2014-10-29 00:00:00', 15, NULL, NULL, 1, '00', 2, 'sub 4', NULL, NULL, NULL, NULL),
(15, 'asdsd asd', '2014-10-17 12:38:16', 123, '<p>asd sad</p>\n', 1, 1, '01', 3, 'sub 7 ', 0, NULL, NULL, 123),
(16, 'asda das', '2014-10-31 00:00:00', 2, '<p>sd sadsad <strong>asd </strong>asd&nbsp;</p>', 1, 1, '01', 3, 'sub 8', NULL, NULL, NULL, NULL),
(17, 'sad asdsadas', '2014-10-16 00:00:00', 23, NULL, 1, 1, '00', 2, 'sub 9', NULL, NULL, NULL, NULL),
(18, 'sd asd ad', '2014-10-01 00:00:00', 23, '<p>as das dsad asd asd</p>', 1, 1, '01', 3, 'sub 10', NULL, NULL, NULL, NULL),
(19, 'asdfasd', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 'asdfasd', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 'sad', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, 'sad', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 'sad', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 'sad', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, 'magooli', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(26, 'googooli', NULL, NULL, NULL, 1, NULL, NULL, NULL, 'magooli', NULL, NULL, NULL, 2147483647),
(27, 'googooli', '2014-10-16 12:13:16', NULL, NULL, 1, NULL, NULL, NULL, 'magooli', NULL, NULL, NULL, 2147483647),
(28, 'googooli', '2014-10-16 12:17:43', 12, NULL, 1, NULL, NULL, NULL, 'magooli', NULL, NULL, NULL, 2147483647),
(29, 'googooli', '2014-10-16 12:18:33', 0, NULL, 1, NULL, NULL, NULL, 'magooli', NULL, NULL, NULL, 2147483647),
(30, 'googooli', '2014-10-16 12:19:02', 12, '<a href="http://google.com">Google</a>', 1, NULL, NULL, NULL, 'magooli', NULL, NULL, NULL, 2147483647),
(31, 'googooli', '2014-10-16 12:20:23', 12, '<a href="http://google.com">Google</a>', 1, NULL, NULL, NULL, 'magooli', NULL, NULL, NULL, 2147483647),
(32, 'googooli', '2014-10-16 12:22:43', 12, '<a href="http://google.com">Google</a>', 1, NULL, NULL, NULL, 'magooli', NULL, NULL, NULL, 2147483647),
(33, 'googooli', '2014-10-16 12:23:14', 12, '<a href="http://google.com">Google</a>', 1, NULL, NULL, NULL, 'magooli', NULL, NULL, NULL, 2147483647),
(34, 'googooli', '2014-10-16 12:23:44', 12, '<a href="http://google.com">Google</a>', 1, NULL, NULL, NULL, 'magooli', NULL, NULL, NULL, 2147483647),
(35, 'asdfasd', '2014-10-16 13:29:54', 12, 'asdlk asdlaksjdlkj', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 23423231),
(36, 'asdfasd', '2014-10-16 13:30:48', 12, 'asdlk asdlaksjdlkj', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 23423231),
(37, 'asdfasd', '2014-10-16 13:32:11', 12, 'asdlk asdlaksjdlkj', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 23423231),
(38, 'asdfasd', '2014-10-16 13:37:30', 12, 'asdlk asdlaksjdlkj', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 23423231),
(39, 'asdfasd', '2014-10-16 13:40:53', 12, 'asdlk asdlaksjdlkj', 1, 1, '01', 3, NULL, NULL, NULL, NULL, 23423231),
(40, 'asdfasd', '2014-10-16 13:41:15', 12, 'asdlk asdlaksjdlkj', 1, 1, '00', 2, NULL, NULL, NULL, NULL, 23423231),
(41, 'asdfasd', '2014-10-16 13:41:40', 12, 'asdlk asdlaksjdlkj', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 23423231),
(49, 'asdfasd', '2014-10-30 07:43:24', 12, '<p>asdlk as</p>\n\n<p><span contenteditable="false" tabindex="-1"><img data-widget="image2" src="http://localhost/darkish/web/uploads/image/10703972_716217588464095_2471459639939712759_n.jpg" width="100" /></span></p>\n\n<p>dlaksjdlkj</p>\n', 1, 0, NULL, NULL, NULL, 0, NULL, NULL, 23423231),
(50, 'with true answer', '2014-10-29 19:18:59', 12, '<p>asdlk asdl<span contenteditable="false" tabindex="-1"><img data-widget="image2" src="http://localhost/darkish/web/uploads/image/1383271_715228791896308_8678229324193851251_n.jpg" width="100" /></span>aksjdlkj</p>\n', 1, 0, NULL, NULL, NULL, 0, 1, NULL, 23423231),
(52, 'with true answer', '2014-10-16 13:56:53', 12, 'asdlk asdlaksjdlkj', 1, 0, NULL, NULL, NULL, 1, 1, NULL, 23423231),
(53, 'with true answer', '2014-10-16 13:59:30', 12, 'asdlk asdlaksjdlkj', 1, 0, NULL, NULL, NULL, 0, 1, NULL, 23423231),
(54, 'with true answer', '2014-10-16 13:59:45', 12, 'asdlk asdlaksjdlkj', 1, 0, NULL, NULL, NULL, 1, 1, 123, 23423231),
(55, 'sd', '2014-10-16 14:06:37', 2, '<p>sadoaidasd</p>\n\n<p>asdsaسشیشسی سشی شسی شس</p>\n\n<p style="direction: rtl;"><strong>شسنیتاشسنی</strong></p>\n', 1, 0, '01', 3, 'عنوان ثانویه', 0, 2, 12, 1393212321),
(56, 'with true answer', '2014-10-16 15:14:07', 12, 'asdlk asdlaksjdlkj', 1, 0, NULL, NULL, NULL, 1, 1, 123, 23423231),
(57, 'with true answer', '2014-10-16 15:14:11', 12, 'asdlk asdlaksjdlkj', 1, 0, NULL, NULL, NULL, 1, 1, 123, 23423231),
(58, 'with true answer', '2014-10-16 15:15:23', 12, 'asdlk asdlaksjdlkj', 1, 0, NULL, NULL, NULL, 1, 1, 123, 23423231),
(59, 'with true answer', '2014-10-16 15:16:03', 12, 'asdlk asdlaksjdlkj', 1, 0, NULL, NULL, NULL, 1, 1, 123, 23423231),
(60, 'with true answer', '2014-10-16 15:16:12', 12, 'asdlk asdlaksjdlkj', 1, 0, NULL, NULL, NULL, 1, 1, 123, 23423231),
(61, 'جدید یک', '2014-10-16 15:31:30', 213, '<p>شسی شسی شسی</p>\n', 1, 0, '01', 3, 'زیر عنوان', 0, NULL, NULL, 12312),
(62, 'جدید دو', '2014-10-16 15:33:15', 123, '<p>نشستین شاسین تشاس</p>\n', 1, 0, NULL, NULL, 'شسی', 0, NULL, NULL, 123),
(63, 'askjdh', '2014-10-16 15:56:46', 324, '<p>asdjhadj</p>\n', 1, 0, NULL, NULL, 'aksdj', 0, NULL, NULL, 324),
(64, 'نشستاینشسیانشسای', '2014-10-16 15:58:43', 12, '<p>شسیشسی</p>\n', 1, 0, NULL, NULL, 'نتانا', 0, NULL, NULL, 423),
(65, '3123', '2014-10-16 15:59:26', 32423, '<p>شیش سیشسی</p>\n', 1, 0, NULL, NULL, '12313', 0, NULL, NULL, 3324),
(66, 'شسیشس یش', '2014-10-16 16:00:46', 23, '<p>&nbsp;شسی سشی شسی&nbsp;</p>\n', 1, 0, NULL, NULL, 'شسیشسی', 0, NULL, NULL, 23),
(67, '2343', '2014-10-16 16:02:41', 32432, '<p>یشسیش سیشس یش</p>\n', 1, 0, NULL, NULL, '234234', 0, 1, 2344, 123),
(68, '123', '2014-10-16 16:14:16', 2344, '<p>3afadasd asd sa</p>\n', 1, 0, NULL, NULL, '3123', 0, NULL, NULL, 22),
(69, '132', '2014-10-16 16:45:58', 3, '<p>sdfsdf sdf</p>\n', 1, 0, NULL, NULL, '2344', 0, NULL, NULL, 23434),
(70, 'جدید', '2014-10-16 22:23:02', 123, '<p>تشمسنتی</p>\n', 1, 0, NULL, NULL, 'جدیددددد', 0, NULL, NULL, 23424234),
(71, 'الان', '2014-10-16 23:25:58', 123, '<p>aksdkajshdkhkj</p>\n', 1, 0, '01', 3, 'الاننننن', 0, NULL, NULL, 123),
(72, 'sd sdsad sad', '2014-10-17 12:33:19', 323, '<p>sda ad ad</p>\n', 1, 0, NULL, NULL, 'sub 5', 0, NULL, NULL, 123),
(73, 'sd sdsad sad', '2014-10-17 12:35:03', 3123, '<p>123312</p>\n', 1, 0, NULL, NULL, 'sub 5', 0, NULL, NULL, 123),
(74, 'sd sdsad sad', '2014-10-17 12:36:34', 123, '<p>a dasdsad</p>\n', 1, 0, NULL, NULL, 'sub 5', 0, NULL, NULL, 123),
(75, 'شاهد', '2014-10-17 12:48:01', 4, '<p>یبایبایب</p>\n', 1, 0, '01', 3, 'شاهد نینین', 0, 2, 3, 12345566),
(76, 'asd a', '2014-10-29 23:24:28', 21, '<p>asd asd</p>\n', 1, 0, NULL, NULL, 'asd asd', 0, NULL, NULL, 12312);

-- --------------------------------------------------------

--
-- Table structure for table `newstree`
--

CREATE TABLE IF NOT EXISTS `newstree` (
`id` int(11) NOT NULL,
  `up_tree_index` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tree_index` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sub_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `back_key_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `search_keywords` longtext COLLATE utf8_unicode_ci,
  `show_subtree_as_filter` tinyint(1) DEFAULT NULL,
  `show_sponsor_box` tinyint(1) DEFAULT NULL,
  `sponsor_group` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `icon_file_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `icon_set_files_name` longtext COLLATE utf8_unicode_ci COMMENT '(DC2Type:array)',
  `font_color` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `back_color` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sub_pic_show` tinyint(1) DEFAULT NULL,
  `sub_background` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sub_unit_height_scale` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hidden_tree` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `newstree`
--

INSERT INTO `newstree` (`id`, `up_tree_index`, `tree_index`, `sort`, `title`, `sub_title`, `back_key_title`, `search_keywords`, `show_subtree_as_filter`, `show_sponsor_box`, `sponsor_group`, `icon_file_name`, `icon_set_files_name`, `font_color`, `back_color`, `sub_pic_show`, `sub_background`, `sub_unit_height_scale`, `hidden_tree`) VALUES
(2, '#', '00', 0, 'اخبار روز', 'اخبار داخلي و خارجي', NULL, NULL, 0, 0, '1', NULL, 'a:0:{}', '9765004', '16777215', 1, '48', NULL, 0),
(3, '#', '01', 1, 'مسابقه', 'مسابقه پيامكي', NULL, NULL, 0, 0, '4', NULL, 'a:0:{}', '7856', '61695', 0, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `offer`
--

CREATE TABLE IF NOT EXISTS `offer` (
`id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_date` datetime DEFAULT NULL,
  `publish_date` int(11) DEFAULT NULL,
  `expire_date` int(11) DEFAULT NULL,
  `body` longtext COLLATE utf8_unicode_ci,
  `user_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `category` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `offertree_id` int(11) DEFAULT NULL,
  `first_phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `second_phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `unit_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `first_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `second_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `third_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `banner` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `offer`
--

INSERT INTO `offer` (`id`, `title`, `created_date`, `publish_date`, `expire_date`, `body`, `user_id`, `status`, `category`, `offertree_id`, `first_phone`, `second_phone`, `email`, `unit_number`, `first_image`, `second_image`, `third_image`, `banner`) VALUES
(1, 'with true answer', '2014-10-19 10:07:28', 23423231, 12, '<p>asdlk asdlaksjdlkj</p>\n', 1, 0, '', NULL, '1233', '23123', NULL, NULL, NULL, NULL, NULL, NULL),
(3, '1231', '2014-10-19 09:56:10', 1231, 123, '<p>asd asd</p>\n', 1, 0, '01', 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `offertree`
--

CREATE TABLE IF NOT EXISTS `offertree` (
`id` int(11) NOT NULL,
  `up_tree_index` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tree_index` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sub_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `back_key_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `search_keywords` longtext COLLATE utf8_unicode_ci,
  `show_subtree_as_filter` tinyint(1) DEFAULT NULL,
  `show_sponsor_box` tinyint(1) DEFAULT NULL,
  `sponsor_group` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `icon_file_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `icon_set_files_name` longtext COLLATE utf8_unicode_ci COMMENT '(DC2Type:array)',
  `font_color` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `back_color` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sub_pic_show` tinyint(1) DEFAULT NULL,
  `sub_background` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sub_unit_height_scale` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hidden_tree` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `offertree`
--

INSERT INTO `offertree` (`id`, `up_tree_index`, `tree_index`, `sort`, `title`, `sub_title`, `back_key_title`, `search_keywords`, `show_subtree_as_filter`, `show_sponsor_box`, `sponsor_group`, `icon_file_name`, `icon_set_files_name`, `font_color`, `back_color`, `sub_pic_show`, `sub_background`, `sub_unit_height_scale`, `hidden_tree`) VALUES
(3, '#', '00', 1, 'نمونه یک', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, '#', '01', 1, 'نمونه دو', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `record`
--

CREATE TABLE IF NOT EXISTS `record` (
`id` int(11) NOT NULL,
  `Title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `SubTitle` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Owner` int(11) DEFAULT NULL,
  `LegalName` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CenterIndex` int(11) DEFAULT NULL,
  `CenterFloor` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CenterUnitNumber` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `AreaIndex` int(11) DEFAULT NULL,
  `MessageEnable` tinyint(1) DEFAULT NULL,
  `MessageText` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `MessageValidityText` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ItineraryTypeIndex` int(11) DEFAULT NULL,
  `ItineraryRank` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TelNumber` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `FaxNumber` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `MobileNumbers` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Longitude` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Latitude` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Reserved1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Reserved2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `BrandEnable` tinyint(1) DEFAULT NULL,
  `ListRank` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `MOpeningHours` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `AOpeningHours` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `WorkingDays` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `SearchKeywords` longtext COLLATE utf8_unicode_ci,
  `CreationDate` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `LastUpdate` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `FavoriteEnable` tinyint(1) DEFAULT NULL,
  `LikeEnable` tinyint(1) DEFAULT NULL,
  `SendSmsEnable` tinyint(1) DEFAULT NULL,
  `InfoKeyEnable` tinyint(1) DEFAULT NULL,
  `CommentEnable` tinyint(1) DEFAULT NULL,
  `OnlyHtml` tinyint(1) DEFAULT NULL,
  `OnlineEnable` tinyint(1) DEFAULT NULL,
  `DbaseEnable` tinyint(1) DEFAULT NULL,
  `DbaseTypeIndex` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `BulkSmsEnable` tinyint(1) DEFAULT NULL,
  `Audio` tinyint(1) DEFAULT NULL,
  `Video` tinyint(1) DEFAULT NULL,
  `OnlineMarket` tinyint(1) DEFAULT NULL,
  `OnlineTicket` tinyint(1) DEFAULT NULL,
  `VisitCount` int(11) DEFAULT NULL,
  `FavoriteCount` int(11) DEFAULT NULL,
  `LikeCount` int(11) DEFAULT NULL,
  `Verify` tinyint(1) DEFAULT NULL,
  `record_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `record`
--

INSERT INTO `record` (`id`, `Title`, `SubTitle`, `Owner`, `LegalName`, `CenterIndex`, `CenterFloor`, `CenterUnitNumber`, `AreaIndex`, `MessageEnable`, `MessageText`, `MessageValidityText`, `ItineraryTypeIndex`, `ItineraryRank`, `TelNumber`, `FaxNumber`, `MobileNumbers`, `Email`, `Website`, `Address`, `Longitude`, `Latitude`, `Reserved1`, `Reserved2`, `BrandEnable`, `ListRank`, `MOpeningHours`, `AOpeningHours`, `WorkingDays`, `SearchKeywords`, `CreationDate`, `LastUpdate`, `FavoriteEnable`, `LikeEnable`, `SendSmsEnable`, `InfoKeyEnable`, `CommentEnable`, `OnlyHtml`, `OnlineEnable`, `DbaseEnable`, `DbaseTypeIndex`, `BulkSmsEnable`, `Audio`, `Video`, `OnlineMarket`, `OnlineTicket`, `VisitCount`, `FavoriteCount`, `LikeCount`, `Verify`, `record_number`) VALUES
(1, 'رکورد', 'شسی شسیs', 12, 'شسی شسی', 12, 'سش یشسی ', '12', 0, 0, '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, ''),
(4, 'رکورد دو', 'سابتایتل رکورد دو', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '124124'),
(5, 'رکورد سه', 'سابتایال رکورد ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '3421231');

-- --------------------------------------------------------

--
-- Table structure for table `records_maintrees`
--

CREATE TABLE IF NOT EXISTS `records_maintrees` (
  `record_id` int(11) NOT NULL,
  `maintree_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `records_maintrees`
--

INSERT INTO `records_maintrees` (`record_id`, `maintree_id`) VALUES
(1, 1),
(4, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acl_classes`
--
ALTER TABLE `acl_classes`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `UNIQ_69DD750638A36066` (`class_type`);

--
-- Indexes for table `acl_entries`
--
ALTER TABLE `acl_entries`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `UNIQ_46C8B806EA000B103D9AB4A64DEF17BCE4289BF4` (`class_id`,`object_identity_id`,`field_name`,`ace_order`), ADD KEY `IDX_46C8B806EA000B103D9AB4A6DF9183C9` (`class_id`,`object_identity_id`,`security_identity_id`), ADD KEY `IDX_46C8B806EA000B10` (`class_id`), ADD KEY `IDX_46C8B8063D9AB4A6` (`object_identity_id`), ADD KEY `IDX_46C8B806DF9183C9` (`security_identity_id`);

--
-- Indexes for table `acl_object_identities`
--
ALTER TABLE `acl_object_identities`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `UNIQ_9407E5494B12AD6EA000B10` (`object_identifier`,`class_id`), ADD KEY `IDX_9407E54977FA751A` (`parent_object_identity_id`);

--
-- Indexes for table `acl_object_identity_ancestors`
--
ALTER TABLE `acl_object_identity_ancestors`
 ADD PRIMARY KEY (`object_identity_id`,`ancestor_id`), ADD KEY `IDX_825DE2993D9AB4A6` (`object_identity_id`), ADD KEY `IDX_825DE299C671CEA1` (`ancestor_id`);

--
-- Indexes for table `acl_security_identities`
--
ALTER TABLE `acl_security_identities`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `UNIQ_8835EE78772E836AF85E0677` (`identifier`,`username`);

--
-- Indexes for table `classified`
--
ALTER TABLE `classified`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classifiedtree`
--
ALTER TABLE `classifiedtree`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dbasetype`
--
ALTER TABLE `dbasetype`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fos_user_group`
--
ALTER TABLE `fos_user_group`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `UNIQ_583D1F3E5E237E06` (`name`);

--
-- Indexes for table `fos_user_user`
--
ALTER TABLE `fos_user_user`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `UNIQ_C560D76192FC23A8` (`username_canonical`), ADD UNIQUE KEY `UNIQ_C560D761A0D96FBF` (`email_canonical`);

--
-- Indexes for table `fos_user_user_group`
--
ALTER TABLE `fos_user_user_group`
 ADD PRIMARY KEY (`user_id`,`group_id`), ADD KEY `IDX_B3C77447A76ED395` (`user_id`), ADD KEY `IDX_B3C77447FE54D947` (`group_id`);

--
-- Indexes for table `maintree`
--
ALTER TABLE `maintree`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newstree`
--
ALTER TABLE `newstree`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offer`
--
ALTER TABLE `offer`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offertree`
--
ALTER TABLE `offertree`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `record`
--
ALTER TABLE `record`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `UNIQ_9C989AA7F4CC592A` (`record_number`);

--
-- Indexes for table `records_maintrees`
--
ALTER TABLE `records_maintrees`
 ADD PRIMARY KEY (`record_id`,`maintree_id`), ADD KEY `IDX_A215A52F4DFD750C` (`record_id`), ADD KEY `IDX_A215A52F61A43B37` (`maintree_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `acl_classes`
--
ALTER TABLE `acl_classes`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `acl_entries`
--
ALTER TABLE `acl_entries`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `acl_object_identities`
--
ALTER TABLE `acl_object_identities`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `acl_security_identities`
--
ALTER TABLE `acl_security_identities`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `classified`
--
ALTER TABLE `classified`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `classifiedtree`
--
ALTER TABLE `classifiedtree`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `dbasetype`
--
ALTER TABLE `dbasetype`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `fos_user_group`
--
ALTER TABLE `fos_user_group`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fos_user_user`
--
ALTER TABLE `fos_user_user`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `maintree`
--
ALTER TABLE `maintree`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=118;
--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=77;
--
-- AUTO_INCREMENT for table `newstree`
--
ALTER TABLE `newstree`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `offer`
--
ALTER TABLE `offer`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `offertree`
--
ALTER TABLE `offertree`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `record`
--
ALTER TABLE `record`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `acl_entries`
--
ALTER TABLE `acl_entries`
ADD CONSTRAINT `FK_46C8B8063D9AB4A6` FOREIGN KEY (`object_identity_id`) REFERENCES `acl_object_identities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `FK_46C8B806DF9183C9` FOREIGN KEY (`security_identity_id`) REFERENCES `acl_security_identities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `FK_46C8B806EA000B10` FOREIGN KEY (`class_id`) REFERENCES `acl_classes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `acl_object_identities`
--
ALTER TABLE `acl_object_identities`
ADD CONSTRAINT `FK_9407E54977FA751A` FOREIGN KEY (`parent_object_identity_id`) REFERENCES `acl_object_identities` (`id`);

--
-- Constraints for table `acl_object_identity_ancestors`
--
ALTER TABLE `acl_object_identity_ancestors`
ADD CONSTRAINT `FK_825DE2993D9AB4A6` FOREIGN KEY (`object_identity_id`) REFERENCES `acl_object_identities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `FK_825DE299C671CEA1` FOREIGN KEY (`ancestor_id`) REFERENCES `acl_object_identities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `fos_user_user_group`
--
ALTER TABLE `fos_user_user_group`
ADD CONSTRAINT `FK_B3C77447A76ED395` FOREIGN KEY (`user_id`) REFERENCES `fos_user_user` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `FK_B3C77447FE54D947` FOREIGN KEY (`group_id`) REFERENCES `fos_user_group` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `records_maintrees`
--
ALTER TABLE `records_maintrees`
ADD CONSTRAINT `FK_A215A52F4DFD750C` FOREIGN KEY (`record_id`) REFERENCES `record` (`id`),
ADD CONSTRAINT `FK_A215A52F61A43B37` FOREIGN KEY (`maintree_id`) REFERENCES `maintree` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
