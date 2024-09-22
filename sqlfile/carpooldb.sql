-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 06, 2023 at 01:59 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `carpooldb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `UserName` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `updationDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `UserName`, `Password`, `updationDate`) VALUES
(1, 'admin', '5c428d8875d2948607f3e3fe134d71b4', '2017-06-18 12:22:38'),
(2, 'admin@gmail.com', 'abcd@12', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tblbill`
--

CREATE TABLE `tblbill` (
  `billid` int(11) NOT NULL,
  `carid` int(11) NOT NULL,
  `Amount` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblbill`
--

INSERT INTO `tblbill` (`billid`, `carid`, `Amount`) VALUES
(1, 1, 300),
(2, 4, 2000),
(3, 5, 600),
(4, 6, 0),
(6, 6, 1500),
(7, 1, 400),
(8, 6, 200),
(9, 5, 200),
(10, 6, 600),
(11, 8, 250);

-- --------------------------------------------------------

--
-- Table structure for table `tblcars`
--

CREATE TABLE `tblcars` (
  `carid` int(11) NOT NULL,
  `carnumber` varchar(10) NOT NULL,
  `carname` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `Image` varchar(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblcars`
--

INSERT INTO `tblcars` (`carid`, `carnumber`, `carname`, `company`, `Image`) VALUES
(1, 'BUN-664', 'Alto', 'suzuki', 'D:\\carpoolimg\\WhatsApp Image 2023-06-14 at 21.08.05.png'),
(3, 'MKE-223', 'city', 'HONDA', 'D:\\carpoolimg\\WhatsApp Image 2023-06-14 at 21.08.05 (1).png'),
(4, 'BML-346', 'Swift', 'Suzuki', 'D:\\carpoolimg\\image.png'),
(5, 'GPA-029', 'Alsvin', 'CHANGAN', 'D:\\carpoolimg\\image.png'),
(6, 'KLB-123', 'CHIRON', 'BUGGATI', 'D:\\carpoolimg\\k213329lab7task1.png'),
(7, 'KBC-990', 'civic', 'HONDA', 'D:\\carpoolimg\\image.png'),
(8, 'KLE-332', 'Dayz', 'nissan', 'D:\\carpoolimg\\WhatsApp Image 2023-11-26 at 13.09.44_0867c4e0.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbldrivers`
--

CREATE TABLE `tbldrivers` (
  `driverid` int(11) NOT NULL,
  `carid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbldrivers`
--

INSERT INTO `tbldrivers` (`driverid`, `carid`) VALUES
(5, 1),
(5, 3),
(5, 5),
(5, 7),
(10, 6),
(10, 8);

-- --------------------------------------------------------

--
-- Table structure for table `tblpages`
--

CREATE TABLE `tblpages` (
  `id` int(11) NOT NULL,
  `PageName` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT '',
  `detail` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblpages`
--

INSERT INTO `tblpages` (`id`, `PageName`, `type`, `detail`) VALUES
(1, 'Terms and Conditions', 'terms', '																				<p align=\"justify\"><span style=\"font-weight: bold; font-size: large;\">**Terms and Conditions for Carpooling Website**</span><font size=\"2\"><strong><br></strong></font></p><p align=\"justify\"><span style=\"font-size: small;\"><br></span></p><p align=\"justify\"><span style=\"font-size: small; font-weight: bold;\">**1. Acceptance of Terms**</span></p><p align=\"justify\"><span style=\"font-size: small;\"><br></span></p><p align=\"justify\"><span style=\"font-size: small;\">By accessing and using our carpooling website, you agree to comply with and be bound by these terms and conditions. If you do not agree with any part of these terms, you may not use our services.</span></p><p align=\"justify\"><span style=\"font-size: small;\"><br></span></p><p align=\"justify\"><span style=\"font-size: small; font-weight: bold;\">**2. User Eligibility**</span></p><p align=\"justify\"><span style=\"font-size: small;\"><br></span></p><p align=\"justify\"><span style=\"font-size: small;\">You must be at least 18 years old to use our carpooling services. By using the website, you confirm that you meet this eligibility requirement.</span></p><p align=\"justify\"><span style=\"font-size: small;\"><br></span></p><p align=\"justify\"><span style=\"font-size: small;\">**3. User Responsibilities**</span></p><p align=\"justify\"><span style=\"font-size: small;\"><br></span></p><p align=\"justify\"><span style=\"font-size: small; font-weight: bold;\">a. **User Information:**&nbsp;</span><span style=\"font-size: small;\">You are responsible for providing accurate and up-to-date information during the registration process.</span></p><p align=\"justify\"><span style=\"font-size: small;\"><br></span></p><p align=\"justify\"><span style=\"font-size: small;\"><span style=\"font-weight: bold;\">b. **Safety:** </span>Users are responsible for their own safety during carpooling arrangements. It is recommended to verify the identity of the fellow carpoolers before agreeing to share rides.</span></p><p align=\"justify\"><span style=\"font-size: small;\"><br></span></p><p align=\"justify\"><span style=\"font-size: small;\"><span style=\"font-weight: bold;\">c. **Compliance:**</span> Users must comply with all applicable laws and regulations during the carpooling arrangement.</span></p><p align=\"justify\"><span style=\"font-size: small;\"><br></span></p><p align=\"justify\"><span style=\"font-size: small; font-weight: bold;\">**4. User Conduct**</span></p><p align=\"justify\"><span style=\"font-size: small;\"><br></span></p><p align=\"justify\"><span style=\"font-size: small;\"><span style=\"font-weight: bold;\">a. **Respect:** </span>Users must treat each other with respect and courtesy. Any form of harassment, discrimination, or inappropriate behavior is strictly prohibited.</span></p><p align=\"justify\"><span style=\"font-size: small;\"><br></span></p><p align=\"justify\"><span style=\"font-size: small;\"><span style=\"font-weight: bold;\">b. **Communication:** </span>Users should communicate clearly and promptly with each other regarding the carpooling arrangements, including pick-up and drop-off locations and times.</span></p><p align=\"justify\"><span style=\"font-size: small;\"><br></span></p><p align=\"justify\"><span style=\"font-size: small; font-weight: bold;\">**5. Privacy**</span></p><p align=\"justify\"><span style=\"font-size: small;\"><br></span></p><p align=\"justify\"><span style=\"font-size: small;\"><span style=\"font-weight: bold;\">a. **Data Security:**</span> We take the privacy and security of user data seriously. Please refer to our Privacy Policy for details on how we collect, use, and protect your personal information.</span></p><p align=\"justify\"><span style=\"font-size: small;\"><br></span></p><p align=\"justify\"><span style=\"font-size: small;\"><span style=\"font-weight: bold;\">b. **Sharing Information:**</span> Users agree to share only necessary information with fellow carpoolers for the purpose of coordinating rides.</span></p><p align=\"justify\"><span style=\"font-size: small;\"><br></span></p><p align=\"justify\"><span style=\"font-size: small; font-weight: bold;\">**6. Payment and Fees**</span></p><p align=\"justify\"><span style=\"font-size: small;\"><br></span></p><p align=\"justify\"><span style=\"font-size: small;\"><span style=\"font-weight: bold;\">a. **Payment:**</span> Users may agree on a fair and reasonable contribution towards fuel costs or other expenses related to the carpooling arrangement.</span></p><p align=\"justify\"><span style=\"font-size: small;\"><br></span></p><p align=\"justify\"><span style=\"font-size: small;\"><span style=\"font-weight: bold;\">b. **No Profit:**</span> Users are not allowed to make a profit from the carpooling service provided through our platform.</span></p><p align=\"justify\"><span style=\"font-size: small;\"><br></span></p><p align=\"justify\"><span style=\"font-size: small; font-weight: bold;\">**7. Termination of Service**</span></p><p align=\"justify\"><span style=\"font-size: small;\"><br></span></p><p align=\"justify\"><span style=\"font-size: small;\">We reserve the right to terminate or suspend a user\'s account, without notice, for any violation of these terms and conditions or for any other reason we deem appropriate.</span></p><p align=\"justify\"><span style=\"font-size: small;\"><br></span></p><p align=\"justify\"><span style=\"font-size: small; font-weight: bold;\">**8. Modifications to Terms**</span></p><p align=\"justify\"><span style=\"font-size: small;\"><br></span></p><p align=\"justify\"><span style=\"font-size: small;\">We may update or modify these terms and conditions at any time. Users are responsible for regularly reviewing these terms. Continued use of the service after changes constitutes acceptance of the modified terms.</span></p><p align=\"justify\"><span style=\"font-size: small;\"><br></span></p><p align=\"justify\"><span style=\"font-size: small; font-weight: bold;\">**9. Disclaimer of Liability**</span></p><p align=\"justify\"><span style=\"font-size: small;\"><br></span></p><p align=\"justify\"><span style=\"font-size: small;\"><span style=\"font-weight: bold;\">a. **Assumption of Risk:**</span> Users acknowledge and agree that they use the carpooling service at their own risk.</span></p><p align=\"justify\"><span style=\"font-size: small;\"><br></span></p><p align=\"justify\"><span style=\"font-size: small;\"><span style=\"font-weight: bold;\">b. **No Liability:**</span> We are not liable for any damages or losses arising from the use of our carpooling platform.</span></p><p align=\"justify\"><span style=\"font-size: small;\"><br></span></p><p align=\"justify\"><span style=\"font-size: small; font-weight: bold;\">**10. Governing Law**</span></p><p align=\"justify\"><span style=\"font-size: small;\"><br></span></p><p align=\"justify\"><span style=\"font-size: small;\">These terms and conditions are governed by and construed in accordance with the laws of [Your Jurisdiction].</span></p><p align=\"justify\"><span style=\"font-size: small;\"><br></span></p><p align=\"justify\"><span style=\"font-size: small;\">By using our carpooling website, you acknowledge that you have read, understood, and agree to these terms and conditions.</span></p>\r\n										\r\n										'),
(2, 'Privacy Policy', 'privacy', '<span style=\"color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;\">At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat</span>'),
(3, 'About Us ', 'aboutus', '<div style=\"text-align: center;\"><span style=\"color: rgb(0, 0, 0); font-size: x-large; font-weight: bold; text-decoration-line: underline; font-family: verdana;\">Welcome to AFK Carpool!</span></div><div style=\"text-align: center;\"><span style=\"color: rgb(0, 0, 0); font-family: verdana;\"><br></span></div><div style=\"text-align: center;\"><span style=\"color: rgb(0, 0, 0); font-family: verdana;\">We are a dynamic team of computer science enthusiasts hailing from FAST-NUCES University, brought together by a shared passion for technology and innovation. Our team comprises dedicated individuals, each bringing a unique set of skills and perspectives to the table.</span></div><div style=\"text-align: center;\"><span style=\"color: rgb(0, 0, 0); font-family: verdana;\"><br></span></div><div style=\"text-align: center;\"><span style=\"color: rgb(0, 0, 0); font-size: large; font-weight: bold; text-decoration-line: underline; font-family: verdana;\">Meet the Team</span></div><div style=\"text-align: center;\"><span style=\"color: rgb(0, 0, 0); font-family: verdana;\"><br></span></div><div style=\"text-align: center;\"><span style=\"color: rgb(0, 0, 0); font-weight: bold; font-family: verdana;\">Syed Khizar Ali</span></div><div style=\"text-align: center;\"><span style=\"color: rgb(0, 0, 0); font-family: verdana;\">Position: Co-Founder and Lead Developer</span></div><div style=\"text-align: center;\"><span style=\"color: rgb(0, 0, 0); font-family: verdana;\"><br></span></div><div style=\"text-align: center;\"><span style=\"color: rgb(0, 0, 0); font-family: verdana;\">Syed Khizar Ali is a computer science student with a keen interest in software development. With a knack for turning ideas into reality through code, he leads our team in creating robust and innovative solutions. Khizar is not just a developer; he\'s a problem solver who thrives on challenges.</span></div><div style=\"text-align: center;\"><span style=\"color: rgb(0, 0, 0); font-family: verdana;\"><br></span></div><div style=\"text-align: center;\"><span style=\"color: rgb(0, 0, 0); font-weight: bold; font-family: verdana;\">Fatima Ali</span></div><div style=\"text-align: center;\"><span style=\"color: rgb(0, 0, 0); font-family: verdana;\">Position: UX/UI Designer</span></div><div style=\"text-align: center;\"><span style=\"color: rgb(0, 0, 0); font-family: verdana;\"><br></span></div><div style=\"text-align: center;\"><span style=\"color: rgb(0, 0, 0); font-family: verdana;\">Meet Fatima Ali, our creative force behind the visuals. As a UX/UI designer, she ensures that our products not only function seamlessly but also offer an exceptional user experience. Fatima\'s design philosophy revolves around simplicity, elegance, and user-centricity.</span></div><div style=\"text-align: center;\"><span style=\"color: rgb(0, 0, 0); font-family: verdana;\"><br></span></div><div style=\"text-align: center;\"><span style=\"color: rgb(0, 0, 0); font-weight: bold; font-family: verdana;\">Syed Muhammad Ali</span></div><div style=\"text-align: center;\"><span style=\"color: rgb(0, 0, 0); font-family: verdana;\">Position: Co-Founder and Technical Lead</span></div><div style=\"text-align: center;\"><span style=\"color: rgb(0, 0, 0); font-family: verdana;\"><br></span></div><div style=\"text-align: center;\"><span style=\"color: rgb(0, 0, 0); font-family: verdana;\">Syed Muhammad Ali is our technical maestro. With a profound understanding of computer science concepts, he takes charge as our technical lead. Muhammad Ali is committed to ensuring that our projects are not only cutting-edge but also scalable and efficient.</span></div><div style=\"text-align: center;\"><span style=\"color: rgb(0, 0, 0); font-family: verdana;\"><br></span></div><div style=\"text-align: center;\"><span style=\"color: rgb(0, 0, 0); font-size: large; font-weight: bold; text-decoration-line: underline; font-family: verdana;\">Our Mission</span></div><div style=\"text-align: center;\"><span style=\"color: rgb(0, 0, 0); font-family: verdana;\"><br></span></div><div style=\"text-align: center;\"><span style=\"color: rgb(0, 0, 0); font-family: verdana;\">At AFK Carpool, we are on a mission to revolutionize the way people commute by providing a seamless and secure carpooling experience. Recognizing the challenges individuals face in their everyday commuting, we are dedicated to offering an easy and safer alternative through our innovative platform.</span></div><div style=\"text-align: center;\"><span style=\"color: rgb(0, 0, 0); font-family: verdana;\"><br></span></div><div style=\"text-align: center;\"><span style=\"color: rgb(0, 0, 0); font-weight: bold; font-family: verdana;\">Helping You Navigate the Carpooling Struggle</span></div><div style=\"text-align: center;\"><span style=\"color: rgb(0, 0, 0); font-family: verdana;\"><br></span></div><div style=\"text-align: center;\"><span style=\"color: rgb(0, 0, 0); font-family: verdana;\">We understand the daily struggle of finding reliable transportation. Our platform aims to bridge the gap between commuters, making carpooling not only accessible but also efficient. Whether you\'re a daily commuter or an occasional traveler, we\'re here to simplify your journey.</span></div><div style=\"text-align: center;\"><span style=\"color: rgb(0, 0, 0); font-family: verdana;\"><br></span></div><div style=\"text-align: center;\"><span style=\"color: rgb(0, 0, 0); font-weight: bold; font-family: verdana;\">Easy and Safer Commutes</span></div><div style=\"text-align: center;\"><span style=\"color: rgb(0, 0, 0); font-family: verdana;\"><br></span></div><div style=\"text-align: center;\"><span style=\"color: rgb(0, 0, 0); font-family: verdana;\">Safety is our top priority. With advanced features and a user-friendly interface, we strive to create a community where commuters can connect with confidence. Through our platform, we provide a space where trust is built, and journeys are shared securely.</span></div><div style=\"text-align: center;\"><span style=\"color: rgb(0, 0, 0); font-family: verdana;\"><br></span></div><div style=\"text-align: center;\"><span style=\"color: rgb(0, 0, 0); font-weight: bold; font-size: large; text-decoration-line: underline; font-family: verdana;\">Join Us on Our Journey</span></div><div style=\"text-align: center;\"><span style=\"color: rgb(0, 0, 0); font-family: verdana;\"><br></span></div><div style=\"text-align: center;\"><span style=\"color: rgb(0, 0, 0); font-family: verdana;\">We believe in the power of collaboration and welcome opportunities to connect with like-minded individuals and organizations. If you share our passion for technology and innovation, we invite you to join us on this exciting journey.</span></div><div style=\"text-align: center;\"><span style=\"color: rgb(0, 0, 0); font-family: verdana;\"><br></span></div><div style=\"text-align: center;\"><span style=\"color: rgb(0, 0, 0); font-family: verdana;\">Thank you for visiting AFK Carpool. We look forward to creating, exploring, and innovating together!</span></div>'),
(11, 'FAQs', 'faqs', '																														<span style=\"color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;\">Address------Test &nbsp; &nbsp;dsfdsfds</span>');

-- --------------------------------------------------------

--
-- Table structure for table `tblpassengers`
--

CREATE TABLE `tblpassengers` (
  `pid` int(11) NOT NULL,
  `poolingid` int(11) NOT NULL,
  `seatsRequested` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblpassengers`
--

INSERT INTO `tblpassengers` (`pid`, `poolingid`, `seatsRequested`, `status`) VALUES
(5, 18, 2, 0),
(5, 19, 3, 1),
(10, 18, 1, 1),
(10, 19, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblpooling`
--

CREATE TABLE `tblpooling` (
  `poolingid` int(11) NOT NULL,
  `carid` int(11) NOT NULL,
  `routeid` int(11) DEFAULT NULL,
  `starttime` time NOT NULL,
  `endtime` time NOT NULL,
  `date` date NOT NULL,
  `seatprice` int(11) NOT NULL,
  `seating` int(11) NOT NULL,
  `bookedseats` int(11) DEFAULT 0,
  `billid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblpooling`
--

INSERT INTO `tblpooling` (`poolingid`, `carid`, `routeid`, `starttime`, `endtime`, `date`, `seatprice`, `seating`, `bookedseats`, `billid`) VALUES
(17, 6, 3, '14:00:00', '15:00:00', '2023-12-07', 200, 3, 0, 8),
(18, 5, 4, '14:00:00', '15:00:00', '2023-12-13', 200, 3, 1, 9),
(19, 6, 10, '12:00:00', '14:00:00', '2023-12-21', 200, 7, 3, 10),
(20, 8, 6, '14:00:00', '16:00:00', '2023-12-08', 250, 3, 0, 11);

-- --------------------------------------------------------

--
-- Table structure for table `tblroutes`
--

CREATE TABLE `tblroutes` (
  `routeid` int(11) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblroutes`
--

INSERT INTO `tblroutes` (`routeid`, `description`) VALUES
(0, 'No desired route'),
(1, 'Gulberg->waterpump->Gulshan chowrangi -> aladdin -> millinium -> Fast'),
(3, 'Nipa->Gulshan Aladin->Johar Mor-> Millennium/Askari->Malir Halt-> FAST'),
(4, 'Fast-> Drigh road - > millenium - > gulshan chowrangi - > waterpump - > ayesha manzil-> 5star'),
(5, 'Gulshan-e-shamim-> gulshan chowrangi-> johar mor-> rado bakery-> habib uni-> airport->fast'),
(6, 'Fast - malir halt - model mord - tank chowk - cp6 - cp5 - safoora'),
(8, 'Fast ->millinium -> aladdin -> Gulshan chowrangi -> lucky one -> nagan chowrangi -> North Nazimabad (Five star)'),
(9, 'Fast->halt->drigh road->shahraeh faisal->awaami markaz->baloch pull->10 pearls'),
(10, 'Nazimabad-> KdaScheme1-.>Fast'),
(11, 'Saddar -> Empress Market -> Karachi Zoo -> Quaid\'s Mausoleum -> Mohatta Palace -> Clifton Underpass -> Sea View'),
(12, 'Clifton Beach -> Teen Talwar -> PIDC -> Do Talwar -> Kothari Parade -> Arts Council -> Frere Hall -> National Stadium'),
(13, 'Pakistan Maritime Museum -> PAF Museum -> Lucky One Mall -> Karachi University -> Hassan Square -> Civic Center -> Bahria Town'),
(14, 'Karachi Port Trust -> Custom House -> City Railway Station -> Merewether Tower -> Port Grand -> Native Jetty Bridge -> Clifton Seafront');

-- --------------------------------------------------------

--
-- Table structure for table `tblusers`
--

CREATE TABLE `tblusers` (
  `id` int(11) NOT NULL,
  `FullName` varchar(120) DEFAULT NULL,
  `EmailId` varchar(100) DEFAULT NULL,
  `Password` varchar(100) DEFAULT NULL,
  `Gender` varchar(11) NOT NULL,
  `ContactNo` char(11) DEFAULT NULL,
  `dob` varchar(100) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `City` varchar(100) DEFAULT NULL,
  `Country` varchar(100) DEFAULT NULL,
  `RegDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblusers`
--

INSERT INTO `tblusers` (`id`, `FullName`, `EmailId`, `Password`, `Gender`, `ContactNo`, `dob`, `Address`, `City`, `Country`, `RegDate`, `UpdationDate`) VALUES
(1, 'Harry Den', 'demo@gmail.com', 'f925916e2754e5e03f75dd58a5733251', '', '2147483647', NULL, NULL, NULL, NULL, '2017-06-17 19:59:27', '2017-06-26 21:02:58'),
(4, 'Tom K', 'test@gmail.com', '5c428d8875d2948607f3e3fe134d71b4', '', '9999857868', '', 'PKL', 'XYZ', 'XYZ', '2017-06-17 20:03:36', '2017-06-26 19:18:14'),
(5, 'khizar ali', 'k213329@nu.edu.pk', 'd57587b0f5bbb0c3fe9d8cb16e97b0fe', 'male', '3212153986', NULL, NULL, NULL, NULL, '2023-11-23 10:05:20', NULL),
(6, 'ahsan hussain', 'k214942@nu.edu.pk', '74870a2fd40b4d9926a5849f64fa2fca', 'male', '3212474391', NULL, NULL, NULL, NULL, '2023-11-27 05:17:15', NULL),
(7, 'Fatima Ali', 'k213249@nu.edu.pk', '1799bb39b47c7ebb9a450000b08ae462', 'female', '9212153986', NULL, NULL, NULL, NULL, '2023-12-02 13:00:14', NULL),
(10, 'Muhammad Ali', 'k213335@nu.edu.pk', 'e9c24de0272e37d5a8bfd081f131f002', 'male', '3012969997', NULL, NULL, NULL, NULL, '2023-12-05 18:59:02', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblbill`
--
ALTER TABLE `tblbill`
  ADD PRIMARY KEY (`billid`),
  ADD KEY `fk_bill_car` (`carid`);

--
-- Indexes for table `tblcars`
--
ALTER TABLE `tblcars`
  ADD PRIMARY KEY (`carid`);

--
-- Indexes for table `tbldrivers`
--
ALTER TABLE `tbldrivers`
  ADD PRIMARY KEY (`driverid`,`carid`),
  ADD KEY `fk_driver_car` (`carid`);

--
-- Indexes for table `tblpages`
--
ALTER TABLE `tblpages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblpassengers`
--
ALTER TABLE `tblpassengers`
  ADD PRIMARY KEY (`pid`,`poolingid`),
  ADD KEY `fk_passenger_pooling` (`poolingid`);

--
-- Indexes for table `tblpooling`
--
ALTER TABLE `tblpooling`
  ADD PRIMARY KEY (`poolingid`),
  ADD KEY `fk_pooling_route` (`routeid`),
  ADD KEY `fk_pooling_bill` (`billid`),
  ADD KEY `fk_pooling_car` (`carid`);

--
-- Indexes for table `tblroutes`
--
ALTER TABLE `tblroutes`
  ADD PRIMARY KEY (`routeid`);

--
-- Indexes for table `tblusers`
--
ALTER TABLE `tblusers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblbill`
--
ALTER TABLE `tblbill`
  MODIFY `billid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tblcars`
--
ALTER TABLE `tblcars`
  MODIFY `carid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tblpages`
--
ALTER TABLE `tblpages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tblpooling`
--
ALTER TABLE `tblpooling`
  MODIFY `poolingid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tblroutes`
--
ALTER TABLE `tblroutes`
  MODIFY `routeid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tblusers`
--
ALTER TABLE `tblusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblbill`
--
ALTER TABLE `tblbill`
  ADD CONSTRAINT `fk_bill_car` FOREIGN KEY (`carid`) REFERENCES `tblcars` (`carid`);

--
-- Constraints for table `tbldrivers`
--
ALTER TABLE `tbldrivers`
  ADD CONSTRAINT `fk_driver_car` FOREIGN KEY (`carid`) REFERENCES `tblcars` (`carid`),
  ADD CONSTRAINT `fk_driver_uset` FOREIGN KEY (`driverid`) REFERENCES `tblusers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tblpassengers`
--
ALTER TABLE `tblpassengers`
  ADD CONSTRAINT `fk_passenger_pooling` FOREIGN KEY (`poolingid`) REFERENCES `tblpooling` (`poolingid`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_passenger_user` FOREIGN KEY (`pid`) REFERENCES `tblusers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tblpooling`
--
ALTER TABLE `tblpooling`
  ADD CONSTRAINT `fk_pooling_bill` FOREIGN KEY (`billid`) REFERENCES `tblbill` (`billid`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_pooling_car` FOREIGN KEY (`carid`) REFERENCES `tbldrivers` (`carid`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_pooling_route` FOREIGN KEY (`routeid`) REFERENCES `tblroutes` (`routeid`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
