-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 30, 2025 at 08:53 PM
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
-- Database: `car_rental`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` enum('pending','approved','rejected','completed') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `car_id`, `start_date`, `end_date`, `status`, `created_at`) VALUES
(1, 2, 2, '2025-03-28', '2025-03-31', 'completed', '2025-03-28 05:27:36'),
(2, 4, 3, '2025-03-29', '2025-03-30', 'completed', '2025-03-28 07:13:38'),
(4, 5, 5, '2025-03-29', '2025-03-31', '', '2025-03-29 06:00:22'),
(5, 5, 7, '2025-03-29', '2025-03-31', 'approved', '2025-03-29 15:05:16');

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `id` int(11) NOT NULL,
  `provider_id` int(11) NOT NULL,
  `model` varchar(100) NOT NULL,
  `brand` varchar(100) NOT NULL,
  `price_per_day` decimal(10,2) NOT NULL,
  `status` enum('available','booked') DEFAULT 'available',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`id`, `provider_id`, `model`, `brand`, `price_per_day`, `status`, `created_at`, `image`) VALUES
(1, 1, 'Swift Dzire', 'Maruti Suzuki', 1500.00, 'available', '2025-03-28 05:25:52', 'Swift Dzire.jpeg'),
(2, 1, 'Creta', 'Hyundai', 3000.00, 'booked', '2025-03-28 05:26:24', 'creta Hyundai.jpeg'),
(3, 1, 'Swift Dzire 1', 'Hyundai', 5000.00, 'booked', '2025-03-28 06:21:28', 'creta Hyundai.jpeg'),
(4, 6, '1 sedan', 'Honda City', 500.00, 'available', '2025-03-28 10:06:02', 'Honda.jpeg'),
(5, 6, 'Harrier', 'Tata', 600.00, 'booked', '2025-03-28 10:20:00', 'harrier.jpg'),
(6, 6, 'Thar', 'Mahindra', 700.00, 'available', '2025-03-28 10:27:52', 'thar.jpg'),
(7, 6, 'R8', 'Audi', 1500.00, 'booked', '2025-03-28 17:58:03', 'audiR8.jpg'),
(8, 6, 'Camry', 'Toyotta', 550.00, 'available', '2025-03-28 17:58:53', 'camry.jpg'),
(9, 6, 'Innova', 'Toyota', 660.00, 'available', '2025-03-28 18:03:30', 'innova.jpg'),
(10, 6, 'MG', 'Gloster', 650.00, 'available', '2025-03-28 18:03:58', 'gloster.jpg'),
(11, 6, 'Verna', 'Hyundai', 440.00, 'available', '2025-03-28 18:07:57', 'verna.jpg'),
(12, 6, '.', 'ISUZU', 900.00, 'available', '2025-03-28 18:12:08', 'isuzu.jpg'),
(13, 6, 'Legendar', 'Fortuner', 1100.00, 'available', '2025-03-28 18:12:49', 'legender.jpg'),
(14, 6, 'Nano', 'TATA', 200.00, 'available', '2025-03-28 19:21:05', 'nano.png');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`id`, `name`, `email`, `phone`) VALUES
(1, 'Ritesh', 'ritesh@gmail.com', '9784767857');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `provider_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `provider_id`, `car_id`, `user_id`, `message`, `is_read`, `created_at`) VALUES
(1, 1, 2, 2, 'Your car Creta has been booked by User ID: 2 from 2025-03-28 to 2025-03-31.', 0, '2025-03-28 05:27:36'),
(2, 1, 3, 4, 'Your car Swift Dzire 1 has been booked by User ID: 4 from 2025-03-29 to 2025-03-30.', 0, '2025-03-28 07:13:38'),
(3, 6, 4, 4, 'Your car 1 sedan has been booked by User ID: 4 from 2025-03-29 to 2025-03-31.', 0, '2025-03-28 13:18:34'),
(4, 6, 5, 5, 'Your car Harrier has been booked by User ID: 5 from 2025-03-29 to 2025-03-31.', 0, '2025-03-29 06:00:22'),
(5, 6, 7, 5, 'Your car R8 has been booked by User ID: 5 from 2025-03-29 to 2025-03-31.', 0, '2025-03-29 15:05:16');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','provider','admin') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'kunal', 'kunalgurav040@gmail.com', '$2y$10$ssktogkqWf3hdatXcwuOx.mcJ5Ve5pTluwpHuXaYKdgv/q4e3Eg.y', 'provider', '2025-03-28 05:23:54'),
(2, 'Sai Dhanawade', 'sai@gmail.com', '$2y$10$shFWNjvn89WupM1nV66x4er.ROIDzXcVHY1YkwMLPeefnmhnPP3Mi', 'user', '2025-03-28 05:27:01'),
(3, 'admin', 'admin@gmail.com', '$2y$10$xNt6DJtGZtNdgH/6SCUhUOyOfHPAtweSdRhWz8o7b6Fs3m5VKQDkC', 'admin', '2025-03-28 05:28:16'),
(4, 'Aditya', 'adii@gmail.com', '$2y$10$li/0IgYuBaw9eTXJUoOTv.gu.h.59NxTqnOWV1A1tZWnkOo/zSMwO', 'user', '2025-03-28 07:01:32'),
(5, 'sujal', 'sujal@gmail.com', '$2y$10$n2JKCoWCRowztHVJaf9msOm7xjwE4Byhm8eTUA6btAgkIrtS1Ecy2', 'user', '2025-03-28 07:02:16'),
(6, 'Adii', 'aditya@gmail.com', '$2y$10$63N2dkMWXAMvBTbTB9A6COz.AgUIbv7ciNA9z33PU3pT.DfkEGEiK', 'provider', '2025-03-28 07:10:56'),
(7, 'Ritesh', 'ritesh@gmail.com', '$2y$10$4pIdo.5GNRKQM/nGd8MjGOXI2uPeLOlshxVOEnemlV4KuXioowdAq', 'user', '2025-03-28 10:42:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `car_id` (`car_id`);

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `provider_id` (`provider_id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD KEY `fk_user_contact` (`id`);

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `provider_id` (`provider_id`),
  ADD KEY `car_id` (`car_id`),
  ADD KEY `user_id` (`user_id`);

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
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`);

--
-- Constraints for table `cars`
--
ALTER TABLE `cars`
  ADD CONSTRAINT `cars_ibfk_1` FOREIGN KEY (`provider_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `contact`
--
ALTER TABLE `contact`
  ADD CONSTRAINT `fk_user_contact` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`provider_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`),
  ADD CONSTRAINT `notifications_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
