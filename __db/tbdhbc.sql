-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 18, 2013 at 03:29 PM
-- Server version: 5.6.14
-- PHP Version: 5.3.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tbdhbc`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbgames`
--

CREATE TABLE IF NOT EXISTS `tbgames` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tbcreate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tbdeleted` tinyint(4) NOT NULL,
  `tbdatefrom` int(11) NOT NULL,
  `tbactive` tinyint(4) NOT NULL,
  `tbdateto` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbpic`
--

CREATE TABLE IF NOT EXISTS `tbpic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tbcreate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tbdeleted` tinyint(11) NOT NULL,
  `tbpic` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `tbresult` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `tbresultvn` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `tborder` int(11) NOT NULL,
  `tbtime` int(11) NOT NULL,
  `tbcountword` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbuser`
--

CREATE TABLE IF NOT EXISTS `tbuser` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tbfacebook_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `tbname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `tbmobile` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `tbemail` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `tbstatus` int(11) NOT NULL,
  `tbcreate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbvoucher`
--

CREATE TABLE IF NOT EXISTS `tbvoucher` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tbgames_id` int(11) NOT NULL,
  `tbvoucher` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `tbdatetake` int(11) NOT NULL,
  `tbdateuse` int(11) NOT NULL,
  `tbcreate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tbdeleted` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tplay`
--

CREATE TABLE IF NOT EXISTS `tplay` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tbgames_id` int(11) NOT NULL,
  `tbface_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `tbtimecorrect` int(11) NOT NULL,
  `tbpass` tinyint(4) NOT NULL,
  `tbcreate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tbdeleted` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
