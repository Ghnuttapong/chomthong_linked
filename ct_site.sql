-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 01, 2023 at 02:59 PM
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
-- Database: `ct_site`
--

-- --------------------------------------------------------

--
-- Table structure for table `agencies`
--

CREATE TABLE `agencies` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(10) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `agencies`
--

INSERT INTO `agencies` (`id`, `name`, `address`, `phone`, `user_id`) VALUES
(1, 'Big Home Ld.', '21/2 อ.เมือง', '0999999999', 4);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `department` varchar(100) NOT NULL,
  `degree` varchar(100) NOT NULL,
  `birthday` date NOT NULL,
  `link` varchar(200) DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `department`, `degree`, `birthday`, `link`, `user_id`) VALUES
(1, 'คอมพิวเตอร์ธุรกิจ', 'ปวช.', '2023-02-16', 'https://www.google.com/?gws_rd=ssl', 2),
(4, 'ช่างไฟฟ้ากำลัง', 'ปวส.', '2020-02-09', NULL, 5),
(5, 'การบัญชี', 'ปวส.', '2014-10-31', NULL, 6),
(7, 'ช่างยนต์(ทวิภาคี)', 'ปวช.', '2013-03-04', NULL, 8);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `prefix` varchar(200) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `fullname` varchar(200) NOT NULL,
  `role` int(11) NOT NULL,
  `path` varchar(200) DEFAULT NULL,
  `enabled` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `prefix`, `firstname`, `lastname`, `fullname`, `role`, `path`, `enabled`) VALUES
(1, 'admin', '5f4dcc3b5aa765d61d8327deb882cf99', 'นาย', 'ณัฐพงศ์', 'วิภา', 'นายณัฐพงศ์ วิภา', 2, '202302280423541661947962.png', 1),
(2, '64309010030', '5f4dcc3b5aa765d61d8327deb882cf99', 'นาย', 'ณัฐพงศ์', 'วิภา', 'นายณัฐพงศ์ วิภา', 0, NULL, 1),
(4, 'bighome', '5f4dcc3b5aa765d61d8327deb882cf99', 'นาย', 'น้อง', 'จ๋าย', 'นายน้อง จ๋าย', 1, '202302280434471445658616.jpg', 1),
(5, '64309010032', '5f4dcc3b5aa765d61d8327deb882cf99', 'นาย', 'มด', 'ดำ', 'นายมด ดำ', 0, NULL, 1),
(6, '64309010034', '5f4dcc3b5aa765d61d8327deb882cf99', 'นาย', 'สาว', 'สาว', 'นายสาว สาว', 0, NULL, 1),
(8, '64309010036', '5f4dcc3b5aa765d61d8327deb882cf99', 'นาย', 'ทดสอบ', 'ทดสอบ', 'นายทดสอบ ทดสอบ', 0, NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agencies`
--
ALTER TABLE `agencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
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
-- AUTO_INCREMENT for table `agencies`
--
ALTER TABLE `agencies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
