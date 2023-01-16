-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 28, 2022 at 02:58 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbpharmacy`
--

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int(11) NOT NULL,
  `Name` longtext NOT NULL,
  `Email` longtext NOT NULL,
  `Date_joined` date NOT NULL,
  `Salary` float NOT NULL,
  `Shifts` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `Name`, `Email`, `Date_joined`, `Salary`, `Shifts`) VALUES
(2, 'Kyron', 'abc@gmail.com', '2022-11-15', 1000, 'Morning Shift');

-- --------------------------------------------------------

--
-- Table structure for table `tblmedicine`
--

CREATE TABLE `tblmedicine` (
  `DrugID` int(11) NOT NULL,
  `drug_image_id` int(11) NOT NULL,
  `drugName` varchar(255) NOT NULL,
  `scientificName` varchar(255) NOT NULL,
  `drugDosage` int(11) NOT NULL,
  `drugCategory` varchar(255) NOT NULL,
  `storageTemperature` int(11) NOT NULL,
  `no_of_unit_in_package` int(11) NOT NULL,
  `manufacturer` varchar(255) NOT NULL,
  `unitPrice` float NOT NULL,
  `storageLocation` varchar(255) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'T'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblmedicine`
--

INSERT INTO `tblmedicine` (`DrugID`, `drug_image_id`, `drugName`, `scientificName`, `drugDosage`, `drugCategory`, `storageTemperature`, `no_of_unit_in_package`, `manufacturer`, `unitPrice`, `storageLocation`, `status`) VALUES
(1, 1, 'LORATADINE', 'LORATADINE', 10, 'ANTIHISTAMINES & ANTIALLERGICS', 30, 30, 'PHARMANIAGA', 10, 'ROOM', 'T'),
(2, 2, 'LEVOCETIRIZINE', 'LEVOCETIRIZINE', 5, 'ANTIHISTAMINES & ANTIALLERGICS', 30, 30, 'GLENMARK', 30, 'ROOM', 'T'),
(3, 3, 'PANADOL', 'PANADOL', 650, 'ANALGESICS AND ANTIPYRETICS', 30, 50, 'PHARMANIAGA', 30, 'ROOM', 'T');

-- --------------------------------------------------------

--
-- Table structure for table `tblmedicine_image`
--

