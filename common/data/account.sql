-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2015-04-16 07:11:50
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `account_abc`
--

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `type` int(11) NOT NULL COMMENT '1\\2\\3\\4 为生产部门、管理部门、销售部门 、研发部门',
  `memo` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `department`
--

INSERT INTO `department` (`id`, `name`, `type`, `memo`) VALUES
(1, '研发部', 4, '研发部'),
(2, '生产厂区部门1', 1, ''),
(3, '行政管理', 2, ''),
(4, '销售人员部门', 3, '');

-- --------------------------------------------------------

--
-- 表的结构 `employee`
--

CREATE TABLE IF NOT EXISTS `employee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `memo` varchar(200) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=50 ;

--
-- 转存表中的数据 `employee`
--

INSERT INTO `employee` (`id`, `name`, `memo`, `department_id`) VALUES
(1, '王宏', '', 2),
(2, '王小均', '', 1),
(3, '徐琴', '', 3),
(9, 'xyg', NULL, 2),
(22, '师忠敏', '', 4),
(23, '张', NULL, 3),
(24, '张三', NULL, 3),
(25, '李四', NULL, 1),
(26, '王五', NULL, 2),
(27, '张三', NULL, 4),
(28, '张三', NULL, 4),
(29, '王五', NULL, 1),
(43, '王', NULL, 1),
(44, '王小', NULL, 1),
(45, '王五ttt', NULL, 1),
(46, '五五五', NULL, 1),
(47, '五', NULL, 1),
(48, '王六', NULL, 3),
(49, '王五', NULL, 3);

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

INSERT INTO `options` (`id`, `name`, `support`, `url`, `entrynum`) VALUES
(1, '我嘉abc', NULL, NULL, NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=481 ;

--
-- 转存表中的数据 `subjects`
--

INSERT INTO `subjects` (`id`, `sbj_number`, `sbj_name`, `sbj_cat`, `sbj_table`, `has_sub`, `balance_set`, `start_balance`) VALUES
(24, 1001, '库存现金', '1', NULL, 0, 1, 0),
(25, 1002, '银行存款', '1', NULL, 1, 1, 0),
(26, 1003, '存放中央银行款项', '1', NULL, 0, 1, 0),
(27, 1102, '短期投资跌价准备', '1', NULL, 0, 1, 0),
(28, 1021, '结算备付金', '1', NULL, 0, 1, 0),
(29, 1031, '存出保证金', '1', NULL, 0, 1, 0),
(30, 1101, '交易性金融资产', '1', NULL, 1, 1, 0),
(31, 1111, '买入返售金融资产', '1', NULL, 0, 1, 0),
(32, 1121, '应收票据', '1', NULL, 0, 1, 0),
(33, 1122, '应收账款', '1', NULL, 0, 1, 0),
(34, 1123, '预付账款', '1', NULL, 1, 1, 0),
(35, 1131, '应收股利', '1', NULL, 0, 1, 0),
(36, 1132, '应收利息', '1', NULL, 0, 1, 0),
(37, 1201, '应收代位追偿款', '1', NULL, 0, 1, 0),
(38, 1211, '应收分保账款', '1', NULL, 0, 1, 0),
(39, 1212, '应收分保合同准备金', '1', NULL, 0, 1, 0),
(40, 1221, '其他应收款', '1', NULL, 1, 1, 0),
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
(66, 1511, '长期股权投资', '1', NULL, 1, 1, 0),
(67, 1512, '长期股权投资减值准备', '1', NULL, 0, 1, 0),
(68, 1521, '投资性房地产', '1', NULL, 0, 1, 0),
(69, 1531, '长期应收款', '1', NULL, 0, 1, 0),
(70, 1532, '未实现融资收益', '1', NULL, 0, 1, 0),
(71, 1541, '存出资本保证金', '1', NULL, 0, 1, 0),
(72, 1601, '固定资产', '1', NULL, 1, 1, 0),
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
(228, 2001, '短期借款', '2', NULL, 1, 1, 0),
(229, 2002, '存入保证金', '2', NULL, 0, 1, 0),
(230, 2003, '拆入资金', '2', NULL, 0, 1, 0),
(231, 2004, '向中央银行借款', '2', NULL, 0, 1, 0),
(232, 2011, '吸收存款', '2', NULL, 0, 1, 0),
(233, 2012, '同业存放', '2', NULL, 0, 1, 0),
(234, 2021, '贴现负债', '2', NULL, 0, 1, 0),
(235, 2101, '交易性金融负债', '2', NULL, 0, 1, 0),
(276, 2111, '卖出回购金融资产款金', '2', NULL, 0, 1, 0),
(277, 2201, '应付票据', '2', NULL, 0, 1, 0),
(278, 2202, '应付账款', '2', NULL, 1, 1, 0),
(279, 2203, '预收账款', '2', NULL, 1, 1, 0),
(280, 2211, '应付职工薪酬', '2', NULL, 0, 1, 0),
(281, 2221, '应交税费', '2', NULL, 1, 1, 0),
(282, 2231, '应付利息', '2', NULL, 0, 1, 0),
(283, 2232, '应付股利', '2', NULL, 1, 1, 0),
(284, 2241, '其他应付款', '2', NULL, 1, 1, 0),
(285, 2251, '应付保单红利', '2', NULL, 0, 1, 0),
(286, 2261, '应付分保账款', '2', NULL, 0, 1, 0),
(287, 2311, '代理买卖证券款', '2', NULL, 0, 1, 0),
(288, 2312, '代理承销证券款', '2', NULL, 0, 1, 0),
(289, 2313, '代理兑付证券款', '2', NULL, 0, 1, 0),
(290, 2314, '代理业务负债', '2', NULL, 0, 1, 0),
(291, 2401, '递延收益', '2', NULL, 0, 1, 0),
(292, 2501, '长期借款', '2', NULL, 1, 1, 0),
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
(315, 6051, '其他业务收入', '4', NULL, 1, 1, 0),
(316, 6061, '汇兑损益', '4', NULL, 0, 1, 0),
(317, 6101, '公允价值变动损益', '4', NULL, 0, 1, 0),
(318, 6111, '投资收益', '4', NULL, 1, 1, 0),
(319, 6201, '摊回保险责任准备金', '4', NULL, 0, 1, 0),
(320, 6202, '摊回赔付支出', '4', NULL, 0, 1, 0),
(321, 6203, '摊回分保费用', '4', NULL, 0, 1, 0),
(322, 6301, '营业外收入', '4', NULL, 1, 1, 0),
(323, 6401, '主营业务成本', '5', NULL, 1, 1, 0),
(324, 6402, '其他业务支出', '5', NULL, 1, 1, 0),
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
(335, 6601, '销售费用', '5', NULL, 1, 1, 0),
(336, 6602, '管理费用', '5', NULL, 1, 1, 0),
(337, 6603, '财务费用', '5', NULL, 1, 1, 0),
(338, 6604, '勘探费用', '5', NULL, 0, 1, 0),
(339, 6701, '资产减值损失', '5', NULL, 0, 1, 0),
(340, 6711, '营业外支出', '5', NULL, 0, 1, 0),
(341, 6801, '所得税费用', '5', NULL, 0, 1, 0),
(342, 6901, '以前年度损益调整', '5', NULL, 0, 1, 0),
(343, 1412, '包装物及低值易耗品', '1', NULL, 0, 1, 0),
(344, 220201, '应付账款-新法师（上海）科技咨询有限公司', '1', NULL, 0, 0, 0),
(345, 220202, '应付账款-上海安畅网络科技股份有限公司', '1', NULL, 0, 0, 0),
(346, 224101, '其他应付款-徐琴', '2', NULL, 0, 0, 0),
(347, 112301, '预付账款-上海卓悠网络科技有限公司', '1', NULL, 0, 0, 0),
(405, 660201, '工资', '5', NULL, 0, 0, 0),
(406, 640101, '工资', '5', NULL, 0, 0, 0),
(407, 660101, '工资', '5', NULL, 0, 0, 0),
(408, 224102, '王小均', '2', NULL, 0, 0, 0),
(409, 224103, '王宏', '2', NULL, 0, 0, 0),
(410, 224104, 'xyg', '2', NULL, 0, 0, 0),
(415, 122101, '王宏', '1', NULL, 0, 0, 0),
(416, 122102, '王小均', '1', NULL, 0, 0, 0),
(417, 122103, '徐琴', '1', NULL, 0, 0, 0),
(418, 122104, 'xyg', '1', NULL, 0, 0, 0),
(419, 122105, '其他应收', '1', NULL, 0, 0, 0),
(420, 160101, '电子设备', '1', NULL, 0, 0, 0),
(421, 160102, '办公设备', '1', NULL, 0, 0, 0),
(422, 160103, '运输设备', '1', NULL, 0, 0, 0),
(423, 160104, '生产设备', '1', NULL, 0, 0, 0),
(425, 660202, '研发费', '5', NULL, 0, 0, 0),
(427, 660203, '塑料', '5', NULL, 0, 0, 0),
(428, 660102, '办公用品', '5', NULL, 0, 0, 0),
(430, 151102, '禾', '1', NULL, 0, 0, 0),
(431, 151103, '禾木', '1', NULL, 0, 0, 0),
(432, 110101, '股票', '1', NULL, 0, 0, 0),
(433, 110102, '基金', '1', NULL, 0, 0, 0),
(434, 110103, '债券', '1', NULL, 0, 0, 0),
(435, 660301, '汇兑损益', '5', NULL, 0, 0, 0),
(436, 640201, '材料销售', '5', NULL, 0, 0, 0),
(437, 640202, '技术转让', '5', NULL, 0, 0, 0),
(438, 640203, '固定资产租赁', '5', NULL, 0, 0, 0),
(439, 223201, '永安信息', '2', NULL, 0, 0, 0),
(442, 220301, 'wf', '2', NULL, 0, 0, 0),
(443, 611101, 'tzs1', '4', NULL, 0, 0, 0),
(444, 660302, '利息费用', '5', NULL, 0, 0, 0),
(445, 605101, '材料销售', '4', NULL, 0, 0, 0),
(446, 605102, '技术转让', '4', NULL, 0, 0, 0),
(447, 222101, '个人所得税', '2', NULL, 0, 0, 0),
(448, 222102, '应交增值税-进项税', '1', NULL, 0, 0, 0),
(449, 100201, 'rmyh', '1', NULL, 0, 0, 0),
(450, 630101, '6301', '4', NULL, 0, 0, 0),
(451, 224105, 'xj', '2', NULL, 0, 0, 0),
(452, 224106, 'abcd', '2', NULL, 0, 0, 0),
(453, 112302, 'test', '1', NULL, 0, 0, 0),
(454, 220302, 'ttt', '2', NULL, 0, 0, 0),
(455, 220303, 'ysz', '2', NULL, 0, 0, 0),
(456, 224107, '师忠敏', '2', NULL, 0, 0, 0),
(457, 122106, 'test', '1', NULL, 0, 0, 0),
(458, 122107, 'a公司', '1', NULL, 0, 0, 0),
(459, 112303, '王', '1', NULL, 0, 0, 0),
(460, 224108, '李四', '2', NULL, 0, 0, 0),
(461, 224109, '张三', '2', NULL, 0, 0, 0),
(462, 122108, '师忠敏', '1', NULL, 0, 0, 0),
(463, 110104, '其他', '1', NULL, 0, 0, 0),
(464, 660204, '社保', '5', NULL, 0, 0, 0),
(465, 122109, 'gaga', '1', NULL, 0, 0, 0),
(466, 122110, 'gaggg', '1', NULL, 0, 0, 0),
(467, 122111, 'ga', '1', NULL, 0, 0, 0),
(468, 122112, 'ag', '1', NULL, 0, 0, 0),
(470, 122113, '张三', '1', NULL, 0, 0, 0),
(471, 640102, '社保', '5', NULL, 0, 0, 0),
(472, 224110, '王五', '2', NULL, 0, 0, 0),
(473, 224111, '王五ttt', '2', NULL, 0, 0, 0),
(474, 200101, '短期借款test', '2', NULL, 0, 0, 0),
(475, 200102, 'bbb', '2', NULL, 0, 0, 0),
(476, 200103, 'ttt', '2', NULL, 0, 0, 0),
(477, 250101, '长期测试', '2', NULL, 0, 0, 0),
(478, 660103, '社保', '5', NULL, 0, 0, 0),
(479, 224112, '王六', '2', NULL, 0, 0, 0),
(480, 122114, '王五', '1', NULL, 0, 0, 0);

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
  `entry_name` varchar(512) DEFAULT NULL COMMENT '交易方名称',
  `data_type` tinyint(4) DEFAULT NULL COMMENT '类型1：银行,2：现金',
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=188 ;

--
-- 转存表中的数据 `transition`
--

INSERT INTO `transition` (`id`, `entry_num_prefix`, `entry_num`, `entry_time`, `entry_date`, `entry_name`, `data_type`, `data_id`, `entry_memo`, `entry_transaction`, `entry_subject`, `entry_amount`, `entry_appendix`, `entry_appendix_type`, `entry_appendix_id`, `entry_creater`, `entry_editor`, `entry_reviewer`, `entry_deleted`, `entry_reviewed`, `entry_posting`, `entry_settlement`, `entry_closing`) VALUES
(98, '201502', 34, '2015-04-08 07:10:43', '2015-02-01 16:00:00', '1', 1, 15, '社保', 2, 2211, '500.00', NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, 0, 0),
(99, '201502', 34, '2015-04-08 07:10:43', '2015-02-01 16:00:00', '1', 1, 15, '社保', 1, 1002, '500.00', NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, 0, 0),
(100, '201502', 35, '2015-04-08 07:10:43', '2015-01-31 16:00:00', '2', 1, 16, '工资', 2, 660204, '4000.00', NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, 0, 0),
(101, '201502', 35, '2015-04-08 07:10:43', '2015-01-31 16:00:00', '2', 1, 16, '工资', 1, 1002, '4000.00', NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, 0, 0),
(102, '201502', 36, '2015-04-08 07:17:42', '2015-02-01 16:00:00', '', 1, 17, '社保', 2, 2211, '500.00', NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, 0, 0),
(103, '201502', 36, '2015-04-08 07:17:42', '2015-02-01 16:00:00', '', 1, 17, '社保', 1, 1002, '500.00', NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, 0, 0),
(104, '201502', 37, '2015-04-08 07:18:58', '2015-02-01 16:00:00', '', 1, 20, '社保', 2, 2211, '500.00', NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, 0, 0),
(105, '201502', 37, '2015-04-08 07:18:58', '2015-02-01 16:00:00', '', 1, 20, '社保', 1, 1002, '500.00', NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, 0, 0),
(110, '201502', 40, '2015-04-15 03:07:07', '2015-02-01 16:00:00', '3', 1, 26, '社保', 2, 2211, '333.00', NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, 0, 0),
(111, '201502', 40, '2015-04-15 03:07:07', '2015-02-01 16:00:00', '3', 1, 26, '社保', 1, 1002, '333.00', NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, 0, 0),
(112, '201502', 41, '2015-04-15 03:07:08', '2015-02-01 16:00:00', '2', 1, 27, '社保', 2, 2241, '222.00', NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, 0, 0),
(113, '201502', 41, '2015-04-15 03:07:08', '2015-02-01 16:00:00', '2', 1, 27, '社保', 1, 1002, '222.00', NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, 0, 0),
(114, '201502', 42, '2015-04-15 03:15:33', '2015-02-01 16:00:00', '', 1, 35, '社保', 2, 2211, '333.00', NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, 0, 0),
(115, '201502', 42, '2015-04-15 03:15:33', '2015-02-01 16:00:00', '', 1, 35, '社保', 1, 1002, '333.00', NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, 0, 0),
(126, '201502', 48, '2015-04-15 03:36:50', '2015-01-31 16:00:00', '', 1, 24, '工资24', 2, 2211, '4.00', NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, 0, 0),
(127, '201502', 48, '2015-04-15 03:36:50', '2015-01-31 16:00:00', '', 1, 24, '工资24', 1, 1002, '4.00', NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, 0, 0),
(128, '201502', 49, '2015-04-15 03:36:50', '2015-02-01 16:00:00', '', 1, 21, '社保', 2, 2211, '3.00', NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, 0, 0),
(129, '201502', 49, '2015-04-15 03:36:50', '2015-02-01 16:00:00', '', 1, 21, '社保', 1, 1002, '3.00', NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, 0, 0),
(130, '201502', 50, '2015-04-15 03:36:51', '2015-02-01 16:00:00', '', 1, 22, '社保', 2, 2211, '2.00', NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, 0, 0),
(131, '201502', 50, '2015-04-15 03:36:51', '2015-02-01 16:00:00', '', 1, 22, '社保', 1, 1002, '2.00', NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, 0, 0),
(166, '201503', 1, '2015-04-15 05:14:32', '2015-03-01 16:00:00', 'testf', 1, 59, '社保fff', 2, 2241, '954.00', NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, 0, 0),
(167, '201503', 1, '2015-04-15 05:14:32', '2015-03-01 16:00:00', 'testf', 1, 59, '社保fff', 1, 1002, '954.00', NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, 0, 0),
(168, '201502', 51, '2015-04-15 05:20:49', '2015-01-31 16:00:00', '', 1, 60, '工资', 2, 220201, '30.00', NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, 0, 0),
(169, '201502', 51, '2015-04-15 05:20:49', '2015-01-31 16:00:00', '', 1, 60, '工资', 1, 1002, '30.00', NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, 0, 0),
(170, '201502', 52, '2015-04-15 05:27:17', '2015-01-31 16:00:00', '', 1, 61, '工资', 2, 220201, '30.00', NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, 0, 0),
(171, '201502', 52, '2015-04-15 05:27:17', '2015-01-31 16:00:00', '', 1, 61, '工资', 1, 1002, '30.00', NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, 0, 0),
(172, '201502', 53, '2015-04-15 05:27:59', '2015-01-31 16:00:00', '333', 1, 62, '工资', 2, 220202, '-86.50', NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, 0, 0),
(173, '201502', 53, '2015-04-15 05:27:59', '2015-01-31 16:00:00', '333', 1, 62, '工资', 1, 1002, '30.00', NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, 0, 0),
(174, '201502', 53, '2015-04-15 05:27:59', '2015-01-31 16:00:00', '333', 1, 62, '工资', 2, 222102, '116.50', NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, 0, 0),
(175, '201502', 54, '2015-04-15 05:28:53', '2015-01-31 16:00:00', '3', 1, 63, '工资', 2, 220201, '291.26', NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, 0, 0),
(176, '201502', 54, '2015-04-15 05:28:53', '2015-01-31 16:00:00', '3', 1, 63, '工资', 1, 1002, '300.00', NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, 0, 0),
(177, '201502', 54, '2015-04-15 05:28:54', '2015-01-31 16:00:00', '3', 1, 63, '工资', 2, 222102, '8.74', NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, 0, 0),
(178, '201502', 55, '2015-04-15 05:30:57', '2015-02-01 16:00:00', '3', 1, 64, '社保', 2, 220201, '29.13', NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, 0, 0),
(179, '201502', 55, '2015-04-15 05:30:58', '2015-02-01 16:00:00', '3', 1, 64, '社保', 1, 1002, '30.00', NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, 0, 0),
(180, '201502', 55, '2015-04-15 05:30:58', '2015-02-01 16:00:00', '3', 1, 64, '社保', 2, 222102, '0.87', NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, 0, 0),
(181, '201502', 56, '2015-04-15 06:09:21', '2015-02-01 16:00:00', '3', 1, 65, '社保', 2, 220201, '29.13', NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, 0, 0),
(182, '201502', 56, '2015-04-15 06:09:21', '2015-02-01 16:00:00', '3', 1, 65, '社保', 1, 1002, '30.00', NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, 0, 0),
(183, '201502', 56, '2015-04-15 06:09:22', '2015-02-01 16:00:00', '3', 1, 65, '社保', 2, 222102, '0.87', NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, 0, 0),
(184, '201502', 57, '2015-04-15 09:51:05', '2015-01-31 16:00:00', '王', 1, 66, '工资', 2, 250101, '4000.00', NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, 0, 0),
(185, '201502', 57, '2015-04-15 09:51:05', '2015-01-31 16:00:00', '王', 1, 66, '工资', 1, 1002, '4000.00', NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, 0, 0),
(186, '201502', 58, '2015-04-15 10:46:42', '2015-02-01 16:00:00', '11111', 1, 67, '社保', 2, 224112, '500.00', NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, 0, 0),
(187, '201502', 58, '2015-04-15 10:46:43', '2015-02-01 16:00:00', '11111', 1, 67, '社保', 1, 1002, '500.00', NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, 0, 0);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 视图结构 `transitiondate`
--
DROP TABLE IF EXISTS `transitiondate`;

CREATE ALGORITHM=UNDEFINED DEFINER=`jason`@`localhost` SQL SECURITY DEFINER VIEW `transitiondate` AS select max(`transition`.`entry_num_prefix`) AS `date` from `transition` where ((`transition`.`entry_closing` = 1) or (`transition`.`entry_settlement` = 1));

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
-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2015-03-25 07:53:40
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `account_abc`
--

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `type` int(11) NOT NULL COMMENT '1\\2\\3\\4 为生产部门、管理部门、销售部门 、研发部门',
  `memo` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `department`
--

INSERT INTO `department` (`id`, `name`, `type`, `memo`) VALUES
(1, '研发部', 4, '研发部'),
(2, '生产厂区部门1', 1, ''),
(3, '行政管理', 2, ''),
(4, '销售人员部门', 3, '');

-- --------------------------------------------------------

--
-- 表的结构 `employee`
--

CREATE TABLE IF NOT EXISTS `employee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `memo` varchar(200) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- 转存表中的数据 `employee`
--

