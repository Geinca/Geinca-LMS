-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2025 at 03:45 PM
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
-- Database: `lms`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `instructor_id` int(11) NOT NULL,
  `price` decimal(10,2) DEFAULT 0.00,
  `category_id` int(11) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `is_published` tinyint(1) DEFAULT 0,
  `requirements` text DEFAULT NULL,
  `what_you_learn` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `title`, `description`, `instructor_id`, `price`, `category_id`, `thumbnail`, `is_published`, `requirements`, `what_you_learn`, `created_at`, `updated_at`) VALUES
(1, 'class 8', 'fdsgvdfgv', 0, 0.00, NULL, NULL, 1, NULL, NULL, '2025-06-28 07:57:27', '2025-06-29 06:09:56'),
(2, 'class 9', 'hlo', 0, 0.00, NULL, NULL, 1, NULL, NULL, '2025-06-29 07:00:43', '2025-06-29 07:08:21'),
(3, 'class 10', 'jhdjdf', 0, 0.00, NULL, NULL, 1, NULL, NULL, '2025-06-30 08:35:37', '2025-06-30 08:37:06'),
(5, 'class 6', 'hello', 0, 0.00, NULL, NULL, 1, NULL, NULL, '2025-06-30 09:21:40', '2025-06-30 09:23:47'),
(7, 'class 5', '', 0, 0.00, NULL, NULL, 1, NULL, NULL, '2025-06-30 09:27:35', '2025-07-01 05:46:32'),
(8, 'class 11', 'dfhhdnzhzz', 0, 0.00, NULL, NULL, 1, NULL, NULL, '2025-06-30 09:29:49', '2025-06-30 09:31:33');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `class_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `instructor_id` int(11) DEFAULT NULL,
  `title` varchar(150) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT 1.00,
  `thumbnail` varchar(255) DEFAULT 'https://i.ibb.co/DfsDp9kX/971.jpg',
  `is_published` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `class_id`, `subject_id`, `instructor_id`, `title`, `description`, `created_at`, `user_id`, `price`, `thumbnail`, `is_published`) VALUES
(1, 1, 1, 2, 'years', 'hbcyg', '2025-06-28 05:58:13', NULL, 1.00, 'https://i.ibb.co/DfsDp9kX/971.jpg', 1),
(2, 1, 1, 2, 'years', 'hbcyg', '2025-06-28 05:59:44', NULL, 1.00, 'https://i.ibb.co/DfsDp9kX/971.jpg', 1),
(3, 2, 1, 3, 'Mathematics Mastery - Class 8', 'Comprehensive mathematics course covering all Class 8 topics', '2025-06-29 07:17:41', 1, 1.00, 'https://i.ibb.co/DfsDp9kX/971.jpg', 1),
(4, 2, NULL, NULL, 'class 10', '', '2025-06-30 08:51:05', NULL, 1.00, 'https://i.ibb.co/DfsDp9kX/971.jpg', 0),
(5, 2, NULL, NULL, 'math', 'yutgfuy', '2025-06-30 09:14:47', NULL, 1.00, 'https://i.ibb.co/DfsDp9kX/971.jpg', 0),
(6, 8, 1, 1, 'hhshs', 'tjhetjeaa', '2025-06-30 09:28:22', NULL, 1.00, 'https://i.ibb.co/DfsDp9kX/971.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `payment_id` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `plan_type` enum('monthly','yearly') NOT NULL,
  `start_date` datetime NOT NULL DEFAULT current_timestamp(),
  `end_date` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `title` varchar(150) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `exam_date` date DEFAULT NULL,
  `duration_minutes` int(11) DEFAULT NULL,
  `price` decimal(6,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exam_access`
--

CREATE TABLE `exam_access` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `exam_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `purchased_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_attempted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exam_questions`
--

CREATE TABLE `exam_questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `exam_id` int(11) DEFAULT NULL,
  `question` text DEFAULT NULL,
  `option_a` text DEFAULT NULL,
  `option_b` text DEFAULT NULL,
  `option_c` text DEFAULT NULL,
  `option_d` text DEFAULT NULL,
  `correct_option` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exam_responses`
--

CREATE TABLE `exam_responses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `exam_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `selected_option` char(1) DEFAULT NULL,
  `answered_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `position` int(11) NOT NULL,
  `is_preview` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `is_live` tinyint(1) DEFAULT 0,
  `live_date` datetime DEFAULT NULL,
  `live_end` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`id`, `course_id`, `title`, `description`, `video_url`, `duration`, `position`, `is_preview`, `created_at`, `date`, `time`, `is_live`, `live_date`, `live_end`) VALUES
