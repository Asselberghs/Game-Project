-- phpMyAdmin SQL Dump
-- version 2.11.11.3
-- http://www.phpmyadmin.net
--
-- Host: 188.121.44.159
-- Generation Time: Apr 26, 2016 at 02:05 AM
-- Server version: 5.5.43
-- PHP Version: 5.1.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `AsselberghsMedia`
--

-- --------------------------------------------------------

--
-- Table structure for table `Book`
--

CREATE TABLE `Book` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Title` text NOT NULL,
  `Author` text NOT NULL,
  `Genre` varchar(20) NOT NULL,
  `Series` text NOT NULL,
  `Copyright` int(11) NOT NULL,
  `Publisher` text NOT NULL,
  `ISBN` varchar(20) NOT NULL,
  `Price` int(11) NOT NULL,
  `Format` varchar(60) NOT NULL,
  `Lend` varchar(11) NOT NULL,
  `Loaner` varchar(20) NOT NULL,
  `User` varchar(20) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=214 ;


-- --------------------------------------------------------

--
-- Table structure for table `Game`
--

CREATE TABLE `Game` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Title` text CHARACTER SET latin1 COLLATE latin1_danish_ci NOT NULL,
  `Platform` varchar(60) CHARACTER SET latin1 COLLATE latin1_danish_ci NOT NULL,
  `Genre` varchar(20) CHARACTER SET latin1 COLLATE latin1_danish_ci NOT NULL,
  `Developer` varchar(30) CHARACTER SET latin1 COLLATE latin1_danish_ci NOT NULL,
  `Lend` varchar(11) CHARACTER SET latin1 COLLATE latin1_danish_ci NOT NULL,
  `Loaner` varchar(20) CHARACTER SET latin1 COLLATE latin1_danish_ci NOT NULL,
  `Price` int(11) NOT NULL,
  `User` varchar(20) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=81 ;

-- --------------------------------------------------------

--
-- Table structure for table `Movie`
--

CREATE TABLE `Movie` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Title` text CHARACTER SET latin1 COLLATE latin1_danish_ci NOT NULL,
  `Format` varchar(60) CHARACTER SET latin1 COLLATE latin1_danish_ci NOT NULL,
  `Production_Year` int(11) NOT NULL,
  `Actor` text CHARACTER SET latin1 COLLATE latin1_danish_ci NOT NULL,
  `Director` text CHARACTER SET latin1 COLLATE latin1_danish_ci NOT NULL,
  `Lend` varchar(11) CHARACTER SET latin1 COLLATE latin1_danish_ci NOT NULL,
  `Loaner` varchar(20) CHARACTER SET latin1 COLLATE latin1_danish_ci NOT NULL,
  `Genre` varchar(20) CHARACTER SET latin1 COLLATE latin1_danish_ci NOT NULL,
  `Price` int(11) NOT NULL,
  `User` varchar(20) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=273 ;


-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `User` varchar(20) NOT NULL,
  `Password` text NOT NULL,
  `SALT` text NOT NULL,
  `logged_out_at` datetime NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Yubikey` varchar(12) NOT NULL,
  `Yubikey_Used` varchar(5) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;