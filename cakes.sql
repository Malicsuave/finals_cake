-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 18, 2024 at 05:01 PM
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
-- Database: `cakes`
--

-- --------------------------------------------------------

--
-- Table structure for table `registered_user`
--

CREATE TABLE `registered_user` (
  `registered_Id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `birthday` date NOT NULL,
  `sex` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `user_profile_picture` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `account_type` int(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registered_user`
--

INSERT INTO `registered_user` (`registered_Id`, `username`, `firstname`, `lastname`, `birthday`, `sex`, `email`, `user_profile_picture`, `password`, `account_type`) VALUES
(5, 'unorawr', 'Uno', 'Valencia', '2024-06-17', 'Female', 'janinevalencian27@gmail.com', 'uploads/436786100_958613725511022_3871309330666312434_n.jpg', NULL, 0),
(6, 'unorawr', 'Uno', 'Valencia', '2024-06-17', 'Female', 'janinevalencian27@gmail.com', 'uploads/436786100_958613725511022_3871309330666312434_n_1718628756.jpg', NULL, 0),
(7, 'unorawr', 'Uno', 'Valencia', '2024-06-17', 'Female', 'janinevalencian27@gmail.com', 'uploads/436786100_958613725511022_3871309330666312434_n_1718628760.jpg', NULL, 0),
(8, 'unorawr', 'Uno', 'Valencia', '2024-06-13', 'Male', 'janinevalencian27@gmail.com', 'uploads/439755772_347062628375651_6956481040210101511_n.jpg', NULL, 0),
(17, 'user', 'Uno', 'Valencia', '2024-06-18', 'Male', 'user@gmail.com', 'uploads/C-lx2EFXYAEvE68_1718719904.jpg', '$2y$10$e.jA.H8lWCPf4IXBsxKGk.1rOggKJELjv18Lo9SEnLLOX5JGwqeWC', 0);

-- --------------------------------------------------------

--
-- Table structure for table `signup`
--

CREATE TABLE `signup` (
  `User_Id` int(11) NOT NULL,
  `account_type` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_profile_picture` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `signup`
--

INSERT INTO `signup` (`User_Id`, `account_type`, `username`, `email`, `password`, `user_profile_picture`) VALUES
(1, 0, 'Ivan', 'ivan@gmail.com', 'Ivanmalaki', NULL),
(2, 0, 'Gloria', 'glory@gmail.com', '$2y$10$VK2gmATL1ggtJ4pwtuqjSuzIpt3LdOC6sOYu5/SWOstF6u/hM4LZy', NULL),
(3, 0, 'uno', 'janinevalencian27@gmail.com', '$2y$10$OFQToxGLihy7HhBJIeQPxOs5M2ZKDCRjujxA1yGK/v1BRGJ6d/sYe', NULL),
(4, 0, 'unoo', 'janinevalencian27@gmail.com', '$2y$10$vTromPVtoJO97KMVPWPT5.DX6ByCbCeYf1bkySZ6AafA21WcBYj56', NULL),
(8, 0, 'Uno', 'Valencia', '2024-06-18', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_address`
--

CREATE TABLE `user_address` (
  `user_add_id` int(11) NOT NULL,
  `street` varchar(255) NOT NULL,
  `barangay` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `registered_Id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `registered_user`
--
ALTER TABLE `registered_user`
  ADD PRIMARY KEY (`registered_Id`);

--
-- Indexes for table `signup`
--
ALTER TABLE `signup`
  ADD PRIMARY KEY (`User_Id`);

--
-- Indexes for table `user_address`
--
ALTER TABLE `user_address`
  ADD PRIMARY KEY (`user_add_id`),
  ADD KEY `registered_Id` (`registered_Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `registered_user`
--
ALTER TABLE `registered_user`
  MODIFY `registered_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `signup`
--
ALTER TABLE `signup`
  MODIFY `User_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_address`
--
ALTER TABLE `user_address`
  MODIFY `user_add_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_address`
--
ALTER TABLE `user_address`
  ADD CONSTRAINT `user_address_ibfk_1` FOREIGN KEY (`registered_Id`) REFERENCES `registered_user` (`registered_Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
