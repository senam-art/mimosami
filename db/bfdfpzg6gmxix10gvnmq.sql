-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: bfdfpzg6gmxix10gvnmq-mysql.services.clever-cloud.com:3306
-- Generation Time: Nov 26, 2024 at 10:55 PM
-- Server version: 8.0.22-13
-- PHP Version: 8.2.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bfdfpzg6gmxix10gvnmq`
--

-- --------------------------------------------------------

--
-- Table structure for table `adminUsers_mimosami`
--

CREATE TABLE `adminUsers_mimosami` (
  `id` int NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adminUsers_mimosami`
--

INSERT INTO `adminUsers_mimosami` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$zZMPBN1YLxBA9qqAsghDjeVlK/bBJ5ZsQieRD.kXKdQ6t99KUBR2S');

-- --------------------------------------------------------

--
-- Table structure for table `mimosami_basket`
--

CREATE TABLE `mimosami_basket` (
  `basketID` int NOT NULL,
  `productID` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `productName` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `price` int NOT NULL,
  `quantity` int NOT NULL,
  `itemTotal` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mimosami_customer`
--

CREATE TABLE `mimosami_customer` (
  `CustomerID` int NOT NULL,
  `fname` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `lname` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `uname` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `Gender` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `pword` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `phoneNum` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `creditCard` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mimosami_customer`
--

INSERT INTO `mimosami_customer` (`CustomerID`, `fname`, `lname`, `uname`, `Gender`, `email`, `pword`, `phoneNum`, `address`, `creditCard`, `created_at`, `updated_at`) VALUES
(1, 'Akua', 'Doe', '', 'Female', 'akua.doe@gmail.com', 'AkuadOe', NULL, '', 0, '2024-11-22 20:34:37', '2024-11-23 05:10:44'),
(2, 'Senam', 'Smith', '', 'Male', 's.sean@gmail.com', 'Senam', NULL, '', 0, '2024-11-22 20:34:37', '2024-11-23 05:10:57'),
(3, 'Kiki', 'Johnson', '', 'Female', 'k.john@gmail.com', 'hfyufgqre', NULL, '', 0, '2024-11-22 20:34:37', '2024-11-23 05:10:51'),
(6, 'rachel', 'frimps', 'rachel.frimps', 'female', 'rachel.frimpong@gmail.com', '$2y$10$.vgB8KWzb0NP/b83N683R.XyzEfcroCNCwhfOESAVmWBVN/7y9yUW', NULL, NULL, NULL, '2024-11-24 21:50:09', '2024-11-24 21:50:09'),
(7, 'Senam', 'Akoo', 'sena223', 'male', 'qwerty@gmail.com', '$2y$10$ilZcUwUsQxfzx2.451ueM.yLdF3vXPhwtyEhL.rByd0GlZNBN3Wq2', NULL, NULL, NULL, '2024-11-26 14:46:16', '2024-11-26 14:46:16'),
(8, 'maisy', 'baer', 'maisy.baer', 'other', 'maisy@gmail.com', '$2y$10$wU6.C/nGY38jI1pCqdbe4u35xHdndvmDiiynx/E.i4JUiFGNaIAxy', NULL, NULL, NULL, '2024-11-26 21:16:12', '2024-11-26 21:16:12'),
(9, 'maisy', 'baer', 'maisy.baer', 'other', 'baer@gmail.com', '$2y$10$P6WdyJtUaKHfG5vEsQDN8udJEz/mRONifQ3Wbvuu/JHvaWBA/rzke', NULL, NULL, NULL, '2024-11-26 21:27:13', '2024-11-26 21:27:13'),
(10, 'm', 'b', 'maisyb', 'male', 'mb@gmail.com', '$2y$10$I9LOMXDoll9e1IIiPpdrvOm/RhNksbsvzJTmx3GWyiciRIt9lr71a', NULL, NULL, NULL, '2024-11-26 21:28:05', '2024-11-26 21:28:05'),
(11, 'dede', 'amofa', 'dede.amofs', 'female', 'dede@gmail.com', '$2y$10$.qCGHfyJPqSSI94mCCxXheNlH5q3fxKckwGqg566N6x1LOotgdgBS', NULL, NULL, NULL, '2024-11-26 21:31:56', '2024-11-26 21:31:56');

-- --------------------------------------------------------

--
-- Table structure for table `mimosami_inventory`
--

CREATE TABLE `mimosami_inventory` (
  `ItemID` int NOT NULL,
  `ItemName` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Quantity` int NOT NULL,
  `RestockLevel` int NOT NULL,
  `Cost` float NOT NULL,
  `SupplierID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mimosami_inventory`
--

INSERT INTO `mimosami_inventory` (`ItemID`, `ItemName`, `Quantity`, `RestockLevel`, `Cost`, `SupplierID`) VALUES
(1, 'Flour', 100, 20, 70.4, 101),
(2, 'Sugar', 50, 15, 30.2, 102),
(3, 'Butter', 200, 50, 50.4, 103),
(4, 'Eggs', 80, 25, 54.3, 104),
(5, 'Milk', 150, 30, 33.4, 105);

-- --------------------------------------------------------

--
-- Table structure for table `mimosami_order`
--

CREATE TABLE `mimosami_order` (
  `orderID` int NOT NULL,
  `customerID` int NOT NULL,
  `productList` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `quantityList` varchar(225) COLLATE utf8mb4_general_ci NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `total` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mimosami_order`
--

INSERT INTO `mimosami_order` (`orderID`, `customerID`, `productList`, `quantityList`, `createdAt`, `total`) VALUES
(25, 2, 'P001,P002,P002,P001,P001,P001,P003,P001', '3,2,3,3,3,3,2,3', '2024-11-25 20:29:55', '560'),
(26, 1, 'P001,P002,P002,P001,P001,P001,P003,P001', '3,2,3,3,3,3,2,3', '2024-11-26 12:35:44', '560'),
(27, 8, 'P001,P002,P002,P001,P001,P001,P003,P001', '3,2,3,3,3,3,2,3', '2024-11-26 12:38:46', '560'),
(28, 3, 'P001,P002,P002,P001,P001,P001,P003,P001', '3,2,3,3,3,3,2,3', '2024-11-26 12:39:26', '560'),
(29, 6, 'P001', '4', '2024-11-26 12:44:34', '120'),
(30, 1, 'P001', '6', '2024-11-26 12:46:14', '180'),
(31, 1, 'P003', '7', '2024-11-26 14:53:48', '35'),
(32, 1, 'P001', '5', '2024-11-26 18:51:43', '150'),
(33, 1, 'P001', '4', '2024-11-26 22:30:57', '120');

-- --------------------------------------------------------

--
-- Table structure for table `mimosami_products`
--

CREATE TABLE `mimosami_products` (
  `productID` varchar(225) COLLATE utf8mb4_general_ci NOT NULL,
  `productName` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `price` float NOT NULL,
  `Flour` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `Eggs` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `Sugar` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `Butter` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `Packaging` varchar(50) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mimosami_products`
--

INSERT INTO `mimosami_products` (`productID`, `productName`, `price`, `Flour`, `Eggs`, `Sugar`, `Butter`, `Packaging`) VALUES
('P001', 'Cake', 30, '500g', '4', '300g', '200g', 'Box'),
('P002', 'Brownies', 20, '300g', '2', '100g', '50g', 'Wrap'),
('P003', 'Cookies', 5, '250g', '1', '150g', '100g', 'Bag');

-- --------------------------------------------------------

--
-- Table structure for table `mimosami_productsales`
--

CREATE TABLE `mimosami_productsales` (
  `id` int NOT NULL,
  `OrderID` int NOT NULL,
  `CustomerID` int NOT NULL,
  `productID` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `Quantity` int NOT NULL,
  `Date` datetime DEFAULT NULL,
  `Cost` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Amount` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mimosami_productsales`
--

INSERT INTO `mimosami_productsales` (`id`, `OrderID`, `CustomerID`, `productID`, `Quantity`, `Date`, `Cost`, `Amount`) VALUES
(1, 25, 1, 'P001', 3, NULL, NULL, 90),
(2, 28, 1, 'P001', 3, NULL, NULL, 90),
(3, 28, 1, 'P002', 2, NULL, NULL, 40),
(4, 28, 1, 'P002', 3, NULL, NULL, 60),
(5, 28, 1, 'P001', 3, NULL, NULL, 90),
(6, 28, 1, 'P001', 3, NULL, NULL, 90),
(7, 28, 1, 'P001', 3, NULL, NULL, 90),
(8, 28, 1, 'P003', 2, NULL, NULL, 10),
(9, 28, 1, 'P001', 3, NULL, NULL, 90),
(10, 29, 1, 'P001', 4, NULL, NULL, 120),
(11, 30, 1, 'P001', 6, NULL, NULL, 180),
(12, 31, 1, 'P003', 7, NULL, NULL, 35),
(13, 32, 1, 'P001', 5, NULL, NULL, 150),
(14, 33, 1, 'P001', 4, NULL, NULL, 120);

-- --------------------------------------------------------

--
-- Table structure for table `mimosami_sales`
--

CREATE TABLE `mimosami_sales` (
  `Sales ID` int NOT NULL,
  `Date` date NOT NULL,
  `Quantity of sales` int NOT NULL,
  `Cost of sales` int NOT NULL,
  `Amount` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mimosami_sales`
--

INSERT INTO `mimosami_sales` (`Sales ID`, `Date`, `Quantity of sales`, `Cost of sales`, `Amount`) VALUES
(1, '2024-11-01', 100, 5000, 0),
(2, '2024-11-08', 150, 7500, 0),
(3, '2024-11-15', 120, 6000, 0),
(4, '2024-11-22', 90, 4500, 0),
(5, '2024-11-29', 130, 6500, 0);

-- --------------------------------------------------------

--
-- Table structure for table `mimosami_supplier`
--

CREATE TABLE `mimosami_supplier` (
  `SupplierID` int NOT NULL,
  `SupplierName` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `PhoneNumber` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Address` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Email` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `Status` varchar(10) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mimosami_supplier`
--

INSERT INTO `mimosami_supplier` (`SupplierID`, `SupplierName`, `PhoneNumber`, `Address`, `Email`, `Status`) VALUES
(101, 'Supplier A', '123456789', '123 Supplier St', '', 'Active'),
(102, 'Supplier B', '987654321', '456 Supplier Ave', '', 'Active'),
(103, 'Supplier C', '456789123', '789 Supplier Blvd', '', 'Active'),
(104, 'Supplier D', '123789456', '101 Supplier Ln', '', 'Active'),
(105, 'Supplier E', '789123456', '202 Supplier Rd', '', 'Active'),
(106, 'John Doe', '+1234567890', '123 Elm Street, Cityville', 'john.doe@example.com', 'active'),
(107, 'Senam', '3208923930', '329ijndw', 'sesdd@gmail.com', 'active'),
(108, 'Senam', '387832923', 'nidjnds', 'sennisdn@gmail.com', 'active'),
(109, 'Senma', '98237832', 'eunijnksd@gmail.ocm', 'eunijnksd@gmail.ocm', 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adminUsers_mimosami`
--
ALTER TABLE `adminUsers_mimosami`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mimosami_basket`
--
ALTER TABLE `mimosami_basket`
  ADD PRIMARY KEY (`basketID`);

--
-- Indexes for table `mimosami_customer`
--
ALTER TABLE `mimosami_customer`
  ADD PRIMARY KEY (`CustomerID`);

--
-- Indexes for table `mimosami_inventory`
--
ALTER TABLE `mimosami_inventory`
  ADD PRIMARY KEY (`ItemID`),
  ADD KEY `foreign key supplier` (`SupplierID`);

--
-- Indexes for table `mimosami_order`
--
ALTER TABLE `mimosami_order`
  ADD PRIMARY KEY (`orderID`),
  ADD KEY `foreign key customer` (`customerID`),
  ADD KEY `FK_PersonOrder` (`productList`);

--
-- Indexes for table `mimosami_products`
--
ALTER TABLE `mimosami_products`
  ADD PRIMARY KEY (`productID`);

--
-- Indexes for table `mimosami_productsales`
--
ALTER TABLE `mimosami_productsales`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `foreign key customer` (`CustomerID`);

--
-- Indexes for table `mimosami_sales`
--
ALTER TABLE `mimosami_sales`
  ADD PRIMARY KEY (`Sales ID`);

--
-- Indexes for table `mimosami_supplier`
--
ALTER TABLE `mimosami_supplier`
  ADD PRIMARY KEY (`SupplierID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mimosami_basket`
--
ALTER TABLE `mimosami_basket`
  MODIFY `basketID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `mimosami_customer`
--
ALTER TABLE `mimosami_customer`
  MODIFY `CustomerID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `mimosami_order`
--
ALTER TABLE `mimosami_order`
  MODIFY `orderID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `mimosami_productsales`
--
ALTER TABLE `mimosami_productsales`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `mimosami_inventory`
--
ALTER TABLE `mimosami_inventory`
  ADD CONSTRAINT `foreign key supplier` FOREIGN KEY (`SupplierID`) REFERENCES `mimosami_supplier` (`SupplierID`);

--
-- Constraints for table `mimosami_order`
--
ALTER TABLE `mimosami_order`
  ADD CONSTRAINT `foreign key customer` FOREIGN KEY (`customerID`) REFERENCES `mimosami_customer` (`CustomerID`);

--
-- Constraints for table `mimosami_productsales`
--
ALTER TABLE `mimosami_productsales`
  ADD CONSTRAINT `foreign key customers` FOREIGN KEY (`CustomerID`) REFERENCES `mimosami_customer` (`CustomerID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
