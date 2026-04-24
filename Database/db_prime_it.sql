-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 24, 2026 at 08:13 AM
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
-- Database: `db_prime_it`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_applicants`
--

CREATE TABLE `tbl_applicants` (
  `Id` int(11) NOT NULL,
  `Applicant_Id` varchar(11) NOT NULL,
  `Applicant_Name` varchar(150) NOT NULL,
  `Applicant_Address` varchar(1000) DEFAULT NULL,
  `Applicant_Contact` varchar(15) NOT NULL,
  `Applicant_Email` varchar(150) NOT NULL,
  `Applicant_CV` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_applicants`
--

INSERT INTO `tbl_applicants` (`Id`, `Applicant_Id`, `Applicant_Name`, `Applicant_Address`, `Applicant_Contact`, `Applicant_Email`, `Applicant_CV`) VALUES
(46, 'APP0001', 'Ridmal Akmeemana', '570/4, Pathalwatte Rd, Erewwala, Pannipitiya', '0773697070', 'rajeewaakmeemana@gmail.com', 'Files/APP0001.pdf?v=1776421284'),
(47, 'APP0002', 'Nilesh Akmeemana', '570/4, Pathalwatte Rd, Erewwala, Pannipitiya', '0746681121', 'nileshnirmalakmeemana@gmail.com', 'Files/APP0002.pdf?v=1776705932'),
(52, 'APP0003', 'Kasun Chanuka', '170 Charles Street', '0715698774', 'quizproject89@gmail.com', 'Files/APP0003.pdf?v=1776927063');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_applications`
--

CREATE TABLE `tbl_applications` (
  `Id` int(11) NOT NULL,
  `Application_Id` varchar(11) NOT NULL,
  `Vacancy_Id` varchar(11) NOT NULL,
  `Applicant_Id` varchar(11) NOT NULL,
  `Status` enum('Pending','Sort Listed','Rejected','Interview','Hired') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_applications`
--

