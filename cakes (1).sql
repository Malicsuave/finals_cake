-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 26, 2024 at 05:45 AM
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
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `Carts_Id` int(11) NOT NULL,
  `User_Id` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'pending',
  `quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `checkout`
--

CREATE TABLE `checkout` (
  `checkout_Id` int(11) NOT NULL,
  `User_Id` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `checkout_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `quantity` int(11) NOT NULL DEFAULT 1,
  `Product_Id` int(11) DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `checkout`
--

INSERT INTO `checkout` (`checkout_Id`, `User_Id`, `total_price`, `checkout_date`, `quantity`, `Product_Id`, `status`) VALUES
(1, 28, 1000.00, '2024-06-24 16:10:33', 1, NULL, 'complete'),
(2, 28, 9400.00, '2024-06-25 07:21:52', 1, NULL, 'pending'),
(3, 28, 4500.00, '2024-06-25 07:22:30', 1, NULL, 'complete'),
(4, 28, 500.00, '2024-06-25 07:34:29', 1, NULL, 'pending'),
(5, 29, 42100.00, '2024-06-25 15:33:13', 1, NULL, 'pending'),
(6, 29, 4500.00, '2024-06-25 15:54:49', 1, NULL, 'pending'),
(7, 28, 1000.00, '2024-06-24 16:10:33', 1, NULL, 'complete'),
(8, 28, 9400.00, '2024-06-25 07:21:52', 1, NULL, 'pending'),
(9, 28, 4500.00, '2024-06-25 07:22:30', 1, NULL, 'pending'),
(10, 28, 500.00, '2024-06-25 07:34:29', 1, NULL, 'pending'),
(11, 29, 42100.00, '2024-06-25 15:33:13', 1, NULL, 'complete'),
(12, 29, 4500.00, '2024-06-25 15:54:49', 1, NULL, 'pending'),
(13, 29, 9000.00, '2024-06-25 16:15:38', 1, NULL, 'complete'),
(14, 29, 1000.00, '2024-06-25 18:19:55', 1, NULL, 'complete'),
(15, 29, 500.00, '2024-06-25 18:45:59', 1, NULL, 'pending'),
(16, 35, 500.00, '2024-06-25 20:45:35', 1, NULL, 'pending'),
(17, 35, 9000.00, '2024-06-25 20:46:53', 1, NULL, 'complete'),
(18, 35, 5000.00, '2024-06-25 20:53:37', 1, NULL, 'pending'),
(19, 35, 9000.00, '2024-06-25 22:33:25', 1, NULL, 'complete'),
(20, 35, 500.00, '2024-06-25 23:46:33', 1, NULL, 'complete');

-- --------------------------------------------------------

--
-- Table structure for table `delivery`
--

CREATE TABLE `delivery` (
  `delivery_id` int(11) NOT NULL,
  `User_Id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `status` varchar(50) DEFAULT 'In-Transit',
  `checkout_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery`
--

INSERT INTO `delivery` (`delivery_id`, `User_Id`, `fullname`, `email`, `phone`, `address`, `status`, `checkout_date`) VALUES
(1, 35, 'Rey Willard ', 'reywillardd01@gmail.com', '09777726493', 'SIco, Lipa City', '', '2024-06-25 22:09:43'),
(2, 35, 'Rey Willard ', 'reywillardd01@gmail.com', '09777726493', 'SIco, Lipa City', 'Delivered', '2024-06-25 22:16:05'),
(7, 35, 'Rey Willard R. Malicse', 'admin@gmail.com', '09563434353', 'adfdsafadsfdsafdsaf', 'Delivered', '2024-06-25 22:38:18'),
(8, 35, 'Rey Willard R. Malicse', 'rey@gmail.com', '093434532423', 'Sico, Lipa City', 'Delivered', '2024-06-25 23:46:54');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `message_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `concern` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `full_name`, `email`, `subject`, `concern`, `created_at`) VALUES
(1, 'Rey Willard', 'reywillard@gmail.com', 'issue', 'expired cake', '2024-06-23 01:15:32');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `productName` varchar(255) NOT NULL,
  `productPrice` decimal(10,2) NOT NULL,
  `productTheme` varchar(255) DEFAULT NULL,
  `productImage` varchar(255) DEFAULT NULL,
  `productStock` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `productName`, `productPrice`, `productTheme`, `productImage`, `productStock`, `created_at`) VALUES
(3, 'Big Cake', 500.00, 'Birthday Cake', 'uploads/1.png', 1, '2024-06-23 05:14:19'),
(4, '4 Tier Cake', 4500.00, 'New Cake Deign', 'uploads/2.png', 1, '2024-06-24 13:24:01'),
(5, 'Wedding Cake', 5000.00, 'Rustic', 'uploads/3.png', 0, '2024-06-24 13:27:40'),
(6, 'Debut', 4700.00, '18th Birthday', 'uploads/4.png', 0, '2024-06-24 13:37:12'),
(7, 'Sample Cake', 5000.00, 'Rustic', 'uploads/2.png', 1, '2024-06-25 12:14:08'),
(8, 'Cake', 5000.00, 'Anniversary', 'uploads/1.png', 1, '2024-06-25 12:14:36'),
(9, 'Sample ', 5000.00, 'Sample', 'uploads/1.png', 1, '2024-06-25 12:22:42');

