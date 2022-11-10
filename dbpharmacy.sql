-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 06, 2022 at 03:30 PM
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
  `storageLocation` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblmedicine`
--

INSERT INTO `tblmedicine` (`DrugID`, `drug_image_id`, `drugName`, `scientificName`, `drugDosage`, `drugCategory`, `storageTemperature`, `no_of_unit_in_package`, `manufacturer`, `unitPrice`, `storageLocation`) VALUES
(1, 1, 'Loratadine', 'Loratadine', 10, 'Antihistamines & Antiallergics', 30, 100, 'Pharmaniaga', 30, 'Room'),
(2, 2, 'Paracetamol', 'Paracetamol', 650, 'Analgesics (Non-Opioid) & Antipyretics', 30, 100, 'Pharmaniaga', 20, 'Room');

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
(1, 'loratadine02-11-22_12:10:50.png'),
(2, '6d273b1b421dfde3c925719adcb6831202-11-22_12:36:48.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `tblstored_drug`
--

CREATE TABLE `tblstored_drug` (
  `batchNo` int(11) NOT NULL,
  `DrugID` int(11) NOT NULL,
  `manufacturerDate` date NOT NULL,
  `expiryDate` date NOT NULL,
  `quantity` int(11) NOT NULL,
  `entryDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblstored_drug`
--

INSERT INTO `tblstored_drug` (`batchNo`, `DrugID`, `manufacturerDate`, `expiryDate`, `quantity`, `entryDate`) VALUES
(1, 1, '2022-11-05', '2022-11-05', 300, '2022-11-05 16:56:59'),
(2, 1, '2022-11-01', '2022-12-01', 100, '2022-11-05 17:06:31'),
(3, 2, '2022-11-01', '2022-12-01', 110, '2022-11-05 17:08:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblmedicine`
--
ALTER TABLE `tblmedicine`
  ADD PRIMARY KEY (`DrugID`),
  ADD UNIQUE KEY `drug_image_id` (`drug_image_id`);

--
-- Indexes for table `tblmedicine_image`
--
ALTER TABLE `tblmedicine_image`
  ADD PRIMARY KEY (`drug_image_id`);

--
-- Indexes for table `tblstored_drug`
--
ALTER TABLE `tblstored_drug`
  ADD PRIMARY KEY (`batchNo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblmedicine`
--
ALTER TABLE `tblmedicine`
  MODIFY `DrugID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblmedicine_image`
--
ALTER TABLE `tblmedicine_image`
  MODIFY `drug_image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
