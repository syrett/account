-- phpMyAdmin SQL Dump
-- version 3.3.2deb1ubuntu1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 11, 2013 at 08:25 PM
-- Server version: 5.1.66
-- PHP Version: 5.3.2-1ubuntu4.18

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `account`
--

-- --------------------------------------------------------

--
-- Table structure for table `transition`
--

CREATE TABLE IF NOT EXISTS `transition` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entry_num_prefix` varchar(10) DEFAULT NULL,
  `entry_num` int(11) NOT NULL,
  `entry_date` int(11) NOT NULL DEFAULT '0',
  `entry_memo` varchar(100) DEFAULT NULL,
  `entry_transaction` tinyint(1) NOT NULL,
  `entry_subject` int(11) NOT NULL,
  `entry_amount` int(11) NOT NULL,
  `entry_appendix` varchar(100) DEFAULT NULL,
  `entry_editor` int(11) NOT NULL,
  `entry_reviewer` int(11) NOT NULL,
  `entry_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `entry_reviewed` tinyint(1) NOT NULL DEFAULT '0',
  `entry_posting` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `entry_closing` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `subject_id_idx` (`entry_subject`),
  KEY `re_employee_id_idx` (`entry_reviewer`),
  KEY `ed_employee_id_idx` (`entry_editor`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=63 ;

--
-- Dumping data for table `transition`
--

INSERT INTO `transition` (`id`, `entry_num_prefix`, `entry_num`, `entry_date`, `entry_memo`, `entry_transaction`, `entry_subject`, `entry_amount`, `entry_appendix`, `entry_editor`, `entry_reviewer`, `entry_deleted`, `entry_reviewed`, `entry_posting`, `entry_closing`) VALUES
(1, '201312', 5, 1386663409, 'ddd', 2, 2202, 111, '11', 1, 1, 0, 0, 0, 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transition`
--
ALTER TABLE `transition`
  ADD CONSTRAINT `transition_ibfk_1` FOREIGN KEY (`entry_subject`) REFERENCES `subjects` (`sbj_number`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `re_employee_id` FOREIGN KEY (`entry_reviewer`) REFERENCES `employee` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
