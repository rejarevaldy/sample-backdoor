-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 28, 2016 at 08:33 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;



-- --------------------------------------------------------

--
-- Table structure for table `botcommands`
--

CREATE TABLE IF NOT EXISTS `botcommands` (
  `botId` int(11) NOT NULL,
  `commandId` int(11) NOT NULL,
  `result` mediumtext,
  PRIMARY KEY (`botId`,`commandId`),
  KEY `botcommands_ibfk_2` (`commandId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bots`
--

CREATE TABLE IF NOT EXISTS `bots` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hwid` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL COMMENT 'TODO: use country list.',
  `country_code` varchar(2) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `os` varchar(100) NOT NULL,
  `cpu` varchar(100) NOT NULL,
  `gpu` varchar(50) NOT NULL,
  `net` varchar(255) NOT NULL,
  `admin` varchar(6) NOT NULL,
  `ram` varchar(10) NOT NULL,
  `lastseen` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `botid` (`hwid`),
  KEY `country` (`country`),
  KEY `country_code` (`country_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=57 ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `bots_offline_v`
--
CREATE TABLE IF NOT EXISTS `bots_offline_v` (
`id` int(11)
,`hwid` varchar(50)
,`botstatus` int(1)
,`country` varchar(50)
,`country_code` varchar(2)
,`ip` varchar(50)
,`os` varchar(100)
,`cpu` varchar(100)
,`gpu` varchar(50)
,`net` varchar(255)
,`admin` varchar(6)
,`ram` varchar(10)
,`lastseen` datetime
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `bots_online_offline_v`
--
CREATE TABLE IF NOT EXISTS `bots_online_offline_v` (
`id` int(11)
,`hwid` varchar(50)
,`botstatus` int(11)
,`country` varchar(50)
,`country_code` varchar(2)
,`ip` varchar(50)
,`os` varchar(100)
,`cpu` varchar(100)
,`gpu` varchar(50)
,`net` varchar(255)
,`admin` varchar(6)
,`ram` varchar(10)
,`lastseen` datetime
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `bots_online_v`
--
CREATE TABLE IF NOT EXISTS `bots_online_v` (
`id` int(11)
,`hwid` varchar(50)
,`botstatus` int(1)
,`country` varchar(50)
,`country_code` varchar(2)
,`ip` varchar(50)
,`os` varchar(100)
,`cpu` varchar(100)
,`gpu` varchar(50)
,`net` varchar(255)
,`admin` varchar(6)
,`ram` varchar(10)
,`lastseen` datetime
);
-- --------------------------------------------------------

--
-- Table structure for table `commands`
--

CREATE TABLE IF NOT EXISTS `commands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `commandtype` int(11) NOT NULL,
  `commandString` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `commandtype` (`commandtype`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=131 ;

-- --------------------------------------------------------

--
-- Table structure for table `commandtypes`
--

CREATE TABLE IF NOT EXISTS `commandtypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `commandtypes`
--

INSERT INTO `commandtypes` (`id`, `type`) VALUES
(0, 'Join'),
(1, 'Poll'),
(2, 'Site Status'),
(3, 'Shutdown'),
(4, 'Restart'),
(5, 'Message Box'),
(6, 'Keylog'),
(7, 'Remote Process'),
(8, 'Download & Execute'),
(9, ' Remote Process No Result'),
(10, 'TCP Flood'),
(11, 'Self Update'),
(12, 'Screenshot');

-- --------------------------------------------------------

--
-- Table structure for table `country_names`
--

CREATE TABLE IF NOT EXISTS `country_names` (
  `country_code` varchar(2) NOT NULL,
  `country_name` varchar(50) NOT NULL,
  PRIMARY KEY (`country_code`),
  KEY `country_name_2` (`country_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `ip_country`
--

CREATE TABLE IF NOT EXISTS `ip_country` (
  `ip_start` varchar(15) NOT NULL,
  `ip_end` varchar(15) NOT NULL,
  `ip_start_long` int(11) NOT NULL,
  `ip_end_long` int(11) NOT NULL,
  `country_code` varchar(2) NOT NULL,
  KEY `ip_country_ibfk_1` (`country_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(150) NOT NULL,
  `auth_token` varchar(255) NOT NULL,
  `cap` varchar(10) NOT NULL,
  `ip` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `auth_token`, `cap`, `ip`) VALUES
(1, 'root', '$2y$10$TtWNoqzxkVVOL1541OJQ4uLC3vBJgb1PowmHC0OrZkRlkiX8WpiKG', 'deae574ed7e0ad546b01f4afe7cbb8885f31343536373331313138', '', '');

-- --------------------------------------------------------

--
-- Structure for view `bots_offline_v`
--
DROP TABLE IF EXISTS `bots_offline_v`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `bots_offline_v` AS (select `bots`.`id` AS `id`,`bots`.`hwid` AS `hwid`,0 AS `botstatus`,`bots`.`country` AS `country`,`bots`.`country_code` AS `country_code`,`bots`.`ip` AS `ip`,`bots`.`os` AS `os`,`bots`.`cpu` AS `cpu`,`bots`.`gpu` AS `gpu`,`bots`.`net` AS `net`,`bots`.`admin` AS `admin`,`bots`.`ram` AS `ram`,`bots`.`lastseen` AS `lastseen` from `bots` where (`bots`.`lastseen` <= (now() - interval 1 minute)));

-- --------------------------------------------------------

--
-- Structure for view `bots_online_offline_v`
--
DROP TABLE IF EXISTS `bots_online_offline_v`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `bots_online_offline_v` AS select `bots_online_v`.`id` AS `id`,`bots_online_v`.`hwid` AS `hwid`,`bots_online_v`.`botstatus` AS `botstatus`,`bots_online_v`.`country` AS `country`,`bots_online_v`.`country_code` AS `country_code`,`bots_online_v`.`ip` AS `ip`,`bots_online_v`.`os` AS `os`,`bots_online_v`.`cpu` AS `cpu`,`bots_online_v`.`gpu` AS `gpu`,`bots_online_v`.`net` AS `net`,`bots_online_v`.`admin` AS `admin`,`bots_online_v`.`ram` AS `ram`,`bots_online_v`.`lastseen` AS `lastseen` from `bots_online_v` union select `bots_offline_v`.`id` AS `id`,`bots_offline_v`.`hwid` AS `hwid`,`bots_offline_v`.`botstatus` AS `botstatus`,`bots_offline_v`.`country` AS `country`,`bots_offline_v`.`country_code` AS `country_code`,`bots_offline_v`.`ip` AS `ip`,`bots_offline_v`.`os` AS `os`,`bots_offline_v`.`cpu` AS `cpu`,`bots_offline_v`.`gpu` AS `gpu`,`bots_offline_v`.`net` AS `net`,`bots_offline_v`.`admin` AS `admin`,`bots_offline_v`.`ram` AS `ram`,`bots_offline_v`.`lastseen` AS `lastseen` from `bots_offline_v`;

-- --------------------------------------------------------

--
-- Structure for view `bots_online_v`
--
DROP TABLE IF EXISTS `bots_online_v`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `bots_online_v` AS (select `bots`.`id` AS `id`,`bots`.`hwid` AS `hwid`,1 AS `botstatus`,`bots`.`country` AS `country`,`bots`.`country_code` AS `country_code`,`bots`.`ip` AS `ip`,`bots`.`os` AS `os`,`bots`.`cpu` AS `cpu`,`bots`.`gpu` AS `gpu`,`bots`.`net` AS `net`,`bots`.`admin` AS `admin`,`bots`.`ram` AS `ram`,`bots`.`lastseen` AS `lastseen` from `bots` where (`bots`.`lastseen` > (now() - interval 1 minute)));

--
-- Constraints for dumped tables
--

--
-- Constraints for table `botcommands`
--
ALTER TABLE `botcommands`
  ADD CONSTRAINT `botcommands_ibfk_1` FOREIGN KEY (`botId`) REFERENCES `bots` (`id`),
  ADD CONSTRAINT `botcommands_ibfk_2` FOREIGN KEY (`commandId`) REFERENCES `commands` (`id`);

--
-- Constraints for table `commands`
--
ALTER TABLE `commands`
  ADD CONSTRAINT `commands_ibfk_1` FOREIGN KEY (`commandtype`) REFERENCES `commandtypes` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `ip_country`
--
ALTER TABLE `ip_country`
  ADD CONSTRAINT `ip_country_ibfk_1` FOREIGN KEY (`country_code`) REFERENCES `country_names` (`country_code`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
