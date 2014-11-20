-- phpMyAdmin SQL Dump
-- version 4.2.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2014-11-07 13:41:16
-- 服务器版本： 5.5.36
-- PHP Version: 5.5.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `account_pz`
--

-- --------------------------------------------------------

--
-- 表的结构 `client`
--

CREATE TABLE IF NOT EXISTS `client` (
  `id` int(11) NOT NULL,
  `company` varchar(256) NOT NULL,
  `vat` varchar(45) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `add` varchar(100) DEFAULT NULL,
  `memo` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `memo` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `employee`
--

CREATE TABLE IF NOT EXISTS `employee` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `memo` varchar(200) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `meta`
--

CREATE TABLE IF NOT EXISTS `meta` (
  `id` int(11) NOT NULL,
  `option` varchar(32) CHARACTER SET utf8 NOT NULL COMMENT '属性名称',
  `value` varchar(256) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

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
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `support` varchar(100) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `entrynum` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `options`
--

INSERT INTO `options` (`id`, `name`, `support`, `url`, `entrynum`) VALUES
  (1, '我嘉', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `balance` double NOT NULL,
  `posted` tinyint(1) NOT NULL DEFAULT '0',
  `debit` double NOT NULL DEFAULT '0' COMMENT '借',
  `credit` double NOT NULL DEFAULT '0' COMMENT '贷',
  `post_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `project`
--

CREATE TABLE IF NOT EXISTS `project` (
  `id` int(11) NOT NULL,
  `name` varchar(60) DEFAULT NULL,
  `memo` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `subjects`
--

CREATE TABLE IF NOT EXISTS `subjects` (
  `id` int(11) NOT NULL,
  `sbj_number` int(12) NOT NULL DEFAULT '0',
  `sbj_name` varchar(20) DEFAULT NULL,
  `sbj_cat` varchar(100) DEFAULT NULL COMMENT '1:资产类; 2:负债类; 3:权益类; 4:收入类; 5:费用类',
  `sbj_table` varchar(200) DEFAULT NULL,
  `has_sub` tinyint(1) NOT NULL DEFAULT '0',
  `balance_set` tinyint(1) NOT NULL DEFAULT '0',
  `start_balance` double DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=344 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `subjects`
--

INSERT INTO `subjects` (`id`, `sbj_number`, `sbj_name`, `sbj_cat`, `sbj_table`, `has_sub`, `balance_set`, `start_balance`) VALUES
  (24, 1001, '库存现金', '1', NULL, 0, 1, 0),
  (25, 1002, '银行存款', '1', NULL, 0, 1, 0),
  (26, 1003, '存放中央银行款项', '1', NULL, 0, 1, 0),
  (27, 1102, '短期投资跌价准备', '1', NULL, 0, 1, 0),
  (28, 1021, '结算备付金', '1', NULL, 0, 1, 0),
  (29, 1031, '存出保证金', '1', NULL, 0, 1, 0),
  (30, 1101, '交易性金融资产', '1', NULL, 0, 1, 0),
  (31, 1111, '买入返售金融资产', '1', NULL, 0, 1, 0),
  (32, 1121, '应收票据', '1', NULL, 0, 1, 0),
  (33, 1122, '应收账款', '1', NULL, 0, 1, 0),
  (34, 1123, '预付账款', '1', NULL, 0, 1, 0),
  (35, 1131, '应收股利', '1', NULL, 0, 1, 0),
  (36, 1132, '应收利息', '1', NULL, 0, 1, 0),
  (37, 1201, '应收代位追偿款', '1', NULL, 0, 1, 0),
  (38, 1211, '应收分保账款', '1', NULL, 0, 1, 0),
  (39, 1212, '应收分保合同准备金', '1', NULL, 0, 1, 0),
  (40, 1221, '其他应收款', '1', NULL, 0, 1, 0),
  (41, 1231, '坏账准备', '1', NULL, 0, 1, 0),
  (42, 1301, '贴现资产', '1', NULL, 0, 1, 0),
  (43, 1302, '拆出资金', '1', NULL, 0, 1, 0),
  (44, 1303, '贷款', '1', NULL, 0, 1, 0),
  (45, 1304, '贷款损失准备', '1', NULL, 0, 1, 0),
  (46, 1311, '代理兑付证券', '1', NULL, 0, 1, 0),
  (47, 1321, '代理业务资产', '1', NULL, 0, 1, 0),
  (48, 1401, '材料采购', '1', NULL, 0, 1, 0),
  (49, 1402, '在途物资', '1', NULL, 0, 1, 0),
  (50, 1403, '原材料', '1', NULL, 0, 1, 0),
  (51, 1404, '材料成本差异', '1', NULL, 0, 1, 0),
  (52, 1405, '库存商品', '1', NULL, 0, 1, 0),
  (53, 1406, '发出商品', '1', NULL, 0, 1, 0),
  (54, 1407, '商品进销差价', '1', NULL, 0, 1, 0),
  (55, 1408, '委托加工物资', '1', NULL, 0, 1, 0),
  (56, 1411, '周转材料', '1', NULL, 0, 1, 0),
  (57, 1421, '消耗性生物资产', '1', NULL, 0, 1, 0),
  (58, 1431, '贵金属', '1', NULL, 0, 1, 0),
  (59, 1441, '抵债资产', '1', NULL, 0, 1, 0),
  (60, 1451, '损余物资', '1', NULL, 0, 1, 0),
  (61, 1461, '融资租赁资产', '1', NULL, 0, 1, 0),
  (62, 1471, '存货跌价准备', '1', NULL, 0, 1, 0),
  (63, 1501, '持有至到期投资', '1', NULL, 0, 1, 0),
  (64, 1502, '持有至到期投资减值准备', '1', NULL, 0, 1, 0),
  (65, 1503, '可供出售金融资产', '1', NULL, 0, 1, 0),
  (66, 1511, '长期股权投资', '1', NULL, 0, 1, 0),
  (67, 1512, '长期股权投资减值准备', '1', NULL, 0, 1, 0),
  (68, 1521, '投资性房地产', '1', NULL, 0, 1, 0),
  (69, 1531, '长期应收款', '1', NULL, 0, 1, 0),
  (70, 1532, '未实现融资收益', '1', NULL, 0, 1, 0),
  (71, 1541, '存出资本保证金', '1', NULL, 0, 1, 0),
  (72, 1601, '固定资产', '1', NULL, 0, 1, 0),
  (73, 1602, '累计折旧', '1', NULL, 0, 1, 0),
  (74, 1603, '固定资产减值准备', '1', NULL, 0, 1, 0),
  (75, 1604, '在建工程', '1', NULL, 0, 1, 0),
  (76, 1605, '工程物资', '1', NULL, 0, 1, 0),
  (77, 1606, '固定资产清理', '1', NULL, 0, 1, 0),
  (78, 1611, '未担保余值', '1', NULL, 0, 1, 0),
  (79, 1621, '生产性生物资产', '1', NULL, 0, 1, 0),
  (80, 1622, '生产性生物资产累计折旧', '1', NULL, 0, 1, 0),
  (81, 1623, '公益性生物资产', '1', NULL, 0, 1, 0),
  (82, 1631, '油气资产', '1', NULL, 0, 1, 0),
  (83, 1632, '累计折耗', '1', NULL, 0, 1, 0),
  (84, 1701, '无形资产', '1', NULL, 0, 1, 0),
  (85, 1702, '累计摊销', '1', NULL, 0, 1, 0),
  (86, 1703, '无形资产减值准备', '1', NULL, 0, 1, 0),
  (87, 1711, '商誉', '1', NULL, 0, 1, 0),
  (88, 1801, '长期待摊费用', '1', NULL, 0, 1, 0),
  (89, 1811, '递延所得税资产', '1', NULL, 0, 1, 0),
  (90, 1821, '独立账户资产', '1', NULL, 0, 1, 0),
  (91, 1901, '待处理财产损溢', '1', NULL, 0, 1, 0),
  (228, 2001, '短期借款', '2', NULL, 0, 1, 0),
  (229, 2002, '存入保证金', '2', NULL, 0, 1, 0),
  (230, 2003, '拆入资金', '2', NULL, 0, 1, 0),
  (231, 2004, '向中央银行借款', '2', NULL, 0, 1, 0),
  (232, 2011, '吸收存款', '2', NULL, 0, 1, 0),
  (233, 2012, '同业存放', '2', NULL, 0, 1, 0),
  (234, 2021, '贴现负债', '2', NULL, 0, 1, 0),
  (235, 2101, '交易性金融负债', '2', NULL, 0, 1, 0),
  (276, 2111, '卖出回购金融资产款金', '2', NULL, 0, 1, 0),
  (277, 2201, '应付票据', '2', NULL, 0, 1, 0),
  (278, 2202, '应付账款', '2', NULL, 0, 1, 0),
  (279, 2203, '预收账款', '2', NULL, 0, 1, 0),
  (280, 2211, '应付职工薪酬', '2', NULL, 0, 1, 0),
  (281, 2221, '应交税费', '2', NULL, 0, 1, 0),
  (282, 2231, '应付利息', '2', NULL, 0, 1, 0),
  (283, 2232, '应付股利', '2', NULL, 0, 1, 0),
  (284, 2241, '其他应付款', '2', NULL, 0, 1, 0),
  (285, 2251, '应付保单红利', '2', NULL, 0, 1, 0),
  (286, 2261, '应付分保账款', '2', NULL, 0, 1, 0),
  (287, 2311, '代理买卖证券款', '2', NULL, 0, 1, 0),
  (288, 2312, '代理承销证券款', '2', NULL, 0, 1, 0),
  (289, 2313, '代理兑付证券款', '2', NULL, 0, 1, 0),
  (290, 2314, '代理业务负债', '2', NULL, 0, 1, 0),
  (291, 2401, '递延收益', '2', NULL, 0, 1, 0),
  (292, 2501, '长期借款', '2', NULL, 0, 1, 0),
  (293, 2502, '应付债券', '2', NULL, 0, 1, 0),
  (294, 2601, '未到期责任准备金', '2', NULL, 0, 1, 0),
  (295, 2602, '保险责任准备金', '2', NULL, 0, 1, 0),
  (296, 2611, '保户储金', '2', NULL, 0, 1, 0),
  (297, 2621, '独立账户负债', '2', NULL, 0, 1, 0),
  (298, 2701, '长期应付款', '2', NULL, 0, 1, 0),
  (299, 2702, '未确认融资费用', '2', NULL, 0, 1, 0),
  (300, 2711, '专项应付款', '2', NULL, 0, 1, 0),
  (301, 2801, '预计负债', '2', NULL, 0, 1, 0),
  (302, 2901, '递延所得税负债', '2', NULL, 0, 1, 0),
  (303, 4001, '实收资本', '3', NULL, 0, 1, 0),
  (304, 4002, '资本公积', '3', NULL, 0, 1, 0),
  (305, 4101, '盈余公积', '3', NULL, 0, 1, 0),
  (306, 4102, '一般风险准备', '3', NULL, 0, 1, 0),
  (307, 4103, '本年利润', '3', NULL, 0, 1, 0),
  (308, 4104, '利润分配', '3', NULL, 0, 1, 0),
  (309, 4201, '库存股', '3', NULL, 0, 1, 0),
  (310, 6001, '主营业务收入', '4', NULL, 0, 1, 0),
  (311, 6011, '利息收入', '4', NULL, 0, 1, 0),
  (312, 6021, '手续费及佣金收入', '4', NULL, 0, 1, 0),
  (313, 6031, '保费收入', '4', NULL, 0, 1, 0),
  (314, 6041, '租赁收入', '4', NULL, 0, 1, 0),
  (315, 6051, '其他业务收入', '4', NULL, 0, 1, 0),
  (316, 6061, '汇兑损益', '4', NULL, 0, 1, 0),
  (317, 6101, '公允价值变动损益', '4', NULL, 0, 1, 0),
  (318, 6111, '投资收益', '4', NULL, 0, 1, 0),
  (319, 6201, '摊回保险责任准备金', '4', NULL, 0, 1, 0),
  (320, 6202, '摊回赔付支出', '4', NULL, 0, 1, 0),
  (321, 6203, '摊回分保费用', '4', NULL, 0, 1, 0),
  (322, 6301, '营业外收入', '4', NULL, 0, 1, 0),
  (323, 6401, '主营业务成本', '5', NULL, 0, 1, 0),
  (324, 6402, '其他业务支出', '5', NULL, 0, 1, 0),
  (325, 6403, '营业税金及附加', '5', NULL, 0, 1, 0),
  (326, 6411, '利息支出', '5', NULL, 0, 1, 0),
  (327, 6421, '手续费及佣金支出', '5', NULL, 0, 1, 0),
  (328, 6501, '提取未到期责任准备金', '5', NULL, 0, 1, 0),
  (329, 6502, '提取保险责任准备金', '5', NULL, 0, 1, 0),
  (330, 6511, '赔付支出', '5', NULL, 0, 1, 0),
  (331, 6521, '保户红利支出', '5', NULL, 0, 1, 0),
  (332, 6531, '退保金', '5', NULL, 0, 1, 0),
  (333, 6541, '分出保费', '5', NULL, 0, 1, 0),
  (334, 6542, '分保费用', '5', NULL, 0, 1, 0),
  (335, 6601, '销售费用', '5', NULL, 0, 1, 0),
  (336, 6602, '管理费用', '5', NULL, 0, 1, 0),
  (337, 6603, '财务费用', '5', NULL, 0, 1, 0),
  (338, 6604, '勘探费用', '5', NULL, 0, 1, 0),
  (339, 6701, '资产减值损失', '5', NULL, 0, 1, 0),
  (340, 6711, '营业外支出', '5', NULL, 0, 1, 0),
  (341, 6801, '所得税费用', '5', NULL, 0, 1, 0),
  (342, 6901, '以前年度损益调整', '5', NULL, 0, 1, 0),
  (343, 1412, '包装物及低值易耗品', '1', NULL, 0, 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `transition`
--

CREATE TABLE IF NOT EXISTS `transition` (
  `id` int(11) NOT NULL,
  `entry_num_prefix` varchar(10) DEFAULT NULL,
  `entry_num` int(11) NOT NULL,
  `entry_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '录入时间',
  `entry_date` timestamp NULL DEFAULT NULL COMMENT '凭证日期，非录入时间',
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
  `entry_closing` tinyint(1) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `transitiondate`
--
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `transitionDate` AS select max(`transition`.`entry_num_prefix`) AS `date` from `transition` where ((`transition`.`entry_closing` = 1) or (`transition`.`entry_settlement` = 1));

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `userid` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `email` varchar(20) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `sys_role` int(11) DEFAULT NULL,
  `roles` varchar(16) NOT NULL,
  `username` varchar(32) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `userid`, `password`, `fullname`, `mobile`, `email`, `title`, `sys_role`, `roles`, `username`) VALUES
  (1, 'short name', '21232f297a57a5a743894a0e4a801fc3', 'fullname', 'm', 'admin', 't', 1, 'admin', ''),
  (2, 'short name 2', '21232f297a57a5a743894a0e4a801fc3', 'fullname2', 'm', 'admin1', 't', 2, 'admin', '');

-- --------------------------------------------------------

--
-- 表的结构 `vendor`
--

CREATE TABLE IF NOT EXISTS `vendor` (
  `id` int(11) NOT NULL,
  `company` varchar(256) NOT NULL,
  `vat` varchar(45) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `add` varchar(100) DEFAULT NULL,
  `memo` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `client`
--
ALTER TABLE `client`
ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Indexes for table `meta`
--
ALTER TABLE `meta`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id_UNIQUE` (`id`), ADD KEY `fk_subject_id_idx` (`subject_id`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id_UNIQUE` (`id`), ADD UNIQUE KEY `No` (`sbj_number`);

--
-- Indexes for table `transition`
--
ALTER TABLE `transition`
ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id_UNIQUE` (`id`), ADD KEY `subject_id_idx` (`entry_subject`), ADD KEY `re_employee_id_idx` (`entry_reviewer`), ADD KEY `ed_employee_id_idx` (`entry_editor`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `meta`
--
ALTER TABLE `meta`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=344;
--
-- AUTO_INCREMENT for table `transition`
--
ALTER TABLE `transition`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `vendor`
--
ALTER TABLE `vendor`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 限制导出的表
--

--
-- 限制表 `post`
--
ALTER TABLE `post`
ADD CONSTRAINT `fk_subject_id` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`sbj_number`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- 限制表 `transition`
--
ALTER TABLE `transition`
ADD CONSTRAINT `transition_ibfk_1` FOREIGN KEY (`entry_subject`) REFERENCES `subjects` (`sbj_number`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
