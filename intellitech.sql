-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 07, 2019 at 09:12 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `intellitech`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(100) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `title`) VALUES
(1, 'Trending'),
(2, 'Javascript'),
(3, 'Programming');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int(3) NOT NULL,
  `post` int(3) NOT NULL,
  `date` date NOT NULL,
  `author` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `post`, `date`, `author`, `email`, `comment`, `status`) VALUES
(3, 69, '2019-07-15', 'Bright Robert', 'configureall@gmail.com', 'njfngrjnknjdnvjdnjndgj', 'Approved'),
(4, 69, '2019-07-15', 'Bright Robert', 'configureall@gmail.com', 'njfngrjnknjdnvjdnjndgj', 'Approved'),
(5, 74, '2019-07-17', 'Nelson', 'configureall@gmail.com', 'How are u', 'Unapproved');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` int(3) NOT NULL,
  `category` int(4) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `image` text NOT NULL,
  `content` text NOT NULL,
  `tags` varchar(255) NOT NULL,
  `comment_count` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'draft',
  `view_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `category`, `title`, `author`, `date`, `image`, `content`, `tags`, `comment_count`, `status`, `view_count`) VALUES
(69, 2, 'UPGRADE', 'Guru Robert', '2019-07-15', 'slider-image-1.jpg', '<p>kniv kdsvnkfnbclkmkdfvmkvm kvirkm vnrigivldkclmv ldcof</p>', 'updrade', '', 'Published', 58),
(70, 2, 'NEXT', 'Guru Robert', '2019-07-15', '70074128127320.jpg', '<p>DBJSNKDNCKSNKM</p>', '#Bight', '', 'Published', 5),
(71, 2, 'Technologies', 'Guru Robert', '2019-07-15', 'slider-image-2.jpg', '<p>JDCJDNKDCLKOjifkvndfd;</p>', '#Wizard #Nice three', '', 'Draft', 3),
(72, 2, 'FORWARD', 'Guru Robert', '2019-07-15', '69958382618900.jpg', '<p>esdcokodmckdj clslspfvodkvlmdkckdmmlmkfmkvv</p>', '#Wizard #Nice three', '', 'Draft', 10),
(73, 2, 'DOWNGRADE', 'Guru Robert', '2019-07-15', '70329315134960.jpg', '<p>JFHKVNVIJFKVFDMNKVNFNVKF SKMSC CMDPKER</p>', '#Wizard #Nice One', '', 'Draft', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(3) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `role` varchar(255) NOT NULL,
  `randSalt` varchar(255) NOT NULL DEFAULT '$2y$10$programmingguru',
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `firstname`, `lastname`, `email`, `image`, `role`, `randSalt`, `date`) VALUES
(11, 'codengr', '$1$TRFE4BWN$yhc1urEV4q5sIwSvpukGi.', 'Bright', 'Robert', 'configureall@gmail.com', '', 'Subscriber', '', '2019-06-28'),
(12, 'virus', '$1$1ZU6EVIR$Pa/x.jhe1juy8TCjupWOH.', 'Guru', 'Robert', 'bright@intellitech.ng', '', 'Admin', '', '2019-06-28'),
(13, 'bright', 'Kingofpop', 'Bright', 'robert', 'bright.robert@intellitech.ng', '', 'Admin', '', '2019-06-06'),
(24, 'man', 'Kingofpop', 'Bright', 'Robert', 'configureall@gmail.com', '', 'Subscriber', '$2y$10$iamtoogoodinprogramming', '2019-06-28'),
(25, 'guru', '$1$wr33JAaW$.noPM44aoFzqVdtVmOdtE/', 'Bright', 'Robert', 'bright@intellitech.ng', '', 'Subscriber', '$2y$10$iamtoogoodinprogramming', '2019-06-28'),
(26, 'glory', '$1$HVot3ipq$spkhHl4ot.KVHIZ78vTes/', 'Glory', 'Bassey', 'configureall@gmail.com', '', 'Subcriber', '$2y$10$iamtoogoodinprogramming', '2019-06-28'),
(27, 'wow', '$1$A89Ffsj2$Q4UEvZJwZ4caInW5fTBg9/', 'bright', 'robert', 'bright@intellitech.ng', '', 'Subscriber', '$2y$10$iamtoogoodinprogramming', '2019-06-28'),
(28, 'name', '$1$lzExuY5S$rM/DwxJT5ce8vTbwSDYYw/', 'Bright', 'nelseon', 'bright@intellitech.ng', '', 'Admin', '$2y$10$iamtoogoodinprogramming', '2019-06-29'),
(29, 'glory', '$2y$12$2BdEjMUqv7za4DV0NxCUqOk3dNog3edQuksx3kT13imcG3PAWySlW', 'Glory', 'Robert', 'glory.angela@gmail.com', '', 'Admin', '$2y$10$programmingguru', '2019-07-06'),
(30, 'guru', '$2y$12$T70mBD4b7uhjQd3w1SzTDuQ2DjDQ.InpY6R2kkwR5gQ4V.b2mJKkq', 'Bright', 'Robert', 'configureall@gmail.com', '', 'Subscriber', '$2y$10$programmingguru', '2019-07-23'),
(31, 'guru', '$2y$12$xeQrI0wkgUSxYI4pHeyVRe027nRtIPPad2WZIqec4tFoXf7CrGhKS', 'bright', 'guruskid', 'configureall@gmail.com', '', 'Subscriber', '$2y$10$programmingguru', '2019-07-23'),
(32, 'guru', '$2y$12$/nKoQyJpof70q8COO0kdjONBmRBHiHkpK/bgdIvawulqB.fZAO4xe', 'Bright', 'robert', 'configureall@gmail.com', '', 'Subscriber', '$2y$10$programmingguru', '2019-07-23'),
(33, 'guru', '$2y$12$ofq1cndx//hZ5sdPOKTw..fQXazmvD7IhqpsAtTSJakxkOxC0oKFu', 'Bright', 'robert', 'configureall@gmail.com', '', 'Subscriber', '$2y$10$programmingguru', '2019-07-23'),
(34, 'error', '$2y$12$i1l19fQ.JAeKNrhC0D49yO2fmlF5JZOw6D.e1qpN/OXhg3HPrFkeC', 'Bright', 'robert', 'configureall@gmail.com', '', 'Subscriber', '$2y$10$programmingguru', '2019-07-23'),
(35, 'wewe', '$2y$12$bIV6n4yzSG76tZUBCzfSbeIe3qi/IicP5/w/HcVQAsELf6QajWepe', 'Bright', 'Ronert', 'configureall@gmail.com', '', 'Subscriber', '$2y$10$programmingguru', '2019-07-23'),
(36, 'wewee', '$2y$12$PuGd//l.kBrgl4SnuVey6eZUQFshfDHEaZj6OE2NDgAReNJultcha', 'Bright', 'Robert', 'configureall@gmail.com', '', 'Subscriber', '$2y$10$programmingguru', '2019-07-23'),
(37, 'wooooooooooow', '$2y$12$CCi4Us.lZPBcGuGqfwPcMOFmcTp.dHGtybZKl9oWcgVEdmWaETmga', 'Bright', 'robert', 'configureall@gmail.com', '', 'Subscriber', '$2y$10$programmingguru', '2019-07-23'),
(38, 'wooow', '$2y$12$tPu9h7UrtqFGn8ozZJFTnOgBNohwFFPwCi5I53KhG646LyfMvM1ve', 'Bright', 'Robert', 'configureall@gmail.com', '', 'Subscriber', '$2y$10$programmingguru', '2019-07-23'),
(39, 'king', '$2y$12$cvcNIrZclVbaOfnUKDL.RuO/dpifeRybs1c2WkWE8fsvFwCmBBojO', 'Bright', 'robert', 'configureall@gmail.com', '', 'Subscriber', '$2y$10$programmingguru', '2019-07-23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
