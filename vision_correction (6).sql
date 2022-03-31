-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2022 at 06:15 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vision_correction`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` int(11) NOT NULL,
  `result_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `result_id`, `question_id`, `answer`) VALUES
(1, 1, 1, 'Nothing'),
(2, 6, 1, '12'),
(3, 1, 2, '3'),
(4, 6, 2, '8'),
(5, 1, 3, '5'),
(6, 6, 3, '6'),
(7, 1, 4, '70'),
(8, 6, 4, '29'),
(9, 1, 5, '35'),
(10, 6, 5, '57'),
(11, 1, 6, '2'),
(12, 6, 6, '5'),
(13, 1, 7, '5'),
(14, 6, 7, '3'),
(15, 1, 8, '17'),
(16, 6, 8, '15'),
(17, 1, 9, '21'),
(18, 6, 9, '74'),
(19, 6, 10, '2'),
(20, 1, 10, 'NOTHING'),
(21, 1, 11, 'NOTHING'),
(22, 6, 11, '6'),
(23, 1, 12, 'NOTHING'),
(24, 6, 12, '97'),
(31, 1, 13, 'NOTHING'),
(32, 6, 13, '45'),
(33, 1, 14, 'NOTHING'),
(34, 6, 14, '5'),
(35, 1, 15, 'NOTHING'),
(36, 6, 15, '7'),
(37, 6, 16, '16'),
(38, 1, 16, 'NOTHING'),
(39, 6, 17, '73'),
(40, 1, 17, 'NOTHING'),
(41, 6, 18, 'NOTHING'),
(42, 1, 18, '5'),
(43, 6, 19, 'NOTHING'),
(44, 1, 19, '2'),
(45, 6, 20, 'NOTHING'),
(46, 1, 20, '45'),
(47, 6, 21, 'NOTHING'),
(48, 1, 21, '73'),
(49, 6, 22, '26'),
(50, 2, 22, '6'),
(51, 3, 22, '2'),
(52, 6, 23, '42'),
(53, 2, 23, '2'),
(54, 3, 23, '4'),
(55, 6, 24, '35'),
(56, 2, 24, '5'),
(57, 3, 24, '3'),
(58, 6, 25, '96'),
(59, 2, 25, '6'),
(60, 3, 25, '9'),
(61, 6, 26, 'Purple & Red Spots'),
(62, 2, 26, 'Only Purple Line'),
(63, 3, 26, 'Only Red Line'),
(64, 6, 27, 'Purple & Red Spots'),
(65, 2, 27, 'Only Purple Line'),
(66, 3, 27, 'Only Red Line'),
(67, 6, 28, 'Nothing'),
(68, 1, 28, 'A Line'),
(69, 6, 29, 'NOTHING'),
(70, 1, 29, 'A Line'),
(71, 6, 30, 'Blue-Green Line'),
(72, 1, 30, 'Nothing'),
(73, 6, 31, 'Green Line'),
(74, 1, 31, 'Nothing'),
(75, 6, 32, 'Orange Line'),
(76, 1, 32, 'Nothing'),
(77, 6, 33, 'Orange Line'),
(78, 1, 33, 'Nothing'),
(79, 6, 34, 'Green and Yellow Line'),
(80, 1, 34, 'Only Red-Green and Violet line '),
(81, 6, 35, ' green and yellow-green line '),
(82, 1, 35, 'only blue-green and violet line '),
(83, 6, 36, 'violet and orange line'),
(84, 1, 36, 'blue-green and violet line '),
(85, 6, 37, 'violet and orange line '),
(86, 1, 37, 'blue-green and violet line '),
(87, 6, 38, 'A line'),
(88, 6, 38, 'Nothing');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `ID` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `complain` varchar(50) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `eyeinputs`
--

CREATE TABLE `eyeinputs` (
  `ID` int(11) NOT NULL,
  `focal` varchar(255) NOT NULL,
  `focus` varchar(255) NOT NULL,
  `do` varchar(255) NOT NULL,
  `fstop` varchar(255) NOT NULL,
  `resolution` varchar(255) NOT NULL,
  `dtype` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `eyeinputs`
--

INSERT INTO `eyeinputs` (`ID`, `focal`, `focus`, `do`, `fstop`, `resolution`, `dtype`) VALUES
(1, 'dcd', 'dd', 'dv', 'dv', 'dv', 'dvd'),
(2, 'dcd', 'dd', 'dv', 'dv', 'dv', 'dvd');

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `Img` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`id`, `userID`, `Img`, `created_at`) VALUES
(1, 1, '1648684228.jpg\n', '2022-03-30 23:50:29');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `question` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `question`) VALUES
(1, 'plate1.jpg'),
(2, 'plate2.jpg'),
(3, 'plate3.jpg'),
(4, 'plate4.jpg'),
(5, 'plate5.jpg'),
(6, 'plate6.jpg'),
(7, 'plate7.jpg'),
(8, 'plate8.jpg'),
(9, 'plate9.jpg'),
(10, 'plate10.jpg'),
(11, 'plate11.jpg'),
(12, 'plate12.jpg'),
(13, 'plate13.jpg'),
(14, 'plate14.jpg'),
(15, 'plate15.jpg'),
(16, 'plate16.jpg'),
(17, 'plate17.jpg'),
(18, 'plate18.jpg'),
(19, 'plate19.jpg'),
(20, 'plate20.jpg'),
(21, 'plate21.jpg'),
(22, 'plate22.jpg'),
(23, 'plate23.jpg'),
(24, 'plate24.jpg'),
(25, 'plate25.jpg'),
(26, 'plate26.jpg'),
(27, 'plate27.jpg'),
(28, 'plate28.jpg'),
(29, 'plate29.jpg'),
(30, 'plate30.jpg'),
(31, 'plate31.jpg'),
(32, 'plate32.jpg'),
(33, 'plate33.jpg'),
(34, 'plate34.jpg'),
(35, 'plate35.jpg'),
(36, 'plate36.jpg'),
(37, 'plate37.jpg'),
(38, 'plate38.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`id`, `name`, `description`, `image`) VALUES
(1, 'Red-Green Deficiency', 'this is a description on your vision problem that shoud be resolved by the color blindness algorithm', 'humanities.png'),
(2, 'Protanopia', 'this is a description on your vision problem that shoud be resolved by the color blindness algorithm', 'philosophy.png'),
(3, 'deutranopia', 'this is a description on your vision problem that shoud be resolved by the color blindness algorithm', 'entrepreneurship.png'),
(4, 'fourth color blindness problem', 'this is a description on your vision problem that shoud be resolved by the color blindness algorithm', 'psychology.png'),
(5, 'Normal', 'Youre Normal', 'psychology.png'),
(6, 'Normal', 'Youre Normal', 'psychology.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `Password` varchar(20) NOT NULL,
  `Age` int(2) NOT NULL,
  `Type` varchar(5) NOT NULL,
  `Points` int(11) NOT NULL,
  `profileIMG` varchar(50) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `Name`, `Email`, `Password`, `Age`, `Type`, `Points`, `profileIMG`) VALUES
(1, 'mahmoud zoair', 'user@gmail.com', '12345', 21, 'user', 2729724, 'images/car.jpg'),
(2, 'seif yasserr', 'mahmod@admins.com', '12345', 21, 'admin', 600, 'images/im.png'),
(3, 'mahmoud zoair', 'admin@gmail.com', '12345', 22, 'admin', 449, 'images/car.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`),
  ADD KEY `result_id` (`result_id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `eyeinputs`
--
ALTER TABLE `eyeinputs`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `eyeinputs`
--
ALTER TABLE `eyeinputs`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`),
  ADD CONSTRAINT `answers_ibfk_2` FOREIGN KEY (`result_id`) REFERENCES `results` (`id`);

--
-- Constraints for table `contact`
--
ALTER TABLE `contact`
  ADD CONSTRAINT `contact_ibfk_1` FOREIGN KEY (`email`) REFERENCES `users` (`Email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
