-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 25, 2024 at 05:02 AM
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
-- Database: `naicc`
--

-- --------------------------------------------------------

--
-- Table structure for table `contents`
--

CREATE TABLE `contents` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contents`
--

INSERT INTO `contents` (`id`, `content`, `created_at`) VALUES
(72, '<p>Hello Nimal</p>', '2024-10-21 14:11:44'),
(73, '<p>Dear Mr. Nimal,</p><p>				You are hereby assigned to the project Green immediately. Please report to Head Office for further instructions and updates.</p><p>Thank you for your attention to this matter.</p><p><br></p><p>Best regards,</p><p>Admin</p>', '2024-10-21 14:15:05'),
(74, '<p>Mr. Nimal Perera is assigned to supervise the new trainee officers starting from October 29th.</p>', '2024-10-21 14:28:28'),
(75, '<p>Dear Admin,</p><p><br></p><p>I would like to inform you that I have been assigned to supervise the new trainee officers starting from October 29th. Please let me know if there are any specific protocols or resources that I should be aware of to facilitate this process.</p><p>Thank you for your attention.</p><p><br></p><p>Best regards,</p><p>Mr. Nimal Perera</p>', '2024-10-21 14:31:48'),
(76, '<p>I, Mr. Nimal Perera, will be on leave from November 5th to November 10th for personal reasons.</p>', '2024-10-21 14:48:38'),
(78, '<p>Reminder: Deadline is 27th Oct 2024</p>', '2024-10-21 17:06:26'),
(82, '<p>Note: There will be a meeting tomorrow at 9 AM at the Main Conference Hall.</p>', '2024-10-21 17:39:26'),
(83, '<p>test notice: Nimal 24th Oct</p>', '2024-10-24 14:58:21'),
(84, '<p>test notice: Admin 24th Oct</p>', '2024-10-24 15:07:28'),
(85, '<p>Hello!</p>', '2024-10-24 18:13:50'),
(86, '<p>Hi!</p>', '2024-10-24 18:15:04'),
(87, '<p>fghghf</p>', '2024-10-25 02:15:56'),
(88, '<p>hi how are you</p>', '2024-10-25 02:16:44'),
(89, '<p>hello!</p>', '2024-10-25 02:28:57');

-- --------------------------------------------------------

--
-- Table structure for table `content_recipients`
--

CREATE TABLE `content_recipients` (
  `id` int(11) NOT NULL,
  `content_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `read_status` tinyint(1) DEFAULT 0,
  `sender_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `content_recipients`
--

INSERT INTO `content_recipients` (`id`, `content_id`, `user_id`, `read_status`, `sender_id`) VALUES
(27, 72, 66, 1, 65),
(28, 73, 66, 1, 65),
(29, 74, 66, 1, 65),
(30, 75, 65, 1, 66),
(31, 76, 65, 0, 66),
(32, 77, 65, 0, 66),
(33, 78, 66, 1, 69),
(36, 81, 66, 0, 65),
(37, 82, 69, 0, 65),
(38, 82, 66, 1, 65),
(39, 82, 70, 0, 65),
(40, 82, 68, 0, 65),
(41, 83, 66, 1, 65),
(42, 84, 65, 1, 66),
(43, 85, 65, 0, 66),
(44, 86, 72, 0, 65),
(45, 87, 70, 0, 65),
(46, 88, 66, 0, 65),
(47, 89, 66, 0, 65);

-- --------------------------------------------------------

--
-- Table structure for table `division`
--

CREATE TABLE `division` (
  `division_id` int(11) NOT NULL,
  `division` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `division`
--

INSERT INTO `division` (`division_id`, `division`) VALUES
(2, 'Agriculture Advisory Services'),
(3, 'ICT Division'),
(4, 'Video & Photography Division'),
(5, 'Graphic Communication & Training');

-- --------------------------------------------------------

--
-- Table structure for table `divisions`
--

CREATE TABLE `divisions` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `start` timestamp NOT NULL DEFAULT current_timestamp(),
  `end` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `title`, `description`, `start`, `end`) VALUES
(4, 'test', 'test', '2024-09-30 18:30:00', '2024-11-08 18:30:00'),
(5, 'task', 'task', '2024-10-11 18:30:00', '2024-11-08 18:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `main_task`
--

CREATE TABLE `main_task` (
  `main_task_id` int(11) NOT NULL,
  `main_task_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `authority` varchar(255) NOT NULL,
  `due_date` date NOT NULL,
  `actual_due_date` date NOT NULL,
  `priority` enum('Low','Medium','High') NOT NULL,
  `division_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `status` varchar(10) NOT NULL DEFAULT 'Pending',
  `progress` int(11) NOT NULL DEFAULT 0,
  `assign` varchar(50) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `main_task`
--

INSERT INTO `main_task` (`main_task_id`, `main_task_name`, `description`, `authority`, `due_date`, `actual_due_date`, `priority`, `division_id`, `created_at`, `status`, `progress`, `assign`) VALUES
(1, 'Database create', 'table create', 'member', '2024-10-18', '2024-11-01', 'Low', 1, '2024-10-23 21:11:15', 'Pending', 0, '2'),
(2, 'Database create', 'Create a MySql database', 'member', '2024-10-31', '2024-11-06', 'Medium', 4, '2024-10-23 23:37:41', 'In Progres', 0, '2'),
(3, 'Create a website', 'Java, mysql, react, Angular', 'Member', '2024-10-31', '2024-10-29', 'Low', 4, '2024-10-24 07:33:23', 'Pending', 0, '2'),
(4, 'test', 'aaaa', 'aaa', '2024-10-12', '2024-10-26', 'Low', 0, '2024-10-24 23:43:16', 'Pending', 0, 'Pending'),
(5, 'main task', 'absd', 'aaa', '2024-10-19', '2024-10-26', 'Low', 0, '2024-10-25 01:04:36', 'Pending', 0, 'Pending'),
(6, 'm task', 'mmmm', 'mmm', '2024-11-02', '2024-11-09', 'Low', 0, '2024-10-25 02:32:40', 'Pending', 0, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `subtasks`
--

CREATE TABLE `subtasks` (
  `sub_task_id` int(11) NOT NULL,
  `main_task_id` int(11) NOT NULL,
  `task_number` varchar(10) NOT NULL,
  `subtask_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `due_date` date NOT NULL,
  `priority` enum('Low','Medium','High') NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subtasks`
--

INSERT INTO `subtasks` (`sub_task_id`, `main_task_id`, `task_number`, `subtask_name`, `description`, `due_date`, `priority`, `created_at`) VALUES
(1, 1, '7FFC9F', 'create table', 'ss', '2024-10-31', 'Medium', '2024-10-23 21:25:48'),
(2, 1, '14FDFB', 'create table', 'create table', '2024-10-27', 'Low', '2024-10-23 23:38:22'),
(3, 3, 'F22F07', 'Create a navigation', 'Using css', '2024-10-31', 'Medium', '2024-10-24 07:35:55'),
(4, 4, '', 'subtest', 'ddd', '2024-10-19', 'Low', '2024-10-25 00:08:25'),
(5, 5, '', 'sub task1', 'asdf', '2024-10-26', 'Low', '2024-10-25 01:05:09'),
(6, 6, '', 's task', 'ssss', '2024-11-08', 'Low', '2024-10-25 02:33:13');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `task_id` int(11) NOT NULL,
  `task` varchar(255) NOT NULL,
  `due_date` date NOT NULL,
  `progress` int(11) DEFAULT 0,
  `status` enum('Not Started','In Progress','Completed') NOT NULL,
  `id` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`task_id`, `task`, `due_date`, `progress`, `status`, `id`) VALUES
(2, 'task2', '2024-11-09', 0, '', 68),
(6, 'sample task1', '2024-10-25', 55, 'In Progress', 68),
(7, 'task', '2024-10-11', 100, 'Completed', 68),
(10, 'task 08', '2024-10-25', 100, 'Completed', 66),
(15, 'sample task', '2024-11-08', 88, 'In Progress', 66),
(16, 'Task1', '2024-11-09', 40, 'In Progress', 71),
(17, 'Task1', '2024-11-09', 50, 'In Progress', 76),
(20, 'task2', '2024-11-24', 20, 'In Progress', 71),
(21, 'my task', '2024-12-09', 10, 'In Progress', 72),
(22, 'sub', '2024-12-08', 20, 'In Progress', 66),
(24, 'sub task 02', '2024-12-25', 0, 'Not Started', 83);

-- --------------------------------------------------------

--
-- Table structure for table `timetable`
--

CREATE TABLE `timetable` (
  `id` int(11) NOT NULL,
  `program_name` varchar(255) NOT NULL,
  `media_type` varchar(255) NOT NULL,
  `channel_name` varchar(255) NOT NULL,
  `program_date` date NOT NULL,
  `program_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `timetable`
