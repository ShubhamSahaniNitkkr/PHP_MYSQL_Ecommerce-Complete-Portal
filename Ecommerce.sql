-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 14, 2019 at 09:35 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `items` text COLLATE utf8_unicode_ci NOT NULL,
  `expire_date` datetime NOT NULL,
  `paid` tinyint(4) NOT NULL DEFAULT '0',
  `shipped` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `items`, `expire_date`, `paid`, `shipped`) VALUES
(81, '[{\"id\":\"40\",\"kilo\":\"9\"},{\"id\":\"34\",\"kilo\":3}]', '2019-04-13 19:24:34', 1, 1),
(82, '[{\"id\":\"39\",\"kilo\":6}]', '2019-04-13 20:38:18', 1, 0),
(83, '[{\"id\":\"37\",\"kilo\":\"2\"}]', '2019-04-13 20:41:47', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category` varchar(255) CHARACTER SET latin1 NOT NULL,
  `parent` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`, `parent`) VALUES
(1, 'Vegetables', 0),
(2, 'Pantry', 0),
(3, 'Meat', 0),
(6, 'onion', 1),
(7, 'patato', 1),
(10, 'cooking items', 2),
(11, 'packed food items', 2),
(12, 'skin care', 2),
(13, 'daily needs', 2),
(14, 'chicken', 3),
(16, 'mutton kari', 3),
(22, 'Tamato', 1),
(23, 'fishes', 3),
(24, 'Electronics', 0),
(25, 'Bulbs', 24),
(26, 'Phones', 24),
(27, 'pumpkin', 1),
(28, 'Cabbage', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `list_price` decimal(10,2) NOT NULL,
  `shops` int(11) NOT NULL,
  `categories` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `featured` tinyint(4) NOT NULL DEFAULT '0',
  `kilos` text COLLATE utf8_unicode_ci NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  `popular` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `price`, `list_price`, `shops`, `categories`, `image`, `description`, `featured`, `kilos`, `deleted`, `popular`) VALUES
(34, 'Dal', '90.00', '510.00', 65, '10', 'medias/products/2844bde50611b0e0fe499be7779c50b6.jpg', '1 kg in Rs: 90 only.', 1, '5', 0, 0),
(35, 'Tamato', '340.00', '350.00', 63, '22', 'medias/products/0833e3bdaf084604e5141a3658233d8d.jpg', 'Shuba', 1, '13', 1, 0),
(36, 'F&amp;D Sound tower', '10000.00', '15000.00', 45, '26', '', 'Bluetooth + AUX + Remote', 1, '11', 1, 0),
(37, 'Govi', '40.00', '50.00', 63, '28', 'medias/products/94ee572fcaf3cb4424a13868d64da2e9.png', 'Fresh Govi From Hazipur', 1, '16', 0, 0),
(38, 'Dove', '90.00', '110.00', 65, '12', 'medias/products/08433b02297d779ab0777613321ddc9e.jpeg', 'Buy 2 and get 15% back', 1, '29', 0, 0),
(39, 'Pixel xl', '34000.00', '40000.00', 45, '26', 'medias/products/9cb4a51ae2b6933c0f7e21ff542d8c11.jpeg', 'New Google Pixel 2 + 30 Mp Camera + 5000 mah Battery', 1, '1', 0, 0),
(40, 'Hydrabadi Chicken', '400.00', '500.00', 64, '14', 'medias/products/4790825d571a27b15a0e8851f09d12b3.jpg', 'Tasty Hydrabadi chicken', 1, '10', 0, 0),
(41, 'Nutella Spray', '140.00', '150.00', 65, '10', 'medias/products/2cf9db87b81d698cd16de1b6517cea0d.jpg', 'Make Food tasty  by spraying Nutella Spray + Healthy + Tasty', 1, '23', 0, 0),
(49, 'ghjk', '123456.00', '122.00', 65, '10', 'medias/products/be2e0727af8680f07d4c40027272c6f5.jpg,medias/products/42da7a7d499003d7e328aae7ff5c7958.jpg', '111', 1, '11', 1, 0),
(50, 'Lifeboy Soap', '50.00', '52.00', 65, '12', 'medias/products/d3ad038b9c4a74e81278de7e32ef652a.jpg,medias/products/15bea25f719bcd299e3ae0a4817a8edd.jpg,medias/products/0c3ba548f810067bbff07c56d6493c91.jpg', 'BUY 3 and get 1 Soap Free', 1, '50', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `shops`
--

CREATE TABLE `shops` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shops`
--

INSERT INTO `shops` (`id`, `name`) VALUES
(45, 'Raj Electronic '),
(62, 'Sudha Milk Store'),
(63, 'Shyam Sabji wala'),
(64, 'Irsad Meat shop'),
(65, 'Deepak Kirana');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL,
  `cartid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fullname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(175) COLLATE utf8_unicode_ci NOT NULL,
  `street` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `street2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `zipcode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `txn_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`id`, `cartid`, `fullname`, `email`, `street`, `street2`, `city`, `state`, `zipcode`, `txn_date`, `description`, `total`) VALUES
(16, '81', 'Shubham Sunny', 'shubhamsahaninitkkr@gmail.com', 'New Manichak Masaurhi', 'Patna', 'Masaurhi', '...', '804452', '2019-03-14 23:55:27', '2', 3870),
(17, '82', 'Shubham Sunny', 'shubhamsahaninitkkr@gmail.com', '1234 snt', 'Masaurhi,Patna', 'Masaurhi', 'Choose...', '136119', '2019-03-15 01:09:18', '1', 204000),
(18, '83', 'erty', 'shubhamsahaninitkkr@gmail.com', 'gh', 'hj', 'h', '...', '12', '2019-03-15 01:12:08', '1', 80);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(175) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `join_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` datetime NOT NULL,
  `permissions` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `join_date`, `last_login`, `permissions`) VALUES
(1, 'Shubham sunny', 'Shubhamsahaninitkkr@gmail.com', '$2y$10$n3vOaRb0AQwKnHc3Fw/xv.jCOPyGTy1KU335g6/0aK1cvRx2O9.KC', '2019-03-10 00:01:22', '2019-03-14 20:07:39', 'admin,editor'),
(10, 'Deep Shikha', 'd@gmail.com', '$2y$10$n3vOaRb0AQwKnHc3Fw/xv.jCOPyGTy1KU335g6/0aK1cvRx2O9.KC', '2019-03-10 17:15:39', '2019-03-10 12:46:54', 'editor'),
(11, 'Deep Shikha', 'ds@gmail.com', '$2y$10$F7PWxqU3pj2XNMZBlzE3OOtJSYikBDMv88zG79wE9ymZT5i4QMmeC', '2019-03-10 17:18:21', '2019-03-10 12:48:39', 'editor'),
(12, 'Rohit', 'rohit@gmail.com', '$2y$10$my6Z0GQ46gb6bEGpszcokeBQnbOxMJAv1HzzIGKT.Imyh1WXPvJHq', '2019-03-10 17:20:02', '0000-00-00 00:00:00', 'editor');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shops`
--
ALTER TABLE `shops`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
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
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT for table `shops`
--
ALTER TABLE `shops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;
--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
