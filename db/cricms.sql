-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2024 at 02:27 PM
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
-- Database: `cricms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `password`, `full_name`, `image`) VALUES
(1, 'adem1', '$2y$10$zNJBfOkPO.FrQ79xbBB6jObIepLmsam8cfn4y.a0V12flU5GhU2EO', 'Adem Abdrei', '../images/profile/admin/AVATARZ - Tomas.png'),
(2, 'adem12', '$2y$10$ASEiPWb6kkyH6GoOC/0jTuCcRes2bpglqx9Kit4L8/V2eFXJ9bfeS', 'adem abdrei', 'AVATARZ - Tomas.png'),
(3, 'adem', '$2y$10$kz1c7zx80VMPdUerqHdrw.MoNf99pa1S5bnpyl3fSZ13pcPNOvkkG', 'adem abdei', 'AVATARZ - Sheik.png');

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `blog_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `author_id` int(11) DEFAULT NULL,
  `author_type` enum('admin','moderator','kebeleModerator','resident') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `city_id` int(11) NOT NULL,
  `city_name` varchar(50) NOT NULL,
  `woreda_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`city_id`, `city_name`, `woreda_id`) VALUES
(1, 'Nekemte', 1);

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `comment_id` int(11) NOT NULL,
  `blog_id` int(11) DEFAULT NULL,
  `commenter_id` int(11) DEFAULT NULL,
  `commenter_type` enum('admin','moderator','kebeleModerator','resident') NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kebele`
--

