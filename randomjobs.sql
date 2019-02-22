-- phpMyAdmin SQL Dump
-- version 4.4.9
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Erstellungszeit: 12. Jul 2015 um 15:37
-- Server-Version: 5.5.37-0+wheezy1
-- PHP-Version: 5.5.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `cc_dev`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `randomjobs_activejobs`
--

CREATE TABLE IF NOT EXISTS `randomjobs_activejobs` (
  `id` int(11) NOT NULL,
  `jobid` int(11) NOT NULL,
  `depicao` varchar(10) NOT NULL,
  `arricao` varchar(10) NOT NULL,
  `paxnum` int(11) NOT NULL,
  `cargonum` int(11) NOT NULL,
  `expirationtime` datetime NOT NULL,
  `booked` int(11) NOT NULL DEFAULT '0',
  `pilot` int(11) NOT NULL DEFAULT '0',
  `schedid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `randomjobs_aircraft`
--

CREATE TABLE IF NOT EXISTS `randomjobs_aircraft` (
  `id` int(11) NOT NULL,
  `aircraft` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `randomjobs_airports`
--

CREATE TABLE IF NOT EXISTS `randomjobs_airports` (
  `id` int(11) NOT NULL,
  `airport` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `randomjobs_arrival_airports`
--

CREATE TABLE IF NOT EXISTS `randomjobs_arrival_airports` (
  `id` int(11) NOT NULL,
  `departure` varchar(11) NOT NULL,
  `arrival` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `randomjobs_jobtemplates`
--

CREATE TABLE IF NOT EXISTS `randomjobs_jobtemplates` (
  `id` int(11) NOT NULL,
  `jobtype` varchar(2) NOT NULL,
  `jobdescription` mediumtext NOT NULL,
  `depairport` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `randomjobs_jobtemplates`
--

INSERT INTO `randomjobs_jobtemplates` (`id`, `jobtype`, `jobdescription`, `depairport`) VALUES
(1, 'P', 'We have {passengernum} passengers over here in {departurename} waiting for a flight to {arrivalname}.\r\nPlease pick them up as soon as possible. This job exires on {expirationtime}.', '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `randomjobs_prefairports`
--

CREATE TABLE IF NOT EXISTS `randomjobs_prefairports` (
  `id` int(11) NOT NULL,
  `icao` varchar(10) NOT NULL,
  `remain` int(11) NOT NULL,
  `pilotid` int(11) NOT NULL,
  `emailnotify` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `randomjobs_settings`
--

CREATE TABLE IF NOT EXISTS `randomjobs_settings` (
  `id` int(11) NOT NULL,
  `creationintmin` int(11) NOT NULL DEFAULT '10',
  `creationintmax` int(11) NOT NULL DEFAULT '30',
  `minexpiration` int(11) NOT NULL DEFAULT '40',
  `maxexpiration` int(11) NOT NULL DEFAULT '180',
  `maxactivejobs` int(11) NOT NULL DEFAULT '3',
  `lastcreation` datetime NOT NULL,
  `mindistance` int(11) NOT NULL DEFAULT '30',
  `maxdistance` int(11) NOT NULL DEFAULT '500',
  `code` varchar(10) NOT NULL DEFAULT 'JOB',
  `pilrequestmax` int(11) NOT NULL DEFAULT '0',
  `enabled` int(11) NOT NULL DEFAULT '0',
  `allairports` int(3) NOT NULL DEFAULT '1',
  `allaircraft` int(3) NOT NULL DEFAULT '1',
  `restrictacrank` int(3) NOT NULL DEFAULT '1',
  `pilotrequestany` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `randomjobs_settings`
--

INSERT INTO `randomjobs_settings` (`id`, `creationintmin`, `creationintmax`, `minexpiration`, `maxexpiration`, `maxactivejobs`, `lastcreation`, `mindistance`, `maxdistance`, `code`, `pilrequestmax`, `enabled`, `allairports`, `allaircraft`, `restrictacrank`, `pilotrequestany`) VALUES
(1, 5, 10, 40, 180, 10, '0000-00-00 00:00:00', 30, 500, 'JOB', 2, 0, 1, 1, 1, 0);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `randomjobs_activejobs`
--
ALTER TABLE `randomjobs_activejobs`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `randomjobs_aircraft`
--
ALTER TABLE `randomjobs_aircraft`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `randomjobs_airports`
--
ALTER TABLE `randomjobs_airports`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `randomjobs_arrival_airports`
--
ALTER TABLE `randomjobs_arrival_airports`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `randomjobs_jobtemplates`
--
ALTER TABLE `randomjobs_jobtemplates`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `randomjobs_prefairports`
--
ALTER TABLE `randomjobs_prefairports`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `randomjobs_settings`
--
ALTER TABLE `randomjobs_settings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `randomjobs_activejobs`
--
ALTER TABLE `randomjobs_activejobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `randomjobs_aircraft`
--
ALTER TABLE `randomjobs_aircraft`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `randomjobs_airports`
--
ALTER TABLE `randomjobs_airports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `randomjobs_arrival_airports`
--
ALTER TABLE `randomjobs_arrival_airports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `randomjobs_jobtemplates`
--
ALTER TABLE `randomjobs_jobtemplates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT für Tabelle `randomjobs_prefairports`
--
ALTER TABLE `randomjobs_prefairports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `randomjobs_settings`
--
ALTER TABLE `randomjobs_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
