-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 17, 2026 at 09:23 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 5.6.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `organdonation`
--

-- --------------------------------------------------------

--
-- Table structure for table `blood_donors`
--

CREATE TABLE `blood_donors` (
  `id` int(11) UNSIGNED NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `age` int(3) NOT NULL,
  `gender` enum('Female','Male','Other') NOT NULL,
  `bloodgroup` enum('A+','A-','B+','B-','AB+','AB-','O+','O-') NOT NULL,
  `weight` decimal(5,2) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `pincode` varchar(10) NOT NULL,
  `lastdonation` date DEFAULT NULL,
  `medical` text,
  `reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blood_donors`
--

INSERT INTO `blood_donors` (`id`, `fullname`, `dob`, `age`, `gender`, `bloodgroup`, `weight`, `phone`, `email`, `address`, `city`, `state`, `pincode`, `lastdonation`, `medical`, `reg_date`) VALUES
(1, 'John', '2004-06-10', 21, 'Male', 'AB+', '55.00', '8765432190', 'John@gmail.com', '11/A,kamaraj middle street', 'Thanjavur', 'Tamilnadu', '627400', '0000-00-00', 'Normal', '2025-09-29 00:04:51'),
(2, 'Henry', '2003-05-12', 22, 'Male', 'O+', '60.00', '9087654321', 'henry@gmail.com', '25/11,south street', 'Kanyakumari', 'Tamilnadu', '634500', '0000-00-00', '', '2025-09-29 00:06:41'),
(6, 'Joe', '2004-07-04', 21, 'Male', 'O-', '56.00', '9753124680', 'joe@gmail.com', '11 west street', 'salem', 'Tamilnadu', '674328', '0000-00-00', '', '2025-09-29 00:15:58'),
(7, 'Joe', '2004-07-04', 21, 'Male', 'O-', '56.00', '9753124680', 'joe@gmail.com', '11 west street', 'salem', 'Tamilnadu', '674328', '0000-00-00', '', '2025-09-29 00:17:26'),
(8, 'Thara', '2005-04-13', 20, 'Female', 'AB-', '50.00', '9256851287', 'thara@gmail.com', '13west street', 'dindugal', 'Tamilnadu', '568923', '0000-00-00', '', '2025-09-29 00:19:47'),
(9, 'Thara', '2005-04-13', 20, 'Female', 'AB-', '50.00', '9256851287', 'thara@gmail.com', '13west street', 'dindugal', 'Tamilnadu', '568923', '0000-00-00', '', '2025-09-29 00:20:56');

-- --------------------------------------------------------

--
-- Table structure for table `contactss`
--

CREATE TABLE `contactss` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `city` varchar(100) NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contactss`
--

INSERT INTO `contactss` (`id`, `name`, `email`, `subject`, `message`, `city`, `submitted_at`) VALUES
(1, 'Ravi', 'ravi@gmail.com', 'organ', 'best for donation', 'vk.puram', '2025-10-08 01:38:48'),
(2, 'regi', 'regi@gmail.com', 'experience', 'its good', 'trichy', '2025-10-08 01:39:27'),
(3, 'Ravi', 'ravi@gmail.com', 'enquiry', 'user friendly', 'kovai', '2025-10-08 09:20:37');

-- --------------------------------------------------------

--
-- Table structure for table `donors`
--

CREATE TABLE `donors` (
  `donor_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `age` int(11) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `blood_group` varchar(5) NOT NULL,
  `organ` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `message` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `donors`
--

INSERT INTO `donors` (`donor_id`, `name`, `age`, `gender`, `blood_group`, `organ`, `city`, `contact`, `message`) VALUES
(2, 'harini', 20, 'Female', 'A+', 'Liver', 'v.k.pram', '786564321', ''),
(3, 'Kirshkapoor', 21, 'Male', 'O-', 'Eyes', 'tiruchy', '945678932', ''),
(4, 'vaani', 27, 'Female', 'AB+', 'Lungs', 'madurai', '9123456842', ''),
(5, 'Rohan', 22, 'Male', 'O+', 'Liver', 'Chennai', '956234589', ''),
(6, 'Alan', 25, 'Male', 'A-', 'Eyes', 'Tenkasi', '9682371261', ''),
(7, 'Hari', 28, 'Male', 'B+', 'Kidney', 'Kanyakumari', '956783421', ''),
(8, 'ravi', 23, 'Male', 'O+', 'Liver', 'trichy', '94657081324', '');

-- --------------------------------------------------------

--
-- Table structure for table `eye_donors`
--

CREATE TABLE `eye_donors` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `registered_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `eye_donors`
--

INSERT INTO `eye_donors` (`id`, `full_name`, `age`, `gender`, `email`, `phone`, `city`, `registered_at`) VALUES
(1, 'Tharun', 30, 'Male', 'tharun@gmail.com', '945673245', 'Ranipet', '2025-09-29 00:37:22'),
(2, 'Ashwin', 40, 'Male', 'ashwin@gmail.com', '923456781', 'thambaram', '2025-09-29 00:38:30'),
(3, 'Banu', 42, 'Female', 'banu@gmail.com', '845867585', 'velacheri', '2025-09-29 00:40:19'),
(4, 'Aadhi', 39, 'Male', 'aadhi@gmail.com', '854123871', 'Tuticori', '2025-09-29 00:41:25');

-- --------------------------------------------------------

--
-- Table structure for table `heart_donors`
--

CREATE TABLE `heart_donors` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `registered_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `heart_donors`
--

INSERT INTO `heart_donors` (`id`, `full_name`, `age`, `gender`, `email`, `phone`, `city`, `registered_at`) VALUES
(1, 'Lucky', 25, 'Female', 'lucky@gmail.com', '9543267819', 'Tirunelveli', '2025-09-29 00:34:09'),
(2, 'yazh', 26, 'Male', 'yazh@gmail.com', '976234567', 'thiruchendur', '2025-09-29 00:35:16'),
(3, 'Subi', 22, 'Female', 'subi@gmail.com', '934567832', 'chengalpet', '2025-09-29 00:36:22'),
(4, 'Tamil', 34, 'Female', 'tamil@gmail.com', '58678673', 'tenkasi', '2025-10-08 09:40:46'),
(5, 'Tamil', 34, 'Female', 'tamil@gmail.com', '58678673', 'tenkasi', '2025-10-08 09:46:00');

-- --------------------------------------------------------

--
-- Table structure for table `kidney_donors`
--

CREATE TABLE `kidney_donors` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `blood_group` varchar(5) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `registered_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kidney_donors`
--

INSERT INTO `kidney_donors` (`id`, `name`, `email`, `phone`, `age`, `gender`, `blood_group`, `city`, `registered_at`) VALUES
(1, 'Vaishu', 'vaishu@gamil.com', '9854526476', 40, 'Female', 'B-', 'Tenkasi', '2025-09-29 00:43:20'),
(2, 'Pavithra', 'pavithra@gmail.com', '934567832', 23, 'Female', 'O+', 'theni', '2025-09-29 00:44:35'),
(3, 'Gayathri', 'Gayathri@gmail.com', '96253645', 30, 'Female', 'O+', 'TIrunelveli', '2025-09-29 00:45:30'),
(4, 'Pushpa', 'pushpa@gmail.com', '952378163', 34, 'Female', 'O+', 'madurai', '2025-09-29 00:46:14');

-- --------------------------------------------------------

--
-- Table structure for table `liver_donors`
--

CREATE TABLE `liver_donors` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `blood_group` varchar(5) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `liver_donors`
--

INSERT INTO `liver_donors` (`id`, `name`, `email`, `phone`, `blood_group`, `age`, `created_at`) VALUES
(1, 'guna', 'guna@gmail.com', '7654321890', 'B-', 43, '2025-09-29 03:51:41'),
(2, 'Ganesh', 'ganesh@gmail.com', '6312457890', 'AB+', 32, '2025-09-29 03:52:15'),
(3, 'praveena', 'praveena@gmail.com', '9058671234', 'A-', 23, '2025-09-29 03:52:55'),
(4, 'sashtika', 'sashtika@gmail.com', '812746590', 'A+', 28, '2025-09-29 03:53:37'),
(5, 'kishore', 'kishore@gmail.com', '9823064751', 'A-', 47, '2025-09-29 03:54:11');

-- --------------------------------------------------------

--
-- Table structure for table `lungs_donors`
--

CREATE TABLE `lungs_donors` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lungs_donors`
--

INSERT INTO `lungs_donors` (`id`, `name`, `email`, `phone`, `age`, `gender`, `created_at`) VALUES
(1, 'Aaradhana', 'aaradhana@gmail.com', '8164235072', 33, 'Female', '2025-09-29 03:55:45'),
(2, 'selva', 'selva@gmail.com', '7120934567', 21, 'Male', '2025-09-29 03:56:24'),
(3, 'sundar', 'sundar@gmail.com', '7890654321', 26, 'Male', '2025-09-29 03:56:52');

-- --------------------------------------------------------

--
-- Table structure for table `matching`
--

CREATE TABLE `matching` (
  `id` int(11) NOT NULL,
  `donor_name` varchar(100) DEFAULT NULL,
  `recipient_name` varchar(100) DEFAULT NULL,
  `blood_group` varchar(10) DEFAULT NULL,
  `organ` varchar(50) DEFAULT NULL,
  `donor_city` varchar(100) DEFAULT NULL,
  `recipient_city` varchar(100) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `matched_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `matching`
--

INSERT INTO `matching` (`id`, `donor_name`, `recipient_name`, `blood_group`, `organ`, `donor_city`, `recipient_city`, `status`, `matched_at`) VALUES
(1, 'Hari', 'vishnu', 'B+', 'Kidney', 'Kanyakumari', 'Theni', 'Waiting', '2025-10-08 01:29:47'),
(2, 'Hari', 'vishnu', 'B+', 'Kidney', 'Kanyakumari', 'Theni', 'Waiting', '2025-10-08 03:35:59'),
(3, 'Hari', 'vishnu', 'B+', 'Kidney', 'Kanyakumari', 'Theni', 'Waiting', '2025-10-08 03:38:43'),
(4, 'Rohan', 'keerthana', 'O+', 'Liver', 'Chennai', 'vk.puram', 'Waiting', '2025-10-08 03:38:43'),
(5, 'ravi', 'keerthana', 'O+', 'Liver', 'trichy', 'vk.puram', 'Waiting', '2025-10-08 03:38:44'),
(6, 'Hari', 'vishnu', 'B+', 'Kidney', 'Kanyakumari', 'Theni', 'Waiting', '2025-10-08 09:15:35'),
(7, 'Rohan', 'keerthana', 'O+', 'Liver', 'Chennai', 'vk.puram', 'Waiting', '2025-10-08 09:15:35'),
(8, 'ravi', 'keerthana', 'O+', 'Liver', 'trichy', 'vk.puram', 'Waiting', '2025-10-08 09:15:35'),
(9, 'Hari', 'vishnu', 'B+', 'Kidney', 'Kanyakumari', 'Theni', 'Waiting', '2025-10-08 09:17:24'),
(10, 'Rohan', 'keerthana', 'O+', 'Liver', 'Chennai', 'vk.puram', 'Waiting', '2025-10-08 09:17:24'),
(11, 'ravi', 'keerthana', 'O+', 'Liver', 'trichy', 'vk.puram', 'Waiting', '2025-10-08 09:17:24'),
(12, 'Hari', 'vishnu', 'B+', 'Kidney', 'Kanyakumari', 'Theni', 'Waiting', '2025-10-08 09:28:03'),
(13, 'Rohan', 'keerthana', 'O+', 'Liver', 'Chennai', 'vk.puram', 'Waiting', '2025-10-08 09:28:04'),
(14, 'ravi', 'keerthana', 'O+', 'Liver', 'trichy', 'vk.puram', 'Waiting', '2025-10-08 09:28:04'),
(15, 'Rohan', 'keerthana', 'O+', 'Liver', 'Chennai', 'vk.puram', 'Waiting', '2025-10-08 09:28:04'),
(16, 'Rohan', 'keerthana', 'O+', 'Liver', 'Chennai', 'vk.puram', 'Waiting', '2025-10-08 09:28:04'),
(17, 'Rohan', 'keerthana', 'O+', 'Liver', 'Chennai', 'vk.puram', 'Waiting', '2025-10-08 09:28:04'),
(18, 'ravi', 'keerthana', 'O+', 'Liver', 'trichy', 'vk.puram', 'Waiting', '2025-10-08 09:28:04'),
(19, 'ravi', 'keerthana', 'O+', 'Liver', 'trichy', 'vk.puram', 'Waiting', '2025-10-08 09:28:04'),
(20, 'ravi', 'keerthana', 'O+', 'Liver', 'trichy', 'vk.puram', 'Waiting', '2025-10-08 09:28:04'),
(21, 'Hari', 'vishnu', 'B+', 'Kidney', 'Kanyakumari', 'Theni', 'Waiting', '2025-10-08 09:28:04'),
(22, 'Hari', 'vishnu', 'B+', 'Kidney', 'Kanyakumari', 'Theni', 'Waiting', '2025-10-08 09:28:04'),
(23, 'Hari', 'vishnu', 'B+', 'Kidney', 'Kanyakumari', 'Theni', 'Waiting', '2025-10-08 09:28:04'),
(24, 'ravi', 'keerthana', 'O+', 'Liver', 'trichy', 'vk.puram', 'Waiting', '2025-10-14 06:09:34'),
(25, 'Hari', 'vishnu', 'B+', 'Kidney', 'Kanyakumari', 'Theni', 'Waiting', '2025-10-14 06:09:34'),
(26, 'Rohan', 'keerthana', 'O+', 'Liver', 'Chennai', 'vk.puram', 'Waiting', '2025-10-14 06:09:34'),
(27, 'ravi', 'keerthana', 'O+', 'Liver', 'trichy', 'vk.puram', 'Waiting', '2025-10-14 06:10:42'),
(28, 'Hari', 'vishnu', 'B+', 'Kidney', 'Kanyakumari', 'Theni', 'Waiting', '2025-10-14 06:10:42'),
(29, 'Rohan', 'keerthana', 'O+', 'Liver', 'Chennai', 'vk.puram', 'Waiting', '2025-10-14 06:10:42');

-- --------------------------------------------------------

--
-- Table structure for table `recipients`
--

CREATE TABLE `recipients` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `age` int(11) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `blood_group` varchar(10) NOT NULL,
  `organ_needed` varchar(50) NOT NULL,
  `city` varchar(100) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  `message` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `recipients`
--

INSERT INTO `recipients` (`id`, `name`, `age`, `gender`, `blood_group`, `organ_needed`, `city`, `contact`, `status`, `message`) VALUES
(1, 'Haritha', 25, 'Female', 'A+', 'Kidney', 'Madurai', '8897654489', 'Accept', ''),
(2, 'vishnu', 24, 'Male', 'B+', 'Kidney', 'Theni', '95678432581', 'Waiting', ''),
(3, 'Vishal', 20, 'Male', 'AB+', 'Eyes', 'karur', '9673456123', 'Waiting', ''),
(4, 'joyal', 25, 'Male', 'O+', 'Eyes', 'Thanjavur', '9875634567', 'Waiting', ''),
(5, 'keerthana', 43, 'Female', 'O+', 'Liver', 'vk.puram', '9087645321', 'Waiting', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(37, 'keerthi', 'keerthi@gmail.com', '$2y$10$y8AdU5oioQUMLL7HFrM9Ve6twtepZ0ptRdH0nIoG3hp5qnR5PxqaC', '2025-09-19 09:16:33'),
(38, 'harini', 'harini@gmail.com', '$2y$10$qTZ6PjAWAx5cOwU0qfe6WenGpvOtHXm4oVCxIYXPL91n1/YvqzsTa', '2025-09-19 10:22:51'),
(39, 'alpha', 'alpha@gmail.com', '$2y$10$YHmrUylmqhLsyVmvB3Dp.uoSgcSFjPxOYY2YAHEjy7zMGsh/EbdYm', '2025-09-22 04:40:40'),
(40, 'ram', 'ram@gmail.com', '$2y$10$k.b6LigNh1qQSObnQilyrOkkPB7WwAoJoFWMuqxaqfoegElOgwaRy', '2025-09-26 04:35:56'),
(41, 'harinitha', 'harinitha@gmail.com', '$2y$10$E/VWljjc.ZHo/TFmXk54FOYqnOQ/M.Z6aWXpmPP4mK3OMyo6hBCdi', '2025-09-28 23:27:16'),
(42, 'adminster', 'adminster@gmail.com', '$2y$10$dWdxRJ.Ac4A5RxcyP/8KYOm0CY7xfgiRcGZOSMv74M1JZyycW4CUy', '2025-10-08 01:26:47'),
(43, 'haritha', 'haritha@gmail.com', '$2y$10$JSJiUm9DPW5t1jNn9NI7TOnbcnwkKQEW9jEP1e490XglVa0XP9fJe', '2025-10-14 06:06:57'),
(44, 'harini', 'harini@gamil.com', '$2y$10$CGA/8BL0qftgzc.Px8n7/.ienXe6yb97J4Y6OvL9Tdje2LDf8FSMy', '2025-10-14 06:29:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blood_donors`
--
ALTER TABLE `blood_donors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contactss`
--
ALTER TABLE `contactss`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `donors`
--
ALTER TABLE `donors`
  ADD PRIMARY KEY (`donor_id`);

--
-- Indexes for table `eye_donors`
--
ALTER TABLE `eye_donors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `heart_donors`
--
ALTER TABLE `heart_donors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kidney_donors`
--
ALTER TABLE `kidney_donors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `liver_donors`
--
ALTER TABLE `liver_donors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lungs_donors`
--
ALTER TABLE `lungs_donors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `matching`
--
ALTER TABLE `matching`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recipients`
--
ALTER TABLE `recipients`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `blood_donors`
--
ALTER TABLE `blood_donors`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `contactss`
--
ALTER TABLE `contactss`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `donors`
--
ALTER TABLE `donors`
  MODIFY `donor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `eye_donors`
--
ALTER TABLE `eye_donors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `heart_donors`
--
ALTER TABLE `heart_donors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kidney_donors`
--
ALTER TABLE `kidney_donors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `liver_donors`
--
ALTER TABLE `liver_donors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `lungs_donors`
--
ALTER TABLE `lungs_donors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `matching`
--
ALTER TABLE `matching`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `recipients`
--
ALTER TABLE `recipients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
