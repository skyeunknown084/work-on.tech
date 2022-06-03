-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 03, 2022 at 01:18 PM
-- Server version: 10.5.12-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u303701207_work_on_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `project_list`
--

CREATE TABLE `project_list` (
  `id` int(30) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(2) NOT NULL,
  `proj_status` int(11) NOT NULL DEFAULT 0,
  `start_date` date DEFAULT NULL,
  `end_date` date NOT NULL,
  `manager_id` int(30) DEFAULT 1,
  `chair_id` int(30) NOT NULL,
  `user_ids` text NOT NULL,
  `user_type` int(1) NOT NULL DEFAULT 3,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `project_list`
--

INSERT INTO `project_list` (`id`, `name`, `description`, `status`, `proj_status`, `start_date`, `end_date`, `manager_id`, `chair_id`, `user_ids`, `user_type`, `date_created`) VALUES
(1, 'Work-ON Project', 'Build Work-ON Project', 0, 0, '2022-06-03', '2022-06-04', 1, 2, '6,8,5,4,3,7', 3, '2022-06-03 12:20:03');

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `cover_img` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`id`, `name`, `email`, `contact`, `address`, `cover_img`) VALUES
(1, 'WorkON', 'info@workon.com', '+6397701234567', '1111 New Build Avenue Drive Street Working Hub City, Philippines', 'work-on-logo.png');

-- --------------------------------------------------------

--
-- Table structure for table `task_list`
--

CREATE TABLE `task_list` (
  `id` int(30) NOT NULL,
  `project_id` int(30) NOT NULL,
  `task` text NOT NULL,
  `task_owner` text NOT NULL,
  `description` text NOT NULL,
  `admin_id` int(30) DEFAULT 1,
  `leader` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `task_startdate` datetime DEFAULT NULL,
  `active` int(11) DEFAULT 0,
  `admin_ok` int(11) DEFAULT 0,
  `chair_ok` int(11) DEFAULT 0,
  `notif_status` int(11) DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `task_list`
--

INSERT INTO `task_list` (`id`, `project_id`, `task`, `task_owner`, `description`, `admin_id`, `leader`, `status`, `task_startdate`, `active`, `admin_ok`, `chair_ok`, `notif_status`, `date_created`) VALUES
(1, 1, 'Login Page', '3', 'Design Login UI', 1, 2, 1, NULL, 1, 0, 1, 1, '2022-06-03 12:22:48');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `type` tinyint(1) DEFAULT 3 COMMENT '1=dean, 2=chair, 3=member',
  `avatar` text NOT NULL DEFAULT 'no-image-available.png',
  `task_status` int(11) NOT NULL DEFAULT 0 COMMENT '0=no-assigned,\r\n1=not-started,\r\n2=started,\r\n3=in-progress,\r\n4=in-review,\r\n5=completed',
  `selected_id` int(11) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `type`, `avatar`, `task_status`, `selected_id`, `date_created`) VALUES
(1, 'Administrator', ' ', 'admin@work-on.tech', '1ab1753615a7e91dc9cd1ed5d0d748cc', 1, 'no-image-available.png', 0, 0, '2022-05-21 16:43:24'),
(2, 'Ash', 'Gray', 'ashgray@gmail.com', 'cd98e2b7dad295ed9207eb761f4eff48', 3, '1653446940_yanfei-genshin-impact.gif', 0, 0, '2022-05-21 16:47:35'),
(3, 'Jenn', 'DM', 'jenndm@gmail.com', 'cd98e2b7dad295ed9207eb761f4eff48', 3, 'no-image-available.png', 0, 0, '2022-05-22 15:53:13'),
(4, 'Clarence', 'Silva', 'cmsilva@gmail.com', '792f44ad367d31db88f8265c07f68095', 3, '1653500520_25247cb2dd5a22a4aa1a36603aedc151.jpg', 0, 0, '2022-05-25 17:42:13'),
(5, 'Charlene', 'Malabanan', 'cmalabanan@work-on.com', '1653cce0dcb92232837c4c9b9bb10f63', 3, '1653500520_6e31399bb4da9736c94dfb8848569d73.jpg', 0, 0, '2022-05-25 17:42:57'),
(6, 'Angela', 'Garcia', 'amgarcia@gmail.com', '779f5ee6da90efaaa98e7713bef54bb0', 3, '1653500580_main-qimg-5af86bc52047503194bec5597d96399b-lq.jpg', 0, 0, '2022-05-25 17:43:25'),
(7, 'Jess', 'DM', 'jessdm@gmail.com', 'cd98e2b7dad295ed9207eb761f4eff48', 3, '1653837240_green-haired-anime-girl-1.jpg', 0, 0, '2022-05-29 15:14:19'),
(8, 'Bryan', 'Hipolito', 'bii@gmail.com', '13521c72644704e973250bba9c1300a6', 3, 'no-image-available.png', 0, 0, '2022-05-30 05:19:37');

-- --------------------------------------------------------

--
-- Table structure for table `user_productivity`
--

CREATE TABLE `user_productivity` (
  `id` int(30) NOT NULL,
  `project_id` int(30) NOT NULL,
  `task_id` int(30) NOT NULL,
  `description` longtext DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `user_id` int(30) NOT NULL,
  `file_name` text DEFAULT NULL,
  `file_type` varchar(255) DEFAULT NULL,
  `file_size` int(255) DEFAULT NULL,
  `file_path` text DEFAULT NULL,
  `status` enum('1','0') CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '0',
  `notif_id` int(11) DEFAULT 0,
  `admin_id` int(11) DEFAULT 1,
  `leader` int(11) DEFAULT NULL,
  `active` int(1) DEFAULT 0,
  `admin_ok` int(11) DEFAULT 0,
  `chair_ok` int(11) DEFAULT 0,
  `date_created` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_productivity`
--

INSERT INTO `user_productivity` (`id`, `project_id`, `task_id`, `description`, `comment`, `user_id`, `file_name`, `file_type`, `file_size`, `file_path`, `status`, `notif_id`, `admin_id`, `leader`, `active`, `admin_ok`, `chair_ok`, `date_created`) VALUES
(1, 1, 1, 'Finish Work-ON Login UI						', NULL, 3, 'images.png', 'png', 6434, 'assets/uploads/files/images.png', '1', 1, 0, 2, 0, 0, 0, '2022-06-03 13:11:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `project_list`
--
ALTER TABLE `project_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task_list`
--
ALTER TABLE `task_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_productivity`
--
ALTER TABLE `user_productivity`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `project_list`
--
ALTER TABLE `project_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `task_list`
--
ALTER TABLE `task_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_productivity`
--
ALTER TABLE `user_productivity`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
