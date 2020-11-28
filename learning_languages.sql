-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2019 at 10:15 PM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `learning_languages`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `key_hash` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `reporting`
--

CREATE TABLE `reporting` (
  `id` int(11) NOT NULL,
  `key_hash` varchar(50) NOT NULL,
  `report` varchar(255) NOT NULL,
  `id_word` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `the_words`
--

CREATE TABLE `the_words` (
  `id` int(40) NOT NULL,
  `key_hash` varchar(40) NOT NULL,
  `word_english` varchar(255) NOT NULL,
  `word_arabic` varchar(255) NOT NULL,
  `share` tinyint(2) NOT NULL,
  `user_id` int(11) NOT NULL,
  `language` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `the_words`
--

INSERT INTO `the_words` (`id`, `key_hash`, `word_english`, `word_arabic`, `share`, `user_id`, `language`) VALUES
(39, 'word5cbb750b0ed25', 'sult', 'مرحبا', 1, 6, 'French'),
(40, 'word5cbb75321aa68', 'new', 'جديد', 1, 4, 'English'),
(43, 'word5cbe2b2c859d0', 'title', 'عنوان', 1, 4, 'English'),
(45, 'word5cbef18513fbd', 'nice', 'لطيف', 1, 2, 'English'),
(46, 'word5cbef1b77d1f5', 'very good', 'جيد جدا', 0, 2, 'English'),
(51, 'word5cbf2d4518169', 'parking', 'موقف', 1, 2, 'English'),
(52, 'word5cc34e9ddc3ce', 'title', 'عنوان', 1, 2, 'English'),
(53, 'word5cc4a385c5ee3', 'zebra', 'الحمار الوحشي', 1, 2, 'English'),
(56, 'word5cc8467d7ec9a', 'it\'s ok', 'لا باس', 1, 2, 'English');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `key_hash` varchar(40) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` tinyint(2) NOT NULL DEFAULT '0',
  `language` varchar(20) NOT NULL,
  `friend` varchar(20) NOT NULL COMMENT 'لاعادة تعيين كلمة المرور',
  `work` varchar(30) NOT NULL COMMENT 'لاعادة تعيين كلمة المرور',
  `share_words` varchar(10) NOT NULL COMMENT 'تحديد مشاركة الكلمات'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `key_hash`, `username`, `password`, `role`, `language`, `friend`, `work`, `share_words`) VALUES
(2, 'Learn5ca9efa71a5eb', 'قصي الشرتح', '$2y$10$VY/uICg821c6/Foq5SYHn.kEifzb10cpokGq6c4pK2ELi2pPX.R8q', 2, 'English', 'مسك', 'حاسوب', 'on'),
(4, 'Learn5cb4fe482b66f', 'ahmad', '$2y$10$DRnJH1pSZNJKL0BHHslxHuIrMuY2vXAcqISjbIfzNa./ozQh2zkzW', 0, 'English', 'محمد', 'حاسوب', 'on'),
(6, 'Learn5cbb74f74e402', 'aser syria', '$2y$10$cbdgNFlt9Ff8m1jjdH1LSuZO.7QwtVgtxG6ydZi6cAxiEuM0VM39i', 0, 'French', 'قصي', 'حاسوب', 'on');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sendTo` (`user_id`);

--
-- Indexes for table `reporting`
--
ALTER TABLE `reporting`
  ADD PRIMARY KEY (`id`),
  ADD KEY `word_id` (`id_word`),
  ADD KEY `userId` (`user_id`);

--
-- Indexes for table `the_words`
--
ALTER TABLE `the_words`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posts` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `key` (`key_hash`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reporting`
--
ALTER TABLE `reporting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `the_words`
--
ALTER TABLE `the_words`
  MODIFY `id` int(40) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `sendTo` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reporting`
--
ALTER TABLE `reporting`
  ADD CONSTRAINT `userId` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `word_id` FOREIGN KEY (`id_word`) REFERENCES `the_words` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `the_words`
--
ALTER TABLE `the_words`
  ADD CONSTRAINT `posts` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
