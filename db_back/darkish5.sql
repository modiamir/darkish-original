-- phpMyAdmin SQL Dump
-- version 4.3.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 04, 2015 at 08:36 AM
-- Server version: 5.5.40-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.5

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `area`
--

CREATE TABLE IF NOT EXISTS `area` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `longitude` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `latitude` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sort` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `area`
--

INSERT INTO `area` (`id`, `name`, `longitude`, `latitude`, `sort`) VALUES
(1, 'صدف', '', '', 1),
(2, 'صفين', '', '', 4),
(3, 'مرجان', '', '', 3),
(4, 'گلديس', '', '', 6),
(5, 'عربها', '', '', 10),
(6, 'مير مهنا', '', '', 5),
(7, 'آب و برق', '', '', 7),
(8, 'نوبنياد', '', '', 9),
(9, 'كلبه هور', '', '', 12),
(10, 'دهكده ساحلي', '', '', 8),
(11, 'سيمرغ', '', '', 11),
(12, 'خانه گستر', '', '', 2);

-- --------------------------------------------------------

--
-- Table structure for table `center`
--

CREATE TABLE IF NOT EXISTS `center` (
  `id` int(11) NOT NULL,
  `center_type_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sub_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `num_of_floors` int(11) DEFAULT NULL,
  `num_of_units` int(11) DEFAULT NULL,
  `longitude` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `latitude` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `icon_index` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `show_brands` tinyint(1) DEFAULT NULL,
  `show_offers` tinyint(1) DEFAULT NULL,
  `record_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tree_index` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `center`
--

INSERT INTO `center` (`id`, `center_type_id`, `name`, `sub_title`, `sort`, `num_of_floors`, `num_of_units`, `longitude`, `latitude`, `icon_index`, `show_brands`, `show_offers`, `record_id`, `tree_index`) VALUES
(1, 2, 'بازار هرمز', 'بازار صنعتي', '7', 2, 100, '53.978705406189', '26.5535509747828', NULL, 1, 1, NULL, NULL),
(2, 3, 'گلستان', 'ميدان كلستان', '9', 1, 25, '54.0072172880173', '26.5400342129008', 'DAILY', NULL, 1, NULL, NULL),
(3, 1, 'مركز تجاري', 'مجتمع بازارها', '1', 3, 350, '54.0190994739533', '26.541840732111', 'BEACH_CHAIR', NULL, 1, NULL, '000000/000001/000002/000003/000004/000005/000006/000007/000008/000009'),
(4, 1, 'پرديس 2', 'مجتمع بازارها', '2', 3, 240, '54.0201508998871', '26.5363310075413', 'SHOP', 1, 1, NULL, '0001/000100/000101/000102/000103/000104/000105/000106/000107/000108/000109/000110/000111/000112/000113/000114/000115'),
(5, 1, 'مرجان', 'مرجان', '6', 1, 60, '54.0375852584839', '26.5253211572252', '', NULL, 1, NULL, NULL),
(6, 2, 'پادنا', 'لوازم منزل', '4', 3, 55, '53.9899599552155', '26.5566709140974', '3TRAVEL_LUGGAGE', NULL, 0, NULL, NULL),
(7, 1, 'پانيذ', 'لوازم گوناگون', '5', 2, 60, '54.0199685096741', '26.5394557276101', '', NULL, 0, NULL, NULL),
(8, 1, 'پرديس 1', 'بازار لوكس', '3', 2, 160, '54.0213310718537', '26.5366381698867', '', NULL, 0, NULL, NULL),
(9, 1, 'بازار عربها', '', '8', 1, 60, '53.9497858285904', '26.5728118171998', '', NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `centertype`
--

CREATE TABLE IF NOT EXISTS `centertype` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `centertype`
--

INSERT INTO `centertype` (`id`, `name`) VALUES
(1, 'تجاری'),
(2, 'نیاز روزانه'),
(3, 'خدماتی');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dbasetype`
--

INSERT INTO `dbasetype` (`id`, `Name`) VALUES
(1, 'املاك'),
(2, 'خودرو'),
(3, 'آژانس هواپيمايي');

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
  `upload_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `temporary` tinyint(1) DEFAULT '0',
  `is_thumbnail` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=201 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `user_id`, `file_name`, `path`, `filemime`, `filesize`, `status`, `timestamp`, `type`, `entity_id`, `upload_dir`, `upload_key`, `temporary`, `is_thumbnail`) VALUES
