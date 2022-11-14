-- phpMyAdmin SQL Dump
-- version 5.0.4deb2+deb11u1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 14, 2022 at 09:37 PM
-- Server version: 10.5.15-MariaDB-0+deb11u1
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `attendance`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attnID` int(11) NOT NULL,
  `time` time NOT NULL,
  `date` date NOT NULL,
  `usrID` varchar(255) NOT NULL,
  `cID` int(9) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`attnID`, `time`, `date`, `usrID`, `cID`) VALUES
(48, '10:00:00', '2022-11-11', 'wahidah', 9),
(47, '10:00:00', '2022-11-11', 'Vijay', 9),
(44, '10:00:00', '2022-11-11', 'Yuga', 9),
(46, '10:00:00', '2022-11-11', 'Surya', 9),
(42, '10:00:00', '2022-11-11', 'yuven', 9),
(45, '10:00:00', '2022-11-11', 'Rocky', 9);

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `cID` int(9) NOT NULL,
  `name` varchar(225) NOT NULL,
  `lecturer` varchar(99) NOT NULL,
  `student` varchar(999) NOT NULL,
  `timeSlot` time NOT NULL,
  `timeSlot2` time NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`cID`, `name`, `lecturer`, `student`, `timeSlot`, `timeSlot2`) VALUES
(9, 'Database 2', 'chandru', '30', '10:00:00', '12:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(9) NOT NULL,
  `sID` varchar(99) NOT NULL,
  `cID` int(9) NOT NULL,
  `LID` varchar(99) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `sID`, `cID`, `LID`) VALUES
(9, 'Surya', 9, 'chandru'),
(7, 'yuven', 9, 'chandru'),
(10, 'Vijay', 9, 'chandru'),
(8, 'Rocky', 9, 'chandru'),
(11, 'wahidah', 9, 'chandru');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id` varchar(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `Hp` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `type_user` varchar(20) NOT NULL,
  `facial` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `id`, `name`, `Hp`, `email`, `type_user`, `facial`) VALUES
('Admin', '123', '', '', '', '', 'Admin', 0),
('Puven', '123', 'EE913728', 'Puvendra Dasan', '019384342', 'puvendradasan1699@gmail.com', 'Lecturer', 0),
('yuven', '123', 'SN0123023', 'Yuven', '0122973652', 'yuven17@gmail.com', 'Student', 0),
('Rocky', '123', 'SN0107036', 'Rocky', '0102206062', 'rocky@gmail.com', 'Student', 1),
('Surya', '123', 'sn0107080', 'Surya', '0102206034', 'surya@gmail.com', 'Student', 1),
('wahidah', '123', 'cs12345', 'wahidah', '0123456789', 'wahidah@gmail.com', 'Student', 1),
('Vijay', '123', 'SN0123025', 'Vijay', '01234456657', 'vijay12@gamil.com', 'Student', 1),
('Chandru', '123', 'CS88888', 'Chandru', '0123343432', 'chandru123@gmail.com', 'Lecturer', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attnID`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`cID`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attnID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `cID` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
