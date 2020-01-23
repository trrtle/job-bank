-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: database:3306
-- Generation Time: Jan 23, 2020 at 11:52 AM
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
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `secret` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `secret`) VALUES
(1, 'turtle', '$2y$10$xNR.OUrF8gDGAi9xh/9hJ.E9b7NOf0ggl/adnJuV04eVyopfSdM66');

-- --------------------------------------------------------

--
-- Table structure for table `companys`
--

CREATE TABLE `companys` (
  `comp_id` int(11) NOT NULL,
  `comp_username` varchar(20) DEFAULT NULL,
  `comp_email` varchar(254) DEFAULT NULL,
  `comp_secret` varchar(255) DEFAULT NULL,
  `comp_name` varchar(200) DEFAULT NULL,
  `comp_city` varchar(50) DEFAULT NULL,
  `comp_image` varchar(255) DEFAULT 'img/comp.jpg',
  `token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `companys`
--

INSERT INTO `companys` (`comp_id`, `comp_username`, `comp_email`, `comp_secret`, `comp_name`, `comp_city`, `comp_image`, `token`) VALUES
(9, 'volkswagen', 'marandom1@outlook.com', '$2y$10$tnPCGG7tuTbxwwRr3recceB3PcrrcPTCbQSGSZxnHGzFy2cPD3Axm', 'Volkswagen', 'Breda', 'img/comp.jpg', NULL),
(10, 'Postnl', 'mmaarnoudse@outlook.com', '$2y$10$7oC.00D.h8KpLDjOUYA6E.vB3OQShW/ZkIUDzROuhU/LcMDkF2q0m', 'Postnl', 'Deventer', 'img/comp.jpg', '2648a15ca3262f394ff19adf4d342ec6a591d47fea3c8cf3971afb0e8a558c4atimestamp1579776397');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `resp_id` int(11) NOT NULL,
  `offer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `commission` double DEFAULT NULL,
  `payed` int(5) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `resp_id`, `offer_id`, `user_id`, `commission`, `payed`) VALUES
