CREATE DATABASE  IF NOT EXISTS `account` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `account`;
-- MySQL dump 10.13  Distrib 5.6.13, for osx10.6 (i386)
--
-- Host: 127.0.0.1    Database: account
-- ------------------------------------------------------
-- Server version	5.6.13

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `client`
--

DROP TABLE IF EXISTS `client`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vat` varchar(45) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `add` varchar(100) DEFAULT NULL,
  `memo` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client`
--

LOCK TABLES `client` WRITE;
/*!40000 ALTER TABLE `client` DISABLE KEYS */;
/*!40000 ALTER TABLE `client` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `department`
--

DROP TABLE IF EXISTS `department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `memo` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `department`
--

LOCK TABLES `department` WRITE;
/*!40000 ALTER TABLE `department` DISABLE KEYS */;
/*!40000 ALTER TABLE `department` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employee` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `memo` varchar(200) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  CONSTRAINT `department_id` FOREIGN KEY (`id`) REFERENCES `department` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee`
--

LOCK TABLES `employee` WRITE;
/*!40000 ALTER TABLE `employee` DISABLE KEYS */;
/*!40000 ALTER TABLE `employee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `options`
--

DROP TABLE IF EXISTS `options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `options` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `support` varchar(100) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `entrynum` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `options`
--

LOCK TABLES `options` WRITE;
/*!40000 ALTER TABLE `options` DISABLE KEYS */;
/*!40000 ALTER TABLE `options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project`
--

DROP TABLE IF EXISTS `project`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project` (
  `id` int(11) NOT NULL,
  `name` varchar(60) DEFAULT NULL,
  `memo` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project`
--

LOCK TABLES `project` WRITE;
/*!40000 ALTER TABLE `project` DISABLE KEYS */;
/*!40000 ALTER TABLE `project` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subject`
--

DROP TABLE IF EXISTS `subject`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subject` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no` int(12) NOT NULL DEFAULT '0',
  `name` varchar(256) CHARACTER SET gbk COLLATE gbk_bin DEFAULT NULL,
  `category` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `no` (`no`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subject`
--

LOCK TABLES `subject` WRITE;
/*!40000 ALTER TABLE `subject` DISABLE KEYS */;
INSERT INTO `subject` VALUES (1,1001,'库存现金',1),(2,1002,'银行存款',1),(3,1003,'存放中央银行款项',1),(4,1102,'短期投资跌价准备',1),(5,100101,'库存现金01',1),(6,100102,'库存现金02',1),(7,1021,'结算备付金',1),(8,1031,'存出保证金',1),(9,1101,'交易性金融资产',1),(10,1111,'买入返售金融资产',1),(11,1121,'应收票据',1),(12,1122,'应收账款',1);
/*!40000 ALTER TABLE `subject` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subjects`
--

DROP TABLE IF EXISTS `subjects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sbj_number` int(12) NOT NULL DEFAULT '0',
  `sbj_name` varchar(20) DEFAULT NULL,
  `sbj_cat` varchar(100) DEFAULT NULL,
  `sbj_table` varchar(200) DEFAULT NULL,
  `has_sub` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `No` (`sbj_number`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subjects`
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
LOCK TABLES `subjects` WRITE;
/*!40000 ALTER TABLE `subjects` DISABLE KEYS */;
INSERT INTO `subjects` VALUES (1,1001,'库存现金','1','',0),(2,1002,'银行存款','1',NULL,0),(3,1003,'存放中央银行款项','1',NULL,0),(4,1102,'短期投资跌价准备','1',NULL,0),(9,1021,'结算备付金','1','',0),(10,100101,'wer','12','',0);
/*!40000 ALTER TABLE `subjects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transition`
--

DROP TABLE IF EXISTS `transition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transition` (
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
  KEY `ed_employee_id_idx` (`entry_editor`),
  CONSTRAINT `subject_id` FOREIGN KEY (`entry_subject`) REFERENCES `subjects` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `ed_employee_id` FOREIGN KEY (`entry_editor`) REFERENCES `employee` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `re_employee_id` FOREIGN KEY (`entry_reviewer`) REFERENCES `employee` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transition`
--

LOCK TABLES `transition` WRITE;
/*!40000 ALTER TABLE `transition` DISABLE KEYS */;
/*!40000 ALTER TABLE `transition` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vendor`
--

DROP TABLE IF EXISTS `vendor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vendor` (
  `id` int(11) NOT NULL,
  `vat` varchar(45) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `add` varchar(100) DEFAULT NULL,
  `memo` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vendor`
--

LOCK TABLES `vendor` WRITE;
/*!40000 ALTER TABLE `vendor` DISABLE KEYS */;
/*!40000 ALTER TABLE `vendor` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-12-06 21:57:11
