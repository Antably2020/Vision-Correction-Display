-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 18, 2022 at 02:57 PM
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
-- Table structure for table `about`
--

CREATE TABLE `about` (
  `description` text NOT NULL,
  `Vision` text NOT NULL,
  `Mission` text NOT NULL,
  `id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `about`
--

INSERT INTO `about` (`description`, `Vision`, `Mission`, `id`) VALUES
('hi i\"m testing this page now!!', 'hi i\"m testing this page now!!', 'hi i\"m testing this page now!!', 0);

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
(1, 2, 1, 'Yes'),
(2, 5, 1, 'No'),
(3, 3, 2, 'Yes'),
(4, 5, 2, 'No'),
(5, 1, 3, 'Yes'),
(6, 5, 3, 'No'),
(7, 4, 4, 'Yes'),
(8, 5, 4, 'No'),
(9, 3, 5, 'Yes'),
(10, 5, 5, 'No'),
(11, 3, 6, 'Yes'),
(12, 5, 6, 'No'),
(13, 1, 7, 'Yes'),
(14, 5, 7, 'No'),
(15, 2, 8, 'Yes'),
(16, 5, 8, 'No'),
(17, 4, 9, 'Yes'),
(18, 5, 9, 'No'),
(19, 1, 10, 'Yes'),
(20, 5, 10, 'No'),
(21, 4, 11, 'Yes'),
(22, 5, 11, 'No'),
(23, 2, 12, 'Yes'),
(24, 5, 12, 'No');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `sum` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `productID`, `userID`, `quantity`, `sum`) VALUES
(1, 6, 1, 2, 1132),
(5, 6, 1, 3, 1698),
(7, 10, 1, 1, 345);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `categoryID` int(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  `catImage` varchar(50) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`categoryID`, `category`, `catImage`) VALUES
(0, 'Transmission', 'images/cat0.jpg'),
(1, 'Exhaust Systems', 'images/p1.jpg'),
(2, 'Air Cleaners ', 'images/cat2.jpg'),
(3, 'Handlebars', 'images/cat3.jpg'),
(4, 'Bike Protection', 'images/cat4.jpg'),
(5, 'Suspensions', 'images/cat5.jpg'),
(6, 'Brakes', 'images/cat6.jpg'),
(7, 'Engine Parts', 'images/cat7.jpg');

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
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `productID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `Fullname` varchar(20) NOT NULL,
  `Email` varchar(40) NOT NULL,
  `Phone` int(11) NOT NULL,
  `City` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `Street` varchar(50) NOT NULL,
  `Building` varchar(10) NOT NULL,
  `Floor` int(10) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `oldPrice` float NOT NULL,
  `price` float NOT NULL,
  `id` int(11) NOT NULL,
  `img` varchar(250) NOT NULL,
  `featured` tinyint(1) NOT NULL,
  `category` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`name`, `description`, `oldPrice`, `price`, `id`, `img`, `featured`, `category`) VALUES
('timing parts', 'Size 16', 1800, 1500, 2, 'images/single-handlebar-showing-cup-popup_1000x.jpg', 1, 7),
('mahmoud', 'gd3', 0, 900000, 3, 'images/TTX-flow-DV_hemsida-380x240.jpg', 1, 4),
('akrapovic', 'high sound exhaust', 600, 566, 6, 'images/p3.jpg', 1, 1),
('c200', 'perfect condition ', 500, 345, 10, 'images/car.jpg', 1, 0),
('new brakes', 'good product', 120, 100, 11, 'images/Motorcycle-Brake-Rotor-and-Pad.JPG', 0, 4),
('exhaust', 'good product', 6000, 5230, 20, 'images/p1.jpg', 1, 1),
('ransmission ig', 'good product', 4000, 4000, 21, 'images/old-parts-motorcycles-background-hard-260nw-459371572.jpg', 0, 0),
('brake ff', 'good product', 1200, 1000, 22, 'images/Motorcycle-Brake-Rotor-and-Pad.jpg', 1, 6),
('sliders', 'good product', 600, 500, 28, 'images/abc0364ea74a8a1ba8e33c840012d630.jpg', 1, 4),
('sliders', 'good product', 500, 400, 29, 'images/abc0364ea74a8a1ba8e33c840012d630.jpg', 0, 4),
('short block', 'good product perfect', 15000, 14000, 30, 'images/cat2.jpg', 0, 7),
('product', 'good product', 150, 100, 35, 'images/619hKdps11L._AC_SY355_.jpg', 1, 1),
('slave', 'good slave eswd', 50, 30, 36, 'images/835bc45b458bb94aed0df244e7d8e796.jpg', 1, 2),
('testonline', 'good product', 300, 300, 37, 'images/', 0, 1);

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
(1, 'this is question 1'),
(2, 'this is question 2'),
(3, 'this is question 3'),
(4, 'this is question 4'),
(5, 'this is question 5'),
(6, 'this is question 6'),
(7, 'this is question 7'),
(8, 'this is question 8'),
(9, 'this is question 9'),
(10, 'this is question 10'),
(11, 'this is question 11'),
(12, 'this is question 12');

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
(1, 'first color blindness problem', 'this is a description on your vision problem that shoud be resolved by the color blindness algorithm', 'humanities.png'),
(2, 'second color blindness problem', 'this is a description on your vision problem that shoud be resolved by the color blindness algorithm', 'philosophy.png'),
(3, 'third color blindness problem', 'this is a description on your vision problem that shoud be resolved by the color blindness algorithm', 'entrepreneurship.png'),
(4, 'fourth color blindness problem', 'this is a description on your vision problem that shoud be resolved by the color blindness algorithm', 'psychology.png'),
(5, 'None', '........', '..............');

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
-- Indexes for table `about`
--
ALTER TABLE `about`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`),
  ADD KEY `result_id` (`result_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pID` (`productID`),
  ADD KEY `uID` (`userID`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`categoryID`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pID` (`productID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index` (`category`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`productID`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `contact`
--
ALTER TABLE `contact`
  ADD CONSTRAINT `contact_ibfk_1` FOREIGN KEY (`email`) REFERENCES `users` (`Email`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`productID`) REFERENCES `products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `users` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category`) REFERENCES `categories` (`categoryID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
