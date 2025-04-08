-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2025 at 07:56 PM
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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booked_procedures`
--
ALTER TABLE `booked_procedures`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booked_procedures`
--
ALTER TABLE `booked_procedures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
