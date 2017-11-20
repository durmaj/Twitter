-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 20, 2017 at 10:32 PM
-- Server version: 5.7.19
-- PHP Version: 7.0.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `twitter`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `text` varchar(60) NOT NULL,
  `tweetID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `creationDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `text`, `tweetID`, `userID`, `creationDate`) VALUES
(19, 'test komentarza', 3, 33, '2017-11-19 21:34:03'),
(20, 'drugi komentarz do tego tweeta', 3, 33, '2017-11-19 21:34:16'),
(21, 'trzeci tweet', 3, 33, '2017-11-19 21:37:34'),
(22, 'try', 25, 33, '2017-11-19 21:39:30'),
(23, 'a jeszcze kolejny', 25, 33, '2017-11-19 22:21:17'),
(24, 'asdfasd', 25, 33, '2017-11-19 22:21:22');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `senderID` int(11) NOT NULL,
  `receiverID` int(11) NOT NULL,
  `text` varchar(500) NOT NULL,
  `isread` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `senderID`, `receiverID`, `text`, `isread`) VALUES
(1, 8, 33, 'pierwsza wiadomosc prywatna', 0),
(2, 8, 3, 'kolejna wiadomosc', 0),
(3, 33, 8, 'blabla', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tweets`
--

CREATE TABLE `tweets` (
  `id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `text` varchar(140) NOT NULL,
  `creationDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tweets`
--

INSERT INTO `tweets` (`id`, `userID`, `text`, `creationDate`) VALUES
(3, 33, 'trzeci tweet, juz jako user przez strone', '2017-11-19 00:37:46'),
(4, 33, 'trzeci tweet, juz jako user przez strone', '2017-11-19 00:37:51'),
(5, 33, 'kolejny tweet', '2017-11-19 00:38:10'),
(6, 33, 'kolejny tweet', '2017-11-19 00:38:11'),
(7, 33, 'just testin', '2017-11-19 00:38:47'),
(8, 33, 'further testin', '2017-11-19 00:39:14'),
(9, 33, 'ouch', '2017-11-19 00:39:21'),
(13, 33, 'isit workin?', '2017-11-19 00:46:43'),
(14, 33, 'isit workin?', '2017-11-19 00:46:45'),
(15, 33, 'dindo nuffin', '2017-11-19 00:46:58'),
(16, 33, 'any better?', '2017-11-19 11:21:59'),
(17, 33, 'sth new', '2017-11-19 11:39:57'),
(18, 33, 'still testin', '2017-11-19 11:40:22'),
(19, 33, '', '2017-11-19 12:37:52'),
(20, 33, 'notempty', '2017-11-19 12:39:42'),
(21, 33, '', '2017-11-19 12:46:12'),
(22, 33, '', '2017-11-19 12:46:14'),
(23, 33, '', '2017-11-19 12:46:38'),
(24, 33, '', '2017-11-19 12:47:46'),
(25, 33, 'still going?', '2017-11-19 13:32:47'),
(26, 5, 'tweet innego usera', '2017-11-01 00:00:00'),
(27, 33, 'test', '2017-11-20 22:12:52');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(60) NOT NULL,
  `pass` char(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `pass`) VALUES
(3, 'tadam@spadam.pl', '$2y$11$pwHvK6DNjYRdoi4O9gJSq.M/FMoenUDtuQQAzhPmhDnugaB93qz5C'),
(5, 'kadam@spadam.pl', '$2y$11$TqYtimhgISd7btf1jI3uUecIGdhwfF9Elm..QwNuGkbz2PsIuPIYS'),
(6, 'testuje@wnocy.pl', '$2y$11$RNHAogm.9TAI/49soizdzetVMSYbwb6fqPUjDrq6OEfDewCLODe..'),
(8, 'nowy@user.pl', '$2y$11$HmMTcH..qmBIbf8BTnqQg.bY.W/o3uS/sbErvwjypOLVbPVfNmy4u'),
(33, 'test@123.pass', '$2y$11$JkZAjL9UpwOHZ04Xy/5A6.5zuPoONs0HBxKrlaLdSbkbgUeB4RKC2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commentTweet` (`tweetID`),
  ADD KEY `commentUser` (`userID`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messageSender` (`senderID`),
  ADD KEY `messageReceiver` (`receiverID`);

--
-- Indexes for table `tweets`
--
ALTER TABLE `tweets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tweetToUser` (`userID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tweets`
--
ALTER TABLE `tweets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `commentTweet` FOREIGN KEY (`tweetID`) REFERENCES `tweets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `commentUser` FOREIGN KEY (`userID`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messageReceiver` FOREIGN KEY (`receiverID`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `messageSender` FOREIGN KEY (`senderID`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tweets`
--
ALTER TABLE `tweets`
  ADD CONSTRAINT `tweetToUser` FOREIGN KEY (`userID`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
