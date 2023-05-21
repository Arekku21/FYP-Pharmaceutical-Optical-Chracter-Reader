-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2023 at 06:45 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

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
  `Shifts` longtext NOT NULL,
  `role` int(13) NOT NULL,
  `status` int(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `Name`, `Email`, `Date_joined`, `Salary`, `Shifts`, `role`, `status`) VALUES
(2, 'Kyron L', 'abc@gmail.com', '2022-11-15', 1008, 'Morning Shift', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `email` varchar(90) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT current_timestamp(),
  `role` int(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `email`, `action`, `date`, `role`) VALUES
(2, 'admin@admin.com', 'User logged in', '2023-04-15 11:10:42', 1),
(4, 'admin@admin.com', 'User logged in', '2023-04-15 11:13:43', 1),
(6, 'admin@admin.com', 'User logged in', '2023-04-15 11:14:45', 1),
(8, 'admin@admin.com', 'User logged in', '2023-04-15 11:15:09', 1),
(10, 'admin@admin.com', 'User logged in', '2023-04-15 11:15:24', 1),
(12, 'admin@admin.com', 'User logged in', '2023-04-15 11:25:50', 1),
(13, 'admin@admin.com', 'User logged out', '2023-04-15 11:25:52', 1),
(14, 'admin@admin.com', 'User logged in', '2023-04-15 12:02:48', 1),
(15, 'admin@admin.com', 'User logged out', '2023-04-16 18:45:54', 1),
(16, 'admin@admin.com', 'User logged in', '2023-04-16 18:45:57', 1),
(17, 'admin@admin.com', 'User logged in', '2023-04-18 05:09:00', 1),
(18, 'admin@admin.com', 'User logged in', '2023-04-19 12:13:39', 1),
(19, 'admin@admin.com', 'User logged in', '2023-05-05 01:51:53', 1),
(20, 'admin@admin.com', 'User logged out', '2023-05-05 03:23:47', 1),
(21, 'admin@admin.com', 'User logged in', '2023-05-05 03:23:50', 1),
(22, 'admin@admin.com', 'User logged out', '2023-05-05 03:26:18', 1),
(23, 'admin@admin.com', 'User logged in', '2023-05-05 03:26:22', 1),
(24, '', 'User logged out', '2023-05-05 13:35:24', 0),
(25, 'admin@admin.com', 'User logged in', '2023-05-05 13:35:28', 1),
(26, 'admin@admin.com', 'User logged out', '2023-05-05 13:35:31', 1),
(27, 'admin@admin.com', 'User logged in', '2023-05-05 13:35:52', 1),
(28, 'admin@admin.com', 'User logged in', '2023-05-08 22:58:30', 1),
(29, NULL, 'fbfgbdg', '2023-05-08 23:59:07', NULL),
(30, '', 'User logged out', '2023-05-09 00:16:01', 0),
(31, 'admin@admin.com', 'User logged in', '2023-05-09 00:16:05', 1),
(32, '', 'fbfgbdg', '2023-05-09 00:16:25', 2),
(33, '', 'User logged out', '2023-05-09 00:16:53', 0),
(34, 'admin@admin.com', 'User logged in', '2023-05-09 00:19:30', 1),
(35, NULL, 'fbfgbdg', '2023-05-09 00:19:55', NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblmedicine`
--

INSERT INTO `tblmedicine` (`DrugID`, `drug_image_id`, `drugName`, `scientificName`, `drugDosage`, `drugCategory`, `storageTemperature`, `no_of_unit_in_package`, `manufacturer`, `unitPrice`, `storageLocation`, `status`) VALUES
(1, 1, 'LORATADINE', 'LORATADINE', 10, 'ANTIHISTAMINES & ANTIALLERGICS', 30, 30, 'PHARMANIAGA', 10, 'ROOM', 'T'),
(2, 2, 'LEVOCETIRIZINE', 'LEVOCETIRIZINE', 5, 'ANTIHISTAMINES & ANTIALLERGICS', 30, 30, 'GLENMARK', 30, 'ROOM', 'T'),
(3, 3, 'PANADOL', 'PANADOL', 650, 'ANALGESICS AND ANTIPYRETICS', 30, 50, 'PHARMANIAGA', 30, 'ROOM', 'T'),
(7, 7, 'GRRGGR', '', 22, 'FEEFEFE', 0, 22, 'WER', 2222, '', 'T'),
(8, 8, 'AFTER SHIFTS', '', 22, 'FEEFEFE', 0, 11, 'WER', 11, '', 'T'),
(9, 9, 'AFTER ROLE', '', 22, 'FEEFEFE', 0, 11, 'WER', 11, '', 'T'),
(10, 10, 'AFTER STATUS', '', 0, 'FEEFEFE', 0, 77, 'WER', 88, '', 'T'),
(11, 11, 'DBPHARMACY', '', 11, 'FEEFEFE', 0, 11, 'WER', 514, '', 'T'),
(12, 12, 'AT BEGINNING OF TABLE', '', 33, 'FEEFEFE', 0, 23, 'WER', 32, '', 'T'),
(13, 13, 'ADMIN123', '', 99, 'FEEFEFE', 0, 99, 'WER', 99, '', 'T'),
(14, 14, 'UHUHU', '', 99, 'FEEFEFE', 0, 99, 'WER', 99, '', 'T'),
(15, 15, 'AT BEGINNING OF TABLE', '', 23, 'FEEFEFE', 0, 2323, 'WER', 322323, '', 'T'),
(16, 16, 'AT BEGINNING OF TABLE', '', 23, 'FEEFEFE', 0, 2323, 'WER', 322323, '', 'T'),
(17, 17, 'AFTER ROLE', '', 23123, 'EFFDSS', 0, 213, 'BGBGBG', 231231, '', 'T'),
(18, 18, 'AFTER ROLE', '', 23123, 'EFFDSS', 0, 213, 'BGBGBG', 231231, '', 'T'),
(19, 19, 'AWSDFGB', '', 2345, 'FRGFSERGF', 0, 23423, 'ERAWESDAWE', 34243, '', 'T'),
(20, 20, 'ERWREWRW', '', 1231, 'GSFWERF', 0, 2342, 'BGBGBG', 213131, '', 'T'),
(21, 21, 'ADMIN123', '', 33333, 'FRGFSERGF', 0, 2323, 'BGBGBG', 32322, '', 'T'),
(22, 22, 'ADMIN123', '', 54, 'FRGFSERGF', 0, 55, 'BGBGBG', 22, '', 'T'),
(23, 23, 'ADMIN123', '', 54, 'FRGFSERGF', 0, 55, 'BGBGBG', 22, '', 'T'),
(24, 24, 'AFTER STATUS', '', 33333333, 'FEEFEFE', 0, 2147483647, 'BGBGBG', 222222, '', 'T'),
(25, 25, 'AFTER STATUS', '', 33333333, 'FEEFEFE', 0, 2147483647, 'BGBGBG', 222222, '', 'T'),
(26, 26, 'AFTER STATUS', '', 33333333, 'FEEFEFE', 0, 2147483647, 'BGBGBG', 222222, '', 'T'),
(27, 27, 'AFTER STATUS', '', 33333333, 'FEEFEFE', 0, 2147483647, 'BGBGBG', 222222, '', 'T'),
(28, 28, 'AFTER STATUS', '', 33333333, 'FEEFEFE', 0, 2147483647, 'BGBGBG', 222222, '', 'T'),
(29, 29, 'AFTER STATUS', '', 23, 'AEFAWERW', 0, 123, 'BGBGBG', 123123, '', 'T'),
(30, 30, 'DBPHARMACY', '', 789, 'EFFDSS', 0, 25, 'BGBGBG', 22, '', 'T');

-- --------------------------------------------------------

--
-- Table structure for table `tblmedicine_image`
--

CREATE TABLE `tblmedicine_image` (
  `drug_image_id` int(11) NOT NULL,
  `image_path` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblmedicine_image`
--

INSERT INTO `tblmedicine_image` (`drug_image_id`, `image_path`) VALUES
(1, 'LORA10MGcopy26-11-22_10_20_39.png'),
(2, 'levocetirizine26-11-22_10_21_50.jpg'),
(3, '6d273b1b421dfde3c925719adcb6831226-11-22_10_22_29.jpeg'),
(7, 'Screenshot (2)05-05-23_05_44_35.png'),
(8, 'Screenshot (7)05-05-23_05_47_48.png'),
(9, 'Screenshot (10)05-05-23_05_49_15.png'),
(10, 'Screenshot (14)05-05-23_05_52_03.png'),
(11, 'Screenshot (10)05-05-23_05_55_09.png'),
(12, 'Screenshot 2023-04-19 22540005-05-23_06_00_29.png'),
(13, 'Screenshot (5)05-05-23_06_03_32.png'),
(14, 'Screenshot (2)05-05-23_06_05_06.png'),
(15, 'Screenshot (9)05-05-23_12_18_18.png'),
(16, 'Screenshot (9)05-05-23_12_19_17.png'),
(17, 'Screenshot (1)05-05-23_12_19_41.png'),
(18, 'Screenshot (1)05-05-23_12_21_30.png'),
(19, 'Screenshot (19)05-05-23_12_21_51.png'),
(20, 'Screenshot 2023-04-19 22540005-05-23_12_25_12.png'),
(21, 'Screenshot (1)05-05-23_01_48_12.png'),
(22, 'Screenshot (2)08-05-23_11_59_07.png'),
(23, 'Screenshot (2)08-05-23_11_59_44.png'),
(24, 'Screenshot (9)09-05-23_12_05_03.png'),
(25, 'Screenshot (9)09-05-23_12_10_56.png'),
(26, 'Screenshot (9)09-05-23_12_11_30.png'),
(27, 'Screenshot (9)09-05-23_12_12_41.png'),
(28, 'Screenshot (9)09-05-23_12_14_49.png'),
(29, 'Screenshot (9)09-05-23_12_16_25.png'),
(30, 'Screenshot (9)09-05-23_12_19_55.png');

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
  `remainingAmount` float NOT NULL,
  `refundedItem` longtext DEFAULT NULL,
  `refundedBatchNo` longtext DEFAULT NULL,
  `refundedDrugQty` longtext DEFAULT NULL,
  `refundedDrugPrice` longtext DEFAULT NULL,
  `refundedTax` longtext DEFAULT NULL,
  `refundedDateTime` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblpurchase_invoice`
--

INSERT INTO `tblpurchase_invoice` (`purchaseInvoiceID`, `purchaseDate`, `drugID`, `drugBatchNo`, `drugQty`, `drugPrice`, `tax`, `totalAmount`, `paymentType`, `discount`, `paidAmount`, `remainingAmount`, `refundedItem`, `refundedBatchNo`, `refundedDrugQty`, `refundedDrugPrice`, `refundedTax`, `refundedDateTime`) VALUES
(1, '2022-11-26 23:47:04', 'PANADOL', 'PANA1', '6', '30', '6:10.80', 190.8, 'Cash', 0, 200, 9.2, '', '', '', '', '', NULL),
(2, '2022-11-26 23:47:15', 'LORATADINE:LORATADINE:LEVOCETIRIZINE', 'LORA1:LORA2:LEVO1', '10:2:3', '10:10:30', '6:12.60', 222.6, 'Cash', 0, 250, 27.4, 'LORATADINE:LEVOCETIRIZINE:LORATADINE', 'LORA1:LEVO1:LORA2', '10:3:2', '10:30:10', '6:12.6', '2023-01-16 11:42:18|2023-01-16 11:42:18|2023-01-16 11:50:29'),
(3, '2022-11-26 23:47:46', 'LEVOCETIRIZINE', 'LEVO1', '6', '30', '6:10.80', 190.8, 'Cash', 0, 200, 9.2, '', '', '', '', '', NULL),
(4, '2022-11-26 23:47:53', 'LEVOCETIRIZINE:LORATADINE:LORATADINE:PANADOL', 'LEVO1:LORA1:LORA2:PANA1', '1:0:2:1', '30:10:10:30', '6:4.80', 84.8, 'Cash', 0, 90, 5.2, '', '', '', '', '', NULL),
(5, '2022-11-27 00:01:58', 'LORATADINE:LORATADINE', 'LORA1:LORA2', '0:1', '10:10', '6:0.60', 10.6, 'Cash', 0, 11, 0.4, '', '', '', '', '', NULL),
(6, '2022-11-27 00:05:25', 'LEVOCETIRIZINE', 'LEVO1', '1', '30', '6:1.80', 31.8, 'Cash', 0, 32, 0.2, NULL, NULL, NULL, NULL, NULL, NULL),
(7, '2022-11-27 00:06:31', 'PANADOL', 'PANA1', '1', '30', '6:1.80', 31.8, 'Cash', 0, 32, 0.2, '', '', '', '', '', NULL),
(8, '2022-11-27 00:06:51', 'PANADOL', 'PANA1', '1', '30', '6:1.80', 31.8, 'Cash', 0, 50, 18.2, '', '', '', '', '', NULL),
(9, '2022-11-27 01:05:10', 'LORATADINE:LORATADINE', 'LORA1:LORA2', '0:5', '10:10', '6:3.00', 53, 'Cash', 0, 55, 2, 'LORATADINE', 'LORA2', '5', '10', '6:3', '2023-01-16 11:51:46'),
(10, '2022-11-29 00:24:44', 'LORATADINE:LORATADINE', 'LORA1:LORA2', '0:5', '10:10', '6:3.00', 53, 'Cash', 0, 55, 2, 'LORATADINE', 'LORA2', '5', '10', '6:3', '2023-01-16 11:32:11'),
(11, '2022-11-29 00:31:35', 'LEVOCETIRIZINE', 'LEVO1', '1', '30', '6:1.80', 31.8, 'Cash', 0, 32, 0.2, '', '', '', '', '', NULL),
(12, '2022-11-29 00:35:26', 'LORATADINE:LORATADINE:LEVOCETIRIZINE', 'LORA1:LORA2:LEVO1', '0:2:3', '10:10:30', '6:6.60', 116.6, 'Cash', 0, 120, 3.4, '', '', '', '', '', NULL),
(13, '2022-11-29 00:40:43', 'LEVOCETIRIZINE:LORATADINE:LORATADINE', 'LEVO1:LORA1:LORA2', '3:0:4', '30:10:10', '6:7.80', 137.8, 'Cash', 0, 140, 2.2, '', '', '', '', '', NULL),
(14, '2023-01-16 11:25:26', 'LORATADINE:LORATADINE', 'LORA1:LORA2', '0:1', '10:10', '6:0.60', 10.6, 'Cash', 0, 11, 0.4, NULL, NULL, NULL, NULL, NULL, NULL),
(15, '2023-01-16 14:05:28', 'LORATADINE:LEVOCETIRIZINE', 'LORA1:LEVO1', '1:1', '10:30', '6:2.40', 42.4, 'Cash', 0, 50, 7.6, 'LEVOCETIRIZINE', 'LEVO1', '1', '30', '6:1.8', '2023-01-16 14:12:16');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblstored_drug`
--

INSERT INTO `tblstored_drug` (`batchNo`, `DrugID`, `manufacturerDate`, `expiryDate`, `quantity`, `entryDate`, `status`) VALUES
('LEVO1', 2, '2022-11-26', '2022-12-01', 89, '2022-11-26 22:23:52', 'T'),
('LORA1', 1, '2022-11-26', '2023-01-01', 29, '2022-11-26 22:24:20', 'T'),
('PANA1', 3, '2022-11-26', '2022-12-09', 0, '2022-11-26 22:24:34', 'T'),
('LORA2', 1, '2022-11-26', '2023-04-01', 104, '2022-11-26 22:25:07', 'T');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `code` VARCHAR(10) NOT NULL , 
  `is_verified` TINYINT(3) NOT NULL DEFAULT '0',
  `roleID` int(55) UNSIGNED DEFAULT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Date_joined` date DEFAULT NULL,
  `Salary` float DEFAULT NULL,
  `Shifts` varchar(255) DEFAULT NULL,
  `status` int(13) DEFAULT NULL,
  `job` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `roleID`, `Name`, `Date_joined`, `Salary`, `Shifts`, `status`, `job`) VALUES
(1, 'admin@gmail.com', '0192023a7bbd73250516f069df18b500', 1, NULL, NULL, NULL, NULL, 0, NULL),
(6, 'admin@admin.com', '0192023a7bbd73250516f069df18b500', 1, NULL, NULL, NULL, NULL, 0, NULL),
(7, 'blah_bub@burr.com', 'NOORULAIN', 2, 'NOOR UL AIN', '2023-04-08', 234567, 'Evening Shift', 0, 'Employee'),
(8, 'blah_bub@burr.com', 'Sufyan', 2, 'Sufyan', '2023-04-01', 999, 'Afternoon Shift', 1, 'Employee'),
(9, 'babysofia5601@gmail.com', 'burbbebe', 3, 'burb bebe', '2023-04-21', 333, 'Evening Shift', 0, 'Pharmacist'),
(10, 'blah_bub@burr.com', 'njnjnjn', 2, 'njnjnjn', '2023-04-02', 3333, 'Evening Shift', 1, 'Employee'),
(11, 'blah_bub@burr.com', 'NOORULAIN', 2, 'NOOR UL AIN', '2023-04-01', 444, 'Afternoon Shift', 1, 'Employee'),
(12, 'babysofia5601@gmail.com', 'atbeginningoftable', 3, 'at beginning of table', '2023-05-01', 234, 'Evening Shift', 0, 'Pharmacist'),
(13, 'babysofia5601@gmail.com', 'atbeginningoftable', 3, 'at beginning of table', '2023-05-01', 234, 'Evening Shift', 0, 'Pharmacist'),
(14, 'blah_bub@burr.com', 'afterstatus', 2, 'after status', '2023-05-01', 5.55556e16, 'Afternoon Shift', 0, 'Employee');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `tblmedicine`
--
ALTER TABLE `tblmedicine`
  MODIFY `DrugID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `tblmedicine_image`
--
ALTER TABLE `tblmedicine_image`
  MODIFY `drug_image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `tblpurchase_invoice`
--
ALTER TABLE `tblpurchase_invoice`
  MODIFY `purchaseInvoiceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
