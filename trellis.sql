-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 30, 2022 at 03:58 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `trellis`
--

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `iMemId` int(11) NOT NULL,
  `vName` varchar(100) DEFAULT NULL,
  `vUserName` varchar(100) DEFAULT NULL,
  `vPassword` varchar(100) DEFAULT NULL,
  `vPic` varchar(100) NOT NULL,
  `vRole` varchar(255) NOT NULL,
  `vDetail` varchar(255) NOT NULL,
  `vFB_link` varchar(255) NOT NULL,
  `vGoogle_link` varchar(255) NOT NULL,
  `vInsta_link` varchar(255) NOT NULL,
  `vLinkedIn_link` varchar(255) NOT NULL,
  `dtLastLogin` datetime DEFAULT NULL,
  `vLastLoginIP` varchar(100) NOT NULL,
  `vSessionToken` varchar(255) NOT NULL,
  `cStatus` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`iMemId`, `vName`, `vUserName`, `vPassword`, `vPic`, `vRole`, `vDetail`, `vFB_link`, `vGoogle_link`, `vInsta_link`, `vLinkedIn_link`, `dtLastLogin`, `vLastLoginIP`, `vSessionToken`, `cStatus`) VALUES
(1, 'Gulzar Mallik', 'gulgermallik05@gmail.com', '$2y$10$JXB0ldGMXtIEpD1ef5dY2eZVBimwcA7mE0XcbGbcHf3U1RM56HTIm', '1-user-jpg', 'Backend PHP Developer', 'I am an experienced software and website developer seeking a full-time\r\nposition in the field of software or website development, where I can apply\r\nmy knowledge and skills for continuous improvement.', 'https://www.facebook.com/profile.php?id=100009029490844', '', 'https://www.instagram.com/rey_mallik/', 'https://www.linkedin.com/in/gulger-mallik-25b96417a', '2022-01-30 15:49:27', '::1', 'MTgwMzk0NjMxNTYxZjZhNTc3NTA5YWI2LjM1MTE2MzA5', 'A');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`iMemId`),
  ADD UNIQUE KEY `vUserName` (`vUserName`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
