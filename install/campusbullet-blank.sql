-- phpMyAdmin SQL Dump
-- version 3.3.2deb1ubuntu1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 16, 2012 at 11:32 AM
-- Server version: 5.1.61
-- PHP Version: 5.3.2-1ubuntu4.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `campusbullet-blank`
--

-- --------------------------------------------------------

--
-- Table structure for table `banned_addresses`
--

CREATE TABLE IF NOT EXISTS `banned_addresses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(16) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `banned_addresses`
--


-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `prettyname` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `disabled` int(11) NOT NULL DEFAULT '0',
  `sort_order` int(11) NOT NULL DEFAULT '50',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `sort_order` (`sort_order`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `prettyname`, `description`, `disabled`, `sort_order`) VALUES
(1, 'stuff', 'General stuff', 'Just...stuff.  Whatever doesn''t fit in any other category, I guess.', 0, 7),
(2, 'books', 'Textbooks ', 'Put your used textbooks and workbooks in here.', 0, 1),
(3, 'shelves', 'Shelves and Furniture', 'Not sure how much you''ll be able to sell with the new limitations on shelves..', 0, 3),
(4, 'videogames', 'Video Games', 'Xbox 360, PS3, Wii, N64, PS2, etc...', 0, 2),
(5, 'vehicles', 'Bikes and Vehicles', 'Bikes, scooters, cars, custom bikes, and skateboards.', 0, 4),
(6, 'electronics', 'Electronics', 'TVs, stereos, DVD players, stuff like that.', 0, 5),
(7, 'appliances', 'Household Appliances', 'Kitchen appliances and stuff around the house that uses power (like lights, vacuum cleaners, etc)', 0, 6),
(8, 'disabled', 'Disabled category', 'This category is for disabled posts, I guess.  If they''re disabled it won''t matter anyway..', 1, 50),
(9, 'rideshare', 'Ride Sharing', 'If you''re driving somewhere and would like to carry some extra passengers, create a post here!', 0, 9),
(10, 'wanted', 'Wanted', 'Put things you want in here (textbooks, TVs, rides, etc).  Put things you want to sell in some other category.', 1, 10),
(11, 'housing', 'Housing', 'Have a house or apartment and want to share it with someone?&nbsp; Make a post here!', 0, 8);

-- --------------------------------------------------------

--
-- Table structure for table `login_failures`
--

CREATE TABLE IF NOT EXISTS `login_failures` (
  `ip` varchar(15) NOT NULL,
  `failures` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login_failures`
--


-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  `log_type` enum('user_disabled') NOT NULL,
  `regarding_user` varchar(255) DEFAULT NULL,
  `key` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `moderator_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `logs`
--


-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender` int(11) NOT NULL,
  `recipient` int(11) NOT NULL,
  `message` text NOT NULL,
  `status` enum('new','read','deleted') NOT NULL DEFAULT 'new',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=134 ;

--
-- Dumping data for table `messages`
--


-- --------------------------------------------------------

--
-- Table structure for table `message_log`
--

CREATE TABLE IF NOT EXISTS `message_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender` int(11) NOT NULL,
  `recipient` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `count` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=365 ;

--
-- Dumping data for table `message_log`
--


-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `condition` varchar(255) NOT NULL,
  `category` int(11) NOT NULL,
  `disabled` int(11) NOT NULL DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isbn` varchar(13) DEFAULT NULL,
  `image` int(11) NOT NULL DEFAULT '0',
  `wanted` int(11) NOT NULL DEFAULT '0',
  `warningsent` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=875 ;

--
-- Dumping data for table `posts`
--


-- --------------------------------------------------------

--
-- Table structure for table `registration_keys`
--

CREATE TABLE IF NOT EXISTS `registration_keys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `key` varchar(255) NOT NULL,
  `ipaddress` varchar(16) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=412 ;

--
-- Dumping data for table `registration_keys`
--


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `userhash` varchar(50) NOT NULL,
  `role` enum('admin','mod','user','system') NOT NULL DEFAULT 'user',
  `email` varchar(50) NOT NULL,
  `originalemail` varchar(255) DEFAULT NULL,
  `disabled` int(1) NOT NULL DEFAULT '0',
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_ip` varchar(15) DEFAULT NULL,
  `whatsnew` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=400 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `userhash`, `role`, `email`, `originalemail`, `disabled`, `create_date`, `last_login`, `last_ip`, `whatsnew`) VALUES
(1, 'campusbullet', '8df547e8861d65696a7bbf0eb0298fb96ca8eeee4317d12770', 'admin', 'admin@campusbullet.net', 'admin@campusbullet.net', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0),
(3, 'ml_abuse', '', 'system', 'help-abuse@campusbullet.net', 'help-abuse@campusbullet.net', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0),
(4, 'ml_bug_report', '', 'system', 'bugs@campusbullet.net', 'bugs@campusbullet.net', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `verification_keys`
--

CREATE TABLE IF NOT EXISTS `verification_keys` (
  `id` int(11) NOT NULL,
  `key` varchar(40) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `verification_keys`
--

