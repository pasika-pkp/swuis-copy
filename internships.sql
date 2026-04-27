-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2026 at 05:20 PM
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
-- Database: `internships`
--

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `company_id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `contact_person` varchar(150) DEFAULT NULL,
  `contact_phone` varchar(10) DEFAULT NULL,
  `contact_email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`company_id`, `company_name`, `address`, `contact_person`, `contact_phone`, `contact_email`) VALUES
(1, 'บริษัท ไอที ซิสเต็มส์ จำกัด', 'หรรหรรกรรร 10110', 'จินตหรา ภูลาภ', '0991234567', 'jintara@gmail.com'),
(2, 'บริษัท นวัตกรรมดิจิทัล จำกัด', 'กรุงเทพ 10110', 'somchai@gmail.com', '0899892323', ''),
(3, 'บริษัท โซลูชั่น เน็ตเวิร์ค จำกัด', '2555 เขตวัฒนา กรุงเทพ 10110', 'สมหมาย ใจดี', '0645524032', 'sommai@email.com'),
(4, 'บริษัท ปังไม่ไหว จำกัด', 'บ้าน', 'สมหมาย ใจดี', '0991234567', NULL),
(5, 'บริษัท ngongไม่ไหว จำกัด', 'don\'t know 11101', 'nonnnn', '042754642', 'arraiiii@gmail.com'),
(6, 'บริษัท คืองงไม่ไหว จำกัด', 'ไม่ไหวจะเคลียร์ 101220', 'ไม่รุ้', '0841551111', 'tasdg@email.com');

-- --------------------------------------------------------

--
-- Table structure for table `internship_request`
--

CREATE TABLE `internship_request` (
  `request_id` int(11) NOT NULL,
  `student_id` varchar(20) NOT NULL,
  `company_id` int(11) NOT NULL,
  `internship_position` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `supervision_note` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `internship_request`
--

INSERT INTO `internship_request` (`request_id`, `student_id`, `company_id`, `internship_position`, `start_date`, `end_date`, `status`, `supervision_note`, `created_at`) VALUES
(12, '661000001', 3, 'บัญชี', '2026-04-22', '2026-07-22', 1, NULL, '2026-04-22 15:10:00');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `role` enum('staff','teacher') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `username`, `password`, `first_name`, `last_name`, `role`) VALUES
(1, 'admin', '$2y$10$eEHYt2f0/r0L7a1B.V40R.Dq2855GQqL3684A1p3Y1r./Q9eR.7QO', 'สมชาย', 'ใจดี', 'staff'),
(2, 'teacher', '$2y$10$eEHYt2f0/r0L7a1B.V40R.Dq2855GQqL3684A1p3Y1r./Q9eR.7QO', 'สมหญิง', 'สอนเก่ง', 'teacher');

-- --------------------------------------------------------

--
-- Table structure for table `status_log`
--

CREATE TABLE `status_log` (
  `log_id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `old_status` int(11) DEFAULT NULL,
  `new_status` int(11) NOT NULL,
  `changed_by` varchar(50) NOT NULL,
  `change_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `year` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `password`, `first_name`, `last_name`, `email`, `phone`, `year`) VALUES
('631000007', '$2y$10$eEHYt2f0/r0L7a1B.V40R.Dq2855GQqL3684A1p3Y1r./Q9eR.7QO', 'ชลธร', 'สายน้ำ', 'chon@g.swu.ac.th', '0811111117', 4),
('631000008', '$2y$10$eEHYt2f0/r0L7a1B.V40R.Dq2855GQqL3684A1p3Y1r./Q9eR.7QO', 'ญาดา', 'น่ารัก', 'yada@g.swu.ac.th', '0811111118', 4),
('631000009', '$2y$10$eEHYt2f0/r0L7a1B.V40R.Dq2855GQqL3684A1p3Y1r./Q9eR.7QO', 'ณัชชา', 'พาเพลิน', 'nat@g.swu.ac.th', '0811111119', 4),
('631000010', '$2y$10$eEHYt2f0/r0L7a1B.V40R.Dq2855GQqL3684A1p3Y1r./Q9eR.7QO', 'ดนัย', 'ใจหาญ', 'danai@g.swu.ac.th', '0811111120', 4),
('641000005', '$2y$10$eEHYt2f0/r0L7a1B.V40R.Dq2855GQqL3684A1p3Y1r./Q9eR.7QO', 'จตุพล', 'ล้ำเลิศ', 'jatu@g.swu.ac.th', '0811111115', 3),
('641000006', '$2y$10$eEHYt2f0/r0L7a1B.V40R.Dq2855GQqL3684A1p3Y1r./Q9eR.7QO', 'ฉัตรชัย', 'ชัยชนะ', 'chat@g.swu.ac.th', '0811111116', 3),
('651000003', '$2y$10$eEHYt2f0/r0L7a1B.V40R.Dq2855GQqL3684A1p3Y1r./Q9eR.7QO', 'คณาวุฒิ', 'ตั้งใจ', 'kana@g.swu.ac.th', '0811111113', 2),
('651000004', '$2y$10$eEHYt2f0/r0L7a1B.V40R.Dq2855GQqL3684A1p3Y1r./Q9eR.7QO', 'งามฤดี', 'ดีงาม', 'ngam@g.swu.ac.th', '0811111114', 2),
('661000001', '$2y$10$eEHYt2f0/r0L7a1B.V40R.Dq2855GQqL3684A1p3Y1r./Q9eR.7QO', 'กานต์', 'ใจดี', 'kan@g.swu.ac.th', '0811111111', 1),
('661000002', '$2y$10$eEHYt2f0/r0L7a1B.V40R.Dq2855GQqL3684A1p3Y1r./Q9eR.7QO', 'ขวัญ', 'รักเรียน', 'kwan@g.swu.ac.th', '0811111112', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`company_id`);

--
-- Indexes for table `internship_request`
--
ALTER TABLE `internship_request`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`);

--
-- Indexes for table `status_log`
--
ALTER TABLE `status_log`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `request_id` (`request_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `internship_request`
--
ALTER TABLE `internship_request`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `status_log`
--
ALTER TABLE `status_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `internship_request`
--
ALTER TABLE `internship_request`
  ADD CONSTRAINT `internship_request_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `internship_request_ibfk_2` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`) ON DELETE CASCADE;

--
-- Constraints for table `status_log`
--
ALTER TABLE `status_log`
  ADD CONSTRAINT `status_log_ibfk_1` FOREIGN KEY (`request_id`) REFERENCES `internship_request` (`request_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
