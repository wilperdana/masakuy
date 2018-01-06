-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 05, 2018 at 06:51 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `masakuy`
--

-- --------------------------------------------------------

--
-- Table structure for table `m_comments`
--

CREATE TABLE IF NOT EXISTS `m_comments` (
`commentID` int(11) NOT NULL,
  `recipeID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `commentFill` longtext NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `m_friends`
--

CREATE TABLE IF NOT EXISTS `m_friends` (
  `friendSource` int(11) NOT NULL,
  `friendDest` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `m_likes`
--

CREATE TABLE IF NOT EXISTS `m_likes` (
  `recipeID` int(11) NOT NULL,
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `m_recipes`
--

CREATE TABLE IF NOT EXISTS `m_recipes` (
`recipeID` int(11) NOT NULL,
  `recipeName` varchar(255) NOT NULL,
  `recipeCustomURL` varchar(100) NOT NULL,
  `userID` int(11) NOT NULL,
  `recipeDescription` longtext NOT NULL,
  `recipeImageURL` varchar(100) NOT NULL,
  `recipeViews` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `m_users`
--

CREATE TABLE IF NOT EXISTS `m_users` (
`userID` int(11) NOT NULL,
  `userName` varchar(100) NOT NULL,
  `userGender` varchar(1) NOT NULL,
  `userUsername` varchar(50) NOT NULL,
  `userDOB` date NOT NULL,
  `userProfileURL` varchar(100) NOT NULL,
  `userAddress` varchar(255) NOT NULL,
  `userBio` varchar(255) NOT NULL,
  `userDateCreated` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `m_users_auth`
--

CREATE TABLE IF NOT EXISTS `m_users_auth` (
  `userID` int(11) NOT NULL,
  `userEmail` varchar(255) NOT NULL,
  `userPassword` varchar(255) NOT NULL,
  `userStatus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `m_comments`
--
ALTER TABLE `m_comments`
 ADD PRIMARY KEY (`commentID`), ADD KEY `recipeID` (`recipeID`), ADD KEY `userID` (`userID`);

--
-- Indexes for table `m_friends`
--
ALTER TABLE `m_friends`
 ADD KEY `friendSource` (`friendSource`,`friendDest`), ADD KEY `friendDest` (`friendDest`);

--
-- Indexes for table `m_likes`
--
ALTER TABLE `m_likes`
 ADD KEY `recipeID` (`recipeID`,`userID`), ADD KEY `userID` (`userID`);

--
-- Indexes for table `m_recipes`
--
ALTER TABLE `m_recipes`
 ADD PRIMARY KEY (`recipeID`), ADD KEY `userID` (`userID`);

--
-- Indexes for table `m_users`
--
ALTER TABLE `m_users`
 ADD PRIMARY KEY (`userID`);

--
-- Indexes for table `m_users_auth`
--
ALTER TABLE `m_users_auth`
 ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `m_comments`
--
ALTER TABLE `m_comments`
MODIFY `commentID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `m_recipes`
--
ALTER TABLE `m_recipes`
MODIFY `recipeID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `m_users`
--
ALTER TABLE `m_users`
MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `m_comments`
--
ALTER TABLE `m_comments`
ADD CONSTRAINT `m_comments_ibfk_1` FOREIGN KEY (`recipeID`) REFERENCES `m_recipes` (`recipeID`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `m_comments_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `m_users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `m_friends`
--
ALTER TABLE `m_friends`
ADD CONSTRAINT `m_friends_ibfk_1` FOREIGN KEY (`friendSource`) REFERENCES `m_users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `m_friends_ibfk_2` FOREIGN KEY (`friendDest`) REFERENCES `m_users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `m_likes`
--
ALTER TABLE `m_likes`
ADD CONSTRAINT `m_likes_ibfk_1` FOREIGN KEY (`recipeID`) REFERENCES `m_recipes` (`recipeID`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `m_likes_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `m_users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `m_recipes`
--
ALTER TABLE `m_recipes`
ADD CONSTRAINT `m_recipes_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `m_users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `m_users_auth`
--
ALTER TABLE `m_users_auth`
ADD CONSTRAINT `m_users_auth_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `m_users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
