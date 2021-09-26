-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 26, 2021 at 09:43 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `square`
--

-- --------------------------------------------------------

--
-- Table structure for table `education_goal`
--

CREATE TABLE `education_goal` (
  `id` int(11) NOT NULL,
  `goal_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `achieved` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `education_goal`
--

INSERT INTO `education_goal` (`id`, `goal_id`, `title`, `achieved`) VALUES
(1, 1, 'kuai study', 1),
(2, 1, 'fast study', 0),
(3, 1, 'late night study', 0),
(4, 8, 'Degree', 0),
(5, 8, 'CGPA 4.0', 0);

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `organization_id` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `user_id`, `organization_id`, `title`, `description`, `date`) VALUES
(1, NULL, 'C1111', 'A company event', 'A big event', '2021-09-23'),
(2, NULL, 'C1111', 'expired event', 'expired', '2021-09-13'),
(3, 'C1632075626426', NULL, 'A new event for self', 'Event for self', '2021-09-24'),
(4, 'C1632075626426', NULL, 'A new event for self2', 'Event for self2', '2021-09-25'),
(5, NULL, 'C1111', 'Event for company', 'A event for company', '2021-09-24'),
(6, 'I1632639524515', NULL, 'Project Demo', 'Demo this project', '2021-09-27'),
(7, 'I1632639524515', NULL, 'Sem break starts', 'End of semester 2', '2021-10-01'),
(8, 'I1632639524515', NULL, 'A new event for self', 'Event for self', '2021-09-29'),
(9, 'I1632639524515', NULL, 'Sem 3 ', 'Sem 3 starts', '2021-10-18'),
(10, 'S1632641619300', NULL, 'Event', 'Literally a new event', '2021-09-29');

-- --------------------------------------------------------

--
-- Table structure for table `goals`
--

CREATE TABLE `goals` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `health_count` int(11) NOT NULL DEFAULT 0,
  `education_count` int(11) NOT NULL DEFAULT 0,
  `skills_count` int(11) NOT NULL DEFAULT 0,
  `social_count` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `goals`
--

INSERT INTO `goals` (`id`, `user_id`, `health_count`, `education_count`, `skills_count`, `social_count`) VALUES
(1, 'C1632075626426', 4, 3, 2, 1),
(2, 'C1632142508896', 0, 0, 0, 0),
(3, 'I1631892721235', 0, 0, 0, 0),
(4, 'S1632075610313', 0, 0, 0, 0),
(5, 'S1632143292247', 0, 0, 0, 0),
(6, 'S1632509169172', 0, 0, 0, 0),
(8, 'I1632639524515', 2, 2, 3, 3),
(9, 'S1632641619300', 0, 0, 0, 0),
(10, 'S1632641994994', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `health_goal`
--

CREATE TABLE `health_goal` (
  `id` int(11) NOT NULL,
  `goal_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `achieved` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `health_goal`
--

INSERT INTO `health_goal` (`id`, `goal_id`, `title`, `achieved`) VALUES
(1, 1, 'eat rice', 0),
(2, 1, 'more rice', 1),
(3, 1, 'eat vege', 0),
(4, 1, 'fit fit', 0),
(5, 8, 'Healthy me', 0),
(6, 8, 'Healthy go happy', 0);

-- --------------------------------------------------------

--
-- Table structure for table `organization`
--

CREATE TABLE `organization` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `member_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `organization`
--

INSERT INTO `organization` (`id`, `name`, `member_count`) VALUES
('C1002', 'Loa Inc', 0),
('C1111', 'Company 1', 2),
('S1002', 'Kiy High School', 2),
('S2222', 'School 1', 3);

-- --------------------------------------------------------

--
-- Table structure for table `org_goal`
--

CREATE TABLE `org_goal` (
  `Id` int(11) NOT NULL,
  `org_id` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `achieved` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `org_goal`
--

INSERT INTO `org_goal` (`Id`, `org_id`, `title`, `achieved`) VALUES
(3, 'C1111', 'Geng ', 0),
(4, 'C1111', 'Very Geng', 0),
(5, 'C1111', 'Hey', 1);

-- --------------------------------------------------------

--
-- Table structure for table `skills_goal`
--

CREATE TABLE `skills_goal` (
  `id` int(11) NOT NULL,
  `goal_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `achieved` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `skills_goal`
--

INSERT INTO `skills_goal` (`id`, `goal_id`, `title`, `achieved`) VALUES
(1, 1, 'music', 1),
(2, 1, 'code', 0),
(3, 8, 'Code', 0),
(4, 8, 'Music', 0),
(5, 8, 'Design', 0);

-- --------------------------------------------------------

--
-- Table structure for table `social_goal`
--

CREATE TABLE `social_goal` (
  `id` int(11) NOT NULL,
  `goal_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `achieved` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `social_goal`
--

INSERT INTO `social_goal` (`id`, `goal_id`, `title`, `achieved`) VALUES
(1, 1, 'get gf', 0),
(2, 8, 'Have friends', 0),
(3, 8, 'Set up social media', 0),
(4, 8, 'Add 100 friends ', 0);

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `organization_id` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `dueDate` date NOT NULL,
  `done` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`id`, `user_id`, `organization_id`, `title`, `description`, `dueDate`, `done`) VALUES
(1, 'I1631892721235', NULL, 'Code finish this thing', 'faster finish la diu', '2021-09-22', 1),
(2, 'I1631892721235', NULL, 'Need to finish', 'fast fast', '2021-09-23', 1),
(3, 'I1631892721235', NULL, 'Short', 'asd', '2021-09-22', 0),
(4, 'I1631892721235', NULL, 'loooong', 'dddd', '2021-09-22', 0),
(5, 'C1632075626426', 'C1111', 'COMPANY TASK 1', 'A TASK', '2021-09-21', 1),
(6, 'C1632075626426', NULL, 'SELF TASK 1', 'SELF TASK', '2021-09-22', 0),
(7, 'C1632075626426', 'C1111', 'COMPANY TASK 2', 'task 2', '2021-09-22', 0),
(8, 'C1632075626426', NULL, 'A task', 'Literally A new task', '2021-09-21', 0),
(9, 'C1632075626426', NULL, 'A task 2', 'Literally A new task 2', '2021-09-22', 1),
(10, 'C1632075626426', NULL, 'Self Task', ' a self task', '2021-09-21', 0),
(12, 'C1632142508896', 'C1111', 'Single Task', 'A single task', '2021-09-23', 0),
(13, 'C1632075626426', 'C1111', 'A task 2', 'Literally A new task', '2021-09-22', 0),
(14, 'C1632142508896', 'C1111', 'A task 2', 'Literally A new task', '2021-09-22', 1),
(15, 'I1632639524515', NULL, 'Task1', 'A new task', '2021-09-30', 0),
(16, 'I1632639524515', NULL, 'Task 2', 'A new task 2', '2021-10-01', 0),
(17, 'I1632639524515', NULL, 'Done Task', 'A task', '2021-09-27', 0),
(18, 'S1632641619300', NULL, 'A task', 'A new task', '2021-09-30', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `isAdmin` tinyint(1) NOT NULL DEFAULT 0,
  `field` varchar(255) NOT NULL,
  `organization` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `isAdmin`, `field`, `organization`) VALUES
('C1632075626426', 'username3', 'password0', 1, 'company', 'C1111'),
('C1632142508896', 'username4', 'password0', 0, 'company', 'C1111'),
('I1631892721235', 'username0', 'password0', 0, 'self', NULL),
('I1632639524515', 'self1', 'password0', 0, 'self', NULL),
('S1632075610313', 'username1', 'password0', 0, 'school', 'S2222'),
('S1632143292247', 'username5', 'password0', 0, 'school', 'S2222'),
('S1632509169172', 'username6', 'password0', 0, 'school', 'S2222'),
('S1632641619300', 'schooluser1', 'password0', 0, 'school', 'S1002'),
('S1632641994994', 'schooladmin1', 'password0', 1, 'school', 'S1002');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `education_goal`
--
ALTER TABLE `education_goal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `goal_id` (`goal_id`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `organization_id` (`organization_id`);

--
-- Indexes for table `goals`
--
ALTER TABLE `goals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `health_goal`
--
ALTER TABLE `health_goal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `goal_id` (`goal_id`);

--
-- Indexes for table `organization`
--
ALTER TABLE `organization`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `org_goal`
--
ALTER TABLE `org_goal`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `org_id` (`org_id`);

--
-- Indexes for table `skills_goal`
--
ALTER TABLE `skills_goal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `goal_id` (`goal_id`);

--
-- Indexes for table `social_goal`
--
ALTER TABLE `social_goal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `goal_id` (`goal_id`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `organization_id` (`organization_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `organization` (`organization`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `education_goal`
--
ALTER TABLE `education_goal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `goals`
--
ALTER TABLE `goals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `health_goal`
--
ALTER TABLE `health_goal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `org_goal`
--
ALTER TABLE `org_goal`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `skills_goal`
--
ALTER TABLE `skills_goal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `social_goal`
--
ALTER TABLE `social_goal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `education_goal`
--
ALTER TABLE `education_goal`
  ADD CONSTRAINT `education_goal_ibfk_1` FOREIGN KEY (`goal_id`) REFERENCES `goals` (`id`);

--
-- Constraints for table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `event_ibfk_2` FOREIGN KEY (`organization_id`) REFERENCES `organization` (`id`);

--
-- Constraints for table `goals`
--
ALTER TABLE `goals`
  ADD CONSTRAINT `goals_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `health_goal`
--
ALTER TABLE `health_goal`
  ADD CONSTRAINT `health_goal_ibfk_1` FOREIGN KEY (`goal_id`) REFERENCES `goals` (`id`);

--
-- Constraints for table `org_goal`
--
ALTER TABLE `org_goal`
  ADD CONSTRAINT `org_goal_ibfk_1` FOREIGN KEY (`org_id`) REFERENCES `organization` (`id`);

--
-- Constraints for table `skills_goal`
--
ALTER TABLE `skills_goal`
  ADD CONSTRAINT `skills_goal_ibfk_1` FOREIGN KEY (`goal_id`) REFERENCES `goals` (`id`);

--
-- Constraints for table `social_goal`
--
ALTER TABLE `social_goal`
  ADD CONSTRAINT `social_goal_ibfk_1` FOREIGN KEY (`goal_id`) REFERENCES `goals` (`id`);

--
-- Constraints for table `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `task_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `task_ibfk_2` FOREIGN KEY (`organization_id`) REFERENCES `organization` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`organization`) REFERENCES `organization` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