CREATE TABLE `kebele` (
  `kebele_id` int(11) NOT NULL,
  `kebele_name` varchar(50) NOT NULL,
  `city_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kebele`
--

INSERT INTO `kebele` (`kebele_id`, `kebele_name`, `city_id`) VALUES
(3, 'Cheleleqi', 1),
(4, 'Bordi', 1),
(5, 'Komto', 1),
(6, 'Bekenisa Qesse', 1);

-- --------------------------------------------------------

--
-- Table structure for table `kebelemoderator`
--

CREATE TABLE `kebelemoderator` (
  `kebeleModerator_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `moderator_id` int(11) DEFAULT NULL,
  `kebele_id` int(11) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kebelemoderator`
--

INSERT INTO `kebelemoderator` (`kebeleModerator_id`, `username`, `password`, `full_name`, `image`, `moderator_id`, `kebele_id`, `status`) VALUES
(6, 'addd', '$2y$10$PmQvwFHuhjvNjxitZjGsMOnyFsOyVPzDkolA/oi6O6FKiGfz80/yK', '', NULL, 3, 3, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `moderator`
--

CREATE TABLE `moderator` (
  `moderator_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `moderator`
--

INSERT INTO `moderator` (`moderator_id`, `username`, `password`, `full_name`, `image`, `city_id`, `status`) VALUES
(3, 'adugna', '$2y$10$6H3kOzqKaip1zwWCQ5mN/OZB4lTW4ktmCo3hsZ2T90Du.8dFuE/4i', '', NULL, 1, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `notices`
--

CREATE TABLE `notices` (
  `notice_id` int(11) NOT NULL,
  `notice_title` varchar(255) NOT NULL,
  `notice_content` text DEFAULT NULL,
  `notice_images` text DEFAULT NULL,
  `notice_posted_by` varchar(100) DEFAULT NULL,
  `notice_posted_role` varchar(100) DEFAULT NULL,
  `notice_posted_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notices`
--

INSERT INTO `notices` (`notice_id`, `notice_title`, `notice_content`, `notice_images`, `notice_posted_by`, `notice_posted_role`, `notice_posted_on`) VALUES
(1, 'sdfghjk', '#szxdcyfukyhj\r\n##gljhk hdckxunk ', 'ethiopia.png', 'adem', 'admin', '2024-06-10 13:20:05');

-- --------------------------------------------------------

--
-- Table structure for table `region`
--

CREATE TABLE `region` (
  `region_id` int(11) NOT NULL,
  `region_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `region`
--

INSERT INTO `region` (`region_id`, `region_name`) VALUES
(3, 'Gambela'),
(1, 'Oromia');

-- --------------------------------------------------------

--
-- Table structure for table `residents`
--

CREATE TABLE `residents` (
  `resident_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `national_id` varchar(255) NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `date_of_birth` date NOT NULL,
  `expiration_date` date DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `occupation` varchar(100) DEFAULT NULL,
  `marital_status` enum('single','married','divorced','widowed') DEFAULT NULL,
  `number_of_dependents` int(11) DEFAULT NULL,
  `emergency_contact_name` varchar(100) DEFAULT NULL,
  `emergency_contact_phone` varchar(20) DEFAULT NULL,
  `blood_type` enum('A+','A-','B+','B-','AB+','AB-','O+','O-') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `region_id` int(11) DEFAULT NULL,
  `zone_id` int(11) DEFAULT NULL,
  `woreda_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `kebele_id` int(11) DEFAULT NULL,
  `status` enum('pending','approved','requested','disapproved') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `residents`
--

INSERT INTO `residents` (`resident_id`, `username`, `password`, `full_name`, `image`, `national_id`, `gender`, `date_of_birth`, `expiration_date`, `phone_number`, `email`, `occupation`, `marital_status`, `number_of_dependents`, `emergency_contact_name`, `emergency_contact_phone`, `blood_type`, `created_at`, `updated_at`, `region_id`, `zone_id`, `woreda_id`, `city_id`, `kebele_id`, `status`) VALUES
(1, 'adem', '$2y$10$Op9Fi5HG4Ij2HbkjUSz1Rew0nDfYVbWcBQkpEoCPTtaZipkKX6LfK', 'adem abdrei seyid', '../images/profile/residentAVATARZ - Sheik.png', 'NEKEMTE000111131', 'male', '2024-06-12', '2027-06-12', '0923365046', 'ademabdrei0923@gmail.com', 'ethiopia', 'single', 15, 'Abdrei Seyid yibre', '0922269658', 'B+', '2024-06-12 10:44:33', '2024-06-12 12:46:24', 1, 1, 1, 1, 3, 'approved'),
(3, 'adugna', '$2y$10$svVFgNwSj3QDDjsjOog9kunU/u5WHD8C0E.7q0EQjzBF3vhxM8Lfy', 'Adugna misgana', '../images/profile/residentAVATARZ 3.png', 'NEKEMTE000111133', 'male', '2024-06-12', '2027-06-12', '0923365046', 'yasinnuru0923@gmail.com', NULL, 'single', 5, 'Misgana ', '0922269658', 'A+', '2024-06-12 11:50:06', '2024-06-12 12:17:25', 1, 1, 1, 1, 3, 'pending'),
(4, 'dugasa', '$2y$10$JIWnfXc1zcfC9njTublEkej0VB7K4NCIIH.g6xiwY2Zi0uDqZ6tIq', 'dugasa olana', '../images/profile/residentAVATARZ - Tomas.png', 'NEKEMTE000111144', 'male', '2010-06-16', '2023-06-03', '0912322212', 'dugasao@gmail.com', NULL, 'single', 3, 'olana', '0384', 'AB+', '2024-06-12 11:58:01', '2024-06-12 12:18:54', 1, 1, 1, 1, 4, 'disapproved'),
(5, 'ad', '$2y$10$HtgjCZv3z/r.WWvAq.IkluEmTd.1i5A.eLJUhFCs7JnrDK5e4LHhC', 'Adem Abdrei Seyid', '../images/profile/residentAVATARZ - Tomas.png', 'NEKEMTE000111145', 'male', '2005-02-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-06-13 12:00:23', '2024-06-13 12:00:23', 1, 1, 1, 1, 4, 'requested'),
(6, 'nuredin', '$2y$10$R0bn3weRXzXS5Ljh2MjqGuk7UfIn6qP4ER9DV0bYq9QEDBreDdMQW', 'Nuredin Jemal Abadir', '../images/profile/residentNuredin Jemal DV edited.jpg', 'NEKEMTE000111136', 'male', '2000-02-01', NULL, '0963402020', 'nuredinjemal0963@gmail.com', NULL, 'single', 4, 'Jemal Abadir', '09835678382', 'A+', '2024-06-13 12:19:41', '2024-06-13 12:21:08', 1, 1, 1, 1, 3, 'requested');

-- --------------------------------------------------------

--
-- Table structure for table `woreda`
--

CREATE TABLE `woreda` (
  `woreda_id` int(11) NOT NULL,
  `woreda_name` varchar(50) NOT NULL,
  `zone_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `woreda`
--

INSERT INTO `woreda` (`woreda_id`, `woreda_name`, `zone_id`) VALUES
(1, 'Naqamte', 1),
(2, 'g', 2);

-- --------------------------------------------------------

--
-- Table structure for table `zone`
--

CREATE TABLE `zone` (
  `zone_id` int(11) NOT NULL,
  `zone_name` varchar(50) NOT NULL,
  `region_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `zone`
--

INSERT INTO `zone` (`zone_id`, `zone_name`, `region_id`) VALUES
(1, 'East Wallaga', 1),
(2, 'ggyu', 3),
(3, 'West Wallaga', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`blog_id`),
  ADD KEY `author_id` (`author_id`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`city_id`),
  ADD UNIQUE KEY `city_name` (`city_name`),
  ADD KEY `woreda_id` (`woreda_id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `blog_id` (`blog_id`),
  ADD KEY `commenter_id` (`commenter_id`);

--
-- Indexes for table `kebele`
--
ALTER TABLE `kebele`
  ADD PRIMARY KEY (`kebele_id`),
  ADD KEY `city_id` (`city_id`);

--
-- Indexes for table `kebelemoderator`
--
ALTER TABLE `kebelemoderator`
  ADD PRIMARY KEY (`kebeleModerator_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `moderator_id` (`moderator_id`),
  ADD KEY `kebele_id` (`kebele_id`);

--
-- Indexes for table `moderator`
--
ALTER TABLE `moderator`
  ADD PRIMARY KEY (`moderator_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `city_id` (`city_id`);

--
-- Indexes for table `notices`
--
ALTER TABLE `notices`
  ADD PRIMARY KEY (`notice_id`);

--
-- Indexes for table `region`
--
ALTER TABLE `region`
  ADD PRIMARY KEY (`region_id`),
  ADD UNIQUE KEY `region_name` (`region_name`);

--
-- Indexes for table `residents`
--
ALTER TABLE `residents`
  ADD PRIMARY KEY (`resident_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `national_id` (`national_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `region_id` (`region_id`),
  ADD KEY `zone_id` (`zone_id`),
  ADD KEY `woreda_id` (`woreda_id`),
  ADD KEY `city_id` (`city_id`),
  ADD KEY `kebele_id` (`kebele_id`);

--
-- Indexes for table `woreda`
--
ALTER TABLE `woreda`
  ADD PRIMARY KEY (`woreda_id`),
  ADD KEY `zone_id` (`zone_id`);

--
-- Indexes for table `zone`
--
ALTER TABLE `zone`
  ADD PRIMARY KEY (`zone_id`),
  ADD KEY `region_id` (`region_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `blog_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `city_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kebele`
--
ALTER TABLE `kebele`
  MODIFY `kebele_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `kebelemoderator`
--
ALTER TABLE `kebelemoderator`
  MODIFY `kebeleModerator_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `moderator`
--
ALTER TABLE `moderator`
  MODIFY `moderator_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `notices`
--
ALTER TABLE `notices`
  MODIFY `notice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `region`
--
ALTER TABLE `region`
  MODIFY `region_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `residents`
--
ALTER TABLE `residents`
  MODIFY `resident_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `woreda`
--
ALTER TABLE `woreda`
  MODIFY `woreda_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `zone`
--
ALTER TABLE `zone`
  MODIFY `zone_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blog`
--
ALTER TABLE `blog`
  ADD CONSTRAINT `blog_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `admin` (`admin_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `blog_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `moderator` (`moderator_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `blog_ibfk_3` FOREIGN KEY (`author_id`) REFERENCES `kebelemoderator` (`kebeleModerator_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `blog_ibfk_4` FOREIGN KEY (`author_id`) REFERENCES `residents` (`resident_id`) ON DELETE SET NULL;

--
-- Constraints for table `city`
--
ALTER TABLE `city`
  ADD CONSTRAINT `city_ibfk_1` FOREIGN KEY (`woreda_id`) REFERENCES `woreda` (`woreda_id`) ON DELETE CASCADE;

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `blog` (`blog_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`commenter_id`) REFERENCES `admin` (`admin_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `comment_ibfk_3` FOREIGN KEY (`commenter_id`) REFERENCES `moderator` (`moderator_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `comment_ibfk_4` FOREIGN KEY (`commenter_id`) REFERENCES `kebelemoderator` (`kebeleModerator_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `comment_ibfk_5` FOREIGN KEY (`commenter_id`) REFERENCES `residents` (`resident_id`) ON DELETE SET NULL;

--
-- Constraints for table `kebele`
--
ALTER TABLE `kebele`
  ADD CONSTRAINT `kebele_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `city` (`city_id`) ON DELETE CASCADE;

--
-- Constraints for table `kebelemoderator`
--
ALTER TABLE `kebelemoderator`
  ADD CONSTRAINT `kebelemoderator_ibfk_1` FOREIGN KEY (`moderator_id`) REFERENCES `moderator` (`moderator_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `kebelemoderator_ibfk_2` FOREIGN KEY (`kebele_id`) REFERENCES `kebele` (`kebele_id`) ON DELETE CASCADE;

--
-- Constraints for table `moderator`
--
ALTER TABLE `moderator`
  ADD CONSTRAINT `moderator_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `city` (`city_id`) ON DELETE CASCADE;

--
-- Constraints for table `residents`
--
ALTER TABLE `residents`
  ADD CONSTRAINT `residents_ibfk_1` FOREIGN KEY (`region_id`) REFERENCES `region` (`region_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `residents_ibfk_2` FOREIGN KEY (`zone_id`) REFERENCES `zone` (`zone_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `residents_ibfk_3` FOREIGN KEY (`woreda_id`) REFERENCES `woreda` (`woreda_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `residents_ibfk_4` FOREIGN KEY (`city_id`) REFERENCES `city` (`city_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `residents_ibfk_5` FOREIGN KEY (`kebele_id`) REFERENCES `kebele` (`kebele_id`) ON DELETE CASCADE;

--
-- Constraints for table `woreda`
--
ALTER TABLE `woreda`
  ADD CONSTRAINT `woreda_ibfk_1` FOREIGN KEY (`zone_id`) REFERENCES `zone` (`zone_id`) ON DELETE CASCADE;

--
-- Constraints for table `zone`
--
ALTER TABLE `zone`
  ADD CONSTRAINT `zone_ibfk_1` FOREIGN KEY (`region_id`) REFERENCES `region` (`region_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
