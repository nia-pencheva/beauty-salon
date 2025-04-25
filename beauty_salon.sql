-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2025 at 01:37 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `beauty_salon`
--

-- --------------------------------------------------------

--
-- Table structure for table `booked_procedures`
--

CREATE TABLE `booked_procedures` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `procedure_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `booked_procedures`
--

INSERT INTO `booked_procedures` (`id`, `user_id`, `procedure_id`, `date`, `time`, `created_at`) VALUES
(1, 1, 3, '2025-04-21', '09:00:00', '2025-04-08 17:56:18'),
(2, 2, 1, '2025-04-21', '10:30:00', '2025-04-08 17:56:18'),
(3, 3, 5, '2025-04-21', '12:00:00', '2025-04-08 17:56:18'),
(4, 4, 6, '2025-04-21', '14:00:00', '2025-04-08 17:56:18'),
(5, 2, 12, '2025-04-21', '16:00:00', '2025-04-08 17:56:18'),
(6, 1, 2, '2025-04-22', '09:00:00', '2025-04-08 17:56:18'),
(7, 4, 10, '2025-04-22', '10:45:00', '2025-04-08 17:56:18'),
(8, 3, 4, '2025-04-22', '13:00:00', '2025-04-08 17:56:18'),
(9, 1, 13, '2025-04-22', '15:00:00', '2025-04-08 17:56:18'),
(10, 2, 8, '2025-04-22', '16:30:00', '2025-04-08 17:56:18'),
(11, 4, 15, '2025-04-23', '09:00:00', '2025-04-08 17:56:18'),
(12, 3, 7, '2025-04-23', '10:30:00', '2025-04-08 17:56:18'),
(13, 1, 11, '2025-04-23', '12:00:00', '2025-04-08 17:56:18'),
(14, 2, 9, '2025-04-23', '13:30:00', '2025-04-08 17:56:18'),
(15, 4, 14, '2025-04-23', '15:00:00', '2025-04-08 17:56:18');

-- --------------------------------------------------------

--
-- Table structure for table `procedures`
--

CREATE TABLE `procedures` (
  `id` int(11) NOT NULL,
  `name` varchar(500) NOT NULL,
  `procedure_category_id` int(11) NOT NULL,
  `duration_minutes` int(11) NOT NULL,
  `price` double NOT NULL,
  `rating` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `procedures`
--

INSERT INTO `procedures` (`id`, `name`, `procedure_category_id`, `duration_minutes`, `price`, `rating`) VALUES
(1, 'Подстригване на жени', 1, 45, 25, 5),
(2, 'Боядисване на коса', 1, 90, 60, 4),
(3, 'Маникюр с гел лак', 2, 60, 35, 5),
(4, 'Педикюр', 2, 50, 30, 4),
(5, 'Почистване на лице', 3, 70, 45, 4),
(6, 'Релаксиращ масаж', 4, 60, 50, 5),
(7, 'Терапия с арганово масло', 1, 30, 20, 4),
(8, 'Оформяне на брада', 1, 30, 15, 4),
(9, 'Изправяне с преса', 1, 40, 20, 4),
(10, 'Удължаване на нокти', 2, 90, 60, 5),
(11, 'Декорация на нокти', 2, 30, 15, 4),
(12, 'Хидратираща маска за лице', 3, 40, 25, 4),
(13, 'Анти-акне терапия', 3, 60, 40, 5),
(14, 'Антицелулитен масаж', 4, 50, 45, 4),
(15, 'Ароматерапевтичен масаж', 4, 75, 55, 5);

-- --------------------------------------------------------

--
-- Table structure for table `procedure_categories`
--

CREATE TABLE `procedure_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `procedure_categories`
--

INSERT INTO `procedure_categories` (`id`, `name`) VALUES
(1, 'Коса'),
(3, 'Лице'),
(4, 'Масажи'),
(2, 'Нокти');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `full_name`, `email`) VALUES
(1, 'admin', '$2y$10$0YHEqGNxY8I6d0t36JH4cuUdiOeL/B2PVKOZE6lhJbT8XC6SpkWHK', 'Админ', 'yoana.tsvetanova06@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booked_procedures`
--
ALTER TABLE `booked_procedures`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `procedures`
--
ALTER TABLE `procedures`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `procedure_categories`
--
ALTER TABLE `procedure_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `procedure_category` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booked_procedures`
--
ALTER TABLE `booked_procedures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `procedures`
--
ALTER TABLE `procedures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `procedure_categories`
--
ALTER TABLE `procedure_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
