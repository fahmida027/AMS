-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Sep 15, 2024 at 08:32 PM
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
-- Database: `amstest`
--
CREATE DATABASE IF NOT EXISTS `amstest` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `amstest`;

-- --------------------------------------------------------

--
-- Table structure for table `accountsname`
--

CREATE TABLE `accountsname` (
  `accCode` varchar(10) NOT NULL,
  `acatID` int(11) NOT NULL,
  `accName` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accountsname`
--

INSERT INTO `accountsname` VALUES('A001', 1, 'Cash');
INSERT INTO `accountsname` VALUES('A002', 1, 'Equipments');
INSERT INTO `accountsname` VALUES('A003', 1, 'Supplies');
INSERT INTO `accountsname` VALUES('A004', 1, 'Account Receivable');
INSERT INTO `accountsname` VALUES('L001', 2, 'Accounts Payable');
INSERT INTO `accountsname` VALUES('L002', 2, 'Notes Payable');
INSERT INTO `accountsname` VALUES('OE001', 3, 'Income');
INSERT INTO `accountsname` VALUES('OE002', 3, 'Capital');
INSERT INTO `accountsname` VALUES('OE003', 3, 'Expenses');
INSERT INTO `accountsname` VALUES('OE004', 3, 'Drawings');

-- --------------------------------------------------------

--
-- Table structure for table `accounttype`
--

CREATE TABLE `accounttype` (
  `catID` int(11) NOT NULL,
  `catName` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounttype`
--

INSERT INTO `accounttype` VALUES(1, 'Assets');
INSERT INTO `accounttype` VALUES(2, 'Liabilities');
INSERT INTO `accounttype` VALUES(3, 'Owner Equity');

-- --------------------------------------------------------

--
-- Table structure for table `details`
--

CREATE TABLE `details` (
  `dTNo` int(11) NOT NULL,
  `dID` int(11) NOT NULL,
  `dAccCode` varchar(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `description` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `details`
--

INSERT INTO `details` VALUES(67, 60, 'A001', 7000, 'Capital for business');
INSERT INTO `details` VALUES(68, 61, 'A001', -900, 'office rent');
INSERT INTO `details` VALUES(69, 62, 'L001', 600, 'supplies on account on accounts payable');
INSERT INTO `details` VALUES(70, 63, 'A001', -125, 'for advertisement in the County news');
INSERT INTO `details` VALUES(71, 64, 'A001', 4000, 'for performing service');
INSERT INTO `details` VALUES(72, 65, 'A001', -1000, 'for personal use');
INSERT INTO `details` VALUES(73, 66, 'OE001', 5400, 'gave service on account');
INSERT INTO `details` VALUES(74, 67, 'A001', -2500, 'salaries for employees');
INSERT INTO `details` VALUES(75, 68, 'A001', -600, 'paid for the supplies on account(AP) on may 3');
INSERT INTO `details` VALUES(76, 69, 'A001', -4000, 'received from previous borrowers from May 15');
INSERT INTO `details` VALUES(77, 70, 'L002', 5000, 'loan from bank');
INSERT INTO `details` VALUES(78, 71, 'L001', 4200, 'equipments on account on accounts payable');
INSERT INTO `details` VALUES(79, 72, 'A001', -275, 'utilities');
INSERT INTO `details` VALUES(80, 73, 'A001', 1000, 'my money');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `tAccCode` varchar(11) NOT NULL,
  `tNo` int(11) NOT NULL,
  `tDate` date NOT NULL,
  `tType` char(1) NOT NULL,
  `tuID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` VALUES('OE002', 67, '2024-03-01', 'C', 1);
INSERT INTO `transactions` VALUES('OE003', 68, '2024-03-02', 'D', 1);
INSERT INTO `transactions` VALUES('A003', 69, '2024-03-03', 'D', 1);
INSERT INTO `transactions` VALUES('OE003', 70, '2024-03-05', 'D', 1);
INSERT INTO `transactions` VALUES('OE001', 71, '2024-03-09', 'C', 1);
INSERT INTO `transactions` VALUES('OE004', 72, '2024-03-12', 'D', 1);
INSERT INTO `transactions` VALUES('A004', 73, '2024-03-15', 'D', 1);
INSERT INTO `transactions` VALUES('OE003', 74, '2024-03-17', 'D', 1);
INSERT INTO `transactions` VALUES('L001', 75, '2024-03-20', 'D', 1);
INSERT INTO `transactions` VALUES('A004', 76, '2024-03-23', 'C', 1);
INSERT INTO `transactions` VALUES('A001', 77, '2024-03-26', 'D', 1);
INSERT INTO `transactions` VALUES('A002', 78, '2024-03-29', 'D', 1);
INSERT INTO `transactions` VALUES('OE003', 79, '2024-03-30', 'D', 1);
INSERT INTO `transactions` VALUES('OE001', 80, '2024-09-12', 'C', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` mediumtext NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` VALUES(1, 'user@gmail.com', '$2y$10$2p/sd/fIaqwwdlFWVUlQO.g8UUCB7fSXwFnBtEokKEAjqgPsvC30q', 'XYZ Business Firm');
INSERT INTO `user` VALUES(2, 'abc@gmail.com', '$2y$10$Pt5s5hQyf.pGTi4nOQMvleLQOVqsGNcea7OqJBCDldOBvTLmu.Lwu', 'Toasean Elmah');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accountsname`
--
ALTER TABLE `accountsname`
  ADD PRIMARY KEY (`accCode`),
  ADD KEY `accName FK accType` (`acatID`);

--
-- Indexes for table `accounttype`
--
ALTER TABLE `accounttype`
  ADD PRIMARY KEY (`catID`);

--
-- Indexes for table `details`
--
ALTER TABLE `details`
  ADD PRIMARY KEY (`dID`),
  ADD KEY `details FK transactions` (`dTNo`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`tNo`),
  ADD KEY `transaction FK accName` (`tAccCode`),
  ADD KEY `transaction FK user` (`tuID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounttype`
--
ALTER TABLE `accounttype`
  MODIFY `catID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `details`
--
ALTER TABLE `details`
  MODIFY `dID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `tNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accountsname`
--
ALTER TABLE `accountsname`
  ADD CONSTRAINT `accName FK accType` FOREIGN KEY (`acatID`) REFERENCES `accounttype` (`catID`);

--
-- Constraints for table `details`
--
ALTER TABLE `details`
  ADD CONSTRAINT `details FK transactions` FOREIGN KEY (`dTNo`) REFERENCES `transactions` (`tNo`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transaction FK accName` FOREIGN KEY (`tAccCode`) REFERENCES `accountsname` (`accCode`),
  ADD CONSTRAINT `transaction FK user` FOREIGN KEY (`tuID`) REFERENCES `user` (`userID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
