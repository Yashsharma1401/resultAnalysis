-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2023 at 04:35 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `manstud`
--

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `faculty_id` int(11) NOT NULL,
  `faculty_name` varchar(255) DEFAULT NULL,
  `faculty_email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`faculty_id`, `faculty_name`, `faculty_email`) VALUES
(121, 'Prof.Shirbhate', 'dhiraj@gmail.com'),
(122, 'Prof. Patil', 'patil@gmail.com'),
(123, 'Prof.Bachwani', 'bachwani@gmail.com'),
(124, 'Prof. Jhunghare ', 'jhunghare@gmail.com'),
(125, 'Prof. Sawaarkar', 'sawaarkar@gmail.com'),
(126, 'Prof. Shruti', 'sruti@gmail.com'),
(127, 'Prof. Sonali Gound', 'sonali@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `marks`
--

CREATE TABLE `marks` (
  `prn` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `marks_obtained` decimal(7,2) DEFAULT NULL,
  `semester` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `marks`
--

INSERT INTO `marks` (`prn`, `subject_id`, `marks_obtained`, `semester`) VALUES
(3027, 301, '10.00', 5),
(3027, 302, '100.00', 5),
(3027, 303, '90.00', 5),
(3027, 304, '85.00', 5),
(3027, 305, '80.00', 5),
(9860, 301, '98.00', 5),
(9860, 302, '85.00', 5),
(9860, 303, '80.00', 5),
(45024, 301, '98.00', 5),
(45024, 305, '85.00', 5),
(45025, 301, '9.00', 0),
(45025, 303, '0.00', 0),
(45025, 304, '0.00', 0),
(45026, 301, '7.00', 0),
(45026, 303, '0.00', 0),
(45027, 301, '7.00', 0),
(45027, 302, '8.00', 0),
(45048, 303, '8.00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `prn` int(11) NOT NULL,
  `student_name` varchar(255) DEFAULT NULL,
  `student_email` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `admi_year` int(11) NOT NULL,
  `total_marks` decimal(7,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`prn`, `student_name`, `student_email`, `date_of_birth`, `admi_year`, `total_marks`) VALUES
(3027, 'prajwal', 'prajwal2@gmail.com', '2001-11-02', 2020, NULL),
(3035, 'Roshan', 'roshan@gmail.com', '2002-02-01', 2020, NULL),
(3036, 'jjds', 'jjds@gmail.com', '2002-11-05', 2020, NULL),
(9860, 'bcd', 'bcd@gmail.com', '2002-02-12', 2020, '263.00'),
(45021, 'abc', 'abc@121.com', '2010-01-25', 2020, NULL),
(45024, 'Pankaj', 'pankajgite@gmail.com', '2002-06-25', 2020, '183.00'),
(45025, 'Parimal', 'parimal@gmail.com', '2002-05-12', 2020, '9.00'),
(45026, 'Prajwal ', 'prajwal@gmail.com', '2002-05-12', 2020, '7.00'),
(45027, 'Rahul', 'rahul@gmail.com', '2002-02-28', 2020, '15.00'),
(45048, 'Yash Sharma', 'yash@sharma.com', '2003-01-14', 2020, '8.00');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subject_id` int(11) NOT NULL,
  `subject_name` varchar(255) DEFAULT NULL,
  `faculty_id` int(11) DEFAULT NULL,
  `semester` int(11) DEFAULT NULL,
  `average_marks` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`subject_id`, `subject_name`, `faculty_id`, `semester`, `average_marks`) VALUES
(301, 'SE', 123, 5, '43.80'),
(302, 'BC', 121, 5, '46.50'),
(303, 'NSM', 122, 5, '22.00'),
(304, 'TOC', 124, 5, '0.00'),
(305, 'DBMS', 125, 5, '85.00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(2, 'pankaj', '121', '2023-05-11 08:37:46'),
(3, 'yash', '123', '2023-05-11 19:52:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`faculty_id`);

--
-- Indexes for table `marks`
--
ALTER TABLE `marks`
  ADD PRIMARY KEY (`prn`,`subject_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`prn`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subject_id`),
  ADD KEY `faculty_id` (`faculty_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `marks`
--
ALTER TABLE `marks`
  ADD CONSTRAINT `marks_ibfk_1` FOREIGN KEY (`prn`) REFERENCES `students` (`prn`),
  ADD CONSTRAINT `marks_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`subject_id`);

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `subjects_ibfk_1` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`faculty_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
