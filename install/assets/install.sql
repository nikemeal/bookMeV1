-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Generation Time: Jun 28, 2012 at 02:41 PM
-- Server version: 5.5.20
-- PHP Version: 5.3.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bookme`
--

-- --------------------------------------------------------

--
-- Table structure for table `block_bookings`
--

CREATE TABLE IF NOT EXISTS `block_bookings` (
  `block_booking_id` int(11) NOT NULL AUTO_INCREMENT,
  `subject_id` int(11) NOT NULL,
  `booking_classname` varchar(255) NOT NULL,
  `year_id` int(11) NOT NULL,
  PRIMARY KEY (`block_booking_id`),
  KEY `subjectid` (`subject_id`),
  KEY `yearid` (`year_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE IF NOT EXISTS `bookings` (
  `booking_id` int(11) NOT NULL AUTO_INCREMENT,
  `subject_id` int(11) NOT NULL,
  `period_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `booking_username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `booking_displayname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `booking_classname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `booking_isblock` tinyint(1) NOT NULL,
  `block_booking_id` int(11) DEFAULT NULL,
  `booking_date` date NOT NULL,
  PRIMARY KEY (`booking_id`),
  KEY `subjectid` (`subject_id`),
  KEY `periodid` (`period_id`),
  KEY `roomid` (`room_id`),
  KEY `blockbookingid` (`block_booking_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--

CREATE TABLE IF NOT EXISTS `holidays` (
  `holiday_id` int(11) NOT NULL AUTO_INCREMENT,
  `holiday_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `holiday_start` date NOT NULL,
  `holiday_end` date NOT NULL,
  PRIMARY KEY (`holiday_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `periods`
--

CREATE TABLE IF NOT EXISTS `periods` (
  `period_id` int(11) NOT NULL AUTO_INCREMENT,
  `period_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `period_start` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `period_end` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `period_bookable` tinyint(1) NOT NULL,
  PRIMARY KEY (`period_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE IF NOT EXISTS `rooms` (
  `room_id` int(11) NOT NULL AUTO_INCREMENT,
  `room_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `room_pc_count` int(11) DEFAULT NULL COMMENT 'Can be left null if needed',
  `room_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `room_image_tn` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`room_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `setting_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `setting_value` varchar(1000) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`setting_name`, `setting_value`) VALUES
('school_name', 'Default School'),
('allow_local_login', '1'),
('ldap_servers', 'default-dc'),
('ldap_account_suffix', '@default.internal'),
('ldap_basedn', 'DC=default,DC=internal'),
('ldap_username', 'administrator'),
('ldap_password', 'v9WNIj7mvEVxs3/XH2QHg2VMTR8GBxmln0o4PnvbP2mQ+hFnKpMns+12sLiBLVULDlPSYvxbS4V2dAlzruAv4g=='),
('ldap_standard_users', ''),
('ldap_admin_users', ''),
('bg_colour', '699A83'),
('user_book_in_advance', '-1'),
('bookme_version', '1.1.5');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE IF NOT EXISTS `subjects` (
  `subject_id` int(11) NOT NULL AUTO_INCREMENT,
  `subject_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `subject_colour` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `subject_use_shading` tinyint(1) NOT NULL,
  PRIMARY KEY (`subject_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `years`
--

CREATE TABLE IF NOT EXISTS `years` (
  `year_id` int(11) NOT NULL AUTO_INCREMENT,
  `year_name` varchar(255) NOT NULL,
  `year_start` date NOT NULL,
  `year_end` date NOT NULL,
  `year_isactive` tinyint(1) NOT NULL,
  PRIMARY KEY (`year_id`),
  KEY `yearid` (`year_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `block_bookings`
--
ALTER TABLE `block_bookings`
  ADD CONSTRAINT `block_bookings_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`subject_id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `block_bookings_ibfk_2` FOREIGN KEY (`year_id`) REFERENCES `years` (`year_id`) ON UPDATE NO ACTION;

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`subject_id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `bookings_ibfk_3` FOREIGN KEY (`period_id`) REFERENCES `periods` (`period_id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `bookings_ibfk_5` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `bookings_ibfk_6` FOREIGN KEY (`block_booking_id`) REFERENCES `block_bookings` (`block_booking_id`) ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
