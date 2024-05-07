-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 01, 2024 at 07:36 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `brainbattle`
--

-- --------------------------------------------------------

--
-- Table structure for table `classrooms`
--

CREATE TABLE `classrooms` (
  `classroom_id` int(10) NOT NULL,
  `classroom_name` varchar(255) NOT NULL,
  `classroom_description` varchar(255) DEFAULT NULL,
  `classroom_faculty` int(8) NOT NULL,
  `classroom_code` varchar(6) NOT NULL,
  `no_of_students` int(4) DEFAULT NULL,
  `create_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classrooms`
--

INSERT INTO `classrooms` (`classroom_id`, `classroom_name`, `classroom_description`, `classroom_faculty`, `classroom_code`, `no_of_students`, `create_at`) VALUES
(1, 'SE', 'Software Engineering&#039;s Classroom', 1, '2HQavk', 1, '2024-04-27 21:58:07');

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams` (
  `exam_id` int(8) NOT NULL,
  `exam_title` varchar(70) NOT NULL,
  `exam_description` varchar(150) NOT NULL,
  `no_of_questions` int(3) NOT NULL,
  `exam_date_time` datetime NOT NULL,
  `time_per_question` int(3) NOT NULL,
  `of_classroom` int(11) NOT NULL,
  `create_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exams`
--

INSERT INTO `exams` (`exam_id`, `exam_title`, `exam_description`, `no_of_questions`, `exam_date_time`, `time_per_question`, `of_classroom`, `create_at`) VALUES
(1, 'class test - 1', 'mandatory', 3, '2024-04-27 22:31:00', 12, 1, '2024-04-27 22:29:29');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `question_id` int(8) NOT NULL,
  `question_text` varchar(255) NOT NULL,
  `option_a` varchar(255) NOT NULL,
  `option_b` varchar(255) NOT NULL,
  `option_c` varchar(255) NOT NULL,
  `option_d` varchar(255) NOT NULL,
  `correct_option` varchar(2) NOT NULL,
  `of_exam` int(6) NOT NULL,
  `create_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`question_id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `of_exam`, `create_at`) VALUES
(1, 'SE stands for?', 'Secure Encryption', 'Software Engineering', 'Software Engineer', 'Secure Engineering', 'B', 1, '2024-04-27 22:29:29'),
(2, 'Mostly our first program is?', 'Hello World', 'Arithmatics', 'Matrix', 'Complex', 'A', 1, '2024-04-27 22:29:29'),
(3, 'dsjd', 'sdfldj', 'oiejoj', 'lsdjj&#039;j;j', ';dkjdkj', 'C', 1, '2024-04-27 22:29:29');

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `result_id` int(8) NOT NULL,
  `of_exam` int(8) NOT NULL,
  `by_user` int(8) NOT NULL,
  `mark_obtained` int(8) NOT NULL,
  `total_marks` int(8) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`result_id`, `of_exam`, `by_user`, `mark_obtained`, `total_marks`, `created_at`) VALUES
(1, 1, 2, 2, 3, '2024-04-27 22:32:23');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `in_classroom` int(8) DEFAULT NULL,
  `role` varchar(8) DEFAULT NULL,
  `time_stamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `password`, `in_classroom`, `role`, `time_stamp`) VALUES
(1, 'a', 'b', 'a@b.com', '$2y$10$C8A2N0vT2UU7lF8ZsnMKPePaquENaQJ/f1G9dTElHp1986Qi8xY8S', 1, 'faculty', '2024-04-27 21:57:25'),
(2, 'c', 'd', 'c@d.com', '$2y$10$eurGt4OT57dGQ1Db1p9OxOHMXa67JEuDVHkSe55q.w2ppxkGtbE5i', 1, 'student', '2024-04-27 21:58:27'),
(3, 'Ansuma ', 'Boro', 'ansumaboro@gmail.com', '$2y$10$2w.cEvKrDHaDlex5udFpZezzl63kmIrDc0qy.GvCGBLzm.c2KhsB2', NULL, NULL, '2024-05-01 20:26:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `classrooms`
--
ALTER TABLE `classrooms`
  ADD PRIMARY KEY (`classroom_id`),
  ADD UNIQUE KEY `classroom_faculty` (`classroom_faculty`,`classroom_code`);

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`exam_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`question_id`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`result_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `classrooms`
--
ALTER TABLE `classrooms`
  MODIFY `classroom_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `exam_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `question_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `result_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
