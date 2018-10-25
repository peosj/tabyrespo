-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 17, 2016 at 07:20 AM
-- Server version: 5.5.24-log
-- PHP Version: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `echeck`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `admin_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `emp_id` varchar(222) NOT NULL,
  `user_type` varchar(222) NOT NULL,
  `name` varchar(222) NOT NULL,
  `email` varchar(222) NOT NULL,
  `phone` varchar(222) NOT NULL,
  `city` varchar(222) NOT NULL,
  `state` varchar(222) NOT NULL,
  `address` varchar(222) NOT NULL,
  `pic` varchar(222) NOT NULL,
  `password` varchar(222) NOT NULL,
  `confirm_password` varchar(222) NOT NULL,
  `status` varchar(222) NOT NULL,
  `date` varchar(222) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `emp_id`, `user_type`, `name`, `email`, `phone`, `city`, `state`, `address`, `pic`, `password`, `confirm_password`, `status`, `date`, `timestamp`) VALUES
(1, '1001', 'admin', 'Satish Singh', 'satish@tratoindia.com', '9811008698', 'South West Delhi', '', 'Laxmi Nagar', '', '1001', '1001', '1', '2016-09-02', '2016-09-02 12:29:02'),
(3, '1002', 'admin', 'Saurabh Singh', 'satish@tratoindia.com', '9811008698', 'South West Delhi', 'South Delhi', 'Laxmi Nagar', '', '1002', '1002', '1', '2016-09-02', '2016-09-02 12:43:25'),
(7, '1003', 'admin', 'Satish', 'satish@tratoindia.com', '9811008698', 'South west delhi', '', 'Goyla vihar', '', '1003', '1003', '1', '2016-09-02', '2016-09-02 13:27:46');

-- --------------------------------------------------------

--
-- Table structure for table `cheque`
--

CREATE TABLE IF NOT EXISTS `cheque` (
  `cheque_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(22) NOT NULL,
  `name_on_account` varchar(222) NOT NULL,
  `email` varchar(222) NOT NULL,
  `phone` varchar(222) NOT NULL,
  `address` varchar(222) NOT NULL,
  `city` varchar(222) NOT NULL,
  `state` varchar(222) NOT NULL,
  `zip` varchar(222) NOT NULL,
  `bank_name` varchar(222) NOT NULL,
  `amount` varchar(222) NOT NULL,
  `checking_account_number` varchar(222) NOT NULL,
  `routing_number` varchar(222) NOT NULL,
  `cheque_number` varchar(222) NOT NULL,
  `cheque_status` varchar(222) NOT NULL,
  `date` varchar(222) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`cheque_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `cheque`
--

INSERT INTO `cheque` (`cheque_id`, `user_id`, `name_on_account`, `email`, `phone`, `address`, `city`, `state`, `zip`, `bank_name`, `amount`, `checking_account_number`, `routing_number`, `cheque_number`, `cheque_status`, `date`, `timestamp`) VALUES
(1, 1002, 'Jitender Raghav', 'jktech11@gmail.com', '8802103824', 'sfsdfs fsdf sfsdf s', 'Chennai', 'Selangor', '110093', 'HDFC', '1000000', '123456789', '12345678', '123456789', 'Pending', '2016-09-16', '2016-09-16 01:25:33'),
(2, 1002, 'Jitender', 'jktech11@gmail.com', '8802103824', 'Nacon''s center, No. 01, 1st Floor, K.R. Road', 'Chennai', 'Selangor', '110093', 'HDFC', '1000000', '123456789', '12345678', '123456789', 'Pending', '2016-09-16', '2016-09-16 02:29:24');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `comment_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(22) NOT NULL,
  `cheque_id` varchar(222) NOT NULL,
  `comment` text NOT NULL,
  `date` varchar(222) NOT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`comment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`comment_id`, `user_id`, `cheque_id`, `comment`, `date`, `timestamp`) VALUES
(1, 1001, '1', 'test', '2016-09-16', '2016-09-16 01:56:36');

-- --------------------------------------------------------

--
-- Table structure for table `managers`
--

CREATE TABLE IF NOT EXISTS `managers` (
  `sno` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `emp_id` varchar(200) NOT NULL,
  `manager` varchar(200) NOT NULL,
  PRIMARY KEY (`sno`),
  UNIQUE KEY `sno` (`sno`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `managers`
--

INSERT INTO `managers` (`sno`, `emp_id`, `manager`) VALUES
(1, '11', '11'),
(15, '1001', '11'),
(14, '1001', '11'),
(16, '1002', '11'),
(17, '1002', '11'),
(18, '1002', '11'),
(19, '1002', '11');

-- --------------------------------------------------------

--
-- Table structure for table `support`
--

CREATE TABLE IF NOT EXISTS `support` (
  `support_id` int(222) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `user_type` varchar(222) NOT NULL,
  `registered_email` varchar(222) NOT NULL,
  `transaction_id` varchar(222) NOT NULL,
  `support_type` varchar(222) NOT NULL,
  `ticket_type` varchar(222) NOT NULL,
  `date` varchar(222) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`support_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `support`
--

INSERT INTO `support` (`support_id`, `user_id`, `user_type`, `registered_email`, `transaction_id`, `support_type`, `ticket_type`, `date`, `timestamp`) VALUES
(1, 1002, 'user', 'satish@tratoindia.com', '11dfd21', 'Billing Department', 'Closed', '2016-09-17', '2016-09-17 06:31:31');