(4, 21, 20, 19, 1200, 0);

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `offer_id` int(11) NOT NULL,
  `comp_id` int(11) DEFAULT NULL,
  `offer_title` varchar(30) DEFAULT NULL,
  `offer_desc` longtext DEFAULT NULL,
  `offer_tags` text DEFAULT NULL,
  `offer_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`offer_id`, `comp_id`, `offer_title`, `offer_desc`, `offer_tags`, `offer_date`) VALUES
(19, 9, 'ICT Medewerker (allround)', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lectus arcu bibendum at varius vel. Purus in mollis nunc sed id semper risus. Nibh mauris cursus mattis molestie. Erat imperdiet sed euismod nisi porta lorem mollis aliquam. Amet cursus sit amet dictum sit amet justo donec. Mauris commodo quis imperdiet massa. Nullam eget felis eget nunc lobortis mattis aliquam. Enim ut tellus elementum sagittis vitae et leo. Odio ut enim blandit volutpat. Mauris rhoncus aenean vel elit. Ut tortor pretium viverra suspendisse potenti. Sit amet volutpat consequat mauris nunc congue nisi.\r\n\r\nEtiam erat velit scelerisque in dictum. Orci phasellus egestas tellus rutrum tellus pellentesque eu tincidunt. Nibh venenatis cras sed felis eget velit aliquet sagittis. Cras pulvinar mattis nunc sed. Magna etiam tempor orci eu. Et malesuada fames ac turpis egestas sed. Risus feugiat in ante metus dictum. Facilisi nullam vehicula ipsum a arcu cursus vitae congue mauris. Cursus risus at ultrices mi tempus imperdiet nulla malesuada. Mattis aliquam faucibus purus in massa tempor nec feugiat nisl. Quam pellentesque nec nam aliquam sem.\r\n\r\nLorem mollis aliquam ut porttitor leo a diam. Massa tincidunt dui ut ornare. Integer feugiat scelerisque varius morbi enim. Interdum velit laoreet id donec ultrices tincidunt. Adipiscing elit ut aliquam purus sit. Dui nunc mattis enim ut tellus elementum sagittis vitae et. Quis auctor elit sed vulputate mi sit amet. Maecenas sed enim ut sem viverra. Urna nunc id cursus metus. Et odio pellentesque diam volutpat commodo sed egestas. Erat pellentesque adipiscing commodo elit at imperdiet dui accumsan. Eu mi bibendum neque egestas congue quisque egestas diam. Egestas quis ipsum suspendisse ultrices gravida dictum fusce ut placerat. At tellus at urna condimentum. Est ultricies integer quis auctor elit sed vulputate. Nec ultrices dui sapien eget mi proin sed. Leo vel fringilla est ullamcorper eget nulla facilisi etiam. Ac ut consequat semper viverra. Posuere urna nec tincidunt praesent semper.', 'ICT Medewerker Helpdesk support', '2020-01-22 09:28:09'),
(20, 9, 'Productieleider', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Magna fermentum iaculis eu non. Lacus viverra vitae congue eu consequat. Mauris ultrices eros in cursus turpis massa tincidunt dui ut. Mauris in aliquam sem fringilla ut. Aliquam nulla facilisi cras fermentum odio. In est ante in nibh mauris cursus mattis molestie a. Felis eget velit aliquet sagittis id consectetur purus ut faucibus. Vel orci porta non pulvinar neque laoreet suspendisse. Sed elementum tempus egestas sed. Sed tempus urna et pharetra pharetra. Rhoncus est pellentesque elit ullamcorper dignissim cras tincidunt.\r\n\r\nAenean pharetra magna ac placerat. Augue mauris augue neque gravida in fermentum et. Pretium nibh ipsum consequat nisl vel. Nulla pellentesque dignissim enim sit amet venenatis. Semper auctor neque vitae tempus quam pellentesque. A cras semper auctor neque vitae. Cras adipiscing enim eu turpis. Pharetra vel turpis nunc eget lorem. Sed egestas egestas fringilla phasellus faucibus scelerisque eleifend. Condimentum vitae sapien pellentesque habitant. Integer quis auctor elit sed vulputate mi sit amet. Eleifend mi in nulla posuere. Laoreet suspendisse interdum consectetur libero. Ac ut consequat semper viverra nam libero justo laoreet sit. Eu nisl nunc mi ipsum faucibus vitae aliquet nec ullamcorper.\r\n\r\nAdipiscing diam donec adipiscing tristique. Purus semper eget duis at tellus at. Vitae nunc sed velit dignissim sodales ut eu sem integer. Vel elit scelerisque mauris pellentesque pulvinar pellentesque habitant morbi tristique. Diam in arcu cursus euismod quis viverra nibh cras pulvinar. Aliquet nec ullamcorper sit amet risus nullam eget. Nec ullamcorper sit amet risus nullam eget felis. Vestibulum lectus mauris ultrices eros in. Enim blandit volutpat maecenas volutpat blandit aliquam etiam erat. Tempus iaculis urna id volutpat lacus laoreet non. Facilisis sed odio morbi quis. Enim tortor at auctor urna nunc. Nunc sed augue lacus viverra vitae congue eu consequat ac.\r\n\r\nBibendum enim facilisis gravida neque convallis. Mi sit amet mauris commodo quis imperdiet massa. Lectus vestibulum mattis ullamcorper velit sed ullamcorper morbi tincidunt ornare. Id leo in vitae turpis massa sed. Duis at tellus at urna condimentum mattis pellentesque id. Nisl rhoncus mattis rhoncus urna neque viverra justo nec ultrices. Volutpat sed cras ornare arcu dui vivamus arcu felis. Sit amet justo donec enim diam. Orci phasellus egestas tellus rutrum tellus pellentesque eu tincidunt tortor. Et tortor consequat id porta nibh venenatis cras sed. Amet aliquam id diam maecenas ultricies mi eget.', 'productie voorman leider', '2020-01-22 09:29:12'),
(24, 10, 'Pakket bezorger', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Sapien pellentesque habitant morbi tristique senectus et netus et. Dolor sit amet consectetur adipiscing elit ut aliquam purus. Eu facilisis sed odio morbi quis commodo. Volutpat diam ut venenatis tellus in metus vulputate eu scelerisque. Commodo sed egestas egestas fringilla phasellus faucibus scelerisque. Laoreet sit amet cursus sit amet. Risus pretium quam vulputate dignissim suspendisse. Sodales ut eu sem integer vitae justo eget. Egestas integer eget aliquet nibh praesent tristique magna. Turpis tincidunt id aliquet risus feugiat in ante. Sed ullamcorper morbi tincidunt ornare. Vitae ultricies leo integer malesuada nunc vel risus commodo viverra. Elit at imperdiet dui accumsan sit amet nulla facilisi. Sed augue lacus viverra vitae congue eu consequat ac. Nibh mauris cursus mattis molestie a iaculis at erat. Urna porttitor rhoncus dolor purus non.', 'Bezorger pakket', '2020-01-23 09:11:34');

-- --------------------------------------------------------

--
-- Table structure for table `response`
--

CREATE TABLE `response` (
  `resp_id` int(11) NOT NULL,
  `offer_id` int(11) DEFAULT NULL,
  `resp_text` longtext DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `resp_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `response`
--

INSERT INTO `response` (`resp_id`, `offer_id`, `resp_text`, `user_id`, `resp_date`) VALUES
(21, 20, 'adfadsf', 19, '2020-01-22 15:53:02');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(20) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `secret` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `firstname` varchar(20) DEFAULT NULL,
  `lastname` varchar(20) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `image` varchar(250) DEFAULT 'img/stewie.jpg',
  `age` varchar(5) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `secret`, `created`, `firstname`, `lastname`, `city`, `image`, `age`, `gender`, `token`) VALUES
(19, 'Micky', 'mmaarnoudse@outlook.com', '$2y$10$1tvNR2QknBzuJ0rDt6kt8Ojbom6R96bac9N8owvCHShrTXAGRdXWC', '2020-01-22 09:23:19', NULL, NULL, NULL, 'img/stewie.jpg', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companys`
--
ALTER TABLE `companys`
  ADD PRIMARY KEY (`comp_id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
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
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `companys`
--
ALTER TABLE `companys`
  MODIFY `comp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `offer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `response`
--
ALTER TABLE `response`
  MODIFY `resp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
