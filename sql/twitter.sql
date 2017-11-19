-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 19, 2017 at 09:55 PM
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
(22, 'try', 25, 33, '2017-11-19 21:39:30');

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
(1, 29, 'Pierwszy tweet w bazie', '2017-11-18 00:00:00'),
(2, 30, 'drugi tweet, ale z przeszlosci', '2017-11-05 00:00:00'),
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
(25, 33, 'still going?', '2017-11-19 13:32:47');

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
(1, 'agnieszka@Å›mieszka.pl', '$2y$11$xqDVXEnYN5dxzOQjK.IXxerRQEOi7yd5jYs46ikewp46NAkPmFiLW'),
(3, 'tadam@spadam.pl', '$2y$11$pwHvK6DNjYRdoi4O9gJSq.M/FMoenUDtuQQAzhPmhDnugaB93qz5C'),
(5, 'kadam@spadam.pl', '$2y$11$TqYtimhgISd7btf1jI3uUecIGdhwfF9Elm..QwNuGkbz2PsIuPIYS'),
(6, 'testuje@wnocy.pl', '$2y$11$RNHAogm.9TAI/49soizdzetVMSYbwb6fqPUjDrq6OEfDewCLODe..'),
(8, 'nowy@user.pl', '$2y$11$HmMTcH..qmBIbf8BTnqQg.bY.W/o3uS/sbErvwjypOLVbPVfNmy4u'),
(10, 'asd@asd', '$2y$11$SaRKeK/T3yq8mWNF/dh33u2gIlcczeKg3h4AF25EP7Fllr0lEjnsy'),
(12, 'dsa@dsa.dsa', '$2y$11$BUZUfHSDw6GjkVUQED6YB.IHrZibNgvyemyZLWdSoEizp/wFjquKu'),
(14, 'qwe@qwe', '$2y$11$CF/BEDhBE4Uw.frvJEm7kufvA.wHv180XNyJPewX96VizdPJntuWm'),
(16, '123@asd.qwe', '$2y$11$zxyR/RktZHq6rsznahV5GOW5AIVoYEROkj1oClhv/QHfVek9OsfsK'),
(17, 'fdsg@ghf.sad', '$2y$11$TWwkTJTVoJ/gYnrEC9m7/upix2lL5xavEEEb.S5wNQb4pRqGybD96'),
(18, '1123@asd.hfd', '$2y$11$H2L8xrwgoYE3rXwH1bwysecAbTNz434tjFpP.unllVwB4oAMX7SqC'),
(19, '1123@asd.hfdg', '$2y$11$m1bbkCaIRT.8lxKGt1sf3ewLD1LzLRgWxCLTF6SoCsIq/Y6WIC5Cm'),
(21, '1123@asd.hfdggg', '$2y$11$2FgD.fmvpwCBaJhqTxGqfOBw2clCCePi3j4v.nVZlhz004cGS4RQK'),
(25, 'asfdsdgh@dfhdfg.asdf', '$2y$11$Ou9zM3TqSKfLKRBDR5hw7OvLhdeNck2kB9V3.2WHFkCM95T9VxBn.'),
(26, 'test@test.pl', '$2y$11$ElYvi0PkU8NDxiu5BclwsuFrbriWfUyCbw8JDbF43Tlv1KetijpzW'),
(27, 'test2@test.pl', '$2y$11$fzBih5PU7yn4wVze5wg6DuQCIgGIC/5H5OpNOypovog6XsnSeVMg.'),
(28, 'test3@adsf.asd', '$2y$11$kQYt9q/MaJS/3BZdbz9/bOVb07J3gd2RAd3LDg9aIWYtLGeRmTrVW'),
(29, 'm.durmaj@gmail.com', '$2y$11$hDfXgTXSW0zZBPiRm4zpVeFnRfNUtQnvFhGbj7y8H8xwYD/vc6R.y'),
(30, 'm@tanasiewicz.pl', '$2y$11$SBHKYp6y5/d2Lw7N.pd1VuuBKvnNxwgO8Sax8DDo0i0xgdfR94CLK'),
(31, 'murdoc@op.pl', '$2y$11$iM2r3U0XImn3x3zqOS7wB.h2OaeCNa1um5MYbc/e.vGQqsY7DG5WS'),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tweets`
--
ALTER TABLE `tweets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

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
-- Constraints for table `tweets`
--
ALTER TABLE `tweets`
  ADD CONSTRAINT `tweetToUser` FOREIGN KEY (`userID`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
