-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 06, 2020 at 10:30 PM
-- Server version: 5.7.26
-- PHP Version: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `data`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `about` varchar(100) DEFAULT NULL,
  `date` varchar(100) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `latitude` varchar(100) NOT NULL,
  `longitude` varchar(100) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`ID`, `title`, `about`, `date`, `address`, `latitude`, `longitude`) VALUES
(4, 'Mexico Trip', '', '', '', '', ''),
(5, 'Ice Hockey', 'PLAYIN HOCKEY WITH THE BOYS', '2020-01-18T20:00', 'Newark, DE', '39.683723', '-75.749657'),
(2, 'Basketball', 'Ballin', '2020-01-23T12:00', 'Newark, NJ', '40.735657', '-74.172363'),
(3, 'Mexico Trip', '', '', '', '', ''),
(6, '', '', '', '1511 US-1, Edison, NJ 08837', '', ''),
(7, 'd', '', '', 'Tim Hortons, 55 York St, Toronto, ON M5J 1R7, Canada', '', ''),
(8, '', 'rtertert', '', '', '', ''),
(9, 'd', '', '', '', '', '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