-- --------------------------------------------------------

--
-- Table structure for table `support_comment`
--

CREATE TABLE IF NOT EXISTS `support_comment` (
  `support_comment_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `support_id` int(22) NOT NULL,
  `user_id` int(22) NOT NULL,
  `user_type` varchar(222) NOT NULL,
  `comment` text NOT NULL,
  `date` varchar(222) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `support_comment_id` (`support_comment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `support_comment`
--

INSERT INTO `support_comment` (`support_comment_id`, `support_id`, `user_id`, `user_type`, `comment`, `date`, `timestamp`) VALUES
(1, 1, 1002, 'user', 'e', '2016-09-17', '2016-09-17 06:31:31'),
(2, 1, 1001, 'admin', 'cv', '2016-09-17', '2016-09-17 07:01:36'),
(3, 1, 1001, 'admin', 'tdsfkjsdfhjsd fkdshk', '2016-09-17', '2016-09-17 07:01:57'),
(4, 1, 1002, 'user', 'test', '2016-09-17', '2016-09-17 07:09:17'),
(5, 1, 1002, 'user', 'sdjfdsi fkdsfw iu', '2016-09-17', '2016-09-17 07:11:46'),
(6, 1, 1002, 'user', 'dsfghs fishfi', '2016-09-17', '2016-09-17 07:13:53'),
(7, 1, 1001, 'admin', 'test', '2016-09-17', '2016-09-17 07:16:56'),
(8, 1, 1001, 'admin', 'test', '2016-09-17', '2016-09-17 07:17:52');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_type` varchar(222) NOT NULL,
  `f_name` varchar(222) NOT NULL,
  `l_name` varchar(222) NOT NULL,
  `company_name` varchar(222) NOT NULL,
  `email` varchar(222) NOT NULL,
  `contact_number` varchar(222) NOT NULL,
  `address` varchar(222) NOT NULL,
  `business_type` varchar(222) NOT NULL,
  `password` varchar(222) NOT NULL,
  `billing_cycle` varchar(222) NOT NULL,
  `bank_name` varchar(222) NOT NULL,
  `bank_address` varchar(222) NOT NULL,
  `name_on_bank_account` varchar(222) NOT NULL,
  `ifsc_code` varchar(222) NOT NULL,
  `swift_code` varchar(222) NOT NULL,
  `status` varchar(222) NOT NULL,
  `date` varchar(222) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1007 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_type`, `f_name`, `l_name`, `company_name`, `email`, `contact_number`, `address`, `business_type`, `password`, `billing_cycle`, `bank_name`, `bank_address`, `name_on_bank_account`, `ifsc_code`, `swift_code`, `status`, `date`, `timestamp`) VALUES
(1002, 'user', 'Jitender', 'Raghav', 'Trato India', 'satish@tratoindia.com', '9811008698', 'Ho-No - 26,Block-A,Goyla Vihar,New Delhi', 'Company secretary', '1002', 'Test1', 'State Bank Of India', 'Pushpa Bhawan', 'Satish Singh', 'SBI8769', 'SBI8769', '1', '2016-09-07', '2016-09-02 11:46:55'),
(1004, 'user', 'Saurabh', 'Singh', 'Trato India', 'saurabh@gmail.com', '8990777790', 'Laxmi Nagar', 'Software Developer', '1004', 'Test11', 'Panjab National Bank', 'Laxmi Nagar', 'saurabh', 'SBI876934', 'SBI8734', '1', '2016-09-02', '2016-09-02 12:02:33'),
(1005, 'user', 'Rajeev', 'Kumar', 'Trato India', 'rajeev@hikesoftwares.com', '9811008698', 'Goyla vihar', 'Technical support', '1005', 'Yes', 'State bank of india', 'Goyla vihar', 'Rajeev', 'SBI87676', 'SBI235454', '1', '2016-09-05', '2016-09-05 06:14:34'),
(1006, 'user', 'Prince', 'Arora', 'Trato India', 'prince@tratoindia.com', '987787575786', 'Laxmi Nagar', 'Technical support', '1006', 'yes', 'State bank of india', 'Laxmi Nagar', 'Prince', 'SBI876743', 'SBI235455', '1', '2016-09-05', '2016-09-05 06:20:05');

-- --------------------------------------------------------

--
-- Table structure for table `user_hierarchy`
--

CREATE TABLE IF NOT EXISTS `user_hierarchy` (
  `sno` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(222) NOT NULL,
  `value` varchar(222) NOT NULL,
  `usual_name` varchar(222) NOT NULL,
  `priority` varchar(222) NOT NULL,
  UNIQUE KEY `sno` (`sno`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `user_hierarchy`
--

INSERT INTO `user_hierarchy` (`sno`, `name`, `value`, `usual_name`, `priority`) VALUES
(1, 'Admin', 'admin', 'M8', '70'),
(2, 'VH', 'vh', 'M6', '60'),
(3, 'ZSM', 'zsm', 'M5', '50'),
(4, 'RSM', 'rsm', 'M4', '40'),
(5, 'SASM', 'sasm', 'M3', '30'),
(6, 'ASM', 'asm', 'M2', '20'),
(7, 'RM', 'rm', 'M1', '10'),
(8, 'Director', 'director', 'M7', '65');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