(1, 1, 'tehranpayment.png', 'tehranpayment.png', 'image/png', '255288', 0, '2014-10-25 16:26:36', '234', 15, 'image', NULL, 0, 1),
(2, 1, 'tehranpayment.png', 'tehranpayment.png', 'image/png', '255288', 0, '2014-10-25 16:29:40', '234', 2, 'image', NULL, 0, 0),
(3, 1, '1383271_715228791896308_8678229324193851251_n.jpg', '1383271_715228791896308_8678229324193851251_n.jpg', 'image/jpeg', '42626', 0, '2014-10-26 08:43:10', 'news', 50, 'image', NULL, 1, 0),
(4, 1, 'Abd0001.JPG', 'Abd0001.JPG', 'image/jpeg', '432581', 0, '2014-10-28 17:27:40', 'news', 15, 'image', NULL, 0, 0),
(5, 1, 'Abd0001.JPG', 'Abd0001.JPG', 'image/jpeg', '432581', 0, '2014-10-28 17:29:37', 'news', 50, 'image', NULL, 0, 0),
(6, 1, 'Abd0001.JPG', 'Abd0001.JPG', 'image/jpeg', '432581', 0, '2014-10-28 17:29:44', 'news', 15, 'image', NULL, 0, 0),
(7, 1, 'Abd0001.JPG', 'Abd0001.JPG', 'image/jpeg', '432581', 0, '2014-10-29 15:48:43', 'news', 2, 'image', NULL, 0, 0),
(8, 1, '1383271_715228791896308_8678229324193851251_n.jpg', '1383271_715228791896308_8678229324193851251_n.jpg', 'image/jpeg', '42626', 0, '2014-10-29 19:28:28', 'news', 2, 'image', NULL, 0, 0),
(9, 1, 'beautiful-ocean-wallpaper-hd-42.jpg', 'beautiful-ocean-wallpaper-hd-42.jpg', 'image/jpeg', '516952', 0, '2014-10-29 19:28:44', 'news', 2, 'image', NULL, 0, 0),
(10, 1, 'beautiful-ocean-wallpaper-hd-42.jpg', 'beautiful-ocean-wallpaper-hd-42.jpg', 'image/jpeg', '516952', 0, '2014-10-29 19:29:08', 'news', 2, 'image', NULL, 0, 0),
(11, 1, 'beautiful-ocean-wallpaper-hd-42.jpg', 'beautiful-ocean-wallpaper-hd-42.jpg', 'image/jpeg', '516952', 0, '2014-10-29 19:37:45', 'news', 49, 'image', NULL, 0, 0),
(12, 1, 'beautiful-ocean-wallpaper-hd-42.jpg', 'beautiful-ocean-wallpaper-hd-42.jpg', 'image/jpeg', '516952', 0, '2014-10-29 19:40:12', 'news', 50, 'image', NULL, 0, 0),
(13, 1, '10434313_10204946910097032_6009711409660298638_n.jpg', '10434313_10204946910097032_6009711409660298638_n.jpg', 'image/jpeg', '9280', 0, '2014-10-29 22:21:02', 'news', 50, 'image', NULL, 0, 0),
(14, 1, '10434313_10204946910097032_6009711409660298638_n.jpg', '10434313_10204946910097032_6009711409660298638_n.jpg', 'image/jpeg', '9280', 0, '2014-10-29 22:21:59', 'news', 0, 'image', NULL, 0, 0),
(15, 1, '10434313_10204946910097032_6009711409660298638_n.jpg', '10434313_10204946910097032_6009711409660298638_n.jpg', 'image/jpeg', '9280', 0, '2014-10-29 22:22:13', 'news', 0, 'image', NULL, 0, 0),
(16, 1, '10434313_10204946910097032_6009711409660298638_n.jpg', '10434313_10204946910097032_6009711409660298638_n.jpg', 'image/jpeg', '9280', 0, '2014-10-29 22:23:07', 'news', 0, 'image', NULL, 0, 0),
(17, 1, '10434313_10204946910097032_6009711409660298638_n.jpg', '10434313_10204946910097032_6009711409660298638_n.jpg', 'image/jpeg', '9280', 0, '2014-10-29 22:24:00', 'news', 0, 'image', NULL, 0, 0),
(18, 1, '10434313_10204946910097032_6009711409660298638_n.jpg', '10434313_10204946910097032_6009711409660298638_n.jpg', 'image/jpeg', '9280', 0, '2014-10-29 22:50:28', 'news', 0, 'image', NULL, 0, 0),
(19, 1, '10434313_10204946910097032_6009711409660298638_n.jpg', '10434313_10204946910097032_6009711409660298638_n.jpg', 'image/jpeg', '9280', 0, '2014-10-29 22:55:15', 'news', 0, 'image', NULL, 0, 0),
(20, 1, '10434313_10204946910097032_6009711409660298638_n.jpg', '10434313_10204946910097032_6009711409660298638_n.jpg', 'image/jpeg', '9280', 0, '2014-10-29 23:01:34', 'news', 0, 'image', NULL, 0, 0),
(21, 1, '10434313_10204946910097032_6009711409660298638_n.jpg', '10434313_10204946910097032_6009711409660298638_n.jpg', 'image/jpeg', '9280', 0, '2014-10-29 23:02:06', 'news', 0, 'image', NULL, 0, 0),
(22, 1, '10434313_10204946910097032_6009711409660298638_n.jpg', '10434313_10204946910097032_6009711409660298638_n.jpg', 'image/jpeg', '9280', 0, '2014-10-29 23:02:39', 'news', 0, 'image', NULL, 0, 0),
(23, 1, '10434313_10204946910097032_6009711409660298638_n.jpg', '10434313_10204946910097032_6009711409660298638_n.jpg', 'image/jpeg', '9280', 0, '2014-10-29 23:03:23', 'news', 0, 'image', NULL, 0, 0),
(24, 1, '10434313_10204946910097032_6009711409660298638_n.jpg', '10434313_10204946910097032_6009711409660298638_n.jpg', 'image/jpeg', '9280', 0, '2014-10-29 23:04:02', 'news', 0, 'image', NULL, 0, 0),
(25, 1, '10434313_10204946910097032_6009711409660298638_n.jpg', '10434313_10204946910097032_6009711409660298638_n.jpg', 'image/jpeg', '9280', 0, '2014-10-29 23:04:34', 'news', 0, 'image', NULL, 0, 0),
(26, 1, '10434313_10204946910097032_6009711409660298638_n.jpg', '10434313_10204946910097032_6009711409660298638_n.jpg', 'image/jpeg', '9280', 0, '2014-10-29 23:05:57', 'news', 0, 'image', NULL, 0, 0),
(27, 1, '10434313_10204946910097032_6009711409660298638_n.jpg', '10434313_10204946910097032_6009711409660298638_n.jpg', 'image/jpeg', '9280', 0, '2014-10-29 23:06:46', 'news', 0, 'image', NULL, 0, 0),
(28, 1, '10434313_10204946910097032_6009711409660298638_n.jpg', '10434313_10204946910097032_6009711409660298638_n.jpg', 'image/jpeg', '9280', 0, '2014-10-29 23:20:30', 'news', 0, 'image', NULL, 0, 0),
(29, 1, '10434313_10204946910097032_6009711409660298638_n.jpg', '10434313_10204946910097032_6009711409660298638_n.jpg', 'image/jpeg', '9280', 0, '2014-10-29 23:21:47', 'news', 0, 'image', NULL, 0, 0),
(30, 1, '10434313_10204946910097032_6009711409660298638_n.jpg', '10434313_10204946910097032_6009711409660298638_n.jpg', 'image/jpeg', '9280', 0, '2014-10-29 23:22:08', 'news', 0, 'image', NULL, 0, 0),
(31, 1, '10434313_10204946910097032_6009711409660298638_n.jpg', '10434313_10204946910097032_6009711409660298638_n.jpg', 'image/jpeg', '9280', 0, '2014-10-29 23:22:35', 'news', 0, 'image', NULL, 0, 0),
(32, 1, '10434313_10204946910097032_6009711409660298638_n.jpg', '10434313_10204946910097032_6009711409660298638_n.jpg', 'image/jpeg', '9280', 0, '2014-10-29 23:22:53', 'news', 0, 'image', NULL, 0, 0),
(33, 1, '10434313_10204946910097032_6009711409660298638_n.jpg', '10434313_10204946910097032_6009711409660298638_n.jpg', 'image/jpeg', '9280', 0, '2014-10-29 23:26:03', 'news', 0, 'image', NULL, 0, 0),
(34, 1, '10434313_10204946910097032_6009711409660298638_n.jpg', '10434313_10204946910097032_6009711409660298638_n.jpg', 'image/jpeg', '9280', 0, '2014-10-29 23:29:52', 'news', 2147483647, 'image', NULL, 0, 0),
(35, 1, '10434313_10204946910097032_6009711409660298638_n.jpg', '10434313_10204946910097032_6009711409660298638_n.jpg', 'image/jpeg', '9280', 0, '2014-10-29 23:40:21', 'news', 0, 'image', NULL, 0, 0),
(36, 1, '10434313_10204946910097032_6009711409660298638_n.jpg', '10434313_10204946910097032_6009711409660298638_n.jpg', 'image/jpeg', '9280', 0, '2014-10-29 23:42:48', 'news', 0, 'image', NULL, 0, 0),
(37, 1, '10434313_10204946910097032_6009711409660298638_n.jpg', '10434313_10204946910097032_6009711409660298638_n.jpg', 'image/jpeg', '9280', 0, '2014-10-29 23:43:18', 'news', 0, 'image', '114146224113703', 0, 0),
(38, 1, '10703972_716217588464095_2471459639939712759_n.jpg', '10703972_716217588464095_2471459639939712759_n.jpg', 'image/jpeg', '55461', 0, '2014-10-30 07:40:17', 'news', 49, 'image', NULL, 0, 0),
(39, 1, '10703972_716217588464095_2471459639939712759_n.jpg', '10703972_716217588464095_2471459639939712759_n.jpg', 'image/jpeg', '55461', 0, '2014-10-30 07:40:19', 'news', 49, 'image', NULL, 0, 0),
(40, 1, '10703972_716217588464095_2471459639939712759_n.jpg', '10703972_716217588464095_2471459639939712759_n.jpg', 'image/jpeg', '55461', 0, '2014-10-30 07:40:25', 'news', 49, 'image', NULL, 0, 0),
(41, 1, '10703972_716217588464095_2471459639939712759_n.jpg', '10703972_716217588464095_2471459639939712759_n.jpg', 'image/jpeg', '55461', 0, '2014-10-30 07:40:26', 'news', 49, 'image', NULL, 0, 0),
(42, 1, '10703972_716217588464095_2471459639939712759_n.jpg', '10703972_716217588464095_2471459639939712759_n.jpg', 'image/jpeg', '55461', 0, '2014-10-30 07:40:29', 'news', 49, 'image', NULL, 0, 0),
(43, 1, '10703972_716217588464095_2471459639939712759_n.jpg', '10703972_716217588464095_2471459639939712759_n.jpg', 'image/jpeg', '55461', 0, '2014-10-30 07:40:30', 'news', 49, 'image', NULL, 0, 0),
(44, 1, '10703972_716217588464095_2471459639939712759_n.jpg', '10703972_716217588464095_2471459639939712759_n.jpg', 'image/jpeg', '55461', 0, '2014-10-30 07:40:38', 'news', 49, 'image', NULL, 0, 0),
(45, 1, '10703972_716217588464095_2471459639939712759_n.jpg', '10703972_716217588464095_2471459639939712759_n.jpg', 'image/jpeg', '55461', 0, '2014-10-30 07:41:04', 'news', 49, 'image', NULL, 0, 0),
(46, 1, 'Love-Rose-06.jpg', 'Love-Rose-06.jpg', 'image/jpeg', '390406', 0, '2014-12-07 21:41:12', 'record', 1, 'image', NULL, 0, 0),
(47, 1, 'beautiful-ocean-wallpaper-hd-42.jpg', 'beautiful-ocean-wallpaper-hd-42.jpg', 'image/jpeg', '516952', 0, '2014-12-11 22:40:36', 'record', NULL, 'image', '114183339518457', 0, 0),
(48, 1, 'tehranpayment.png', 'tehranpayment.png', 'image/png', '255288', 0, '2014-12-11 22:44:02', 'record', NULL, 'image', '114183342255898', 0, 0),
(49, 1, 'tehranpayment.png', 'tehranpayment.png', 'image/png', '255288', 0, '2014-12-11 22:45:58', 'record', NULL, 'image', '114183343443436', 0, 0),
(50, 1, 'beautiful-ocean-wallpaper-hd-42.jpg', 'beautiful-ocean-wallpaper-hd-42.jpg', 'image/jpeg', '516952', 0, '2014-12-11 22:47:40', 'record', NULL, 'image', '114183344491045', 0, 0),
(51, 1, 'Love-Rose-06.jpg', 'Love-Rose-06.jpg', 'image/jpeg', '390406', 0, '2014-12-11 22:50:32', 'record', NULL, 'image', '114183346249158', 0, 0),
(52, 1, 'beautiful-ocean-wallpaper-hd-42.jpg', 'beautiful-ocean-wallpaper-hd-42.jpg', 'image/jpeg', '516952', 0, '2014-12-11 22:55:00', 'record', NULL, 'image', NULL, 0, 0),
(53, 1, 'beautiful-ocean-wallpaper-hd-42.jpg', 'beautiful-ocean-wallpaper-hd-42.jpg', 'image/jpeg', '516952', 0, '2014-12-11 22:56:39', 'record', NULL, 'image', '114183349941536', 0, 0),
(54, 1, 'beautiful-ocean-wallpaper-hd-42.jpg', 'beautiful-ocean-wallpaper-hd-42.jpg', 'image/jpeg', '516952', 0, '2014-12-12 20:58:31', 'record', 1, 'image', NULL, 0, 0),
(55, 1, '10434313_10204946910097032_6009711409660298638_n.jpg', '10434313_10204946910097032_6009711409660298638_n.jpg', 'image/jpeg', '9280', 0, '2014-12-14 18:02:10', 'record', NULL, 'image', '114185749181276', 0, 0),
(56, 1, 'record-1418576764-43035.tmp', '10434313_10204946910097032_6009711409660298638_n.jpg', 'image/jpeg', '9280', 0, '2014-12-14 18:06:04', 'record', NULL, 'image', '114185749181276', 0, 0),
(57, 1, 'record-1418576865-95443.jpg', '10434313_10204946910097032_6009711409660298638_n.jpg', 'image/jpeg', '9280', 0, '2014-12-14 18:07:44', 'record', NULL, 'image', '114185749181276', 0, 0),
(58, 1, 'record-1418576926-91458.jpg', 'record-1418576926-91458.jpg', 'image/jpeg', '9280', 0, '2014-12-14 18:08:46', 'record', NULL, 'image', '114185749181276', 0, 0),
(59, 1, 'record-1418576966-88780.jpg', 'record-1418576966-88780.jpg', 'image/jpeg', '9280', 0, '2014-12-14 18:09:26', 'record', NULL, 'image', '114185749181276', 0, 0),
(60, 1, 'record-1418576992-54230.jpg', 'record-1418576992-54230.jpg', 'image/jpeg', '9280', 0, '2014-12-14 18:09:52', 'record', 1, 'image', NULL, 0, 0),
(61, 1, 'record-1418577042-38830.jpg', 'record-1418577042-38830.jpg', 'image/jpeg', '9280', 0, '2014-12-14 18:10:42', 'record', 1, 'image', NULL, 0, 0),
(62, 1, 'record-1418577172-12853.jpg', 'record-1418577172-12853.jpg', 'image/jpeg', '9280', 0, '2014-12-14 18:12:52', 'record', NULL, 'image', '114185771661381', 0, 0),
(63, 1, 'record-1418577646-32159.jpg', 'record-1418577646-32159.jpg', 'image/jpeg', '9280', 0, '2014-12-14 18:20:46', 'record', NULL, 'image', '114185775005611', 0, 0),
(64, 1, 'record-1418577761-11337.jpg', 'record-1418577761-11337.jpg', 'image/jpeg', '9280', 0, '2014-12-14 18:22:41', 'record', NULL, 'image', '114185777559131', 0, 0),
(65, 1, 'record-1418577777-78609.jpg', 'record-1418577777-78609.jpg', 'image/jpeg', '9280', 0, '2014-12-14 18:22:57', 'record', NULL, 'video', '114185777559131', 0, 0),
(66, 1, 'record-1418578422-85679.jpg', 'record-1418578422-85679.jpg', 'image/jpeg', '9280', 0, '2014-12-14 18:33:42', 'record', NULL, 'video', '114185784126865', 0, 0),
(67, 1, 'record-1418578462-43706.jpg', 'record-1418578462-43706.jpg', 'image/jpeg', '9280', 0, '2014-12-14 18:34:22', 'record', NULL, 'video', '114185784567764', 0, 0),
(68, 1, 'record-1418578473-50366.jpg', 'record-1418578473-50366.jpg', 'image/jpeg', '9280', 0, '2014-12-14 18:34:33', 'record', NULL, 'image', '114185784567764', 0, 0),
(69, 1, 'record-1418578753-17366.jpg', 'record-1418578753-17366.jpg', 'image/jpeg', '9280', 0, '2014-12-14 18:39:13', 'record', NULL, 'image', '114185787485967', 0, 0),
(70, 1, 'record-1418578767-67774.jpg', 'record-1418578767-67774.jpg', 'image/jpeg', '9280', 0, '2014-12-14 18:39:26', 'record', NULL, 'video', '114185787485967', 0, 0),
(71, 1, 'record-1418578774-59592.jpg', 'record-1418578774-59592.jpg', 'image/jpeg', '9280', 0, '2014-12-14 18:39:34', 'record', NULL, 'audio', '114185787485967', 0, 0),
(72, 1, 'record-1418578879-63830.jpg', 'record-1418578879-63830.jpg', 'image/jpeg', '9280', 0, '2014-12-14 18:41:19', 'record', NULL, 'image', '114185788733245', 0, 0),
(73, 1, 'record-1418578886-74061.jpg', 'record-1418578886-74061.jpg', 'image/jpeg', '9280', 0, '2014-12-14 18:41:25', 'record', NULL, 'video', '114185788733245', 0, 0),
(74, 1, 'record-1418578892-86687.jpg', 'record-1418578892-86687.jpg', 'image/jpeg', '9280', 0, '2014-12-14 18:41:32', 'record', NULL, 'audio', '114185788733245', 0, 0),
(75, 1, 'record-1418578999-18764.jpg', 'record-1418578999-18764.jpg', 'image/jpeg', '9280', 0, '2014-12-14 18:43:19', 'record', NULL, 'video', '114185789946516', 0, 0),
(76, 1, 'record-1418579010-55626.jpg', 'record-1418579010-55626.jpg', 'image/jpeg', '9280', 0, '2014-12-14 18:43:30', 'record', NULL, 'audio', '114185789946516', 0, 0),
(77, 1, 'record-1418579056-61539.jpg', 'record-1418579056-61539.jpg', 'image/jpeg', '9280', 0, '2014-12-14 18:44:16', 'record', 4, 'image', NULL, 0, 0),
(78, 1, 'record-1418579094-74692.jpg', 'record-1418579094-74692.jpg', 'image/jpeg', '9280', 0, '2014-12-14 18:44:54', 'record', 4, 'image', NULL, 0, 0),
(79, 1, 'record-1418579655-95130.jpg', 'record-1418579655-95130.jpg', 'image/jpeg', '9280', 0, '2014-12-14 18:54:15', 'record', 1, 'image', NULL, 0, 0),
(80, 1, 'record-1418579840-15141.jpg', 'record-1418579840-15141.jpg', 'image/jpeg', '9280', 0, '2014-12-14 18:57:20', 'record', 1, 'video', NULL, 0, 0),
(81, 1, 'record-1418579962-12210.jpg', 'record-1418579962-12210.jpg', 'image/jpeg', '9280', 0, '2014-12-14 18:59:22', 'record', 1, 'audio', NULL, 0, 0),
(82, 1, 'record-1418580309-41841.jpg', 'record-1418580309-41841.jpg', 'image/jpeg', '9280', 0, '2014-12-14 19:05:09', 'record', 1, 'image', NULL, 0, 0),
(83, 1, 'record-1418580415-84075.jpg', 'record-1418580415-84075.jpg', 'image/jpeg', '9280', 0, '2014-12-14 19:06:55', 'record', NULL, 'image', '114185804056977', 0, 0),
(84, 1, 'record-1418580424-38215.jpg', 'record-1418580424-38215.jpg', 'image/jpeg', '9280', 0, '2014-12-14 19:07:04', 'record', NULL, 'audio', '114185804056977', 0, 0),
(85, 1, 'record-1418594412-51182.jpg', 'record-1418594412-51182.jpg', 'image/jpeg', '9280', 0, '2014-12-14 23:00:12', 'record', NULL, 'image', '114185944066070', 0, 0),
(86, 1, 'record-1418595007-54137.jpg', 'record-1418595007-54137.jpg', 'image/jpeg', '9280', 0, '2014-12-14 23:10:07', 'record', NULL, 'image', '114185950024137', 0, 0),
(87, 1, 'record-1418595132-89947.jpg', 'record-1418595132-89947.jpg', 'image/jpeg', '9280', 0, '2014-12-14 23:12:12', 'record', NULL, 'image', '114185951035396', 0, 0),
(88, 1, 'record-1418595139-90060.jpg', 'record-1418595139-90060.jpg', 'image/jpeg', '9280', 0, '2014-12-14 23:12:19', 'record', NULL, 'video', '114185951035396', 0, 0),
(89, 1, 'record-1418595146-10928.jpg', 'record-1418595146-10928.jpg', 'image/jpeg', '9280', 0, '2014-12-14 23:12:26', 'record', NULL, 'audio', '114185951035396', 0, 0),
(90, 1, 'record-1418599977-52283.jpg', 'record-1418599977-52283.jpg', 'image/jpeg', '9280', 0, '2014-12-15 00:32:57', 'record', 1, 'image', NULL, 0, 0),
(91, 1, 'record-1418600107-52541.jpg', 'record-1418600107-52541.jpg', 'image/jpeg', '9280', 0, '2014-12-15 00:35:07', 'record', 1, 'image', NULL, 0, 0),
(92, 1, 'record-1418600190-89013.jpg', 'record-1418600190-89013.jpg', 'image/jpeg', '9280', 0, '2014-12-15 00:36:30', 'record', 1, 'image', NULL, 0, 0),
(93, 1, 'record-1418601124-92353.jpg', 'record-1418601124-92353.jpg', 'image/jpeg', '9280', 0, '2014-12-15 00:52:04', 'record', 1, 'image', NULL, 0, 0),
(94, 1, 'record-1418601133-65439.jpg', 'record-1418601133-65439.jpg', 'image/jpeg', '9280', 0, '2014-12-15 00:52:13', 'record', 1, 'video', NULL, 0, 0),
(95, 1, 'record-1418601141-77933.jpg', 'record-1418601141-77933.jpg', 'image/jpeg', '9280', 0, '2014-12-15 00:52:21', 'record', 1, 'audio', NULL, 0, 0),
(96, 1, 'record-1418646027-67079.jpg', 'record-1418646027-67079.jpg', 'image/jpeg', '9280', 0, '2014-12-15 13:20:27', 'record', 1, 'image', NULL, 0, 0),
(97, 1, 'record-1418646035-90878.jpg', 'record-1418646035-90878.jpg', 'image/jpeg', '9280', 0, '2014-12-15 13:20:35', 'record', 1, 'video', NULL, 0, 0),
(98, 1, 'record-1418646051-63580.jpg', 'record-1418646051-63580.jpg', 'image/jpeg', '9280', 0, '2014-12-15 13:20:51', 'record', 1, 'video', NULL, 0, 0),
(99, 1, 'record-1418646065-96036.jpg', 'record-1418646065-96036.jpg', 'image/jpeg', '9280', 0, '2014-12-15 13:21:05', 'record', 1, 'audio', NULL, 0, 0),
(100, 1, 'record-1418646080-32373.jpg', 'record-1418646080-32373.jpg', 'image/jpeg', '9280', 0, '2014-12-15 13:21:20', 'record', 1, 'video', NULL, 0, 0),
(101, 1, 'record-1418646128-58381.jpg', 'record-1418646128-58381.jpg', 'image/jpeg', '9280', 0, '2014-12-15 13:22:08', 'record', 1, 'image', NULL, 0, 0),
(102, 1, 'record-1418646135-20096.jpg', 'record-1418646135-20096.jpg', 'image/jpeg', '9280', 0, '2014-12-15 13:22:15', 'record', 1, 'video', NULL, 0, 0),
(103, 1, 'record-1418646147-70043.jpg', 'record-1418646147-70043.jpg', 'image/jpeg', '9280', 0, '2014-12-15 13:22:27', 'record', 1, 'audio', NULL, 0, 0),
(104, 1, 'record-1418646274-49822.jpg', 'record-1418646274-49822.jpg', 'image/jpeg', '9280', 0, '2014-12-15 13:24:34', 'record', 1, 'video', NULL, 0, 0),
(105, 1, 'record-1418647044-94111.jpg', 'record-1418647044-94111.jpg', 'image/jpeg', '9280', 0, '2014-12-15 13:37:24', 'record', 1, 'image', NULL, 0, 0),
(106, 1, 'record-1418647608-77041.jpg', 'record-1418647608-77041.jpg', 'image/jpeg', '9280', 0, '2014-12-15 13:46:48', 'record', 1, 'image', NULL, 0, 0),
(107, 1, 'record-1418647920-67815.jpg', 'record-1418647920-67815.jpg', 'image/jpeg', '9280', 0, '2014-12-15 13:52:00', 'record', 1, 'image', NULL, 0, 0),
(108, 1, 'record-1418647975-76739.jpg', 'record-1418647975-76739.jpg', 'image/jpeg', '9280', 0, '2014-12-15 13:52:55', 'record', 1, 'image', NULL, 0, 0),
(109, 1, 'record-1418648194-82504.jpg', 'record-1418648194-82504.jpg', 'image/jpeg', '9280', 0, '2014-12-15 13:56:34', 'record', 1, 'video', NULL, 0, 0),
(110, 1, 'record-1418648205-52184.jpg', 'record-1418648205-52184.jpg', 'image/jpeg', '9280', 0, '2014-12-15 13:56:45', 'record', 1, 'audio', NULL, 0, 0),
(111, 1, 'record-1418648210-87200.jpg', 'record-1418648210-87200.jpg', 'image/jpeg', '9280', 0, '2014-12-15 13:56:50', 'record', 1, 'audio', NULL, 0, 0),
(112, 1, 'record-1418668060-37864.jpg', 'record-1418668060-37864.jpg', 'image/jpeg', '9280', 0, '2014-12-15 19:27:40', 'record', 1, 'image', NULL, 0, 0),
(113, 1, 'record-1418668077-30934.jpg', 'record-1418668077-30934.jpg', 'image/jpeg', '9280', 0, '2014-12-15 19:27:56', 'record', 1, 'image', NULL, 0, 0),
(114, 1, 'record-1418668083-44823.jpg', 'record-1418668083-44823.jpg', 'image/jpeg', '9280', 0, '2014-12-15 19:28:03', 'record', 1, 'image', NULL, 0, 0),
(115, 1, 'record-1418669039-82652.jpg', 'record-1418669039-82652.jpg', 'image/jpeg', '9280', 0, '2014-12-15 19:43:59', 'record', 1, 'image', NULL, 0, 0),
(116, 1, 'record-1418669457-18687.jpg', 'record-1418669457-18687.jpg', 'image/jpeg', '9280', 0, '2014-12-15 19:50:57', 'record', 1, 'image', NULL, 0, 0),
(117, 1, 'record-1418669543-83619.jpg', 'record-1418669543-83619.jpg', 'image/jpeg', '9280', 0, '2014-12-15 19:52:23', 'record', 1, 'image', NULL, 0, 0),
(118, 1, 'record-1418669692-41618.jpg', 'record-1418669692-41618.jpg', 'image/jpeg', '9280', 0, '2014-12-15 19:54:52', 'record', 1, 'image', NULL, 0, 0),
(119, 1, 'record-1418669927-97577.jpg', 'record-1418669927-97577.jpg', 'image/jpeg', '9280', 0, '2014-12-15 19:58:47', 'record', 1, 'image', NULL, 0, 0),
(120, 1, 'record-1418670008-87720.jpg', 'record-1418670008-87720.jpg', 'image/jpeg', '9280', 0, '2014-12-15 20:00:08', 'record', 1, 'image', NULL, 0, 0),
(121, 1, 'record-1418670209-46760.jpg', 'record-1418670209-46760.jpg', 'image/jpeg', '9280', 0, '2014-12-15 20:03:29', 'record', 1, 'image', NULL, 0, 0),
(122, 1, 'record-1418670256-30294.jpg', 'record-1418670256-30294.jpg', 'image/jpeg', '9280', 0, '2014-12-15 20:04:16', 'record', 1, 'image', NULL, 0, 0),
(123, 1, 'record-1418670319-66475.jpg', 'record-1418670319-66475.jpg', 'image/jpeg', '9280', 0, '2014-12-15 20:05:19', 'record', 1, 'image', NULL, 0, 0),
(124, 1, 'record-1418670366-76893.jpg', 'record-1418670366-76893.jpg', 'image/jpeg', '9280', 0, '2014-12-15 20:06:06', 'record', 1, 'image', NULL, 0, 0),
(125, 1, 'record-1418670398-74775.jpg', 'record-1418670398-74775.jpg', 'image/jpeg', '9280', 0, '2014-12-15 20:06:38', 'record', 1, 'image', NULL, 0, 0),
(126, 1, 'record-1418670430-79524.jpg', 'record-1418670430-79524.jpg', 'image/jpeg', '9280', 0, '2014-12-15 20:07:10', 'record', 1, 'image', NULL, 0, 0),
(127, 1, 'record-1418670434-71891.jpg', 'record-1418670434-71891.jpg', 'image/jpeg', '9280', 0, '2014-12-15 20:07:14', 'record', 1, 'image', NULL, 0, 0),
(128, 1, 'record-1418670442-99140.jpg', 'record-1418670442-99140.jpg', 'image/jpeg', '9280', 0, '2014-12-15 20:07:22', 'record', 1, 'image', NULL, 0, 0),
(129, 1, 'record-1418670452-64107.jpg', 'record-1418670452-64107.jpg', 'image/jpeg', '9280', 0, '2014-12-15 20:07:32', 'record', 1, 'image', NULL, 0, 0),
(130, 1, 'record-1418670588-98983.jpg', 'record-1418670588-98983.jpg', 'image/jpeg', '9280', 0, '2014-12-15 20:09:48', 'record', 1, 'image', NULL, 0, 0),
(131, 1, 'record-1418670624-70949.jpg', 'record-1418670624-70949.jpg', 'image/jpeg', '9280', 0, '2014-12-15 20:10:24', 'record', 1, 'image', NULL, 0, 0),
(132, 1, 'record-1418670632-85047.jpg', 'record-1418670632-85047.jpg', 'image/jpeg', '9280', 0, '2014-12-15 20:10:32', 'record', 1, 'image', NULL, 0, 0),
(133, 1, 'record-1418670637-84720.jpg', 'record-1418670637-84720.jpg', 'image/jpeg', '9280', 0, '2014-12-15 20:10:37', 'record', 1, 'image', NULL, 0, 0),
(134, 1, 'record-1418670642-92688.jpg', 'record-1418670642-92688.jpg', 'image/jpeg', '9280', 0, '2014-12-15 20:10:42', 'record', 1, 'image', NULL, 0, 0),
(135, 1, 'record-1418672083-81589.jpg', 'record-1418672083-81589.jpg', 'image/jpeg', '9280', 0, '2014-12-15 20:34:43', 'record', 1, 'image', NULL, 0, 0),
(136, 1, 'record-1418672593-59913.jpg', 'record-1418672593-59913.jpg', 'image/jpeg', '9280', 0, '2014-12-15 20:43:13', 'record', 1, 'image', NULL, 0, 0),
(137, 1, 'record-1418672601-99961.jpg', 'record-1418672601-99961.jpg', 'image/jpeg', '9280', 0, '2014-12-15 20:43:21', 'record', 1, 'image', NULL, 0, 0),
(138, 1, 'record-1418672856-49523.jpg', 'record-1418672856-49523.jpg', 'image/jpeg', '9280', 0, '2014-12-15 20:47:36', 'record', 1, 'image', NULL, 0, 0),
(139, 1, 'record-1418676046-74970.jpg', 'record-1418676046-74970.jpg', 'image/jpeg', '9280', 0, '2014-12-15 21:40:45', 'record', 1, 'image', NULL, 0, 0),
(140, 1, 'record-1418676728-44889.jpg', 'record-1418676728-44889.jpg', 'image/jpeg', '9280', 0, '2014-12-15 21:52:08', 'record', 1, 'image', NULL, 0, 0),
(141, 1, 'record-1418678702-55043.mp4', 'record-1418678702-55043.mp4', 'video/mp4', '10657135', 0, '2014-12-15 22:25:01', 'record', 1, 'video', NULL, 0, 0),
(142, 1, 'record-1418678965-71196.mp4', 'record-1418678965-71196.mp4', 'video/mp4', '10657135', 0, '2014-12-15 22:29:25', 'record', 1, 'video', NULL, 0, 0),
(143, 1, 'record-1418684449-10906.jpg', 'record-1418684449-10906.jpg', 'image/jpeg', '42626', 0, '2014-12-16 00:00:49', 'record', 17, 'audio', NULL, 0, 0),
(144, 1, 'record-1418840247-54906.jpg', 'record-1418840247-54906.jpg', 'image/jpeg', '516952', 0, '2014-12-17 19:17:27', 'record', 17, 'image', NULL, 0, 0),
(145, 1, 'record-1418843005-45603.jpg', 'record-1418843005-45603.jpg', 'image/jpeg', '516952', 0, '2014-12-17 20:03:25', 'record', 17, 'image', NULL, 0, 0),
(146, 1, 'record-1418853087-14040.jpg', 'record-1418853087-14040.jpg', 'image/jpeg', '516952', 0, '2014-12-17 22:51:27', 'record', 1, 'image', NULL, 0, 0),
(147, 1, 'record-1418853095-69447.png', 'record-1418853095-69447.png', 'image/png', '255288', 0, '2014-12-17 22:51:35', 'record', 1, 'image', NULL, 0, 0),
(148, 1, 'record-1418853109-71756.jpg', 'record-1418853109-71756.jpg', 'image/jpeg', '55461', 0, '2014-12-17 22:51:49', 'record', 1, 'image', NULL, 0, 0),
(149, 1, 'record-1418853187-95819.jpg', 'record-1418853187-95819.jpg', 'image/jpeg', '55461', 0, '2014-12-17 22:53:07', 'record', 1, 'image', NULL, 0, 0),
(150, 1, 'record-1419064066-42442.jpg', 'record-1419064066-42442.jpg', 'image/jpeg', '516952', 0, '2014-12-20 09:27:46', 'record', 1, 'image', NULL, 0, 0),
(151, 1, 'record-1419064185-64527.jpg', 'record-1419064185-64527.jpg', 'image/jpeg', '390406', 0, '2014-12-20 09:29:45', 'record', 4, 'image', NULL, 0, 0),
(152, 1, 'record-1419659293-66055.jpg', 'record-1419659293-66055.jpg', 'image/jpeg', '22205', 0, '2014-12-27 09:18:13', 'record', 18, 'image', NULL, 0, 0),
(153, 1, 'record-1419659440-67669.jpg', 'record-1419659440-67669.jpg', 'image/jpeg', '22205', 0, '2014-12-27 09:20:40', 'record', 17, 'image', NULL, 0, 0),
(154, 1, 'record-1419659609-63028.jpg', 'record-1419659609-63028.jpg', 'image/jpeg', '22205', 0, '2014-12-27 09:23:29', 'record', 17, 'image', NULL, 0, 0),
(155, 1, 'record-1419661123-66187.mp4', 'record-1419661123-66187.mp4', 'video/mp4', '1202546', 0, '2014-12-27 09:48:43', 'record', 1, 'video', NULL, 0, 0),
(156, 1, 'record-1419661229-17265.mp4', 'record-1419661229-17265.mp4', 'video/mp4', '1202546', 0, '2014-12-27 09:50:29', 'record', 1, 'video', NULL, 0, 0),
(157, 1, 'record-1419661593-27987.mp4', 'record-1419661593-27987.mp4', 'video/mp4', '1202546', 0, '2014-12-27 09:56:33', 'record', 1, 'video', NULL, 0, 0),
(158, 1, 'record-1419661601-27912.mp4', 'record-1419661601-27912.mp4', 'video/mp4', '1202546', 0, '2014-12-27 09:56:41', 'record', 1, 'video', NULL, 0, 0),
(159, 1, 'record-1419671501-67988.mp4', 'record-1419671501-67988.mp4', 'video/mp4', '1202546', 0, '2014-12-27 12:41:41', 'record', 1, 'video', NULL, 0, 0),
(160, 1, 'record-1419671660-82008.mp4', 'record-1419671660-82008.mp4', 'video/mp4', '1202546', 0, '2014-12-27 12:44:20', 'record', 1, 'video', NULL, 0, 0),
(161, 1, 'record-1419674261-33083.mp4', 'record-1419674261-33083.mp4', 'video/mp4', '1202546', 0, '2014-12-27 13:27:41', 'record', 1, 'video', NULL, 0, 0),
(162, 1, 'record-1419674280-19709.mp4', 'record-1419674280-19709.mp4', 'video/mp4', '1202546', 0, '2014-12-27 13:28:00', 'record', 1, 'video', NULL, 0, 0),
(163, 1, 'record-1419674435-65285.mp4', 'record-1419674435-65285.mp4', 'video/mp4', '1202546', 0, '2014-12-27 13:30:35', 'record', 1, 'video', NULL, 0, 0),
(164, 1, 'record-1419674517-46200.mp4', 'record-1419674517-46200.mp4', 'video/mp4', '1202546', 0, '2014-12-27 13:31:57', 'record', 1, 'video', NULL, 0, 0),
(165, 1, 'record-1419674697-83150.mp4', 'record-1419674697-83150.mp4', 'video/mp4', '1202546', 0, '2014-12-27 13:34:57', 'record', 1, 'video', NULL, 0, 0),
(166, 1, 'record-1419674722-83749.mp4', 'record-1419674722-83749.mp4', 'video/mp4', '1202546', 0, '2014-12-27 13:35:22', 'record', 1, 'video', NULL, 0, 0),
(167, 1, 'record-1419674966-68761.mp4', 'record-1419674966-68761.mp4', 'video/mp4', '1202546', 0, '2014-12-27 13:39:26', 'record', 1, 'video', NULL, 0, 0),
(168, 1, 'record-1419675850-53988.mpeg', 'record-1419675850-53988.mpeg', 'video/mpeg', '9908224', 0, '2014-12-27 13:54:10', 'record', 1, 'video', NULL, 0, 0),
(169, 1, 'record-1419675962-38763.mpeg', 'record-1419675962-38763.mpeg', 'video/mpeg', '9908224', 0, '2014-12-27 13:56:02', 'record', 1, 'video', NULL, 0, 0),
(170, 1, 'record-1419676054-36948.mp4', 'record-1419676054-36948.mp4', 'video/mp4', '2280085', 0, '2014-12-27 13:57:34', 'record', 1, 'video', NULL, 0, 0),
(171, 1, 'record-1419744220-15010.mp3', 'record-1419744220-15010.mp3', 'audio/mpeg', '707124', 0, '2014-12-28 08:53:40', 'record', 1, 'audio', NULL, 0, 0),
(172, 1, 'record-1419744282-19622.mp3', 'record-1419744282-19622.mp3', 'audio/mpeg', '707124', 0, '2014-12-28 08:54:42', 'record', 1, 'audio', NULL, 0, 0),
(173, 1, 'record-1419744307-17839.mp3', 'record-1419744307-17839.mp3', 'audio/mpeg', '707124', 0, '2014-12-28 08:55:07', 'record', 1, 'audio', NULL, 0, 0),
(174, 1, 'record-1419744620-32322.mp3', 'record-1419744620-32322.mp3', 'audio/mpeg', '707124', 0, '2014-12-28 09:00:20', 'record', 1, 'audio', NULL, 0, 0),
(175, 1, 'record-1419744949-20537.mpg', 'record-1419744949-20537.mpg', 'video/mpeg', '9908224', 0, '2014-12-28 09:05:49', 'record', 1, 'video', NULL, 0, 0),
(176, 1, 'record-1419745124-13423.mpg', 'record-1419745124-13423.mpg', 'video/mpeg', '9908224', 0, '2014-12-28 09:08:44', 'record', 1, 'video', NULL, 0, 0),
(177, 1, 'record-1419745238-35476.mpg', 'record-1419745238-35476.mpg', 'video/mpeg', '9908224', 0, '2014-12-28 09:10:38', 'record', 1, 'video', NULL, 0, 0),
(178, 1, 'record-1420314006-33403.png', 'record-1420314006-33403.png', 'image/png', '126462', 0, '2015-01-03 23:10:06', 'record', NULL, 'image', NULL, NULL, NULL),
(179, 1, 'record-1420314171-96562.png', 'record-1420314171-96562.png', 'image/png', '246855', 0, '2015-01-03 23:12:51', 'record', NULL, 'image', NULL, NULL, NULL),
(180, 1, 'record-1420314312-62372.png', 'record-1420314312-62372.png', 'image/png', '246855', 0, '2015-01-03 23:15:12', 'record', NULL, 'image', NULL, NULL, NULL),
(181, 1, 'record-1420314370-50025.png', 'record-1420314370-50025.png', 'image/png', '246855', 0, '2015-01-03 23:16:10', 'record', NULL, 'image', NULL, NULL, NULL),
(182, 1, 'record-1420314485-21590.png', 'record-1420314485-21590.png', 'image/png', '126462', 0, '2015-01-03 23:18:05', 'record', NULL, 'image', NULL, NULL, NULL),
(183, 1, 'record-1420314586-17836.png', 'record-1420314586-17836.png', 'image/png', '126328', 0, '2015-01-03 23:19:46', 'record', NULL, 'image', NULL, NULL, NULL),
(184, 1, 'record-1420314619-57810.png', 'record-1420314619-57810.png', 'image/png', '126462', 0, '2015-01-03 23:20:19', 'record', NULL, 'image', NULL, NULL, NULL),
(185, 1, 'record-1420314659-92470.png', 'record-1420314659-92470.png', 'image/png', '126328', 0, '2015-01-03 23:20:59', 'record', NULL, 'image', NULL, NULL, NULL),
(186, 1, 'record-1420314681-64337.png', 'record-1420314681-64337.png', 'image/png', '246855', 0, '2015-01-03 23:21:21', 'record', NULL, 'video', NULL, NULL, NULL),
(187, 1, 'record-1420314715-53906.png', 'record-1420314715-53906.png', 'image/png', '246855', 0, '2015-01-03 23:21:55', 'record', NULL, 'image', NULL, NULL, NULL),
(188, 1, 'record-1420314785-49788.png', 'record-1420314785-49788.png', 'image/png', '246855', 0, '2015-01-03 23:23:05', 'record', NULL, 'image', NULL, 1, 0),
(189, 1, 'record-1420315149-30727.gif', 'record-1420315149-30727.gif', 'image/gif', '286464', 0, '2015-01-03 23:29:09', 'record', NULL, 'image', NULL, 1, 0),
(190, 1, 'record-1420317873-46385.jpeg', 'record-1420317873-46385.jpeg', 'image/jpeg', '1211', 0, '2015-01-04 00:14:33', 'record', NULL, 'image', NULL, NULL, NULL),
(191, 1, 'record-1420319438-80503.jpeg', 'record-1420319438-80503.jpeg', 'image/jpeg', '1211', 0, '2015-01-04 00:40:38', 'record', NULL, 'image', NULL, NULL, NULL),
(192, 1, 'record-1420319570-17455.jpeg', 'record-1420319570-17455.jpeg', 'image/jpeg', '1211', 0, '2015-01-04 00:42:50', 'record', NULL, 'image', NULL, NULL, NULL),
(193, 1, 'record-1420319588-20295.mp4', 'record-1420319588-20295.mp4', 'video/mp4', '1202546', 0, '2015-01-04 00:43:08', 'record', NULL, 'image', NULL, NULL, NULL),
(194, 1, 'record-1420319609-94624.mp4', 'record-1420319609-94624.mp4', 'video/mp4', '1202546', 0, '2015-01-04 00:43:29', 'record', NULL, 'image', NULL, NULL, NULL),
(195, 1, 'record-1420319668-70295.mp3', 'record-1420319668-70295.mp3', 'audio/mpeg', '2881664', 0, '2015-01-04 00:44:27', 'record', NULL, 'image', NULL, NULL, NULL),
(196, 1, 'record-1420319799-23696.mp3', 'record-1420319799-23696.mp3', 'audio/mpeg', '2881664', 0, '2015-01-04 00:46:39', 'record', NULL, 'image', NULL, NULL, NULL),
(197, 1, 'record-1420320012-60032.mp3', 'record-1420320012-60032.mp3', 'audio/mpeg', '2881536', 0, '2015-01-04 00:50:12', 'record', NULL, 'image', NULL, NULL, NULL),
(198, 1, 'record-1420320345-24421.jpeg', 'record-1420320345-24421.jpeg', 'image/jpeg', '1211', 0, '2015-01-04 00:55:45', 'record', NULL, 'image', NULL, NULL, NULL),
(199, 1, 'record-1420320379-62287.mp3', 'record-1420320379-62287.mp3', 'audio/mpeg', '2878153', 0, '2015-01-04 00:56:19', 'record', NULL, 'audio', NULL, NULL, NULL),
(200, 1, 'record-1420347677-74700.jpeg', 'record-1420347677-74700.jpeg', 'image/jpeg', '1211', 0, '2015-01-04 08:31:17', 'record', NULL, 'image', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fos_user`
--

CREATE TABLE IF NOT EXISTS `fos_user` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fos_user_group`
--

CREATE TABLE IF NOT EXISTS `fos_user_group` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fos_user_user`
--

INSERT INTO `fos_user_user` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `locked`, `expired`, `expires_at`, `confirmation_token`, `password_requested_at`, `roles`, `credentials_expired`, `credentials_expire_at`, `created_at`, `updated_at`, `date_of_birth`, `firstname`, `lastname`, `website`, `biography`, `gender`, `locale`, `timezone`, `phone`, `facebook_uid`, `facebook_name`, `facebook_data`, `twitter_uid`, `twitter_name`, `twitter_data`, `gplus_uid`, `gplus_name`, `gplus_data`, `token`, `two_step_code`) VALUES
(1, 'admin', 'admin', 'admin@darkish.ir', 'admin@darkish.ir', 1, 'q2vdhsg8qk0s0o4sg8c0kw4k0ookoo4', 'KgZhMfcxwkcWPJmk42BdvSYzoNA8Y4QtErWhlmPklfSiVngHeQwyDvUY2OLxM1HN5h8bD/UCOXlbm8epAT7iTw==', '2015-01-04 08:30:18', 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:16:"ROLE_SUPER_ADMIN";}', 0, NULL, '2014-09-11 12:44:17', '2015-01-04 08:30:18', NULL, NULL, NULL, NULL, NULL, 'u', NULL, NULL, NULL, NULL, NULL, 'null', NULL, NULL, 'null', NULL, NULL, 'null', NULL, NULL),
(2, 'operator', 'operator', 'operator@darkish.ir', 'operator@darkish.ir', 1, 'b29uhyh7negws84csg4wos8cskc80ks', 'Wi6kFKcBP7KS/HVsAHy0kc5YFACtYpbx5tO5EOv4eyEDZ88BHU/QLeHSLIcbcpveoPH4lJziMLFwGN1cOTFwag==', '2014-12-29 11:19:20', 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:16:"ROLE_SUPER_ADMIN";}', 0, NULL, '2014-12-28 20:52:09', '2014-12-29 11:19:20', NULL, NULL, NULL, NULL, NULL, 'u', NULL, NULL, NULL, NULL, NULL, 'null', NULL, NULL, 'null', NULL, NULL, 'null', NULL, NULL);

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
-- Table structure for table `itinerarytype`
--

CREATE TABLE IF NOT EXISTS `itinerarytype` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
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
) ENGINE=InnoDB AUTO_INCREMENT=235 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `maintree`
--

INSERT INTO `maintree` (`id`, `UpTreeIndex`, `TreeIndex`, `Sort`, `Title`, `SubTitle`, `BackKeyTitle`, `SearchKeywords`, `ShowInfoKey`, `InfoKeyTitle`, `InfoHtmlIndex`, `ShowSubtreeAsFilter`, `ShowDistanceFilter`, `DistanceFilterWithArea`, `ShowBrandsKey`, `ShowMessagesKey`, `ShowSponsorBox`, `SponsorGroup`, `ShowCenters`, `CentersKeyTitle`, `CentersGroupIndex`, `CentersShowAsDefault`, `CentersListAfterGroup`, `DbaseType`, `ShowDbaseKey`, `DbaseKeyTitle`, `ShowDbaseUpdate`, `DbaseUpdateKeyTitle`, `IconFileName`, `IconSetFilesName`, `FontColor`, `BackColor`, `SubPicShow`, `SubBackground`, `SubUnitHeightScale`, `HiddenTree`) VALUES
(118, '0003', '000308', 8, 'پارک و سواحل تفريحي', 'پارک ساحلي مرجان - پارک شهر - ساحل کشتي يوناني', 'تفريحات', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(119, '0003', '000309', 9, 'اماکن و تورهاي گردشگري', 'شهر حريره - کاريز - تور هندورابي - گشت دور جزيره', 'تفريحات', '', 0, 'اطلاعات کاربردي', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(120, '0008', '000800', 0, 'نمايشگاه هاي ماشين', 'جستجو در همه نمايشگاه هاي جزيره - نمايشگاه ها', 'خودرو', '', 0, 'اطلاعات کاربردي', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(121, '0008', '000801', 1, 'کرايه اتومبيل', 'رنت - شرکت هاي مجاز کرايه اتومبيل - قيمت ها', 'خودرو', '', 0, 'اطلاعات کاربردي', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(122, '0008', '000802', 2, 'خدمات خودرو', 'مراکز خدماتي - صافکاري و نقاشي - تعميرگاه', 'خودرو', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(123, '0008', '000803', 3, 'نمايندگي هاي مجاز', 'ايرتويا - کيا و هيوندا - فرد', 'خودرو', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(124, '0008', '000804', 4, 'پمپ بنزين', 'آدرس - خدمات - ساعات کار', 'خودرو', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(125, '0008', '000805', 5, 'بيمه ثالث و بدنه اتومبيل', 'بيمه ايران - بيمه دنا - بيمه پارسيان', 'خودرو', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(126, '0008', '000806', 6, 'آموزشگاه رانندگي', 'تعليم و آموزش رانندگي - مجري آزمون رانندگي', 'خودرو', '', 0, 'اطلاعات کاربردي', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(127, '0010', '001000', 0, 'بيمارستان', 'بيمارستان هاي کيش - خدمات و امکانات', 'مراکز بهداشتي', '', 0, 'اطلاعات کاربردي', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(128, '0010', '001001', 1, 'کلينيک و مراکز درماني', 'کلينيک دندانپزشکي - مرکز بهداشت بوعلي', 'مراکز بهداشتي', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(129, '0010', '001002', 2, 'مطب پزشکان', 'دندانپزشکي - پوست و مو - کودکان - داخلي', 'مراکز بهداشتي', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(130, '0010', '001003', 3, 'خدمات بهداشتي و تناسب اندام', 'ليزر مو - ساکشن - کاشت مو - ترميم پوست', 'مراکز بهداشتي', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(131, '0010', '001004', 4, 'داروخانه', 'آدرس - ساعات کاري', '', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(132, '0011', '001100', 0, 'مهد کودک و پيش دبستاني', 'آدرس - شماره تماس - خدمات و توضيحات تکميلي', 'مراکز آموزشي', '', 0, 'اطلاعات تکميلي', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(133, '0011', '001101', 1, 'مدارس', 'ابتدايي - راهنمايي - متوسطه - هنرستان', 'مراکز آموزشي', '', 0, 'اطلاعات تکميلي', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(134, '0011', '001102', 2, 'دانشگاه', 'آدرس - رشته هاي آموزشي - توضيحات تکميلي', 'مراکز آموزشي', '', 0, 'اطلاعات کاربردي', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(135, '00', '0000', 0, 'درباره کيش', '', 'صفحه اول', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(136, '00', '0001', 1, 'بازارهاي تجاري', 'برندها - واحدهاي مراکز تجاري', 'صفحه اول', 'بازار تجاري خريد برند جنس مراکز پاساژ', 0, '', '', 0, '0', 0, 1, 1, 0, 0, 0, 'نام مراکز تجاري', 1, 1, 1, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(137, '00', '0002', 2, 'رستوران و کافي شاپ', 'موسيقي زنده - فست فود - طباخي - آبميوه و بستني', 'صفحه اول', '', 0, 'اطلاعات کاربردي', '', 0, '0', 0, 0, 1, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(138, '00', '0003', 3, 'مراکز تفريحي و ورزشي', 'بازي هاي دريايي - اماکن ورزشي و تفريحي - سافاري', 'صفحه اول', '', 0, 'قيمت تفريحات', '', 0, '0', 0, 0, 1, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(139, '00', '0004', 4, 'نيازهاي روزانه', 'سوپرمارکت - نانوايي - ميوه - آرايشگاه - تاکسي', 'صفحه اول', 'سوپر مارکت نان نانوايي شيريني فانتزي ميوه سبزي آرايشگاه تاکسي گاز آب خياطي کفاشي', 0, 'اطلاعات کاربردي', '', 0, '0', 0, 0, 1, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(140, '00', '0005', 5, 'هتل و مراکز اقامتي', 'هتل هاي 5 ستاره - اقامت در جزيره کيش', 'صفحه اول', '', 0, 'اطلاعات کاربردب', '', 0, '1', 1, 0, 1, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(141, '00', '0006', 6, 'آژانس هاي مسافرتي', 'بليط هواپيما - سفر دريايي - رزرو بليط', 'صفحه اول', '', 0, 'اطلاعات کاربردي', '', 0, '1', 1, 0, 1, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(142, '00', '0007', 7, 'آژانس هاي مسکن', 'املاک و مستغلات - خريد، رهن و اجاره منزل - مشاورين', 'صفحه اول', '', 0, 'اطلاعات کاربردي', '', 0, '1', 1, 0, 1, 0, 0, 0, '', 0, 0, 0, 1, 1, 'جستجو فايل در همه املاک', 1, 'بروزرساني همه', '', '', '16711680', '16777215', 0, '', '', 0),
(143, '00', '0008', 8, 'خودرو', 'نمايشگاه ماشين - کرايه اتومبيل - مراکز خدماتي', 'صفحه اول', '', 0, 'معرفي خودروهاي روز', '', 0, '0', 0, 0, 1, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(144, '00', '0009', 9, 'مراکز خدماتي', 'لوازم و دکوراسيون ساختماني - دفاتر حقوقي و اداري', 'صفحه اول', '', 0, 'اطلاعات کاربردي', '', 0, '0', 0, 0, 1, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(145, '00', '0010', 10, 'مراکز بهداشتي و درماني', 'بيمارستان - درمانگاه - مطب پزشکان - تناسب اندام', 'صفحه اول', '', 0, 'اطلاعات کاربردي', '', 0, '0', 0, 0, 1, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(146, '00', '0011', 11, 'مراکز آموزشي، فرهنگي و هنري', 'مدارس - دانشگاه - آموزشگاه - اساتيد خصوصي', 'صفحه اول', '', 0, 'اطلاعات کاربردي', '', 0, '0', 0, 0, 1, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(147, '0011', '001103', 3, 'آموزشگاه', 'زبان - تخصصي - کمک درسي - هنري', 'مراکز آموزشي', '', 0, 'اطلاعات کاربردي', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(148, '0011', '001104', 4, 'آموزش خصوصي', 'کمک درسي - زبان - هنري', 'مراکز آموزشي', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(149, '0011', '001105', 5, 'فرهنگسرا', 'آدرس - خدمات و امکانات - ساعات کاري', 'مراکز آموزشي', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(150, '0011', '001106', 6, 'کتابخانه', 'آدرس - ساعات کاري', '', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(151, '0001', '000100', 0, 'لباس مردانه', 'لباس مردانه - کت و شلوار - لباس زير', 'بازارهاي تجاري', '', 0, '', '', 1, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(152, '0001', '000101', 1, 'لباس زنانه', 'مانتو - روسري - لباس مجلسي - لباس زير', 'بازارهاي تجاري', '', 0, '', '', 1, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(153, '0001', '000102', 2, 'پوشاک و لوازم کودک، اسباب بازي', 'لباس بچه - سيسموني و کالاي اتاق کودک - اسباب بازي', 'بازارهاي تجاري', '', 0, '', '', 1, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(154, '0001', '000103', 3, 'کيف و کفش - چمدان', 'کفش مردانه - کيف و کفش زنانه - چمدان', 'بازارهاي تجاري', '', 0, '', '', 1, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(155, '0001', '000104', 4, 'آرايشي، بهداشتي و دارويي', 'لوازم آرايشي - مکمل هاي غذايي - داردهاي گياهي', 'بازارهاي تجاري', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(156, '0001', '000105', 5, 'عطر و ادکلن', 'برندها - معرفي محصولات روز - ادکلن هاي اصل', 'بازارهاي تجاري', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(157, '0001', '000106', 6, 'ورزشي', 'پوشاک ورزشي - لوازم و تجهيزات - نماينگي هاي معتبر', 'بازارهاي تجاري', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(158, '0001', '000107', 7, 'رايانه، موبايل و دوربين', 'تلفن - موبايل - نوت بوک - دوربين', 'بازارهاي تجاري', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(159, '0001', '000108', 8, 'زيورآلات', 'طلا و جواهر - ساعت - عينک - بدليجات', 'بازارهاي تجاري', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(160, '0001', '000109', 9, 'لوازم منزل و تزئيني', 'لوازم منزل و آشپزخانه - تصويري - لوازم تزئيني', 'بازارهاي تجاري', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(161, '0001', '000110', 10, 'بانک و موسسات مالي', 'بانک - موسسات مالي و اعتباري - صرافي', 'بازارهاي تجاري', '', 0, '', '', 1, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(162, '0001', '000111', 11, 'آژانس هاي مسافرتي', 'خريد و رزرو بليط هواپيما - تورهاي مسافرتي', 'بازارهاي تجاري', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(163, '0001', '000112', 12, 'رستوران و کافي شاپ', 'آبميوه - فست فود - کافي شاپ و رستوران داخل بازار', 'بازارهاي تجاري', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(164, '0001', '000113', 13, 'شکلات فروشي', 'برندهاي معتبر - قرعه کشي ها و جوايز - محصولات', 'بازارهاي تجاري', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(165, '0001', '000114', 14, 'لوازم التحرير، مواد مصرفي و ماشين هاي اداري', 'برندها - محصولات - لوازم و تجهيزات دفترهاي اداري', 'بازارهاي تجاري', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(166, '0001', '000115', 15, 'کانتر و ديگر واحدهاي بازار', 'کانترهاي گردشگري - ماشين کودک - کافي نت و غيره', '', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(167, '0009', '000900', 0, 'راه و ساختمان', 'مصالح - پيمانکاران - تاسيساتي و بهداشتي - آسانسور', 'مراکز خدماتي', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(168, '0009', '000901', 1, 'مبلمان و دکوراسيون', 'مبلمان اداري و خانگي - فرش و موکت - پرده - روشنايي', 'مراکز خدماتي', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(169, '0009', '000902', 2, 'لوازم و خدمات فردي و خانگي', 'سمساري - قاليشويي - کليدسازي - گل فروشي', 'مراکز خدماتي', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(170, '0009', '000903', 3, 'دفاتر اداري، حقوقي و بيمه', 'پست - پليس+10 - بيمه - ثبت اسناد - ثبت احوال', 'مراکز خدماتي', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(171, '0009', '000904', 4, 'تعميرات و خدمات فني', 'تعمير لوازم منزل - نمايندگي مجاز - تعمير موبايل', 'مراکز خدماتي', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(172, '0009', '000905', 5, 'بانک و موسسات مالي', 'موسسات مالي و اعتباري - صرافي', 'مراکز خدماتي', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(173, '0009', '000906', 6, 'اينترنت، شبکه و خدمات آي تي', 'اينترنت - خدمات پس از فروش - طراحي سايت', 'مراکز خدماتي', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(174, '0009', '000907', 7, 'حفاظتي، نظارتي و ايمني', 'فروش، نصب و خدمات پس از فروش', 'مراکز خدماتي', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(175, '0009', '000908', 8, 'تامين، ترخيص و پخش کالا', 'سردخانه مواد غذايي - صادرات و واردات - ترخيص کالا', 'مراکز خدماتي', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(176, '0009', '000909', 9, 'حمل و نقل و باربري', 'حمل بار - پست هوايي - 6 چرخ - هايس', 'مراکز خدماتي', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(177, '0009', '000910', 10, 'مطبوعات، تبليغات، چاپ و تکثير', 'نشريات - خدمات فني - طراحي و خدمات تبليغاتي', 'مراکز خدماتي', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(178, '0009', '000911', 11, 'خدمات و فعاليت هاي صنعتي', 'تراشکاري - نجاري - نقاشي ساختمان - سيم پيچي', 'مراکز خدماتي', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(179, '0009', '000912', 12, 'شرکت ها و کارخانجات', 'نفتي - صنعتي - کاريابي - توليدي - بازرگاني', 'مراکز خدماتي', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(180, '0005', '000502', 2, '3 ستاره', '', '', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(181, '0005', '000503', 3, 'مهمانپذير', '', '', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(182, '00', '0012', 12, 'فرصت هاي سرمايه گذاري', 'سرمايه گذاري در پروژه - معرفي فايل هاي اکازيون', 'صفحه اول', '', 0, 'اطلاعات کاربردي', '', 0, '0', 0, 0, 1, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(183, '0000', '000000', 0, 'معرفي جزيره کيش', 'تاريخچه - طبيعت - گونه هاي جانوري - بوميان کيش', 'درباره کيش', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(184, '0000', '000001', 1, 'اطلاعات کاربردي', 'سفر به کيش - زندگي، کسب و کار در کيش', 'درباره کيش', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(185, '0000', '000002', 2, 'سازمان منطقه آزاد', 'معرفي - معاونت ها و ادارات - برنامه ها', 'درباره کيش', '', 1, 'معرفي سازمان', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(186, '0000', '000003', 3, 'ديگر ادارات و سازمان هاي دولتي', 'دادگستري - مخابرات - آب و برق - نيروي انتظامي', 'درباره کيش', '', 1, 'اطلاعات کاربردي', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(187, '0000', '000004', 4, 'اماکن عمومي', 'نمايشگاه - تالار شهر - فرودگاه - بندرگاه - مصلي', 'درباره کيش', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(188, '0000', '000005', 5, 'اماکن گردشگري و جاذبه هاي توريستي', 'ابنيه تاريخي کيش - پارک ها و امکن توريستي', 'درباره کيش', '', 0, '', '', 0, '1', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(189, '0000', '000006', 6, 'قوانين و ضوابط اداري در کيش', 'قوانين رانندگي - ثبت شرکت - مجوز فعاليت اقتصادي', 'درباره کيش', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(190, '0000', '000007', 7, 'تلفن هاي ضروري کيش', 'سازمان - دادگستري - نيروي انتظامي - فرودگاه', 'درباره کيش', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(191, '0000', '000008', 8, 'پروژه ها و طرح هاي در حال اجرا', 'موزه و نماد شهري', 'درباره کيش', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(192, '0000', '000009', 9, 'انجمن هاي صنفي و تشکل ها', 'جامعه هتلداران - مراکز پذيرايي - مجمع رنت کاران', 'درباره کيش', '', 0, '', '', 0, '0', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(193, '0002', '000200', 0, 'موسيقي زنده', 'رستوران هاي داراي موسيقي زنده', 'رستوران', '', 0, '', '', 0, '1', 1, 0, 1, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(194, '0002', '000201', 1, 'رستوران هاي ايراني', 'چلوکبابي - رستوران هاي هتل', 'رستوران', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(195, '0002', '000202', 2, 'سنتي', 'سفره خانه - ديزي سرا', 'رستوران', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(196, '0002', '000203', 3, 'فست فود', 'پيتزا - مرغ سوخاري - همبرگر و ساندويچ', 'رستوران', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(197, '0004', '000400', 0, 'سوپر مارکت', 'آدرس - نمايش روي نقشه - ساعات کاري - محصولات', 'نيازهاي روزانه', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(198, '0004', '000401', 1, 'ميوه فروشي', 'آدرس - نمايش روي نقشه - ساعات کاري', 'نيازهاي روزانه', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(199, '0004', '000402', 2, 'قصابي و مواد پروتئيني', 'گوشت و مرغ - سوسيس و کالباس - فرآورده هاي گوشتي', 'نيازهاي روزانه', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(200, '0004', '000403', 3, 'نانوايي', 'سنگک - لواش - بربري - آدرس و نمايش بروي نقشه', 'نيازهاي روزانه', '', 0, '', '', 1, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(201, '0004', '000404', 4, 'شيريني و نان فانتزي', 'خشکبار - نان هاي رژيمي - آدرس و نمايش بر روي نقشه', 'نيازهاي روزانه', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(202, '0004', '000405', 5, 'آرايشگاه', 'مردانه - زنانه - آدرس و نمايش بر روي نقشه', 'نيازهاي روزانه', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(203, '000405', '00040500', 0, 'مردانه', 'آدرس - خدمات - ساعت کار - نمايش بر روي نقشه', 'آرايشگاه', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(204, '000405', '00040501', 1, 'زنانه', 'آدرس - خدمات - ساعات کاري - نمايش بر روي نقشه', 'آرايشگاه', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(205, '000403', '00040300', 0, 'بربري', '', '', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(206, '000403', '00040301', 1, 'لواش', '', '', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(207, '000403', '00040302', 2, 'سنگک', '', '', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(208, '000403', '00040303', 3, 'غيره', '', '', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(209, '0004', '000406', 6, 'خياطي و کفاشي', 'دوزندگي - تعميرات لباس - تعميرات کفش', 'نيازهاي روزانه', '', 0, '', '', 1, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(210, '000406', '00040600', 0, 'خياطي و دوزندگي', '', '', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(211, '000406', '00040601', 1, 'کفاشي', '', '', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(212, '0004', '000407', 7, 'ويدئو کلوپ و کحصولات فرهنگي', 'محصولات رسانه هاي تصويري - آدرس - محصولات', 'نيازهاي روزانه', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(213, '0004', '000408', 8, 'خشکشويي', 'آدرس - نمايش بر روي نقشه - ساعات کاري', 'نيازهاي روزانه', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(214, '0004', '000409', 9, 'تاکسي', 'شماره تلفن -نرخ کرايه تاکسي در جزيره کيش', 'نيازهاي روزانه', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(215, '0004', '000410', 10, 'پخش آب', 'شماره تلفن - نرخ محصولات', 'نيازهاي روزانه', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(216, '0004', '000411', 11, 'پخش گاز', 'شماره تلفن - نرخ محصولات', 'نيازهاي روزانه', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(217, '0005', '000500', 0, '5 ستاره', '', '', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(218, '0005', '000501', 1, '4 ستاره', '', '', '', 0, '', '', 0, '0', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(219, '0002', '000204', 4, 'رستوران ملل', 'ايتاليايي - هندي - عربي - فرنگي', 'رستوران', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(220, '0002', '000205', 5, 'دريايي', 'ماهي - ميگو', 'رستوران', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(221, '0002', '000206', 6, 'آشپزخانه', 'مراکز تهيه غذا - غذاي شرکتي و پرسنلي', 'رستوران', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(222, '0002', '000207', 7, 'کافي شاپ و کافه', 'کافه - بوفه - قهوه - هات چاکلت', 'رستوران', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(223, '0002', '000208', 8, 'آبميوه و بستني', 'آب اناري - بستني سنتي و ميوه اي - فالوده', 'رستوران', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(224, '0002', '000209', 9, 'کبابي و جگرکي', 'کباب بناب - جوجه کباب - دل و جگر', 'رستوران', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(225, '0002', '000210', 10, 'طباخي', 'کله و پاچه - سيرابي', 'رستوران', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(226, '0002', '000211', 11, 'چايخانه و قهوه خانه', 'چاي - قليان - نيمرو - املت', 'رستوران', '', 0, '', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(227, '0003', '000300', 0, 'تفريحات دريايي', 'کلوپ هاي دريايي - غواصي - جت اسکي', 'تفريحات', '', 0, 'قيمت تفريحات دريايي', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(228, '0003', '000301', 1, 'کشتي تفريحي', 'موسيقي دار - گردشي - آکواريومي', 'تفريحات', '', 0, 'قيمت انواع کشتي', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(229, '0003', '000302', 2, 'تفريحات ورزشي', 'بولينگ - بيليارد - کارتينگ - دوچرخه و اسکوتر', 'تفريحات', '', 0, 'قيمت تفريحات', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(230, '0003', '000303', 3, 'مراکز تفريحي', 'پارک دولفين ها - پارس سافاري کيش - بولينگ مريم', 'تفريحات', '', 0, 'قيمت تفريحات', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(231, '0003', '000304', 4, 'تفريحات هيجاني', 'سينما 3 و 4 بعدي - تلسم موميايي - قلعه وحشت', 'تفريحات', '', 0, 'قيمت تفريحات', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(232, '0003', '000305', 5, 'ماساژ و اسپا', 'ماساژ سنگ - ماساژ تايلندي - ماساژورها', 'تفريحات', '', 0, 'قيمت خدمات', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(233, '0003', '000306', 6, 'پلاژ', 'آقايان - بانوان', 'تفريحات', '', 0, 'اطلاعات', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0),
(234, '0003', '000307', 7, 'مراکز ورزشي', 'مجموعه المپيک - استخر کرانه - اسپرت کلاپ', 'تفريحات', '', 0, 'اطلاعات کاربردي', '', 0, '1', 1, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '', '', '', '16711680', '16777215', 0, '', '', 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  `Owner` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `LegalName` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CenterIndex` int(11) DEFAULT NULL,
  `CenterFloor` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CenterUnitNumber` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `AreaIndex` int(11) DEFAULT NULL,
  `MessageEnable` tinyint(1) DEFAULT NULL,
  `MessageText` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `MessageInsertDate` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `safarsazTypeIndex` int(11) DEFAULT NULL,
  `SafarsazRank` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TelNumberOne` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `FaxNumberOne` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `MobileNumberOne` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Longitude` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Latitude` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Reserved1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Reserved2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `BrandEnable` tinyint(1) DEFAULT NULL,
  `ListRank` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `WorkingDays` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `SearchKeywords` longtext COLLATE utf8_unicode_ci,
  `CreationDate` datetime NOT NULL,
  `LastUpdate` datetime NOT NULL,
  `FavoriteEnable` tinyint(1) DEFAULT NULL,
  `LikeEnable` tinyint(1) DEFAULT NULL,
  `SendSmsEnable` tinyint(1) DEFAULT NULL,
  `InfoKeyEnable` tinyint(1) DEFAULT NULL,
  `CommentEnable` tinyint(1) DEFAULT NULL,
  `OnlyHtml` tinyint(1) DEFAULT NULL,
  `OnlineEnable` tinyint(1) DEFAULT NULL,
  `DbaseEnable` tinyint(1) DEFAULT NULL,
  `DbaseTypeIndex` int(11) DEFAULT NULL,
  `BulkSmsEnable` tinyint(1) DEFAULT NULL,
  `Audio` tinyint(1) DEFAULT NULL,
  `Video` tinyint(1) DEFAULT NULL,
  `OnlineMarket` tinyint(1) DEFAULT NULL,
  `OnlineTicket` tinyint(1) DEFAULT NULL,
  `VisitCount` int(11) DEFAULT NULL,
  `FavoriteCount` int(11) DEFAULT NULL,
  `LikeCount` int(11) DEFAULT NULL,
  `Verify` tinyint(1) NOT NULL DEFAULT '0',
  `record_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `safarsaz` tinyint(1) DEFAULT NULL,
  `MessageValidityDate` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `MOpeningHoursFrom` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `MOpeningHoursTo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `AOpeningHoursFrom` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `AOpeningHoursTo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TelNumberTwo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TelNumberThree` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TelNumberFour` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `FaxNumberTwo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `MobileNumberTwo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Body` longtext COLLATE utf8_unicode_ci,
  `Active` tinyint(1) NOT NULL DEFAULT '0',
  `EnglishTitle` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EnglishSubTitle` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ArabicTitle` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ArabicSubTitle` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TurkishTitle` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TurkishSubTitle` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `AccessClass` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `record`
--

INSERT INTO `record` (`id`, `Title`, `SubTitle`, `Owner`, `LegalName`, `CenterIndex`, `CenterFloor`, `CenterUnitNumber`, `AreaIndex`, `MessageEnable`, `MessageText`, `MessageInsertDate`, `safarsazTypeIndex`, `SafarsazRank`, `TelNumberOne`, `FaxNumberOne`, `MobileNumberOne`, `Email`, `Website`, `Address`, `Longitude`, `Latitude`, `Reserved1`, `Reserved2`, `BrandEnable`, `ListRank`, `WorkingDays`, `SearchKeywords`, `CreationDate`, `LastUpdate`, `FavoriteEnable`, `LikeEnable`, `SendSmsEnable`, `InfoKeyEnable`, `CommentEnable`, `OnlyHtml`, `OnlineEnable`, `DbaseEnable`, `DbaseTypeIndex`, `BulkSmsEnable`, `Audio`, `Video`, `OnlineMarket`, `OnlineTicket`, `VisitCount`, `FavoriteCount`, `LikeCount`, `Verify`, `record_number`, `safarsaz`, `MessageValidityDate`, `MOpeningHoursFrom`, `MOpeningHoursTo`, `AOpeningHoursFrom`, `AOpeningHoursTo`, `TelNumberTwo`, `TelNumberThree`, `TelNumberFour`, `FaxNumberTwo`, `MobileNumberTwo`, `Body`, `Active`, `EnglishTitle`, `EnglishSubTitle`, `ArabicTitle`, `ArabicSubTitle`, `TurkishTitle`, `TurkishSubTitle`, `AccessClass`) VALUES
(1, 'عنوان جدیدs', 'ش asd', '12', 'شسی شسی', 4, '3', '12', 3, 0, 'asdasdf', '2014-06-23T19:30:00.000Z', 2, '3', '', '', '', '', '', '', '', '', '', '', 0, '3', '12345678', 'کلید واژه ها', '0000-00-00 00:00:00', '2015-01-03 15:54:31', 1, 1, 0, 0, 0, 0, 1, 0, 2, 0, 0, 1, 0, 1, 0, 0, 0, 0, '001031', 0, '2015-01-03T20:30:00.000Z', '08:00', '12:00', '14:00', '22:00', NULL, '1234', NULL, NULL, NULL, '<h2><img alt="" src="http://localhost/n-darkish/web/uploads/image/record-1418676728-44889.jpg" style="width:100px" />salamasd asd asd asdsada</h2>\n\n<p>\n<audio controls="" name="media" width="300"><source src="http://localhost/n-darkish/web/uploads/audio/record-1419744282-19622.mp3" type="audio/mpeg" />​</audio>\n</p>\n', 0, '', NULL, '', NULL, '', NULL, 1),
(4, 'رکورد دو', 'سابتایتل', 'asd asd', 'asd dssad', 6, '4', '122', 5, 1, ' sgsdf sdf sdf', '1234124', 1, '3', '13124', '123412', '234235', 'asd@asd.asd', ' asdasd.asd', 'asdsad asd af asd asfa', '123324.123', '12343.124', NULL, NULL, 1, '6', '245', 'asd sad asd as', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0, 0, 1, 1, 0, 1, 3, 1, 0, 1, 0, 1, 0, 1, 0, 0, '124124', 1, '234324324', '9:30', '13:00', '15:00', '22:23', '3443', NULL, '123', '12343', '324234', '<p>asd sadasdasdaasd asdasdasdsa</p>\n', 1, '', NULL, '', NULL, '', NULL, 1),
(5, 'رکورد سه', 'سابتایال رکورد ', NULL, NULL, NULL, NULL, NULL, 9, 1, 'gdfg dfgdfg dfg', '14234324', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1456', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '342123', 1, '12423423', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '', NULL, '', NULL, '', NULL, 1),
(10, 'یسشی سشی', 'شسی شسی شسی', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '123123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, '', NULL, '', NULL, 1),
(11, '24234', '235235', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1256', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '242342', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, '', NULL, '', NULL, 1),
(15, 'dasd a', 'asd asd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '234123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, '', NULL, '', NULL, 1),
(17, 'شسیش سی', 'شسی شسی سشی', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '132132', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'asdasd', 'asdas dasd', 'asd asd', 'a sd asd', 'asd asd', 'asd asd', 1),
(18, 'امیر', 'شسی شسی شسی', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '123312', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, '', NULL, '', NULL, 1),
(20, 'شیشسی شس', 'شسی شسی سیبسیب', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '234232', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, '', NULL, '', NULL, 1),
(22, 'jadid', 'jadid', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '232344', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, '', NULL, '', NULL, 1),
(23, 'asd asd', 'asdasd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '234324', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, '', NULL, '', NULL, 1),
(24, 'asd asd', 'a sdasd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '124234', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, '', NULL, '', NULL, 1),
(25, 'asdsa d jadid', 'asd asdas d', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '242435', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, '', NULL, '', NULL, 1),
(26, 'asd asdasd', 'asdas d as', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '324242', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, '', NULL, '', NULL, 1),
(28, 'ads asd asda', 'd asd asd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '354352', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, '', NULL, '', NULL, 1),
(29, 'adasd', 'd asd sdfasdasd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '243455', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, '', NULL, '', NULL, 1),
(30, 'asdad a', 'sd asd asdasd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '535345', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, '', NULL, '', NULL, 1),
(32, 'asd adsa', 'sd asd asd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '343242', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, '', NULL, '', NULL, 1),
(33, 'in', 'un', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '543422', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '', NULL, '', NULL, '', NULL, 1),
(34, 'asdsad sa', 'asd sad a', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2014-12-29 11:35:51', '2014-12-29 11:35:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '543430', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(35, 'asdas d asd', 'asd asd asd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2014-12-29 11:36:25', '2014-12-29 11:36:25', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '543431', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(36, 'jadid', 'jadid', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2014-12-29 11:40:55', '2014-12-29 11:40:55', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '543432', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(37, 'asd asd', 'asd asd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2014-12-29 11:42:33', '2014-12-29 11:42:33', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '543433', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(38, 'asd asdasd sad', 'ad asdasdas d', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2014-12-29 11:44:52', '2014-12-29 11:44:52', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '543434', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(39, 'asdasd', 'sda sd asd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2014-12-29 11:46:10', '2014-12-29 11:46:10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '543435', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(40, '12314123', '4asdsadsad sad', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2014-12-29 11:48:18', '2014-12-29 11:48:18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '543436', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(41, 'asdsad a', 'dasd asd s', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2014-12-29 11:48:44', '2014-12-29 11:48:44', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '543437', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(42, 'asd asd', 'asd asd a', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2014-12-29 11:49:19', '2014-12-29 11:49:19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '543438', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(43, 'asdas', 'asd asd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2014-12-29 11:52:44', '2014-12-31 16:47:50', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '543439', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(44, 'این جدید است', 'این زیر عنوان جدید است', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2014-12-29 11:53:19', '2014-12-31 14:42:31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '543440', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(45, 'این جدید تر است', 'شسمیاشسنیتا', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2014-12-29 11:53:42', '2014-12-31 16:48:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '543441', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 3),
(46, 'بسیار جدید', 'خیلی خیلی جدید', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2014-12-31 16:48:25', '2014-12-31 16:53:32', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '543444', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 3),
(47, 'aaaaassss', 'ddddddfffff', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2014-12-31 17:13:54', '2015-01-03 23:29:39', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '543452', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `RecordLock`
--

CREATE TABLE IF NOT EXISTS `RecordLock` (
  `id` int(11) NOT NULL,
  `record_id` int(11) DEFAULT NULL,
  `user` int(11) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `records_audios`
--

CREATE TABLE IF NOT EXISTS `records_audios` (
  `record_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `records_body_audios`
--

CREATE TABLE IF NOT EXISTS `records_body_audios` (
  `record_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `records_body_audios`
--

INSERT INTO `records_body_audios` (`record_id`, `file_id`) VALUES
(1, 172);

-- --------------------------------------------------------

--
-- Table structure for table `records_body_images`
--

CREATE TABLE IF NOT EXISTS `records_body_images` (
  `record_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `records_body_images`
--

INSERT INTO `records_body_images` (`record_id`, `file_id`) VALUES
(1, 140);

-- --------------------------------------------------------

--
-- Table structure for table `records_body_videos`
--

CREATE TABLE IF NOT EXISTS `records_body_videos` (
  `record_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `records_body_videos`
--

INSERT INTO `records_body_videos` (`record_id`, `file_id`) VALUES
(1, 159);

-- --------------------------------------------------------

--
-- Table structure for table `records_images`
--

CREATE TABLE IF NOT EXISTS `records_images` (
  `record_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `records_images`
--

INSERT INTO `records_images` (`record_id`, `file_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 9),
(26, 85),
(33, 86),
(1, 93),
(17, 145),
(1, 146),
(1, 147),
(1, 148),
(47, 188),
(47, 189);

-- --------------------------------------------------------

--
-- Table structure for table `records_maintrees`
--

CREATE TABLE IF NOT EXISTS `records_maintrees` (
  `record_id` int(11) NOT NULL,
  `maintree_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `records_videos`
--

CREATE TABLE IF NOT EXISTS `records_videos` (
  `record_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `records_videos`
--

INSERT INTO `records_videos` (`record_id`, `file_id`) VALUES
(1, 159),
(1, 170);

-- --------------------------------------------------------

--
-- Table structure for table `record_lock`
--

CREATE TABLE IF NOT EXISTS `record_lock` (
  `id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `record_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `expire` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `safarsaztype`
--

CREATE TABLE IF NOT EXISTS `safarsaztype` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `safarsaztype`
--

INSERT INTO `safarsaztype` (`id`, `name`) VALUES
(1, 'دريايي'),
(2, 'گردشگري'),
(3, 'جنگ شبانه'),
(4, 'رستوران'),
(5, 'تور ورزشي');

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
-- Indexes for table `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `center`
--
ALTER TABLE `center`
  ADD PRIMARY KEY (`id`), ADD KEY `IDX_475CEE1280FEB2FF` (`center_type_id`);

--
-- Indexes for table `centertype`
--
ALTER TABLE `centertype`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `fos_user`
--
ALTER TABLE `fos_user`
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
-- Indexes for table `itinerarytype`
--
ALTER TABLE `itinerarytype`
  ADD PRIMARY KEY (`id`);

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
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `UNIQ_9C989AA7F4CC592A` (`record_number`), ADD KEY `IDX_9B349F91B7ACB4FA` (`CenterIndex`), ADD KEY `IDX_9B349F9160701891` (`safarsazTypeIndex`), ADD KEY `IDX_9B349F91AB98DE82` (`DbaseTypeIndex`), ADD KEY `IDX_9B349F915C2395A2` (`AreaIndex`);

--
-- Indexes for table `RecordLock`
--
ALTER TABLE `RecordLock`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `UNIQ_47A4F7D74DFD750C` (`record_id`);

--
-- Indexes for table `records_audios`
--
ALTER TABLE `records_audios`
  ADD PRIMARY KEY (`record_id`,`file_id`), ADD UNIQUE KEY `UNIQ_7B46451193CB796C` (`file_id`), ADD KEY `IDX_7B4645114DFD750C` (`record_id`);

--
-- Indexes for table `records_body_audios`
--
ALTER TABLE `records_body_audios`
  ADD PRIMARY KEY (`record_id`,`file_id`), ADD UNIQUE KEY `UNIQ_5505580C93CB796C` (`file_id`), ADD KEY `IDX_5505580C4DFD750C` (`record_id`);

--
-- Indexes for table `records_body_images`
--
ALTER TABLE `records_body_images`
  ADD PRIMARY KEY (`record_id`,`file_id`), ADD UNIQUE KEY `UNIQ_2E69339093CB796C` (`file_id`), ADD KEY `IDX_2E6933904DFD750C` (`record_id`);

--
-- Indexes for table `records_body_videos`
--
ALTER TABLE `records_body_videos`
  ADD PRIMARY KEY (`record_id`,`file_id`), ADD UNIQUE KEY `UNIQ_E7DCE9C893CB796C` (`file_id`), ADD KEY `IDX_E7DCE9C84DFD750C` (`record_id`);

--
-- Indexes for table `records_images`
--
ALTER TABLE `records_images`
  ADD PRIMARY KEY (`record_id`,`file_id`), ADD UNIQUE KEY `UNIQ_2A2E8D93CB796C` (`file_id`), ADD KEY `IDX_2A2E8D4DFD750C` (`record_id`);

--
-- Indexes for table `records_maintrees`
--
ALTER TABLE `records_maintrees`
  ADD PRIMARY KEY (`record_id`,`maintree_id`), ADD KEY `IDX_A215A52F4DFD750C` (`record_id`), ADD KEY `IDX_A215A52F61A43B37` (`maintree_id`);

--
-- Indexes for table `records_videos`
--
ALTER TABLE `records_videos`
  ADD PRIMARY KEY (`record_id`,`file_id`), ADD UNIQUE KEY `UNIQ_C99FF4D593CB796C` (`file_id`), ADD KEY `IDX_C99FF4D54DFD750C` (`record_id`);

--
-- Indexes for table `record_lock`
--
ALTER TABLE `record_lock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `safarsaztype`
--
ALTER TABLE `safarsaztype`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `area`
--
ALTER TABLE `area`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `center`
--
ALTER TABLE `center`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `centertype`
--
ALTER TABLE `centertype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=201;
--
-- AUTO_INCREMENT for table `fos_user`
--
ALTER TABLE `fos_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fos_user_group`
--
ALTER TABLE `fos_user_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fos_user_user`
--
ALTER TABLE `fos_user_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `itinerarytype`
--
ALTER TABLE `itinerarytype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `maintree`
--
ALTER TABLE `maintree`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=235;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=48;
--
-- AUTO_INCREMENT for table `RecordLock`
--
ALTER TABLE `RecordLock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `record_lock`
--
ALTER TABLE `record_lock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `safarsaztype`
--
ALTER TABLE `safarsaztype`
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
-- Constraints for table `center`
--
ALTER TABLE `center`
ADD CONSTRAINT `FK_475CEE1280FEB2FF` FOREIGN KEY (`center_type_id`) REFERENCES `centertype` (`id`);

--
-- Constraints for table `fos_user_user_group`
--
ALTER TABLE `fos_user_user_group`
ADD CONSTRAINT `FK_B3C77447A76ED395` FOREIGN KEY (`user_id`) REFERENCES `fos_user_user` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `FK_B3C77447FE54D947` FOREIGN KEY (`group_id`) REFERENCES `fos_user_group` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `record`
--
ALTER TABLE `record`
ADD CONSTRAINT `FK_9B349F915C2395A2` FOREIGN KEY (`AreaIndex`) REFERENCES `area` (`id`),
ADD CONSTRAINT `FK_9B349F9160701891` FOREIGN KEY (`safarsazTypeIndex`) REFERENCES `safarsaztype` (`id`),
ADD CONSTRAINT `FK_9B349F91AB98DE82` FOREIGN KEY (`DbaseTypeIndex`) REFERENCES `dbasetype` (`id`),
ADD CONSTRAINT `FK_9B349F91B7ACB4FA` FOREIGN KEY (`CenterIndex`) REFERENCES `center` (`id`);

--
-- Constraints for table `RecordLock`
--
ALTER TABLE `RecordLock`
ADD CONSTRAINT `FK_47A4F7D74DFD750C` FOREIGN KEY (`record_id`) REFERENCES `record` (`id`);

--
-- Constraints for table `records_audios`
--
ALTER TABLE `records_audios`
ADD CONSTRAINT `FK_7B4645114DFD750C` FOREIGN KEY (`record_id`) REFERENCES `record` (`id`),
ADD CONSTRAINT `FK_7B46451193CB796C` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`);

--
-- Constraints for table `records_body_audios`
--
ALTER TABLE `records_body_audios`
ADD CONSTRAINT `FK_5505580C4DFD750C` FOREIGN KEY (`record_id`) REFERENCES `record` (`id`),
ADD CONSTRAINT `FK_5505580C93CB796C` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`);

--
-- Constraints for table `records_body_images`
--
ALTER TABLE `records_body_images`
ADD CONSTRAINT `FK_2E6933904DFD750C` FOREIGN KEY (`record_id`) REFERENCES `record` (`id`),
ADD CONSTRAINT `FK_2E69339093CB796C` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`);

--
-- Constraints for table `records_body_videos`
--
ALTER TABLE `records_body_videos`
ADD CONSTRAINT `FK_E7DCE9C84DFD750C` FOREIGN KEY (`record_id`) REFERENCES `record` (`id`),
ADD CONSTRAINT `FK_E7DCE9C893CB796C` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`);

--
-- Constraints for table `records_images`
--
ALTER TABLE `records_images`
ADD CONSTRAINT `FK_2A2E8D4DFD750C` FOREIGN KEY (`record_id`) REFERENCES `record` (`id`),
ADD CONSTRAINT `FK_2A2E8D93CB796C` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`);

--
-- Constraints for table `records_maintrees`
--
ALTER TABLE `records_maintrees`
ADD CONSTRAINT `FK_A215A52F4DFD750C` FOREIGN KEY (`record_id`) REFERENCES `record` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `FK_A215A52F61A43B37` FOREIGN KEY (`maintree_id`) REFERENCES `maintree` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `records_videos`
--
ALTER TABLE `records_videos`
ADD CONSTRAINT `FK_C99FF4D54DFD750C` FOREIGN KEY (`record_id`) REFERENCES `record` (`id`),
ADD CONSTRAINT `FK_C99FF4D593CB796C` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
