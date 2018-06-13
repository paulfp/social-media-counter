-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 13, 2018 at 09:48 AM
-- Server version: 10.1.23-MariaDB-9+deb9u1
-- PHP Version: 7.0.27-0+deb9u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `socialCounter`
--
CREATE DATABASE IF NOT EXISTS `socialCounter` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `socialCounter`;

-- --------------------------------------------------------

--
-- Table structure for table `credentials`
--

CREATE TABLE `credentials` (
  `id` int(1) NOT NULL,
  `googleApiKey` varchar(50) DEFAULT NULL,
  `facebookAppId` varchar(50) DEFAULT NULL,
  `facebookSecret` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `credentials`
--

INSERT INTO `credentials` (`id`, `googleApiKey`, `facebookAppId`, `facebookSecret`) VALUES
(1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(1) NOT NULL,
  `scrollDirection` char(1) NOT NULL DEFAULT 'y',
  `intervalTime` int(5) NOT NULL DEFAULT '5000',
  `animationSpeed` int(5) NOT NULL DEFAULT '500' COMMENT '0 = instant',
  `refreshIntervalMinutes` int(5) NOT NULL DEFAULT '5'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `scrollDirection`, `intervalTime`, `animationSpeed`, `refreshIntervalMinutes`) VALUES
(1, 'y', 5000, 500, 5);

-- --------------------------------------------------------

--
-- Table structure for table `social_accounts`
--

CREATE TABLE `social_accounts` (
  `id` int(1) NOT NULL DEFAULT '1',
  `twitterUsername` varchar(15) DEFAULT NULL,
  `youTubeUsername` varchar(20) DEFAULT NULL,
  `facebookPage` varchar(20) DEFAULT NULL,
  `instagramUsername` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `social_accounts`
--

INSERT INTO `social_accounts` (`id`, `twitterUsername`, `youTubeUsername`, `facebookPage`, `instagramUsername`) VALUES
(1, 'SwitchedOnNet', 'caeusdotcomTV', 'SwitchedOnNetwork', 'switchedonnetwork');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `credentials`
--
ALTER TABLE `credentials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_accounts`
--
ALTER TABLE `social_accounts`
  ADD PRIMARY KEY (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