--

INSERT INTO `timetable` (`id`, `program_name`, `media_type`, `channel_name`, `program_date`, `program_time`) VALUES
(2, 'Govibimata Arunalu', 'Television', 'National Rupavahini TV', '2024-10-31', '08:00:00'),
(3, 'Mihikatha Dinuwo​', 'Television', 'National Rupavahni TV', '2024-07-15', '06:15:00'),
(4, 'Uyirum Ulavum (Tamil)', 'Television', 'Wasantham TV', '2024-07-25', '17:15:00'),
(5, 'Rividina Arunella', 'Television', 'National Rupavahini TV', '2024-07-28', '07:00:00'),
(6, 'Ran Arunella', 'Television', 'National Rupawahini TV', '2024-10-23', '09:00:00'),
(7, 'A Park', 'Television', 'National Rupawahini TV', '2024-10-16', '08:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `trainee_courses_timetable`
--

CREATE TABLE `trainee_courses_timetable` (
  `id` int(11) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `course_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trainee_courses_timetable`
--

INSERT INTO `trainee_courses_timetable` (`id`, `course_name`, `course_date`, `start_time`, `end_time`) VALUES
(3, 'National Diploma in Agricultural Production Technology ETA 19', '2024-10-31', '15:00:00', '17:30:00'),
(4, 'National Diploma in Farm Machinery Technology – ETB 09', '2024-10-30', '10:00:00', '14:00:00'),
(5, 'National Diploma in Post-Harvest Technology – ETB 26', '2024-10-31', '10:00:00', '18:00:00'),
(6, 'National Diploma in Floriculture and Landscaping – ETB 33.1', '2024-10-22', '10:00:00', '12:00:00'),
(7, 'Plant nursery development assistant – A01S001', '2024-10-22', '10:00:00', '12:00:00'),
(8, 'Certificate for Agricultural Equipment Mechanics – ECC 34', '2024-10-22', '10:00:00', '12:00:00'),
(9, 'Field Assistants (Agriculture) – A01S003', '2024-10-31', '10:00:00', '13:00:00'),
(10, 'Livestock Technician – A01S023', '2024-10-22', '10:00:00', '12:00:00'),
(11, 'Floriculture and Landscape Development Assistant – A01S019', '2024-10-24', '10:00:00', '12:00:00'),
(12, 'Plant tissue culture laboratory assistant –  A01S018', '2024-10-22', '10:00:00', '12:00:00'),
(13, 'Aquaculture Technician – B05S004', '2024-10-16', '10:00:00', '12:00:00'),
(14, 'Livestock Assistant (Part Time) – A01S022.1', '2024-10-22', '10:00:00', '12:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `verification_code` varchar(64) DEFAULT NULL,
  `verified` tinyint(1) DEFAULT 0,
  `user_type` enum('admin','Deputy director','Additional director','Employee') NOT NULL,
  `position` varchar(100) NOT NULL,
  `phone` int(15) DEFAULT NULL,
  `location` varchar(50) NOT NULL,
  `division` varchar(100) NOT NULL,
  `profile picture` varchar(255) NOT NULL,
  `reset_token` varchar(200) DEFAULT NULL,
  `division_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `verification_code`, `verified`, `user_type`, `position`, `phone`, `location`, `division`, `profile picture`, `reset_token`, `division_id`) VALUES
(65, 'Admin', 'admin@ad.gov', '$2y$10$TXMzV3rqKto9MpVGwfdrjejzHeEH7837lBUzRzo6zNqWKvYyb.TzO', '0dd97e95e534', 1, 'admin', 'Director', 11111111, 'Kandy', 'Admin ', '', NULL, NULL),
(66, 'Nimal Perera', 'nimal@ad.gov', '$2y$10$Od2E/KLKjtO6fR/GqZH4cOC9YatB3fdmhORJIw110Jd6Rlz64XlqS', 'd0cc0db176d5', 1, '', 'Senior Agriculture Advisor ', 712345678, 'Badulla', 'Agriculture Advisory Services', '', NULL, 2),
(68, 'Tharindu Silva ', 'silva@ad.gov', '$2y$10$dyMq6b.Z/oRu0CH.lSAeSeJEnenVtzwhQTcxq7L1xRoTUTc/wnVbm', 'fc63effb042f', 1, '', 'ICT Manager', 723456789, 'Colombo', 'ICT Division', '', '68a6426a6d0b0e82b1d32d9202e7febfeb9699a52fc9f68f83cbf186026f2c04', 3),
(69, 'Lakmini Senanayake ', 'lakmini@ad.gov', '$2y$10$7zkkqjoVlBO4mqTNwCtUZu0OqgC6pYum7T/Zz0cVvWt7vIUtKe2Cm', '532a1897c559', 1, '', 'Head of Video Production', 2147483647, 'Colombo', 'Video & Photography Division', '', NULL, 4),
(70, 'Sanduni Wickramasinghe', 'sanduni@ad.gov', '$2y$10$Ja.mRx4Nq3EjSwgWg2LQg.PDNPFd5Q/vDXOMG1KOCH5/PiGRMbbgm', 'cd5ba3f7e6c5', 1, '', 'Training Coordinator', 745678902, 'Kandy', 'Graphic communication & Training', '', NULL, 5),
(71, 'Anura Perera', 'anura@ad.gov', '$2y$10$53uAxRvFq4N6ssw7w8uFGusgxvrUMi8alY6W6AmTbdfVvN4oIrTIK', 'fd3eae5a9943', 1, '', 'Senior Advisor', 711234567, 'Colombo', 'Agriculture Advisory Services', '', NULL, NULL),
(72, 'Sunil Fernando', 'sunil@ad.gov', '$2y$10$JxPke7gFLHig/JwD055Eq.ogUtP3pig6K/S/JggwOM2QX9431jOJO', 'd6c34e891a03', 1, '', 'Agricultural Consultant', 712345678, 'Galle', 'Agriculture Advisory Services', '', NULL, NULL),
(73, 'Ruwan Jayasinghe', 'ruwan@ad.gov', '$2y$10$VgjJMipHvDe5IKWMJ8KSC.mtaEx.3qP86cdJrEuezPhwqdc71ol1i', 'f546bac7b769', 1, '', 'IT Manager', 716789012, 'Colombo', 'ICT Division', '', NULL, NULL),
(74, 'Dilini Jayawardena', 'dilini@ad.gov', '$2y$10$GNxTsuC7DeGrYGvih8J25Oi8ZClw5qN6r1I4C9bvZD8HD0VDDns4u', '8b28a056af22', 1, '', 'Systems Administrator', 717890123, 'Gampaha', 'ICT Division', '', NULL, NULL),
(75, 'Asanka Rajapaksha', 'asanka@ad.gov', '$2y$10$jaqKjvT.9a.kgB9HLiufdulVpRjmSp.VTGnwcMwqFHwvAnygvVgPe', 'e75ae87f31fa', 1, '', 'Senior Videographer', 712341234, 'Colombo', 'Video & Photography Division', '', NULL, NULL),
(76, 'Sashini Samarawickrama', 'sashini@ad.gov', '$2y$10$VnvJZLTnFO/936lhWnL.HewcmDOmlmAnbNvH2nT.nZcBcIzqubydO', 'fa34d481570e', 1, '', 'Photographer', 713452345, 'Galle', 'Video & Photography Division', '', NULL, NULL),
(77, 'Tharanga Abeysinghe', 'tharanga@ad.gov', '$2y$10$DmntIWSFWcDcnBmY3N5Ed.XPEs9Y8eNiUOTCoezJzG8uu3YpYkvZq', 'c26672b985e0', 1, '', 'Graphic Designer', 717896789, 'Colombo', 'Graphic Communication & Training', '', NULL, NULL),
(78, 'Nimali De Silva', 'nimali@ad.gov', '$2y$10$23zGM3FTDjeYh7ZXkDsnv./PcHvCTcj1w6niJpdyACjADx8U0QkQG', 'e40835478db0', 1, '', 'Training Coordinator', 718907890, 'Kandy', 'Graphic Communication & Training', '', NULL, NULL),
(83, 'Kamal', 'kamal@ad.gov', '$2y$10$TE.23WNChEP3UdfMjhSvkOoJ5fpPebOIGWbwQITCVWbiC6/KhmOEG', 'bce9b866e047', 1, '', 'Agriculture Advisory', 245677881, 'Kandy', 'Agriculture Advisory Services', '', NULL, NULL),
(84, '', 'iit20074@std.uwu.ac.lk', '$2y$10$jcuTVhLJraQ7C0u0x1pCiucqwp/SkVqpyaZcqjRWkz9W5wLV2CncG', '7a40a2dc988d', 1, '', '', NULL, '', '', '', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contents`
--
ALTER TABLE `contents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `content_recipients`
--
ALTER TABLE `content_recipients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `content_id` (`content_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `division`
--
ALTER TABLE `division`
  ADD PRIMARY KEY (`division_id`);

--
-- Indexes for table `divisions`
--
ALTER TABLE `divisions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `main_task`
--
ALTER TABLE `main_task`
  ADD PRIMARY KEY (`main_task_id`);

--
-- Indexes for table `subtasks`
--
ALTER TABLE `subtasks`
  ADD PRIMARY KEY (`sub_task_id`),
  ADD KEY `main_task_id` (`main_task_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`task_id`),
  ADD KEY `user_id` (`id`);

--
-- Indexes for table `timetable`
--
ALTER TABLE `timetable`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trainee_courses_timetable`
--
ALTER TABLE `trainee_courses_timetable`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `division_id` (`division_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contents`
--
ALTER TABLE `contents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `content_recipients`
--
ALTER TABLE `content_recipients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `division`
--
ALTER TABLE `division`
  MODIFY `division_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `divisions`
--
ALTER TABLE `divisions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `main_task`
--
ALTER TABLE `main_task`
  MODIFY `main_task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `subtasks`
--
ALTER TABLE `subtasks`
  MODIFY `sub_task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `timetable`
--
ALTER TABLE `timetable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `trainee_courses_timetable`
--
ALTER TABLE `trainee_courses_timetable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`division_id`) REFERENCES `division` (`division_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