(1, 1, '1st chapter', '<p>dfsgvfdeg b&nbsp; &nbsp; &nbsp;eere&nbsp; wefwef&nbsp; ewf</p>', 'https://steelblue-albatross-702143.hostingersite.com/wp-content/uploads/2025/04/media4.mp4', 29, 1, 0, '2025-06-28 02:30:40', NULL, NULL, 0, NULL, NULL),
(2, 1, 'chapter 2', '<p>sdbdfb</p>', 'https://www.youtube.com/watch?v=naJO1zxB6_Q&ab_channel=TheDeshbhakt', 0, 2, 1, '2025-06-28 08:45:31', '2025-06-30', '00:00:12', 1, '2025-06-30 02:04:00', '2025-06-30 02:40:01'),
(3, 1, '12', '<p>ewwef</p>', 'https://www.youtube.com/watch?v=naJO1zxB6_Q&ab_channel=TheDeshbhakt', 0, 1, 0, '2025-06-28 23:10:57', NULL, NULL, 0, NULL, NULL),
(4, 2, 'section 11', '<p>hii</p>', 'https://www.youtube.com/watch?v=naJO1zxB6_Q&ab_channel=TheDeshbhakt', 0, 1, 1, '2025-06-29 01:31:24', NULL, NULL, 0, NULL, NULL),
(5, 4, 'what', '<p>vhvjhgv</p>', 'https://www.youtube.com/watch?v=naJO1zxB6_Q&ab_channel=TheDeshbhakt', 0, 1, 1, '2025-06-30 03:06:00', NULL, NULL, 0, NULL, NULL),
(6, 3, 'history', '<p>civic</p>', 'https://www.youtube.com/watch?v=naJO1zxB6_Q&ab_channel=TheDeshbhakt', 78, 1, 1, '2025-06-30 03:18:53', NULL, NULL, 0, NULL, NULL),
(7, 6, 'engineer', '<p>how to be an&nbsp;<s>engineer</s></p>', 'https://www.youtube.com/watch?v=naJO1zxB6_Q&ab_channel=TheDeshbhakt', 0, 1, 1, '2025-06-30 03:52:34', NULL, NULL, 0, NULL, NULL),
(8, 6, 'hello', '<p>hello bro</p>', 'https://www.youtube.com/watch?v=naJO1zxB6_Q&ab_channel=TheDeshbhakt', 6, 5, 1, '2025-06-30 04:00:40', NULL, NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `amount` decimal(6,2) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `transaction_id` varchar(100) DEFAULT NULL,
  `status` enum('pending','completed','failed') DEFAULT NULL,
  `purpose` enum('subscription','exam') DEFAULT NULL,
  `related_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `title` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_attempts`
--

CREATE TABLE `quiz_attempts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `quiz_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `selected_option` char(1) DEFAULT NULL,
  `answered_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_questions`
--

CREATE TABLE `quiz_questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `quiz_id` int(11) DEFAULT NULL,
  `question` text DEFAULT NULL,
  `option_a` text DEFAULT NULL,
  `option_b` text DEFAULT NULL,
  `option_c` text DEFAULT NULL,
  `option_d` text DEFAULT NULL,
  `correct_option` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `class_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `class_id`, `name`) VALUES
(1, 1, 'math'),
(2, 6, 'history');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password_hash` text DEFAULT NULL,
  `role` enum('admin','instructor','student') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password_hash`, `role`, `created_at`, `status`) VALUES
(1, 'chpra ', 'all@gmail.com', '$2y$10$XR0RTNfIPrIMAOIEd2c3sOQ3jvU.8XrVsdOKj/RHqB8ur6OwTZpRW', 'instructor', '2025-06-26 18:14:21', 'active'),
(2, 'priya', 'xyz@gmail.com', '$2y$10$3h6vbRAtYUcqTfmMyNFFn.hUE27OATURdjN5H3rDawGKs1GecpUeW', 'student', '2025-06-28 05:57:25', 'active'),
(3, 'pr ar', 'prar@gmail.com', '$2y$10$V13VM88y4s7wEJHRKefcwOr4WnJ.8LEbASyz4IlUk2yGj4kENe3dS', 'student', '2025-06-28 17:06:02', 'active'),
(4, 'rohan', 'rdas@gmail.com', '$2y$10$rwsZD7R7GbO2GbaBeb.2ReznkhEENm8B3x0t8PZbt5vcLDL9MR3kW', 'student', '2025-07-01 12:38:58', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `user_courses`
--

CREATE TABLE `user_courses` (
  `id` int(11) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `course_id` int(11) NOT NULL,
  `subscription_type` enum('monthly','yearly') NOT NULL,
  `expiry_date` datetime NOT NULL,
  `payment_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_courses`
--

INSERT INTO `user_courses` (`id`, `user_email`, `course_id`, `subscription_type`, `expiry_date`, `payment_id`, `created_at`) VALUES
(1, 'xyz@gmail.com', 6, 'monthly', '2025-07-31 14:35:06', NULL, '2025-07-01 12:35:06'),
(2, 'xyz@gmail.com', 1, 'monthly', '2025-07-31 14:37:07', NULL, '2025-07-01 12:37:07'),
(3, 'rdas@gmail.com', 1, 'yearly', '2026-07-01 14:39:49', NULL, '2025-07-01 12:39:49');

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `title` varchar(150) DEFAULT NULL,
  `live_date` date DEFAULT NULL,
  `live_time` time DEFAULT NULL,
  `video_url` text DEFAULT NULL,
  `is_live` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `video_access`
--

CREATE TABLE `video_access` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subscription_id` int(11) DEFAULT NULL,
  `video_id` int(11) DEFAULT NULL,
  `access_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `credit_deducted` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `video_comments`
--

CREATE TABLE `video_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `video_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `commented_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam_access`
--
ALTER TABLE `exam_access`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam_questions`
--
ALTER TABLE `exam_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam_responses`
--
ALTER TABLE `exam_responses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_lessons_course` (`course_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_courses`
--
ALTER TABLE `user_courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_email_course_id` (`user_email`,`course_id`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `course_id` (`course_id`,`live_date`);

--
-- Indexes for table `video_access`
--
ALTER TABLE `video_access`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video_comments`
--
ALTER TABLE `video_comments`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exam_access`
--
ALTER TABLE `exam_access`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exam_questions`
--
ALTER TABLE `exam_questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exam_responses`
--
ALTER TABLE `exam_responses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_courses`
--
ALTER TABLE `user_courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `video_access`
--
ALTER TABLE `video_access`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `video_comments`
--
ALTER TABLE `video_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lessons`
--
ALTER TABLE `lessons`
  ADD CONSTRAINT `fk_lessons_course` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
