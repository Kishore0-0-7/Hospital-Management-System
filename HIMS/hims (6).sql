-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2024 at 12:58 PM
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
-- Database: `hims`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `ID` decimal(7,0) NOT NULL,
  `A_USERNAME` varchar(50) NOT NULL,
  `A_PASSWORD` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`ID`, `A_USERNAME`, `A_PASSWORD`) VALUES
(1, 'admin', 'password');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `CategoryID` int(11) NOT NULL,
  `CategoryName` varchar(255) DEFAULT NULL,
  `SupplierID` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `created_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`CategoryID`, `CategoryName`, `SupplierID`, `status`, `created_date`) VALUES
(1, 'Surgical Requirements', 1, 'Active', '2024-02-28'),
(2, 'Diagnostic Equipment', 2, 'Active', '2024-02-22'),
(3, 'Patient Monitoring Devices', 3, 'Active', '2024-02-14'),
(4, 'Medical Supplies', 4, 'Active', '2024-02-15'),
(5, 'Surgical Instruments', 5, 'Active', '2024-03-03'),
(6, 'Latest Instruments', 4, 'Active', '2024-03-05'),
(16, 'wer', 3, 'Active', '2024-03-07');

-- --------------------------------------------------------

--
-- Stand-in structure for view `combined_view`
-- (See below for the actual view)
--
CREATE TABLE `combined_view` (
`InventoryID` int(11)
,`ItemName` varchar(255)
,`CurrentStock` int(11)
,`CostPerUnit` decimal(10,2)
,`ExpiryDate` date
,`SupplierID` int(11)
,`SupplierName` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `E_ID` decimal(7,0) NOT NULL,
  `E_USERNAME` varchar(20) NOT NULL,
  `E_PASS` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`E_ID`, `E_USERNAME`, `E_PASS`) VALUES
(4567001, 'varshini', 'pass7'),
(4567002, 'anita', 'pass2'),
(4567003, 'harish', 'pass4'),
(4567005, 'amaya', 'pass1'),
(4567006, 'shoaib', 'pass6'),
(4567009, 'shayla', 'pass5'),
(4567010, 'daniel', 'pass3');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `EMP_ID` decimal(7,0) NOT NULL,
  `E_NAME` varchar(20) NOT NULL,
  `E_POS` varchar(30) NOT NULL,
  `E_ADDRESS` varchar(30) NOT NULL,
  `E_PHONE` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`EMP_ID`, `E_NAME`, `E_POS`, `E_ADDRESS`, `E_PHONE`) VALUES
(4567001, 'varshini', 'Doctor', 'Bangalore', '9874569871'),
(4567002, 'anita', 'Nurse', 'Bangalore', '9874569871'),
(4567003, 'harish', 'Manager', 'Mumbai', '9878555271'),
(4567005, 'amaya', 'Manager', 'Bangalore', '8974899871'),
(4567006, 'shoaib', 'Doctor', 'Bangalore', '9874568888');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `InventoryID` int(11) NOT NULL,
  `ItemID` int(11) DEFAULT NULL,
  `CurrentStock` int(11) DEFAULT NULL,
  `ReorderLevel` int(11) DEFAULT NULL,
  `ExpiryDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`InventoryID`, `ItemID`, `CurrentStock`, `ReorderLevel`, `ExpiryDate`) VALUES
(1, 1, 16, 20, '2024-03-06'),
(2, 2, 5, 2, '2025-06-30'),
(3, 3, 100, 6, '2025-10-04'),
(4, 4, 100, 50, '2024-02-29'),
(5, 5, 10, 6, '2024-03-07'),
(6, 2, 43, 13, '2024-02-27');

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `ItemID` int(11) NOT NULL,
  `ItemName` varchar(255) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `CategoryID` int(11) DEFAULT NULL,
  `SupplierID` int(11) DEFAULT NULL,
  `UnitOfMeasure` varchar(50) DEFAULT NULL,
  `CostPerUnit` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`ItemID`, `ItemName`, `Description`, `CategoryID`, `SupplierID`, `UnitOfMeasure`, `CostPerUnit`) VALUES
(1, 'Surgical Scissors', 'Stainless steel scissors for surgical procedures', 1, 1, 'Each', 50.00),
(2, 'Digital X-ray Machines', 'High-resolution X-ray machine for diagnostic imaging', 2, 2, 'Each', 50000.00),
(3, 'ECG Monitor', 'Electrocardiogram monitor for continuous patient heart rate monitoring', 3, 3, 'Each', 2000.00),
(4, 'Surgical Gloves', 'Sterile latex gloves for surgical procedures', 4, 4, 'Box', 15.00),
(5, 'Implant for heart surgery', 'Used for surgeries', 3, 4, 'Each', 30.00);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `SupplierID` int(11) NOT NULL,
  `SupplierName` varchar(255) DEFAULT NULL,
  `ContactInformation` varchar(255) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `PaymentTerms` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`SupplierID`, `SupplierName`, `ContactInformation`, `Address`, `PaymentTerms`) VALUES