INSERT INTO `tbl_applications` (`Id`, `Application_Id`, `Vacancy_Id`, `Applicant_Id`, `Status`) VALUES
(39, 'RES0001', 'JOB0005', 'APP0001', 'Hired'),
(40, 'RES0002', 'JOB0002', 'APP0002', 'Pending');

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
(194, 'addNewDepartment.php', 'Departments', 'Add'),
(195, 'getAllDepartmentData.php', 'Departments', 'View'),
(196, 'updateDepartment.php', 'Departments', 'Edit'),
(197, 'deleteDepartment.php', 'Departments', 'Delete'),
(202, 'getAllReviewsData.php', 'Reviews', 'View'),
(203, 'updateReview.php', 'Reviews', 'Edit'),
(204, 'deleteReview.php', 'Reviews', 'Delete'),
(205, 'addNewLocation.php', 'Locations', 'Add'),
(206, 'getAllLocationData.php', 'Locations', 'View'),
(207, 'updatelocation.php', 'Locations', 'Edit'),
(208, 'deleteLocation.php', 'Locations', 'Delete'),
(209, 'addNewType.php', 'Job Type', 'Add'),
(210, 'getAllTypeData.php', 'Job Type', 'View'),
(211, 'updateType.php', 'Job Type', 'Edit'),
(212, 'deleteType.php', 'Job Type', 'Delete'),
(213, 'addNewVacancy.php', 'Vacancies', 'Add'),
(214, 'getAllVacancyData.php', 'Vacancies', 'View'),
(215, 'updateVacancy.php', 'Vacancies', 'Edit'),
(216, 'deleteVacancy.php', 'Vacancies', 'Delete'),
(217, 'viewVacancyData.php', 'Vacancies', 'View'),
(218, 'activeVacancy.php', 'Vacancies', 'Status Change'),
(219, 'viewApplication.php', 'Application', 'View'),
(220, 'getAllApplicantData.php', 'Applicant', 'View'),
(221, 'deleteApplicant.php', 'Applicant', 'Delete'),
(222, 'getAllApplicationData.php', 'Application', 'View'),
(223, 'deleteApplication.php', 'Application', 'Delete'),
(224, 'updateApplicationStatus.php', 'Application', 'View'),
(225, 'getAllIndividualData.php', 'Individuals', 'View'),
(226, 'deleteIndividual.php', 'Individuals', 'Delete'),
(227, 'updateIndividualStatus.php', 'Individuals', 'View'),
(228, 'viewIndividual.php', 'Individuals', 'View'),
(229, 'getAllInquiriesData.php', 'Inquiries', 'View'),
(230, 'deleteInquiries.php', 'Inquiries', 'Delete');

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
(1075, 'Super Admin', 127),
(1076, 'Super Admin', 128),
(1079, 'Super Admin', 101),
(1080, 'Super Admin', 105),
(1087, 'Super Admin', 172),
(1088, 'Super Admin', 173),
(1089, 'Super Admin', 174),
(1090, 'Super Admin', 175),
(1098, 'Super Admin', 196),
(1099, 'Super Admin', 197),
(1132, 'Super Admin', 110),
(1133, 'Super Admin', 121),
(1161, 'Super Admin', 116),
(1162, 'Super Admin', 133),
(1163, 'Super Admin', 132),
(1164, 'Super Admin', 135),
(1165, 'Super Admin', 134),
(1235, 'Super Admin', 204),
(1236, 'Super Admin', 202),
(1238, 'Super Admin', 194),
(1239, 'Super Admin', 195),
(1240, 'Super Admin', 205),
(1241, 'Super Admin', 208),
(1242, 'Super Admin', 206),
(1243, 'Super Admin', 207),
(1246, 'Super Admin', 210),
(1248, 'Super Admin', 209),
(1249, 'Super Admin', 212),
(1250, 'Super Admin', 211),
(1252, 'Super Admin', 126),
(1253, 'Super Admin', 129),
(1255, 'Super Admin', 213),
(1256, 'Super Admin', 216),
(1257, 'Super Admin', 214),
(1258, 'Super Admin', 217),
(1259, 'Super Admin', 215),
(1260, 'Super Admin', 125),
(1261, 'Super Admin', 130),
(1262, 'System User', 125),
(1263, 'System User', 130),
(1264, 'System User', 128),
(1265, 'System User', 126),
(1266, 'System User', 129),
(1267, 'System User', 127),
(1268, 'Super Admin', 203),
(1269, 'Super Admin', 218),
(1270, 'Super Admin', 219),
(1271, 'Super Admin', 220),
(1272, 'Super Admin', 221),
(1273, 'Super Admin', 222),
(1274, 'Super Admin', 223),
(1275, 'Super Admin', 224),
(1276, 'Super Admin', 226),
(1277, 'Super Admin', 225),
(1278, 'Super Admin', 227),
(1279, 'Super Admin', 228),
(1281, 'Super Admin', 229),
(1282, 'Super Admin', 230);

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
(1, 'Prime IT Solutions Private Limited', 'No. 36, Nugegoda Road, Pepiliyana, Sri Lanka', 'orbissolutionslk@gmail.com', '+94(11)5672666', '+94(11)5752117 ', NULL);

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

--
-- Dumping data for table `tbl_contact`
--

