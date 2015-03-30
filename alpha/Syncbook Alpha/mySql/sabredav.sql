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
-- Database: `sabredav`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `addressbookchanges`
--

CREATE TABLE `addressbookchanges` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uri` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `synctoken` int(11) unsigned NOT NULL,
  `addressbookid` int(11) unsigned NOT NULL,
  `operation` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `addressbookid_synctoken` (`addressbookid`,`synctoken`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `addressbooks`
--

CREATE TABLE `addressbooks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `principaluri` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `displayname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `uri` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `synctoken` int(11) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `principaluri` (`principaluri`(100),`uri`(100))
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dump dei dati per la tabella `addressbooks`
--

INSERT INTO `addressbooks` (`id`, `principaluri`, `displayname`, `uri`, `description`, `synctoken`) VALUES
(1, 'principals/federico', 'contactsFederico', 'contacts', NULL, 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `calendarchanges`
--

CREATE TABLE `calendarchanges` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uri` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `synctoken` int(11) unsigned NOT NULL,
  `calendarid` int(11) unsigned NOT NULL,
  `operation` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `calendarid_synctoken` (`calendarid`,`synctoken`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `calendarobjects`
--

CREATE TABLE `calendarobjects` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `calendardata` mediumblob,
  `uri` varbinary(200) DEFAULT NULL,
  `calendarid` int(10) unsigned NOT NULL,
  `lastmodified` int(11) unsigned DEFAULT NULL,
  `etag` varbinary(32) DEFAULT NULL,
  `size` int(11) unsigned NOT NULL,
  `componenttype` varbinary(8) DEFAULT NULL,
  `firstoccurence` int(11) unsigned DEFAULT NULL,
  `lastoccurence` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `calendarid` (`calendarid`,`uri`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `calendars`
--

CREATE TABLE `calendars` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `principaluri` varbinary(100) DEFAULT NULL,
  `displayname` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `uri` varbinary(200) DEFAULT NULL,
  `synctoken` int(10) unsigned NOT NULL DEFAULT '0',
  `description` text COLLATE utf8_unicode_ci,
  `calendarorder` int(11) unsigned NOT NULL DEFAULT '0',
  `calendarcolor` varbinary(10) DEFAULT NULL,
  `timezone` text COLLATE utf8_unicode_ci,
  `components` varbinary(20) DEFAULT NULL,
  `transparent` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `principaluri` (`principaluri`,`uri`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dump dei dati per la tabella `calendars`
--

INSERT INTO `calendars` (`id`, `principaluri`, `displayname`, `uri`, `synctoken`, `description`, `calendarorder`, `calendarcolor`, `timezone`, `components`, `transparent`) VALUES
(1, 'principals/federico', 'events', 'events', 0, NULL, 3, '#E6C800FF', 'BEGIN:VCALENDAR\nVERSION:2.0\nPRODID:-//Apple Inc.//Mac OS X 10.9.3//EN\nCALSCALE:GREGORIAN\nBEGIN:VTIMEZONE\nTZID:Europe/Rome\nBEGIN:DAYLIGHT\nTZOFFSETFROM:+0100\nRRULE:FREQ=YEARLY;BYMONTH=3;BYDAY=-1SU\nDTSTART:19810329T020000\nTZNAME:CEST\nTZOFFSETTO:+0200\nEND:DAYLIGHT\nBEGIN:STANDARD\nTZOFFSETFROM:+0200\nRRULE:FREQ=YEARLY;BYMONTH=10;BYDAY=-1SU\nDTSTART:19961027T030000\nTZNAME:CET\nTZOFFSETTO:+0100\nEND:STANDARD\nEND:VTIMEZONE\nEND:VCALENDAR\n', 'VEVENT,VTODO', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `calendarsubscriptions`
--

CREATE TABLE `calendarsubscriptions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uri` varchar(200) NOT NULL,
  `principaluri` varchar(100) NOT NULL,
  `source` text,
  `displayname` varchar(100) DEFAULT NULL,
  `refreshrate` varchar(10) DEFAULT NULL,
  `calendarorder` int(11) unsigned NOT NULL DEFAULT '0',
  `calendarcolor` varchar(10) DEFAULT NULL,
  `striptodos` tinyint(1) DEFAULT NULL,
  `stripalarms` tinyint(1) DEFAULT NULL,
  `stripattachments` tinyint(1) DEFAULT NULL,
  `lastmodified` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `principaluri` (`principaluri`,`uri`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `cards`
--

CREATE TABLE `cards` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `addressbookid` int(11) unsigned NOT NULL,
  `carddata` mediumblob,
  `uri` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastmodified` int(11) unsigned DEFAULT NULL,
  `etag` varbinary(32) DEFAULT NULL,
  `size` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `groupmembers`
--

CREATE TABLE `groupmembers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `principal_id` int(10) unsigned NOT NULL,
  `member_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `principal_id` (`principal_id`,`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `locks`
--

CREATE TABLE `locks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `owner` varchar(100) DEFAULT NULL,
  `timeout` int(10) unsigned DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `token` varbinary(100) DEFAULT NULL,
  `scope` tinyint(4) DEFAULT NULL,
  `depth` tinyint(4) DEFAULT NULL,
  `uri` varbinary(1000) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `token` (`token`),
  KEY `uri` (`uri`(100))
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `principals`
--

CREATE TABLE `principals` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uri` varchar(200) NOT NULL,
  `email` varchar(80) DEFAULT NULL,
  `displayname` varchar(80) DEFAULT NULL,
  `vcardurl` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uri` (`uri`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dump dei dati per la tabella `principals`
--

INSERT INTO `principals` (`id`, `uri`, `email`, `displayname`, `vcardurl`) VALUES
(1, 'principals/admin', 'longhin.federico.nildric@gmail.com', 'Administrator', NULL),
(2, 'principals/admin/calendar-proxy-read', NULL, NULL, NULL),
(3, 'principals/admin/calendar-proxy-write', NULL, NULL, NULL),
(5, 'principals/federico', 'longhin.federico.nildric@gmail.com', 'federico', NULL),
(6, 'principals/federico/calendar-proxy-read', NULL, NULL, NULL),
(7, 'principals/federico/calendar-proxy-write', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `propertystorage`
--

CREATE TABLE `propertystorage` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `path` varbinary(1024) NOT NULL,
  `name` varbinary(100) NOT NULL,
  `value` mediumblob,
  PRIMARY KEY (`id`),
  UNIQUE KEY `path_property` (`path`(600),`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `digesta1` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`id`, `username`, `digesta1`) VALUES
(1, 'admin', '87fd274b7b6c01e48d7c2f965da8ddf7'),
(2, 'federico', '40d8632e44ce4a54e35e55fa4f5b70fa');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
