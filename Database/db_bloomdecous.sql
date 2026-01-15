-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 06, 2026 at 10:21 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_bloomdecous`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_addon`
--

CREATE TABLE `tbl_addon` (
  `Id` int(11) NOT NULL,
  `Addon_Name` varchar(50) NOT NULL,
  `Addon_description` varchar(250) NOT NULL,
  `Addon_Price` float(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_addon`
--

INSERT INTO `tbl_addon` (`Id`, `Addon_Name`, `Addon_description`, `Addon_Price`) VALUES
(1, 'Balloon Centerpieces', '<p>balloon centerpieces $35up</p>', 35.00),
(2, 'Flower Centerpieces', '<p>flower centerpieces $40 up</p>', 12.00),
(4, 'Welcome Sign size 18”by 24”', '<p>Welcome Sign size 18&rdquo;by 24&rdquo; $60 and up</p>', 60.00),
(5, 'Love Seat', '<p>Love Seat $100</p>', 100.00);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_backend`
--

CREATE TABLE `tbl_backend` (
  `Backend_Id` int(11) NOT NULL,
  `Backend_Name` varchar(100) NOT NULL,
  `Screen_Category` varchar(20) NOT NULL,
  `Screen_Sub_Category` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_backend`
--

INSERT INTO `tbl_backend` (`Backend_Id`, `Backend_Name`, `Screen_Category`, `Screen_Sub_Category`) VALUES
(101, 'addNewCustomer.php', 'Customers', 'Add'),
(105, 'deleteCustomer.php', 'Customers', 'Delete'),
(110, 'getAllCustomerData.php', 'Customers', 'View'),
(116, 'updateCustomer.php', 'Customers', 'Edit'),
(121, 'viewCustomerData.php', 'Customers', 'View'),
(125, 'addNewRole.php', 'Roles', 'Add'),
(126, 'getAllRoleData.php', 'Roles', 'View'),
(127, 'updateRole.php', 'Roles', 'Edit'),
(128, 'deleteRole.php', 'Roles', 'Delete'),
(129, 'viewRoleData.php', 'Roles', 'View'),
(130, 'savePermissions.php', 'Roles', 'Add'),
(132, 'addNewUser.php', 'Users', 'Add'),
(133, 'getAllUserData.php', 'Users', 'View'),
(134, 'updateUser.php', 'Users', 'Edit'),
(135, 'deleteUser.php', 'Users', 'Delete'),
(172, 'getCompanyDetails.php', 'System Information', 'View'),
(173, 'updateCompany.php', 'System Information', 'View'),
(174, 'getSystemConfiguration.php', 'System Information', 'View'),
(175, 'updateConfiguration.php', 'System Information', 'View'),
(188, 'getAllPackageData.php', 'Packages', 'View'),
(189, 'getPackageDetails.php', 'Packages', 'Add'),
(190, 'addNewPackage.php', 'Packages', 'Add'),
(191, 'updatePackage.php', 'Packages', 'Edit'),
(192, 'deletePackage.php', 'Packages', 'Delete'),
(194, 'addNewAddon.php', 'Addons', 'Add'),
(195, 'getAllAddonData.php', 'Addons', 'View'),
(196, 'updateAddon.php', 'Addons', 'Edit'),
(197, 'deleteAddon.php', 'Addons', 'Delete'),
(198, 'getAllOrderData.php', 'Orders', 'View'),
(199, 'viewOrderData.php', 'Orders', 'View'),
(200, 'updateOrder.php', 'Orders', 'Edit'),
(201, 'deleteOrder.php', 'Orders', 'Delete'),
(202, 'getAllReviewsData.php', 'Reviews', 'View'),
(203, 'updateReview.php', 'Reviews', 'Edit'),
(204, 'deleteReview.php', 'Reviews', 'Delete');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_backend_permissions`
--

CREATE TABLE `tbl_backend_permissions` (
  `Permission_Id` int(11) NOT NULL,
  `Role` varchar(50) NOT NULL,
  `Backend_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_backend_permissions`
--

INSERT INTO `tbl_backend_permissions` (`Permission_Id`, `Role`, `Backend_Id`) VALUES
(1074, 'Super Admin', 126),
(1075, 'Super Admin', 127),
(1076, 'Super Admin', 128),
(1077, 'Super Admin', 129),
(1079, 'Super Admin', 101),
(1080, 'Super Admin', 105),
(1087, 'Super Admin', 172),
(1088, 'Super Admin', 173),
(1089, 'Super Admin', 174),
(1090, 'Super Admin', 175),
(1091, 'Super Admin', 188),
(1092, 'Super Admin', 189),
(1093, 'Super Admin', 190),
(1094, 'Super Admin', 191),
(1095, 'Super Admin', 192),
(1096, 'Super Admin', 194),
(1097, 'Super Admin', 195),
(1098, 'Super Admin', 196),
(1099, 'Super Admin', 197),
(1132, 'Super Admin', 110),
(1133, 'Super Admin', 121),
(1161, 'Super Admin', 116),
(1162, 'Super Admin', 133),
(1163, 'Super Admin', 132),
(1164, 'Super Admin', 135),
(1165, 'Super Admin', 134),
(1166, 'Super Admin', 125),
(1167, 'Super Admin', 130),
(1227, 'Super Admin', 201),
(1228, 'Super Admin', 198),
(1229, 'Super Admin', 199),
(1231, 'Super Admin', 200),
(1235, 'Super Admin', 204),
(1236, 'Super Admin', 202),
(1237, 'Super Admin', 203);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_company_info`
--

CREATE TABLE `tbl_company_info` (
  `Id` int(11) NOT NULL,
  `Company_Name` varchar(150) NOT NULL,
  `Company_Address` varchar(1000) NOT NULL,
  `Company_Email` varchar(150) NOT NULL,
  `Company_Tel1` varchar(15) NOT NULL,
  `Company_Tel2` varchar(15) DEFAULT NULL,
  `Company_Tel3` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_company_info`
--

INSERT INTO `tbl_company_info` (`Id`, `Company_Name`, `Company_Address`, `Company_Email`, `Company_Tel1`, `Company_Tel2`, `Company_Tel3`) VALUES
(1, 'Bloom Decous', 'New York, NY, United States, New York 10306', 'orbissolutionslk@gmail.com', '+1 929-421-6047', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contact`
--

CREATE TABLE `tbl_contact` (
  `Id` int(11) NOT NULL,
  `Customer_Id` varchar(11) NOT NULL,
  `Subject` varchar(150) NOT NULL,
  `Message` varchar(1000) NOT NULL,
  `Created_Date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customers`
--

CREATE TABLE `tbl_customers` (
  `Id` int(11) NOT NULL,
  `Customer_Id` varchar(11) NOT NULL,
  `Customer_Name` varchar(150) NOT NULL,
  `Customer_Address` varchar(1000) DEFAULT NULL,
  `Customer_Contact` varchar(15) NOT NULL,
  `Customer_Email` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_customers`
--

INSERT INTO `tbl_customers` (`Id`, `Customer_Id`, `Customer_Name`, `Customer_Address`, `Customer_Contact`, `Customer_Email`) VALUES
(16, 'CUS0001', 'Ridmal Akmeemana', '570/4, Erewwala, Pannipitiya', '0773697070', 'rajeewaakmeemana@gmail.com'),
(20, 'CUS0003', 'Dulan Malintha', 'Digana Rd, Kottawa', '0712658801', 'orbissolutionslk@gmail.com'),
(25, 'CUS0005', 'Dulan Malintha', 'Digana Rd, Kottawa', '0773697071', 'dulan@gmail.com'),
(26, 'CUS0006', 'Nilesh Akmeemana', '570/4, Erewwala, Pannipitiya', '0787223917', 'nileshnirmalakmeemana@gmail.com'),
(28, 'CUS0008', 'C.M.F Sriyana', 'Rotuphilla Akiriya', '0774569898', 'sriyana@gmail.com'),
(29, 'CUS0009', 'Gayan Akmeemana', '570/4, Pathalwatte Rd, Erewwala, Pannipitiya', '0766061234', 'gayanakmeemana@yahoo.com');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_orders`
--

CREATE TABLE `tbl_orders` (
  `Id` int(11) NOT NULL,
  `Order_Id` varchar(11) NOT NULL,
  `Customer_Id` varchar(11) NOT NULL,
  `Package_Id` varchar(11) NOT NULL,
  `Event_Location` varchar(150) NOT NULL,
  `Event_DateTime` datetime NOT NULL,
  `Package_Price` float(10,2) NOT NULL,
  `Status` enum('Pending','Approved','Completed','Rejected','Canceled') NOT NULL,
  `Order_Date` datetime NOT NULL,
  `Reject_Cancel_Reason` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_orders`
--

INSERT INTO `tbl_orders` (`Id`, `Order_Id`, `Customer_Id`, `Package_Id`, `Event_Location`, `Event_DateTime`, `Package_Price`, `Status`, `Order_Date`, `Reject_Cancel_Reason`) VALUES
(139, 'ORD0001', 'CUS0001', 'SHIMER', 'Test 01', '2026-01-05 00:17:00', 17.00, 'Completed', '2026-01-05 00:17:20', '<p><strong>Rejected</strong></p>'),
(141, 'ORD0003', 'CUS0001', 'PAKG005', 'Test 03', '2026-01-06 00:19:00', 20.00, 'Completed', '2026-01-05 00:19:47', NULL),
(142, 'ORD0004', 'CUS0001', 'PAKG002', 'dwdw', '2026-01-07 12:50:00', 15.00, 'Pending', '2026-01-06 12:50:19', NULL),
(143, 'ORD0005', 'CUS0001', 'PAKG002', 'dsd', '2026-01-06 12:53:00', 15.00, 'Pending', '2026-01-06 12:53:14', NULL),
(144, 'ORD0006', 'CUS0001', 'PAKG002', 'sdsd', '2026-01-06 13:56:00', 15.00, 'Pending', '2026-01-06 13:56:12', NULL),
(145, 'ORD0007', 'CUS0001', 'PAKG002', '458845', '2026-01-06 13:58:00', 15.00, 'Pending', '2026-01-06 13:58:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order_addons`
--

CREATE TABLE `tbl_order_addons` (
  `Id` int(11) NOT NULL,
  `Order_Id` varchar(11) NOT NULL,
  `Addon_Id` int(11) NOT NULL,
  `Addon_Price` float(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_order_addons`
--

INSERT INTO `tbl_order_addons` (`Id`, `Order_Id`, `Addon_Id`, `Addon_Price`) VALUES
(185, 'ORD0001', 1, 35.00),
(186, 'ORD0001', 5, 100.00),
(187, 'ORD0004', 1, 35.00),
(188, 'ORD0004', 2, 12.00),
(189, 'ORD0005', 2, 12.00),
(190, 'ORD0005', 4, 60.00),
(191, 'ORD0006', 1, 35.00),
(192, 'ORD0006', 2, 12.00),
(193, 'ORD0007', 1, 35.00),
(194, 'ORD0007', 2, 12.00);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_package`
--

CREATE TABLE `tbl_package` (
  `Id` int(11) NOT NULL,
  `Package_Id` varchar(11) NOT NULL,
  `Package_Name` varchar(50) NOT NULL,
  `Package_Description` varchar(250) NOT NULL,
  `Price` float(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_package`
--

INSERT INTO `tbl_package` (`Id`, `Package_Id`, `Package_Name`, `Package_Description`, `Price`) VALUES
(1, 'PAKG001', 'Package 01', '<ul>\r\n<li>One backdrop with balloon garland (any three colors)</li>\r\n<li>Neon sign (Oh baby sign / birthday sign)</li>\r\n<li>3 Pedestal stands (any color)</li>\r\n</ul>', 25.00),
(2, 'PAKG002', 'Package 02', '<ul>\r\n<li>2 backdrops with balloon garland (any three colors)</li>\r\n<li>Neon sign (Oh baby sign / birthday sign)</li>\r\n<li>3 Pedestal stands (any color)</li>\r\n<li>Floor carpet</li>\r\n</ul>', 15.00),
(8, 'PAKG003', 'Package 03', '<ul>\r\n<li>3 backdrops with balloon garland (any three colors)</li>\r\n<li>Neon sign (Oh baby sign / birthday sign)</li>\r\n<li>3 Pedestal stands (any color)</li>\r\n<li>Floor carpet</li>\r\n</ul>', 20.00),
(9, 'SHIMER', 'Shimmer Wall', '<ul>\r\n<li>Shimmer wall with balloon garland (any three colors)</li>\r\n<li>Neon sign(Oh baby sign / birthday sign,Sweet sixteen)</li>\r\n<li>3 Pedestal stands (any color)</li>\r\n<li>White floor carpet</li>\r\n</ul>', 17.00),
(28, 'PAKG005', 'Package 05', '<ul>\r\n<li>3 backdrops with&nbsp; balloon garland (any three colors)</li>\r\n<li>Neon sign (Oh baby sign / birthday sign)</li>\r\n<li>3 Pedestal stands (any color)</li>\r\n<li>Floor carpet</li>\r\n<li>10 centerpieces</li>\r\n<li>Welcome board decoration.</li>\r\n', 20.00);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reviews`
--

CREATE TABLE `tbl_reviews` (
  `Id` int(11) NOT NULL,
  `Customer_Id` varchar(11) NOT NULL,
  `Star_Rating` int(11) NOT NULL,
  `Message` varchar(1000) NOT NULL,
  `Is_Approved` tinyint(1) NOT NULL,
  `Created_Date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_reviews`
--

INSERT INTO `tbl_reviews` (`Id`, `Customer_Id`, `Star_Rating`, `Message`, `Is_Approved`, `Created_Date`) VALUES
(5, 'CUS0008', 4, 'Highly Recomended', 1, '2026-01-05 23:42:46'),
(7, 'CUS0005', 3, 'Best', 1, '2026-01-06 14:04:44');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_roles`
--

CREATE TABLE `tbl_roles` (
  `Id` int(11) NOT NULL,
  `Role_Id` varchar(11) NOT NULL,
  `Role_Name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_roles`
--

INSERT INTO `tbl_roles` (`Id`, `Role_Id`, `Role_Name`) VALUES
(1, 'ROL0001', 'Super Admin'),
(15, 'ROL0002', 'System User');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_screens`
--

CREATE TABLE `tbl_screens` (
  `Screen_Id` int(11) NOT NULL,
  `Screen_Name` varchar(100) NOT NULL,
  `Screen_Category` varchar(20) NOT NULL,
  `Screen_Sub_Category` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_screens`
--

INSERT INTO `tbl_screens` (`Screen_Id`, `Screen_Name`, `Screen_Category`, `Screen_Sub_Category`) VALUES
(303, 'add_customers.php', 'Customers', 'View'),
(307, 'view_customer.php', 'Customers', 'View'),
(310, 'add_roles.php', 'Roles', 'View'),
(311, 'view_role.php', 'Roles', 'View'),
(312, 'add_users.php', 'Users', 'View'),
(333, 'settings.php', 'System Information', 'View'),
(346, 'add_packages.php', 'Packages', 'View'),
(348, 'add_addons.php', 'Addons', 'View'),
(350, 'orders.php', 'Orders', 'View'),
(351, 'view_order.php', 'Orders', 'View'),
(352, 'reviews.php', 'Reviews', 'View');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_screen_permissions`
--

CREATE TABLE `tbl_screen_permissions` (
  `Permission_Id` int(11) NOT NULL,
  `Role` varchar(50) NOT NULL,
  `Screen_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_screen_permissions`
--

INSERT INTO `tbl_screen_permissions` (`Permission_Id`, `Role`, `Screen_Id`) VALUES
(375, 'Super Admin', 310),
(376, 'Super Admin', 311),
(495, 'Super Admin', 333),
(496, 'Super Admin', 346),
(497, 'Super Admin', 348),
(507, 'Super Admin', 303),
(517, 'Super Admin', 307),
(518, 'Super Admin', 312),
(542, 'Super Admin', 350),
(543, 'Super Admin', 351),
(545, 'Super Admin', 352);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_system_configuration`
--

CREATE TABLE `tbl_system_configuration` (
  `Id` int(11) NOT NULL,
  `Tax_IsPercentage` tinyint(1) DEFAULT NULL,
  `Tax` float(10,2) DEFAULT NULL,
  `Delivery_IsPercentage` tinyint(1) NOT NULL,
  `Delivery` float(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_system_configuration`
--

INSERT INTO `tbl_system_configuration` (`Id`, `Tax_IsPercentage`, `Tax`, `Delivery_IsPercentage`, `Delivery`) VALUES
(1, 1, 0.00, 0, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `Id` int(11) NOT NULL,
  `First_Name` varchar(50) NOT NULL,
  `Last_Name` varchar(50) NOT NULL,
  `Username` varchar(20) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `Status` varchar(20) NOT NULL,
  `Img` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`Id`, `First_Name`, `Last_Name`, `Username`, `Password`, `Status`, `Img`) VALUES
(1, 'Super', 'Administrator', 'super_admin', 'e10adc3949ba59abbe56e057f20f883e', 'Super Admin', 'Images/Admins/default_profile.png'),
(18, 'System', 'User', 'system_user', 'e10adc3949ba59abbe56e057f20f883e', 'System User', 'Images/Admins/default_profile.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_addon`
--
ALTER TABLE `tbl_addon`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Addon_Name` (`Addon_Name`);

--
-- Indexes for table `tbl_backend`
--
ALTER TABLE `tbl_backend`
  ADD PRIMARY KEY (`Backend_Id`);

--
-- Indexes for table `tbl_backend_permissions`
--
ALTER TABLE `tbl_backend_permissions`
  ADD PRIMARY KEY (`Permission_Id`),
  ADD KEY `Backend_Id` (`Backend_Id`),
  ADD KEY `Role` (`Role`);

--
-- Indexes for table `tbl_company_info`
--
ALTER TABLE `tbl_company_info`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tbl_contact`
--
ALTER TABLE `tbl_contact`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Customer_Id` (`Customer_Id`);

--
-- Indexes for table `tbl_customers`
--
ALTER TABLE `tbl_customers`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Customer_Id` (`Customer_Id`),
  ADD UNIQUE KEY `Customer_Contact` (`Customer_Contact`,`Customer_Email`);

--
-- Indexes for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Order_Id` (`Order_Id`),
  ADD KEY `Customer_Id` (`Customer_Id`,`Package_Id`),
  ADD KEY `Package_Id` (`Package_Id`);

--
-- Indexes for table `tbl_order_addons`
--
ALTER TABLE `tbl_order_addons`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Order_Id` (`Order_Id`,`Addon_Id`),
  ADD KEY `Addon_Id` (`Addon_Id`);

--
-- Indexes for table `tbl_package`
--
ALTER TABLE `tbl_package`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Package_Id` (`Package_Id`);

--
-- Indexes for table `tbl_reviews`
--
ALTER TABLE `tbl_reviews`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Customer_Id` (`Customer_Id`);

--
-- Indexes for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Role_Id` (`Role_Id`,`Role_Name`),
  ADD KEY `Role_Name` (`Role_Name`);

--
-- Indexes for table `tbl_screens`
--
ALTER TABLE `tbl_screens`
  ADD PRIMARY KEY (`Screen_Id`);

--
-- Indexes for table `tbl_screen_permissions`
--
ALTER TABLE `tbl_screen_permissions`
  ADD PRIMARY KEY (`Permission_Id`),
  ADD KEY `Screen_Id` (`Screen_Id`),
  ADD KEY `Role` (`Role`);

--
-- Indexes for table `tbl_system_configuration`
--
ALTER TABLE `tbl_system_configuration`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD KEY `Status` (`Status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_addon`
--
ALTER TABLE `tbl_addon`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_backend`
--
ALTER TABLE `tbl_backend`
  MODIFY `Backend_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=205;

--
-- AUTO_INCREMENT for table `tbl_backend_permissions`
--
ALTER TABLE `tbl_backend_permissions`
  MODIFY `Permission_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1238;

--
-- AUTO_INCREMENT for table `tbl_company_info`
--
ALTER TABLE `tbl_company_info`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_contact`
--
ALTER TABLE `tbl_contact`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_customers`
--
ALTER TABLE `tbl_customers`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT for table `tbl_order_addons`
--
ALTER TABLE `tbl_order_addons`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=195;

--
-- AUTO_INCREMENT for table `tbl_package`
--
ALTER TABLE `tbl_package`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tbl_reviews`
--
ALTER TABLE `tbl_reviews`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_screens`
--
ALTER TABLE `tbl_screens`
  MODIFY `Screen_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=353;

--
-- AUTO_INCREMENT for table `tbl_screen_permissions`
--
ALTER TABLE `tbl_screen_permissions`
  MODIFY `Permission_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=546;

--
-- AUTO_INCREMENT for table `tbl_system_configuration`
--
ALTER TABLE `tbl_system_configuration`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_backend_permissions`
--
ALTER TABLE `tbl_backend_permissions`
  ADD CONSTRAINT `tbl_backend_permissions_ibfk_2` FOREIGN KEY (`Role`) REFERENCES `tbl_roles` (`Role_Name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  ADD CONSTRAINT `tbl_orders_ibfk_1` FOREIGN KEY (`Customer_Id`) REFERENCES `tbl_customers` (`Customer_Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_orders_ibfk_2` FOREIGN KEY (`Package_Id`) REFERENCES `tbl_package` (`Package_Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_order_addons`
--
ALTER TABLE `tbl_order_addons`
  ADD CONSTRAINT `tbl_order_addons_ibfk_1` FOREIGN KEY (`Addon_Id`) REFERENCES `tbl_addon` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_order_addons_ibfk_2` FOREIGN KEY (`Order_Id`) REFERENCES `tbl_orders` (`Order_Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_reviews`
--
ALTER TABLE `tbl_reviews`
  ADD CONSTRAINT `tbl_reviews_ibfk_1` FOREIGN KEY (`Customer_Id`) REFERENCES `tbl_customers` (`Customer_Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_screen_permissions`
--
ALTER TABLE `tbl_screen_permissions`
  ADD CONSTRAINT `tbl_screen_permissions_ibfk_2` FOREIGN KEY (`Role`) REFERENCES `tbl_roles` (`Role_Name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD CONSTRAINT `tbl_user_ibfk_1` FOREIGN KEY (`Status`) REFERENCES `tbl_roles` (`Role_Name`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
