-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2025 at 02:54 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `events_mangment`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(1, 'Theatre'),
(2, 'Cinema'),
(3, 'Music');

-- --------------------------------------------------------

--
-- Table structure for table `evente`
--

CREATE TABLE `evente` (
  `event_id` int(11) NOT NULL,
  `event_name` varchar(50) DEFAULT NULL,
  `event_salle_quantity` int(11) DEFAULT NULL,
  `event_description` varchar(50) DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `event_image` varchar(225) DEFAULT NULL,
  `salle_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `normal_tarif` int(11) DEFAULT NULL,
  `spicail_tarif` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `evente`
--

INSERT INTO `evente` (`event_id`, `event_name`, `event_salle_quantity`, `event_description`, `start_date`, `event_image`, `salle_id`, `category_id`, `normal_tarif`, `spicail_tarif`) VALUES
(1, 'Shakespeare Play', 503, 'A classic play by Shakespeare', '2025-04-04 22:00:00', 'events_images/shakespeare_play.jpg', 1, 1, 150, 80),
(2, 'Rock Concert', 25, 'Live rock music event', '2025-04-10 23:00:00', 'events_images/rock_concert.jpg', 2, 3, 130, 60),
(3, 'Comedy Movie', 2, 'A fun comedy film', '2025-04-15 20:00:00', 'events_images/comedy_movie.jpg', 3, 2, 100, 50),
(4, 'Jazz Night', 0, 'A smooth jazz night with live performances', '2025-05-01 23:00:00', 'events_images/jazz_night.jpg', 3, 3, 200, 100);

-- --------------------------------------------------------

--
-- Table structure for table `resrvtion`
--

CREATE TABLE `resrvtion` (
  `resrve_id` int(11) NOT NULL,
  `date_now` datetime DEFAULT NULL,
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `normal_tarif` int(11) DEFAULT NULL,
  `spicail_tarif` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `resrvtion`
--

INSERT INTO `resrvtion` (`resrve_id`, `date_now`, `event_id`, `user_id`, `normal_tarif`, `spicail_tarif`) VALUES
(44, '2025-04-07 09:04:12', 2, 12, 4, 0),
(45, '2025-04-07 09:04:33', 2, 12, 6, 0),
(46, '2025-04-07 09:05:00', 2, 12, 2, 0),
(47, '2025-04-07 09:05:34', 2, 12, 3, 0),
(48, '2025-04-08 16:46:25', 2, 14, 3, 2),
(49, '2025-04-09 10:10:27', 2, 20, 1, 0),
(50, '2025-04-14 13:49:26', 3, 21, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `salle`
--

CREATE TABLE `salle` (
  `salle_id` int(11) NOT NULL,
  `salle_quentity` int(11) DEFAULT NULL,
  `salle_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `salle`
--

INSERT INTO `salle` (`salle_id`, `salle_quentity`, `salle_name`) VALUES
(1, 600, 'Salle A'),
(2, 300, 'Salle B'),
(3, 150, 'Salle C');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `password`, `email`) VALUES
(12, 'sami', 'belhadj', '$2y$10$i0rO4xOeLzQwHpGiwnQnnuLNfy/8bl/wXUv0xfG0AaiF55ERHhZqC', 'sami@gmail.com'),
(14, 'Monir', 'Marnissi', '$2y$10$SgkWlEry/.6gzQYvXdxNjOQSaXevwn5v.Vxu0EtGTSpkqAVRTL3D2', 'marnissimounir05@gmail.com'),
(15, 'yassin', 'gg', '$2y$10$.o3etY0zFA87g.Un3A0zCu3xdpm6BDSWFWCmsHXJz6v2NrVLz9Lc2', 'yas@gmail.com'),
(16, 'bibi', 'hot', '$2y$10$irl8E34lBmj5kt26ZfaM.OxRpVmgN5Y.cByBcgUXyZzzUjPWul1o2', 'hot@gmail.com'),
(17, 'tgt', 'wjdi', '$2y$10$0xQoqNb3PWMd.VrwKDuCg.VAFOzNQB/8Xz8frGoLwm7OhIgIm633i', 'f@gmail.com'),
(18, 'udsqhus', 'dsjcnsd', '$2y$10$g3TS5EWNQCQTd5VXF3W/mOQEn/EMhilzbKhurJLuOFvJELq5iP5Ui', 'r@gmail.com'),
(19, 'djnsd', 'djndsn', '$2y$10$m/oEjI5ridQuEh35aGyAo.XCF2RTNGu2XykuA/KT8agp2UQGVpoAi', 'y@gmail.com'),
(20, 'sijf', 'qazje', '$2y$10$m/YEQ..DSQ1b.w9twi8AVOlvDTBVg3aM/IYotP6Lfhliuczcibaz6', 'ss@gmail.com'),
(21, 'abdol', 'mohamed', '$2y$10$TPPuuhjcc1oYElQdSevUeu9nwevX3TnOGaZuMSOELn5H/mwzqlW1G', 'abdo@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `evente`
--
ALTER TABLE `evente`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `salle_id` (`salle_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `resrvtion`
--
ALTER TABLE `resrvtion`
  ADD PRIMARY KEY (`resrve_id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `salle`
--
ALTER TABLE `salle`
  ADD PRIMARY KEY (`salle_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `evente`
--
ALTER TABLE `evente`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `resrvtion`
--
ALTER TABLE `resrvtion`
  MODIFY `resrve_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `salle`
--
ALTER TABLE `salle`
  MODIFY `salle_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `evente`
--
ALTER TABLE `evente`
  ADD CONSTRAINT `evente_ibfk_1` FOREIGN KEY (`salle_id`) REFERENCES `salle` (`salle_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `evente_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE;

--
-- Constraints for table `resrvtion`
--
ALTER TABLE `resrvtion`
  ADD CONSTRAINT `resrvtion_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `evente` (`event_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `resrvtion_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