CREATE TABLE `tblmedicine_image` (
  `drug_image_id` int(11) NOT NULL,
  `image_path` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblmedicine_image`
--

INSERT INTO `tblmedicine_image` (`drug_image_id`, `image_path`) VALUES
(1, 'LORA10MGcopy26-11-22_10_20_39.png'),
(2, 'levocetirizine26-11-22_10_21_50.jpg'),
(3, '6d273b1b421dfde3c925719adcb6831226-11-22_10_22_29.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `tblpurchase_invoice`
--

CREATE TABLE `tblpurchase_invoice` (
  `purchaseInvoiceID` int(11) NOT NULL,
  `purchaseDate` datetime NOT NULL,
  `drugID` longtext NOT NULL,
  `drugBatchNo` longtext NOT NULL,
  `drugQty` longtext NOT NULL,
  `drugPrice` longtext NOT NULL,
  `tax` varchar(255) NOT NULL,
  `totalAmount` float NOT NULL,
  `paymentType` enum('Cash') NOT NULL,
  `discount` int(11) NOT NULL,
  `paidAmount` float NOT NULL,
  `remainingAmount` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblpurchase_invoice`
--

INSERT INTO `tblpurchase_invoice` (`purchaseInvoiceID`, `purchaseDate`, `drugID`, `drugBatchNo`, `drugQty`, `drugPrice`, `tax`, `totalAmount`, `paymentType`, `discount`, `paidAmount`, `remainingAmount`) VALUES
(1, '2022-11-26 23:47:04', 'PANADOL', 'PANA1', '6', '30', '6:10.80', 190.8, 'Cash', 0, 200, 9.2),
(2, '2022-11-26 23:47:15', 'LORATADINE:LORATADINE:LEVOCETIRIZINE', 'LORA1:LORA2:LEVO1', '10:2:3', '10:10:30', '6:12.60', 222.6, 'Cash', 0, 250, 27.4),
(3, '2022-11-26 23:47:46', 'LEVOCETIRIZINE', 'LEVO1', '6', '30', '6:10.80', 190.8, 'Cash', 0, 200, 9.2),
(4, '2022-11-26 23:47:53', 'LEVOCETIRIZINE:LORATADINE:LORATADINE:PANADOL', 'LEVO1:LORA1:LORA2:PANA1', '1:0:2:1', '30:10:10:30', '6:4.80', 84.8, 'Cash', 0, 90, 5.2),
(5, '2022-11-27 00:01:58', 'LORATADINE:LORATADINE', 'LORA1:LORA2', '0:1', '10:10', '6:0.60', 10.6, 'Cash', 0, 11, 0.4),
(6, '2022-11-27 00:05:25', 'LEVOCETIRIZINE', 'LEVO1', '1', '30', '6:1.80', 31.8, 'Cash', 0, 32, 0.2),
(7, '2022-11-27 00:06:31', 'PANADOL', 'PANA1', '1', '30', '6:1.80', 31.8, 'Cash', 0, 32, 0.2),
(8, '2022-11-27 00:06:51', 'PANADOL', 'PANA1', '1', '30', '6:1.80', 31.8, 'Cash', 0, 50, 18.2),
(9, '2022-11-27 01:05:10', 'LORATADINE:LORATADINE', 'LORA1:LORA2', '0:5', '10:10', '6:3.00', 53, 'Cash', 0, 55, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tblstored_drug`
--

CREATE TABLE `tblstored_drug` (
  `batchNo` longtext NOT NULL,
  `DrugID` int(11) NOT NULL,
  `manufacturerDate` date NOT NULL,
  `expiryDate` date NOT NULL,
  `quantity` int(11) NOT NULL,
  `entryDate` datetime NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'T'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblstored_drug`
--

INSERT INTO `tblstored_drug` (`batchNo`, `DrugID`, `manufacturerDate`, `expiryDate`, `quantity`, `entryDate`, `status`) VALUES
('LEVO1', 2, '2022-11-26', '2022-12-01', 89, '2022-11-26 22:23:52', 'T'),
('LORA1', 1, '2022-11-26', '2023-01-01', 0, '2022-11-26 22:24:20', 'T'),
('PANA1', 3, '2022-11-26', '2022-12-09', 0, '2022-11-26 22:24:34', 'T'),
('LORA2', 1, '2022-11-26', '2023-04-01', 90, '2022-11-26 22:25:07', 'T');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `roleID` int(55) UNSIGNED DEFAULT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Date_joined` date DEFAULT NULL,
  `Salary` float DEFAULT NULL,
  `Shifts` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `roleID`, `Name`, `Date_joined`, `Salary`, `Shifts`) VALUES
(1, 'admin@gmail.com', '37d8f7239f12b52bd7615a470aaa9bc7', 1, NULL, NULL, NULL, NULL),
(2, 'abcd@gmail.com', '37d8f7239f12b52bd7615a470aaa9bc7', 2, NULL, NULL, NULL, NULL),
(3, 'abcde@gmail.com', '37d8f7239f12b52bd7615a470aaa9bc7', 3, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblmedicine`
--
ALTER TABLE `tblmedicine`
  ADD UNIQUE KEY `DrugID` (`DrugID`);

--
-- Indexes for table `tblmedicine_image`
--
ALTER TABLE `tblmedicine_image`
  ADD PRIMARY KEY (`drug_image_id`);

--
-- Indexes for table `tblpurchase_invoice`
--
ALTER TABLE `tblpurchase_invoice`
  ADD PRIMARY KEY (`purchaseInvoiceID`);

--
-- Indexes for table `tblstored_drug`
--
ALTER TABLE `tblstored_drug`
  ADD UNIQUE KEY `batchNo` (`batchNo`) USING HASH;

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblmedicine`
--
ALTER TABLE `tblmedicine`
  MODIFY `DrugID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblmedicine_image`
--
ALTER TABLE `tblmedicine_image`
  MODIFY `drug_image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblpurchase_invoice`
--
ALTER TABLE `tblpurchase_invoice`
  MODIFY `purchaseInvoiceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
