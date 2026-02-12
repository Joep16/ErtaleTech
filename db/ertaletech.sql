-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 16, 2024 at 09:42 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ertaletech`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`firstname`, `lastname`, `email`, `subject`, `message`, `id`) VALUES
('yohannes ', 'gebreselassie', 'yohannes161@gmail.com', 'thanks', 'kafasjf asfjsbafsa', 1),
('mikiyas', 'tadesse', 'yoo161@gmail.com', 'code', 'safnfhsaf', 2),
('yohannes ', 'gebreselassie', 'yohannes161@gmail.com', 'thanks', 'sdgs', 3),
('mikiyas', 'gebreselassie', 'end@gmail.com', 'code', 'sgsdg', 4);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `number` varchar(255) NOT NULL,
  `partner` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `user_id`, `name`, `number`, `partner`) VALUES
(14, 10, 'jo', '12', 'jo jo');

-- --------------------------------------------------------

--
-- Table structure for table `motivation`
--

CREATE TABLE `motivation` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `motivation` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`id`, `user_id`, `title`, `content`, `created_at`) VALUES
(3, 12, 'skdasd', 'kfnasf fasfkjhnasf asfksanf', '2024-08-08 10:54:18');

-- --------------------------------------------------------

--
-- Table structure for table `reminders`
--

CREATE TABLE `reminders` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `reminder` text NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reminders`
--

INSERT INTO `reminders` (`id`, `date`, `reminder`, `user_id`) VALUES
(17, '2024-12-08', 'xxzfvsv', 11),
(30, '2024-09-22', 'xcxvvxczvfdhfg', 10);

-- --------------------------------------------------------

--
-- Table structure for table `sell`
--

CREATE TABLE `sell` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `coname` varchar(255) NOT NULL,
  `cname` varchar(255) NOT NULL,
  `item` varchar(255) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `unit` int(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `dates` date NOT NULL,
  `phone` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sell`
--

INSERT INTO `sell` (`id`, `user_id`, `coname`, `cname`, `item`, `brand`, `unit`, `price`, `email`, `dates`, `phone`) VALUES
(10, 10, 'mhs trading', 'tesfaye kebede', 'car', 'toyota', 1, '2', 'yoo161@gmail.com', '2024-08-07', '0947000000'),
(11, 4, 'jhoerp', 'Yakob Abebe', 'gold', '120 carat', 1, '25', 'yakob@gmail.com', '2024-08-07', '0947000000'),
(12, 12, 'lead addis', 'naol mengesha', 'gold', '120 carat', 1, '200', 'naol@gmail.com', '2024-08-08', '0947000000'),
(13, 13, 'naolsgold', 'tesfaye kebede', 'gold', '120 carat', 1, '2', 'yohannes161@gmail.com', '2024-08-04', '0947000000'),
(15, 10, 'mhs trading', 'fasf', 'asfa', 'fasf', 1, '12', 'jo@gmail.com', '2024-08-28', '09999999');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `phone` varchar(13) NOT NULL,
  `email` varchar(255) CHARACTER SET latin1 NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 NOT NULL,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `phone`, `email`, `password`, `name`) VALUES
(4, '0931676400', 'jo@gmail.com', '06c47572d60c55a17a21dd73dc7053a6', 'jhoerp'),
(9, '0931676400', 'joep@gmail.com', '18969e55f92c7f6b6e07e38688e4c2ef', 'Yohannes Gebreselassie'),
(10, '0931676400', 'mhs@gmail.com', 'f4a9bdd7a328c6f106e4eaf570185cbc', 'mhs trading'),
(11, '0931676400', 'yohannes161@gmail.com', '06c47572d60c55a17a21dd73dc7053a6', 'administrator'),
(12, '0913030327', 'leadaddis@gmail.com', '06c47572d60c55a17a21dd73dc7053a6', 'lead addis'),
(13, '0960362108', 'naolmengesha101@gmail.com', 'd4a7532831ee320022652c02d6f04344', 'naolsgold'),
(14, '0931676400', 'joes@gmail.com', '06c47572d60c55a17a21dd73dc7053a6', 'joes'),
(15, '0921372486', 'asd@gmail.com', '44c65676d693fd40b67b7c6fa4bfb3ce', 'asldjabsd'),
(16, '0911334455', 'yo@gmail.com', '91dd8f8f2ae1961fc47071bcfc712ee7', 'yohannes'),
(17, '0999000000', 'fa@gmail.com', '06c47572d60c55a17a21dd73dc7053a6', 'sdff');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `motivation`
--
ALTER TABLE `motivation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `reminders`
--
ALTER TABLE `reminders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `sell`
--
ALTER TABLE `sell`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `motivation`
--
ALTER TABLE `motivation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `reminders`
--
ALTER TABLE `reminders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `sell`
--
ALTER TABLE `sell`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `motivation`
--
ALTER TABLE `motivation`
  ADD CONSTRAINT `motivation_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `reminders`
--
ALTER TABLE `reminders`
  ADD CONSTRAINT `reminders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `sell`
--
ALTER TABLE `sell`
  ADD CONSTRAINT `sell_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
