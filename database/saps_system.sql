-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 04, 2023 at 07:26 PM
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
-- Database: `saps_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `criminal_offences`
--

CREATE TABLE `criminal_offences` (
  `offense_id` int(11) NOT NULL,
  `offense_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `criminal_offences`
--

INSERT INTO `criminal_offences` (`offense_id`, `offense_name`) VALUES
(1, 'killing'),
(2, 'Rape'),
(3, 'Beating'),
(4, 'Stealing');

-- --------------------------------------------------------

--
-- Table structure for table `criminal_records`
--

CREATE TABLE `criminal_records` (
  `record_id` int(11) NOT NULL,
  `suspect_id` int(11) DEFAULT NULL,
  `offense_id` int(11) DEFAULT NULL,
  `sentence` int(11) NOT NULL,
  `issue_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `criminal_records`
--

INSERT INTO `criminal_records` (`record_id`, `suspect_id`, `offense_id`, `sentence`, `issue_date`) VALUES
(1, 1, 1, 23, '2023-11-15'),
(2, 1, 1, 23, '2023-11-07'),
(3, 2, 1, 34, '2023-11-12'),
(14, NULL, 1, 45, '2013-09-10'),
(15, NULL, 1, 45, '2013-09-10'),
(16, NULL, 2, 34, '2013-09-10'),
(17, NULL, 3, 33, '2013-09-19'),
(18, NULL, 4, 34, '2013-09-19'),
(19, NULL, 4, 34, '2013-09-19');

-- --------------------------------------------------------

--
-- Table structure for table `suspects`
--

CREATE TABLE `suspects` (
  `suspect_id` int(11) NOT NULL,
  `id_number` varchar(20) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suspects`
--

INSERT INTO `suspects` (`suspect_id`, `id_number`, `first_name`, `last_name`) VALUES
(1, '9309105209080', 'mth', 'kdd'),
(2, '0409040838081', 'naled', 'maseko'),
(3, '0412085133087', 'siya', 'md');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `criminal_offences`
--
ALTER TABLE `criminal_offences`
  ADD PRIMARY KEY (`offense_id`);

--
-- Indexes for table `criminal_records`
--
ALTER TABLE `criminal_records`
  ADD PRIMARY KEY (`record_id`),
  ADD KEY `suspect_id` (`suspect_id`),
  ADD KEY `offense_id` (`offense_id`);

--
-- Indexes for table `suspects`
--
ALTER TABLE `suspects`
  ADD PRIMARY KEY (`suspect_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `criminal_offences`
--
ALTER TABLE `criminal_offences`
  MODIFY `offense_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `criminal_records`
--
ALTER TABLE `criminal_records`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `suspects`
--
ALTER TABLE `suspects`
  MODIFY `suspect_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `criminal_records`
--
ALTER TABLE `criminal_records`
  ADD CONSTRAINT `criminal_records_ibfk_1` FOREIGN KEY (`suspect_id`) REFERENCES `suspects` (`suspect_id`),
  ADD CONSTRAINT `criminal_records_ibfk_2` FOREIGN KEY (`offense_id`) REFERENCES `criminal_offences` (`offense_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
