-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 12, 2026 at 12:14 PM
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
-- Database: `marinetraders`
--

-- --------------------------------------------------------

--
-- Table structure for table `adminlo`
--

CREATE TABLE `adminlo` (
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adminlo`
--

INSERT INTO `adminlo` (`email`, `password`) VALUES
('rohannawani470@gmail.com', '2828'),
('rohannawani470@gmail.com', '2828'),
('rohan@mail.com', '123313'),
('rohan@gmail.com', '2828');

-- --------------------------------------------------------

--
-- Table structure for table `enqueryi`
--

CREATE TABLE `enqueryi` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `email` varchar(11) NOT NULL,
  `phone` varchar(250) NOT NULL,
  `product` varchar(250) NOT NULL,
  `message` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enqueryi`
--

INSERT INTO `enqueryi` (`id`, `name`, `email`, `phone`, `product`, `message`) VALUES
(1, '0', '0', '2147483647', '0', '0'),
(2, '0', '0', '2147483647', '0', '0'),
(3, 'Rohan nawani', 'rohannawani', '9712334903', 'Marine Circuit Breaker (MCB)', 'hiiii'),
(4, 'Rohan nawani', 'rohannawani', '9712334903', 'Power Distribution Model(Marine)', 'hiii');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `lastname` varchar(250) NOT NULL,
  `phone` varchar(250) NOT NULL,
  `confirmpassword` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `email`, `password`, `firstname`, `lastname`, `phone`, `confirmpassword`) VALUES
(1, 'rohannawani470@gmail.com', '1234', '', '', '', ''),
(2, 'rohannawani470@gmail.com', '12345', '', '', '9712334903', ''),
(3, '9999@gmail.com', '999999', '', '', '9999999999', ''),
(4, 'rohannawani470@gmail.com', '123', 'rohan', 'nawani', '9712334903', '123'),
(5, 'rohannawani470@gmail.com', '88888', '', '', '', ''),
(6, 'rohannawani470@gmail.com', 'rororoo', '', '', '', ''),
(7, 'rohannawani470@gmail.com', 'rohananan', '', '', '', ''),
(8, 'rohannawani470@gmail.com', '123', '', '', '', ''),
(9, 'rohannawani470@gmail.com', '222', '', '', '', ''),
(10, 'rohannawanibkjbjll@g.com', '222', '', '', '', ''),
(11, 'rohannawani470@gmail.com', '12454', '', '', '', ''),
(12, 'rohannakddll@gmail.com', '78899', '', '', '', ''),
(13, '9@gmail.com', '78899', '', '', '', ''),
(14, 'rohannawani470@gmail.com', '123', 'rohan', 'nawani', '9712334903', '123'),
(15, 'rohannawani470@gmail.com', '4545', 'rohan', 'nawani', '9712334903', '4545');

-- --------------------------------------------------------

--
-- Table structure for table `orderss`
--