INSERT INTO `employee` (`id`, `name`, `memo`, `department_id`) VALUES
(1, '王宏', '', 2),
(2, '王小均', '', 1),
(3, '徐琴', '', 3),
(9, 'xyg', NULL, 2),
(22, '师忠敏', '', 4);

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

INSERT INTO `options` (`id`, `name`, `support`, `url`, `entrynum`) VALUES
(1, '我嘉abc', NULL, NULL, NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=440 ;

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
(30, 1101, '交易性金融资产', '1', NULL, 1, 1, 0),
(31, 1111, '买入返售金融资产', '1', NULL, 0, 1, 0),
(32, 1121, '应收票据', '1', NULL, 0, 1, 0),
(33, 1122, '应收账款', '1', NULL, 0, 1, 0),
(34, 1123, '预付账款', '1', NULL, 1, 1, 0),
(35, 1131, '应收股利', '1', NULL, 0, 1, 0),
(36, 1132, '应收利息', '1', NULL, 0, 1, 0),
(37, 1201, '应收代位追偿款', '1', NULL, 0, 1, 0),
(38, 1211, '应收分保账款', '1', NULL, 0, 1, 0),
(39, 1212, '应收分保合同准备金', '1', NULL, 0, 1, 0),
(40, 1221, '其他应收款', '1', NULL, 1, 1, 0),
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
(66, 1511, '长期股权投资', '1', NULL, 1, 1, 0),
(67, 1512, '长期股权投资减值准备', '1', NULL, 0, 1, 0),
(68, 1521, '投资性房地产', '1', NULL, 0, 1, 0),
(69, 1531, '长期应收款', '1', NULL, 0, 1, 0),
(70, 1532, '未实现融资收益', '1', NULL, 0, 1, 0),
(71, 1541, '存出资本保证金', '1', NULL, 0, 1, 0),
(72, 1601, '固定资产', '1', NULL, 1, 1, 0),
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
(278, 2202, '应付账款', '2', NULL, 1, 1, 0),
(279, 2203, '预收账款', '2', NULL, 0, 1, 0),
(280, 2211, '应付职工薪酬', '2', NULL, 0, 1, 0),
(281, 2221, '应交税费', '2', NULL, 0, 1, 0),
(282, 2231, '应付利息', '2', NULL, 0, 1, 0),
(283, 2232, '应付股利', '2', NULL, 1, 1, 0),
(284, 2241, '其他应付款', '2', NULL, 1, 1, 0),
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
(323, 6401, '主营业务成本', '5', NULL, 1, 1, 0),
(324, 6402, '其他业务支出', '5', NULL, 1, 1, 0),
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
(335, 6601, '销售费用', '5', NULL, 1, 1, 0),
(336, 6602, '管理费用', '5', NULL, 1, 1, 0),
(337, 6603, '财务费用', '5', NULL, 1, 1, 0),
(338, 6604, '勘探费用', '5', NULL, 0, 1, 0),
(339, 6701, '资产减值损失', '5', NULL, 0, 1, 0),
(340, 6711, '营业外支出', '5', NULL, 0, 1, 0),
(341, 6801, '所得税费用', '5', NULL, 0, 1, 0),
(342, 6901, '以前年度损益调整', '5', NULL, 0, 1, 0),
(343, 1412, '包装物及低值易耗品', '1', NULL, 0, 1, 0),
(344, 220201, '应付账款-新法师（上海）科技咨询有限公司', '1', NULL, 0, 0, 0),
(345, 220202, '应付账款-上海安畅网络科技股份有限公司', '1', NULL, 0, 0, 0),
(346, 224101, '其他应付款-徐琴', '2', NULL, 0, 0, 0),
(347, 112301, '预付账款-上海卓悠网络科技有限公司', '1', NULL, 0, 0, 0),
(405, 660201, '工资', '5', NULL, 0, 0, 0),
(406, 640101, '工资', '5', NULL, 0, 0, 0),
(407, 660101, '工资', '5', NULL, 0, 0, 0),
(408, 224102, '王小均', '2', NULL, 0, 0, 0),
(409, 224103, '王宏', '2', NULL, 0, 0, 0),
(410, 224104, 'xyg', '2', NULL, 0, 0, 0),
(415, 122101, '王宏', '1', NULL, 0, 0, 0),
(416, 122102, '王小均', '1', NULL, 0, 0, 0),
(417, 122103, '徐琴', '1', NULL, 0, 0, 0),
(418, 122104, 'xyg', '1', NULL, 0, 0, 0),
(419, 122105, '其他应收', '1', NULL, 0, 0, 0),
(420, 160101, '电子设备', '1', NULL, 0, 0, 0),
(421, 160102, '办公设备', '1', NULL, 0, 0, 0),
(422, 160103, '运输设备', '1', NULL, 0, 0, 0),
(423, 160104, '生产设备', '1', NULL, 0, 0, 0),
(425, 660202, '研发费', '5', NULL, 0, 0, 0),
(427, 660203, '塑料', '5', NULL, 0, 0, 0),
(428, 660102, '办公用品', '5', NULL, 0, 0, 0),
(430, 151102, '禾', '1', NULL, 0, 0, 0),
(431, 151103, '禾木', '1', NULL, 0, 0, 0),
(432, 110101, '股票', '1', NULL, 0, 0, 0),
(433, 110102, '基金', '1', NULL, 0, 0, 0),
(434, 110103, '其他', '1', NULL, 0, 0, 0),
(435, 660301, '汇兑损益', '5', NULL, 0, 0, 0),
(436, 640201, '材料销售', '5', NULL, 0, 0, 0),
(437, 640202, '技术转让', '5', NULL, 0, 0, 0),
(438, 640203, '固定资产出租', '5', NULL, 0, 0, 0),
(439, 223201, '永安信息', '2', NULL, 0, 0, 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- 转存表中的数据 `transition`
--

INSERT INTO `transition` (`id`, `entry_num_prefix`, `entry_num`, `entry_time`, `entry_date`, `entry_memo`, `entry_transaction`, `entry_subject`, `entry_amount`, `entry_appendix`, `entry_appendix_type`, `entry_appendix_id`, `entry_creater`, `entry_editor`, `entry_reviewer`, `entry_deleted`, `entry_reviewed`, `entry_posting`, `entry_settlement`, `entry_closing`) VALUES
(19, '201502', 1, '2015-03-24 09:36:14', '2015-02-01 16:00:00', '社保', 1, 2241, '500.00', NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, 0, 0),
(20, '201502', 1, '2015-03-24 09:36:14', '2015-02-01 16:00:00', '社保', 2, 1002, '500.00', NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, 0, 0),
(21, '201502', 2, '2015-03-24 09:36:14', '2015-01-31 16:00:00', '工资', 1, 660101, '4000.00', NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, 0, 0),
(22, '201502', 2, '2015-03-24 09:36:14', '2015-01-31 16:00:00', '工资', 2, 1002, '4000.00', NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, 0, 0);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 视图结构 `transitiondate`
--
DROP TABLE IF EXISTS `transitiondate`;

CREATE ALGORITHM=UNDEFINED DEFINER=`jason`@`localhost` SQL SECURITY DEFINER VIEW `transitiondate` AS select max(`transition`.`entry_num_prefix`) AS `date` from `transition` where ((`transition`.`entry_closing` = 1) or (`transition`.`entry_settlement` = 1));

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
