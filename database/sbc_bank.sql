-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2021 at 08:46 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sbc bank`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(100) NOT NULL,
  `name` varchar(50) NOT NULL,
  `account_num` varchar(20) NOT NULL,
  `IFSC_Code` varchar(10) NOT NULL,
  `email` varchar(40) NOT NULL,
  `contact_num` varchar(15) NOT NULL,
  `location` varchar(30) NOT NULL,
  `State` varchar(20) NOT NULL,
  `current_balance` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `name`, `account_num`, `IFSC_Code`, `email`, `contact_num`, `location`, `State`, `current_balance`) VALUES
(1, 'Rhythm Sharma', '601004183', 'SBCI100401', 'srhythm2020@gmail.com', '8708537023', 'Kurukshetra', 'Haryana', 209349.67),
(3, 'Ishwar Baisla', '601003097', 'SBCI100301', 'ishwar2303@gmail.com', '9821671707', 'Delhi', 'New Delhi', 159781.09),
(4, 'Tapas Baranwal', '601004204', 'SBCI100402', 'tapasbaranal@gmail.com', '9017527234', 'Gurgaon', 'Haryana', 194167.76),
(5, 'Pankaj Gautam', '601001169', 'SBCI100101', 'pankajg@gmail.com', '7088360659', 'Ghaziabad', 'Uttar Pradesh', 281894.65),
(11, 'Swati Bharadwaj', '601001193', 'SBCI100102', 'swati@gmail.com', '9084812963', 'Agra', 'Uttar Pradesh', 100006.01),
(13, 'Marut Nandan', '601005131', 'SBCI100501', 'marutnandan@gmail.com', '9128386811', 'Patna', 'Bihar', 55002.54),
(14, 'Akshay Mathur', '601006011', 'SBCI100601', 'akshay@gmail.com', '9588265971', 'Jodhpur', 'Rajasthan', 83500),
(15, 'Anjali Joseph', '601007300', 'SBCI10073', 'anjalij@orkut.com', '7985327643', 'Chennai', 'Tamil Nadu', 1353689),
(16, 'Pragati Rathor', '601008001', 'SBCI10082', 'rathor12@gmail.com', '7088360601', 'Pune', 'Maharashtra', 929698.34),
(17, 'Kishan Khatri', '601009005', 'SBCI10096', 'khkishan@gmail.com', '9876543676', 'Chandigarh', 'Punjab', 72567.09),
(18, 'Sakshi Malik', '601006854', 'SBCI100456', 'sakshimalik23@gmail.com', '6365654585', 'Meerut', 'Uttar Pradesh', 12298.56);

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `Eid` int(11) NOT NULL,
  `Ename` varchar(50) NOT NULL,
  `Eemail` varchar(60) NOT NULL,
  `Epass` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`Eid`, `Ename`, `Eemail`, `Epass`) VALUES
(1, 'Jatin Kumar', 'jatink220@gmail.com', 'jkjatin27');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `sender_acc_num` varchar(20) NOT NULL,
  `recipient_acc_num` varchar(20) NOT NULL,
  `amount` double NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `sender_acc_num`, `recipient_acc_num`, `amount`, `timestamp`) VALUES
(820, '601003097', '601001169', 50000, '2021-04-18 14:21:20'),
(821, '601003097', '601004204', 4000, '2021-04-18 14:24:26'),
(822, '601003097', '601007300', 65000, '2021-05-17 16:41:49'),
(823, '601006854', '601006011', 500, '2021-05-17 16:44:29'),
(824, '601004183', '601006854', 1000, '2021-05-17 17:05:50'),
(825, '601004183', '601004204', 10000, '2021-05-18 11:11:45'),
(836, '601004183', '601003097', 12000, '2021-05-18 11:27:03'),
(837, '601003097', '601001169', 1000, '2021-05-18 11:28:43'),
(838, '601004183', '601007300', 1000, '2021-05-18 12:39:05'),
(839, '601003097', '601004183', 5200, '2021-05-18 13:27:57'),
(840, '601003097', '601004183', 2500, '2021-05-18 13:51:42'),
(841, '601004183', '601003097', 10025, '2021-05-18 14:02:25'),
(843, '601009005', '601008001', 26000, '2021-05-20 18:02:45'),
(844, '601006854', '601008001', 58056, '2021-05-20 18:43:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`Eid`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `Eid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=845;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