-- --------------------------------------------------------

--
-- Table structure for table `proof_of_payment`
--

CREATE TABLE `proof_of_payment` (
  `transaction_id` int(11) NOT NULL,
  `transaction_number` varchar(100) NOT NULL,
  `upload_photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `User_Id` int(11) NOT NULL,
  `account_type` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `birthday` date DEFAULT NULL,
  `sex` varchar(255) NOT NULL,
  `contact_info` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_profile_picture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`User_Id`, `account_type`, `username`, `password`, `firstname`, `lastname`, `birthday`, `sex`, `contact_info`, `user_email`, `user_profile_picture`) VALUES
(1, 1, 'Mickey', 'Mouse', '', '', NULL, '', '', '', ''),
(2, 0, 'Cheese', 'Hotdog', '', '', NULL, '', '', '', ''),
(3, 0, 'Foot', 'Long', '', '', NULL, '', '', '', ''),
(12, 0, 'Rey', 'pass', 'Rey', 'Malicse', '2002-03-03', 'male', '', '', ''),
(14, 0, 'anakniluka', 'mavs', 'dj', 'aquino', '2003-09-27', 'male', '', '', ''),
(21, 1, 'rey1', '$2y$10$PJXnifnJlFv4o5DxoC5G3esf7DmpRo8BNfmahFr1RxYaq3cjfgm4i', 'Rey ', 'Malicse', '2002-03-03', 'Male', '', 'reywillardd01@gmail.com', 'uploads/profile pic_1716340929.jpg'),
(23, 0, 'Rey_W', '$2y$10$ZMFMvEoVvo9bza25XfuCserQ9dtrh93TzLE59/0bVu0fsgBCW5ow.', 'Rey Willard ', 'Malicse', '2002-03-30', 'Male', '', 'malicsuave@gmail.com', 'uploads/gettyimages-490703338.jpg'),
(24, 1, 'malicsuave', '$2y$10$keBynbf8p7mQTn4htB4zRO4jhuvMPwfXBCc6FXjIKDVEP65jtpFHC', 'John', 'Doe', '1232-03-12', 'Male', '', 'you@gmail.com', 'uploads/OIP_1716447605.jpg'),
(25, 0, 'username', 'Lolzz1230', '', '', NULL, '', '', 'username@gmail.com', ''),
(26, 0, 'name', 'Lolzz1230', '', '', NULL, '', '', 'name@gmail.com', ''),
(27, 0, 'new', '$2y$10$w42JtXoRangrZT6.UwIlhuc/GNltJteLPhsmfEJhyJnv78vI3Xf8q', 'new', 'new', '2002-03-01', 'Male', '', 'new@gmail.com', 'uploads/3490883874_08a361fec8_b_1718930045.jpg'),
(28, 1, 'admin', '$2y$10$pAKsBrKzJH7ZfLTxD6bG1.e4Tt2HeSCzp1WF6wUMYRxKKm1WowM7C', 'admin', 'admin', '2001-01-01', 'Male', '', 'admin@gmail.com', 'uploads/3490883874_08a361fec8_b.jpg'),
(29, 0, 'John', '$2y$10$oGmehphQ7ugHk3U/GAJqDeUMwfCfjX33pHFbyLKuPG1ddk8exA51K', 'John', 'Doe', '2002-02-19', 'Female', '', 'Doe@gmail.com', 'uploads/3490883874_08a361fec8_b_1719075580.jpg'),
(30, 1, 'Jane ', '$2y$10$B1KElGTav6D8L0f27dW96OyL/X8QnneOb2eLG7FXB3SnlM4XBw8Gm', 'jane', 'doe', '2002-01-01', 'Male', '', 'janedoe@gmail.com', 'uploads/3490883874_08a361fec8_b_1719092566.jpg'),
(31, 0, '$2y$10$YnMdjLEWz53FCdW7X8VK2uzz9.5OvfCH.7.jN0D.jNFjrxXP1CDSu', '09777726604', 'Ivan', 'Malaki', '2001-01-01', 'Male', 'ivan', 'ivan@gmail.com', 'uploads/360_F_362562495_Gau0POzcwR8JCfQuikVUTqzMFTo78vkF_1719345410.jpg'),
(32, 0, '$2y$10$aQ4BHk.CaTJsWd7WCa9fgumCem6PIsKXOG/z2B92HQqL0vDOWZ0ke', '095653243245', 'Ivan', 'macapagal', '2001-01-01', 'Male', 'Ivan', 'ivan@gmail.com', 'uploads/360_F_362562495_Gau0POzcwR8JCfQuikVUTqzMFTo78vkF_1719345481.jpg'),
(33, 0, '$2y$10$RzzyXUDx0TAOkGCowl8vtOMbLv9UbTUBjgkvKLP791PWhSDtHNRMO', '0966445454554', 'sample', 'sample', '2001-01-01', 'Male', 'sample', 'sample@gmail.com', 'uploads/360_F_362562495_Gau0POzcwR8JCfQuikVUTqzMFTo78vkF_1719346166.jpg'),
(34, 0, 'Sarah', 'Banks', '2000-12-09', 'Male', '0000-00-00', 'Banks@gmail.com', '$2y$10$pJfOq4V6uUAeRfg6tajjjuy/YI.Py.JWPVf5pme135nObEN0vQXIy', '0966653453434', 'uploads/360_F_362562495_Gau0POzcwR8JCfQuikVUTqzMFTo78vkF_1719346413.jpg'),
(35, 1, 'Vayne', '$2y$10$Vdsdd8jZsZtDlcXmq3Hafu0q7F/jqz6bvlfSaitFpKlbzAFMhRoP6', 'Janna', 'Town', '0000-00-00', '2002-02-03', '095654545454', 'Vayne@gmail.com', 'uploads/360_F_362562495_Gau0POzcwR8JCfQuikVUTqzMFTo78vkF_1719346694.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `user_address`
--

CREATE TABLE `user_address` (
  `user_add_id` int(11) NOT NULL,
  `User_Id` int(11) DEFAULT NULL,
  `street` varchar(255) NOT NULL,
  `barangay` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_address`
--

INSERT INTO `user_address` (`user_add_id`, `User_Id`, `street`, `barangay`, `city`, `province`) VALUES
(7, 21, 'Purok 1', 'Sico', 'Lipa City', 'Region IV-A (CALABARZON)'),
(9, 23, '123', 'San Rafael (Idiang)', 'Itbayat', 'Batanes'),
(10, 24, '123', 'Sico', 'Lipa City', 'Region IV-A (CALABARZON)'),
(11, 27, '123', 'San Pedro I (Eastern)', 'Malvar', 'Region IV-A (CALABARZON)'),
(12, 28, '123', 'Lower Tablas', 'Tuburan', 'Autonomous Region in Muslim Mindanao (ARMM)'),
(13, 29, '123', 'Cuevas', 'Trento', 'Region XIII (Caraga)'),
(14, 30, '123', 'Ulitan', 'Ungkaya Pukan', 'Autonomous Region in Muslim Mindanao (ARMM)'),
(15, 31, '123', 'Limbo-Upas', 'Tipo-tipo', 'Autonomous Region in Muslim Mindanao (ARMM)'),
(16, 32, '123', 'Concepcion', 'Calintaan', 'MIMAROPA'),
(17, 33, '123', 'Ilayang Bayucain', 'Majayjay', 'Region IV-A (CALABARZON)'),
(18, 34, '123', 'Sapa', 'Samal', 'Region III (Central Luzon)'),
(19, 35, '123', 'San Rafael IV', 'Noveleta', 'Region IV-A (CALABARZON)');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`Carts_Id`),
  ADD KEY `User_Id` (`User_Id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `checkout`
--
ALTER TABLE `checkout`
  ADD PRIMARY KEY (`checkout_Id`),
  ADD KEY `User_Id` (`User_Id`),
  ADD KEY `fk_checkout_product` (`Product_Id`);

--
-- Indexes for table `delivery`
--
ALTER TABLE `delivery`
  ADD PRIMARY KEY (`delivery_id`),
  ADD KEY `User_Id` (`User_Id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `proof_of_payment`
--
ALTER TABLE `proof_of_payment`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`User_Id`),
  ADD KEY `idx_User_Id` (`User_Id`),
  ADD KEY `idx_User_Id_New` (`User_Id`),
  ADD KEY `idx_Users_Id` (`User_Id`);

