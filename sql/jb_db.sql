-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: database:3306
-- Generation Time: Dec 30, 2019 at 12:49 PM
-- Server version: 10.4.7-MariaDB-1:10.4.7+maria~bionic
-- PHP Version: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jb_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `companys`
--

CREATE TABLE `companys` (
  `comp_id` int(11) NOT NULL,
  `comp_username` varchar(20) NOT NULL,
  `comp_email` varchar(254) NOT NULL,
  `comp_secret` varchar(255) NOT NULL,
  `comp_name` varchar(200) DEFAULT NULL,
  `comp_city` varchar(50) DEFAULT NULL,
  `comp_image` varchar(255) NOT NULL DEFAULT 'comp.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `companys`
--

INSERT INTO `companys` (`comp_id`, `comp_username`, `comp_email`, `comp_secret`, `comp_name`, `comp_city`, `comp_image`) VALUES
(1, 'test_comp', 'test_comp@test.nl', '$2y$10$mbOS/RTxBiIywH4Q/b/cSeNeueZNwjsDUklF/rzrNueTPkGIDdL8W', 'Nieuw bedrijf', 'Amsterdam', 'img/test_comp.avatar');

-- --------------------------------------------------------

--
-- Table structure for table `offer`
--

CREATE TABLE `offer` (
  `offer_id` int(11) NOT NULL,
  `comp_id` int(11) NOT NULL,
  `offer_title` varchar(30) NOT NULL,
  `offer_description` longtext NOT NULL,
  `offer_field` varchar(20) NOT NULL,
  `offer_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `response`
--

CREATE TABLE `response` (
  `resp_id` int(11) NOT NULL,
  `comp_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `resp_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(200) NOT NULL,
  `secret` varchar(255) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `firstname` varchar(20) DEFAULT NULL,
  `lastname` varchar(20) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `image` varchar(250) DEFAULT 'img/stewie.jpg',
  `age` varchar(5) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `secret`, `created`, `firstname`, `lastname`, `city`, `image`, `age`, `gender`) VALUES
(5, 'test', 'test@test.nl', '$2y$10$4aZxa2PYHELItp/eel1tB.pXWAX12gzQYbgVOM5X6aiQrRDn5vZ5u', '2019-12-20 13:07:07', NULL, NULL, NULL, 'img/stewie.jpg ', '0', ''),
(7, 'turtle', 'turtle@test.com', '$2y$10$O11e1JwdvL8QjEsTq7X.4OGO7K6Jx99cyOSLsAi7mxRZIdKlCtnhK', '2019-12-24 12:33:21', 'Micky', 'Aarnoudse', 'Apeldoorn', 'img/turtle.avatar', '25', 'Apache'),
(8, 'testuser', 'test@user.nl', '$2y$10$7a9eXiT88ezTLFl29Ieqk.xekoHJUGLgPvjg1N0x0cvQOouIa0rve', '2019-12-27 09:07:01', NULL, NULL, NULL, 'img/stewie.jpg ', NULL, NULL),
(9, 'test2', 'test2@test.nl', '$2y$10$inxR4oDCfGR/50HL/mvbwePrd8AyjX.bLQz6wROsYIzAaP9yrJx9.', '2019-12-27 10:20:23', NULL, NULL, NULL, 'img/stewie.jpg', NULL, NULL),
(10, 'kees', 'test@kees.nl', '$2y$10$7xnCU4fRe7JEtu.IgRn7mum.dkcmxYeMdrlCGo8y1zeAKeg4rUBYy', '2019-12-30 12:11:41', '123', '12asd', '', 'img/stewie.jpg', '', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `companys`
--
ALTER TABLE `companys`
  ADD PRIMARY KEY (`comp_id`);

--
-- Indexes for table `offer`
--
ALTER TABLE `offer`
  ADD PRIMARY KEY (`offer_id`);

--
-- Indexes for table `response`
--
ALTER TABLE `response`
  ADD PRIMARY KEY (`resp_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `companys`
--
ALTER TABLE `companys`
  MODIFY `comp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `offer`
--
ALTER TABLE `offer`
  MODIFY `offer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `response`
--
ALTER TABLE `response`
  MODIFY `resp_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
