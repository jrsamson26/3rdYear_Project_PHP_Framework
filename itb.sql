-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: May 02, 2016 at 02:41 PM
-- Server version: 10.1.9-MariaDB-log
-- PHP Version: 5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `itb`
--

-- --------------------------------------------------------

--
-- Table structure for table `actions`
--

CREATE TABLE `actions` (
  `id` int(11) NOT NULL,
  `description` text NOT NULL,
  `implementorid` int(11) NOT NULL,
  `deadline` date NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `actions`
--

INSERT INTO `actions` (`id`, `description`, `implementorid`, `deadline`, `status`) VALUES
(1, 'Uploading the project', 22, '2016-04-11', 11);

-- --------------------------------------------------------

--
-- Table structure for table `futuremeetings`
--

CREATE TABLE `futuremeetings` (
  `id` int(11) NOT NULL,
  `description` text NOT NULL,
  `day` date NOT NULL,
  `time` time NOT NULL,
  `duration` time NOT NULL,
  `room` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `futuremeetings`
--

INSERT INTO `futuremeetings` (`id`, `description`, `day`, `time`, `duration`, `room`) VALUES
(1, 'dsadsa', '2016-05-09', '00:09:00', '00:10:00', 'A40'),
(3, 'Proper Meeting', '2016-06-05', '00:08:00', '00:09:00', 'A10');

-- --------------------------------------------------------

--
-- Table structure for table `meetings`
--

CREATE TABLE `meetings` (
  `id` int(11) NOT NULL,
  `description` text NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `room` varchar(100) NOT NULL,
  `approval` text NOT NULL COMMENT 'yes, no, maybe'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `meetings`
--

INSERT INTO `meetings` (`id`, `description`, `date`, `time`, `room`, `approval`) VALUES
(1, 'Project Meeting ', '2016-04-08', '00:59:00', 'A45', 'yes'),
(2, 'Staff Meeting', '2016-04-11', '07:00:00', 'F49', 'yes'),
(8, 'Planning to reserve sits', '2016-10-09', '00:10:00', 'A42', 'yes'),
(9, 'General Staff Meeting', '2016-05-06', '00:09:00', 'B40', 'yes'),
(10, 'Project Meeting', '2016-05-04', '00:09:00', 'D20', 'Yes'),
(11, 'General Meeting Staff', '2016-05-03', '00:08:00', 'D19', 'Yes'),
(12, 'dd', '2016-05-06', '00:09:00', 'C29', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `member` text NOT NULL,
  `supervisor` text NOT NULL,
  `deadline` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `title`, `description`, `member`, `supervisor`, `deadline`) VALUES
(1, 'Project Report', 'report of the project', 'JRCharlesDarren ', 'Matt Smith', '2016-05-02'),
(4, 'Web Framework Project', 'Project', 'JR', 'Matt Smith', '2016-05-02');

-- --------------------------------------------------------

--
-- Table structure for table `publications`
--

CREATE TABLE `publications` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `authorid` int(11) NOT NULL,
  `url` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `publications`
--

INSERT INTO `publications` (`id`, `title`, `authorid`, `url`) VALUES
(1, 'Head First Java, 2nd Edition', 0, 'dd');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(73, 'karen', '$2y$10$x.hya2YMHraFC2kYFWL88eiRudpcQqcbwEiS9qQkQEE5h1Nr/N8zy', 1),
(74, 'admin', '$2y$10$43KHEsITibQlubKg3RrZiulYajMIcyw4tqcfkVXuU2rkK02HSDZpq', 2),
(75, 'darren', '$2y$10$cLZsq54j6lAUXhQniXahMuersQiAfwGAs/MJY.1kGkQxzy3pSuP9S', 3),
(76, 'charles', '$2y$10$UUoyDp64lLditRl61yYUVe.HrVvvmL.xZIMhzp9ixbDPywpRo8jx.', 4),
(78, 'jr', '$2y$10$Ej2uEvSGJEnGsDhTJpg/newKZZ9PbDPlqUUgS/ZLGA3Bwr.5zeNje', 2),
(98, 'adada', '$2y$10$XXJ0dnv7OdZWtxSyx3znf.rGnSSD4yBYwS/FVQBYauMfotMcHIGna', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `actions`
--
ALTER TABLE `actions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `futuremeetings`
--
ALTER TABLE `futuremeetings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meetings`
--
ALTER TABLE `meetings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `publications`
--
ALTER TABLE `publications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `actions`
--
ALTER TABLE `actions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `futuremeetings`
--
ALTER TABLE `futuremeetings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `meetings`
--
ALTER TABLE `meetings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `publications`
--
ALTER TABLE `publications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
