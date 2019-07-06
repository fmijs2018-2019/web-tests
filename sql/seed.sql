-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 06, 2019 at 11:05 AM
-- Server version: 10.3.15-MariaDB
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web-tests`
--
CREATE DATABASE IF NOT EXISTS `web-tests` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `web-tests`;

-- --------------------------------------------------------

--
-- Table structure for table `answer_results`
--

CREATE TABLE `answer_results` (
  `id` int(11) NOT NULL,
  `test_result_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `given_answer` int(11) NOT NULL,
  `correct_answer` int(11) NOT NULL,
  `question_text` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `answer_results`
--

INSERT INTO `answer_results` (`id`, `test_result_id`, `question_id`, `given_answer`, `correct_answer`, `question_text`) VALUES
(17, 26, 133, 2, 1, 'What does SQL stand for?'),
(18, 26, 134, 2, 2, 'Which SQL statement is used to extract data from a database?'),
(19, 26, 135, 2, 3, 'Which SQL statement is used to update data in a database?'),
(20, 26, 136, 2, 3, 'Which SQL statement is used to delete data from a database?'),
(21, 26, 137, 2, 4, 'Which SQL statement is used to insert new data in a database?'),
(22, 26, 138, 2, 2, 'With SQL, how do you select a column named \"FirstName\" from a table named \"Persons\"?'),
(23, 26, 139, 3, 1, 'With SQL, how do you select all the columns from a table named \"Persons\"?'),
(24, 26, 140, 2, 4, 'With SQL, how do you select all the records from a table named \"Persons\" where the value of the column \"FirstName\" is \"Peter\"?'),
(25, 27, 133, 2, 1, 'What does SQL stand for?'),
(26, 27, 134, 2, 2, 'Which SQL statement is used to extract data from a database?'),
(27, 27, 135, 2, 3, 'Which SQL statement is used to update data in a database?'),
(28, 27, 136, 3, 3, 'Which SQL statement is used to delete data from a database?'),
(29, 27, 137, 3, 4, 'Which SQL statement is used to insert new data in a database?'),
(30, 27, 138, 3, 2, 'With SQL, how do you select a column named \"FirstName\" from a table named \"Persons\"?'),
(31, 27, 139, 2, 1, 'With SQL, how do you select all the columns from a table named \"Persons\"?'),
(32, 27, 140, 2, 4, 'With SQL, how do you select all the records from a table named \"Persons\" where the value of the column \"FirstName\" is \"Peter\"?'),
(33, 28, 149, 2, 1, 'What does SQL stand for?'),
(34, 28, 150, 3, 2, 'Which SQL statement is used to extract data from a database?'),
(35, 28, 151, 3, 3, 'Which SQL statement is used to update data in a database?'),
(36, 28, 152, 1, 3, 'Which SQL statement is used to delete data from a database?'),
(37, 28, 153, 1, 4, 'Which SQL statement is used to insert new data in a database?'),
(38, 28, 154, 1, 2, 'With SQL, how do you select a column named \"FirstName\" from a table named \"Persons\"?'),
(39, 28, 155, 1, 1, 'With SQL, how do you select all the columns from a table named \"Persons\"?'),
(40, 28, 156, 1, 4, 'With SQL, how do you select all the records from a table named \"Persons\" where the value of the column \"FirstName\" is \"Peter\"?');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `text` varchar(1024) NOT NULL,
  `answer_1` varchar(256) NOT NULL DEFAULT '''''',
  `answer_2` varchar(256) NOT NULL DEFAULT '''''',
  `answer_3` varchar(256) NOT NULL DEFAULT '''''',
  `answer_4` varchar(256) NOT NULL DEFAULT '''''',
  `correct_answer` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `test_id`, `text`, `answer_1`, `answer_2`, `answer_3`, `answer_4`, `correct_answer`) VALUES
