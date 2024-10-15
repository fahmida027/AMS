-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307:3307
-- Generation Time: Sep 25, 2024 at 09:21 PM
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

INSERT INTO `accountsname` (`accCode`, `acatID`, `accName`) VALUES
('A001', 1, 'Cash'),
('A002', 1, 'Equipments'),
('A003', 1, 'Supplies'),
('A004', 1, 'Account Receivable'),
('L001', 2, 'Accounts Payable'),
('L002', 2, 'Notes Payable'),
('OE001', 3, 'Income'),
('OE002', 3, 'Capital'),
('OE003', 3, 'Expenses'),
('OE004', 3, 'Drawings');

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

INSERT INTO `accounttype` (`catID`, `catName`) VALUES
(1, 'Assets'),
(2, 'Liabilities'),
(3, 'Owner Equity');

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

INSERT INTO `details` (`dTNo`, `dID`, `dAccCode`, `amount`, `description`) VALUES
(67, 60, 'A001', 7000, 'Capital for business'),
(68, 61, 'A001', -900, 'office rent'),
(69, 62, 'L001', 600, 'supplies on account on accounts payable'),
(70, 63, 'A001', -125, 'for advertisement in the County news'),
(71, 64, 'A001', 4000, 'for performing service'),
(72, 65, 'A001', -1000, 'for personal use'),
(73, 66, 'OE001', 5400, 'gave service on account'),
(74, 67, 'A001', -2500, 'salaries for employees'),
(75, 68, 'A001', -600, 'paid for the supplies on account(AP) on may 3'),
(76, 69, 'A001', -4000, 'received from previous borrowers from May 15'),
(77, 70, 'L002', 5000, 'loan from bank'),
(78, 71, 'L001', 4200, 'equipments on account on accounts payable'),
(79, 72, 'A001', -275, 'utilities'),
(80, 73, 'A001', 5000, 'Income from K.K co.'),
(81, 74, 'A001', 500, 'income'),
(82, 75, 'A001', 400, 'income'),
(83, 76, 'A001', 15000, 'income'),
(84, 77, 'A001', 13000, 'income'),
(85, 78, 'A001', 18000, 'income'),
(86, 79, 'A001', 20000, 'income'),
(87, 80, 'A001', 25000, 'income'),
(88, 81, 'A001', 10000, 'income'),
(89, 82, 'A001', 30000, 'income'),
(90, 83, 'A001', 23000, 'income'),
(91, 84, 'A001', 33000, 'income'),
(92, 85, 'A001', 12000, 'income'),
(93, 86, 'A001', -5000, 'expense'),
(94, 87, 'A001', -3000, 'expense'),
(95, 88, 'A001', -7000, 'expense'),
(96, 89, 'A001', -4000, 'expense'),
(97, 90, 'A001', -2000, 'expense'),
(98, 91, 'A001', -1000, 'expense'),
(99, 92, 'A001', -500, 'expense'),
(100, 93, 'A001', -3500, 'expense'),
(101, 94, 'A001', -5300, 'expense'),
(102, 95, 'A001', -900, 'expense'),
(103, 96, 'A001', -2000, 'expense'),
(104, 97, 'A001', -3000, 'expense'),
(105, 98, 'A001', -4000, 'expense'),
(106, 99, 'A001', -2000, 'expense'),
(107, 100, 'A001', -1500, 'expense'),
(108, 101, 'A001', -2500, 'expense'),
(109, 102, 'A001', 5000, 'income'),
(110, 103, 'A001', 8000, 'income');

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

INSERT INTO `transactions` (`tAccCode`, `tNo`, `tDate`, `tType`, `tuID`) VALUES
('OE002', 67, '2024-03-01', 'C', 1),
('OE003', 68, '2024-03-02', 'D', 1),
('A003', 69, '2024-03-03', 'D', 1),
('OE003', 70, '2024-03-05', 'D', 1),
('OE001', 71, '2024-03-09', 'C', 1),
('OE004', 72, '2024-03-12', 'D', 1),
('A004', 73, '2024-03-15', 'D', 1),
('OE003', 74, '2024-03-17', 'D', 1),
('L001', 75, '2024-03-20', 'D', 1),
('A004', 76, '2024-03-23', 'C', 1),
('A001', 77, '2024-03-26', 'D', 1),
('A002', 78, '2024-03-29', 'D', 1),
('OE003', 79, '2024-03-30', 'D', 1),
('OE001', 80, '2024-03-20', 'C', 1),
('OE001', 81, '2024-02-20', 'C', 1),
('OE001', 82, '2024-04-18', 'C', 1),
('OE001', 83, '2024-01-02', 'C', 1),
('OE001', 84, '2024-05-17', 'C', 1),
('OE001', 85, '2024-06-20', 'C', 1),
('OE001', 86, '2024-07-26', 'C', 1),
('OE001', 87, '2024-08-20', 'C', 1),
('OE001', 88, '2024-09-21', 'C', 1),
('OE001', 89, '2024-09-20', 'C', 1),
('OE001', 90, '2024-10-18', 'C', 1),
('OE001', 91, '2024-11-20', 'C', 1),
('OE001', 92, '2024-12-20', 'C', 1),
('OE003', 93, '2024-01-20', 'D', 1),
('OE003', 94, '2024-02-20', 'D', 1),
('OE003', 95, '2024-04-20', 'D', 1),
('OE003', 96, '2024-05-20', 'D', 1),
('OE003', 97, '2024-06-20', 'D', 1),
('OE003', 98, '2024-07-06', 'D', 1),
('OE003', 99, '2024-07-06', 'D', 1),
('OE003', 100, '2024-08-03', 'D', 1),
('OE003', 101, '2024-08-03', 'D', 1),
('OE003', 102, '2024-09-07', 'D', 1),
('OE003', 103, '2024-08-20', 'D', 1),
('OE003', 104, '2024-09-20', 'D', 1),
('OE003', 105, '2024-10-20', 'D', 1),
('OE003', 106, '2024-10-20', 'D', 1),
('OE003', 107, '2024-11-20', 'D', 1),
('OE003', 108, '2024-12-20', 'D', 1),
('OE001', 109, '2024-02-20', 'C', 1),
('OE001', 110, '2024-04-20', 'C', 1);

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

INSERT INTO `user` (`userID`, `email`, `password`, `name`) VALUES
(1, 'user@gmail.com', '$2y$10$2p/sd/fIaqwwdlFWVUlQO.g8UUCB7fSXwFnBtEokKEAjqgPsvC30q', 'user@gmail.com'),
(2, 'abc@gmail.com', '$2y$10$Pt5s5hQyf.pGTi4nOQMvleLQOVqsGNcea7OqJBCDldOBvTLmu.Lwu', 'Toasean Elmah');

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
  MODIFY `dID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `tNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

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
