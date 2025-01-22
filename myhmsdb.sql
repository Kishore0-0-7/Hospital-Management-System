-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 14, 2025 at 02:30 PM
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
-- Database: `myhmsdb`
--
CREATE DATABASE IF NOT EXISTS `myhmsdb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `myhmsdb`;

-- --------------------------------------------------------

--
-- Table structure for table `admintb`
--

DROP TABLE IF EXISTS `admintb`;
CREATE TABLE IF NOT EXISTS `admintb` (
  `username` varchar(50) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admintb`
--

INSERT INTO `admintb` (`username`, `password`) VALUES
('admin', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `appointmenttb`
--

DROP TABLE IF EXISTS `appointmenttb`;
CREATE TABLE IF NOT EXISTS `appointmenttb` (
  `pid` int(11) NOT NULL,
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(20) NOT NULL,
  `lname` varchar(20) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `email` varchar(30) NOT NULL,
  `contact` varchar(10) NOT NULL,
  `doctor` varchar(30) NOT NULL,
  `docFees` int(5) NOT NULL,
  `appdate` date NOT NULL,
  `apptime` time NOT NULL,
  `userStatus` int(5) NOT NULL,
  `doctorStatus` int(5) NOT NULL,
  `status` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `appointmenttb`
--

INSERT INTO `appointmenttb` (`pid`, `ID`, `fname`, `lname`, `gender`, `email`, `contact`, `doctor`, `docFees`, `appdate`, `apptime`, `userStatus`, `doctorStatus`, `status`) VALUES
(4, 1, 'vishnu', 'V', 'Male', 'vishnu@gmail.com', '9361070035', 'Ganesh', 550, '2020-02-14', '10:00:00', 1, 0, NULL),
(4, 2, 'vishnu', 'V', 'Male', 'vishnu@gmail.com', '9361070035', 'Dinesh', 700, '2020-02-28', '10:00:00', 0, 1, NULL),
(4, 3, 'vishnu', 'V', 'Male', 'vishnu@gmail.com', '9361070035', 'john', 1000, '2020-02-19', '03:00:00', 0, 1, NULL),
(11, 4, 'jen', 's', 'Female', 'jen@gmail.com', '9768946252', 'ajay', 500, '2020-02-29', '20:00:00', 1, 1, NULL),
(4, 5, 'vishnu', 'V', 'Male', 'vishnu@gmail.com', '9361070035', 'Dinesh', 700, '2020-02-28', '12:00:00', 1, 1, NULL),
(4, 6, 'vishnu', 'V', 'Male', 'vishnu@gmail.com', '9361070035', 'Ganesh', 550, '2020-02-26', '15:00:00', 0, 1, NULL),
(2, 8, 'priya', 'M', 'Female', 'priya@gmail.com', '8976897689', 'Ganesh', 550, '2020-03-21', '10:00:00', 1, 1, NULL),
(5, 9, 'Gowtham', 'S', 'Male', 'Gowtham@gmail.com', '9070897653', 'Ganesh', 550, '2020-03-19', '20:00:00', 1, 0, NULL),
(4, 10, 'vishnu', 'V', 'Male', 'vishnu@gmail.com', '9361070035', 'Ganesh', 550, '0000-00-00', '14:00:00', 1, 0, NULL),
(4, 11, 'vishnu', 'V', 'Male', 'vishnu@gmail.com', '9361070035', 'Dinesh', 700, '2020-03-27', '15:00:00', 1, 1, NULL),
(9, 12, 'yuvan', 'prasad', 'Male', 'yuvan@gmail.com', '8683619153', 'Kumar', 800, '2020-03-26', '12:00:00', 1, 1, NULL),
(9, 13, 'yuvan', 'prasad', 'Male', 'yuvan@gmail.com', '8683619153', 'Tin', 450, '2020-03-26', '14:00:00', 1, 1, NULL),
(6, 14, 'sai', 'S', 'Male', 'sai@gmail.com', '9059986865', 'arun', 600, '2025-01-16', '12:00:00', 1, 2, 'completed'),
(6, 15, 'sai', 'S', 'Male', 'sai@gmail.com', '9059986865', 'arun', 600, '2025-01-14', '14:00:00', 1, 1, 'completed'),
(6, 16, 'sai', 'S', 'Male', 'sai@gmail.com', '9059986865', 'arun', 600, '2025-01-14', '16:00:00', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

DROP TABLE IF EXISTS `contact`;
CREATE TABLE IF NOT EXISTS `contact` (
  `name` varchar(30) NOT NULL,
  `email` text NOT NULL,
  `contact` varchar(10) NOT NULL,
  `message` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`name`, `email`, `contact`, `message`) VALUES
('Anu', 'anu@gmail.com', '7896677554', 'Hey Admin'),
(' Viki', 'viki@gmail.com', '9899778865', 'Good Job, Pal'),
('Ananya', 'ananya@gmail.com', '9997888879', 'How can I reach you?'),
('Aakash', 'aakash@gmail.com', '8788979967', 'Love your site'),
('Mani', 'mani@gmail.com', '8977768978', 'Want some coffee?'),
('Karthick', 'karthi@gmail.com', '9898989898', 'Good service'),
('Abi', 'Abi@gmail.com', '8979776868', 'Love your service'),
('Asiq', 'asiq@gmail.com', '9087897564', 'Love your service. Thank you!'),
('Jane', 'jane@gmail.com', '7869869757', 'I love your service!');

-- --------------------------------------------------------

--
-- Table structure for table `doctb`
--

DROP TABLE IF EXISTS `doctb`;
CREATE TABLE IF NOT EXISTS `doctb` (
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `spec` varchar(50) NOT NULL,
  `docFees` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `doctb`
--

INSERT INTO `doctb` (`username`, `password`, `email`, `spec`, `docFees`) VALUES
('ajay', 'ajay123', 'ajay@gmail.com', 'General', 500),
('arun', 'arun123', 'arun@gmail.com', 'Cardiologist', 600),
('Dinesh', 'dinesh123', 'dinesh@gmail.com', 'General', 700),
('Ganesh', 'ganesh123', 'ganesh@gmail.com', 'Pediatrician', 550),
('Kumar', 'kumar123', 'kumar@gmail.com', 'Pediatrician', 800),
('john', 'john123', 'john@gmail.com', 'Cardiologist', 1000),
('Abi', 'Abi123', 'Abi@gmail.com', 'Neurologist', 1500),
('Tin', 'Tin123', 'Tin@gmail.com', 'Pediatrician', 450);

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

DROP TABLE IF EXISTS `documents`;
CREATE TABLE IF NOT EXISTS `documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) DEFAULT NULL,
  `doctor_id` varchar(255) DEFAULT NULL,
  `document_name` varchar(255) DEFAULT NULL,
  `document_type` varchar(50) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `uploaded_by` varchar(50) DEFAULT NULL,
  `upload_date` datetime DEFAULT current_timestamp(),
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `pid`, `doctor_id`, `document_name`, `document_type`, `file_path`, `uploaded_by`, `upload_date`, `description`) VALUES
(2, 6, 'arun', 'doc.pdf', 'application/pdf', 'uploads/678519e5560c5_doc.pdf', 'doctor', '2025-01-13 19:19:25', 'report');

-- --------------------------------------------------------

--
-- Table structure for table `patient_health_details`
--

DROP TABLE IF EXISTS `patient_health_details`;
CREATE TABLE IF NOT EXISTS `patient_health_details` (
  `pid` int(11) NOT NULL,
  `age` int(11) DEFAULT NULL,
  `blood_group` varchar(5) DEFAULT NULL,
  `weight` decimal(5,2) DEFAULT NULL,
  `height` decimal(5,2) DEFAULT NULL,
  `medical_conditions` text DEFAULT NULL,
  `allergies` text DEFAULT NULL,
  `current_medications` text DEFAULT NULL,
  `family_history` text DEFAULT NULL,
  `emergency_contact` varchar(100) DEFAULT NULL,
  `emergency_contact_phone` varchar(15) DEFAULT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient_health_details`
--

INSERT INTO `patient_health_details` (`pid`, `age`, `blood_group`, `weight`, `height`, `medical_conditions`, `allergies`, `current_medications`, `family_history`, `emergency_contact`, `emergency_contact_phone`, `last_updated`) VALUES
(1, 18, 'O+', 54.00, 150.00, 'none', 'no', 'no', 'none', '1234567890', '9965422090', '2025-01-13 10:22:43'),
(2, 45, 'B-', 69.00, 160.00, 'none', 'no', 'no', 'none', '1234567890', '9965422090', '2025-01-13 10:22:43'),
(3, 7, 'A-', 16.00, 75.00, 'none', 'no', 'no', 'none', '1234567890v', '9965422090', '2025-01-13 10:22:43'),
(4, 9, 'AB-', 19.00, 90.00, 'none', 'no', 'no', 'none', '1234567890', '9965422090', '2025-01-13 10:22:43'),
(5, 22, 'A+', 50.00, 155.00, 'none', 'no', 'no', 'none', '1234567890', '9965422090', '2025-01-13 10:22:43'),
(6, 19, 'O-', 65.00, 155.00, 'none', 'no', 'no', 'none', '1234567890', '9965422090', '2025-01-13 13:47:32'),
(7, 63, 'B-', 70.00, 160.00, 'none', 'no', 'no', 'none', '1234567890', '9965422090', '2025-01-13 10:22:43'),
(8, 70, 'O+', 83.00, 162.00, 'none', 'no', 'no', 'none', '1234567890', '9965422090', '2025-01-13 10:22:43'),
(9, 14, 'O-', 26.00, 110.00, 'none', 'no', 'no', 'none', '1234567890', '9965422090', '2025-01-13 10:22:43'),
(10, 7, 'AB+', 12.00, 100.00, 'none', 'no', 'no', 'none', '1234567890', '9965422090', '2025-01-13 10:22:43');

-- --------------------------------------------------------

--
-- Table structure for table `patreg`
--

DROP TABLE IF EXISTS `patreg`;
CREATE TABLE IF NOT EXISTS `patreg` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(20) NOT NULL,
  `lname` varchar(20) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `email` varchar(30) NOT NULL,
  `contact` varchar(10) NOT NULL,
  `password` varchar(30) NOT NULL,
  `cpassword` varchar(30) NOT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `patreg`
--

INSERT INTO `patreg` (`pid`, `fname`, `lname`, `gender`, `email`, `contact`, `password`, `cpassword`) VALUES
(1, 'Anandh', 'K', 'Male', 'Anandh@gmail.com', '9876543210', 'Anandh123', 'Anandh123'),
(2, 'priya', 'B', 'Female', 'priya@gmail.com', '8976897689', 'priya123', 'priya123'),
(3, 'Shahrukh', 'k', 'Male', 'shahrukh@gmail.com', '8976898463', 'shahrukh123', 'shahrukh123'),
(4, 'vishnu', 'V', 'Male', 'vishnu@gmail.com', '9361070035', 'vishnu123', 'vishnu123'),
(5, 'Gowtham', 'S', 'Male', 'Gowtham@gmail.com', '9070897653', 'Gowtham123', 'Gowtham123'),
(6, 'sai', 'S', 'Male', 'sai@gmail.com', '9059986865', 'sai123', 'sai123'),
(7, 'Nancy', 'D', 'Female', 'nancy@gmail.com', '9128972454', 'nancy123', 'nancy123'),
(8, 'Kenny', 'S', 'Male', 'kenny@gmail.com', '9809879868', 'kenny123', 'kenny123'),
(9, 'yuvan', 'prasad', 'Male', 'yuvan@gmail.com', '8683619153', 'yuvan123', 'yuvan123'),
(10, 'Peter', 'N', 'Male', 'peter@gmail.com', '9609362815', 'peter123', 'peter123'),
(11, 'jen', 'Kapoor', 'Female', 'jen@gmail.com', '9768946252', 'loki123', 'loki123');

-- --------------------------------------------------------

--
-- Table structure for table `prestb`
--

DROP TABLE IF EXISTS `prestb`;
CREATE TABLE IF NOT EXISTS `prestb` (
  `doctor` varchar(50) NOT NULL,
  `pid` int(11) NOT NULL,
  `ID` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `appdate` date NOT NULL,
  `apptime` time NOT NULL,
  `disease` varchar(250) NOT NULL,
  `allergy` varchar(250) NOT NULL,
  `prescription` text DEFAULT NULL,
  `patient_details` text DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `blood_group` varchar(5) DEFAULT NULL,
  `height` decimal(5,2) DEFAULT NULL,
  `weight` decimal(5,2) DEFAULT NULL,
  `medical_history` text DEFAULT NULL,
  `emergency_contact` varchar(15) DEFAULT NULL,
  `emergency_relation` varchar(50) DEFAULT NULL,
  `insurance_no` varchar(50) DEFAULT NULL,
  `insurance_provider` varchar(100) DEFAULT NULL,
  `patient_age` int(11) DEFAULT NULL,
  `patient_blood_group` varchar(5) DEFAULT NULL,
  `patient_height` decimal(5,2) DEFAULT NULL,
  `patient_weight` decimal(5,2) DEFAULT NULL,
  `patient_medical_history` text DEFAULT NULL,
  `patient_emergency_contact` varchar(15) DEFAULT NULL,
  `patient_emergency_relation` varchar(50) DEFAULT NULL,
  `patient_insurance_no` varchar(50) DEFAULT NULL,
  `patient_insurance_provider` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `prestb`
--

INSERT INTO `prestb` (`doctor`, `pid`, `ID`, `fname`, `lname`, `appdate`, `apptime`, `disease`, `allergy`, `prescription`, `patient_details`, `age`, `blood_group`, `height`, `weight`, `medical_history`, `emergency_contact`, `emergency_relation`, `insurance_no`, `insurance_provider`, `patient_age`, `patient_blood_group`, `patient_height`, `patient_weight`, `patient_medical_history`, `patient_emergency_contact`, `patient_emergency_relation`, `patient_insurance_no`, `patient_insurance_provider`) VALUES
('Dinesh', 4, 11, 'vishnu', 'V', '2020-03-27', '15:00:00', 'Cough', 'Nothing', 'Just take a teaspoon of Benadryl every night', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('Ganesh', 2, 8, 'priya', 'Bhatt', '2020-03-21', '10:00:00', 'Severe Fever', 'Nothing', 'Take bed rest', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('Kumar', 9, 12, 'yuvan', 'prasad', '2020-03-26', '12:00:00', 'Sever fever', 'nothing', 'Paracetamol -> 1 every morning and night', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('Tin', 9, 13, 'yuvan', 'prasad', '2020-03-26', '14:00:00', 'Cough', 'Skin dryness', 'Intake fruits with more water content', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('arun', 6, 14, 'sai', 'S', '2025-01-16', '12:00:00', 'cold', 'none', 'drink cough syrup', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('arun', 6, 14, 'sai', 'S', '2025-01-16', '12:00:00', 'cold', 'none', 'drink syrup', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `patreg` (`pid`);

--
-- Constraints for table `patient_health_details`
--
ALTER TABLE `patient_health_details`
  ADD CONSTRAINT `patient_health_details_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `patreg` (`pid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
