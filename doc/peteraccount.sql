-- MySQL dump 10.13  Distrib 5.5.36, for osx10.9 (i386)
--
-- Host: localhost    Database: account
-- ------------------------------------------------------
-- Server version	5.5.36

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
  `company` varchar(256) NOT NULL,
  `vat` varchar(45) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `add` varchar(100) DEFAULT NULL,
  `memo` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client`
--

LOCK TABLES `client` WRITE;
/*!40000 ALTER TABLE `client` DISABLE KEYS */;
INSERT INTO `client` VALUES (1,'client1','client1',NULL,NULL,NULL);
/*!40000 ALTER TABLE `client` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `department`
--

DROP TABLE IF EXISTS `department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `memo` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `department`
--

LOCK TABLES `department` WRITE;
/*!40000 ALTER TABLE `department` DISABLE KEYS */;
INSERT INTO `department` VALUES (1,'财务部','真的是财务部'),(2,'人事','人事');
/*!40000 ALTER TABLE `department` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `memo` varchar(200) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  CONSTRAINT `department_id` FOREIGN KEY (`id`) REFERENCES `department` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee`
--

LOCK TABLES `employee` WRITE;
/*!40000 ALTER TABLE `employee` DISABLE KEYS */;
INSERT INTO `employee` VALUES (1,'雇员1号','雇员1号',1),(2,'雇员2','e2',1);
/*!40000 ALTER TABLE `employee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `meta`
--

DROP TABLE IF EXISTS `meta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `meta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `option` varchar(32) CHARACTER SET utf8 NOT NULL COMMENT '属性名称',
  `value` varchar(256) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meta`
--

LOCK TABLES `meta` WRITE;
/*!40000 ALTER TABLE `meta` DISABLE KEYS */;
INSERT INTO `meta` VALUES (1,'transitionDate','201401');
/*!40000 ALTER TABLE `meta` ENABLE KEYS */;
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
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject_id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `balance` double NOT NULL,
  `posted` tinyint(1) NOT NULL DEFAULT '0',
  `debit` double NOT NULL DEFAULT '0' COMMENT '借',
  `credit` double NOT NULL DEFAULT '0' COMMENT '贷',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_subject_id_idx` (`subject_id`),
  CONSTRAINT `fk_subject_id` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`sbj_number`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post`
--