--
-- Indexes for table `user_address`
--
ALTER TABLE `user_address`
  ADD PRIMARY KEY (`user_add_id`),
  ADD KEY `User_Id` (`User_Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `Carts_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `checkout`
--
ALTER TABLE `checkout`
  MODIFY `checkout_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `delivery`
--
ALTER TABLE `delivery`
  MODIFY `delivery_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `proof_of_payment`
--
ALTER TABLE `proof_of_payment`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `User_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `user_address`
--
ALTER TABLE `user_address`
  MODIFY `user_add_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`User_Id`) REFERENCES `users` (`User_Id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_ibfk_2` FOREIGN KEY (`id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `checkout`
--
ALTER TABLE `checkout`
  ADD CONSTRAINT `checkout_ibfk_1` FOREIGN KEY (`User_Id`) REFERENCES `users` (`User_Id`),
  ADD CONSTRAINT `fk_checkout_product` FOREIGN KEY (`Product_Id`) REFERENCES `products` (`id`);

--
-- Constraints for table `delivery`
--
ALTER TABLE `delivery`
  ADD CONSTRAINT `delivery_ibfk_1` FOREIGN KEY (`User_Id`) REFERENCES `users` (`User_Id`);

--
-- Constraints for table `user_address`
--
ALTER TABLE `user_address`
  ADD CONSTRAINT `user_address_ibfk_1` FOREIGN KEY (`User_Id`) REFERENCES `users` (`User_Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