CREATE TABLE `orderss` (
  `id` int(11) NOT NULL,
  `firstname` varchar(250) DEFAULT NULL,
  `lastname` varchar(250) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `city` varchar(250) DEFAULT NULL,
  `state` varchar(250) DEFAULT NULL,
  `pincode` varchar(10) DEFAULT NULL,
  `country` varchar(250) DEFAULT NULL,
  `productname` varchar(250) DEFAULT NULL,
  `qunatity` varchar(50) DEFAULT NULL,
  `payment` varchar(250) DEFAULT NULL,
  `notes` varchar(250) DEFAULT NULL,
  `productn` varchar(250) NOT NULL,
  `totalamount` varchar(250) NOT NULL,
  `orderstatus` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderss`
--

INSERT INTO `orderss` (`id`, `firstname`, `lastname`, `email`, `phone`, `address`, `city`, `state`, `pincode`, `country`, `productname`, `qunatity`, `payment`, `notes`, `productn`, `totalamount`, `orderstatus`) VALUES
(70, 'rohan', 'nawani', '', '9712334903', '', '', '', '', 'India', 'Marine Circuit Breaker (MCB)', '1', 'cod', '', 'Marine Circuit Breaker (MCB)', '2800', 'delivered'),
(71, 'parmar', 'jay', '', '9825936227', '', '', '', '', 'India', 'Ship Power Meter (Digital)', '1', 'cod', '', 'Ship Power Meter (Digital)', '9500', 'pending'),
(72, 'tota', 'jaypal', '', '9585697830', '', '', '', '', 'India', 'Marine Circuit Breaker (MCB)', '1', 'cod', '', 'Marine Circuit Breaker (MCB)', '2800', ''),
(73, 'diya', 'nawani', '', '9712334903', '', '', '', '', 'India', 'Ship Power Meter (Digital)', '1', 'cod', '', 'Ship Power Meter (Digital)', '9500', ''),
(74, 'mahendra', 'navani', '', '9712334903', '', '', '', '', 'India', 'Navigation Display Panel(HMI)', '1', 'cod', '', 'Navigation Display Panel(HMI)', '18000', ''),
(75, 'ahuja', 'avi', '', '9737616811', '', '', '', '', 'India', 'Power Distribution Model(Marine)', '1', 'cod', '', 'Power Distribution Model(Marine)', '12000', ''),
(76, 'mahendra', 'navani', '', '9712334903', '', '', '', '', 'India', 'Power Distribution Model(Marine)', '1', 'cod', '', 'Power Distribution Model(Marine)', '12000', ''),
(77, 'mahendra', 'navani', '', '9715334903', '', '', '', '', 'India', 'Power Distribution Model(Marine)', '1', 'cod', '', 'Power Distribution Model(Marine)', '12000', ''),
(78, 'niyati', 'navani', '', '9712334903', '', '', '', '', 'India', 'Navigation Display Panel(HMI)', '1', 'cod', '', 'Navigation Display Panel(HMI)', '18000', ''),
(79, 'kishan', 'chavda', '', '9712334903', '', '', '', '', 'India', 'Navigation Display Panel(HMI)', '1', 'cod', '', 'Navigation Display Panel(HMI)', '18000', ''),
(80, 'daksh', 'koladra', '', '9712334903', '', '', '', '', 'India', 'Ship Power Meter (Digital)', '1', 'cod', '', 'Ship Power Meter (Digital)', '9500', ''),
(81, 'meet', 'rathod', '', '982593227', '', '', '', '', 'India', 'Marine Circuit Breaker (MCB)', '1', 'cod', '', 'Marine Circuit Breaker (MCB)', '2800', ''),
(82, 'mahendra', 'navani', '', '9712334903', '', '', '', '', 'India', 'Marine Circuit Breaker (MCB)', '1', 'cod', '', 'Marine Circuit Breaker (MCB)', '2800', ''),
(83, 'hritik ', 'dubey', '', '9874563122', '', '', '', '', 'India', 'Marine Circuit Breaker (MCB)', '1', 'cod', '', 'Marine Circuit Breaker (MCB)', '2800', ''),
(84, '', '', '', '', '', '', '', '', 'India', 'Marine Circuit Breaker (MCB)', '1', 'cod', '', 'Marine Circuit Breaker (MCB)', '2800', ''),
(85, '', '', '', '', '', '', '', '', 'India', 'Marine Circuit Breaker (MCB)', '1', 'cod', '', 'Marine Circuit Breaker (MCB)', '2800', ''),
(87, '', '', '', '', '', '', '', '', 'India', 'Generator Control Module', '1', 'cod', '', 'Generator Control Module', '18000', ''),
(89, 'rohan', 'nawani', 'rohannawani470@gmail.com', '9712334903', 'rasala', 'bhavnagar', 'gujarat', '364001', 'India', 'Ship Power Meter (Digital)', '2', 'cod', 'hiiii', 'Ship Power Meter (Digital)', '19000', ''),
(90, 'rohan', 'nawani', 'rohannawani470@gamil.com', '9712334903', 'rasala', 'bhavnagar', 'gujarat', '364001', 'India', 'Ship Power Meter (Digital)', '2', 'select', 'hii', 'Ship Power Meter (Digital)', '19000', ''),
(91, 'rohan', 'nawani', 'rohannawani470@gamil.com', '9712334903', 'rasala', 'bhavnagar', 'gujarat', '364001', 'India', 'Ship Power Meter (Digital)', '2', 'cod', 'hii', 'Ship Power Meter (Digital)', '19000', ''),
(92, '', '', '', '', '', '', '', '', 'India', '', '1', 'select', '', '', '', ''),
(93, 'mahendra', 'navani', 'mahendranavani111@gmail.com', '', 'rasala', '', '', '', 'India', 'Navigation Display Panel(HMI)', '1', 'select', '', 'Navigation Display Panel(HMI)', '18000', ''),
(94, 'mahendra', 'navani', 'mahendranavani111@gmail.com', '9712334903', 'rasala', 'bhavnagar', 'gujarat', '364001', 'India', 'Navigation Display Panel(HMI)', '1', 'online', '', 'Navigation Display Panel(HMI)', '18000', ''),
(97, '', '', '', '', '', '', '', '', 'India', 'Mak Piston(551)', '1', 'select', '', 'Mak Piston(551)', '51000', ''),
(98, 'mahendra', 'navani', 'mahendranavani111@gmail.com', '9712334903', '', '', '', '', 'India', 'Mak Piston(551)', '1', 'select', '', 'Mak Piston(551)', '51000', ''),
(99, 'mahendra', 'navani', 'mahendranavani111@gmail.com', '9712334903', '', '', '', '', 'India', 'Mak Piston(551)', '1', 'select', '', 'Mak Piston(551)', '51000', ''),
(100, 'mahendra', 'navani', 'mahendranavani111@gmail.com', '9712334903', '', '', '', '', 'India', 'Mak Piston(551)', '1', 'online', '', 'Mak Piston(551)', '51000', ''),
(101, 'mahendra', 'navani', 'mahendranavani111@gmail.com', '9712334903', '', '', '', '', 'India', 'Mak Piston(551)', '1', 'cod', '', 'Mak Piston(551)', '51000', ''),
(102, '', '', '', '', '', '', '', '', 'India', 'Marine Circuit Breaker (MCB)', '1', 'online', '', 'Marine Circuit Breaker (MCB)', '2800', ''),
(103, '', '', '', '', '', '', '', '', 'India', 'Marine Circuit Breaker (MCB)', '1', 'online', '', 'Marine Circuit Breaker (MCB)', '2800', ''),
(104, '', '', '', '', '', '', '', '', 'India', 'Power Distribution Model(Marine)', '1', 'online', '', 'Power Distribution Model(Marine)', '12000', ''),
(105, '', '', '', '', '', '', '', '', 'India', 'Power Distribution Model(Marine)', '1', 'online', '', 'Power Distribution Model(Marine)', '12000', ''),
(106, '', '', '', '', '', '', '', '', 'India', 'Power Distribution Model(Marine)', '1', 'online', '', 'Power Distribution Model(Marine)', '12000', ''),
(107, '', '', '', '', '', '', '', '', 'India', 'Power Distribution Model(Marine)', '1', 'online', '', 'Power Distribution Model(Marine)', '12000', ''),
(108, 'mahendra', 'navani', 'mahendranavani111@gmail.com', '9712334903', 'rasala', 'bhavnagar', 'gujarat', '364001', 'India', 'Power Distribution Model(Marine)', '1', 'select', '', 'Power Distribution Model(Marine)', '12000', ''),
(109, 'mahendra', 'navani', 'mahendranavani111@gmail.com', '9712334903', 'rasala', 'bhavnagar', 'gujarat', '364001', 'India', 'Marine MCCB(Heavy Duty)', '1', 'online', '', 'Marine MCCB(Heavy Duty)', '14500', ''),
(110, 'mahendra', 'navani', 'mahendranavani111@gmail.com', '9712334903', 'rasala', 'bhavnagar', 'gujarat', '364001', 'India', 'Marine MCCB(Heavy Duty)', '1', 'online', '', 'Marine MCCB(Heavy Duty)', '14500', ''),
(111, 'mahendra', 'navani', 'mahendranavani111@gmail.com', '9712334903', 'rasala', 'bhavnagar', 'gujarat', '364001', 'India', 'Marine MCCB(Heavy Duty)', '1', 'online', 'hiiii', 'Marine MCCB(Heavy Duty)', '14500', ''),
(112, 'mahendra', 'navani', 'mahendranavani111@gmail.com', '9712334903', 'rasala', 'bhavnagar', 'gujarat', '364001', 'India', 'Marine MCCB(Heavy Duty)', '1', 'online', 'hiiii', 'Marine MCCB(Heavy Duty)', '14500', ''),
(113, 'mahendra', 'navani', 'mahendranavani111@gmail.com', '9712334903', 'rasala', 'bhavnagar', 'gujarat', '364001', 'India', 'Marine MCCB(Heavy Duty)', '1', 'online', 'kk', 'Marine MCCB(Heavy Duty)', '14500', ''),
(114, 'mahendra', 'navani', 'mahendranavani111@gmail.com', '9712334903', 'rasala', 'bhavnagar', 'gujarat', '364001', 'India', 'Valves(VP0106)', '1', 'online', 'hiii', 'Valves(VP0106)', '1500', '');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(250) NOT NULL,
  `img` varchar(250) NOT NULL,
  `title` varchar(250) NOT NULL,
  `mrp` int(250) NOT NULL,
  `saleprice` int(250) NOT NULL,
  `stock` int(250) NOT NULL,
  `category` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `img`, `title`, `mrp`, `saleprice`, `stock`, `category`) VALUES
(1, 'upload/P2.jpg', 'Marine Circuit Breaker (MCB)', 3400, 2800, 10, 'marine'),
(2, 'upload/P4.jpg', 'Ship Power Meter (Digital)', 12000, 9500, 10, 'marine'),
(3, 'upload/P5.jpg', 'Navigation Display Panel(HMI)', 25000, 18000, 6, 'marine'),
(4, 'upload/P7.jpg', 'Power Distribution Model(Marine)', 15000, 12000, 5, 'marine'),
(5, 'upload/P8.jpg', 'Generator Control Module', 22000, 18000, 8, 'marine'),
(6, 'upload/P10.jpg', 'Marine MCCB(Heavy Duty)', 10000, 14500, 7, 'marine'),
(7, 'upload/P11.jpg', 'Switchboard Bus Coupler', 9500, 7500, 8, 'marine'),
(8, 'upload/WIRING.jpg', 'Wiring Cable For Power Supply', 2000, 1500, 2, 'marine'),
(9, 'upload/piston.jpeg', 'Mak Piston(551)', 60000, 51000, 4, 'marine'),
(10, 'upload/rod.jpeg', 'Connecting Rod(CR)', 10000, 16000, 2, 'marine'),
(11, 'upload/Marine-Pumps.jpeg', 'Pump(P56)', 10000, 6000, 4, 'marine'),
(12, 'upload/cr.jpg', 'Crankshaft(CF001)', 9500, 5000, 9, 'marine'),
(13, 'upload/st.jpeg', 'Turbo Charger(TCI)', 30000, 25000, 6, 'marine'),
(14, 'upload/valves.jpeg', 'Valves(VP0106)', 2000, 1500, 8, 'marine'),
(15, 'upload/Box cooler.jpeg', 'Box Cooler(500)', 9500, 7500, 9, 'marine'),
(16, 'upload/ship m.jpeg', 'Flow Meter(FM)', 15000, 12000, 7, 'marine');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `enqueryi`
--
ALTER TABLE `enqueryi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orderss`
--
ALTER TABLE `orderss`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `enqueryi`
--
ALTER TABLE `enqueryi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `orderss`
--
ALTER TABLE `orderss`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