LOCK TABLES `post` WRITE;
/*!40000 ALTER TABLE `post` DISABLE KEYS */;
INSERT INTO `post` VALUES (2,1002,2013,12,100,1,0,0),(3,4103,2013,12,0,1,0,0),(4,6411,2013,12,0,1,0,0),(5,6421,2013,12,0,1,0,0),(6,6501,2013,12,0,1,0,0),(7,6502,2013,12,0,1,0,0),(8,6511,2013,12,0,1,0,0),(9,6521,2013,12,0,1,0,0),(10,6531,2013,12,0,1,0,0),(11,6541,2013,12,0,1,0,0),(12,6542,2013,12,0,1,0,0),(13,6601,2013,12,0,1,0,0),(14,6602,2013,12,0,1,0,0),(15,6603,2013,12,0,1,0,0),(16,6604,2013,12,0,1,0,0),(17,6701,2013,12,0,1,0,0),(18,6711,2013,12,0,1,0,0),(19,6801,2013,12,0,1,0,0),(20,6901,2013,12,0,1,0,0),(21,6403,2013,12,0,1,0,0),(22,6402,2013,12,0,1,0,0),(24,4103,2013,11,0,1,0,0),(25,6403,2013,11,0,1,0,0),(26,6402,2013,11,0,1,0,0),(27,6401,2013,11,0,1,0,0),(28,6301,2013,11,0,1,0,0),(29,6203,2013,11,0,1,0,0),(30,6202,2013,11,0,1,0,0),(31,6201,2013,11,0,1,0,0),(32,6101,2013,11,0,1,0,0),(33,6111,2013,11,0,1,0,0),(34,6061,2013,11,0,1,0,0),(35,6051,2013,11,0,1,0,0),(36,6041,2013,11,0,1,0,0),(37,6031,2013,11,0,1,0,0),(38,6021,2013,11,0,1,0,0),(39,6011,2013,11,0,1,0,0),(40,6411,2013,11,0,1,0,0),(41,6421,2013,11,0,1,0,0),(42,6501,2013,11,0,1,0,0),(43,6901,2013,11,0,1,0,0),(44,6401,2013,12,0,1,0,0),(45,6301,2013,12,0,1,0,0),(46,6203,2013,12,0,1,0,0),(47,6202,2013,12,0,1,0,0),(48,6201,2013,12,0,1,0,0),(49,6101,2013,12,0,1,0,0),(50,6502,2013,11,0,1,0,0),(51,6511,2013,11,0,1,0,0),(52,6521,2013,11,0,1,0,0),(53,6531,2013,11,0,1,0,0),(54,6541,2013,11,0,1,0,0),(55,6542,2013,11,0,1,0,0),(56,6601,2013,11,0,1,0,0),(57,6602,2013,11,0,1,0,0),(58,6603,2013,11,0,1,0,0),(59,6604,2013,11,0,1,0,0),(60,6701,2013,11,0,1,0,0),(61,6711,2013,11,0,1,0,0),(62,6801,2013,11,0,1,0,0),(63,6001,2013,11,0,1,0,0),(74,10010101,2013,11,0,1,0,0),(75,6111,2013,12,0,1,0,0),(76,10010101,2013,12,0,1,0,0);
/*!40000 ALTER TABLE `post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project`
--

DROP TABLE IF EXISTS `project`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT NULL,
  `memo` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project`
--

LOCK TABLES `project` WRITE;
/*!40000 ALTER TABLE `project` DISABLE KEYS */;
INSERT INTO `project` VALUES (1,'project1','project1\r\nproject1'),(2,'project299999999999','project299999999999');
/*!40000 ALTER TABLE `project` ENABLE KEYS */;
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
  `sbj_cat` varchar(100) DEFAULT NULL COMMENT '1:资产类; 2:负债类; 3:权益类; 4:收入类; 5:费用类',
  `sbj_table` varchar(200) DEFAULT NULL,
  `has_sub` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `No` (`sbj_number`)
) ENGINE=InnoDB AUTO_INCREMENT=356 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subjects`
--

LOCK TABLES `subjects` WRITE;
/*!40000 ALTER TABLE `subjects` DISABLE KEYS */;
INSERT INTO `subjects` VALUES (24,1001,'库存现金','1',NULL,1),(25,1002,'银行存款','1',NULL,0),(26,1003,'存放中央银行款项','1',NULL,0),(27,1102,'短期投资跌价准备','1',NULL,0),(28,1021,'结算备付金','1',NULL,0),(29,1031,'存出保证金','1',NULL,0),(30,1101,'交易性金融资产','1',NULL,0),(31,1111,'买入返售金融资产','1',NULL,0),(32,1121,'应收票据','1',NULL,0),(33,1122,'应收账款','1',NULL,0),(34,1123,'预付账款','1',NULL,0),(35,1131,'应收股利','1',NULL,0),(36,1132,'应收利息','1',NULL,0),(37,1201,'应收代位追偿款','1',NULL,0),(38,1211,'应收分保账款','1',NULL,0),(39,1212,'应收分保合同准备金','1',NULL,0),(40,1221,'其他应收款','1',NULL,0),(41,1231,'坏账准备','1',NULL,0),(42,1301,'贴现资产','1',NULL,0),(43,1302,'拆出资金','1',NULL,0),(44,1303,'贷款','1',NULL,0),(45,1304,'贷款损失准备','1',NULL,0),(46,1311,'代理兑付证券','1',NULL,0),(47,1321,'代理业务资产','1',NULL,0),(48,1401,'材料采购','1',NULL,0),(49,1402,'在途物资','1',NULL,0),(50,1403,'原材料','1',NULL,0),(51,1404,'材料成本差异','1',NULL,0),(52,1405,'库存商品','1',NULL,0),(53,1406,'发出商品','1',NULL,0),(54,1407,'商品进销差价','1',NULL,0),(55,1408,'委托加工物资','1',NULL,0),(56,1411,'周转材料','1',NULL,0),(57,1421,'消耗性生物资产','1',NULL,0),(58,1431,'贵金属','1',NULL,0),(59,1441,'抵债资产','1',NULL,0),(60,1451,'损余物资','1',NULL,0),(61,1461,'融资租赁资产','1',NULL,0),(62,1471,'存货跌价准备','1',NULL,0),(63,1501,'持有至到期投资','1',NULL,0),(64,1502,'持有至到期投资减值准备','1',NULL,0),(65,1503,'可供出售金融资产','1',NULL,0),(66,1511,'长期股权投资','1',NULL,0),(67,1512,'长期股权投资减值准备','1',NULL,0),(68,1521,'投资性房地产','1',NULL,0),(69,1531,'长期应收款','1',NULL,0),(70,1532,'未实现融资收益','1',NULL,0),(71,1541,'存出资本保证金','1',NULL,0),(72,1601,'固定资产','1',NULL,0),(73,1602,'累计折旧','1',NULL,0),(74,1603,'固定资产减值准备','1',NULL,0),(75,1604,'在建工程','1',NULL,0),(76,1605,'工程物资','1',NULL,0),(77,1606,'固定资产清理','1',NULL,0),(78,1611,'未担保余值','1',NULL,0),(79,1621,'生产性生物资产','1',NULL,0),(80,1622,'生产性生物资产累计折旧','1',NULL,0),(81,1623,'公益性生物资产','1',NULL,0),(82,1631,'油气资产','1',NULL,0),(83,1632,'累计折耗','1',NULL,0),(84,1701,'无形资产','1',NULL,0),(85,1702,'累计摊销','1',NULL,0),(86,1703,'无形资产减值准备','1',NULL,0),(87,1711,'商誉','1',NULL,0),(88,1801,'长期待摊费用','1',NULL,0),(89,1811,'递延所得税资产','1',NULL,0),(90,1821,'独立账户资产','1',NULL,0),(91,1901,'待处理财产损溢','1',NULL,0),(228,2001,'短期借款','2',NULL,0),(229,2002,'存入保证金','2',NULL,0),(230,2003,'拆入资金','2',NULL,0),(231,2004,'向中央银行借款','2',NULL,0),(232,2011,'吸收存款','2',NULL,0),(233,2012,'同业存放','2',NULL,0),(234,2021,'贴现负债','2',NULL,0),(235,2101,'交易性金融负债','2',NULL,0),(276,2111,'卖出回购金融资产款金','2',NULL,0),(277,2201,'应付票据','2',NULL,0),(278,2202,'应付账款','2',NULL,0),(279,2203,'预收账款','2',NULL,0),(280,2211,'应付职工薪酬','2',NULL,0),(281,2221,'应交税费','2',NULL,0),(282,2231,'应付利息','2',NULL,0),(283,2232,'应付股利','2',NULL,0),(284,2241,'其他应付款','2',NULL,0),(285,2251,'应付保单红利','2',NULL,0),(286,2261,'应付分保账款','2',NULL,0),(287,2311,'代理买卖证券款','2',NULL,0),(288,2312,'代理承销证券款','2',NULL,0),(289,2313,'代理兑付证券款','2',NULL,0),(290,2314,'代理业务负债','2',NULL,0),(291,2401,'递延收益','2',NULL,0),(292,2501,'长期借款','2',NULL,0),(293,2502,'应付债券','2',NULL,0),(294,2601,'未到期责任准备金','2',NULL,0),(295,2602,'保险责任准备金','2',NULL,0),(296,2611,'保户储金','2',NULL,0),(297,2621,'独立账户负债','2',NULL,0),(298,2701,'长期应付款','2',NULL,0),(299,2702,'未确认融资费用','2',NULL,0),(300,2711,'专项应付款','2',NULL,0),(301,2801,'预计负债','2',NULL,0),(302,2901,'递延所得税负债','2',NULL,0),(303,4001,'实收资本','3',NULL,0),(304,4002,'资本公积','3',NULL,0),(305,4101,'盈余公积','3',NULL,0),(306,4102,'一般风险准备','3',NULL,0),(307,4103,'本年利润','3',NULL,0),(308,4104,'利润分配','3',NULL,0),(309,4201,'库存股','3',NULL,0),(310,6001,'主营业务收入','4',NULL,0),(311,6011,'利息收入','4',NULL,0),(312,6021,'手续费及佣金收入','4',NULL,0),(313,6031,'保费收入','4',NULL,0),(314,6041,'租赁收入','4',NULL,0),(315,6051,'其他业务收入','4',NULL,0),(316,6061,'汇兑损益','4',NULL,0),(317,6101,'公允价值变动损益','4',NULL,0),(318,6111,'投资收益','4',NULL,0),(319,6201,'摊回保险责任准备金','4',NULL,0),(320,6202,'摊回赔付支出','4',NULL,0),(321,6203,'摊回分保费用','4',NULL,0),(322,6301,'营业外收入','4',NULL,0),(323,6401,'主营业务成本','5',NULL,0),(324,6402,'其他业务支出','5',NULL,0),(325,6403,'营业税金及附加','5',NULL,0),(326,6411,'利息支出','5',NULL,0),(327,6421,'手续费及佣金支出','5',NULL,0),(328,6501,'提取未到期责任准备金','5',NULL,0),(329,6502,'提取保险责任准备金','5',NULL,0),(330,6511,'赔付支出','5',NULL,0),(331,6521,'保户红利支出','5',NULL,0),(332,6531,'退保金','5',NULL,0),(333,6541,'分出保费','5',NULL,0),(334,6542,'分保费用','5',NULL,0),(335,6601,'销售费用','5',NULL,0),(336,6602,'管理费用','5',NULL,0),(337,6603,'财务费用','5',NULL,0),(338,6604,'勘探费用','5',NULL,0),(339,6701,'资产减值损失','5',NULL,0),(340,6711,'营业外支出','5',NULL,0),(341,6801,'所得税费用','5',NULL,0),(342,6901,'以前年度损益调整','5',NULL,0),(343,1412,'包装物及低值易耗品','1',NULL,0),(354,100101,'二级科目','1',NULL,1),(355,10010101,'三级科目','1',NULL,0);
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
  `entry_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '录入时间',
  `entry_date` timestamp NULL DEFAULT NULL COMMENT '凭证日期，非录入时间',
  `entry_memo` varchar(512) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT NULL,
  `entry_transaction` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:借;2:贷',
  `entry_subject` int(11) NOT NULL,
  `entry_amount` decimal(12,2) NOT NULL,
  `entry_appendix` text COMMENT '已废弃不用',
  `entry_appendix_type` tinyint(1) DEFAULT NULL COMMENT '1:client;2:vendor;3:employee;4:project',
  `entry_appendix_id` int(8) DEFAULT NULL COMMENT 'client vendor employee project ID',
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
  KEY `ed_employee_id_idx` (`entry_editor`),
  CONSTRAINT `transition_ibfk_1` FOREIGN KEY (`entry_subject`) REFERENCES `subjects` (`sbj_number`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2196 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transition`
--

LOCK TABLES `transition` WRITE;
/*!40000 ALTER TABLE `transition` DISABLE KEYS */;
INSERT INTO `transition` VALUES (2080,'201402',1,'2014-02-08 10:22:12','2014-02-07 16:00:00','ad',1,10010101,11.00,NULL,0,0,2,1,0,1,0,0,0),(2081,'201402',1,'2014-02-08 10:22:12','2014-02-07 16:00:00','ddd',2,10010101,11.00,NULL,0,0,2,1,0,1,0,0,0),(2088,'201401',1,'2014-02-18 07:47:56','2013-12-31 16:00:00','sdf',1,10010101,12.00,NULL,0,0,2,1,0,1,0,0,0),(2089,'201401',1,'2014-02-18 07:47:56','2013-12-31 16:00:00','df',2,6001,12.00,NULL,4,1,2,1,0,1,0,0,0),(2090,'201401',1,'2014-02-18 07:48:03','2013-12-31 16:00:00','sdf',1,10010101,12.00,NULL,0,0,2,1,0,1,0,0,0),(2091,'201401',1,'2014-02-18 07:48:03','2013-12-31 16:00:00','df',2,6001,12.00,NULL,4,1,2,1,0,1,0,0,0),(2092,'201401',2,'2014-02-18 07:48:38','2014-01-07 16:00:00','33',1,10010101,1.00,NULL,0,0,2,1,0,1,0,0,0),(2093,'201401',2,'2014-02-18 07:48:38','2014-01-07 16:00:00','33',2,6101,1.00,NULL,0,0,2,1,0,1,0,0,0),(2094,'201401',3,'2014-02-18 07:49:58','2014-01-22 16:00:00','ff',1,10010101,1.00,NULL,0,0,1,2,0,1,0,0,0),(2095,'201401',3,'2014-02-18 07:49:58','2014-01-22 16:00:00','fd',2,10010101,2.00,NULL,0,0,1,2,0,1,0,0,0),(2096,'201401',3,'2014-02-18 07:50:15','2014-01-22 16:00:00','dd',1,10010101,1.00,NULL,0,0,1,2,0,1,0,0,0),(2124,'201401',4,'2014-02-19 10:15:06','2014-01-13 16:00:00','ccc',1,10010101,11.00,NULL,0,0,1,2,0,1,0,0,0),(2125,'201401',4,'2014-02-19 10:15:06','2014-01-13 16:00:00','d',1,10010101,11.00,NULL,0,0,1,2,0,1,0,0,0),(2126,'201401',4,'2014-02-19 10:15:06','2014-01-13 16:00:00','d',2,10010101,22.00,NULL,0,0,1,2,0,1,0,0,0),(2174,'201402',2,'2014-02-23 11:34:02','2014-02-22 16:00:00','DDd',1,1002,11.00,NULL,0,0,2,1,0,1,0,0,0),(2175,'201402',2,'2014-02-23 11:34:02','2014-02-22 16:00:00','DDd',2,10010101,11.00,NULL,NULL,0,2,1,0,1,0,0,0),(2184,'201402',3,'2014-02-23 11:40:06','2014-02-22 16:00:00','ss',1,1002,11.00,NULL,0,0,2,1,0,1,0,0,0),(2185,'201402',3,'2014-02-23 11:40:06','2014-02-22 16:00:00','ss',2,10010101,11.00,NULL,NULL,0,2,1,0,1,0,0,0),(2186,'201402',4,'2014-02-23 11:40:33','2014-02-22 16:00:00','ss',1,1002,11.00,NULL,0,0,2,1,0,1,0,0,0),(2187,'201402',4,'2014-02-23 11:40:33','2014-02-22 16:00:00','ss',2,10010101,11.00,NULL,NULL,0,2,1,0,1,0,0,0),(2188,'201402',5,'2014-02-23 11:41:19','2014-02-22 16:00:00','hu',1,10010101,9.00,NULL,NULL,0,2,1,0,1,0,0,0),(2189,'201402',5,'2014-02-23 11:41:19','2014-02-22 16:00:00','hu',2,10010101,9.00,NULL,NULL,0,2,1,0,1,0,0,0),(2190,'201402',6,'2014-02-23 11:41:48','2014-02-22 16:00:00','hu',1,10010101,9.00,NULL,NULL,0,2,1,0,1,0,0,0),(2191,'201402',6,'2014-02-23 11:41:48','2014-02-22 16:00:00','hu',2,10010101,9.00,NULL,NULL,0,2,1,0,1,0,0,0),(2192,'201402',7,'2014-02-23 11:43:18','2014-02-22 16:00:00','uih',1,10010101,9.00,NULL,NULL,0,2,0,0,0,0,0,0),(2193,'201402',7,'2014-02-23 11:43:18','2014-02-22 16:00:00','jk',2,10010101,9.00,NULL,NULL,0,2,0,0,0,0,0,0),(2194,'201402',8,'2014-02-23 11:44:48','2014-02-22 16:00:00','88',1,10010101,88.00,NULL,NULL,0,2,1,0,1,0,0,0),(2195,'201402',8,'2014-02-23 11:44:48','2014-02-22 16:00:00','888',2,10010101,88.00,NULL,NULL,0,2,1,0,1,0,0,0);
/*!40000 ALTER TABLE `transition` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `transitiondate`
--

DROP TABLE IF EXISTS `transitiondate`;
/*!50001 DROP VIEW IF EXISTS `transitiondate`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `transitiondate` (
  `date` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `email` varchar(20) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `sys_role` int(11) DEFAULT NULL,
  `roles` varchar(16) NOT NULL,
  `username` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'short name','admin','fullname','m','admin','t',1,'admin',''),(2,'short name 2','admin','fullname2','m','admin1','t',2,'admin','');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vendor`
--

DROP TABLE IF EXISTS `vendor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vendor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company` varchar(256) NOT NULL,
  `vat` varchar(45) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `add` varchar(100) DEFAULT NULL,
  `memo` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vendor`
--

LOCK TABLES `vendor` WRITE;
/*!40000 ALTER TABLE `vendor` DISABLE KEYS */;
INSERT INTO `vendor` VALUES (1,'company1','vendor','111111','11111','11111'),(2,'company2','vendor2','111111','11111','11111'),(3,'company3','vendor3','111111','11111','11111');
/*!40000 ALTER TABLE `vendor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Final view structure for view `transitiondate`
--

/*!50001 DROP TABLE IF EXISTS `transitiondate`*/;
/*!50001 DROP VIEW IF EXISTS `transitiondate`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `transitiondate` AS select max(`transition`.`entry_num_prefix`) AS `date` from `transition` where ((`transition`.`entry_closing` = 1) or (`transition`.`entry_settlement` = 1)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-04-27 22:21:44