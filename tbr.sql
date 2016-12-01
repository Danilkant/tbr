-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2016 at 01:19 PM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tbr`
--

-- --------------------------------------------------------

--
-- Table structure for table `comp`
--

CREATE TABLE `comp` (
  `id` int(11) NOT NULL,
  `games_id` int(11) NOT NULL,
  `compDate` date NOT NULL,
  `description` text,
  `prize` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comp`
--

INSERT INTO `comp` (`id`, `games_id`, `compDate`, `description`, `prize`) VALUES
(1, 1, '2020-01-21', 'Bob vs the World 2020 championship', 'Bobzor mouse, sorround sound screamo and a cent.'),
(2, 1, '2016-05-18', 'Who da best?', 'Tomato');

-- --------------------------------------------------------

--
-- Table structure for table `comp_team`
--

CREATE TABLE `comp_team` (
  `id` int(11) NOT NULL,
  `comp_id` int(11) DEFAULT NULL,
  `teams_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comp_team`
--

INSERT INTO `comp_team` (`id`, `comp_id`, `teams_id`) VALUES
(2, 1, 3),
(3, 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `game`
--

CREATE TABLE `game` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `maxPlayer` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `game`
--

INSERT INTO `game` (`id`, `name`, `maxPlayer`) VALUES
(1, 'Bob : GO', '5');

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `id` int(11) NOT NULL,
  `teamname` varchar(255) NOT NULL,
  `teamtag` char(3) NOT NULL,
  `description` text,
  `imgLink` varchar(255) DEFAULT NULL,
  `teamOwner` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`id`, `teamname`, `teamtag`, `description`, `imgLink`, `teamOwner`) VALUES
(3, 'BobInPajamas', 'BIJ', 'We are bob', 'http://i.imgur.com/DoXLf7v.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `team_user`
--

CREATE TABLE `team_user` (
  `id` int(11) NOT NULL,
  `team_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `team_user`
--

INSERT INTO `team_user` (`id`, `team_id`, `user_id`) VALUES
(19, 3, 1),
(20, 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(14) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `isAdmin` tinyint(1) DEFAULT NULL,
  `imgLink` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `name`, `password`, `email`, `isAdmin`, `imgLink`) VALUES
(1, 'Bob', 'Bob Bob', 'password', 'bob@bobmail.com', 1, 'http://i.imgur.com/ZYzQKIR.png'),
(2, 'Potato', 'Potato Potato', 'password', 'potato@bobmail.com', NULL, 'http://i.imgur.com/nimIn05.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comp`
--
ALTER TABLE `comp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `games_id` (`games_id`);

--
-- Indexes for table `comp_team`
--
ALTER TABLE `comp_team`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teams_id` (`teams_id`),
  ADD KEY `comp_id` (`comp_id`);

--
-- Indexes for table `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `teamname` (`teamname`),
  ADD UNIQUE KEY `teamtag` (`teamtag`),
  ADD KEY `teamOwner` (`teamOwner`);

--
-- Indexes for table `team_user`
--
ALTER TABLE `team_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `team_id` (`team_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comp`
--
ALTER TABLE `comp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `comp_team`
--
ALTER TABLE `comp_team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `game`
--
ALTER TABLE `game`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `team_user`
--
ALTER TABLE `team_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `comp`
--
ALTER TABLE `comp`
  ADD CONSTRAINT `comp_ibfk_1` FOREIGN KEY (`games_id`) REFERENCES `game` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `comp_team`
--
ALTER TABLE `comp_team`
  ADD CONSTRAINT `comp_team_ibfk_1` FOREIGN KEY (`teams_id`) REFERENCES `team` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `comp_team_ibfk_2` FOREIGN KEY (`comp_id`) REFERENCES `comp` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `team`
--
ALTER TABLE `team`
  ADD CONSTRAINT `team_Ownder_constraint` FOREIGN KEY (`teamOwner`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `team_user`
--
ALTER TABLE `team_user`
  ADD CONSTRAINT `team_user_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `team_user_ibfk_2` FOREIGN KEY (`team_id`) REFERENCES `team` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
