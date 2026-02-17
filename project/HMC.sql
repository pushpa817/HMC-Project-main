-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 02, 2024 at 04:24 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `HMC`
--

-- --------------------------------------------------------

--
-- Table structure for table `Chairman`
--

CREATE TABLE `Chairman` (
  `chairman_id` varchar(11) NOT NULL,
  `chairman_name` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `photo` varchar(255) DEFAULT 'chairman.jpg',
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Chairman`
--

INSERT INTO `Chairman` (`chairman_id`, `chairman_name`, `phone`, `photo`, `email`, `password`) VALUES
('CH999999', 'Ravi Sastri', '9876555665', 'chairman.jpg', 'ravi1234@gmail.com', 'ravi9999');

-- --------------------------------------------------------

--
-- Table structure for table `Complaints`
--

CREATE TABLE `Complaints` (
  `complaint_id` int(11) NOT NULL,
  `student_id` varchar(10) NOT NULL,
  `hall_id` int(11) NOT NULL,
  `complaint_type` enum('Mess','Hall') NOT NULL,
  `description` text NOT NULL,
  `date_raised` date NOT NULL,
  `date_resolved` date DEFAULT NULL,
  `status` enum('Pending','Resolved') NOT NULL DEFAULT 'Pending',
  `ATR` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Expenditures`
--

CREATE TABLE `Expenditures` (
  `expenditure_id` int(11) NOT NULL,
  `hall_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `date_incurred` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Halls`
--

CREATE TABLE `Halls` (
  `hall_id` int(11) NOT NULL,
  `hall_name` varchar(100) NOT NULL,
  `hall_type` varchar(20) DEFAULT NULL CHECK (`hall_type` in ('Old','New')),
  `capacity` int(11) NOT NULL,
  `single_room_cost` decimal(10,2) NOT NULL,
  `twin_sharing_room_cost` decimal(10,2) NOT NULL,
  `warden_id` varchar(11) NOT NULL,
  `category` enum('Boys','Girls') NOT NULL,
  `single_rooms` int(11) NOT NULL,
  `twin_sharing_rooms` int(11) NOT NULL,
  `anual_grant` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Halls`
--

INSERT INTO `Halls` (`hall_id`, `hall_name`, `hall_type`, `capacity`, `single_room_cost`, `twin_sharing_room_cost`, `warden_id`, `category`, `single_rooms`, `twin_sharing_rooms`, `anual_grant`) VALUES
(1, 'Ramanujan Hall', 'Old', 70, 3000.00, 5000.00, 'WD999991', 'Boys', 20, 30, 0.00),
(2, 'Infinity Hall', 'New', 80, 4000.00, 6000.00, 'WD999992', 'Boys', 25, 30, 0.00),
(3, 'Sarojini Hall', 'Old', 70, 3000.00, 5000.00, 'WD999993', 'Girls', 20, 30, 0.00),
(4, 'Delta Hall', 'New', 80, 4000.00, 6000.00, 'WD999994', 'Girls', 25, 30, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `MessManager`
--

CREATE TABLE `MessManager` (
  `mess_manager_id` varchar(11) NOT NULL,
  `mess_manager_name` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `photo` varchar(255) DEFAULT 'mess_manager.jpg',
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `MessManager`
--

INSERT INTO `MessManager` (`mess_manager_id`, `mess_manager_name`, `phone`, `photo`, `email`, `password`) VALUES
('MM999918', 'Virat Kohli', '9576543332', 'mess_manager.jpg', 'virat1818@gmail.com', 'virat1818');

-- --------------------------------------------------------

--
-- Table structure for table `Rooms`
--

CREATE TABLE `Rooms` (
  `hall_id` int(11) NOT NULL,
  `room_number` int(11) NOT NULL,
  `room_type` enum('Single','Twin Sharing') NOT NULL,
  `student_count` int(11) NOT NULL DEFAULT 0
) ;

--
-- Dumping data for table `Rooms`
--

INSERT INTO `Rooms` (`hall_id`, `room_number`, `room_type`, `student_count`) VALUES
(1, 1, 'Twin Sharing', 2),
(1, 2, 'Twin Sharing', 2),
(1, 3, 'Twin Sharing', 2),
(1, 4, 'Twin Sharing', 2),
(1, 5, 'Twin Sharing', 2),
(1, 6, 'Twin Sharing', 2),
(1, 7, 'Twin Sharing', 0),
(1, 8, 'Twin Sharing', 0),
(1, 9, 'Twin Sharing', 0),
(1, 10, 'Twin Sharing', 0),
(1, 11, 'Twin Sharing', 0),
(1, 12, 'Twin Sharing', 0),
(1, 13, 'Twin Sharing', 0),
(1, 14, 'Twin Sharing', 0),
(1, 15, 'Twin Sharing', 0),
(1, 16, 'Twin Sharing', 0),
(1, 17, 'Twin Sharing', 0),
(1, 18, 'Twin Sharing', 0),
(1, 19, 'Twin Sharing', 0),
(1, 20, 'Twin Sharing', 0),
(1, 21, 'Single', 1),
(1, 22, 'Single', 1),
(1, 23, 'Single', 1),
(1, 24, 'Single', 1),
(1, 25, 'Single', 1),
(1, 26, 'Single', 1),
(1, 27, 'Single', 1),
(1, 28, 'Single', 1),
(1, 29, 'Single', 1),
(1, 30, 'Single', 1),
(1, 31, 'Single', 0),
(1, 32, 'Single', 0),
(1, 33, 'Single', 0),
(1, 34, 'Single', 0),
(1, 35, 'Single', 0),
(1, 36, 'Single', 0),
(1, 37, 'Single', 0),
(1, 38, 'Single', 0),
(1, 39, 'Single', 0),
(1, 40, 'Single', 0),
(1, 41, 'Single', 0),
(1, 42, 'Single', 0),
(1, 43, 'Single', 0),
(1, 44, 'Single', 0),
(1, 45, 'Single', 0),
(1, 46, 'Single', 0),
(1, 47, 'Single', 0),
(1, 48, 'Single', 0),
(1, 49, 'Single', 0),
(1, 50, 'Single', 0),
(2, 1, 'Twin Sharing', 2),
(2, 2, 'Twin Sharing', 2),
(2, 3, 'Twin Sharing', 2),
(2, 4, 'Twin Sharing', 2),
(2, 5, 'Twin Sharing', 2),
(2, 6, 'Twin Sharing', 2),
(2, 7, 'Twin Sharing', 0),
(2, 8, 'Twin Sharing', 0),
(2, 9, 'Twin Sharing', 0),
(2, 10, 'Twin Sharing', 0),
(2, 11, 'Twin Sharing', 0),
(2, 12, 'Twin Sharing', 0),
(2, 13, 'Twin Sharing', 0),
(2, 14, 'Twin Sharing', 0),
(2, 15, 'Twin Sharing', 0),
(2, 16, 'Twin Sharing', 0),
(2, 17, 'Twin Sharing', 0),
(2, 18, 'Twin Sharing', 0),
(2, 19, 'Twin Sharing', 0),
(2, 20, 'Twin Sharing', 0),
(2, 21, 'Twin Sharing', 0),
(2, 22, 'Twin Sharing', 0),
(2, 23, 'Twin Sharing', 0),
(2, 24, 'Twin Sharing', 0),
(2, 25, 'Twin Sharing', 0),
(2, 26, 'Single', 1),
(2, 27, 'Single', 1),
(2, 28, 'Single', 1),
(2, 29, 'Single', 1),
(2, 30, 'Single', 1),
(2, 31, 'Single', 1),
(2, 32, 'Single', 1),
(2, 33, 'Single', 1),
(2, 34, 'Single', 1),
(2, 35, 'Single', 1),
(2, 36, 'Single', 0),
(2, 37, 'Single', 0),
(2, 38, 'Single', 0),
(2, 39, 'Single', 0),
(2, 40, 'Single', 0),
(2, 41, 'Single', 0),
(2, 42, 'Single', 0),
(2, 43, 'Single', 0),
(2, 44, 'Single', 0),
(2, 45, 'Single', 0),
(2, 46, 'Single', 0),
(2, 47, 'Single', 0),
(2, 48, 'Single', 0),
(2, 49, 'Single', 0),
(2, 50, 'Single', 0),
(2, 51, 'Single', 0),
(2, 52, 'Single', 0),
(2, 53, 'Single', 0),
(2, 54, 'Single', 0),
(2, 55, 'Single', 0),
(3, 1, 'Twin Sharing', 2),
(3, 2, 'Twin Sharing', 2),
(3, 3, 'Twin Sharing', 2),
(3, 4, 'Twin Sharing', 2),
(3, 5, 'Twin Sharing', 2),
(3, 6, 'Twin Sharing', 2),
(3, 7, 'Twin Sharing', 0),
(3, 8, 'Twin Sharing', 0),
(3, 9, 'Twin Sharing', 0),
(3, 10, 'Twin Sharing', 0),
(3, 11, 'Twin Sharing', 0),
(3, 12, 'Twin Sharing', 0),
(3, 13, 'Twin Sharing', 0),
(3, 14, 'Twin Sharing', 0),
(3, 15, 'Twin Sharing', 0),
(3, 16, 'Twin Sharing', 0),
(3, 17, 'Twin Sharing', 0),
(3, 18, 'Twin Sharing', 0),
(3, 19, 'Twin Sharing', 0),
(3, 20, 'Twin Sharing', 0),
(3, 21, 'Single', 1),
(3, 22, 'Single', 1),
(3, 23, 'Single', 1),
(3, 24, 'Single', 1),
(3, 25, 'Single', 1),
(3, 26, 'Single', 1),
(3, 27, 'Single', 1),
(3, 28, 'Single', 1),
(3, 29, 'Single', 1),
(3, 30, 'Single', 1),
(3, 31, 'Single', 0),
(3, 32, 'Single', 0),
(3, 33, 'Single', 0),
(3, 34, 'Single', 0),
(3, 35, 'Single', 0),
(3, 36, 'Single', 0),
(3, 37, 'Single', 0),
(3, 38, 'Single', 0),
(3, 39, 'Single', 0),
(3, 40, 'Single', 0),
(3, 41, 'Single', 0),
(3, 42, 'Single', 0),
(3, 43, 'Single', 0),
(3, 44, 'Single', 0),
(3, 45, 'Single', 0),
(3, 46, 'Single', 0),
(3, 47, 'Single', 0),
(3, 48, 'Single', 0),
(3, 49, 'Single', 0),
(3, 50, 'Single', 0),
(4, 1, 'Twin Sharing', 2),
(4, 2, 'Twin Sharing', 2),
(4, 3, 'Twin Sharing', 2),
(4, 4, 'Twin Sharing', 2),
(4, 5, 'Twin Sharing', 2),
(4, 6, 'Twin Sharing', 2),
(4, 7, 'Twin Sharing', 0),
(4, 8, 'Twin Sharing', 0),
(4, 9, 'Twin Sharing', 0),
(4, 10, 'Twin Sharing', 0),
(4, 11, 'Twin Sharing', 0),
(4, 12, 'Twin Sharing', 0),
(4, 13, 'Twin Sharing', 0),
(4, 14, 'Twin Sharing', 0),
(4, 15, 'Twin Sharing', 0),
(4, 16, 'Twin Sharing', 0),
(4, 17, 'Twin Sharing', 0),
(4, 18, 'Twin Sharing', 0),
(4, 19, 'Twin Sharing', 0),
(4, 20, 'Twin Sharing', 0),
(4, 21, 'Twin Sharing', 0),
(4, 22, 'Twin Sharing', 0),
(4, 23, 'Twin Sharing', 0),
(4, 24, 'Twin Sharing', 0),
(4, 25, 'Twin Sharing', 0),
(4, 26, 'Single', 1),
(4, 27, 'Single', 1),
(4, 28, 'Single', 1),
(4, 29, 'Single', 1),
(4, 30, 'Single', 1),
(4, 31, 'Single', 1),
(4, 32, 'Single', 1),
(4, 33, 'Single', 1),
(4, 34, 'Single', 1),
(4, 35, 'Single', 1),
(4, 36, 'Single', 0),
(4, 37, 'Single', 0),
(4, 38, 'Single', 0),
(4, 39, 'Single', 0),
(4, 40, 'Single', 0),
(4, 41, 'Single', 0),
(4, 42, 'Single', 0),
(4, 43, 'Single', 0),
(4, 44, 'Single', 0),
(4, 45, 'Single', 0),
(4, 46, 'Single', 0),
(4, 47, 'Single', 0),
(4, 48, 'Single', 0),
(4, 49, 'Single', 0),
(4, 50, 'Single', 0),
(4, 51, 'Single', 0),
(4, 52, 'Single', 0),
(4, 53, 'Single', 0),
(4, 54, 'Single', 0),
(4, 55, 'Single', 0);

-- --------------------------------------------------------

--
-- Table structure for table `Staff`
--

CREATE TABLE `Staff` (
  `staff_id` varchar(11) NOT NULL,
  `staff_name` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `hall_id` int(11) NOT NULL,
  `role` enum('Cleaner','Gardener') NOT NULL,
  `daily_pay` decimal(10,2) NOT NULL,
  `attended_days` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Staff`
--

INSERT INTO `Staff` (`staff_id`, `staff_name`, `phone`, `hall_id`, `role`, `daily_pay`, `attended_days`) VALUES
('SF880001', 'Arjun Malhotra', '9876123450', 1, 'Cleaner', 300.00, 0),
('SF880002', 'Geeta Bhatia', '9876123451', 1, 'Cleaner', 300.00, 0),
('SF880003', 'Nitin Mehra', '9876123452', 1, 'Gardener', 400.00, 0),
('SF880004', 'Swati Kapoor', '9876123453', 1, 'Gardener', 400.00, 0),
('SF880005', 'Rajiv Singh', '9876123454', 2, 'Cleaner', 300.00, 0),
('SF880006', 'Sonal Verma', '9876123455', 2, 'Cleaner', 300.00, 0),
('SF880007', 'Anupam Roy', '9876123456', 2, 'Gardener', 400.00, 0),
('SF880008', 'Tanvi Joshi', '9876123457', 2, 'Gardener', 400.00, 0),
('SF880009', 'Kunal Desai', '9876123458', 3, 'Cleaner', 300.00, 0),
('SF880010', 'Priti Nair', '9876123459', 3, 'Cleaner', 300.00, 0),
('SF880011', 'Arvind Tiwari', '9876123460', 3, 'Gardener', 400.00, 0),
('SF880012', 'Meera Rani', '9876123461', 3, 'Gardener', 400.00, 0),
('SF880013', 'Vikram Ahuja', '9876123462', 4, 'Cleaner', 300.00, 0),
('SF880014', 'Kiran Malik', '9876123463', 4, 'Cleaner', 300.00, 0),
('SF880015', 'Sandeep Bansal', '9876123464', 4, 'Gardener', 400.00, 0),
('SF880016', 'Aisha Khan', '9876123465', 4, 'Gardener', 400.00, 0);

-- --------------------------------------------------------

--
-- Table structure for table `StaffManager`
--

CREATE TABLE `StaffManager` (
  `staff_manager_id` varchar(11) NOT NULL,
  `staff_manager_name` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `photo` varchar(255) DEFAULT 'staff_manager.jpg',
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `StaffManager`
--

INSERT INTO `StaffManager` (`staff_manager_id`, `staff_manager_name`, `phone`, `photo`, `email`, `password`) VALUES
('SM999991', 'Rahul Dravid', '9876555995', 'staff_manager.jpg', 'dravid1234@gmail.com', 'dravid9999');

-- --------------------------------------------------------

--
-- Table structure for table `StudentHallDetails`
--

CREATE TABLE `StudentHallDetails` (
  `student_id` varchar(10) NOT NULL,
  `hall_id` int(11) NOT NULL,
  `room_number` int(11) NOT NULL,
  `mess_type` enum('Vegetarian','Non Vegetarian') NOT NULL,
  `room_bill` decimal(10,2) NOT NULL DEFAULT 0.00,
  `mess_bill` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `StudentHallDetails`
--

INSERT INTO `StudentHallDetails` (`student_id`, `hall_id`, `room_number`, `mess_type`, `room_bill`, `mess_bill`) VALUES
('ST220001', 1, 1, 'Vegetarian', 0.00, 0.00),
('ST220002', 4, 1, 'Non Vegetarian', 0.00, 0.00),
('ST220003', 2, 1, 'Vegetarian', 0.00, 0.00),
('ST220004', 3, 1, 'Non Vegetarian', 0.00, 0.00),
('ST220005', 1, 21, 'Non Vegetarian', 0.00, 0.00),
('ST220008', 1, 1, 'Vegetarian', 0.00, 0.00),
('ST220009', 3, 21, 'Vegetarian', 0.00, 0.00),
('ST220010', 1, 2, 'Non Vegetarian', 0.00, 0.00),
('ST220011', 3, 22, 'Non Vegetarian', 0.00, 0.00),
('ST220012', 1, 22, 'Vegetarian', 0.00, 0.00),
('ST220013', 4, 26, 'Non Vegetarian', 0.00, 0.00),
('ST220014', 1, 2, 'Vegetarian', 0.00, 0.00),
('ST220016', 1, 3, 'Vegetarian', 0.00, 0.00),
('ST220018', 2, 1, 'Non Vegetarian', 0.00, 0.00),
('ST220021', 4, 27, 'Non Vegetarian', 0.00, 0.00),
('ST220022', 1, 23, 'Vegetarian', 0.00, 0.00),
('ST220026', 2, 2, 'Vegetarian', 0.00, 0.00),
('ST220028', 1, 3, 'Non Vegetarian', 0.00, 0.00),
('ST220029', 3, 1, 'Vegetarian', 0.00, 0.00),
('ST220034', 1, 4, 'Non Vegetarian', 0.00, 0.00),
('ST220035', 3, 23, 'Non Vegetarian', 0.00, 0.00),
('ST220037', 4, 1, 'Non Vegetarian', 0.00, 0.00),
('ST220038', 2, 26, 'Vegetarian', 0.00, 0.00),
('ST220039', 3, 24, 'Vegetarian', 0.00, 0.00),
('ST220042', 1, 24, 'Non Vegetarian', 0.00, 0.00),
('ST220049', 3, 2, 'Vegetarian', 0.00, 0.00),
('ST220053', 4, 28, 'Vegetarian', 0.00, 0.00),
('ST220054', 1, 4, 'Non Vegetarian', 0.00, 0.00),
('ST220056', 2, 27, 'Vegetarian', 0.00, 0.00),
('ST220058', 2, 2, 'Non Vegetarian', 0.00, 0.00),
('ST220073', 3, 2, 'Non Vegetarian', 0.00, 0.00),
('ST220092', 2, 28, 'Vegetarian', 0.00, 0.00),
('ST220099', 4, 29, 'Non Vegetarian', 0.00, 0.00),
('ST230008', 4, 30, 'Vegetarian', 0.00, 0.00),
('ST230009', 2, 3, 'Non Vegetarian', 0.00, 0.00),
('ST230011', 1, 25, 'Non Vegetarian', 0.00, 0.00),
('ST230012', 4, 2, 'Non Vegetarian', 0.00, 0.00),
('ST230013', 2, 29, 'Vegetarian', 0.00, 0.00),
('ST230014', 4, 2, 'Non Vegetarian', 0.00, 0.00),
('ST230015', 2, 3, 'Non Vegetarian', 0.00, 0.00),
('ST230016', 4, 31, 'Vegetarian', 0.00, 0.00),
('ST230019', 2, 4, 'Non Vegetarian', 0.00, 0.00),
('ST230021', 2, 4, 'Non Vegetarian', 0.00, 0.00),
('ST230022', 3, 3, 'Non Vegetarian', 0.00, 0.00),
('ST230023', 1, 26, 'Vegetarian', 0.00, 0.00),
('ST230027', 2, 30, 'Vegetarian', 0.00, 0.00),
('ST230028', 4, 3, 'Non Vegetarian', 0.00, 0.00),
('ST230040', 4, 32, 'Non Vegetarian', 0.00, 0.00),
('ST230046', 3, 26, 'Vegetarian', 0.00, 0.00),
('ST230047', 1, 5, 'Non Vegetarian', 0.00, 0.00),
('ST230049', 2, 31, 'Non Vegetarian', 0.00, 0.00),
('ST230052', 3, 25, 'Non Vegetarian', 0.00, 0.00),
('ST230054', 4, 3, 'Non Vegetarian', 0.00, 0.00),
('ST230057', 2, 32, 'Vegetarian', 0.00, 0.00),
('ST230067', 1, 27, 'Non Vegetarian', 0.00, 0.00),
('ST230070', 4, 4, 'Non Vegetarian', 0.00, 0.00),
('ST230074', 3, 3, 'Non Vegetarian', 0.00, 0.00),
('ST230083', 2, 33, 'Vegetarian', 0.00, 0.00),
('ST230099', 1, 5, 'Non Vegetarian', 0.00, 0.00),
('ST230100', 4, 4, 'Vegetarian', 0.00, 0.00),
('ST240001', 3, 4, 'Vegetarian', 0.00, 0.00),
('ST240006', 4, 5, 'Non Vegetarian', 0.00, 0.00),
('ST240015', 4, 33, 'Vegetarian', 0.00, 0.00),
('ST240016', 1, 6, 'Non Vegetarian', 0.00, 0.00),
('ST240018', 3, 27, 'Vegetarian', 0.00, 0.00),
('ST240019', 3, 4, 'Non Vegetarian', 0.00, 0.00),
('ST240020', 2, 5, 'Non Vegetarian', 0.00, 0.00),
('ST240025', 4, 34, 'Vegetarian', 0.00, 0.00),
('ST240027', 4, 5, 'Non Vegetarian', 0.00, 0.00),
('ST240029', 1, 6, 'Non Vegetarian', 0.00, 0.00),
('ST240030', 1, 28, 'Vegetarian', 0.00, 0.00),
('ST240035', 3, 28, 'Vegetarian', 0.00, 0.00),
('ST240043', 2, 5, 'Vegetarian', 0.00, 0.00),
('ST240046', 2, 34, 'Vegetarian', 0.00, 0.00),
('ST240052', 3, 5, 'Non Vegetarian', 0.00, 0.00),
('ST240054', 3, 5, 'Non Vegetarian', 0.00, 0.00),
('ST240057', 3, 29, 'Non Vegetarian', 0.00, 0.00),
('ST240060', 4, 6, 'Vegetarian', 0.00, 0.00),
('ST240062', 4, 6, 'Non Vegetarian', 0.00, 0.00),
('ST240063', 2, 6, 'Non Vegetarian', 0.00, 0.00),
('ST240075', 3, 6, 'Non Vegetarian', 0.00, 0.00),
('ST240081', 4, 35, 'Non Vegetarian', 0.00, 0.00),
('ST240083', 2, 6, 'Vegetarian', 0.00, 0.00),
('ST240090', 2, 35, 'Vegetarian', 0.00, 0.00),
('ST240091', 3, 30, 'Non Vegetarian', 0.00, 0.00),
('ST240092', 3, 6, 'Vegetarian', 0.00, 0.00),
('ST240096', 1, 29, 'Non Vegetarian', 0.00, 0.00),
('ST240099', 1, 30, 'Vegetarian', 0.00, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `StudentPersonalDetails`
--

CREATE TABLE `StudentPersonalDetails` (
  `student_id` varchar(10) NOT NULL,
  `student_name` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL CHECK (`phone` regexp '^[0-9]+$'),
  `photo` varchar(255) DEFAULT 'student.jpg',
  `college_email` varchar(100) DEFAULT NULL,
  `personal_email` varchar(100) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL CHECK (`gender` in ('Male','Female')),
  `year` int(11) DEFAULT NULL,
  `branch` varchar(100) DEFAULT NULL CHECK (`year` in (1,2,3)),
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `StudentPersonalDetails`
--

INSERT INTO `StudentPersonalDetails` (`student_id`, `student_name`, `address`, `phone`, `photo`, `college_email`, `personal_email`, `dob`, `gender`, `year`, `branch`, `password`) VALUES
('ST220001', 'Rohit Sharma', 'Mumbai, Maharashtra', '7890123456', 'ST220001.jpg', 'st220001@iit.ac.in', 'rohitsharma8356@gmail.com', '2003-05-12', 'Male', 3, 'Computer Science and Engineering', '11861504'),
('ST220002', 'Priya Singh', 'Delhi, Delhi', '8891234567', 'ST220002.jpg', 'st220002@iit.ac.in', 'priyasingh9254@gmail.com', '2003-09-23', 'Female', 3, 'Mechanical Engineering', '50267650'),
('ST220003', 'Aarav Khan', 'Lucknow, Uttar Pradesh', '8792345678', 'ST220003.jpg', 'st220003@iit.ac.in', 'aaravkhan4731@gmail.com', '2004-01-14', 'Male', 3, 'Civil Engineering', '48863234'),
('ST220004', 'Neha D’Souza', 'Kochi, Kerala', '7893456789', 'ST220004.jpg', 'st220004@iit.ac.in', 'nehadsouza3417@gmail.com', '2003-06-20', 'Female', 3, 'Chemical Engineering', '19901443'),
('ST220005', 'Vikas Yadav', 'Pune, Maharashtra', '7894567890', 'ST220005.jpg', 'st220005@iit.ac.in', 'vikasyadav7526@gmail.com', '2003-08-18', 'Male', 3, 'Computer Science and Engineering', '81194501'),
('ST220006', 'Aisha Ali', 'Hyderabad, Telangana', '7598765432', 'ST220006.jpg', 'st220006@iit.ac.in', 'aishaali6123@gmail.com', '2003-03-10', 'Female', 3, 'Mechanical Engineering', '77816325'),
('ST220007', 'Lakshmi Iyer', 'Bengaluru, Karnataka', '8590123456', 'ST220007.jpg', 'st220007@iit.ac.in', 'lakshmiiyer7248@gmail.com', '2003-12-29', 'Female', 3, 'Mechanical Engineering', '66120711'),
('ST220008', 'Rahul Verma', 'Jaipur, Rajasthan', '8790234567', 'ST220008.jpg', 'st220008@iit.ac.in', 'rahulverma1572@gmail.com', '2004-04-25', 'Male', 3, 'Civil Engineering', '85063176'),
('ST220009', 'Sara Kaur', 'Amritsar, Punjab', '7890345671', 'ST220009.jpg', 'st220009@iit.ac.in', 'sarakaur9832@gmail.com', '2003-10-08', 'Female', 3, 'Chemical Engineering', '37987334'),
('ST220010', 'Ramesh Patel', 'Ahmedabad, Gujarat', '9790456782', 'ST220010.jpg', 'st220010@iit.ac.in', 'rameshpatel1743@gmail.com', '2004-11-22', 'Male', 3, 'Computer Science and Engineering', '19030534'),
('ST220011', 'Aditi Gupta', 'Varanasi, Uttar Pradesh', '8890345673', 'ST220011.jpg', 'st220011@iit.ac.in', 'aditigupta4519@gmail.com', '2003-01-11', 'Female', 3, 'Computer Science and Engineering', '77706253'),
('ST220012', 'Rohan Mehta', 'Bhopal, Madhya Pradesh', '7894567321', 'ST220012.jpg', 'st220012@iit.ac.in', 'rohanmehta3420@gmail.com', '2004-06-30', 'Male', 3, 'Mechanical Engineering', '42151950'),
('ST220013', 'Sneha Nair', 'Kochi, Kerala', '8790567432', 'ST220013.jpg', 'st220013@iit.ac.in', 'snehanair5243@gmail.com', '2003-10-16', 'Female', 3, 'Civil Engineering', '46296591'),
('ST220014', 'Ajay Malik', 'Patna, Bihar', '7890767543', 'ST220014.jpg', 'st220014@iit.ac.in', 'ajaymalik9132@gmail.com', '2003-08-09', 'Male', 3, 'Chemical Engineering', '57700880'),
('ST220015', 'Simran Kaur', 'Ludhiana, Punjab', '8890878654', 'ST220015.jpg', 'st220015@iit.ac.in', 'simrankaur3872@gmail.com', '2004-02-18', 'Female', 3, 'Computer Science and Engineering', '76747284'),
('ST220016', 'Ravi Thakur', 'Patna, Bihar', '8794567542', 'ST220016.jpg', 'st220016@iit.ac.in', 'ravithakur7481@gmail.com', '2003-07-19', 'Male', 3, 'Mechanical Engineering', '78786580'),
('ST220017', 'Anjali Rao', 'Kolkata, West Bengal', '7890123454', 'ST220017.jpg', 'st220017@iit.ac.in', 'anjalirao2368@gmail.com', '2003-05-14', 'Female', 3, 'Civil Engineering', '28987414'),
('ST220018', 'Arjun Iyer', 'Chennai, Tamil Nadu', '8790234561', 'ST220018.jpg', 'st220018@iit.ac.in', 'arjuniyer5712@gmail.com', '2003-03-08', 'Male', 3, 'Computer Science and Engineering', '44879895'),
('ST220019', 'Pooja Mehta', 'Surat, Gujarat', '7890345678', 'ST220019.jpg', 'st220019@iit.ac.in', 'poojamehta6429@gmail.com', '2003-10-02', 'Female', 3, 'Mechanical Engineering', '61821976'),
('ST220020', 'Rajesh Kapoor', 'Mumbai, Maharashtra', '7790456783', 'ST220020.jpg', 'st220020@iit.ac.in', 'rajeshkapoor8794@gmail.com', '2003-06-11', 'Male', 3, 'Civil Engineering', '77339673'),
('ST220021', 'Ananya Das', 'Noida, Uttar Pradesh', '7990123456', 'ST220021.jpg', 'st220021@iit.ac.in', 'ananyadas0123@gmail.com', '2003-12-14', 'Female', 3, 'Computer Science and Engineering', '89536025'),
('ST220022', 'Mohammed Ameen', 'Kochi, Kerala', '8781234567', 'ST220022.jpg', 'st220022@iit.ac.in', 'mohammedameen456@gmail.com', '2004-01-05', 'Male', 3, 'Mechanical Engineering', '16642584'),
('ST220023', 'Kavita Reddy', 'Hyderabad, Telangana', '9662345678', 'ST220023.jpg', 'st220023@iit.ac.in', 'kavitareddy7714@gmail.com', '2003-02-19', 'Female', 3, 'Civil Engineering', '93319196'),
('ST220024', 'Ajit Kumar', 'Delhi, Delhi', '7783456789', 'ST220024.jpg', 'st220024@iit.ac.in', 'ajitkumar4563@gmail.com', '2003-07-27', 'Male', 3, 'Chemical Engineering', '25576982'),
('ST220025', 'Nisha Sharma', 'Bhopal, Madhya Pradesh', '8784567890', 'ST220025.jpg', 'st220025@iit.ac.in', 'nishasharma8714@gmail.com', '2004-03-15', 'Female', 3, 'Computer Science and Engineering', '70436383'),
('ST220026', 'Manoj Tiwari', 'Varanasi, Uttar Pradesh', '9585678901', 'ST220026.jpg', 'st220026@iit.ac.in', 'manojtiwari7891@gmail.com', '2003-11-04', 'Male', 3, 'Mechanical Engineering', '24562210'),
('ST220027', 'Geeta Rani', 'Bengaluru, Karnataka', '7896789012', 'ST220027.jpg', 'st220027@iit.ac.in', 'geetarani7324@gmail.com', '2004-02-22', 'Female', 3, 'Civil Engineering', '42700323'),
('ST220028', 'Sunil Joshi', 'Chennai, Tamil Nadu', '8797890123', 'ST220028.jpg', 'st220028@iit.ac.in', 'suniljoshi5983@gmail.com', '2003-10-09', 'Male', 3, 'Chemical Engineering', '61741091'),
('ST220029', 'Suman Kumari', 'Ahmedabad, Gujarat', '9698901234', 'ST220029.jpg', 'st220029@iit.ac.in', 'sumankumari8452@gmail.com', '2004-09-15', 'Female', 3, 'Computer Science and Engineering', '61759522'),
('ST220030', 'Karan Singh', 'Jaipur, Rajasthan', '8789012345', 'ST220030.jpg', 'st220030@iit.ac.in', 'karansingh6712@gmail.com', '2003-05-30', 'Male', 3, 'Mechanical Engineering', '43577895'),
('ST220031', 'Sophie Lopez', 'Mumbai, Maharashtra', '7860123456', 'ST220031.jpg', 'st220031@iit.ac.in', 'sophielopez9736@gmail.com', '2004-12-01', 'Female', 3, 'Civil Engineering', '24672296'),
('ST220032', 'Vikram Reddy', 'Kochi, Kerala', '7971234567', 'ST220032.jpg', 'st220032@iit.ac.in', 'vikramreddy8292@gmail.com', '2003-11-27', 'Male', 3, 'Chemical Engineering', '49745961'),
('ST220033', 'Shreya Patil', 'Pune, Maharashtra', '8692345678', 'ST220033.jpg', 'st220033@iit.ac.in', 'shreyapatil0567@gmail.com', '2004-08-15', 'Female', 3, 'Computer Science and Engineering', '39099434'),
('ST220034', 'Siddharth Gupta', 'Delhi, Delhi', '8883456789', 'ST220034.jpg', 'st220034@iit.ac.in', 'siddharthgupta9711@gmail.com', '2003-03-12', 'Male', 3, 'Mechanical Engineering', '60281390'),
('ST220035', 'Aditi Choudhary', 'Bhopal, Madhya Pradesh', '7984567890', 'ST220035.jpg', 'st220035@iit.ac.in', 'aditichoudhary6405@gmail.com', '2004-05-29', 'Female', 3, 'Civil Engineering', '63181870'),
('ST220036', 'Ajay Singh', 'Noida, Uttar Pradesh', '7895678901', 'ST220036.jpg', 'st220036@iit.ac.in', 'ajaysingh9475@gmail.com', '2003-06-14', 'Male', 3, 'Chemical Engineering', '72960560'),
('ST220037', 'Nisha Iyer', 'Hyderabad, Telangana', '7866789012', 'ST220037.jpg', 'st220037@iit.ac.in', 'nishaiyer8723@gmail.com', '2003-10-27', 'Female', 3, 'Computer Science and Engineering', '16011826'),
('ST220038', 'Rahul Jain', 'Ahmedabad, Gujarat', '8787890123', 'ST220038.jpg', 'st220038@iit.ac.in', 'rahuljain1193@gmail.com', '2004-11-10', 'Male', 3, 'Mechanical Engineering', '61465650'),
('ST220039', 'Preeti Sharma', 'Chennai, Tamil Nadu', '7898901234', 'ST220039.jpg', 'st220039@iit.ac.in', 'preetisharma0328@gmail.com', '2003-12-25', 'Female', 3, 'Civil Engineering', '23339579'),
('ST220040', 'Deepak Mehta', 'Lucknow, Uttar Pradesh', '7899012345', 'ST220040.jpg', 'st220040@iit.ac.in', 'deepakmehta1921@gmail.com', '2003-01-21', 'Male', 3, 'Chemical Engineering', '46864446'),
('ST220041', 'Priya Singh', 'Kolkata, West Bengal', '8900123456', 'ST220041.jpg', 'st220041@iit.ac.in', 'priyasingh6273@gmail.com', '2004-02-14', 'Female', 3, 'Computer Science and Engineering', '96001086'),
('ST220042', 'Mohammed Rizwan', 'Delhi, Delhi', '8901234567', 'ST220042.jpg', 'st220042@iit.ac.in', 'mohammedrizwan4937@gmail.com', '2003-03-17', 'Male', 3, 'Mechanical Engineering', '32097343'),
('ST220043', 'Sana Khan', 'Jaipur, Rajasthan', '8012345678', 'ST220043.jpg', 'st220043@iit.ac.in', 'sanakhan7462@gmail.com', '2003-07-25', 'Female', 3, 'Civil Engineering', '71941187'),
('ST220044', 'Ritesh Yadav', 'Pune, Maharashtra', '8112345679', 'ST220044.jpg', 'st220044@iit.ac.in', 'riteshyadav2680@gmail.com', '2004-08-30', 'Male', 3, 'Chemical Engineering', '17617988'),
('ST220045', 'Kiran Sharma', 'Bhopal, Madhya Pradesh', '8212345670', 'ST220045.jpg', 'st220045@iit.ac.in', 'kiransharma0824@gmail.com', '2003-05-04', 'Female', 3, 'Computer Science and Engineering', '90838598'),
('ST220046', 'Sandeep Singh', 'Kochi, Kerala', '8312345671', 'ST220046.jpg', 'st220046@iit.ac.in', 'sandeepsingh9630@gmail.com', '2004-03-23', 'Male', 3, 'Mechanical Engineering', '27741179'),
('ST220047', 'Komal Sharma', 'Hyderabad, Telangana', '8412345672', 'ST220047.jpg', 'st220047@iit.ac.in', 'komalsharma5820@gmail.com', '2003-09-12', 'Female', 3, 'Civil Engineering', '46943815'),
('ST220048', 'Tarun Rathi', 'Mumbai, Maharashtra', '8512345673', 'ST220048.jpg', 'st220048@iit.ac.in', 'tarunrathi6149@gmail.com', '2004-06-07', 'Male', 3, 'Chemical Engineering', '47018571'),
('ST220049', 'Ritika D’souza', 'Bengaluru, Karnataka', '8612345674', 'ST220049.jpg', 'st220049@iit.ac.in', 'ritikadsouza0931@gmail.com', '2003-08-11', 'Female', 3, 'Computer Science and Engineering', '19397708'),
('ST220050', 'Ashish Kumar', 'Delhi, Delhi', '8712345675', 'ST220050.jpg', 'st220050@iit.ac.in', 'ashishkumar5731@gmail.com', '2004-11-29', 'Male', 3, 'Mechanical Engineering', '23599691'),
('ST220051', 'Deepika Rani', 'Jaipur, Rajasthan', '8812345676', 'ST220051.jpg', 'st220051@iit.ac.in', 'deepikarani9471@gmail.com', '2003-10-02', 'Female', 3, 'Civil Engineering', '72859727'),
('ST220052', 'Vivek Patel', 'Kochi, Kerala', '8912345677', 'ST220052.jpg', 'st220052@iit.ac.in', 'vivekpatel8172@gmail.com', '2003-06-19', 'Male', 3, 'Chemical Engineering', '21450832'),
('ST220053', 'Poonam Kaur', 'Ahmedabad, Gujarat', '9012345678', 'ST220053.jpg', 'st220053@iit.ac.in', 'poonamkaur2567@gmail.com', '2004-01-05', 'Female', 3, 'Computer Science and Engineering', '68324943'),
('ST220054', 'Nikhil Yadav', 'Bhopal, Madhya Pradesh', '9112345679', 'ST220054.jpg', 'st220054@iit.ac.in', 'nikhilyadav1743@gmail.com', '2004-04-17', 'Male', 3, 'Mechanical Engineering', '77529683'),
('ST220055', 'Radha Gupta', 'Lucknow, Uttar Pradesh', '9212345670', 'ST220055.jpg', 'st220055@iit.ac.in', 'radhagupta9654@gmail.com', '2003-05-24', 'Female', 3, 'Civil Engineering', '23829076'),
('ST220056', 'Raj Kumar', 'Delhi, Delhi', '9312345671', 'ST220056.jpg', 'st220056@iit.ac.in', 'rajkumar3456@gmail.com', '2004-02-14', 'Male', 3, 'Chemical Engineering', '48012886'),
('ST220057', 'Vani Reddy', 'Pune, Maharashtra', '9412345672', 'ST220057.jpg', 'st220057@iit.ac.in', 'vanireddy8542@gmail.com', '2003-10-29', 'Female', 3, 'Computer Science and Engineering', '44363355'),
('ST220058', 'Amit Kumar', 'Jaipur, Rajasthan', '9512345673', 'ST220058.jpg', 'st220058@iit.ac.in', 'amitkumar9287@gmail.com', '2003-11-21', 'Male', 3, 'Mechanical Engineering', '97077340'),
('ST220059', 'Nisha Ali', 'Chennai, Tamil Nadu', '9612345674', 'ST220059.jpg', 'st220059@iit.ac.in', 'nishaali1502@gmail.com', '2004-07-09', 'Female', 3, 'Civil Engineering', '53932124'),
('ST220060', 'Ankit Rathi', 'Kochi, Kerala', '9712345675', 'ST220060.jpg', 'st220060@iit.ac.in', 'ankitrathi5920@gmail.com', '2004-09-11', 'Male', 3, 'Chemical Engineering', '76302942'),
('ST220061', 'Riya Das', 'Delhi, Delhi', '9812345676', 'ST220061.jpg', 'st220061@iit.ac.in', 'riyadas9403@gmail.com', '2003-05-30', 'Female', 3, 'Computer Science and Engineering', '20916834'),
('ST220062', 'Karan Yadav', 'Noida, Uttar Pradesh', '9912345677', 'ST220062.jpg', 'st220062@iit.ac.in', 'karanyadav0825@gmail.com', '2003-10-18', 'Male', 3, 'Mechanical Engineering', '27376740'),
('ST220063', 'Aisha Kumar', 'Bhopal, Madhya Pradesh', '7012345678', 'ST220063.jpg', 'st220063@iit.ac.in', 'aishakumar4718@gmail.com', '2004-11-15', 'Female', 3, 'Civil Engineering', '94717030'),
('ST220064', 'Sunil Reddy', 'Kolkata, West Bengal', '7112345679', 'ST220064.jpg', 'st220064@iit.ac.in', 'sunilreddy3540@gmail.com', '2003-03-21', 'Male', 3, 'Chemical Engineering', '30531687'),
('ST220065', 'Sonia Jain', 'Delhi, Delhi', '7212345680', 'ST220065.jpg', 'st220065@iit.ac.in', 'soniajain7965@gmail.com', '2004-02-07', 'Female', 3, 'Computer Science and Engineering', '78217320'),
('ST220066', 'Amit Sharma', 'Mumbai, Maharashtra', '7312345681', 'ST220066.jpg', 'st220066@iit.ac.in', 'amitsharma2741@gmail.com', '2003-06-26', 'Male', 3, 'Mechanical Engineering', '14214764'),
('ST220067', 'Sita Singh', 'Ahmedabad, Gujarat', '7412345682', 'ST220067.jpg', 'st220067@iit.ac.in', 'sitasingh1390@gmail.com', '2004-09-28', 'Female', 3, 'Civil Engineering', '87949421'),
('ST220068', 'Vikas Verma', 'Pune, Maharashtra', '7512345683', 'ST220068.jpg', 'st220068@iit.ac.in', 'vikasverma6721@gmail.com', '2003-11-08', 'Male', 3, 'Chemical Engineering', '88561772'),
('ST220069', 'Neha Rani', 'Jaipur, Rajasthan', '7612345684', 'ST220069.jpg', 'st220069@iit.ac.in', 'neharani8179@gmail.com', '2004-03-13', 'Female', 3, 'Computer Science and Engineering', '36312176'),
('ST220070', 'Rohit Bhardwaj', 'Kolkata, West Bengal', '7712345685', 'ST220070.jpg', 'st220070@iit.ac.in', 'rohitbhardwaj2645@gmail.com', '2004-04-24', 'Male', 3, 'Mechanical Engineering', '67942002'),
('ST220071', 'Pooja Singh', 'Bengaluru, Karnataka', '7812345686', 'ST220071.jpg', 'st220071@iit.ac.in', 'poojasingh5869@gmail.com', '2003-07-17', 'Female', 3, 'Civil Engineering', '17570420'),
('ST220072', 'Rajesh Kumar', 'Delhi, Delhi', '7912345687', 'ST220072.jpg', 'st220072@iit.ac.in', 'rajeshkumar8594@gmail.com', '2004-10-20', 'Male', 3, 'Chemical Engineering', '16370293'),
('ST220073', 'Suman Patil', 'Mumbai, Maharashtra', '8012345688', 'ST220073.jpg', 'st220073@iit.ac.in', 'sumanpatil0385@gmail.com', '2003-12-05', 'Female', 3, 'Computer Science and Engineering', '24029814'),
('ST220074', 'Ajay Kapoor', 'Lucknow, Uttar Pradesh', '8112345689', 'ST220074.jpg', 'st220074@iit.ac.in', 'ajaykapoor8926@gmail.com', '2003-09-22', 'Male', 3, 'Mechanical Engineering', '14692980'),
('ST220075', 'Naina Iyer', 'Pune, Maharashtra', '8212345690', 'ST220075.jpg', 'st220075@iit.ac.in', 'nainaiyer1298@gmail.com', '2004-05-10', 'Female', 3, 'Civil Engineering', '93703288'),
('ST220076', 'Vikram Jain', 'Bhopal, Madhya Pradesh', '8312345691', 'ST220076.jpg', 'st220076@iit.ac.in', 'vikramjain3479@gmail.com', '2004-06-13', 'Male', 3, 'Chemical Engineering', '57221241'),
('ST220077', 'Shivani Mehta', 'Delhi, Delhi', '8412345692', 'ST220077.jpg', 'st220077@iit.ac.in', 'shivanimehta8735@gmail.com', '2003-01-14', 'Female', 3, 'Computer Science and Engineering', '71920762'),
('ST220078', 'Karan Yadav', 'Kochi, Kerala', '8512345693', 'ST220078.jpg', 'st220078@iit.ac.in', 'karanyadav5894@gmail.com', '2004-11-02', 'Male', 3, 'Mechanical Engineering', '11445881'),
('ST220079', 'Sona Sharma', 'Mumbai, Maharashtra', '8612345694', 'ST220079.jpg', 'st220079@iit.ac.in', 'sonasharma1407@gmail.com', '2003-03-18', 'Female', 3, 'Civil Engineering', '65196668'),
('ST220080', 'Anil Verma', 'Jaipur, Rajasthan', '8712345695', 'ST220080.jpg', 'st220080@iit.ac.in', 'anilverma7638@gmail.com', '2003-12-09', 'Male', 3, 'Chemical Engineering', '25133181'),
('ST220081', 'Geeta Kaur', 'Kolkata, West Bengal', '8812345696', 'ST220081.jpg', 'st220081@iit.ac.in', 'geetakaur7940@gmail.com', '2004-10-30', 'Female', 3, 'Computer Science and Engineering', '94459010'),
('ST220082', 'Mohammed Rizwan', 'Lucknow, Uttar Pradesh', '8912345697', 'ST220082.jpg', 'st220082@iit.ac.in', 'mohammedrizwan0923@gmail.com', '2003-08-22', 'Male', 3, 'Mechanical Engineering', '40557187'),
('ST220083', 'Neelam Rani', 'Delhi, Delhi', '9012345698', 'ST220083.jpg', 'st220083@iit.ac.in', 'neelamrani8341@gmail.com', '2003-11-15', 'Female', 3, 'Civil Engineering', '11499650'),
('ST220084', 'Sanjay Sharma', 'Bhopal, Madhya Pradesh', '9112345699', 'ST220084.jpg', 'st220084@iit.ac.in', 'sanjaysharma5286@gmail.com', '2004-01-08', 'Male', 3, 'Chemical Engineering', '12873349'),
('ST220085', 'Rani Gupta', 'Mumbai, Maharashtra', '9212345600', 'ST220085.jpg', 'st220085@iit.ac.in', 'ranigupta4785@gmail.com', '2004-06-26', 'Female', 3, 'Computer Science and Engineering', '36941446'),
('ST220086', 'Ajay Bhatia', 'Ahmedabad, Gujarat', '9312345601', 'ST220086.jpg', 'st220086@iit.ac.in', 'ajaybhatia1853@gmail.com', '2003-04-11', 'Male', 3, 'Mechanical Engineering', '65044104'),
('ST220087', 'Simran Mehta', 'Delhi, Delhi', '9412345602', 'ST220087.jpg', 'st220087@iit.ac.in', 'simranmehta9126@gmail.com', '2004-03-29', 'Female', 3, 'Civil Engineering', '14170763'),
('ST220088', 'Karan Choudhary', 'Pune, Maharashtra', '9512345603', 'ST220088.jpg', 'st220088@iit.ac.in', 'karanchoudhary6740@gmail.com', '2003-12-19', 'Male', 3, 'Chemical Engineering', '66555022'),
('ST220089', 'Aarti Rani', 'Lucknow, Uttar Pradesh', '9612345604', 'ST220089.jpg', 'st220089@iit.ac.in', 'aartirani3712@gmail.com', '2004-09-30', 'Female', 3, 'Computer Science and Engineering', '30081680'),
('ST220090', 'Ajit Sharma', 'Jaipur, Rajasthan', '9712345605', 'ST220090.jpg', 'st220090@iit.ac.in', 'ajitsharma3705@gmail.com', '2003-07-18', 'Male', 3, 'Mechanical Engineering', '74704529'),
('ST220091', 'Meera Singh', 'Delhi, Delhi', '9812345606', 'ST220091.jpg', 'st220091@iit.ac.in', 'meerasingh8742@gmail.com', '2004-10-06', 'Female', 3, 'Civil Engineering', '85043345'),
('ST220092', 'Ravi Kumar', 'Kolkata, West Bengal', '9912345607', 'ST220092.jpg', 'st220092@iit.ac.in', 'ravikumar9752@gmail.com', '2004-02-09', 'Male', 3, 'Chemical Engineering', '53327509'),
('ST220093', 'Sneha Rani', 'Mumbai, Maharashtra', '7012345608', 'ST220093.jpg', 'st220093@iit.ac.in', 'sneharani9167@gmail.com', '2003-01-12', 'Female', 3, 'Computer Science and Engineering', '28671638'),
('ST220094', 'Nikhil Sharma', 'Ahmedabad, Gujarat', '7112345609', 'ST220094.jpg', 'st220094@iit.ac.in', 'nikhilsharma8432@gmail.com', '2004-11-22', 'Male', 3, 'Mechanical Engineering', '92113045'),
('ST220095', 'Alia Gupta', 'Bhopal, Madhya Pradesh', '7212345610', 'ST220095.jpg', 'st220095@iit.ac.in', 'aliagupta1653@gmail.com', '2003-06-30', 'Female', 3, 'Civil Engineering', '19461272'),
('ST220096', 'Vikram Singh', 'Delhi, Delhi', '7312345611', 'ST220096.jpg', 'st220096@iit.ac.in', 'vikramsingh9518@gmail.com', '2004-03-15', 'Male', 3, 'Chemical Engineering', '34395295'),
('ST220097', 'Ankita Verma', 'Pune, Maharashtra', '7412345612', 'ST220097.jpg', 'st220097@iit.ac.in', 'ankitaverma6350@gmail.com', '2003-12-15', 'Female', 3, 'Computer Science and Engineering', '86137503'),
('ST220098', 'Manish Gupta', 'Lucknow, Uttar Pradesh', '7512345613', 'ST220098.jpg', 'st220098@iit.ac.in', 'manishgupta1249@gmail.com', '2003-09-16', 'Male', 3, 'Mechanical Engineering', '58528929'),
('ST220099', 'Riya Kapoor', 'Jaipur, Rajasthan', '7612345614', 'ST220099.jpg', 'st220099@iit.ac.in', 'riyakapoor8601@gmail.com', '2004-08-08', 'Female', 3, 'Civil Engineering', '68367020'),
('ST220100', 'Vivek Rani', 'Delhi, Delhi', '7712345615', 'ST220100.jpg', 'st220100@iit.ac.in', 'vivekrani4280@gmail.com', '2004-05-15', 'Male', 3, 'Chemical Engineering', '61177517'),
('ST230001', 'Anand Bachchan', 'Kochi, Ernakulam, Kerala', '9123456780', 'ST230001.jpg', 'st230001@iit.ac.in', 'anandbachchan37410@gmail.com', '2004-04-12', 'Male', 2, 'Computer Science and Engineering', '67342347'),
('ST230002', 'Lakshmi Mathews', 'Mumbai, Mumbai Suburban, Maharashtra', '8123456781', 'ST230002.jpg', 'st230002@iit.ac.in', 'lakshmimathews49732@gmail.com', '2005-01-20', 'Female', 2, 'Computer Science and Engineering', '51338432'),
('ST230003', 'Aditya Arora', 'Delhi, Central Delhi, Delhi', '9123456782', 'ST230003.jpg', 'st230003@iit.ac.in', 'adityaarora19204@gmail.com', '2004-03-05', 'Male', 2, 'Computer Science and Engineering', '72953948'),
('ST230004', 'Aadhya Dhawan', 'Pune, Pune, Maharashtra', '9323456783', 'ST230004.jpg', 'st230004@iit.ac.in', 'aadhyadhawan82714@gmail.com', '2005-07-25', 'Female', 2, 'Computer Science and Engineering', '18274665'),
('ST230005', 'Aayush Dubey', 'Lucknow, Lucknow, Uttar Pradesh', '8923456784', 'ST230005.jpg', 'st230005@iit.ac.in', 'aayushdubey39245@gmail.com', '2004-11-15', 'Male', 2, 'Computer Science and Engineering', '65983799'),
('ST230006', 'Ananya Ghosh', 'Bhopal, Bhopal, Madhya Pradesh', '9223456785', 'ST230006.jpg', 'st230006@iit.ac.in', 'ananyaghosh12679@gmail.com', '2004-08-10', 'Female', 2, 'Computer Science and Engineering', '54329815'),
('ST230007', 'Mohith Kashyap', 'Jaipur, Jaipur, Rajasthan', '9823456786', 'ST230007.jpg', 'st230007@iit.ac.in', 'mohithkashyap83746@gmail.com', '2005-06-17', 'Male', 2, 'Computer Science and Engineering', '41860290'),
('ST230008', 'Radha Naidu', 'Chennai, Chennai, Tamil Nadu', '8623456787', 'ST230008.jpg', 'st230008@iit.ac.in', 'radhanaidu24589@gmail.com', '2004-12-04', 'Female', 2, 'Computer Science and Engineering', '91655602'),
('ST230009', 'Charan Narang', 'Kolkata, Kolkata, West Bengal', '7923456788', 'ST230009.jpg', 'st230009@iit.ac.in', 'charannaranga92718@gmail.com', '2005-05-02', 'Male', 2, 'Computer Science and Engineering', '40768923'),
('ST230010', 'Gautami Pandey', 'Ahmedabad, Ahmedabad, Gujarat', '9723456789', 'ST230010.jpg', 'st230010@iit.ac.in', 'gautamipandey67845@gmail.com', '2004-09-19', 'Female', 2, 'Computer Science and Engineering', '37094462'),
('ST230011', 'Anand Ghosh', 'Hyderabad, Hyderabad, Telangana', '9123456790', 'ST230011.jpg', 'st230011@iit.ac.in', 'anandghosh37451@gmail.com', '2004-01-12', 'Male', 2, 'Computer Science and Engineering', '81751631'),
('ST230012', 'Aadhya Narang', 'Bengaluru, Bengaluru Urban, Karnataka', '9323456791', 'ST230012.jpg', 'st230012@iit.ac.in', 'aadhyanarang85972@gmail.com', '2005-06-18', 'Female', 2, 'Computer Science and Engineering', '53418976'),
('ST230013', 'Aditya Kashyap', 'Chandigarh, Chandigarh, Chandigarh', '9523456792', 'ST230013.jpg', 'st230013@iit.ac.in', 'adityakashyap43178@gmail.com', '2004-04-29', 'Male', 2, 'Computer Science and Engineering', '42167005'),
('ST230014', 'Lakshmi Pandey', 'Visakhapatnam, Visakhapatnam, Andhra Pradesh', '8923456793', 'ST230014.jpg', 'st230014@iit.ac.in', 'lakshmipandey98421@gmail.com', '2005-05-11', 'Female', 2, 'Computer Science and Engineering', '14954321'),
('ST230015', 'Mohith Arora', 'Vadodara, Vadodara, Gujarat', '9123456794', 'ST230015.jpg', 'st230015@iit.ac.in', 'mohitharora46210@gmail.com', '2004-02-25', 'Male', 2, 'Computer Science and Engineering', '64857293'),
('ST230016', 'Ananya Bachchan', 'Nagpur, Nagpur, Maharashtra', '8523456795', 'ST230016.jpg', 'st230016@iit.ac.in', 'ananyabachchan23905@gmail.com', '2005-09-23', 'Female', 2, 'Computer Science and Engineering', '79321088'),
('ST230017', 'Charan Mathews', 'Patna, Patna, Bihar', '9623456796', 'ST230017.jpg', 'st230017@iit.ac.in', 'charanmathews56982@gmail.com', '2004-12-19', 'Male', 2, 'Computer Science and Engineering', '95763458'),
('ST230018', 'Radha Dhawan', 'Agra, Agra, Uttar Pradesh', '9123456797', 'ST230018.jpg', 'st230018@iit.ac.in', 'radhadhawan48173@gmail.com', '2005-10-27', 'Female', 2, 'Computer Science and Engineering', '13476990'),
('ST230019', 'Aayush Dubey', 'Amritsar, Amritsar, Punjab', '8723456798', 'ST230019.jpg', 'st230019@iit.ac.in', 'aayushdubey17384@gmail.com', '2004-11-03', 'Male', 2, 'Computer Science and Engineering', '56087346'),
('ST230020', 'Gautami Naidu', 'Indore, Indore, Madhya Pradesh', '9823456799', 'ST230020.jpg', 'st230020@iit.ac.in', 'gautaminaidu98452@gmail.com', '2004-02-09', 'Female', 2, 'Computer Science and Engineering', '76240269'),
('ST230021', 'Anand Arora', 'Gurgaon, Gurgaon, Haryana', '9234567810', 'ST230021.jpg', 'st230021@iit.ac.in', 'anandarora32645@gmail.com', '2004-04-18', 'Male', 2, 'Computer Science and Engineering', '29574613'),
('ST230022', 'Lakshmi Kashyap', 'Kochi, Ernakulam, Kerala', '8134567811', 'ST230022.jpg', 'st230022@iit.ac.in', 'lakshmikashyap98312@gmail.com', '2005-03-12', 'Female', 2, 'Computer Science and Engineering', '46952087'),
('ST230023', 'Aayush Pandey', 'Jaipur, Jaipur, Rajasthan', '9434567812', 'ST230023.jpg', 'st230023@iit.ac.in', 'aayushpandey40123@gmail.com', '2004-05-23', 'Male', 2, 'Computer Science and Engineering', '14380246'),
('ST230024', 'Radha Narang', 'Thane, Thane, Maharashtra', '8834567813', 'ST230024.jpg', 'st230024@iit.ac.in', 'radhanarang78523@gmail.com', '2005-06-20', 'Female', 2, 'Computer Science and Engineering', '28391371'),
('ST230025', 'Charan Ghosh', 'Bhubaneswar, Khordha, Odisha', '9734567814', 'ST230025.jpg', 'st230025@iit.ac.in', 'charanghosh20984@gmail.com', '2004-07-10', 'Male', 2, 'Computer Science and Engineering', '76846324'),
('ST230026', 'Gautami Mathews', 'Madurai, Madurai, Tamil Nadu', '7934567815', 'ST230026.jpg', 'st230026@iit.ac.in', 'gautamimathews40132@gmail.com', '2005-04-25', 'Female', 2, 'Computer Science and Engineering', '25789060'),
('ST230027', 'Anand Dubey', 'Varanasi, Varanasi, Uttar Pradesh', '9334567816', 'ST230027.jpg', 'st230027@iit.ac.in', 'ananddubey69347@gmail.com', '2004-09-11', 'Male', 2, 'Computer Science and Engineering', '85014293'),
('ST230028', 'Aadhya Naidu', 'Lucknow, Lucknow, Uttar Pradesh', '8134567817', 'ST230028.jpg', 'st230028@iit.ac.in', 'aadhyanaidu57481@gmail.com', '2005-08-15', 'Female', 2, 'Computer Science and Engineering', '70415967'),
('ST230029', 'Mohith Narang', 'Patna, Patna, Bihar', '9834567818', 'ST230029.jpg', 'st230029@iit.ac.in', 'mohithnarang24873@gmail.com', '2004-03-07', 'Male', 2, 'Computer Science and Engineering', '68294039'),
('ST230030', 'Ananya Bachchan', 'Surat, Surat, Gujarat', '9234567819', 'ST230030.jpg', 'st230030@iit.ac.in', 'ananyabachchan19837@gmail.com', '2005-11-16', 'Female', 2, 'Computer Science and Engineering', '52014673'),
('ST230031', 'Aditya Dhawan', 'Chandigarh, Chandigarh, Chandigarh', '9134567820', 'ST230031.jpg', 'st230031@iit.ac.in', 'adityadhawan32567@gmail.com', '2004-08-08', 'Male', 2, 'Computer Science and Engineering', '32547891'),
('ST230032', 'Lakshmi Narang', 'Nagpur, Nagpur, Maharashtra', '8734567821', 'ST230032.jpg', 'st230032@iit.ac.in', 'lakshminarang87432@gmail.com', '2005-02-17', 'Female', 2, 'Computer Science and Engineering', '91028474'),
('ST230033', 'Charan Kashyap', 'Guwahati, Kamrup Metropolitan, Assam', '9134567822', 'ST230033.jpg', 'st230033@iit.ac.in', 'charankashyap78463@gmail.com', '2004-01-30', 'Male', 2, 'Computer Science and Engineering', '57037210'),
('ST230034', 'Gautami Pandey', 'Raipur, Raipur, Chhattisgarh', '9534567823', 'ST230034.jpg', 'st230034@iit.ac.in', 'gautamipandey23478@gmail.com', '2005-10-24', 'Female', 2, 'Computer Science and Engineering', '73649088'),
('ST230035', 'Anand Dhawan', 'Delhi, North Delhi, Delhi', '9834567824', 'ST230035.jpg', 'st230035@iit.ac.in', 'ananddhawan94821@gmail.com', '2004-05-15', 'Male', 2, 'Computer Science and Engineering', '84219506'),
('ST230036', 'Radha Mathews', 'Bhopal, Bhopal, Madhya Pradesh', '8834567825', 'ST230036.jpg', 'st230036@iit.ac.in', 'radhamathews74598@gmail.com', '2005-06-01', 'Female', 2, 'Computer Science and Engineering', '48464250'),
('ST230037', 'Aayush Ghosh', 'Jaipur, Jaipur, Rajasthan', '9234567826', 'ST230037.jpg', 'st230037@iit.ac.in', 'aayushghosh67854@gmail.com', '2004-07-02', 'Male', 2, 'Computer Science and Engineering', '93940583'),
('ST230038', 'Aadhya Dubey', 'Bengaluru, Bengaluru Urban, Karnataka', '8934567827', 'ST230038.jpg', 'st230038@iit.ac.in', 'aadhyadubey15634@gmail.com', '2005-04-12', 'Female', 2, 'Computer Science and Engineering', '19424099'),
('ST230039', 'Charan Naidu', 'Chennai, Chennai, Tamil Nadu', '9834567828', 'ST230039.jpg', 'st230039@iit.ac.in', 'charannaidu39528@gmail.com', '2004-03-25', 'Male', 2, 'Computer Science and Engineering', '89164327'),
('ST230040', 'Gautami Kashyap', 'Hyderabad, Hyderabad, Telangana', '9134567829', 'ST230040.jpg', 'st230040@iit.ac.in', 'gautamikashyap92347@gmail.com', '2005-08-06', 'Female', 2, 'Computer Science and Engineering', '61054091'),
('ST230041', 'Anand Pandey', 'Gurgaon, Gurgaon, Haryana', '9234567830', 'ST230041.jpg', 'st230041@iit.ac.in', 'anandpandey62347@gmail.com', '2004-11-28', 'Male', 2, 'Mechanical Engineering', '30367156'),
('ST230042', 'Lakshmi Narang', 'Thane, Thane, Maharashtra', '8834567831', 'ST230042.jpg', 'st230042@iit.ac.in', 'lakshminarang12846@gmail.com', '2005-06-15', 'Female', 2, 'Mechanical Engineering', '65258476'),
('ST230043', 'Aayush Ghosh', 'Kolkata, Kolkata, West Bengal', '8934567832', 'ST230043.jpg', 'st230043@iit.ac.in', 'aayushghosh29847@gmail.com', '2004-04-03', 'Male', 2, 'Mechanical Engineering', '78104280'),
('ST230044', 'Radha Kashyap', 'Delhi, South Delhi, Delhi', '9234567833', 'ST230044.jpg', 'st230044@iit.ac.in', 'radhakashyap79345@gmail.com', '2005-12-22', 'Female', 2, 'Mechanical Engineering', '17623948'),
('ST230045', 'Mohith Naidu', 'Bengaluru, Bengaluru Urban, Karnataka', '9134567834', 'ST230045.jpg', 'st230045@iit.ac.in', 'mohithnaidu50432@gmail.com', '2004-09-05', 'Male', 2, 'Mechanical Engineering', '34326971'),
('ST230046', 'Ananya Dubey', 'Jaipur, Jaipur, Rajasthan', '9534567835', 'ST230046.jpg', 'st230046@iit.ac.in', 'ananyadubey81245@gmail.com', '2005-03-18', 'Female', 2, 'Mechanical Engineering', '84219863'),
('ST230047', 'Charan Arora', 'Lucknow, Lucknow, Uttar Pradesh', '9234567836', 'ST230047.jpg', 'st230047@iit.ac.in', 'charanarora39058@gmail.com', '2004-11-07', 'Male', 2, 'Mechanical Engineering', '17603420'),
('ST230048', 'Aadhya Ghosh', 'Patna, Patna, Bihar', '8834567837', 'ST230048.jpg', 'st230048@iit.ac.in', 'aadhyaghosh27849@gmail.com', '2005-07-29', 'Female', 2, 'Mechanical Engineering', '58712093'),
('ST230049', 'Aditya Narang', 'Varanasi, Varanasi, Uttar Pradesh', '9134567838', 'ST230049.jpg', 'st230049@iit.ac.in', 'adityanarang10927@gmail.com', '2004-02-04', 'Male', 2, 'Mechanical Engineering', '29843062'),
('ST230050', 'Gautami Mathews', 'Thane, Thane, Maharashtra', '8934567839', 'ST230050.jpg', 'st230050@iit.ac.in', 'gautamimathews56328@gmail.com', '2005-05-11', 'Female', 2, 'Mechanical Engineering', '56859370'),
('ST230051', 'Aayush Pandey', 'Ahmedabad, Ahmedabad, Gujarat', '9834567840', 'ST230051.jpg', 'st230051@iit.ac.in', 'aayushpandey47291@gmail.com', '2004-01-14', 'Male', 2, 'Mechanical Engineering', '34918376'),
('ST230052', 'Radha Dubey', 'Hyderabad, Hyderabad, Telangana', '8134567841', 'ST230052.jpg', 'st230052@iit.ac.in', 'radhadubey67453@gmail.com', '2005-10-30', 'Female', 2, 'Mechanical Engineering', '95018452'),
('ST230053', 'Charan Narang', 'Gurgaon, Gurgaon, Haryana', '9234567842', 'ST230053.jpg', 'st230053@iit.ac.in', 'charannarng21409@gmail.com', '2004-06-17', 'Male', 2, 'Mechanical Engineering', '17604278'),
('ST230054', 'Lakshmi Ghosh', 'Surat, Surat, Gujarat', '8734567843', 'ST230054.jpg', 'st230054@iit.ac.in', 'lakshmighosh47298@gmail.com', '2005-03-20', 'Female', 2, 'Mechanical Engineering', '80345020'),
('ST230055', 'Mohith Mathews', 'Jaipur, Jaipur, Rajasthan', '9234567844', 'ST230055.jpg', 'st230055@iit.ac.in', 'mohithmathews38267@gmail.com', '2004-10-23', 'Male', 2, 'Mechanical Engineering', '48156372'),
('ST230056', 'Aadhya Pandey', 'Kochi, Ernakulam, Kerala', '8734567845', 'ST230056.jpg', 'st230056@iit.ac.in', 'aadhyapandey79236@gmail.com', '2005-02-28', 'Female', 2, 'Mechanical Engineering', '24497361'),
('ST230057', 'Anand Dubey', 'Bhopal, Bhopal, Madhya Pradesh', '9534567846', 'ST230057.jpg', 'st230057@iit.ac.in', 'ananddubey45089@gmail.com', '2004-04-19', 'Male', 2, 'Mechanical Engineering', '39876522'),
('ST230058', 'Radha Kashyap', 'Chennai, Chennai, Tamil Nadu', '8734567847', 'ST230058.jpg', 'st230058@iit.ac.in', 'radhakashyap69023@gmail.com', '2005-08-31', 'Female', 2, 'Mechanical Engineering', '80149329'),
('ST230059', 'Charan Pandey', 'Guwahati, Kamrup, Assam', '9434567848', 'ST230059.jpg', 'st230059@iit.ac.in', 'charanpandey56421@gmail.com', '2004-12-18', 'Male', 2, 'Mechanical Engineering', '56429291'),
('ST230060', 'Aadhya Naidu', 'Raipur, Raipur, Chhattisgarh', '9634567849', 'ST230060.jpg', 'st230060@iit.ac.in', 'aadhyanaidu47923@gmail.com', '2005-09-04', 'Female', 2, 'Mechanical Engineering', '97056018'),
('ST230061', 'Aditya Mathews', 'Delhi, North Delhi, Delhi', '9334567850', 'ST230061.jpg', 'st230061@iit.ac.in', 'adityamathews56984@gmail.com', '2004-07-27', 'Male', 2, 'Mechanical Engineering', '27938744'),
('ST230062', 'Lakshmi Narang', 'Chandigarh, Chandigarh, Chandigarh', '8234567851', 'ST230062.jpg', 'st230062@iit.ac.in', 'lakshminarang87234@gmail.com', '2005-06-16', 'Female', 2, 'Mechanical Engineering', '12340294'),
('ST230063', 'Aayush Ghosh', 'Nagpur, Nagpur, Maharashtra', '8834567852', 'ST230063.jpg', 'st230063@iit.ac.in', 'aayushghosh39248@gmail.com', '2004-11-22', 'Male', 2, 'Mechanical Engineering', '68179364'),
('ST230064', 'Radha Dubey', 'Patna, Patna, Bihar', '8834567853', 'ST230064.jpg', 'st230064@iit.ac.in', 'radhadubey58349@gmail.com', '2005-04-11', 'Female', 2, 'Mechanical Engineering', '95742875'),
('ST230065', 'Charan Naidu', 'Ahmedabad, Ahmedabad, Gujarat', '9234567854', 'ST230065.jpg', 'st230065@iit.ac.in', 'charannaidu38947@gmail.com', '2004-03-12', 'Male', 2, 'Mechanical Engineering', '73405680'),
('ST230066', 'Lakshmi Kashyap', 'Gurgaon, Gurgaon, Haryana', '9134567855', 'ST230066.jpg', 'st230066@iit.ac.in', 'lakshmikashyap27894@gmail.com', '2005-10-29', 'Female', 2, 'Mechanical Engineering', '79073427'),
('ST230067', 'Charan Pandey', 'Bhopal, Bhopal, Madhya Pradesh', '9134567836', 'ST230067.jpg', 'st230067@iit.ac.in', 'charan.pandey82713@gmail.com', '2004-05-21', 'Male', 2, 'Civil Engineering', '19478412'),
('ST230068', 'Radha Narang', 'Patna, Patna, Bihar', '9734567837', 'ST230068.jpg', 'st230068@iit.ac.in', 'radha.narang52374@gmail.com', '2005-09-14', 'Female', 2, 'Civil Engineering', '38682175'),
('ST230069', 'Anand Dubey', 'Jaipur, Jaipur, Rajasthan', '9634567838', 'ST230069.jpg', 'st230069@iit.ac.in', 'anand.dubey47835@gmail.com', '2004-07-30', 'Male', 2, 'Civil Engineering', '79253704'),
('ST230070', 'Lakshmi Kashyap', 'Gurgaon, Gurgaon, Haryana', '8004560039', 'ST230070.jpg', 'st230070@iit.ac.in', 'lakshmi.kashyap65248@gmail.com', '2005-06-09', 'Female', 2, 'Civil Engineering', '12068345'),
('ST230071', 'Aditya Dhawan', 'Hyderabad, Hyderabad, Telangana', '9034567840', 'ST230071.jpg', 'st230071@iit.ac.in', 'aditya.dhawan35894@gmail.com', '2004-01-13', 'Male', 2, 'Civil Engineering', '49106873'),
('ST230072', 'Ananya Pandey', 'Chennai, Chennai, Tamil Nadu', '8934567841', 'ST230072.jpg', 'st230072@iit.ac.in', 'ananya.pandey10458@gmail.com', '2005-07-02', 'Female', 2, 'Civil Engineering', '20489160'),
('ST230073', 'Mohith Narang', 'Kolkata, Kolkata, West Bengal', '9734567842', 'ST230073.jpg', 'st230073@iit.ac.in', 'mohith.narang29834@gmail.com', '2004-09-14', 'Male', 2, 'Civil Engineering', '37089212'),
('ST230074', 'Radha Kashyap', 'Thane, Thane, Maharashtra', '9834567843', 'ST230074.jpg', 'st230074@iit.ac.in', 'radha.kashyap56293@gmail.com', '2005-12-29', 'Female', 2, 'Civil Engineering', '51179754'),
('ST230075', 'Charan Dubey', 'Ahmedabad, Ahmedabad, Gujarat', '9134567844', 'ST230075.jpg', 'st230075@iit.ac.in', 'charan.dubey40952@gmail.com', '2004-06-11', 'Male', 2, 'Civil Engineering', '14765083'),
('ST230076', 'Gautami Arora', 'Delhi, North Delhi, Delhi', '9534567845', 'ST230076.jpg', 'st230076@iit.ac.in', 'gautami.arora18274@gmail.com', '2005-04-07', 'Female', 2, 'Civil Engineering', '62984751'),
('ST230077', 'Anand Pandey', 'Mumbai, Mumbai, Maharashtra', '9934567846', 'ST230077.jpg', 'st230077@iit.ac.in', 'anand.pandey20398@gmail.com', '2004-08-19', 'Male', 2, 'Civil Engineering', '10462749'),
('ST230078', 'Aadhya Ghosh', 'Bhopal, Bhopal, Madhya Pradesh', '9334567847', 'ST230078.jpg', 'st230078@iit.ac.in', 'aadhya.ghosh98214@gmail.com', '2005-03-23', 'Female', 2, 'Civil Engineering', '84195056'),
('ST230079', 'Aditya Mathews', 'Pune, Pune, Maharashtra', '9234567848', 'ST230079.jpg', 'st230079@iit.ac.in', 'aditya.mathews56831@gmail.com', '2004-12-02', 'Male', 2, 'Civil Engineering', '35258127'),
('ST230080', 'Lakshmi Narang', 'Surat, Surat, Gujarat', '9134567849', 'ST230080.jpg', 'st230080@iit.ac.in', 'lakshmi.narang12587@gmail.com', '2005-05-10', 'Female', 2, 'Civil Engineering', '21735009'),
('ST230081', 'Aayush Dubey', 'Varanasi, Varanasi, Uttar Pradesh', '8834567850', 'ST230081.jpg', 'st230081@iit.ac.in', 'aayush.dubey73485@gmail.com', '2004-10-06', 'Male', 2, 'Civil Engineering', '60074345'),
('ST230082', 'Radha Kashyap', 'Patna, Patna, Bihar', '8734567851', 'ST230082.jpg', 'st230082@iit.ac.in', 'radha.kashyap43589@gmail.com', '2005-11-19', 'Female', 2, 'Civil Engineering', '51267481'),
('ST230083', 'Mohith Naidu', 'Chennai, Chennai, Tamil Nadu', '8934567852', 'ST230083.jpg', 'st230083@iit.ac.in', 'mohith.naidu63827@gmail.com', '2004-01-22', 'Male', 2, 'Civil Engineering', '79644082'),
('ST230084', 'Ananya Arora', 'Jaipur, Jaipur, Rajasthan', '9634567853', 'ST230084.jpg', 'st230084@iit.ac.in', 'ananya.arora97264@gmail.com', '2005-08-03', 'Female', 2, 'Civil Engineering', '26713540'),
('ST230085', 'Charan Ghosh', 'Kochi, Ernakulam, Kerala', '9034567854', 'ST230085.jpg', 'st230085@iit.ac.in', 'charan.ghosh30259@gmail.com', '2004-05-14', 'Male', 2, 'Civil Engineering', '96482379'),
('ST230086', 'Lakshmi Pandey', 'Gurgaon, Gurgaon, Haryana', '8934567855', 'ST230086.jpg', 'st230086@iit.ac.in', 'lakshmi.pandey87963@gmail.com', '2005-09-27', 'Female', 2, 'Civil Engineering', '24013851'),
('ST230087', 'Aayush Narang', 'Nagpur, Nagpur, Maharashtra', '9834567856', 'ST230087.jpg', 'st230087@iit.ac.in', 'aayush.narang24358@gmail.com', '2004-11-05', 'Male', 2, 'Civil Engineering', '48481273'),
('ST230088', 'Radha Mathews', 'Bengaluru, Bengaluru Urban, Karnataka', '9734567857', 'ST230088.jpg', 'st230088@iit.ac.in', 'radha.mathews78154@gmail.com', '2005-06-21', 'Female', 2, 'Civil Engineering', '92037958'),
('ST230089', 'Anand Kashyap', 'Delhi, South Delhi, Delhi', '9234567858', 'ST230089.jpg', 'st230089@iit.ac.in', 'anand.kashyap89235@gmail.com', '2004-07-28', 'Male', 2, 'Civil Engineering', '17570392'),
('ST230090', 'Gautami Narang', 'Kolkata, Kolkata, West Bengal', '9134567859', 'ST230090.jpg', 'st230090@iit.ac.in', 'gautami.narang47825@gmail.com', '2005-03-17', 'Female', 2, 'Civil Engineering', '65713018'),
('ST230091', 'Mohith Arora', 'Delhi, North Delhi, Delhi', '8934567860', 'ST230091.jpg', 'st230091@iit.ac.in', 'mohith.arora68934@gmail.com', '2004-06-19', 'Male', 2, 'Chemical Engineering', '19245930'),
('ST230092', 'Lakshmi Mathews', 'Surat, Surat, Gujarat', '9634567861', 'ST230092.jpg', 'st230092@iit.ac.in', 'lakshmi.mathews25843@gmail.com', '2005-02-14', 'Female', 2, 'Chemical Engineering', '89341067'),
('ST230093', 'Charan Dubey', 'Jaipur, Jaipur, Rajasthan', '9234567862', 'ST230093.jpg', 'st230093@iit.ac.in', 'charan.dubey57183@gmail.com', '2004-09-08', 'Male', 2, 'Chemical Engineering', '50739491'),
('ST230094', 'Ananya Kashyap', 'Gurgaon, Gurgaon, Haryana', '9134567863', 'ST230094.jpg', 'st230094@iit.ac.in', 'ananya.kashyap38472@gmail.com', '2005-08-19', 'Female', 2, 'Chemical Engineering', '80426542'),
('ST230095', 'Aditya Ghosh', 'Kolkata, Kolkata, West Bengal', '8734567864', 'ST230095.jpg', 'st230095@iit.ac.in', 'aditya.ghosh72834@gmail.com', '2004-10-25', 'Male', 2, 'Chemical Engineering', '38091456'),
('ST230096', 'Radha Pandey', 'Bhopal, Bhopal, Madhya Pradesh', '9534567865', 'ST230096.jpg', 'st230096@iit.ac.in', 'radha.pandey43792@gmail.com', '2005-05-23', 'Female', 2, 'Chemical Engineering', '29820750'),
('ST230097', 'Anand Naidu', 'Hyderabad, Hyderabad, Telangana', '9634567866', 'ST230097.jpg', 'st230097@iit.ac.in', 'anand.naidu92748@gmail.com', '2004-01-18', 'Male', 2, 'Chemical Engineering', '13278944'),
('ST230098', 'Aadhya Dubey', 'Thane, Thane, Maharashtra', '8834567867', 'ST230098.jpg', 'st230098@iit.ac.in', 'aadhya.dubey17458@gmail.com', '2005-07-30', 'Female', 2, 'Chemical Engineering', '72956421'),
('ST230099', 'Mohith Narang', 'Ahmedabad, Ahmedabad, Gujarat', '9734567868', 'ST230099.jpg', 'st230099@iit.ac.in', 'mohith.narang37826@gmail.com', '2004-11-12', 'Male', 2, 'Chemical Engineering', '39016543'),
('ST230100', 'Gautami Bachchan', 'Patna, Patna, Bihar', '9034567869', 'ST230100.jpg', 'st230100@iit.ac.in', 'gautami.bachchan28457@gmail.com', '2005-12-01', 'Female', 2, 'Chemical Engineering', '71904820'),
('ST240001', 'Ananya Reddy', 'Delhi, Delhi, Delhi', '9034567890', 'ST240001.jpg', 'st240001@iit.ac.in', 'ananyareddy24001@gmail.com', '2005-01-01', 'Female', 1, 'Computer Science and Engineering', '981345672'),
('ST240002', 'Mohith Sharma', 'Bhopal, Bhopal, Madhya Pradesh', '8034567891', 'ST240002.jpg', 'st240002@iit.ac.in', 'mohitsharma24002@gmail.com', '2004-02-02', 'Male', 1, 'Computer Science and Engineering', '829473156'),
('ST240003', 'Radha Singh', 'Pune, Pune, Maharashtra', '7034567892', 'ST240003.jpg', 'st240003@iit.ac.in', 'radhasingh24003@gmail.com', '2005-03-03', 'Female', 1, 'Mechanical Engineering', '374920561'),
('ST240004', 'Aadhya Kumar', 'Chennai, Chennai, Tamil Nadu', '6034567893', 'ST240004.jpg', 'st240004@iit.ac.in', 'aadhyakumar24004@gmail.com', '2004-04-04', 'Female', 1, 'Mechanical Engineering', '156489273'),
('ST240005', 'Aayush Mehta', 'Indore, Indore, Madhya Pradesh', '5034567894', 'ST240005.jpg', 'st240005@iit.ac.in', 'aayushmehta24005@gmail.com', '2005-05-05', 'Male', 1, 'Mechanical Engineering', '298734615'),
('ST240006', 'Gautami Verma', 'Kolkata, Kolkata, West Bengal', '9034567895', 'ST240006.jpg', 'st240006@iit.ac.in', 'gautamiverma24006@gmail.com', '2004-06-06', 'Female', 1, 'Chemical Engineering', '493827156'),
('ST240007', 'Charan Iyer', 'Noida, Gautam Buddha Nagar, Uttar Pradesh', '8034567896', 'ST240007.jpg', 'st240007@iit.ac.in', 'charaniyer24007@gmail.com', '2005-07-07', 'Male', 1, 'Chemical Engineering', '264389507'),
('ST240008', 'Lakshmi Rao', 'Bhubaneswar, Khurda, Odisha', '7034567897', 'ST240008.jpg', 'st240008@iit.ac.in', 'lakshmirao24008@gmail.com', '2004-08-08', 'Female', 1, 'Civil Engineering', '759841230'),
('ST240009', 'Mohith Patil', 'Jaipur, Jaipur, Rajasthan', '6034567898', 'ST240009.jpg', 'st240009@iit.ac.in', 'mohithpatil24009@gmail.com', '2005-09-09', 'Male', 1, 'Civil Engineering', '847213690'),
('ST240010', 'Ananya Nair', 'Surat, Surat, Gujarat', '5034567899', 'ST240010.jpg', 'st240010@iit.ac.in', 'ananyanair24010@gmail.com', '2004-10-10', 'Female', 1, 'Civil Engineering', '915764820'),
('ST240011', 'Aayush Awasthi', 'Gurgaon, Gurgaon, Haryana', '9034567800', 'ST240011.jpg', 'st240011@iit.ac.in', 'aayushawasthi24011@gmail.com', '2005-11-11', 'Male', 1, 'Civil Engineering', '632874159'),
('ST240012', 'Gautami Bansal', 'Kochi, Ernakulam, Kerala', '9034567801', 'ST240012.jpg', 'st240012@iit.ac.in', 'gautamibansal24012@gmail.com', '2004-12-12', 'Female', 1, 'Civil Engineering', '280943675'),
('ST240013', 'Mohith Jain', 'Srinagar, Srinagar, Jammu and Kashmir', '9034567802', 'ST240013.jpg', 'st240013@iit.ac.in', 'mohithjain24013@gmail.com', '2005-01-13', 'Male', 1, 'Chemical Engineering', '718294306'),
('ST240014', 'Radha Choudhary', 'Delhi, Delhi, Delhi', '9034567803', 'ST240014.jpg', 'st240014@iit.ac.in', 'radhachoudhary24014@gmail.com', '2004-02-14', 'Female', 1, 'Chemical Engineering', '534781920'),
('ST240015', 'Aadhya Sinha', 'Bhopal, Bhopal, Madhya Pradesh', '9034567804', 'ST240015.jpg', 'st240015@iit.ac.in', 'aadhyasinha24015@gmail.com', '2005-03-15', 'Female', 1, 'Chemical Engineering', '406275839'),
('ST240016', 'Charan Kumar', 'Pune, Pune, Maharashtra', '9034567805', 'ST240016.jpg', 'st240016@iit.ac.in', 'charankumar24016@gmail.com', '2004-04-16', 'Male', 1, 'Chemical Engineering', '957246813'),
('ST240017', 'Aayush Gupta', 'Indore, Indore, Madhya Pradesh', '9034567806', 'ST240017.jpg', 'st240017@iit.ac.in', 'aayushgupta24017@gmail.com', '2005-05-17', 'Male', 1, 'Mechanical Engineering', '120479635'),
('ST240018', 'Gautami Singh', 'Chennai, Chennai, Tamil Nadu', '9034567807', 'ST240018.jpg', 'st240018@iit.ac.in', 'gautamisingh24018@gmail.com', '2004-06-18', 'Female', 1, 'Mechanical Engineering', '487320651'),
('ST240019', 'Radha Sharma', 'Kolkata, Kolkata, West Bengal', '9034567808', 'ST240019.jpg', 'st240019@iit.ac.in', 'radhasharma24019@gmail.com', '2005-07-19', 'Female', 1, 'Mechanical Engineering', '345671892'),
('ST240020', 'Mohith Verma', 'Bhubaneswar, Khurda, Odisha', '9034567809', 'ST240020.jpg', 'st240020@iit.ac.in', 'mohithverma24020@gmail.com', '2004-08-20', 'Male', 1, 'Mechanical Engineering', '218739564'),
('ST240021', 'Aadhya Yadav', 'Jaipur, Jaipur, Rajasthan', '9034567810', 'ST240021.jpg', 'st240021@iit.ac.in', 'aadhyayadav24021@gmail.com', '2005-09-21', 'Female', 1, 'Mechanical Engineering', '578624013'),
('ST240022', 'Aayush Pandey', 'Delhi, Delhi, Delhi', '9034567811', 'ST240022.jpg', 'st240022@iit.ac.in', 'aayushpandey24022@gmail.com', '2004-10-22', 'Male', 1, 'Mechanical Engineering', '694820357'),
('ST240023', 'Charan Soni', 'Pune, Pune, Maharashtra', '9034567812', 'ST240023.jpg', 'st240023@iit.ac.in', 'charansoni24023@gmail.com', '2005-11-23', 'Male', 1, 'Mechanical Engineering', '832756194'),
('ST240024', 'Gautami Gupta', 'Kochi, Ernakulam, Kerala', '9034567813', 'ST240024.jpg', 'st240024@iit.ac.in', 'gautamigupta24024@gmail.com', '2004-12-24', 'Female', 1, 'Chemical Engineering', '781354926'),
('ST240025', 'Ananya Yadav', 'Delhi, Delhi, Delhi', '9034567814', 'ST240025.jpg', 'st240025@iit.ac.in', 'ananyayadav24025@gmail.com', '2005-01-25', 'Female', 1, 'Chemical Engineering', '530912478'),
('ST240026', 'Mohith Thakur', 'Noida, Gautam Buddha Nagar, Uttar Pradesh', '9034567815', 'ST240026.jpg', 'st240026@iit.ac.in', 'mohitthakur24026@gmail.com', '2004-02-26', 'Male', 1, 'Chemical Engineering', '945217680'),
('ST240027', 'Radha Singh', 'Srinagar, Srinagar, Jammu and Kashmir', '9034567816', 'ST240027.jpg', 'st240027@iit.ac.in', 'radhasingh24027@gmail.com', '2005-03-27', 'Female', 1, 'Chemical Engineering', '681049235'),
('ST240028', 'Aadhya Nair', 'Delhi, Delhi, Delhi', '9034567817', 'ST240028.jpg', 'st240028@iit.ac.in', 'aadhyanair24028@gmail.com', '2004-04-28', 'Female', 1, 'Civil Engineering', '720364891'),
('ST240029', 'Charan Jadhav', 'Bhopal, Bhopal, Madhya Pradesh', '9034567818', 'ST240029.jpg', 'st240029@iit.ac.in', 'charanjadhav24029@gmail.com', '2005-05-29', 'Male', 1, 'Civil Engineering', '103945782'),
('ST240030', 'Mohith Iyer', 'Pune, Pune, Maharashtra', '9034567819', 'ST240030.jpg', 'st240030@iit.ac.in', 'mohithiyer24030@gmail.com', '2004-06-30', 'Male', 1, 'Civil Engineering', '492875631'),
('ST240031', 'Radha Rao', 'Chennai, Chennai, Tamil Nadu', '9034567820', 'ST240031.jpg', 'st240031@iit.ac.in', 'radharao24031@gmail.com', '2005-07-01', 'Female', 1, 'Civil Engineering', '384726509'),
('ST240032', 'Gautami Singh', 'Kolkata, Kolkata, West Bengal', '9034567821', 'ST240032.jpg', 'st240032@iit.ac.in', 'gautamisingh24032@gmail.com', '2004-08-02', 'Female', 1, 'Chemical Engineering', '927168453'),
('ST240033', 'Aayush Reddy', 'Gurgaon, Gurgaon, Haryana', '9034567822', 'ST240033.jpg', 'st240033@iit.ac.in', 'aayushreddy24033@gmail.com', '2005-09-03', 'Male', 1, 'Chemical Engineering', '569431820'),
('ST240034', 'Charan Thakur', 'Noida, Gautam Buddha Nagar, Uttar Pradesh', '9034567823', 'ST240034.jpg', 'st240034@iit.ac.in', 'charanthakur24034@gmail.com', '2004-10-04', 'Male', 1, 'Mechanical Engineering', '418975263'),
('ST240035', 'Radha Mehta', 'Surat, Surat, Gujarat', '9034567824', 'ST240035.jpg', 'st240035@iit.ac.in', 'radhamehta24035@gmail.com', '2005-11-05', 'Female', 1, 'Mechanical Engineering', '253764819'),
('ST240036', 'Mohith Kapoor', 'Jaipur, Jaipur, Rajasthan', '9034567825', 'ST240036.jpg', 'st240036@iit.ac.in', 'mohithkapoor24036@gmail.com', '2004-12-06', 'Male', 1, 'Mechanical Engineering', '807915634'),
('ST240037', 'Aadhya Nair', 'Delhi, Delhi, Delhi', '9034567826', 'ST240037.jpg', 'st240037@iit.ac.in', 'aadhyanair24037@gmail.com', '2005-01-07', 'Female', 1, 'Civil Engineering', '602184739'),
('ST240038', 'Gautami Yadav', 'Bhopal, Bhopal, Madhya Pradesh', '9034567827', 'ST240038.jpg', 'st240038@iit.ac.in', 'gautamiyadav24038@gmail.com', '2004-02-08', 'Female', 1, 'Civil Engineering', '475829610'),
('ST240039', 'Mohith Reddy', 'Pune, Pune, Maharashtra', '9034567828', 'ST240039.jpg', 'st240039@iit.ac.in', 'mohithreddy24039@gmail.com', '2005-03-09', 'Male', 1, 'Mechanical Engineering', '315284769'),
('ST240040', 'Radha Jain', 'Chennai, Chennai, Tamil Nadu', '9034567829', 'ST240040.jpg', 'st240040@iit.ac.in', 'radhajain24040@gmail.com', '2004-04-10', 'Female', 1, 'Mechanical Engineering', '149760238'),
('ST240041', 'Aayush Patil', 'Kolkata, Kolkata, West Bengal', '9034567830', 'ST240041.jpg', 'st240041@iit.ac.in', 'aayushpatil24041@gmail.com', '2005-05-11', 'Male', 1, 'Chemical Engineering', '689317205'),
('ST240042', 'Gautami Agarwal', 'Jaipur, Jaipur, Rajasthan', '9034567831', 'ST240042.jpg', 'st240042@iit.ac.in', 'gautamiagarwal24042@gmail.com', '2004-06-12', 'Female', 1, 'Chemical Engineering', '758203946'),
('ST240043', 'Mohith Agarwal', 'Delhi, Delhi, Delhi', '9034567832', 'ST240043.jpg', 'st240043@iit.ac.in', 'mohithagarwal24043@gmail.com', '2005-07-13', 'Male', 1, 'Mechanical Engineering', '247195803'),
('ST240044', 'Aadhya Bhattacharya', 'Bhopal, Bhopal, Madhya Pradesh', '9034567833', 'ST240044.jpg', 'st240044@iit.ac.in', 'aadhyabhattacharya24044@gmail.com', '2004-08-14', 'Female', 1, 'Mechanical Engineering', '935672184'),
('ST240045', 'Radha Srivastava', 'Pune, Pune, Maharashtra', '9034567834', 'ST240045.jpg', 'st240045@iit.ac.in', 'radh Srivastava24045@gmail.com', '2005-09-15', 'Female', 1, 'Civil Engineering', '460521798');
INSERT INTO `StudentPersonalDetails` (`student_id`, `student_name`, `address`, `phone`, `photo`, `college_email`, `personal_email`, `dob`, `gender`, `year`, `branch`, `password`) VALUES
('ST240046', 'Mohith Nair', 'Chennai, Chennai, Tamil Nadu', '9034567835', 'ST240046.jpg', 'st240046@iit.ac.in', 'mohithnair24046@gmail.com', '2004-10-16', 'Male', 1, 'Civil Engineering', '892674530'),
('ST240047', 'Aayush Iyer', 'Kolkata, Kolkata, West Bengal', '9034567836', 'ST240047.jpg', 'st240047@iit.ac.in', 'aayushiyer24047@gmail.com', '2005-11-17', 'Male', 1, 'Civil Engineering', '103968254'),
('ST240048', 'Gautami Choudhary', 'Jaipur, Jaipur, Rajasthan', '9034567837', 'ST240048.jpg', 'st240048@iit.ac.in', 'gautamichoudhary24048@gmail.com', '2004-12-18', 'Female', 1, 'Chemical Engineering', '538912467'),
('ST240049', 'Radha Reddy', 'Delhi, Delhi, Delhi', '9034567838', 'ST240049.jpg', 'st240049@iit.ac.in', 'radhareddy24049@gmail.com', '2005-01-19', 'Female', 1, 'Chemical Engineering', '794236185'),
('ST240050', 'Mohith Singh', 'Bhopal, Bhopal, Madhya Pradesh', '9034567839', 'ST240050.jpg', 'st240050@iit.ac.in', 'mohithsingh24050@gmail.com', '2004-02-20', 'Male', 1, 'Mechanical Engineering', '284075913'),
('ST240051', 'Aayush Dubey', 'Gurgaon, Gurgaon, Haryana', '9801234560', 'ST240051.jpg', 'st240051@iit.ac.in', 'aayushdubey24051@gmail.com', '2004-03-21', 'Male', 1, 'Chemical Engineering', '675391248'),
('ST240052', 'Gautami Naidu', 'Kolkata, Kolkata, West Bengal', '9823456781', 'ST240052.jpg', 'st240052@iit.ac.in', 'gautaminaidu24052@gmail.com', '2005-04-22', 'Female', 1, 'Chemical Engineering', '809215346'),
('ST240053', 'Mohith Ghosh', 'Chennai, Chennai, Tamil Nadu', '9861234567', 'ST240053.jpg', 'st240053@iit.ac.in', 'mohithghosh24053@gmail.com', '2004-05-23', 'Male', 1, 'Mechanical Engineering', '314259867'),
('ST240054', 'Ananya Kashyap', 'Delhi, Delhi, Delhi', '9778901234', 'ST240054.jpg', 'st240054@iit.ac.in', 'ananyakashyap24054@gmail.com', '2005-06-24', 'Female', 1, 'Mechanical Engineering', '296740851'),
('ST240055', 'Aadhya Pandey', 'Pune, Pune, Maharashtra', '9884567890', 'ST240055.jpg', 'st240055@iit.ac.in', 'aadhyapandey24055@gmail.com', '2004-07-25', 'Female', 1, 'Civil Engineering', '473851926'),
('ST240056', 'Aditya Arora', 'Bhopal, Bhopal, Madhya Pradesh', '9802345678', 'ST240056.jpg', 'st240056@iit.ac.in', 'adityaarora24056@gmail.com', '2005-08-26', 'Male', 1, 'Civil Engineering', '810924735'),
('ST240057', 'Lakshmi Dhawan', 'Kolkata, Kolkata, West Bengal', '9834567890', 'ST240057.jpg', 'st240057@iit.ac.in', 'lakshmidhawan24057@gmail.com', '2004-09-27', 'Female', 1, 'Civil Engineering', '562348917'),
('ST240058', 'Charan Narang', 'Jaipur, Jaipur, Rajasthan', '9038900034', 'ST240058.jpg', 'st240058@iit.ac.in', 'charannarng24058@gmail.com', '2005-10-28', 'Male', 1, 'Mechanical Engineering', '147062358'),
('ST240059', 'Anand Mathews', 'Delhi, Delhi, Delhi', '9865432109', 'ST240059.jpg', 'st240059@iit.ac.in', 'anandmathews24059@gmail.com', '2004-11-29', 'Male', 1, 'Chemical Engineering', '985612473'),
('ST240060', 'Ananya Ghosh', 'Chennai, Chennai, Tamil Nadu', '9798765432', 'ST240060.jpg', 'st240060@iit.ac.in', 'ananyaghosh24060@gmail.com', '2005-12-30', 'Female', 1, 'Chemical Engineering', '265479138'),
('ST240061', 'Aayush Dubey', 'Pune, Pune, Maharashtra', '9787654321', 'ST240061.jpg', 'st240061@iit.ac.in', 'aayushdubey24061@gmail.com', '2004-01-31', 'Male', 1, 'Mechanical Engineering', '752931684'),
('ST240062', 'Lakshmi Bhattacharya', 'Delhi, Delhi, Delhi', '9756789012', 'ST240062.jpg', 'st240062@iit.ac.in', 'lakshmibhattacharya24062@gmail.com', '2005-02-01', 'Female', 1, 'Civil Engineering', '461583297'),
('ST240063', 'Mohith Yadav', 'Bhopal, Bhopal, Madhya Pradesh', '9745678901', 'ST240063.jpg', 'st240063@iit.ac.in', 'mohithyadav24063@gmail.com', '2004-03-02', 'Male', 1, 'Chemical Engineering', '302978654'),
('ST240064', 'Radha Srivastava', 'Chennai, Chennai, Tamil Nadu', '9734567890', 'ST240064.jpg', 'st240064@iit.ac.in', 'radh Srivastava24064@gmail.com', '2005-04-03', 'Female', 1, 'Civil Engineering', '578294013'),
('ST240065', 'Aadhya Narang', 'Kolkata, Kolkata, West Bengal', '9720056000', 'ST240065.jpg', 'st240065@iit.ac.in', 'aadhyanarang24065@gmail.com', '2004-05-04', 'Female', 1, 'Chemical Engineering', '839647215'),
('ST240066', 'Charan Thakur', 'Jaipur, Jaipur, Rajasthan', '9712345678', 'ST240066.jpg', 'st240066@iit.ac.in', 'charanthakur24066@gmail.com', '2005-06-05', 'Male', 1, 'Mechanical Engineering', '495260871'),
('ST240067', 'Gautami Sharma', 'Delhi, Delhi, Delhi', '9701234567', 'ST240067.jpg', 'st240067@iit.ac.in', 'gautamisharma24067@gmail.com', '2004-07-06', 'Female', 1, 'Civil Engineering', '620478935'),
('ST240068', 'Mohith Singh', 'Bhopal, Bhopal, Madhya Pradesh', '9687654321', 'ST240068.jpg', 'st240068@iit.ac.in', 'mohithsingh24068@gmail.com', '2005-08-07', 'Male', 1, 'Chemical Engineering', '583214690'),
('ST240069', 'Ananya Patil', 'Chennai, Chennai, Tamil Nadu', '9654321098', 'ST240069.jpg', 'st240069@iit.ac.in', 'ananyapatil24069@gmail.com', '2004-09-08', 'Female', 1, 'Mechanical Engineering', '471829063'),
('ST240070', 'Aayush Nair', 'Gurgaon, Gurgaon, Haryana', '9643210987', 'ST240070.jpg', 'st240070@iit.ac.in', 'aayushnair24070@gmail.com', '2005-10-09', 'Male', 1, 'Civil Engineering', '835267194'),
('ST240071', 'Lakshmi Narang', 'Pune, Pune, Maharashtra', '9512345678', 'ST240071.jpg', 'st240071@iit.ac.in', 'lakshminarang24071@gmail.com', '2004-01-11', 'Female', 1, 'Chemical Engineering', '906435782'),
('ST240072', 'Aditya Bachchan', 'Gurgaon, Gurgaon, Haryana', '9587654321', 'ST240072.jpg', 'st240072@iit.ac.in', 'adityabachchan24072@gmail.com', '2005-02-12', 'Male', 1, 'Mechanical Engineering', '372149680'),
('ST240073', 'Aadhya Ghosh', 'Delhi, Delhi, Delhi', '9565432109', 'ST240073.jpg', 'st240073@iit.ac.in', 'aadhyaghosh24073@gmail.com', '2004-03-13', 'Female', 1, 'Chemical Engineering', '689247531'),
('ST240074', 'Mohith Kashyap', 'Chennai, Chennai, Tamil Nadu', '9532109876', 'ST240074.jpg', 'st240074@iit.ac.in', 'mohithkashyap24074@gmail.com', '2005-04-14', 'Male', 1, 'Mechanical Engineering', '214690853'),
('ST240075', 'Ananya Dhawan', 'Kolkata, Kolkata, West Bengal', '9523456780', 'ST240075.jpg', 'st240075@iit.ac.in', 'ananyadhawan24075@gmail.com', '2004-05-15', 'Female', 1, 'Civil Engineering', '873951240'),
('ST240076', 'Charan Arora', 'Bhopal, Bhopal, Madhya Pradesh', '9510987654', 'ST240076.jpg', 'st240076@iit.ac.in', 'charanarora24076@gmail.com', '2005-06-16', 'Male', 1, 'Civil Engineering', '406728951'),
('ST240077', 'Aayush Mathews', 'Jaipur, Jaipur, Rajasthan', '9509876543', 'ST240077.jpg', 'st240077@iit.ac.in', 'aayushmathews24077@gmail.com', '2004-07-17', 'Male', 1, 'Mechanical Engineering', '275149863'),
('ST240078', 'Gautami Sharma', 'Delhi, Delhi, Delhi', '9498765432', 'ST240078.jpg', 'st240078@iit.ac.in', 'gautamisharma24078@gmail.com', '2005-08-18', 'Female', 1, 'Chemical Engineering', '159240378'),
('ST240079', 'Anand Dubey', 'Pune, Pune, Maharashtra', '9487654321', 'ST240079.jpg', 'st240079@iit.ac.in', 'ananddubey24079@gmail.com', '2004-09-19', 'Male', 1, 'Civil Engineering', '847916302'),
('ST240080', 'Radha Naidu', 'Kolkata, Kolkata, West Bengal', '9476543210', 'ST240080.jpg', 'st240080@iit.ac.in', 'radhanidu24080@gmail.com', '2005-10-20', 'Female', 1, 'Chemical Engineering', '268974153'),
('ST240081', 'Aadhya Pandey', 'Chennai, Chennai, Tamil Nadu', '9465432109', 'ST240081.jpg', 'st240081@iit.ac.in', 'aadhyapandey24081@gmail.com', '2004-11-21', 'Female', 1, 'Mechanical Engineering', '493682715'),
('ST240082', 'Mohith Thakur', 'Gurgaon, Gurgaon, Haryana', '9454321098', 'ST240082.jpg', 'st240082@iit.ac.in', 'mohitthakur24082@gmail.com', '2005-12-22', 'Male', 1, 'Civil Engineering', '738915024'),
('ST240083', 'Charan Singh', 'Bhopal, Bhopal, Madhya Pradesh', '9443210987', 'ST240083.jpg', 'st240083@iit.ac.in', 'charansingh24083@gmail.com', '2004-01-23', 'Male', 1, 'Mechanical Engineering', '985362740'),
('ST240084', 'Ananya Ghosh', 'Delhi, Delhi, Delhi', '9432109876', 'ST240084.jpg', 'st240084@iit.ac.in', 'ananyaghosh24084@gmail.com', '2005-02-24', 'Female', 1, 'Chemical Engineering', '204853197'),
('ST240085', 'Aayush Kashyap', 'Kolkata, Kolkata, West Bengal', '9421098765', 'ST240085.jpg', 'st240085@iit.ac.in', 'aayushkashyap24085@gmail.com', '2004-03-25', 'Male', 1, 'Civil Engineering', '761049283'),
('ST240086', 'Lakshmi Dubey', 'Jaipur, Jaipur, Rajasthan', '9410987654', 'ST240086.jpg', 'st240086@iit.ac.in', 'lakshmidubey24086@gmail.com', '2005-04-26', 'Female', 1, 'Mechanical Engineering', '139275804'),
('ST240087', 'Aditya Narang', 'Delhi, Delhi, Delhi', '9409876543', 'ST240087.jpg', 'st240087@iit.ac.in', 'adityanarang24087@gmail.com', '2004-05-27', 'Male', 1, 'Chemical Engineering', '478920563'),
('ST240088', 'Radha Sharma', 'Gurgaon, Gurgaon, Haryana', '9398765432', 'ST240088.jpg', 'st240088@iit.ac.in', 'radhasharma24088@gmail.com', '2005-06-28', 'Female', 1, 'Mechanical Engineering', '630159472'),
('ST240089', 'Mohith Ghosh', 'Chennai, Chennai, Tamil Nadu', '9387654321', 'ST240089.jpg', 'st240089@iit.ac.in', 'mohithghosh24089@gmail.com', '2004-07-29', 'Male', 1, 'Civil Engineering', '271548690'),
('ST240090', 'Anand Dhawan', 'Bhopal, Bhopal, Madhya Pradesh', '9376543210', 'ST240090.jpg', 'st240090@iit.ac.in', 'ananddhawan24090@gmail.com', '2005-08-30', 'Male', 1, 'Chemical Engineering', '804392157'),
('ST240091', 'Gautami Naidu', 'Kolkata, Kolkata, West Bengal', '9365432109', 'ST240091.jpg', 'st240091@iit.ac.in', 'gautaminaidu24091@gmail.com', '2004-09-30', 'Female', 1, 'Mechanical Engineering', '583410962'),
('ST240092', 'Aadhya Pandey', 'Delhi, Delhi, Delhi', '9354321098', 'ST240092.jpg', 'st240092@iit.ac.in', 'aadhyapandey24092@gmail.com', '2005-10-01', 'Female', 1, 'Civil Engineering', '426789503'),
('ST240093', 'Aditya Bachchan', 'Gurgaon, Gurgaon, Haryana', '9343210987', 'ST240093.jpg', 'st240093@iit.ac.in', 'adityabachchan24093@gmail.com', '2004-11-02', 'Male', 1, 'Chemical Engineering', '750193824'),
('ST240094', 'Charan Teja', 'Anantapur, Andhra Pradesh', '9332109876', 'ST240094.jpg', 'st240094@iit.ac.in', 'charanteja24094@gmail.com', '2005-12-03', 'Male', 1, 'Mechanical Engineering', '910624358'),
('ST240095', 'Mohith Arora', 'Chennai, Chennai, Tamil Nadu', '9321098765', 'ST240095.jpg', 'st240095@iit.ac.in', 'mohitharora24095@gmail.com', '2004-01-04', 'Male', 1, 'Chemical Engineering', '284073695'),
('ST240096', 'Manju Bhargav', 'Chittor, Andhra Pradesh', '9310987654', 'ST240096.jpg', 'st240096@iit.ac.in', 'manjubhargav24096@gmail.com', '2005-02-05', 'Male', 1, 'Mechanical Engineering', '672438519'),
('ST240097', 'Aayush Mathews', 'Delhi, Delhi, Delhi', '9309876543', 'ST240097.jpg', 'st240097@iit.ac.in', 'aayushmathews24097@gmail.com', '2004-03-06', 'Male', 1, 'Civil Engineering', '358120749'),
('ST240098', 'Radha Dubey', 'Jaipur, Jaipur, Rajasthan', '9298765432', 'ST240098.jpg', 'st240098@iit.ac.in', 'radhadubey24098@gmail.com', '2005-04-07', 'Female', 1, 'Chemical Engineering', '194627380'),
('ST240099', 'Aditya Yadav', 'Gurgaon, Gurgaon, Haryana', '9287654321', 'ST240099.jpg', 'st240099@iit.ac.in', 'adityayadav24099@gmail.com', '2004-05-08', 'Male', 1, 'Mechanical Engineering', '908215763'),
('ST240100', 'Aadhya Mathews', 'Chennai, Chennai, Tamil Nadu', '9276543210', 'ST240100.jpg', 'st240100@iit.ac.in', 'aadhyamathews240100@gmail.com', '2005-06-09', 'Female', 1, 'Chemical Engineering', '753942681');

-- --------------------------------------------------------

--
-- Table structure for table `Wardens`
--

CREATE TABLE `Wardens` (
  `warden_id` varchar(11) NOT NULL,
  `warden_name` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `photo` varchar(100) DEFAULT 'warden.jpg',
  `email` varchar(100) NOT NULL,
  `hall_id` int(11) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Wardens`
--

INSERT INTO `Wardens` (`warden_id`, `warden_name`, `phone`, `photo`, `email`, `hall_id`, `password`) VALUES
('WD999991', 'Rohit Sharma', '9876543210', 'warden.jpg', 'rohit4545@gmail.com', 1, 'rohit4455'),
('WD999992', 'K Lokesh Rahul', '7654321098', 'warden.jpg', 'rahul0101@gmail.com', 2, 'rahul0011'),
('WD999993', 'Sita Sharma', '8765432109', 'warden.jpg', 'sitasharma@example.com', 3, 'sita333'),
('WD999994', 'Anjali Patel', '6543210987', 'warden.jpg', 'anjalipatel@example.com', 4, 'anjali444');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Chairman`
--
ALTER TABLE `Chairman`
  ADD PRIMARY KEY (`chairman_id`);

--
-- Indexes for table `Complaints`
--
ALTER TABLE `Complaints`
  ADD PRIMARY KEY (`complaint_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `hall_id` (`hall_id`);

--
-- Indexes for table `Expenditures`
--
ALTER TABLE `Expenditures`
  ADD PRIMARY KEY (`expenditure_id`),
  ADD KEY `hall_id` (`hall_id`);

--
-- Indexes for table `Halls`
--
ALTER TABLE `Halls`
  ADD PRIMARY KEY (`hall_id`);

--
-- Indexes for table `MessManager`
--
ALTER TABLE `MessManager`
  ADD PRIMARY KEY (`mess_manager_id`);

--
-- Indexes for table `Rooms`
--
ALTER TABLE `Rooms`
  ADD PRIMARY KEY (`hall_id`,`room_number`);

--
-- Indexes for table `Staff`
--
ALTER TABLE `Staff`
  ADD PRIMARY KEY (`staff_id`),
  ADD KEY `hall_id` (`hall_id`);

--
-- Indexes for table `StaffManager`
--
ALTER TABLE `StaffManager`
  ADD PRIMARY KEY (`staff_manager_id`);

--
-- Indexes for table `StudentHallDetails`
--
ALTER TABLE `StudentHallDetails`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `hall_id` (`hall_id`);

--
-- Indexes for table `StudentPersonalDetails`
--
ALTER TABLE `StudentPersonalDetails`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `Wardens`
--
ALTER TABLE `Wardens`
  ADD PRIMARY KEY (`warden_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `hall_id` (`hall_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Complaints`
--
ALTER TABLE `Complaints`
  MODIFY `complaint_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Expenditures`
--
ALTER TABLE `Expenditures`
  MODIFY `expenditure_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Halls`
--
ALTER TABLE `Halls`
  MODIFY `hall_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Complaints`
--
ALTER TABLE `Complaints`
  ADD CONSTRAINT `Complaints_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `StudentHallDetails` (`student_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `Complaints_ibfk_2` FOREIGN KEY (`hall_id`) REFERENCES `Halls` (`hall_id`) ON DELETE CASCADE;

--
-- Constraints for table `Expenditures`
--
ALTER TABLE `Expenditures`
  ADD CONSTRAINT `Expenditures_ibfk_1` FOREIGN KEY (`hall_id`) REFERENCES `Halls` (`hall_id`);

--
-- Constraints for table `Rooms`
--
ALTER TABLE `Rooms`
  ADD CONSTRAINT `Rooms_ibfk_1` FOREIGN KEY (`hall_id`) REFERENCES `Halls` (`hall_id`) ON DELETE CASCADE;

--
-- Constraints for table `Staff`
--
ALTER TABLE `Staff`
  ADD CONSTRAINT `Staff_ibfk_1` FOREIGN KEY (`hall_id`) REFERENCES `Halls` (`hall_id`);

--
-- Constraints for table `StudentHallDetails`
--
ALTER TABLE `StudentHallDetails`
  ADD CONSTRAINT `StudentHallDetails_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `StudentPersonalDetails` (`student_id`),
  ADD CONSTRAINT `StudentHallDetails_ibfk_2` FOREIGN KEY (`hall_id`) REFERENCES `Halls` (`hall_id`);

--
-- Constraints for table `Wardens`
--
ALTER TABLE `Wardens`
  ADD CONSTRAINT `Wardens_ibfk_1` FOREIGN KEY (`hall_id`) REFERENCES `Halls` (`hall_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
