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
(24, 1001, '库存现金', '1', NULL),
(25, 1002, '银行存款', '1', NULL),
(26, 1003, '存放中央银行款项', '1', NULL),
(27, 1102, '短期投资跌价准备', '1', NULL),
(28, 1021, '结算备付金', '1', NULL),
(29, 1031, '存出保证金', '1', NULL),
(30, 1101, '交易性金融资产', '1', NULL),
(31, 1111, '买入返售金融资产', '1', NULL),
(32, 1121, '应收票据', '1', NULL),
(33, 1122, '应收账款', '1', NULL),
(34, 1123, '预付账款', '1', NULL),
(35, 1131, '应收股利', '1', NULL),
(36, 1132, '应收利息', '1', NULL),
(37, 1201, '应收代位追偿款', '1', NULL),
(38, 1211, '应收分保账款', '1', NULL),
(39, 1212, '应收分保合同准备金', '1', NULL),
(40, 1221, '其他应收款', '1', NULL),
(41, 1231, '坏账准备', '1', NULL),
(42, 1301, '贴现资产', '1', NULL),
(43, 1302, '拆出资金', '1', NULL),
(44, 1303, '贷款', '1', NULL),
(45, 1304, '贷款损失准备', '1', NULL),
(46, 1311, '代理兑付证券', '1', NULL),
(47, 1321, '代理业务资产', '1', NULL),
(48, 1401, '材料采购', '1', NULL),
(49, 1402, '在途物资', '1', NULL),
(50, 1403, '原材料', '1', NULL),
(51, 1404, '材料成本差异', '1', NULL),
(52, 1405, '库存商品', '1', NULL),
(53, 1406, '发出商品', '1', NULL),
(54, 1407, '商品进销差价', '1', NULL),
(55, 1408, '委托加工物资', '1', NULL),
(56, 1411, '周转材料1412包装物及低值易耗品', '1', NULL),
(57, 1421, '消耗性生物资产', '1', NULL),
(58, 1431, '贵金属', '1', NULL),
(59, 1441, '抵债资产', '1', NULL),
(60, 1451, '损余物资', '1', NULL),
(61, 1461, '融资租赁资产', '1', NULL),
(62, 1471, '存货跌价准备', '1', NULL),
(63, 1501, '持有至到期投资', '1', NULL),
(64, 1502, '持有至到期投资减值准备', '1', NULL),
(65, 1503, '可供出售金融资产', '1', NULL),
(66, 1511, '长期股权投资', '1', NULL),
(67, 1512, '长期股权投资减值准备', '1', NULL),
(68, 1521, '投资性房地产', '1', NULL),
(69, 1531, '长期应收款', '1', NULL),
(70, 1532, '未实现融资收益', '1', NULL),
(71, 1541, '存出资本保证金', '1', NULL),
(72, 1601, '固定资产', '1', NULL),
(73, 1602, '累计折旧', '1', NULL),
(74, 1603, '固定资产减值准备', '1', NULL),
(75, 1604, '在建工程', '1', NULL),
(76, 1605, '工程物资', '1', NULL),
(77, 1606, '固定资产清理', '1', NULL),
(78, 1611, '未担保余值', '1', NULL),
(79, 1621, '生产性生物资产', '1', NULL),
(80, 1622, '生产性生物资产累计折旧', '1', NULL),
(81, 1623, '公益性生物资产', '1', NULL),
(82, 1631, '油气资产', '1', NULL),
(83, 1632, '累计折耗', '1', NULL),
(84, 1701, '无形资产', '1', NULL),
(85, 1702, '累计摊销', '1', NULL),
(86, 1703, '无形资产减值准备', '1', NULL),
(87, 1711, '商誉', '1', NULL),
(88, 1801, '长期待摊费用', '1', NULL),
(89, 1811, '递延所得税资产', '1', NULL),
(90, 1821, '独立账户资产', '1', NULL),
(91, 1901, '待处理财产损溢', '1', NULL),
(228, 2001, '短期借款', '2', NULL),
(229, 2002, '存入保证金', '2', NULL),
(230, 2003, '拆入资金', '2', NULL),
(231, 2004, '向中央银行借款', '2', NULL),
(232, 2011, '吸收存款', '2', NULL),
(233, 2012, '同业存放', '2', NULL),
(234, 2021, '贴现负债', '2', NULL),
(235, 2101, '交易性金融负债', '2', NULL),
(276, 2111, '卖出回购金融资产款金', '2', NULL),
(277, 2201, '应付票据', '2', NULL),
(278, 2202, '应付账款', '2', NULL),
(279, 2203, '预收账款', '2', NULL),
(280, 2211, '应付职工薪酬', '2', NULL),
(281, 2221, '应交税费', '2', NULL),
(282, 2231, '应付利息', '2', NULL),
(283, 2232, '应付股利', '2', NULL),
(284, 2241, '其他应付款', '2', NULL),
(285, 2251, '应付保单红利', '2', NULL),
(286, 2261, '应付分保账款', '2', NULL),
(287, 2311, '代理买卖证券款', '2', NULL),
(288, 2312, '代理承销证券款', '2', NULL),
(289, 2313, '代理兑付证券款', '2', NULL),
(290, 2314, '代理业务负债', '2', NULL),
(291, 2401, '递延收益', '2', NULL),
(292, 2501, '长期借款', '2', NULL),
(293, 2502, '应付债券', '2', NULL),
(294, 2601, '未到期责任准备金', '2', NULL),
(295, 2602, '保险责任准备金', '2', NULL),
(296, 2611, '保户储金', '2', NULL),
(297, 2621, '独立账户负债', '2', NULL),
(298, 2701, '长期应付款', '2', NULL),
(299, 2702, '未确认融资费用', '2', NULL),
(300, 2711, '专项应付款', '2', NULL),
(301, 2801, '预计负债', '2', NULL),
(302, 2901, '递延所得税负债', '2', NULL),
(303, 4001, '实收资本', '3', NULL),
(304, 4002, '资本公积', '3', NULL),
(305, 4101, '盈余公积', '3', NULL),
(306, 4102, '一般风险准备', '3', NULL),
(307, 4103, '本年利润', '3', NULL),
(308, 4104, '利润分配', '3', NULL),
(309, 4201, '库存股', '3', NULL),
(310, 6001, '主营业务收入', '4', NULL),
(311, 6011, '利息收入', '4', NULL),
(312, 6021, '手续费及佣金收入', '4', NULL),
(313, 6031, '保费收入', '4', NULL),
(314, 6041, '租赁收入', '4', NULL),
(315, 6051, '其他业务收入', '4', NULL),
(316, 6061, '汇兑损益', '4', NULL),
(317, 6101, '公允价值变动损益', '4', NULL),
(318, 6111, '投资收益', '4', NULL),
(319, 6201, '摊回保险责任准备金', '4', NULL),
(320, 6202, '摊回赔付支出', '4', NULL),
(321, 6203, '摊回分保费用', '4', NULL),
(322, 6301, '营业外收入', '4', NULL),
(323, 6401, '主营业务成本', '5', NULL),
(324, 6402, '其他业务支出', '5', NULL),
(325, 6403, '营业税金及附加', '5', NULL),
(326, 6411, '利息支出', '5', NULL),
(327, 6421, '手续费及佣金支出', '5', NULL),
(328, 6501, '提取未到期责任准备金', '5', NULL),
(329, 6502, '提取保险责任准备金', '5', NULL),
(330, 6511, '赔付支出', '5', NULL),
(331, 6521, '保户红利支出', '5', NULL),
(332, 6531, '退保金', '5', NULL),
(333, 6541, '分出保费', '5', NULL),
(334, 6542, '分保费用', '5', NULL),
(335, 6601, '销售费用', '5', NULL),
(336, 6602, '管理费用', '5', NULL),
(337, 6603, '财务费用', '5', NULL),
(338, 6604, '勘探费用', '5', NULL),
(339, 6701, '资产减值损失', '5', NULL),
(340, 6711, '营业外支出', '5', NULL),
(341, 6801, '所得税费用', '5', NULL),
(342, 6901, '以前年度损益调整', '5', NULL);

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
