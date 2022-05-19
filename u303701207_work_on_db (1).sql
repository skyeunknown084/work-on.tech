-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 17, 2022 at 01:38 AM
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
-- Database: `work_on_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `group_list`
--

CREATE TABLE `group_list` (
  `id` int(30) NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `group_manager` varchar(255) NOT NULL,
  `group_members` text NOT NULL,
  `group_tasks` text NOT NULL,
  `user_ids` int(30) DEFAULT NULL,
  `manager_id` int(30) DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `group_list`
--

INSERT INTO `group_list` (`id`, `group_name`, `group_manager`, `group_members`, `group_tasks`, `user_ids`, `manager_id`, `date_created`) VALUES
(1, 'Group Two', 'Andrea Jada', 'Adam Gio, Arnold John', 'My First Task, My Second Task', NULL, NULL, '2022-03-06 22:58:16'),
(3, 'Group One', 'Andrea Jada', 'Array', 'Array', NULL, NULL, '2022-03-07 01:37:56'),
(4, 'Group Three', 'Andrea Jada', 'Array', 'Array', NULL, NULL, '2022-03-07 01:40:01');

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
(1, 'Tribute to parents', '								tribute to parents							', 0, 1, '2022-05-13', '2022-05-14', 1, 2, '3', 3, '2022-05-13 13:37:08'),
(2, 'Capstone Document', '																																													', 2, 1, '2022-05-14', '2022-05-31', 1, 2, '5,3,4', 3, '2022-05-13 17:50:12'),
(3, 'MIR4', 'Game 1 please start', 0, 1, '2022-05-16', '2022-05-31', 1, 5, '2,3,4', 3, '2022-05-16 07:01:19');

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
  `file_uploaded` longtext NOT NULL,
  `user_id` int(30) DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `task_startdate` datetime DEFAULT NULL,
  `active` int(11) DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `task_list`
--

INSERT INTO `task_list` (`id`, `project_id`, `task`, `task_owner`, `description`, `file_uploaded`, `user_id`, `status`, `task_startdate`, `active`, `date_created`) VALUES
(2, 2, 'project 007', 'Jenn DM', '							', '', NULL, 0, NULL, 1, '2022-05-13 17:50:38'),
(6, 1, 'Make A Video Tribute', 'Bea Lorraine Galon', 'short video dedication', '', NULL, 0, NULL, 1, '2022-05-14 04:20:34'),
(7, 1, 'Students dedicated speech to parents', 'Bea Lorraine Galon', '				tribute speech			', '', NULL, 0, NULL, 1, '2022-05-14 05:03:26'),
(8, 3, 'Team UNCRWNED', 'Bea Lorraine Galon', 'nice game', '', NULL, 0, NULL, 1, '2022-05-16 07:03:33');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_files`
--

CREATE TABLE `tbl_files` (
  `id` int(11) NOT NULL,
  `project_id` int(30) DEFAULT NULL,
  `task_id` int(30) DEFAULT NULL,
  `file_name` text NOT NULL,
  `file_type` varchar(255) NOT NULL,
  `file_path` text DEFAULT NULL,
  `file_size` varchar(255) DEFAULT NULL,
  `date_uploaded` datetime NOT NULL,
  `status` enum('1','0') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_notifications`
--

CREATE TABLE `tbl_notifications` (
  `n_id` int(11) NOT NULL,
  `project_id` int(30) NOT NULL,
  `task_owner` text NOT NULL,
  `description` text NOT NULL,
  `task` text NOT NULL,
  `active` int(1) DEFAULT 0,
  `date_stamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_status`
--

CREATE TABLE `tbl_status` (
  `id` int(11) NOT NULL,
  `status_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_status`
--

INSERT INTO `tbl_status` (`id`, `status_name`) VALUES
(1, 'NOT-STARTED'),
(2, 'STARTED'),
(3, 'IN-PROGRESS'),
(4, 'IN-REVIEW'),
(5, 'COMPLETED'),
(6, 'OVER-DUE');

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
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `type`, `avatar`, `task_status`, `date_created`) VALUES
(1, 'Administrator', 'Work-ON', 'admin@work-on.tech', '1ab1753615a7e91dc9cd1ed5d0d748cc', 1, '1652446440_anime-girl-green-hair-Favim.com-642566.jpg', 0, '2022-05-13 12:50:51'),
(2, 'Bea Lorraine', 'Galon', 'bldgalon@gmail.com', '9fa3b8aa0ddc5a5b0b7f322c637d0b6e', 3, 'no-image-available.png', 0, '2022-05-13 12:56:34'),
(3, 'Jenn', 'DM', 'jenndm@gmail.com', 'cd98e2b7dad295ed9207eb761f4eff48', 3, '1652446800_e259dd19c9cc6e043f8755a0007d7656.jpg', 0, '2022-05-13 13:00:35'),
(4, 'Jess', 'DM', 'jessdm@gmail.com', 'cd98e2b7dad295ed9207eb761f4eff48', 3, '1652446860_green-haired-anime-girl-1.jpg', 0, '2022-05-13 13:01:23'),
(5, 'Clarence', 'Silva', 'cmsilva@gmail.com', '00817ee5a9d9db82b866936e25433121', 3, 'no-image-available.png', 0, '2022-05-13 17:52:39');

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
  `date` date DEFAULT current_timestamp(),
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT current_timestamp(),
  `user_id` int(30) NOT NULL,
  `file_name` text DEFAULT NULL,
  `file_type` varchar(255) DEFAULT NULL,
  `file_size` int(255) DEFAULT NULL,
  `file_path` text DEFAULT NULL,
  `date_uploaded` datetime DEFAULT current_timestamp(),
  `status` enum('1','0') CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '1',
  `active` int(1) NOT NULL DEFAULT 0,
  `time_rendered` float DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `group_list`
--
ALTER TABLE `group_list`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `tbl_files`
--
ALTER TABLE `tbl_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_notifications`
--
ALTER TABLE `tbl_notifications`
  ADD PRIMARY KEY (`n_id`);

--
-- Indexes for table `tbl_status`
--
ALTER TABLE `tbl_status`
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
-- AUTO_INCREMENT for table `group_list`
--
ALTER TABLE `group_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `project_list`
--
ALTER TABLE `project_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `task_list`
--
ALTER TABLE `task_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_files`
--
ALTER TABLE `tbl_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_notifications`
--
ALTER TABLE `tbl_notifications`
  MODIFY `n_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_status`
--
ALTER TABLE `tbl_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_productivity`
--
ALTER TABLE `user_productivity`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
