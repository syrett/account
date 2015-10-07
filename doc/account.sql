-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2015-10-07 16:05:08
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `account_201509174311`
--

-- --------------------------------------------------------

--
-- 表的结构 `bank`
--

CREATE TABLE IF NOT EXISTS `bank` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_no` varchar(16) NOT NULL,
  `type` varchar(16) DEFAULT NULL COMMENT '类型：采购、销售、工资、报销等',
  `pid` int(11) NOT NULL COMMENT '采购、销售、报销、工资等',
  `target` varchar(512) DEFAULT NULL COMMENT '交易对象',
  `date` varchar(64) DEFAULT NULL COMMENT '日期',
  `memo` text COMMENT '说明',
  `amount` float NOT NULL COMMENT '金额',
  `parent` int(11) DEFAULT NULL COMMENT '父，相关',
  `subject` varchar(16) DEFAULT NULL COMMENT '科目',
  `subject_2` int(12) DEFAULT NULL,
  `invoice` tinyint(4) DEFAULT '0' COMMENT '有无发票',
  `tax` int(8) DEFAULT NULL COMMENT '税率',
  `path` varchar(1024) DEFAULT NULL,
  `relation` text NOT NULL,
  `status_id` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1:已经生成凭证 ',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `status_id` (`status_id`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`),
  KEY `parent` (`parent`),
  KEY `sbj_bank` (`subject_2`),
  KEY `sbj_bank_2` (`subject_2`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `bank`
--

INSERT INTO `bank` (`id`, `order_no`, `type`, `pid`, `target`, `date`, `memo`, `amount`, `parent`, `subject`, `subject_2`, `invoice`, `tax`, `path`, `relation`, `status_id`, `created_at`, `updated_at`) VALUES
(1, 'BA2015100001', NULL, 0, 'aaa', '20151007', 'ha', 5000, NULL, '112301', 100201, 0, NULL, '=>支出=>供应商采购=>初始供应商1=>预付款', '', 1, '2015-10-07 04:35:13', 1444192512),
(2, 'BA2015100002', 'purchase', 2, 'aaa', '20151007', 'asdf', 500, NULL, '220202', 100201, 0, NULL, '=>支出=>供应商采购=>初始供应商1=>PO2015100002', '{"purchase":"2"}', 1, '2015-10-07 04:40:46', 1444192846);

-- --------------------------------------------------------

--
-- 表的结构 `cash`
--

CREATE TABLE IF NOT EXISTS `cash` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_no` varchar(16) NOT NULL,
  `type` varchar(16) DEFAULT NULL COMMENT '类型：采购、销售、工资、报销等',
  `pid` int(11) NOT NULL COMMENT '采购、销售、报销、工资等',
  `target` varchar(512) DEFAULT NULL COMMENT '交易对象',
  `date` varchar(64) DEFAULT NULL COMMENT '日期',
  `memo` text COMMENT '说明',
  `amount` float NOT NULL COMMENT '金额',
  `parent` int(11) DEFAULT NULL COMMENT '父，相关',
  `subject` varchar(16) DEFAULT NULL COMMENT '科目',
  `subject_2` int(12) DEFAULT NULL,
  `invoice` tinyint(4) DEFAULT '0' COMMENT '有无发票',
  `tax` int(8) DEFAULT NULL COMMENT '税率',
  `relation` text NOT NULL,
  `path` varchar(1024) DEFAULT NULL,
  `status_id` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1:已经生成凭证 ',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `status_id` (`status_id`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`),
  KEY `parent` (`parent`),
  KEY `sbj_bank` (`subject_2`),
  KEY `sbj_bank_2` (`subject_2`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `cash`
--

INSERT INTO `cash` (`id`, `order_no`, `type`, `pid`, `target`, `date`, `memo`, `amount`, `parent`, `subject`, `subject_2`, `invoice`, `tax`, `relation`, `path`, `status_id`, `created_at`, `updated_at`) VALUES
(1, '', NULL, 0, 'b公司', '20150927', 'ha', 5000, NULL, '660302', 1001, 0, NULL, '', '=>收入=>利息收入=>利息费用', 1, '2015-09-27 07:27:48', 1443338865);

-- --------------------------------------------------------

--
-- 表的结构 `client`
--

CREATE TABLE IF NOT EXISTS `client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company` varchar(256) NOT NULL,
  `vat` varchar(45) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `add` varchar(100) DEFAULT NULL,
  `memo` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `client`
--

INSERT INTO `client` (`id`, `company`, `vat`, `phone`, `add`, `memo`) VALUES
(1, '初始客户1', NULL, NULL, NULL, NULL),
(2, '联通', NULL, NULL, NULL, NULL),
(3, '电信', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- 替换视图以便查看 `condomdate`
--
CREATE TABLE IF NOT EXISTS `condomdate` (
`date` varchar(10)
);
-- --------------------------------------------------------

--
-- 表的结构 `cost`
--

CREATE TABLE IF NOT EXISTS `cost` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_no` varchar(16) NOT NULL COMMENT '订单号',
  `entry_date` varchar(16) NOT NULL COMMENT '销售日期',
  `entry_name` varchar(512) NOT NULL COMMENT '商品名称',
  `stocks` varchar(512) NOT NULL COMMENT '商品清单',
  `stocks_count` varchar(512) NOT NULL COMMENT '对应数量',
  `stocks_price` varchar(512) NOT NULL COMMENT '对应当时计算价格',
  `entry_amount` float NOT NULL COMMENT '成本',
  `subject` int(11) DEFAULT NULL,
  `subject_2` varchar(512) DEFAULT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` int(11) NOT NULL,
  `status_id` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `subject_2` (`subject_2`(255)),
  KEY `subject` (`subject`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- 转存表中的数据 `cost`
--

INSERT INTO `cost` (`id`, `order_no`, `entry_date`, `entry_name`, `stocks`, `stocks_count`, `stocks_price`, `entry_amount`, `subject`, `subject_2`, `create_time`, `update_time`, `status_id`) VALUES
(25, 'SO2015090001', '20150928', 'b公司', '办公桌\r\n电脑', '2\r\n1', '1186.05\r\n5000.00', 7372.1, 640106, '1405', '2015-10-07 05:37:35', 0, 1);

-- --------------------------------------------------------

--
-- 表的结构 `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `type` int(11) NOT NULL COMMENT '1\\2\\3\\4 为生产部门、管理部门、销售部门 、研发部门',
  `position` varchar(32) DEFAULT NULL COMMENT '职位',
  `memo` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `department`
--

INSERT INTO `department` (`id`, `name`, `type`, `position`, `memo`) VALUES
(1, '研发部', 4, NULL, '研发部'),
(2, '生产厂区部门', 1, NULL, ''),
(3, '行政管理', 2, NULL, ''),
(4, '销售人员部门', 3, NULL, '');

-- --------------------------------------------------------

--
-- 表的结构 `employee`
--

CREATE TABLE IF NOT EXISTS `employee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `position` varchar(512) DEFAULT NULL,
  `base` float DEFAULT NULL COMMENT '社保基数',
  `base_2` float NOT NULL COMMENT '公积金基数',
  `memo` varchar(200) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `departure_date` datetime DEFAULT NULL COMMENT '离职日期',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '0离职，1正常，2停职，3兼职',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `employee`
--

INSERT INTO `employee` (`id`, `name`, `position`, `base`, `base_2`, `memo`, `department_id`, `departure_date`, `status`) VALUES
(1, '张三', '', 2000, 0, '', 2, NULL, 1),
(2, '李四', '', 800, 0, '', 1, NULL, 1),
(3, 'fff', NULL, NULL, 0, NULL, 2, NULL, 1),
(4, 'tttt', NULL, NULL, 0, NULL, 1, NULL, 1);

-- --------------------------------------------------------

--
-- 表的结构 `meta`
--

CREATE TABLE IF NOT EXISTS `meta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `option` varchar(32) CHARACTER SET utf8 NOT NULL COMMENT '属性名称',
  `value` varchar(256) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `meta`
--

INSERT INTO `meta` (`id`, `option`, `value`) VALUES
(1, 'transitionDate', '201401');

-- --------------------------------------------------------

--
-- 表的结构 `options`
--

CREATE TABLE IF NOT EXISTS `options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entry_subject` int(16) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `support` varchar(100) DEFAULT NULL,
  `year` int(16) NOT NULL DEFAULT '1' COMMENT '折旧或摊销年限',
  `value` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`entry_subject`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `entry_subject` (`entry_subject`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `options`
--

INSERT INTO `options` (`id`, `entry_subject`, `name`, `support`, `year`, `value`) VALUES
(1, 1701, NULL, NULL, 10, 5),
(2, 1801, NULL, NULL, 5, 5),
(3, 160101, NULL, NULL, 3, 5),
(4, 160102, NULL, NULL, 5, 5),
(5, 160103, NULL, NULL, 4, 5),
(6, 160104, NULL, NULL, 10, 5),
(7, 160105, NULL, NULL, 20, 5);

-- --------------------------------------------------------

--
-- 表的结构 `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject_id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `balance` double NOT NULL,
  `posted` tinyint(1) NOT NULL DEFAULT '0',
  `debit` double NOT NULL DEFAULT '0' COMMENT '借',
  `credit` double NOT NULL DEFAULT '0' COMMENT '贷',
  `post_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_subject_id_idx` (`subject_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `post`
--

INSERT INTO `post` (`id`, `subject_id`, `year`, `month`, `balance`, `posted`, `debit`, `credit`, `post_date`) VALUES
(3, 1405, 2015, 8, 8000, 1, 0, 0, '2015-07-31 16:00:00'),
(4, 160101, 2015, 8, 5008, 1, 0, 0, '2015-07-31 16:00:00'),
(5, 200101, 2015, 8, 5008, 1, 0, 0, '2015-07-31 16:00:00'),
(6, 2801, 2015, 8, 8000, 1, 0, 0, '2015-07-31 16:00:00');

-- --------------------------------------------------------

--
-- 表的结构 `preparation`
--

CREATE TABLE IF NOT EXISTS `preparation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_no` varchar(64) NOT NULL,
  `real_order` text,
  `pid` int(11) NOT NULL COMMENT '现金或银行的id',
  `type` varchar(16) NOT NULL COMMENT '现金或银行',
  `entry_amount` float NOT NULL,
  `amount_used` float NOT NULL COMMENT '已使用金额',
  `memo` text,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `preparation`
--

INSERT INTO `preparation` (`id`, `order_no`, `real_order`, `pid`, `type`, `entry_amount`, `amount_used`, `memo`, `create_time`, `status`) VALUES
(1, 'PPO2015100001', '{"PO2015100001":5000}', 1, 'bank', 5000, 5000, NULL, '2015-10-07 04:35:13', 1);

-- --------------------------------------------------------

--
-- 表的结构 `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_no` varchar(16) NOT NULL COMMENT '订单号',
  `entry_date` varchar(16) NOT NULL COMMENT '销售日期',
  `client_id` int(11) NOT NULL COMMENT '客户ID',
  `entry_name` varchar(512) NOT NULL COMMENT '商品名称',
  `entry_memo` varchar(1024) DEFAULT NULL,
  `price` float NOT NULL COMMENT '价格',
  `count` int(11) NOT NULL DEFAULT '1',
  `unit` varchar(32) NOT NULL COMMENT '单位',
  `tax` int(11) NOT NULL COMMENT '税率',
  `paied` float NOT NULL COMMENT '已收金额',
  `subject` int(11) DEFAULT NULL,
  `subject_2` varchar(512) DEFAULT NULL,
  `relation` text NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` int(11) NOT NULL,
  `status_id` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `client_id` (`client_id`),
  KEY `subject_2` (`subject_2`(255)),
  KEY `subject` (`subject`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `product`
--

INSERT INTO `product` (`id`, `order_no`, `entry_date`, `client_id`, `entry_name`, `entry_memo`, `price`, `count`, `unit`, `tax`, `paied`, `subject`, `subject_2`, `relation`, `create_time`, `update_time`, `status_id`) VALUES
(1, 'SO2015090001', '20150928', 1, 'b公司', 'asdf', 2000, 1, '', 3, 0, 600101, '112203', '[]', '2015-09-28 08:23:06', 0, 1);

-- --------------------------------------------------------

--
-- 表的结构 `project`
--

CREATE TABLE IF NOT EXISTS `project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT NULL,
  `memo` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `purchase`
--

CREATE TABLE IF NOT EXISTS `purchase` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_no` varchar(16) NOT NULL COMMENT '订单号',
  `entry_date` varchar(16) NOT NULL COMMENT '采购日期',
  `vendor_id` int(11) NOT NULL COMMENT '供应商ID',
  `entry_name` varchar(512) NOT NULL COMMENT '商品名称',
  `model` varchar(64) DEFAULT NULL COMMENT '型号',
  `entry_memo` varchar(1024) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL COMMENT '如果是公司自己使用，比如固定资产，需要填写部门',
  `price` float NOT NULL COMMENT '价格',
  `count` int(11) NOT NULL DEFAULT '1',
  `unit` varchar(32) DEFAULT NULL COMMENT '单位',
  `tax` int(11) NOT NULL COMMENT '税率',
  `paied` float NOT NULL COMMENT '已付金额',
  `subject` int(11) DEFAULT NULL,
  `subject_2` varchar(512) DEFAULT NULL,
  `relation` text NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` int(11) NOT NULL,
  `status_id` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `vendor_id` (`vendor_id`),
  KEY `subject` (`subject`,`subject_2`(255)),
  KEY `subject_2` (`subject_2`(255)),
  KEY `department_id` (`department_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `purchase`
--

INSERT INTO `purchase` (`id`, `order_no`, `entry_date`, `vendor_id`, `entry_name`, `model`, `entry_memo`, `department_id`, `price`, `count`, `unit`, `tax`, `paied`, `subject`, `subject_2`, `relation`, `create_time`, `update_time`, `status_id`) VALUES
(1, 'PO2015100001', '20151007', 1, '办公桌', '', 'ha', 1, 5000, 1, NULL, 0, 0, 160101, '112301', '[{"bank":"1"}]', '2015-10-07 04:39:15', 0, 1),
(2, 'PO2015100002', '20151007', 1, '办公桌', '', 'ha', 1, 5000, 1, NULL, 0, 0, 1405, '220202', '[]', '2015-10-07 04:39:50', 0, 1);

-- --------------------------------------------------------

--
-- 表的结构 `reimburse`
--

CREATE TABLE IF NOT EXISTS `reimburse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_no` varchar(16) NOT NULL COMMENT '订单号',
  `entry_date` varchar(16) NOT NULL COMMENT '销售日期',
  `entry_memo` varchar(1024) DEFAULT NULL COMMENT '摘要',
  `employee_id` int(11) NOT NULL COMMENT '员工ID',
  `travel_amount` decimal(12,2) DEFAULT NULL COMMENT '差旅费',
  `benefit_amount` decimal(12,2) DEFAULT NULL COMMENT '福利费（餐费等）',
  `traffic_amount` decimal(12,2) DEFAULT NULL COMMENT '交通费',
  `phone_amount` decimal(12,2) DEFAULT NULL COMMENT '通讯费',
  `entertainment_amount` decimal(12,2) DEFAULT NULL COMMENT '招待费',
  `office_amount` decimal(12,2) DEFAULT NULL COMMENT '办公费',
  `rent_amount` decimal(12,2) DEFAULT NULL COMMENT '租金',
  `watere_amount` decimal(12,2) DEFAULT NULL COMMENT '水电费',
  `train_amount` decimal(12,2) DEFAULT NULL COMMENT '培训费',
  `service_amount` decimal(12,2) DEFAULT NULL COMMENT '服务费',
  `stamping_amount` decimal(12,2) DEFAULT NULL COMMENT '印花税',
  `subject` varchar(512) DEFAULT NULL,
  `subject_2` varchar(512) DEFAULT NULL,
  `relation` text NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` int(11) NOT NULL,
  `paid` varchar(1024) DEFAULT NULL COMMENT '已经报销的项目',
  `status_id` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `subject_2` (`subject_2`(255)),
  KEY `subject` (`subject`(255)),
  KEY `employee_id` (`employee_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `reimburse`
--

INSERT INTO `reimburse` (`id`, `order_no`, `entry_date`, `entry_memo`, `employee_id`, `travel_amount`, `benefit_amount`, `traffic_amount`, `phone_amount`, `entertainment_amount`, `office_amount`, `rent_amount`, `watere_amount`, `train_amount`, `service_amount`, `stamping_amount`, `subject`, `subject_2`, `relation`, `create_time`, `update_time`, `paid`, `status_id`) VALUES
(1, 'RE2015100001', '20150905', 'test 3报销', 1, '100.00', '200.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '640108', '224102', '[]', '2015-10-07 05:01:59', 0, NULL, 1),
(2, 'RE2015100002', '20150905', 'test 4报销', 2, '200.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '66020204', '224103', '[]', '2015-10-07 05:01:59', 0, NULL, 1);

-- --------------------------------------------------------

--
-- 表的结构 `salary`
--

CREATE TABLE IF NOT EXISTS `salary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_no` varchar(16) NOT NULL COMMENT '订单号',
  `entry_date` varchar(16) NOT NULL COMMENT '销售日期',
  `employee_id` int(11) NOT NULL COMMENT '员工ID',
  `salary_amount` decimal(12,2) NOT NULL COMMENT '工资',
  `bonus_amount` decimal(12,2) NOT NULL COMMENT '奖金',
  `benefit_amount` decimal(12,2) NOT NULL COMMENT '其他福利',
  `base_amount` decimal(12,2) DEFAULT NULL COMMENT '当时社保基数',
  `social_personal` decimal(12,2) DEFAULT NULL COMMENT '社保个人部分',
  `provident_personal` decimal(12,2) DEFAULT NULL COMMENT '公积金个人部分',
  `personal_tax` decimal(12,2) DEFAULT NULL COMMENT '个人所得税',
  `social_company` decimal(12,2) DEFAULT NULL COMMENT '社保公司部分',
  `provident_company` decimal(12,2) DEFAULT NULL COMMENT '公积金公司部分',
  `subject` int(11) DEFAULT NULL,
  `subject_2` varchar(512) DEFAULT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` int(11) NOT NULL,
  `status_id` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `subject_2` (`subject_2`(255)),
  KEY `subject` (`subject`),
  KEY `employee_id` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `stock`
--

CREATE TABLE IF NOT EXISTS `stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hs_no` varchar(64) DEFAULT NULL COMMENT '编号',
  `order_no` varchar(16) DEFAULT NULL COMMENT '采购订单',
  `order_no_sale` varchar(16) NOT NULL COMMENT '销售订单',
  `name` varchar(512) NOT NULL COMMENT '名字',
  `model` varchar(64) DEFAULT NULL COMMENT '型号',
  `entry_subject` int(11) NOT NULL,
  `vendor_id` int(11) DEFAULT NULL COMMENT '供应商',
  `client_id` int(11) DEFAULT NULL COMMENT '销售动向，客户ID',
  `in_date` varchar(16) NOT NULL COMMENT '日期',
  `in_price` decimal(12,2) NOT NULL COMMENT '价格',
  `out_date` timestamp NULL DEFAULT NULL,
  `out_price` decimal(12,2) DEFAULT NULL,
  `worth` text COMMENT '净值',
  `enable_date` date DEFAULT NULL COMMENT '固定资产等折旧起始日期,即物品开始使用的日期',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cost_role` int(11) DEFAULT NULL COMMENT '成本计算方法',
  `value_month` int(11) DEFAULT NULL COMMENT '报销年限',
  `value_rate` int(11) NOT NULL DEFAULT '0' COMMENT '残值率',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:正常，2出库，3退货',
  PRIMARY KEY (`id`),
  KEY `vendor_id` (`vendor_id`),
  KEY `stock_ibfk_2` (`client_id`),
  KEY `entry_subject` (`entry_subject`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=66 ;

--
-- 转存表中的数据 `stock`
--

INSERT INTO `stock` (`id`, `hs_no`, `order_no`, `order_no_sale`, `name`, `model`, `entry_subject`, `vendor_id`, `client_id`, `in_date`, `in_price`, `out_date`, `out_price`, `worth`, `enable_date`, `create_time`, `cost_role`, `value_month`, `value_rate`, `status`) VALUES
(1, 'F000001', '11', 'SO2015090001', '电脑', '联想 E1', 1405, NULL, 1, '20150901', '5000.00', '2015-09-27 16:00:00', '5000.00', NULL, NULL, '2015-09-28 08:07:57', NULL, 15, 5, 2),
(2, 'F000002', '11', '', '电脑', '联想 E1', 160101, NULL, NULL, '20150901', '5000.00', NULL, NULL, NULL, NULL, '2015-09-28 08:07:57', NULL, 15, 5, 1),
(3, 'F000003', '11', '', '电脑', '联想 E1', 160101, NULL, NULL, '20150901', '5000.00', NULL, NULL, NULL, NULL, '2015-09-28 08:07:57', NULL, 15, 5, 1),
(4, 'F000004', '11', '', '电脑', '联想 E1', 160101, NULL, NULL, '20150901', '5000.00', NULL, NULL, NULL, NULL, '2015-09-28 08:07:57', NULL, 15, 5, 1),
(6, 'F000006', '11', '', '电脑', '联想 E1', 160101, NULL, NULL, '20150901', '5000.00', NULL, NULL, NULL, NULL, '2015-09-28 08:07:57', NULL, 15, 5, 1),
(7, 'F000007', '11', '', '电脑', '联想 E1', 160101, NULL, NULL, '20150901', '5000.00', NULL, NULL, NULL, NULL, '2015-09-28 08:07:57', NULL, 15, 5, 1),
(8, 'F000008', NULL, '', '电脑', '联想 E1', 160101, NULL, NULL, '20150901', '5000.00', NULL, NULL, NULL, NULL, '2015-09-28 08:07:57', NULL, 15, 5, 1),
(9, 'F000009', NULL, '', '电脑', '联想 E1', 160101, NULL, NULL, '20150901', '5000.00', NULL, NULL, NULL, NULL, '2015-09-28 08:07:57', NULL, 15, 5, 1),
(11, 'F000011', NULL, 'SO2015090001', '办公桌', '通用', 160102, NULL, 1, '20150901', '1000.00', '2015-09-27 16:00:00', '1186.05', NULL, NULL, '2015-09-28 08:07:57', NULL, 36, 5, 2),
(12, 'F000012', NULL, 'SO2015090001', '办公桌', '通用', 160102, NULL, 1, '20150901', '1000.00', '2015-09-27 16:00:00', '1186.05', NULL, NULL, '2015-09-28 08:07:57', NULL, 36, 5, 2),
(13, 'F000013', NULL, '', '办公桌', '通用', 160102, NULL, NULL, '20150901', '1000.00', NULL, NULL, NULL, NULL, '2015-09-28 08:07:57', NULL, 36, 5, 1),
(14, 'F000014', NULL, '', '办公桌', '通用', 160102, NULL, NULL, '20150901', '1000.00', NULL, NULL, NULL, NULL, '2015-09-28 08:07:57', NULL, 36, 5, 1),
(15, 'F000015', NULL, '', '办公桌', '通用', 160102, NULL, NULL, '20150901', '1000.00', NULL, NULL, NULL, NULL, '2015-09-28 08:07:57', NULL, 36, 5, 1),
(16, 'F000016', NULL, '', '办公桌', '通用', 160102, NULL, NULL, '20150901', '1000.00', NULL, NULL, NULL, NULL, '2015-09-28 08:07:57', NULL, 36, 5, 1),
(17, 'F000017', NULL, '', '办公桌', '通用', 160102, NULL, NULL, '20150901', '1000.00', NULL, NULL, NULL, NULL, '2015-09-28 08:07:58', NULL, 36, 5, 1),
(18, 'F000018', NULL, '', '办公桌', '通用', 160102, NULL, NULL, '20150901', '1000.00', NULL, NULL, NULL, NULL, '2015-09-28 08:07:58', NULL, 36, 5, 1),
(19, 'F000019', NULL, '', '办公桌', '通用', 160102, NULL, NULL, '20150901', '1000.00', NULL, NULL, NULL, NULL, '2015-09-28 08:07:58', NULL, 36, 5, 1),
(20, 'F000020', NULL, '', '办公桌', '通用', 160102, NULL, NULL, '20150901', '1000.00', NULL, NULL, NULL, NULL, '2015-09-28 08:07:58', NULL, 36, 5, 1),
(21, 'F000021', NULL, '', '办公桌', '通用', 160102, NULL, NULL, '20150901', '1000.00', NULL, NULL, NULL, NULL, '2015-09-28 08:07:58', NULL, 36, 5, 1),
(22, 'F000022', NULL, '', '办公桌', '通用', 160102, NULL, NULL, '20150901', '1000.00', NULL, NULL, NULL, NULL, '2015-09-28 08:07:58', NULL, 36, 5, 1),
(23, 'F000023', NULL, '', '办公桌', '通用', 160102, NULL, NULL, '20150901', '1000.00', NULL, NULL, NULL, NULL, '2015-09-28 08:07:58', NULL, 36, 5, 1),
(24, 'F000024', NULL, '', '办公桌', '通用', 160102, NULL, NULL, '20150901', '1000.00', NULL, NULL, NULL, NULL, '2015-09-28 08:07:58', NULL, 36, 5, 1),
(25, 'F000025', NULL, '', '办公桌', '通用', 160102, NULL, NULL, '20150901', '1000.00', NULL, NULL, NULL, NULL, '2015-09-28 08:07:58', NULL, 36, 5, 1),
(26, 'F000026', NULL, '', '办公桌', '通用', 160102, NULL, NULL, '20150901', '1000.00', NULL, NULL, NULL, NULL, '2015-09-28 08:07:58', NULL, 36, 5, 1),
(27, 'F000027', NULL, '', '办公桌', '通用', 160102, NULL, NULL, '20150901', '1000.00', NULL, NULL, NULL, NULL, '2015-09-28 08:07:58', NULL, 36, 5, 1),
(28, 'F000028', NULL, '', '办公桌', '通用', 160102, NULL, NULL, '20150901', '1000.00', NULL, NULL, NULL, NULL, '2015-09-28 08:07:58', NULL, 36, 5, 1),
(29, 'F000029', NULL, '', '办公桌', '通用', 160102, NULL, NULL, '20150901', '1000.00', NULL, NULL, NULL, NULL, '2015-09-28 08:07:58', NULL, 36, 5, 1),
(30, 'F000030', NULL, '', '办公桌', '通用', 160102, NULL, NULL, '20150901', '1000.00', NULL, NULL, NULL, NULL, '2015-09-28 08:07:58', NULL, 36, 5, 1),
(31, 'F000031', NULL, '', '电脑', '联想 E1', 160101, NULL, NULL, '20150901', '5000.00', NULL, NULL, NULL, NULL, '2015-09-28 08:21:40', NULL, 15, 7, 1),
(32, 'F000032', NULL, '', '办公桌', '通用', 160102, NULL, NULL, '20150901', '1000.00', NULL, NULL, NULL, NULL, '2015-09-28 08:21:40', NULL, 36, 6, 1),
(34, '000033', NULL, '', '电脑', '联想 E1', 1405, NULL, NULL, '20150901', '5000.00', NULL, NULL, NULL, NULL, '2015-09-29 05:41:08', NULL, NULL, 0, 1),
(35, '000033', NULL, '', '电脑', '联想 E1', 1405, NULL, NULL, '20150901', '5000.00', NULL, NULL, NULL, NULL, '2015-09-29 05:41:09', NULL, NULL, 0, 1),
(36, '000033', NULL, '', '电脑', '联想 E1', 1405, NULL, NULL, '20150901', '5000.00', NULL, NULL, NULL, NULL, '2015-09-29 05:41:09', NULL, NULL, 0, 1),
(37, '000033', NULL, '', '电脑', '联想 E1', 1405, NULL, NULL, '20150901', '5000.00', NULL, NULL, NULL, NULL, '2015-09-29 05:41:09', NULL, NULL, 0, 1),
(38, '000033', NULL, '', '电脑', '联想 E1', 1405, NULL, NULL, '20150901', '5000.00', NULL, NULL, NULL, NULL, '2015-09-29 05:41:09', NULL, NULL, 0, 1),
(39, '000033', NULL, '', '电脑', '联想 E1', 1405, NULL, NULL, '20150901', '5000.00', NULL, NULL, NULL, NULL, '2015-09-29 05:41:09', NULL, NULL, 0, 1),
(40, '000033', NULL, '', '电脑', '联想 E1', 1405, NULL, NULL, '20150901', '5000.00', NULL, NULL, NULL, NULL, '2015-09-29 05:41:09', NULL, NULL, 0, 1),
(41, '000033', NULL, '', '电脑', '联想 E1', 1405, NULL, NULL, '20150901', '5000.00', NULL, NULL, NULL, NULL, '2015-09-29 05:41:09', NULL, NULL, 0, 1),
(42, '000033', NULL, '', '电脑', '联想 E1', 1405, NULL, NULL, '20150901', '5000.00', NULL, NULL, NULL, NULL, '2015-09-29 05:41:09', NULL, NULL, 0, 1),
(43, '000033', NULL, '', '电脑', '联想 E1', 1405, NULL, NULL, '20150901', '5000.00', NULL, NULL, NULL, NULL, '2015-09-29 05:41:09', NULL, NULL, 0, 1),
(44, '000033', NULL, '', '办公桌', '通用', 1405, NULL, NULL, '20150901', '1000.00', NULL, NULL, NULL, NULL, '2015-09-29 05:41:09', NULL, NULL, 0, 1),
(45, '000033', NULL, '', '办公桌', '通用', 1405, NULL, NULL, '20150901', '1000.00', NULL, NULL, NULL, NULL, '2015-09-29 05:41:09', NULL, NULL, 0, 1),
(46, '000033', NULL, '', '办公桌', '通用', 1405, NULL, NULL, '20150901', '1000.00', NULL, NULL, NULL, NULL, '2015-09-29 05:41:09', NULL, NULL, 0, 1),
(47, '000033', NULL, '', '办公桌', '通用', 1405, NULL, NULL, '20150901', '1000.00', NULL, NULL, NULL, NULL, '2015-09-29 05:41:09', NULL, NULL, 0, 1),
(48, '000033', NULL, '', '办公桌', '通用', 1405, NULL, NULL, '20150901', '1000.00', NULL, NULL, NULL, NULL, '2015-09-29 05:41:10', NULL, NULL, 0, 1),
(49, '000033', NULL, '', '办公桌', '通用', 1405, NULL, NULL, '20150901', '1000.00', NULL, NULL, NULL, NULL, '2015-09-29 05:41:10', NULL, NULL, 0, 1),
(50, '000033', NULL, '', '办公桌', '通用', 1405, NULL, NULL, '20150901', '1000.00', NULL, NULL, NULL, NULL, '2015-09-29 05:41:10', NULL, NULL, 0, 1),
(51, '000033', NULL, '', '办公桌', '通用', 1405, NULL, NULL, '20150901', '1000.00', NULL, NULL, NULL, NULL, '2015-09-29 05:41:10', NULL, NULL, 0, 1),
(52, '000033', NULL, '', '办公桌', '通用', 1405, NULL, NULL, '20150901', '1000.00', NULL, NULL, NULL, NULL, '2015-09-29 05:41:10', NULL, NULL, 0, 1),
(53, '000033', NULL, '', '办公桌', '通用', 1405, NULL, NULL, '20150901', '1000.00', NULL, NULL, NULL, NULL, '2015-09-29 05:41:10', NULL, NULL, 0, 1),
(54, '000033', NULL, '', '办公桌', '通用', 1405, NULL, NULL, '20150901', '1000.00', NULL, NULL, NULL, NULL, '2015-09-29 05:41:10', NULL, NULL, 0, 1),
(55, '000033', NULL, '', '办公桌', '通用', 1405, NULL, NULL, '20150901', '1000.00', NULL, NULL, NULL, NULL, '2015-09-29 05:41:10', NULL, NULL, 0, 1),
(56, '000033', NULL, '', '办公桌', '通用', 1405, NULL, NULL, '20150901', '1000.00', NULL, NULL, NULL, NULL, '2015-09-29 05:41:10', NULL, NULL, 0, 1),
(57, '000033', NULL, '', '办公桌', '通用', 1405, NULL, NULL, '20150901', '1000.00', NULL, NULL, NULL, NULL, '2015-09-29 05:41:10', NULL, NULL, 0, 1),
(58, '000033', NULL, '', '办公桌', '通用', 1405, NULL, NULL, '20150901', '1000.00', NULL, NULL, NULL, NULL, '2015-09-29 05:41:10', NULL, NULL, 0, 1),
(59, '000033', NULL, '', '办公桌', '通用', 1405, NULL, NULL, '20150901', '1000.00', NULL, NULL, NULL, NULL, '2015-09-29 05:41:10', NULL, NULL, 0, 1),
(60, '000033', NULL, '', '办公桌', '通用', 1405, NULL, NULL, '20150901', '1000.00', NULL, NULL, NULL, NULL, '2015-09-29 05:41:10', NULL, NULL, 0, 1),
(61, '000033', NULL, '', '办公桌', '通用', 1405, NULL, NULL, '20150901', '1000.00', NULL, NULL, NULL, NULL, '2015-09-29 05:41:10', NULL, NULL, 0, 1),
(62, '000033', NULL, '', '办公桌', '通用', 1405, NULL, NULL, '20150901', '1000.00', NULL, NULL, NULL, NULL, '2015-09-29 05:41:11', NULL, NULL, 0, 1),
(63, '000033', NULL, '', '办公桌', '通用', 1405, NULL, NULL, '20150901', '1000.00', NULL, NULL, NULL, NULL, '2015-09-29 05:41:11', NULL, NULL, 0, 1),
(64, 'F000033', 'PO2015100001', '', '办公桌', '', 160101, 1, NULL, '20151007', '5000.00', NULL, NULL, NULL, NULL, '2015-10-07 04:39:15', NULL, 36, 5, 1),
(65, 'F000034', 'PO2015100002', '', '办公桌', '', 1405, 1, NULL, '20151007', '5000.00', NULL, NULL, NULL, NULL, '2015-10-07 04:39:50', NULL, 36, 5, 1);

-- --------------------------------------------------------

--
-- 表的结构 `subjects`
--

CREATE TABLE IF NOT EXISTS `subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sbj_number` int(12) NOT NULL DEFAULT '0',
  `sbj_name` varchar(20) DEFAULT NULL,
  `sbj_cat` varchar(100) DEFAULT NULL COMMENT '1:资产类; 2:负债类; 3:权益类; 4:收入类; 5:费用类',
  `sbj_table` varchar(200) DEFAULT NULL,
  `has_sub` tinyint(1) NOT NULL DEFAULT '0',
  `balance_set` tinyint(1) NOT NULL DEFAULT '0',
  `start_balance` double DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `No` (`sbj_number`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=250 ;

--
-- 转存表中的数据 `subjects`
--

INSERT INTO `subjects` (`id`, `sbj_number`, `sbj_name`, `sbj_cat`, `sbj_table`, `has_sub`, `balance_set`, `start_balance`) VALUES
(1, 1001, '库存现金', '1', NULL, 0, 1, 0),
(2, 1002, '银行存款', '1', NULL, 1, 1, 0),
(3, 1003, '存放中央银行款项', '1', NULL, 0, 1, 0),
(4, 1102, '短期投资跌价准备', '1', NULL, 0, 1, 0),
(5, 1021, '结算备付金', '1', NULL, 0, 1, 0),
(6, 1031, '存出保证金', '1', NULL, 0, 1, 0),
(7, 1101, '交易性金融资产', '1', NULL, 1, 1, 0),
(8, 1111, '买入返售金融资产', '1', NULL, 0, 1, 0),
(9, 1121, '应收票据', '1', NULL, 0, 1, 0),
(10, 1122, '应收账款', '1', NULL, 1, 1, 0),
(11, 1123, '预付账款', '1', NULL, 1, 1, 0),
(12, 1131, '应收股利', '1', NULL, 0, 1, 0),
(13, 1132, '应收利息', '1', NULL, 0, 1, 0),
(14, 1201, '应收代位追偿款', '1', NULL, 0, 1, 0),
(15, 1211, '应收分保账款', '1', NULL, 0, 1, 0),
(16, 1212, '应收分保合同准备金', '1', NULL, 0, 1, 0),
(17, 1221, '其他应收款', '1', NULL, 1, 1, 0),
(18, 1231, '坏账准备', '1', NULL, 0, 1, 0),
(19, 1301, '贴现资产', '1', NULL, 0, 1, 0),
(20, 1302, '拆出资金', '1', NULL, 0, 1, 0),
(21, 1303, '贷款', '1', NULL, 0, 1, 0),
(22, 1304, '贷款损失准备', '1', NULL, 0, 1, 0),
(23, 1311, '代理兑付证券', '1', NULL, 0, 1, 0),
(24, 1321, '代理业务资产', '1', NULL, 0, 1, 0),
(25, 1401, '材料采购', '1', NULL, 0, 1, 0),
(26, 1402, '在途物资', '1', NULL, 0, 1, 0),
(27, 1403, '原材料', '1', NULL, 0, 1, 0),
(28, 1404, '材料成本差异', '1', NULL, 0, 1, 0),
(29, 1405, '库存商品', '1', NULL, 0, 1, 8000),
(30, 1406, '发出商品', '1', NULL, 0, 1, 0),
(31, 1407, '商品进销差价', '1', NULL, 0, 1, 0),
(32, 1408, '委托加工物资', '1', NULL, 0, 1, 0),
(33, 1411, '周转材料', '1', NULL, 0, 1, 0),
(34, 1412, '包装物及低值易耗品', '1', NULL, 0, 1, 0),
(35, 1421, '消耗性生物资产', '1', NULL, 0, 1, 0),
(36, 1431, '贵金属', '1', NULL, 0, 1, 0),
(37, 1441, '抵债资产', '1', NULL, 0, 1, 0),
(38, 1451, '损余物资', '1', NULL, 0, 1, 0),
(39, 1461, '融资租赁资产', '1', NULL, 0, 1, 0),
(40, 1471, '存货跌价准备', '1', NULL, 0, 1, 0),
(41, 1501, '持有至到期投资', '1', NULL, 0, 1, 0),
(42, 1502, '持有至到期投资减值准备', '1', NULL, 0, 1, 0),
(43, 1503, '可供出售金融资产', '1', NULL, 0, 1, 0),
(44, 1511, '长期股权投资', '1', NULL, 0, 1, 0),
(45, 1512, '长期股权投资减值准备', '1', NULL, 0, 1, 0),
(46, 1521, '投资性房地产', '1', NULL, 0, 1, 0),
(47, 1531, '长期应收款', '1', NULL, 0, 1, 0),
(48, 1532, '未实现融资收益', '1', NULL, 0, 1, 0),
(49, 1541, '存出资本保证金', '1', NULL, 0, 1, 0),
(50, 1601, '固定资产', '1', NULL, 1, 1, 0),
(51, 1602, '累计折旧', '1', NULL, 0, 1, 0),
(52, 1603, '固定资产减值准备', '1', NULL, 0, 1, 0),
(53, 1604, '在建工程', '1', NULL, 0, 1, 0),
(54, 1605, '工程物资', '1', NULL, 0, 1, 0),
(55, 1606, '固定资产清理', '1', NULL, 0, 1, 0),
(56, 1611, '未担保余值', '1', NULL, 0, 1, 0),
(57, 1621, '生产性生物资产', '1', NULL, 0, 1, 0),
(58, 1622, '生产性生物资产累计折旧', '1', NULL, 0, 1, 0),
(59, 1623, '公益性生物资产', '1', NULL, 0, 1, 0),
(60, 1631, '油气资产', '1', NULL, 0, 1, 0),
(61, 1632, '累计折耗', '1', NULL, 0, 1, 0),
(62, 1701, '无形资产', '1', NULL, 0, 1, 0),
(63, 1702, '累计摊销', '1', NULL, 0, 1, 0),
(64, 1703, '无形资产减值准备', '1', NULL, 0, 1, 0),
(65, 1711, '商誉', '1', NULL, 0, 1, 0),
(66, 1801, '长期待摊费用', '1', NULL, 0, 1, 0),
(67, 1811, '递延所得税资产', '1', NULL, 0, 1, 0),
(68, 1821, '独立账户资产', '1', NULL, 0, 1, 0),
(69, 1901, '待处理财产损溢', '1', NULL, 0, 1, 0),
(70, 2001, '短期借款', '2', NULL, 1, 1, 0),
(71, 2002, '存入保证金', '2', NULL, 0, 1, 0),
(72, 2003, '拆入资金', '2', NULL, 0, 1, 0),
(73, 2004, '向中央银行借款', '2', NULL, 0, 1, 0),
(74, 2011, '吸收存款', '2', NULL, 0, 1, 0),
(75, 2012, '同业存放', '2', NULL, 0, 1, 0),
(76, 2021, '贴现负债', '2', NULL, 0, 1, 0),
(77, 2101, '交易性金融负债', '2', NULL, 0, 1, 0),
(78, 2111, '卖出回购金融资产款金', '2', NULL, 0, 1, 0),
(79, 2201, '应付票据', '2', NULL, 0, 1, 0),
(80, 2202, '应付账款', '2', NULL, 1, 1, 0),
(81, 2203, '预收账款', '2', NULL, 1, 1, 0),
(82, 2211, '应付职工薪酬', '2', NULL, 1, 1, 0),
(83, 2221, '应交税费', '2', NULL, 1, 1, 0),
(84, 2231, '应付利息', '2', NULL, 0, 1, 0),
(85, 2232, '应付股利', '2', NULL, 0, 1, 0),
(86, 2241, '其他应付款', '2', NULL, 0, 1, 0),
(87, 2251, '应付保单红利', '2', NULL, 0, 1, 0),
(88, 2261, '应付分保账款', '2', NULL, 0, 1, 0),
(89, 2311, '代理买卖证券款', '2', NULL, 0, 1, 0),
(90, 2312, '代理承销证券款', '2', NULL, 0, 1, 0),
(91, 2313, '代理兑付证券款', '2', NULL, 0, 1, 0),
(92, 2314, '代理业务负债', '2', NULL, 0, 1, 0),
(93, 2401, '递延收益', '2', NULL, 0, 1, 0),
(94, 2501, '长期借款', '2', NULL, 0, 1, 0),
(95, 2502, '应付债券', '2', NULL, 0, 1, 0),
(96, 2601, '未到期责任准备金', '2', NULL, 0, 1, 0),
(97, 2602, '保险责任准备金', '2', NULL, 0, 1, 0),
(98, 2611, '保户储金', '2', NULL, 0, 1, 0),
(99, 2621, '独立账户负债', '2', NULL, 0, 1, 0),
(100, 2701, '长期应付款', '2', NULL, 0, 1, 0),
(101, 2702, '未确认融资费用', '2', NULL, 0, 1, 0),
(102, 2711, '专项应付款', '2', NULL, 0, 1, 0),
(103, 2801, '预计负债', '2', NULL, 0, 1, 8000),
(104, 2901, '递延所得税负债', '2', NULL, 0, 1, 0),
(105, 4001, '实收资本', '3', NULL, 0, 1, 0),
(106, 4002, '资本公积', '3', NULL, 0, 1, 0),
(107, 4101, '盈余公积', '3', NULL, 0, 1, 0),
(108, 4102, '一般风险准备', '3', NULL, 0, 1, 0),
(109, 4103, '本年利润', '3', NULL, 0, 1, 0),
(110, 4104, '利润分配', '3', NULL, 0, 1, 0),
(111, 4201, '库存股', '3', NULL, 0, 1, 0),
(112, 6001, '主营业务收入', '4', NULL, 1, 1, 0),
(113, 6011, '利息收入', '4', NULL, 0, 1, 0),
(114, 6021, '手续费及佣金收入', '4', NULL, 0, 1, 0),
(115, 6031, '保费收入', '4', NULL, 0, 1, 0),
(116, 6041, '租赁收入', '4', NULL, 0, 1, 0),
(117, 6051, '其他业务收入', '4', NULL, 1, 1, 0),
(118, 6061, '汇兑损益', '4', NULL, 0, 1, 0),
(119, 6101, '公允价值变动损益', '4', NULL, 0, 1, 0),
(120, 6111, '投资收益', '4', NULL, 1, 1, 0),
(121, 6201, '摊回保险责任准备金', '4', NULL, 0, 1, 0),
(122, 6202, '摊回赔付支出', '4', NULL, 0, 1, 0),
(123, 6203, '摊回分保费用', '4', NULL, 0, 1, 0),
(124, 6301, '营业外收入', '4', NULL, 0, 1, 0),
(125, 6401, '主营业务成本', '5', NULL, 1, 1, 0),
(126, 6402, '其他业务支出', '5', NULL, 1, 1, 0),
(127, 6403, '营业税金及附加', '5', NULL, 1, 1, 0),
(128, 6411, '利息支出', '5', NULL, 0, 1, 0),
(129, 6421, '手续费及佣金支出', '5', NULL, 0, 1, 0),
(130, 6501, '提取未到期责任准备金', '5', NULL, 0, 1, 0),
(131, 6502, '提取保险责任准备金', '5', NULL, 0, 1, 0),
(132, 6511, '赔付支出', '5', NULL, 0, 1, 0),
(133, 6521, '保户红利支出', '5', NULL, 0, 1, 0),
(134, 6531, '退保金', '5', NULL, 0, 1, 0),
(135, 6541, '分出保费', '5', NULL, 0, 1, 0),
(136, 6542, '分保费用', '5', NULL, 0, 1, 0),
(137, 6601, '销售费用', '5', NULL, 1, 1, 0),
(138, 6602, '管理费用', '5', NULL, 1, 1, 0),
(139, 6603, '财务费用', '5', NULL, 1, 1, 0),
(140, 6604, '勘探费用', '5', NULL, 0, 1, 0),
(141, 6701, '资产减值损失', '5', NULL, 0, 1, 0),
(142, 6711, '营业外支出', '5', NULL, 0, 1, 0),
(143, 6801, '企业所得税费用', '5', NULL, 0, 1, 0),
(144, 6901, '以前年度损益调整', '5', NULL, 0, 1, 0),
(145, 660201, '工资', '5', NULL, 0, 0, 0),
(146, 640101, '工资', '5', NULL, 0, 0, 0),
(147, 160101, '电子设备', '1', NULL, 0, 0, 5008),
(148, 160102, '办公设备', '1', NULL, 0, 0, 0),
(149, 160103, '运输设备', '1', NULL, 0, 0, 0),
(150, 160104, '生产设备', '1', NULL, 0, 0, 0),
(151, 160105, '房屋建筑物', '1', NULL, 0, 0, 0),
(152, 660202, '研发费', '5', NULL, 1, 0, 0),
(153, 660102, '办公费', '5', NULL, 0, 0, 0),
(154, 110101, '股票', '1', NULL, 0, 0, 0),
(155, 110102, '基金', '1', NULL, 0, 0, 0),
(156, 110103, '债券', '1', NULL, 0, 0, 0),
(157, 660301, '手续费', '5', NULL, 0, 0, 0),
(158, 640201, '材料销售', '5', NULL, 0, 0, 0),
(159, 640202, '技术转让', '5', NULL, 0, 0, 0),
(160, 640203, '固定资产租赁', '5', NULL, 0, 0, 0),
(161, 660302, '利息费用', '5', NULL, 0, 0, 0),
(162, 605101, '材料销售', '4', NULL, 0, 0, 0),
(163, 605102, '技术转让', '4', NULL, 0, 0, 0),
(164, 222101, '增值税', '2', NULL, 1, 0, 0),
(165, 110104, '其他', '1', NULL, 0, 0, 0),
(166, 660204, '招待费', '5', NULL, 0, 0, 0),
(167, 640102, '社保', '5', NULL, 0, 0, 0),
(168, 660103, '社保', '5', NULL, 0, 0, 0),
(169, 640103, '工资与奖金', '5', NULL, 0, 0, 0),
(170, 640104, '社保公积金', '5', NULL, 0, 0, 0),
(171, 200101, '中国银行', '2', NULL, 0, 0, 5008),
(172, 200102, '招商银行', '2', NULL, 0, 0, 0),
(173, 200103, '农业银行', '2', NULL, 0, 0, 0),
(174, 200104, '建设银行', '2', NULL, 0, 0, 0),
(175, 200105, '工商银行', '2', NULL, 0, 0, 0),
(176, 600101, '销售产品', '4', NULL, 0, 0, 0),
(177, 600102, '提供服务', '4', NULL, 0, 0, 0),
(178, 611101, '股票', '4', NULL, 0, 0, 0),
(179, 611102, '基金', '4', NULL, 0, 0, 0),
(180, 611103, '债券', '4', NULL, 0, 0, 0),
(181, 611104, '其他', '4', NULL, 0, 0, 0),
(182, 66020201, '工资与奖金', '5', NULL, 0, 0, 0),
(183, 660205, '工资与奖金', '5', NULL, 0, 0, 0),
(184, 660104, '工资与奖金', '5', NULL, 0, 0, 0),
(185, 660206, '服务费', '5', NULL, 0, 0, 0),
(186, 660207, '印花税', '5', NULL, 0, 0, 0),
(187, 660208, '社保公积金', '5', NULL, 0, 0, 0),
(188, 66020202, '社保公积金', '5', NULL, 0, 0, 0),
(189, 660209, '交通费', '5', NULL, 0, 0, 0),
(190, 660211, '快递费', '5', NULL, 0, 0, 0),
(191, 660212, '差旅费', '5', NULL, 0, 0, 0),
(192, 200106, '交通银行', '2', NULL, 0, 0, 0),
(193, 605103, '固定资产租赁', '4', NULL, 0, 0, 0),
(194, 640301, '城建税', '5', NULL, 0, 0, 0),
(195, 640302, '教育费附加', '5', NULL, 0, 0, 0),
(196, 640303, '河道管理费', '5', NULL, 0, 0, 0),
(197, 640304, '营业税', '5', NULL, 0, 0, 0),
(198, 100201, '中国银行', '1', NULL, 0, 0, 0),
(199, 100202, '农业银行', '1', NULL, 0, 0, 0),
(200, 222102, '个人所得税', '2', NULL, 0, 0, 0),
(201, 222103, '城建税', '2', NULL, 0, 0, 0),
(202, 222104, '教育附加税', '2', NULL, 0, 0, 0),
(203, 222105, '地方教育费附加', '2', NULL, 0, 0, 0),
(204, 224101, '河道管理费', '2', NULL, 0, 0, 0),
(205, 640105, '服务费', '5', NULL, 0, 0, 0),
(206, 220201, '某某公司', '2', NULL, 0, 0, 0),
(207, 220202, '初始供应商1', '2', NULL, 0, 0, 0),
(208, 22210101, '进项', '2', NULL, 0, 0, 0),
(209, 220203, '联通', '2', NULL, 0, 0, 0),
(210, 22210102, '销项', '2', NULL, 0, 0, 0),
(211, 220204, '电信', '2', NULL, 0, 0, 0),
(212, 112201, '联通', '1', NULL, 0, 0, 0),
(213, 112202, '电信', '1', NULL, 0, 0, 0),
(214, 220205, '初始客户1', '2', NULL, 0, 0, 0),
(215, 112203, '初始客户1', '1', NULL, 0, 0, 0),
(216, 640106, '材料', '5', NULL, 0, 0, 0),
(217, 222106, '教育费附加', '2', NULL, 0, 0, 0),
(218, 221101, '应付工资', '2', NULL, 0, 0, 0),
(219, 221102, '应付社保', '2', NULL, 0, 0, 0),
(220, 221103, '应付福利', '2', NULL, 0, 0, 0),
(221, 221104, '应付公积金', '2', NULL, 0, 0, 0),
(222, 640107, '差旅费', '5', NULL, 0, 0, 0),
(223, 122101, '张三', '1', NULL, 0, 0, 0),
(224, 224102, '张三', '2', NULL, 0, 0, 0),
(225, 640108, '福利费', '5', NULL, 0, 0, 0),
(226, 122102, '联通', '1', NULL, 0, 0, 0),
(227, 112301, '初始供应商1', '1', NULL, 0, 0, 0),
(228, 220301, '初始客户1', '2', NULL, 0, 0, 0),
(229, 112302, '某某公司', '1', NULL, 0, 0, 0),
(230, 220302, '联通', '2', NULL, 0, 0, 0),
(231, 122103, '李四', '1', NULL, 0, 0, 0),
(232, 66020203, '工资', '5', NULL, 0, 0, 0),
(233, 66020204, '差旅费', '5', NULL, 0, 0, 0),
(234, 224103, '李四', '2', NULL, 0, 0, 0),
(235, 122104, 'aaa', '1', NULL, 0, 0, 0),
(236, 220206, '客户选择', '2', NULL, 0, 0, 0),
(237, 220207, '供应商选择', '2', NULL, 0, 0, 0),
(238, 221105, '工资与奖金', '2', NULL, 0, 0, 0),
(239, 221106, '2', '2', NULL, 0, 0, 0),
(240, 221107, '1', '2', NULL, 0, 0, 0),
(241, 221108, '李四', '2', NULL, 0, 0, 0),
(242, 221109, '张三', '2', NULL, 0, 0, 0),
(243, 221110, 'fff', '2', NULL, 0, 0, 0),
(244, 221111, 'tttt', '2', NULL, 0, 0, 0),
(245, 122105, 'fff', '1', NULL, 0, 0, 0),
(246, 221112, '工资社保', '2', NULL, 0, 0, 0),
(247, 224104, 'asdf', '2', NULL, 0, 0, 0),
(248, 160106, '生产部', '1', NULL, 0, 0, 0),
(249, 160107, '行政', '1', NULL, 0, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `transition`
--

CREATE TABLE IF NOT EXISTS `transition` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entry_num_prefix` varchar(10) DEFAULT NULL,
  `entry_num` int(11) NOT NULL,
  `entry_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '录入时间',
  `entry_date` timestamp NULL DEFAULT NULL COMMENT '凭证日期，非录入时间',
  `entry_name` varchar(512) NOT NULL COMMENT '交易方名称',
  `data_type` varchar(16) DEFAULT NULL COMMENT '类型',
  `data_id` int(11) NOT NULL COMMENT '原始数据ID',
  `entry_memo` varchar(512) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT NULL,
  `entry_transaction` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:借;2:贷',
  `entry_subject` int(11) NOT NULL,
  `entry_amount` decimal(12,2) NOT NULL,
  `entry_appendix` text COMMENT '已废弃不用',
  `entry_appendix_type` tinyint(1) DEFAULT NULL COMMENT '1:client;2:vendor;3:employee;4:project',
  `entry_appendix_id` int(8) DEFAULT NULL COMMENT 'client vendor employee project ID',
  `entry_creater` int(11) NOT NULL,
  `entry_editor` int(11) NOT NULL,
  `entry_reviewer` int(11) NOT NULL,
  `entry_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `entry_reviewed` tinyint(1) NOT NULL DEFAULT '0',
  `entry_posting` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `entry_settlement` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0:不是结转凭证;1:是结转凭证',
  `entry_closing` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `subject_id_idx` (`entry_subject`),
  KEY `re_employee_id_idx` (`entry_reviewer`),
  KEY `ed_employee_id_idx` (`entry_editor`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- 转存表中的数据 `transition`
--

INSERT INTO `transition` (`id`, `entry_num_prefix`, `entry_num`, `entry_time`, `entry_date`, `entry_name`, `data_type`, `data_id`, `entry_memo`, `entry_transaction`, `entry_subject`, `entry_amount`, `entry_appendix`, `entry_appendix_type`, `entry_appendix_id`, `entry_creater`, `entry_editor`, `entry_reviewer`, `entry_deleted`, `entry_reviewed`, `entry_posting`, `entry_settlement`, `entry_closing`) VALUES
(1, '201509', 1, '2015-09-28 08:23:06', '2015-09-27 16:00:00', 'b公司', 'product', 1, 'asdf', 2, 600101, '1941.75', NULL, 2, 1, 48, 48, 0, 0, 0, 0, 0, 0),
(2, '201509', 1, '2015-09-28 08:23:06', '2015-09-27 16:00:00', 'b公司', 'product', 1, 'asdf', 1, 112203, '2000.00', NULL, NULL, 0, 48, 48, 0, 0, 0, 0, 0, 0),
(3, '201509', 1, '2015-09-28 08:23:06', '2015-09-27 16:00:00', 'b公司', 'product', 1, 'asdf', 2, 22210102, '58.25', NULL, NULL, 0, 48, 48, 0, 0, 0, 0, 0, 0),
(4, '201510', 1, '2015-10-07 04:35:13', '2015-10-06 16:00:00', 'aaa', 'bank', 1, 'ha', 1, 112301, '5000.00', NULL, NULL, NULL, 48, 48, 0, 0, 0, 0, 0, 0),
(5, '201510', 1, '2015-10-07 04:35:13', '2015-10-06 16:00:00', 'aaa', 'bank', 1, 'ha', 2, 100201, '5000.00', NULL, NULL, 0, 48, 48, 0, 0, 0, 0, 0, 0),
(6, '201510', 2, '2015-10-07 04:39:15', '2015-10-06 16:00:00', '办公桌', 'purchase', 1, 'ha', 1, 160101, '5000.00', NULL, 1, 1, 48, 48, 0, 0, 0, 0, 0, 0),
(7, '201510', 2, '2015-10-07 04:39:15', '2015-10-06 16:00:00', '办公桌', 'purchase', 1, 'ha', 2, 112301, '5000.00', NULL, NULL, 0, 48, 48, 0, 0, 0, 0, 0, 0),
(10, '201510', 4, '2015-10-07 04:40:44', '2015-10-06 16:00:00', '办公桌', 'purchase', 2, 'ha', 1, 1405, '5000.00', NULL, 1, 1, 48, 48, 0, 0, 0, 0, 0, 0),
(11, '201510', 4, '2015-10-07 04:40:44', '2015-10-06 16:00:00', '办公桌', 'purchase', 2, 'ha', 2, 220202, '5000.00', NULL, NULL, 0, 48, 48, 0, 0, 0, 0, 0, 0),
(12, '201510', 5, '2015-10-07 04:40:47', '2015-10-06 16:00:00', 'aaa', 'bank', 2, 'asdf', 1, 220202, '500.00', NULL, NULL, NULL, 48, 48, 0, 0, 0, 0, 0, 0),
(13, '201510', 5, '2015-10-07 04:40:47', '2015-10-06 16:00:00', 'aaa', 'bank', 2, 'asdf', 2, 100201, '500.00', NULL, NULL, 0, 48, 48, 0, 0, 0, 0, 0, 0),
(14, '201509', 2, '2015-10-07 05:01:59', '2015-09-04 16:00:00', '', 'reimburse', 1, 'test 3报销', 1, 640107, '100.00', NULL, NULL, 0, 48, 48, 0, 0, 0, 0, 0, 0),
(15, '201509', 2, '2015-10-07 05:01:59', '2015-09-04 16:00:00', '', 'reimburse', 1, 'test 3报销', 2, 224102, '300.00', NULL, NULL, 0, 48, 48, 0, 0, 0, 0, 0, 0),
(16, '201509', 2, '2015-10-07 05:01:59', '2015-09-04 16:00:00', '', 'reimburse', 1, 'test 3报销', 1, 640108, '200.00', NULL, NULL, 0, 48, 48, 0, 0, 0, 0, 0, 0),
(17, '201509', 3, '2015-10-07 05:01:59', '2015-09-04 16:00:00', '', 'reimburse', 2, 'test 4报销', 1, 66020204, '200.00', NULL, NULL, 0, 48, 48, 0, 0, 0, 0, 0, 0),
(18, '201509', 3, '2015-10-07 05:01:59', '2015-09-04 16:00:00', '', 'reimburse', 2, 'test 4报销', 2, 224103, '200.00', NULL, NULL, 0, 48, 48, 0, 0, 0, 0, 0, 0),
(19, '201509', 4, '2015-10-07 05:37:35', '2015-09-27 16:00:00', 'b公司', 'stock', 25, '成本结转-b公司', 1, 640106, '7372.10', NULL, NULL, NULL, 48, 48, 0, 0, 0, 0, 0, 0),
(20, '201509', 4, '2015-10-07 05:37:35', '2015-09-27 16:00:00', 'b公司', 'stock', 25, '成本结转-b公司', 2, 1405, '7372.10', NULL, NULL, 0, 48, 48, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- 替换视图以便查看 `transitiondate`
--
CREATE TABLE IF NOT EXISTS `transitiondate` (
`date` varchar(10)
);
-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `token` varchar(53) NOT NULL,
  `role` varchar(64) NOT NULL DEFAULT 'user',
  `group` int(11) NOT NULL,
  `status_id` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `role` (`role`),
  KEY `status_id` (`status_id`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `vendor`
--

CREATE TABLE IF NOT EXISTS `vendor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company` varchar(256) NOT NULL,
  `vat` varchar(45) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `add` varchar(100) DEFAULT NULL,
  `memo` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `vendor`
--

INSERT INTO `vendor` (`id`, `company`, `vat`, `phone`, `add`, `memo`) VALUES
(1, '初始供应商1', NULL, NULL, NULL, NULL),
(2, '某某公司', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- 视图结构 `condomdate`
--
DROP TABLE IF EXISTS `condomdate`;

CREATE ALGORITHM=UNDEFINED DEFINER=`dev`@`localhost` SQL SECURITY DEFINER VIEW `condomdate` AS select max(`transition`.`entry_num_prefix`) AS `date` from `transition` where (`transition`.`entry_closing` = 1);

-- --------------------------------------------------------

--
-- 视图结构 `transitiondate`
--
DROP TABLE IF EXISTS `transitiondate`;

CREATE ALGORITHM=UNDEFINED DEFINER=`dev`@`localhost` SQL SECURITY DEFINER VIEW `transitiondate` AS select max(`transition`.`entry_num_prefix`) AS `date` from `transition` where ((`transition`.`entry_closing` = 1) or (`transition`.`entry_settlement` = 1));

--
-- 限制导出的表
--

--
-- 限制表 `cost`
--
ALTER TABLE `cost`
  ADD CONSTRAINT `cost_ibfk_2` FOREIGN KEY (`subject`) REFERENCES `subjects` (`sbj_number`) ON DELETE NO ACTION;

--
-- 限制表 `options`
--
ALTER TABLE `options`
  ADD CONSTRAINT `options_ibfk_1` FOREIGN KEY (`entry_subject`) REFERENCES `subjects` (`sbj_number`);

--
-- 限制表 `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `fk_subject_id` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`sbj_number`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- 限制表 `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`),
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`subject`) REFERENCES `subjects` (`sbj_number`);

--
-- 限制表 `purchase`
--
ALTER TABLE `purchase`
  ADD CONSTRAINT `purchase_ibfk_1` FOREIGN KEY (`vendor_id`) REFERENCES `vendor` (`id`),
  ADD CONSTRAINT `purchase_ibfk_2` FOREIGN KEY (`subject`) REFERENCES `subjects` (`sbj_number`),
  ADD CONSTRAINT `purchase_ibfk_3` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`);

--
-- 限制表 `reimburse`
--
ALTER TABLE `reimburse`
  ADD CONSTRAINT `reimburse_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`id`);

--
-- 限制表 `salary`
--
ALTER TABLE `salary`
  ADD CONSTRAINT `salary_ibfk_1` FOREIGN KEY (`subject`) REFERENCES `subjects` (`sbj_number`),
  ADD CONSTRAINT `salary_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`id`);

--
-- 限制表 `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `stock_ibfk_1` FOREIGN KEY (`vendor_id`) REFERENCES `vendor` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `stock_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `stock_ibfk_3` FOREIGN KEY (`entry_subject`) REFERENCES `subjects` (`sbj_number`);

--
-- 限制表 `transition`
--
ALTER TABLE `transition`
  ADD CONSTRAINT `transition_ibfk_1` FOREIGN KEY (`entry_subject`) REFERENCES `subjects` (`sbj_number`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
