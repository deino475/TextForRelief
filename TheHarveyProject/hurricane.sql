-- phpMyAdmin SQL Dump
-- version 4.7.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 05, 2018 at 07:24 AM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hurricane`
--

-- --------------------------------------------------------

--
-- Table structure for table `shelters`
--

CREATE TABLE `shelters` (
  `id` int(12) NOT NULL,
  `shelter_id` varchar(300) NOT NULL,
  `shelter_name` varchar(300) NOT NULL,
  `street_name` varchar(300) NOT NULL,
  `city_name` varchar(100) NOT NULL,
  `state_name` varchar(20) NOT NULL,
  `zip_code` varchar(10) NOT NULL,
  `available` varchar(4) NOT NULL,
  `lat` float(10,6) NOT NULL,
  `lng` float(10,6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shelters`
--

INSERT INTO `shelters` (`id`, `shelter_id`, `shelter_name`, `street_name`, `city_name`, `state_name`, `zip_code`, `available`, `lat`, `lng`) VALUES
(1, 'test_one', 'test_one', 'test_one', 'Houston', 'Texas', '77033', 'Yes', 0.000000, 0.000000),
(2, 'ad0fb50f-f1c8-11e7-9d9b-18cf5e7b44b0', 'shelter_name', 'street_name', 'city_name', 'state_name', 'zip_code', 'acti', 0.000000, 0.000000),
(3, 'd7ef0204-f1c8-11e7-9d9b-18cf5e7b44b0', 'This is another test', '5619 Belarbor Street', 'Houston', 'TX', '77033', 'Yes', 10.000000, 10.000000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `shelters`
--
ALTER TABLE `shelters`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `shelters`
--
ALTER TABLE `shelters`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