INSERT INTO `tbl_contact` (`Id`, `Customer_Id`, `Subject`, `Message`, `Created_Date`) VALUES
(19, 'CUS0001', 'Requesting An Appointment', 'Need a Time to Make an appointment', '2026-04-23 16:44:27');

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
(25, 'CUS0005', 'Dulan Malintha', 'Digana Rd, Kottawa', '0773697071', 'dulan@gmail.com'),
(26, 'CUS0006', 'Nilesh Akmeemana', '570/4, Erewwala, Pannipitiya', '0787223917', 'nileshnirmalakmeemana@gmail.com'),
(28, 'CUS0008', 'C.M.F Sriyana', 'Rotuphilla Akiriya', '0774569898', 'sriyana@gmail.com'),
(29, 'CUS0009', 'Gayan Akmeemana', '570/4, Pathalwatte Rd, Erewwala, Pannipitiya', '0766061234', 'gayanakmeemana@yahoo.com'),
(30, 'CUS0010', 'Ruwan Weerasuriya', '<p>Air Resources Management Center, Sri Lanka</p>', '0774569870', 'test@gmail.com'),
(31, 'CUS0011', 'Kasun Chanuka', '666 Parramatta Road, Croydon NSW 2132', '0774569873', 'kasun@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_departments`
--

CREATE TABLE `tbl_departments` (
  `Id` int(11) NOT NULL,
  `Department_Name` varchar(50) NOT NULL,
  `Department_description` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_departments`
--

INSERT INTO `tbl_departments` (`Id`, `Department_Name`, `Department_description`) VALUES
(12, 'Software Development', '<p>Designs, develops, tests, and maintains software applications and systems for clients or internal use.</p>'),
(13, 'Quality Assurance', '<p>Ensures software quality by testing applications, identifying bugs, and verifying performance before release.</p>'),
(14, 'Cybersecurity', '<p>Protects systems, networks, and data from cyber threats, attacks, and unauthorized access.</p>'),
(15, 'Network & Infrastructure', '<p>Manages servers, networks, cloud systems, and ensures stable connectivity and performance.</p>'),
(16, 'Research & Development', '<p>Explores new technologies, tools, and innovations to improve products and services.</p>'),
(17, 'Project Management', '<p>Plans, manages, and monitors IT projects to ensure they are completed on time and within budget.</p>'),
(18, 'Business Analysis', '<p>Analyzes business needs and translates them into technical requirements for development teams.</p>'),
(19, 'Customer Support', '<p>Provides timely assistance ensuring customer satisfaction and maintaining strong client relationships.</p>'),
(20, 'IoT Solutions', '<p>Architect and deploy IoT solutions for industrial and commercial applications.</p>');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_individuals`
--

CREATE TABLE `tbl_individuals` (
  `Id` int(11) NOT NULL,
  `Individuals_Id` varchar(11) NOT NULL,
  `Job_Title` varchar(50) NOT NULL,
  `Applicant_Id` varchar(11) NOT NULL,
  `Status` enum('Pending','Sort Listed','Rejected','Interview','Hired') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_individuals`
--

INSERT INTO `tbl_individuals` (`Id`, `Individuals_Id`, `Job_Title`, `Applicant_Id`, `Status`) VALUES
(46, 'IND0001', 'Lecture', 'APP0003', 'Pending'),
(47, 'IND0002', 'SE', 'APP0002', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_locations`
--

CREATE TABLE `tbl_locations` (
  `Id` int(11) NOT NULL,
  `Postal_Code` varchar(50) NOT NULL,
  `Location_Name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_locations`
--

INSERT INTO `tbl_locations` (`Id`, `Postal_Code`, `Location_Name`) VALUES
(1, '10230', 'Erewwala, Sri Lanka'),
(2, '10280', 'Maharagama, Sri Lanka'),
(3, '11450', 'Katunayake, Sri Lanka'),
(4, '00900', 'Dematagoda, Sri Lanka'),
(5, 'REMT', 'Remote'),
(9, '10360', 'Panadura, Sri Lanka'),
(10, '15556', 'Colombo, Sri Lanka');

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
(7, 'CUS0005', 3, 'Best', 1, '2026-01-06 14:04:44'),
(8, 'CUS0010', 5, 'Prime IT Solutions showed professionalism and outstanding developer efficiency. Any questions and problems, arising during the development cycle, were attended to by Prime specialists in a timely fashion leaving no unresolved issues.Prime team always remained responsive, demonstrated great communicative skills and ensured smooth interaction throughout all development and implementation stages, suggesting articulate and consistent decisions and viable solutions for our project.Prime ensured fast finalization of our project and fully met our expectations, concerning the time to bring the new features to our clients. We won\'t hesitate to turn to Prime services again and hope for further fruitful collaboration.', 1, '2026-02-07 07:03:25');

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
(348, 'add_departments.php', 'Departments', 'View'),
(352, 'reviews.php', 'Reviews', 'View'),
(353, 'add_locations.php', 'Locations', 'View'),
(354, 'add_types.php', 'Job Type', 'View'),
(355, 'add_vacancies.php', 'Vacancies', 'View'),
(356, 'view_vacancies.php', 'Vacancies', 'View'),
(357, 'view_applicants.php', 'Applicant', 'View'),
(358, 'view_applications.php', 'Application', 'View'),
(359, 'view_individuals.php', 'Individuals', 'View'),
(360, 'inquiries.php', 'Inquiries', 'View');

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
(495, 'Super Admin', 333),
(507, 'Super Admin', 303),
(517, 'Super Admin', 307),
(518, 'Super Admin', 312),
(545, 'Super Admin', 352),
(546, 'Super Admin', 348),
(547, 'Super Admin', 353),
(548, 'Super Admin', 354),
(549, 'Super Admin', 310),
(550, 'Super Admin', 311),
(551, 'Super Admin', 355),
(552, 'Super Admin', 356),
(553, 'System User', 310),
(554, 'System User', 311),
(555, 'Super Admin', 357),
(556, 'Super Admin', 358),
(557, 'Super Admin', 359),
(558, 'Super Admin', 360);

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
-- Table structure for table `tbl_types`
--

CREATE TABLE `tbl_types` (
  `Id` int(11) NOT NULL,
  `Job_Type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_types`
--

INSERT INTO `tbl_types` (`Id`, `Job_Type`) VALUES
(12, 'Contract'),
(10, 'Full-Time'),
(11, 'Part-Time');

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

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vacancies`
--

CREATE TABLE `tbl_vacancies` (
  `Id` int(11) NOT NULL,
  `Vacancy_Id` varchar(11) NOT NULL,
  `Job_Title` varchar(50) NOT NULL,
  `Department_Id` int(11) NOT NULL,
  `Job_Description` varchar(2500) NOT NULL,
  `Location_Id` int(11) NOT NULL,
  `Type_Id` int(11) NOT NULL,
  `Is_Active` tinyint(1) NOT NULL,
  `Created_Date` datetime NOT NULL,
  `Closing_Date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_vacancies`
--

INSERT INTO `tbl_vacancies` (`Id`, `Vacancy_Id`, `Job_Title`, `Department_Id`, `Job_Description`, `Location_Id`, `Type_Id`, `Is_Active`, `Created_Date`, `Closing_Date`) VALUES
(29, 'JOB0001', 'Senior Software Engineer', 12, '<p>Lead development of enterprise software solutions using modern technologies.</p>', 5, 10, 1, '2026-04-04 13:02:28', '2026-04-04 16:05:00'),
(30, 'JOB0002', 'Cybersecurity Analyst', 14, '<p>Monitor and protect systems from security threats and vulnerabilities.</p>', 4, 11, 1, '2026-03-19 15:21:02', '2026-03-23 15:21:02'),
(32, 'JOB0003', 'Network Infrastructure Engineer', 15, '<p>Design and implement network infrastructure for enterprise clients.</p>', 1, 12, 1, '2026-03-19 17:30:41', '2026-03-19 17:30:41'),
(37, 'JOB0004', 'IoT Solutions Architect', 20, '<p class=\"text-muted-foreground mb-4 leading-relaxed\">Architect and deploy <strong>IoT solutions</strong> for industrial and commercial applications.</p>', 10, 10, 1, '2026-03-24 23:25:38', '2026-04-01 00:00:00'),
(38, 'JOB0005', 'Quality Assurance Engineer', 13, '<p>Software Quality Assurance (SQA) is a proactive process-oriented approach ensuring software meets quality standards, user needs, and business goals throughout the development lifecycle.</p>', 5, 10, 1, '2026-04-07 22:21:00', '2026-04-01 08:37:00'),
(44, 'JOB0006', 'Cybersecurity Analyst', 14, '<p>QA Test</p>', 2, 11, 1, '2026-04-04 12:32:20', '2026-03-31 23:46:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_applicants`
--
ALTER TABLE `tbl_applicants`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Customer_Id` (`Applicant_Id`),
  ADD UNIQUE KEY `Customer_Contact` (`Applicant_Contact`,`Applicant_Email`);

--
-- Indexes for table `tbl_applications`
--
ALTER TABLE `tbl_applications`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Application_Id` (`Application_Id`),
  ADD KEY `Vacancy_Id` (`Vacancy_Id`,`Applicant_Id`),
  ADD KEY `Applicant_Id` (`Applicant_Id`);

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
-- Indexes for table `tbl_departments`
--
ALTER TABLE `tbl_departments`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Addon_Name` (`Department_Name`);

--
-- Indexes for table `tbl_individuals`
--
ALTER TABLE `tbl_individuals`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Individuals_Id` (`Individuals_Id`),
  ADD KEY `Vacancy_Id` (`Applicant_Id`),
  ADD KEY `Applicant_Id` (`Applicant_Id`);

--
-- Indexes for table `tbl_locations`
--
ALTER TABLE `tbl_locations`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Postal_Code` (`Postal_Code`),
  ADD UNIQUE KEY `Location_Name` (`Location_Name`);

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
-- Indexes for table `tbl_types`
--
ALTER TABLE `tbl_types`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Location_Name` (`Job_Type`),
  ADD UNIQUE KEY `Location_Name_2` (`Job_Type`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD KEY `Status` (`Status`);

--
-- Indexes for table `tbl_vacancies`
--
ALTER TABLE `tbl_vacancies`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Package_Id` (`Vacancy_Id`),
  ADD KEY `Department_Id` (`Department_Id`,`Location_Id`,`Type_Id`),
  ADD KEY `Type_Id` (`Type_Id`),
  ADD KEY `Location_Id` (`Location_Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_applicants`
--
ALTER TABLE `tbl_applicants`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `tbl_applications`
--
ALTER TABLE `tbl_applications`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `tbl_backend`
--
ALTER TABLE `tbl_backend`
  MODIFY `Backend_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=231;

--
-- AUTO_INCREMENT for table `tbl_backend_permissions`
--
ALTER TABLE `tbl_backend_permissions`
  MODIFY `Permission_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1283;

--
-- AUTO_INCREMENT for table `tbl_company_info`
--
ALTER TABLE `tbl_company_info`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_contact`
--
ALTER TABLE `tbl_contact`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tbl_customers`
--
ALTER TABLE `tbl_customers`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `tbl_departments`
--
ALTER TABLE `tbl_departments`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tbl_individuals`
--
ALTER TABLE `tbl_individuals`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `tbl_locations`
--
ALTER TABLE `tbl_locations`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_reviews`
--
ALTER TABLE `tbl_reviews`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tbl_screens`
--
ALTER TABLE `tbl_screens`
  MODIFY `Screen_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=361;

--
-- AUTO_INCREMENT for table `tbl_screen_permissions`
--
ALTER TABLE `tbl_screen_permissions`
  MODIFY `Permission_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=559;

--
-- AUTO_INCREMENT for table `tbl_system_configuration`
--
ALTER TABLE `tbl_system_configuration`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_types`
--
ALTER TABLE `tbl_types`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_vacancies`
--
ALTER TABLE `tbl_vacancies`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_applications`
--
ALTER TABLE `tbl_applications`
  ADD CONSTRAINT `tbl_applications_ibfk_1` FOREIGN KEY (`Vacancy_Id`) REFERENCES `tbl_vacancies` (`Vacancy_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `tbl_applications_ibfk_2` FOREIGN KEY (`Applicant_Id`) REFERENCES `tbl_applicants` (`Applicant_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_backend_permissions`
--
ALTER TABLE `tbl_backend_permissions`
  ADD CONSTRAINT `tbl_backend_permissions_ibfk_2` FOREIGN KEY (`Role`) REFERENCES `tbl_roles` (`Role_Name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_individuals`
--
ALTER TABLE `tbl_individuals`
  ADD CONSTRAINT `tbl_individuals_ibfk_1` FOREIGN KEY (`Applicant_Id`) REFERENCES `tbl_applicants` (`Applicant_Id`) ON DELETE CASCADE ON UPDATE CASCADE;

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

--
-- Constraints for table `tbl_vacancies`
--
ALTER TABLE `tbl_vacancies`
  ADD CONSTRAINT `tbl_vacancies_ibfk_1` FOREIGN KEY (`Department_Id`) REFERENCES `tbl_departments` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_vacancies_ibfk_2` FOREIGN KEY (`Type_Id`) REFERENCES `tbl_types` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_vacancies_ibfk_3` FOREIGN KEY (`Location_Id`) REFERENCES `tbl_locations` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