(1, 'MedEquip Solutions', 'Medequip@yahoo.com', '123,maple street road,Busan', 'Net 30 day'),
(2, 'PharmaCare Inc.', 'sales@pharmacare.com', '456 Pharmacy Avenue, Townsville, USA', 'Net 45 Days'),
(3, 'SurgiTech Corporation', 'orders@surgitech.com', '789 Surgery Street, Metropolis, USA', 'Net 60 Days'),
(4, 'MediSupplies Ltd.', 'info@medisupplies.com', '101 Health Supplies Road, Villageton, USA', 'Net 30 Day'),
(5, 'Hosp Pharma', 'hosp@gmail.com', '123,Tint Road, canada', 'Net 40 days');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `Transaction_id` int(11) NOT NULL,
  `ItemID` int(11) NOT NULL,
  `Transaction_type` varchar(50) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `Transaction_date` date DEFAULT NULL,
  `E_ID` decimal(7,0) NOT NULL,
  `TotalPrice` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`Transaction_id`, `ItemID`, `Transaction_type`, `quantity`, `Transaction_date`, `E_ID`, `TotalPrice`) VALUES
(1, 1, 'Sale', 10, '2024-02-27', 4567001, 500.00),
(2, 2, 'Purchase', 9, '2024-02-26', 4567002, 450000.00),
(3, 3, 'Transfer', 5, '2024-02-25', 4567003, 10000.00),
(4, 4, 'Return', 90, '2024-02-24', 4567005, 1350.00),
(5, 3, 'sales', 25, '2024-03-07', 4567005, 50000.00);

--
-- Triggers `transaction`
--
DELIMITER $$
CREATE TRIGGER `calculate_total_price_trigger` BEFORE INSERT ON `transaction` FOR EACH ROW BEGIN
    DECLARE item_cost DECIMAL(10,2);
    SELECT CostPerUnit INTO item_cost FROM item WHERE ItemID = NEW.ItemID;
    SET NEW.TotalPrice = NEW.quantity * item_cost;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `calculate_total_price_update_trigger` BEFORE UPDATE ON `transaction` FOR EACH ROW BEGIN
    DECLARE item_cost DECIMAL(10,2);
    SELECT CostPerUnit INTO item_cost FROM item WHERE ItemID = NEW.ItemID;
    SET NEW.TotalPrice = NEW.quantity * item_cost;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure for view `combined_view`
--
DROP TABLE IF EXISTS `combined_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `combined_view`  AS SELECT `inventory`.`InventoryID` AS `InventoryID`, `item`.`ItemName` AS `ItemName`, `inventory`.`CurrentStock` AS `CurrentStock`, `item`.`CostPerUnit` AS `CostPerUnit`, `inventory`.`ExpiryDate` AS `ExpiryDate`, `item`.`SupplierID` AS `SupplierID`, `supplier`.`SupplierName` AS `SupplierName` FROM ((`inventory` join `item` on(`inventory`.`ItemID` = `item`.`ItemID`)) join `supplier` on(`item`.`SupplierID` = `supplier`.`SupplierID`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`CategoryID`),
  ADD KEY `SupplierID` (`SupplierID`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`E_ID`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`InventoryID`),
  ADD KEY `ItemID` (`ItemID`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`ItemID`),
  ADD KEY `CategoryID` (`CategoryID`),
  ADD KEY `SupplierID` (`SupplierID`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`SupplierID`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`Transaction_id`),
  ADD KEY `transaction_ibfk_1` (`ItemID`),
  ADD KEY `transaction_ibfk_2` (`E_ID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `category_ibfk_1` FOREIGN KEY (`SupplierID`) REFERENCES `supplier` (`SupplierID`) ON DELETE CASCADE;

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`ItemID`) REFERENCES `item` (`ItemID`) ON DELETE CASCADE;

--
-- Constraints for table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `item_ibfk_1` FOREIGN KEY (`CategoryID`) REFERENCES `category` (`CategoryID`) ON DELETE CASCADE,
  ADD CONSTRAINT `item_ibfk_2` FOREIGN KEY (`SupplierID`) REFERENCES `supplier` (`SupplierID`) ON DELETE CASCADE;

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`ItemID`) REFERENCES `item` (`ItemID`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaction_ibfk_2` FOREIGN KEY (`E_ID`) REFERENCES `employee` (`E_ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
