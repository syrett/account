-- phpMyAdmin SQL Dump
-- version 3.3.2deb1ubuntu1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2013 年 12 月 06 日 21:10
-- 服务器版本: 5.1.66
-- PHP 版本: 5.3.2-1ubuntu4.18

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `account`
--

-- --------------------------------------------------------

--
-- 表的结构 `client`
--

CREATE TABLE IF NOT EXISTS `client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vat` varchar(45) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `add` varchar(100) DEFAULT NULL,
  `memo` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `client`
--


-- --------------------------------------------------------

--
-- 表的结构 `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `memo` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `department`
--


-- --------------------------------------------------------

--
-- 表的结构 `employee`
--

CREATE TABLE IF NOT EXISTS `employee` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `memo` varchar(200) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `employee`
--


-- --------------------------------------------------------

--
-- 表的结构 `options`
--

CREATE TABLE IF NOT EXISTS `options` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `support` varchar(100) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `entrynum` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `options`
--


-- --------------------------------------------------------

--
-- 表的结构 `project`
--

CREATE TABLE IF NOT EXISTS `project` (
  `id` int(11) NOT NULL,
  `name` varchar(60) DEFAULT NULL,
  `memo` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `project`
--


-- --------------------------------------------------------

--
-- 表的结构 `subject`
--

CREATE TABLE IF NOT EXISTS `subject` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no` int(12) NOT NULL DEFAULT '0',
  `name` varchar(256) CHARACTER SET gbk COLLATE gbk_bin DEFAULT NULL,
  `category` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `no` (`no`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- 转存表中的数据 `subject`
--

INSERT INTO `subject` (`id`, `no`, `name`, `category`) VALUES
(1, 1001, '库存现金', 1),
(2, 1002, '银行存款', 1),
(3, 1003, '存放中央银行款项', 1),
(4, 1102, '短期投资跌价准备', 1),
(5, 100101, '库存现金01', 1),
(6, 100102, '库存现金02', 1),
(7, 1021, '结算备付金', 1),
(8, 1031, '存出保证金', 1),
(9, 1101, '交易性金融资产', 1),
(10, 1111, '买入返售金融资产', 1),
(11, 1121, '应收票据', 1),
(12, 1122, '应收账款', 1);

-- --------------------------------------------------------

--
-- 表的结构 `subjects`
--

CREATE TABLE IF NOT EXISTS `subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sbj_number` int(12) NOT NULL DEFAULT '0',
  `sbj_name` varchar(20) DEFAULT NULL,
  `sbj_cat` varchar(100) DEFAULT NULL,
  `sub_table` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `No` (`sbj_number`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- 转存表中的数据 `subjects`
--

INSERT INTO `subjects` (`id`, `sbj_number`, `sbj_name`, `sbj_cat`, `sub_table`) VALUES
(1, 1001, '库存现金', '1', ''),
(2, 1002, '银行存款', '1', NULL),
(3, 1003, '存放中央银行款项', '1', NULL),
(4, 1102, '短期投资跌价准备', '1', NULL),
(8, 1, '', '1', ''),
(9, 1021, '结算备付金', '1', ''),
(10, 0, 'wer', '12', ''),
(14, 12, '', '2', '');

-- --------------------------------------------------------

--
-- 表的结构 `transition`
--

CREATE TABLE IF NOT EXISTS `transition` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entry_num_prefix` varchar(10) DEFAULT NULL,
  `entry_num` int(11) NOT NULL,
  `entry_date` datetime NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `transition`
--


-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `userid` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `email` varchar(20) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `sys_role` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `users`
--


-- --------------------------------------------------------

--
-- 表的结构 `vendor`
--

CREATE TABLE IF NOT EXISTS `vendor` (
  `id` int(11) NOT NULL,
  `vat` varchar(45) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `add` varchar(100) DEFAULT NULL,
  `memo` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `vendor`
--


--
-- 限制导出的表
--

--
-- 限制表 `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `department_id` FOREIGN KEY (`id`) REFERENCES `department` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- 限制表 `transition`
--
ALTER TABLE `transition`
  ADD CONSTRAINT `subject_id` FOREIGN KEY (`entry_subject`) REFERENCES `subjects` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `ed_employee_id` FOREIGN KEY (`entry_editor`) REFERENCES `employee` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `re_employee_id` FOREIGN KEY (`entry_reviewer`) REFERENCES `employee` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
