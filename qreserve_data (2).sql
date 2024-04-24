-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 15, 2024 at 11:45 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qreserve_data`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_accounts`
--

CREATE TABLE `admin_accounts` (
  `adminID` int(11) NOT NULL,
  `adminInfoID` int(11) NOT NULL,
  `adminUsername` varchar(300) NOT NULL,
  `adminPassword` varchar(300) NOT NULL,
  `startShift` time NOT NULL,
  `endShift` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_accounts`
--

INSERT INTO `admin_accounts` (`adminID`, `adminInfoID`, `adminUsername`, `adminPassword`, `startShift`, `endShift`) VALUES
(6, 1, 'G3E4tgTMcnRM30aicJ46Y/fu+3MTjKXQ51Sv4786vKqT44uT3g2Fn15dWHwSO6q6', '4hmrPTZfRZD5/MM/yLxTOiVWbyZ2y6jyfbsmjueDgj4=', '10:00:00', '18:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `admin_info`
--

CREATE TABLE `admin_info` (
  `adminInfoID` int(11) NOT NULL,
  `adminLastName` varchar(300) NOT NULL,
  `adminFirstName` varchar(300) NOT NULL,
  `adminMiddleName` varchar(300) NOT NULL,
  `adminSex` enum('Male','Female','Others','') NOT NULL,
  `adminContactNumber` varchar(300) NOT NULL,
  `adminEmail` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_info`
--

INSERT INTO `admin_info` (`adminInfoID`, `adminLastName`, `adminFirstName`, `adminMiddleName`, `adminSex`, `adminContactNumber`, `adminEmail`) VALUES
(1, '+PPtBp9LZGjQlFJb8ljEHYt4rvOGxSSmNElDmheVc/A=', 'nFH3jgGdgyL0ayhaojLpciYCyNZ6/KPiLYycWtPtmw8=', 'g70Fn7ZdNVhMIXzNadv0Y7jif2F15TBBgYfLMT3vKjg=', 'Female', '0n+PoyoIHCPgB2/gzLQLuInMYqZZ5c5Pz2anAAHShzs=', 'aDtFF9Jb5Zfr8IiV/2rBVXtvn40h1i4d4d2gJko6xT4rndcZNOSzKMyMWMhdnToL');

-- --------------------------------------------------------

--
-- Table structure for table `admin_shift`
--

CREATE TABLE `admin_shift` (
  `adminShiftID` int(11) NOT NULL,
  `adminID` int(11) NOT NULL,
  `loginTime` datetime NOT NULL,
  `logoutTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customer_info`
--

CREATE TABLE `customer_info` (
  `customerID` int(11) NOT NULL,
  `customerFirstName` varchar(300) NOT NULL,
  `customerLastName` varchar(300) NOT NULL,
  `customerMiddleName` varchar(300) NOT NULL,
  `customerBirthdate` date NOT NULL,
  `customerNumber` varchar(300) NOT NULL,
  `customerEmail` varchar(300) NOT NULL,
  `validID` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_info`
--

INSERT INTO `customer_info` (`customerID`, `customerFirstName`, `customerLastName`, `customerMiddleName`, `customerBirthdate`, `customerNumber`, `customerEmail`, `validID`) VALUES
(1, 'BOKm2WGEp4vOqZyRcAp00Gy+Qy+YLQEOA+PvIFp8FhA=', '+W49SF5a9yIk937FJ0QWbuw4qPB5j/BDQ+GOoXThUnI=', 'kdvl0vvQ7V2cmkA3VCYddTvHu9MHKgj6Ms5ZV4A/lGY= encrypted data:', '2001-11-02', 'jZ8AvZmvN9+UXZhgCYngyOs2EvwTvX9LCBqKG6G9ShM=', 'A4PYNjUe1ddX0ggg6yxxLHJYx+gOWITv7Dc2EBnoqJ2GLCo+Eyy5J5eCrAhtdpTk', '');

-- --------------------------------------------------------

--
-- Table structure for table `hour_price`
--

CREATE TABLE `hour_price` (
  `hoursID` int(11) NOT NULL,
  `numberOfHours` int(11) NOT NULL,
  `pricePerHour` int(11) NOT NULL,
  `membershipPrice` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hour_price`
--

INSERT INTO `hour_price` (`hoursID`, `numberOfHours`, `pricePerHour`, `membershipPrice`) VALUES
(1, 1, 150, 100),
(2, 2, 300, 250),
(3, 3, 450, 400),
(4, 4, 600, 550),
(5, 5, 750, 700),
(6, 6, 900, 850),
(7, 7, 1050, 1000),
(8, 8, 1200, 1150),
(9, 9, 1350, 1300),
(10, 10, 1500, 1450),
(11, 11, 1650, 1600),
(12, 12, 1800, 1750),
(13, 13, 1950, 1900),
(14, 14, 2100, 2050),
(15, 15, 2250, 2200),
(16, 16, 2400, 2350),
(17, 17, 2550, 2500),
(18, 18, 2700, 2650);

-- --------------------------------------------------------

--
-- Table structure for table `membership_perks`
--

CREATE TABLE `membership_perks` (
  `perk_id` int(11) NOT NULL,
  `perk_monthly` int(11) NOT NULL,
  `membership_discount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `membership_perks`
--

INSERT INTO `membership_perks` (`perk_id`, `perk_monthly`, `membership_discount`) VALUES
(1, 250, 50);

-- --------------------------------------------------------

--
-- Table structure for table `member_details`
--

CREATE TABLE `member_details` (
  `memberID` int(11) NOT NULL,
  `membershipID` varchar(500) NOT NULL,
  `membershipPassword` varchar(500) NOT NULL,
  `customerID` int(11) DEFAULT NULL,
  `creationDate` date NOT NULL,
  `validityDate` date NOT NULL,
  `perk_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `member_details`
--

INSERT INTO `member_details` (`memberID`, `membershipID`, `membershipPassword`, `customerID`, `creationDate`, `validityDate`, `perk_id`) VALUES
(7, 'gv2PqedXsyQ+rctlNPO0+VxodCMh49rYMLS5krKnWqNp0JCb3ghyA9COd3lVxXVW', ' Afxze2UGZ50gSRKPD6t8pLbokxYd7zmisPg+V/NkgjA=', 1, '2024-04-15', '2024-05-15', 1);

-- --------------------------------------------------------

--
-- Table structure for table `payment_history`
--

CREATE TABLE `payment_history` (
  `paymentID` int(11) NOT NULL,
  `customerID` int(11) NOT NULL,
  `paymentAmount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pool_tables`
--

CREATE TABLE `pool_tables` (
  `poolTableID` int(11) NOT NULL,
  `poolTableNumber` int(11) NOT NULL,
  `poolTableStatus` enum('Done','Reserved','Playing','Waiting','Available') NOT NULL,
  `customerName` varchar(50) NOT NULL,
  `timeStarted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `timeEnd` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pool_tables`
--

INSERT INTO `pool_tables` (`poolTableID`, `poolTableNumber`, `poolTableStatus`, `customerName`, `timeStarted`, `timeEnd`) VALUES
(1, 1, 'Available', '', '2024-03-29 16:00:00', '0000-00-00 00:00:00'),
(2, 2, 'Available', '', '2024-03-29 16:00:00', '0000-00-00 00:00:00'),
(3, 3, 'Available', '', '2024-03-29 16:00:00', '0000-00-00 00:00:00'),
(4, 4, 'Available', '', '2024-03-29 16:00:00', '0000-00-00 00:00:00'),
(5, 5, 'Available', '', '2024-03-29 16:00:00', '0000-00-00 00:00:00'),
(6, 6, 'Available', '', '2024-03-29 16:00:00', '0000-00-00 00:00:00'),
(7, 7, 'Available', '', '2024-03-29 16:00:00', '0000-00-00 00:00:00'),
(8, 8, 'Available', '', '2024-03-29 16:00:00', '0000-00-00 00:00:00'),
(9, 9, 'Available', '', '2024-03-29 16:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `pool_table_history`
--

CREATE TABLE `pool_table_history` (
  `historyID` int(11) NOT NULL,
  `poolTable1` int(11) NOT NULL,
  `poolTable2` int(11) NOT NULL,
  `poolTable3` int(11) NOT NULL,
  `poolTable4` int(11) NOT NULL,
  `poolTable5` int(11) NOT NULL,
  `poolTable6` int(11) NOT NULL,
  `poolTable7` int(11) NOT NULL,
  `poolTable8` int(11) NOT NULL,
  `poolTable9` int(11) NOT NULL,
  `poolTable10` int(11) NOT NULL,
  `totalReservations` int(11) NOT NULL,
  `totalWalkIn` int(11) NOT NULL,
  `totalVisits` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pool_table_reservation`
--

CREATE TABLE `pool_table_reservation` (
  `reservationID` int(11) NOT NULL,
  `tableID` int(11) NOT NULL,
  `customerID` int(11) NOT NULL,
  `hoursID` int(11) NOT NULL,
  `paymentID` int(11) DEFAULT NULL,
  `adminID` int(11) DEFAULT NULL,
  `reservationDate` date NOT NULL,
  `reservationTimeStart` time NOT NULL,
  `reservationTimeEnd` time NOT NULL,
  `reservationStatus` enum('On Process','Paid','Pending','No Show','Done') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pool_table_walk_in`
--

CREATE TABLE `pool_table_walk_in` (
  `walkinID` int(11) NOT NULL,
  `tableID` int(11) NOT NULL,
  `customerID` int(11) NOT NULL,
  `hoursID` int(11) NOT NULL,
  `paymentID` int(11) DEFAULT NULL,
  `adminID` int(11) DEFAULT NULL,
  `walkinDate` date NOT NULL,
  `walkinTimeStart` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `walkinTimeEnd` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `walkinStatus` enum('Playing','Done') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `qr_code`
--

CREATE TABLE `qr_code` (
  `qrID` int(11) NOT NULL,
  `walkinOrReservationID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `serviceID` int(11) NOT NULL,
  `serviceName` varchar(20) NOT NULL,
  `serviceDescription` varchar(50) NOT NULL,
  `serviceRate` int(11) NOT NULL,
  `serviceImage` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`serviceID`, `serviceName`, `serviceDescription`, `serviceRate`, `serviceImage`) VALUES
(1, 'Billiards', '', 150, 'Billiards Hall.jpg'),
(2, 'KTV Room 1', '', 0, 'KTV Room 1.jpg'),
(3, 'KTV Room 2', '', 0, 'KTV Room 2.jpg'),
(4, 'KTV Room 3', '', 0, 'KTV Room 3.jpg'),
(5, 'Karaoke Night', '', 0, 'Karaoke.jpg'),
(6, 'Membership', '', 250, 'Membership.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `super_admin`
--

CREATE TABLE `super_admin` (
  `superAdminID` int(11) NOT NULL,
  `superAdminUsername` varchar(300) NOT NULL,
  `superAdminPassword` varchar(300) NOT NULL,
  `superAdminEmail` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `super_admin`
--

INSERT INTO `super_admin` (`superAdminID`, `superAdminUsername`, `superAdminPassword`, `superAdminEmail`) VALUES
(1, 'rrk3mjuWsVndAogkVWyjircu6BHeMy0PRO1h6PUbo6OOODyLA4VFz6oM1G1ShweG', 'yxQc/K/LN8W8rl6nSthWNhqpwXkCvzIalsKZtGFBgUg=', 'rrk3mjuWsVndAogkVWyjircu6BHeMy0PRO1h6PUbo6OOODyLA4VFz6oM1G1ShweG');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_accounts`
--
ALTER TABLE `admin_accounts`
  ADD PRIMARY KEY (`adminID`),
  ADD KEY `adminID` (`adminInfoID`) USING BTREE;

--
-- Indexes for table `admin_info`
--
ALTER TABLE `admin_info`
  ADD PRIMARY KEY (`adminInfoID`);

--
-- Indexes for table `admin_shift`
--
ALTER TABLE `admin_shift`
  ADD PRIMARY KEY (`adminShiftID`),
  ADD KEY `adminID` (`adminID`);

--
-- Indexes for table `customer_info`
--
ALTER TABLE `customer_info`
  ADD PRIMARY KEY (`customerID`);

--
-- Indexes for table `hour_price`
--
ALTER TABLE `hour_price`
  ADD PRIMARY KEY (`hoursID`);

--
-- Indexes for table `membership_perks`
--
ALTER TABLE `membership_perks`
  ADD PRIMARY KEY (`perk_id`);

--
-- Indexes for table `member_details`
--
ALTER TABLE `member_details`
  ADD PRIMARY KEY (`memberID`),
  ADD KEY `customerID` (`customerID`),
  ADD KEY `perk_id` (`perk_id`);

--
-- Indexes for table `payment_history`
--
ALTER TABLE `payment_history`
  ADD PRIMARY KEY (`paymentID`),
  ADD KEY `customerID` (`customerID`);

--
-- Indexes for table `pool_tables`
--
ALTER TABLE `pool_tables`
  ADD PRIMARY KEY (`poolTableID`),
  ADD KEY `poolTableNumber` (`poolTableNumber`);

--
-- Indexes for table `pool_table_history`
--
ALTER TABLE `pool_table_history`
  ADD PRIMARY KEY (`historyID`);

--
-- Indexes for table `pool_table_reservation`
--
ALTER TABLE `pool_table_reservation`
  ADD PRIMARY KEY (`reservationID`),
  ADD KEY `tableID` (`tableID`,`customerID`,`hoursID`,`paymentID`),
  ADD KEY `customerID` (`customerID`),
  ADD KEY `hoursID` (`hoursID`),
  ADD KEY `paymentID` (`paymentID`),
  ADD KEY `adminID` (`adminID`);

--
-- Indexes for table `pool_table_walk_in`
--
ALTER TABLE `pool_table_walk_in`
  ADD PRIMARY KEY (`walkinID`),
  ADD KEY `tableID` (`tableID`,`customerID`,`hoursID`,`paymentID`,`adminID`),
  ADD KEY `paymentID` (`paymentID`),
  ADD KEY `hoursID` (`hoursID`),
  ADD KEY `adminID` (`adminID`),
  ADD KEY `customerID` (`customerID`);

--
-- Indexes for table `qr_code`
--
ALTER TABLE `qr_code`
  ADD PRIMARY KEY (`qrID`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`serviceID`);

--
-- Indexes for table `super_admin`
--
ALTER TABLE `super_admin`
  ADD PRIMARY KEY (`superAdminID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_accounts`
--
ALTER TABLE `admin_accounts`
  MODIFY `adminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `admin_info`
--
ALTER TABLE `admin_info`
  MODIFY `adminInfoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_shift`
--
ALTER TABLE `admin_shift`
  MODIFY `adminShiftID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_info`
--
ALTER TABLE `customer_info`
  MODIFY `customerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hour_price`
--
ALTER TABLE `hour_price`
  MODIFY `hoursID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `membership_perks`
--
ALTER TABLE `membership_perks`
  MODIFY `perk_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `member_details`
--
ALTER TABLE `member_details`
  MODIFY `memberID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `payment_history`
--
ALTER TABLE `payment_history`
  MODIFY `paymentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pool_tables`
--
ALTER TABLE `pool_tables`
  MODIFY `poolTableID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pool_table_history`
--
ALTER TABLE `pool_table_history`
  MODIFY `historyID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pool_table_reservation`
--
ALTER TABLE `pool_table_reservation`
  MODIFY `reservationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pool_table_walk_in`
--
ALTER TABLE `pool_table_walk_in`
  MODIFY `walkinID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `qr_code`
--
ALTER TABLE `qr_code`
  MODIFY `qrID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `serviceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `super_admin`
--
ALTER TABLE `super_admin`
  MODIFY `superAdminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_accounts`
--
ALTER TABLE `admin_accounts`
  ADD CONSTRAINT `admin_accounts_ibfk_1` FOREIGN KEY (`adminInfoID`) REFERENCES `admin_info` (`adminInfoID`);

--
-- Constraints for table `admin_shift`
--
ALTER TABLE `admin_shift`
  ADD CONSTRAINT `admin_shift_ibfk_1` FOREIGN KEY (`adminID`) REFERENCES `admin_accounts` (`adminID`);

--
-- Constraints for table `member_details`
--
ALTER TABLE `member_details`
  ADD CONSTRAINT `member_details_ibfk_1` FOREIGN KEY (`customerID`) REFERENCES `customer_info` (`customerID`),
  ADD CONSTRAINT `member_details_ibfk_2` FOREIGN KEY (`perk_id`) REFERENCES `membership_perks` (`perk_id`);

--
-- Constraints for table `payment_history`
--
ALTER TABLE `payment_history`
  ADD CONSTRAINT `payment_history_ibfk_1` FOREIGN KEY (`customerID`) REFERENCES `customer_info` (`customerID`);

--
-- Constraints for table `pool_table_reservation`
--
ALTER TABLE `pool_table_reservation`
  ADD CONSTRAINT `pool_table_reservation_ibfk_1` FOREIGN KEY (`customerID`) REFERENCES `customer_info` (`customerID`),
  ADD CONSTRAINT `pool_table_reservation_ibfk_2` FOREIGN KEY (`tableID`) REFERENCES `pool_tables` (`poolTableID`),
  ADD CONSTRAINT `pool_table_reservation_ibfk_3` FOREIGN KEY (`hoursID`) REFERENCES `hour_price` (`hoursID`),
  ADD CONSTRAINT `pool_table_reservation_ibfk_4` FOREIGN KEY (`paymentID`) REFERENCES `payment_history` (`paymentID`),
  ADD CONSTRAINT `pool_table_reservation_ibfk_5` FOREIGN KEY (`adminID`) REFERENCES `admin_accounts` (`adminID`);

--
-- Constraints for table `pool_table_walk_in`
--
ALTER TABLE `pool_table_walk_in`
  ADD CONSTRAINT `pool_table_walk_in_ibfk_1` FOREIGN KEY (`paymentID`) REFERENCES `payment_history` (`paymentID`),
  ADD CONSTRAINT `pool_table_walk_in_ibfk_2` FOREIGN KEY (`hoursID`) REFERENCES `hour_price` (`hoursID`),
  ADD CONSTRAINT `pool_table_walk_in_ibfk_3` FOREIGN KEY (`tableID`) REFERENCES `pool_tables` (`poolTableID`),
  ADD CONSTRAINT `pool_table_walk_in_ibfk_4` FOREIGN KEY (`adminID`) REFERENCES `admin_accounts` (`adminID`),
  ADD CONSTRAINT `pool_table_walk_in_ibfk_5` FOREIGN KEY (`customerID`) REFERENCES `customer_info` (`customerID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