(133, 61, 'What does SQL stand for?', 'Structured Query Language', 'Structured Question Language', 'Strong Question Language', 'All af the above', 1),
(134, 61, 'Which SQL statement is used to extract data from a database?', 'OPEN', 'SELECT', 'EXTRACT', 'GET', 2),
(135, 61, 'Which SQL statement is used to update data in a database?', 'MODIFY', 'SAVE', 'UPDATE', 'SAVE AS', 3),
(136, 61, 'Which SQL statement is used to delete data from a database?', 'REMOVE', 'COLLAPSE', 'DELETE', 'SELECT', 3),
(137, 61, 'Which SQL statement is used to insert new data in a database?', 'ADD NEW', 'ADD RECORD', 'INSERT NEW', 'INSERT INTO', 4),
(138, 61, 'With SQL, how do you select a column named \"FirstName\" from a table named \"Persons\"?', 'EXTRACT FirstName FROM Persons', 'SELECT FirstName FROM Persons', 'SELECT Persons.FirstName', 'None of the above are correct', 2),
(139, 61, 'With SQL, how do you select all the columns from a table named \"Persons\"?', 'SELECT * FROM Persons', 'SELECT Persons', 'SELECT [all] FROM Persons', 'SELECT *.Persons', 1),
(140, 61, 'With SQL, how do you select all the records from a table named \"Persons\" where the value of the column \"FirstName\" is \"Peter\"?', ' SELECT [all] FROM Persons WHERE FirstName=\'Peter', 'SELECT * FROM Persons WHERE FirstName<>\'Peter', 'SELECT [all] FROM Persons WHERE FirstName LIKE \'Peter', 'SELECT * FROM Persons WHERE FirstName=\'Peter', 4),
(141, 62, 'What does SQL stand for?', 'Structured Query Language', 'Structured Question Language', 'Strong Question Language', 'All af the above', 1),
(142, 62, 'Which SQL statement is used to extract data from a database?', 'OPEN', 'SELECT', 'EXTRACT', 'GET', 2),
(143, 62, 'Which SQL statement is used to update data in a database?', 'MODIFY', 'SAVE', 'UPDATE', 'SAVE AS', 3),
(144, 62, 'Which SQL statement is used to delete data from a database?', 'REMOVE', 'COLLAPSE', 'DELETE', 'SELECT', 3),
(145, 62, 'Which SQL statement is used to insert new data in a database?', 'ADD NEW', 'ADD RECORD', 'INSERT NEW', 'INSERT INTO', 4),
(146, 62, 'With SQL, how do you select a column named \"FirstName\" from a table named \"Persons\"?', 'EXTRACT FirstName FROM Persons', 'SELECT FirstName FROM Persons', 'SELECT Persons.FirstName', 'None of the above are correct', 2),
(147, 62, 'With SQL, how do you select all the columns from a table named \"Persons\"?', 'SELECT * FROM Persons', 'SELECT Persons', 'SELECT [all] FROM Persons', 'SELECT *.Persons', 1),
(148, 62, 'With SQL, how do you select all the records from a table named \"Persons\" where the value of the column \"FirstName\" is \"Peter\"?', ' SELECT [all] FROM Persons WHERE FirstName=\'Peter\'', 'SELECT * FROM Persons WHERE FirstName<>\'Peter\'', 'SELECT [all] FROM Persons WHERE FirstName LIKE \'Peter\'', 'SELECT * FROM Persons WHERE FirstName=\'Peter\'', 4),
(149, 63, 'What does SQL stand for?', 'Structured Query Language', 'Structured Question Language', 'Strong Question Language', 'All af the above', 1),
(150, 63, 'Which SQL statement is used to extract data from a database?', 'OPEN', 'SELECT', 'EXTRACT', 'GET', 2),
(151, 63, 'Which SQL statement is used to update data in a database?', 'MODIFY', 'SAVE', 'UPDATE', 'SAVE AS', 3),
(152, 63, 'Which SQL statement is used to delete data from a database?', 'REMOVE', 'COLLAPSE', 'DELETE', 'SELECT', 3),
(153, 63, 'Which SQL statement is used to insert new data in a database?', 'ADD NEW', 'ADD RECORD', 'INSERT NEW', 'INSERT INTO', 4),
(154, 63, 'With SQL, how do you select a column named \"FirstName\" from a table named \"Persons\"?', 'EXTRACT FirstName FROM Persons', 'SELECT FirstName FROM Persons', 'SELECT Persons.FirstName', 'None of the above are correct', 2),
(155, 63, 'With SQL, how do you select all the columns from a table named \"Persons\"?', 'SELECT * FROM Persons', 'SELECT Persons', 'SELECT [all] FROM Persons', 'SELECT *.Persons', 1),
(156, 63, 'With SQL, how do you select all the records from a table named \"Persons\" where the value of the column \"FirstName\" is \"Peter\"?', ' SELECT [all] FROM Persons WHERE FirstName=\'Peter', 'SELECT * FROM Persons WHERE FirstName<>\'Peter', 'SELECT [all] FROM Persons WHERE FirstName LIKE \'Peter', 'SELECT * FROM Persons WHERE FirstName=\'Peter', 4),
(157, 64, 'What does SQL stand for?', 'Structured Query Language', 'Structured Question Language', 'Strong Question Language', 'All af the above', 1),
(158, 64, 'Which SQL statement is used to extract data from a database?', 'OPEN', 'SELECT', 'EXTRACT', 'GET', 2),
(159, 64, 'Which SQL statement is used to update data in a database?', 'MODIFY', 'SAVE', 'UPDATE', 'SAVE AS', 3),
(160, 64, 'Which SQL statement is used to delete data from a database?', 'REMOVE', 'COLLAPSE', 'DELETE', 'SELECT', 3),
(161, 64, 'Which SQL statement is used to insert new data in a database?', 'ADD NEW', 'ADD RECORD', 'INSERT NEW', 'INSERT INTO', 4),
(162, 64, 'With SQL, how do you select a column named \"FirstName\" from a table named \"Persons\"?', 'EXTRACT FirstName FROM Persons', 'SELECT FirstName FROM Persons', 'SELECT Persons.FirstName', 'None of the above are correct', 2),
(163, 64, 'With SQL, how do you select all the columns from a table named \"Persons\"?', 'SELECT * FROM Persons', 'SELECT Persons', 'SELECT [all] FROM Persons', 'SELECT *.Persons', 1),
(164, 64, 'With SQL, how do you select all the records from a table named \"Persons\" where the value of the column \"FirstName\" is \"Peter\"?', ' SELECT [all] FROM Persons WHERE FirstName=\'Peter', 'SELECT * FROM Persons WHERE FirstName<>\'Peter', 'SELECT [all] FROM Persons WHERE FirstName LIKE \'Peter', 'SELECT * FROM Persons WHERE FirstName=\'Peter', 4);

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE `tests` (
  `id` int(11) NOT NULL,
  `topic` varchar(256) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tests`
--

INSERT INTO `tests` (`id`, `topic`, `created_at`, `created_by`) VALUES
(61, 'SQL Beginners Quiz', '2019-07-06 08:21:17', 'google-oauth2|116727614381765250760'),
(62, 'SQL Intermediate Quiz', '2019-07-06 08:22:29', 'google-oauth2|116727614381765250760'),
(63, 'SQL Advanced Quiz', '2019-07-06 08:24:08', 'google-oauth2|116727614381765250760'),
(64, 'SQL quiz for dummies', '2019-07-06 09:04:25', 'auth0|5ce8fdf20828151101feef0a');

-- --------------------------------------------------------

--
-- Table structure for table `test_results`
--

CREATE TABLE `test_results` (
  `id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `user_id` varchar(256) NOT NULL,
  `correct_answers` int(11) NOT NULL,
  `questions_count` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `test_results`
--

INSERT INTO `test_results` (`id`, `test_id`, `user_id`, `correct_answers`, `questions_count`, `created_at`) VALUES
(26, 61, 'google-oauth2|116727614381765250760', 2, 8, '2019-07-06 08:43:18'),
(27, 61, 'google-oauth2|116727614381765250760', 2, 8, '2019-07-06 08:47:07'),
(28, 63, 'google-oauth2|116727614381765250760', 2, 8, '2019-07-06 08:47:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answer_results`
--
ALTER TABLE `answer_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_answer_results_questions` (`question_id`),
  ADD KEY `FK_answer_results_test_results` (`test_result_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_questions_tests` (`test_id`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `test_results`
--
ALTER TABLE `test_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_test_results_tests` (`test_id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answer_results`
--
ALTER TABLE `answer_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=165;

--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `test_results`
--
ALTER TABLE `test_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answer_results`
--
ALTER TABLE `answer_results`
  ADD CONSTRAINT `FK_answer_results_questions` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`),
  ADD CONSTRAINT `FK_answer_results_test_results` FOREIGN KEY (`test_result_id`) REFERENCES `test_results` (`id`);

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `FK_questions_tests` FOREIGN KEY (`test_id`) REFERENCES `tests` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `test_results`
--
ALTER TABLE `test_results`
  ADD CONSTRAINT `FK_test_results_tests` FOREIGN KEY (`test_id`) REFERENCES `tests` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
