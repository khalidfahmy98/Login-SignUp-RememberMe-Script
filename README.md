# Login-SignUp-RememberMe-Script


Hello , 

This a simple loign / sign up script created with oop php 

some of classes in this project is dynamic and got ability to copy into any another project 
based . 

sql injection in pdo connection is protoected and good .

SQL SCHEMA : 

-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 19, 2019 at 06:08 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 5.6.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `oopscript`
--

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `permissions` text NOT NULL COMMENT 'this is a json format cell'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `permissions`) VALUES
(1, 'Standard User ', ''),
(2, 'administrator ', '{\"admin\":1}');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(64) NOT NULL,
  `salt` varchar(32) NOT NULL,
  `name` varchar(50) NOT NULL,
  `joined` datetime NOT NULL,
  `grouping` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `salt`, `name`, `joined`, `grouping`) VALUES
(2, 'Ahmed', '0000', 'salt', '', '0000-00-00 00:00:00', 0),
(3, ' asdasdasdasdasd', '780dcfdb131f341637e9600f07f06ad3010f202a11c353f778e0c8153d7d1d2d', '`û,çeü-cz7˜Þÿæ¶6^\'Zm`]*?°amÍ', ' asdasdasdasd', '2019-08-14 20:33:36', 1),
(4, ' ahemd mohammed', 'd021eee07228504f8346e8f9bfdabafd11ea584efcf4c90e61d21a4b34b9657e', '¶‘‘É™‰C+ø¤ÃùãÞ“…>©?À.0·­5¡\0Ý•', 'ahmed mohammed ahmed', '2019-08-14 20:35:31', 1),
(5, ' asdhaskldhasklhd', '6589c4b6ff68039f6991ef71df140b0b1aa73b50a1e5c61ab6831f74b9005a60', 'ýViÄ€éÖFÿ½iUEóûxYÊñr“hD\nÌšÂ©bî', 'asdasdad', '2019-08-14 21:37:12', 1),
(6, ' william ', 'fa928fa24791b6a2fa5e268e2c4b25d80b9114d192e2d9ea23c70ab8f08447d9', 'I%¨XšnÝ€W{É\'­4¤ºSœÃóy’è-¹ÕŠ§R', 'william maikel ', '2019-08-14 21:43:28', 1),
(7, ' asdasdasdasd', 'a3cd45f5747648fcc2c14a67c5560af8abd6a08b13ec3adb4939a9b99eb682d3', '¡xp“8¥—F¤ñÔiyÜá\'DÕ\\j\Z~o¦ÏîT', ' asdasdasdasd', '2019-08-14 21:44:16', 1),
(10, 'alex', 'ec89b5c2b298e3e560164b1675ec3e51aca1874d278a3a6a476481e30c1b1e45', 'uÈÊÓÆøÑ|ï•\Zßz}{*—Ä*âÕË…Yÿ', 'alex is alex as always', '2019-08-14 22:47:56', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_session`
--

CREATE TABLE `user_session` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `hash` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_session`
--
ALTER TABLE `user_session`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user_session`
--
ALTER TABLE `user_session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
