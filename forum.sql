-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2025 at 04:30 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `forum`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(5) NOT NULL,
  `email` varchar(200) NOT NULL,
  `adminname` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `email`, `adminname`, `password`, `created_at`) VALUES
(1, 'raiadmin@gmail.com', 'raiadmin@gmail.com', '$2y$10$enz8xsuFhnp5Qfz2Joh9JezAEGe804.ttd8G1i17sWg6TRLAtlqxa', '2024-12-05 02:04:29'),
(2, 'edwardvicente29@gmail.com', 'edwardvicente29@gmail.com', '$2y$10$43MhipynvkgxZkvjQ581QOpV9TPtzLqYDtuKNLbiguWMkVkHlIOhq', '2024-12-05 03:24:06'),
(3, 'raiadmin123@admin.com', 'rai', 'adminrai123', '2024-12-05 06:27:44'),
(11, 'edward@gmail.com', 'Edward', '$2y$10$u8S3jPVJ0h1HikZoUFWM6.iT8dpPqxvIMMvi.HmNgvNf1FFZQISAi', '2025-03-27 02:15:57');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(5) NOT NULL,
  `name` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`) VALUES
(1, 'Academic', '2024-12-04 11:49:23'),
(2, 'Personal Life', '2024-12-04 11:49:23'),
(3, 'Mental Health', '2024-12-04 11:49:23'),
(4, 'Lifehacks', '2024-12-05 12:38:30');

-- --------------------------------------------------------

--
-- Table structure for table `replies`
--

CREATE TABLE `replies` (
  `id` int(5) NOT NULL,
  `reply` varchar(200) NOT NULL,
  `user_id` int(5) NOT NULL,
  `user_image` varchar(200) NOT NULL,
  `topics_id` int(5) NOT NULL,
  `user_name` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `replies`
--

INSERT INTO `replies` (`id`, `reply`, `user_id`, `user_image`, `topics_id`, `user_name`, `created_at`) VALUES
(73, 'reply', 25, '', 141, '', '2025-05-18 11:19:29');

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `id` int(5) NOT NULL,
  `user_id` int(100) NOT NULL,
  `title` varchar(200) NOT NULL,
  `category` varchar(200) NOT NULL,
  `body` text NOT NULL,
  `user_name` varchar(200) NOT NULL,
  `user_image` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`id`, `user_id`, `title`, `category`, `body`, `user_name`, `user_image`, `created_at`) VALUES
(138, 0, 'hi', 'Academic', 'oioihioh', 'JOSH', '', '2025-03-30 17:34:55'),
(139, 24, 'hihi', 'Academic', 'bkhk', '3466', '', '2025-03-30 17:45:35'),
(141, 25, 'test ulit ', 'Personal Life', 'hello po', 'tbjosh24', 'unnamed (1).png', '2025-05-18 10:37:46');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(5) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `about` text NOT NULL,
  `avatar` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `password`, `about`, `avatar`, `created_at`) VALUES
(17, 'mama', 'mama@gmail.com', 'mama', '$2y$10$GKHjEuKdFzx4Z3jL/bDpkOu7ER832sWmRrJlH9u20KdPP1pLy63O2', 'mama', '', '2025-02-24 09:01:58'),
(20, 'edward', 'edwardvicente29@gmail.com', 'edward', '$2y$10$Ka0fB2oMRGoLJ5bxLdPBauYK0WPSYpivRCgZ4vMv6242hepSo4eVe', 'Hi', '', '2025-02-25 14:50:04'),
(21, 'Versoza', 'versoza@gmail.com', 'versoza', '$2y$10$jvgUTlhDdqIo.ytnbt1Bp.JuQmsbKC4b9XBfaRMboiYne3GcJI/WG', 'Hi im Versoza', '', '2025-03-26 23:39:36'),
(22, 'hack', 'hackerer@gmail.com  ', 'hack', '$2y$10$gC8v25h1MTdvxO7SaFF8juUnFAcxoXVjdSS2W.PqS2jQdNPfdP5.G', 'yahoo', '', '2025-03-30 15:58:30'),
(23, 'villena', 'villena@gmail.com', 'villena', '$2y$10$Wyd9kyTfUNteIVQKpBhVUegVCfBEvLjopr0xL34nbKRoWnFWhrLnC', 'Hello', '', '2025-03-30 16:10:04'),
(24, 'JOSH', 'josh@gmail.com', '3466', '$2y$10$.UU7CwD8plj1iCTaeRu9FOhc0X1LnakJQ93tUjxf158fPldoZWR0u', 'iyio', '', '2025-03-30 17:11:09'),
(25, 'Joshua Victor Verzosa', 'joshuaverzosa879@gmail.com', 'tbjosh24', '$2y$10$3JMKMwbUEgAUc8xn0DlrEOxUzPDO5xcty6I5ceuQV04heou87ZOAa', 'Hello i\'m 22 years old', 'j.png', '2025-05-18 09:34:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `replies`
--
ALTER TABLE `replies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
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
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `replies`
--
ALTER TABLE `replies`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
