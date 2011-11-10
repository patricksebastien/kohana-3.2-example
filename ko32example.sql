-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 02, 2011 at 04:05 PM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ko32example`
--

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`) VALUES
(1, 'login', 'Login privileges, granted after account confirmation'),
(2, 'admin', 'Administrative user, has access to everything.'),
(3, 'participant', 'Participants');

-- --------------------------------------------------------

--
-- Table structure for table `roles_users`
--

CREATE TABLE IF NOT EXISTS `roles_users` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `fk_role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles_users`
--

INSERT INTO `roles_users` (`user_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(6, 1),
(7, 1),
(8, 1),
(6, 3),
(7, 3),
(8, 3);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `session_id` varchar(24) NOT NULL,
  `last_active` int(10) unsigned NOT NULL,
  `contents` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_active` (`last_active`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`session_id`, `last_active`, `contents`) VALUES
('4eb071e18ce518-03119450', 1320186356, 'zbF3UkHYXJlSokP4KNgT9s4zVewL74uPUbLlCJbP56F0UZRbPqnyUYNTPIwxGXhjIZ3CpGSOvcA14nm8ho/5zaeXr1YvJ3bukMiOedUa2pw='),
('4eb1560dd5d987-93057814', 1320245020, '4jZLvV+cvVngrlrTEbOHNRpCdF9+lTXTKrC6qqQWAK+Li3YAqu9e3XmAsCAYSUrO/zVZJpA3YEVsUclSatIhvUo5fAKHB78OtslBNqkb7une3Zjq/J/vTt4isANO8g=='),
('4eb1614e564524-11999928', 1320249907, '0grUO6whHN670zzSqGqeHqUUhfszvsxxHeV6RRD58iHQdJQeTjTnZo7FvRFB9qnTQkMQ6njmjJmQKX3uijX7xESWskFsg76A2aduF1EtjIQ=');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(254) NOT NULL,
  `username` varchar(32) NOT NULL DEFAULT '',
  `password` varchar(64) NOT NULL,
  `logins` int(10) unsigned NOT NULL DEFAULT '0',
  `last_login` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_username` (`username`),
  UNIQUE KEY `uniq_email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password`, `logins`, `last_login`) VALUES
(1, '11h11@11h11.com', 'patrick', 'f695cb71cbe7ae41655b0c0a13e9c69800e2dd9a523e0d8e89f27849fd540d67', 2, 1320186305),
(2, 'oooooo@11h11.com', 'ooooooo', '454bb903b6f4fb9fba1a211f63bf2c4886411a7235e8a337ac09191b6ce8cfe3', 0, NULL),
(3, 'ppppppppp@11h11.com', 'ppppppp', '8d1e5217c307fbc6b55608d139c64581060ed44753ef4915a34877d8a7e926e5', 0, NULL),
(4, 'lfdsfsdf@11h11.com', 'opopopo', 'f695cb71cbe7ae41655b0c0a13e9c69800e2dd9a523e0d8e89f27849fd540d67', 0, NULL),
(5, 'lplpl@11h11.com', 'ppppppo', 'ee17f04a5d6ee85d5051dc2b726c5f947cb7d96aa5a67ce2732689fe7f1b6a2d', 0, NULL),
(6, 'fsdfdsfds@11h11.com', 'dsjfdsifjdsi', 'fadeabb4eca46e85eecb1fd4667e0587d8bc1209cd1552a69d180119fac24c9d', 1, 1320186290),
(7, 'patrick@11h11.com', 'patrickc', 'f695cb71cbe7ae41655b0c0a13e9c69800e2dd9a523e0d8e89f27849fd540d67', 2, 1320186335),
(8, 'patrickco@11h11.com', 'paco', '6ea38bfb3b2640e11fd225c181202abc778b0cb06491c0ae9fa503881cb40fce', 1, 1320247613);

-- --------------------------------------------------------

--
-- Table structure for table `user_tokens`
--

CREATE TABLE IF NOT EXISTS `user_tokens` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `user_agent` varchar(40) NOT NULL,
  `token` varchar(40) NOT NULL,
  `type` varchar(100) NOT NULL,
  `created` int(10) unsigned NOT NULL,
  `expires` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_token` (`token`),
  KEY `fk_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `roles_users`
--
ALTER TABLE `roles_users`
  ADD CONSTRAINT `roles_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `roles_users_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_tokens`
--
ALTER TABLE `user_tokens`
  ADD CONSTRAINT `user_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
