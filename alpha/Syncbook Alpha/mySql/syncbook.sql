-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Lug 25, 2014 alle 16:36
-- Versione del server: 5.5.34
-- PHP Version: 5.5.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `syncbook`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `contacts`
--

CREATE TABLE `contacts` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `contactColor` varchar(7) DEFAULT NULL,
  `contactGroup` varchar(32) DEFAULT NULL,
  `contactType` varchar(32) NOT NULL,
  `contactImage` varchar(512) DEFAULT NULL,
  `contactSurname` varchar(32) NOT NULL,
  `contactUsername` varchar(32) DEFAULT NULL,
  `contactName` varchar(32) NOT NULL,
  `contactEMail` varchar(128) DEFAULT NULL,
  `contactPhoneNumber` varchar(32) DEFAULT NULL,
  `contactMobileNumber` varchar(32) DEFAULT NULL,
  `contactFax` varchar(32) DEFAULT NULL,
  `contactAddress` varchar(128) DEFAULT NULL,
  `contactWeb` varchar(64) DEFAULT NULL,
  `contactPartitaIva` varchar(32) DEFAULT NULL,
  `contactCodiceFiscale` varchar(16) DEFAULT NULL,
  `contactFacebook` varchar(512) DEFAULT NULL,
  `contactTwitter` varchar(512) DEFAULT NULL,
  `contactInstagram` varchar(512) DEFAULT NULL,
  `contactGoogle` varchar(512) DEFAULT NULL,
  `contactLinkedin` varchar(512) DEFAULT NULL,
  `contactSkype` varchar(512) DEFAULT NULL,
  `UUID` varchar(128) NOT NULL,
  PRIMARY KEY (`ID`) COMMENT 'ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `events`
--

CREATE TABLE `events` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `eventDate` varchar(128) DEFAULT NULL,
  `eventName` varchar(32) NOT NULL,
  `eventStart` varchar(128) NOT NULL,
  `eventEnd` varchar(128) NOT NULL,
  `eventDescription` varchar(1024) DEFAULT NULL,
  `eventLocation` varchar(128) DEFAULT NULL,
  `eventUrl` varchar(128) DEFAULT NULL,
  `eventType` varchar(32) DEFAULT NULL,
  `UUID` varchar(128) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `syncoptions`
--

CREATE TABLE `syncoptions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `synctype` varchar(8) CHARACTER SET utf8 NOT NULL,
  `syncflag` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `synctime` int(128) unsigned NOT NULL DEFAULT '10',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dump dei dati per la tabella `syncoptions`
--

INSERT INTO `syncoptions` (`id`, `synctype`, `syncflag`, `synctime`) VALUES
(1, 'carddav', 0, 10),
(2, 'caldav', 0, 10);

-- --------------------------------------------------------

--
-- Struttura della tabella `synctoken`
--

CREATE TABLE `synctoken` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `synctoken` int(11) NOT NULL,
  `flag` varchar(7) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dump dei dati per la tabella `synctoken`
--

INSERT INTO `synctoken` (`id`, `synctoken`, `flag`) VALUES
(1, 0, 'carddav'),
(2, 0, 'caldav');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
