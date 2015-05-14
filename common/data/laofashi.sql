-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2015-04-16 07:11:22
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `laofashi`
--

-- --------------------------------------------------------

--
-- 表的结构 `lfs_bank`
--

CREATE TABLE IF NOT EXISTS `lfs_bank` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `target` varchar(512) DEFAULT NULL COMMENT '交易对象',
  `date` varchar(64) DEFAULT NULL COMMENT '日期',
  `memo` text COMMENT '说明',
  `amount` float NOT NULL COMMENT '金额',
  `parent` int(11) DEFAULT NULL COMMENT '父，相关',
  `order` text COMMENT '订单号',
  `subject` varchar(16) DEFAULT NULL COMMENT '科目',
  `invoice` tinyint(4) DEFAULT '0' COMMENT '有无发票',
  `tax` int(8) DEFAULT NULL COMMENT '税率',
  `status_id` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `status_id` (`status_id`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`),
  KEY `parent` (`parent`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=70 ;

--
-- 转存表中的数据 `lfs_bank`
--

INSERT INTO `lfs_bank` (`id`, `target`, `date`, `memo`, `amount`, `parent`, `order`, `subject`, `invoice`, `tax`, `status_id`, `created_at`, `updated_at`) VALUES
(15, '1', '20150202', '社保', 500, NULL, NULL, '2211', 1, NULL, 0, '2015-04-08 07:10:42', 0),
(16, '2', '20150201', '工资', 4000, NULL, NULL, '660204', 1, NULL, 0, '2015-04-08 07:10:43', 0),
(17, '', '20150202', '社保', 500, NULL, NULL, '2211', 1, 3, 0, '2015-04-08 07:17:42', 0),
(18, '', '20150202', '社保', 500, NULL, NULL, '', 0, NULL, 0, '2015-04-08 07:18:06', 0),
(19, '', '20150202', '社保19', 500, NULL, NULL, '', NULL, NULL, 0, '2015-04-08 07:18:23', 0),
(20, '', '20150202', '社保', 500, NULL, NULL, '2211', 1, NULL, 0, '2015-04-08 07:18:58', 0),
(21, '', '20150202', '社保', 3, 19, NULL, '2211', 0, NULL, 0, '2015-04-08 07:20:32', 0),
(22, '', '20150202', '社保', 2, 19, NULL, '2211', 0, NULL, 0, '2015-04-08 07:21:28', 0),
(23, '', '20150202', '社保', 500, 18, NULL, '', 1, 3, 0, '2015-04-08 07:21:52', 0),
(24, '', '20150201', '工资24', 4, 19, NULL, '2211', 0, NULL, 0, '2015-04-08 07:23:54', 0),
(59, 'testf', '20150302', '社保fff', 954, NULL, NULL, '2241', 0, NULL, 0, '2015-04-15 03:51:22', 0),
(60, '', '20150201', '工资', 30, NULL, NULL, '220201', 1, 3, 0, '2015-04-15 05:20:49', 0),
(61, '', '20150201', '工资', 30, NULL, NULL, '220201', 1, 3, 0, '2015-04-15 05:27:17', 0),
(62, '333', '20150201', '工资', 30, NULL, NULL, '220202', 1, 3, 0, '2015-04-15 05:27:59', 0),
(63, '3', '20150201', '工资', 300, NULL, NULL, '220201', 1, 3, 0, '2015-04-15 05:28:53', 0),
(64, '3', '20150202', '社保', 30, NULL, NULL, '220201', 1, 3, 0, '2015-04-15 05:30:57', 0),
(65, '3', '20150202', '社保', 30, NULL, NULL, '220201', 1, 3, 0, '2015-04-15 06:09:21', 0),
(66, '王', '20150201', '工资', 4000, NULL, NULL, '250101', 1, NULL, 0, '2015-04-15 09:51:05', 0),
(67, '11111', '20150202', '社保', 500, NULL, NULL, '224112', 0, NULL, 0, '2015-04-15 10:46:42', 0),
(68, '', '20150202', '社保社保社保社保社保', 5001, NULL, NULL, '', NULL, NULL, 0, '2015-04-15 10:47:39', 0),
(69, '', '20150201', '工资工资工资工资工资工资', 4001, NULL, NULL, '', NULL, NULL, 0, '2015-04-15 10:47:39', 0);

-- --------------------------------------------------------

--
-- 表的结构 `lfs_blogs`
--

CREATE TABLE IF NOT EXISTS `lfs_blogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `alias` varchar(100) NOT NULL,
  `snippet` text NOT NULL,
  `content` longtext NOT NULL,
  `image_url` varchar(64) NOT NULL,
  `preview_url` varchar(64) NOT NULL,
  `views` int(11) NOT NULL DEFAULT '0',
  `status_id` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `status_id` (`status_id`),
  KEY `views` (`views`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `lfs_blogs`
--

INSERT INTO `lfs_blogs` (`id`, `title`, `alias`, `snippet`, `content`, `image_url`, `preview_url`, `views`, `status_id`, `created_at`, `updated_at`) VALUES
(1, 'php_openssl_support', 'phpopensslsupport', '<h3>OpenSSL support =&gt; disabled (install ext/openssl) </h3>', '<p>#下面是php的安装目录</p><p>/usr/local/php5/bin/ </p><p>#切换到php安装目录的 etx/openssl目录 </p><p>cd /php-5.3.8p/ext/openssl </p><p>#查看openssl目录下有个config0.m4，把config0.m4改名为config.m4。 </p><p>cp config0.m4 config.m4 </p><p>#依次执行: </p><p>/usr/local/php5/bin/phpize </p><p>./configure –with-openssl –with-php-config=/usr/local/php5/bin/php-config </p><p>make &amp;&amp; make install </p><p>#然后找到php.ini所在位置 打开 extension_dir(如果没有则自行添加), 同时添加 extension = "openssl.so" </p><p>#重启服务器 即可 </p><p>#openssl 查看方法: </p><p>/usr/local/php5/bin/php -i |grep openssl </p>', '', '', 4, 1, 1416441600, 1416873600),
(2, 'ubuntu command', 'ubuntu-command', '<p>ubuntu command</p>', '<p>vim /etc/resolv.conf</p><p>nameserver 8.8.8.8</p><p>nameserver 192.168.100.11</p><p>apt-get install openssh-server</p><p>useradd webmaster</p><p>passwd webmaster</p><p>usermod -g adminis webmaster</p><p>vim /etc/passwd</p><p>apt-get install apache2</p><p>apt-get install php5</p><p>sudo apt-get install mysql-server</p><p>sudo apt-get install libapache2-mod-auth-mysql</p><p>sudo apt-get install php5-mysql</p><p>sudo /etc/init.d/apache2 restart</p><p>apt-get install phpmyadmin</p><p>sudo apt-get install vsftpd</p><p>sudo chmod 777 -R /var/www</p><p>sudo vim /etc/vsftp.conf</p><p>/*</p><p>local_enable=YES</p><p>local_root=/var/www</p><p>max_clients=5un</p><p>#</p><p># Uncomment this to enable any form of FTP write command.</p><p>write_enable=YES</p><p>*/</p><p>useradd -d /var/www/ ubuntuftp</p><p>passwd ubuntuftp</p><p>useradd -d /home/ubuntugit/ ubuntugit</p><p>passwd ubuntugit</p><p>apt-get install git-core</p><p>git init</p><p>/* if need sass install ruby first don''t use the 163''s source list */</p><p>sudo apt-get install ruby</p><p>apt-get install rubygems</p><p>/* it seems it does not work fine */</p><p>gem install sass</p><p>sudo apt-get -uVf install libfssm-ruby</p><p>sudo sass --watch /var/www/100/wp-content/themes/100/css/sass:/var/www/100/wp-content/themes/100/css/stylesheets -C -t compressed</p><p>/* if it didn''t overwrite any *.css. Because the server time is not same as upload client.*/</p><p>sudo ntpdate time.stdtime.gov.tw</p><p>sudo hwclock -w</p><p>刷新dns</p><p>/etc/init.d/dns-clean restart</p>', '', '', 4, 1, 1416441600, 1416441600),
(3, 'titlettt', 'titlettt', '<p>密云路1018号乙asdfvvv怎么回事，什么情况啊，这是很长的</p>', '<p>备注不能为空，也可以是很长的东西</p>', '', '', 0, 0, 1420070400, 1421625600),
(4, 'apache vhosts', 'apache-vhosts', '<p>virtual hosts</p>', '<p>首先确定你的apache配置文件已经开启了虚拟站点。</p><p>/etc/apache2/文件夹下有两个文件夹：/etc/apache2/sites-enabled/和/etc/apache2/sites-available/</p><p>其中/etc/apache2/sites-enabled/是生效的配置，当然你也可以修改apache2.conf文件来指定另外的文件夹。</p><p>新建一个虚拟站点我分为以下两个步骤：</p><p>第一步：在/etc/apache2/sites-available/新建一个blogguy_cn文件</p><p>vi blogguy.cn</p><p>输入以下配置内容</p><p>&lt;VirtualHost *:80&gt;<br> ServerAdmin <a href="mailto:wayswang@gmail.com">wayswang@gmail.com</a></p><p> DocumentRoot /var/www/blogguy_cn<br> <br> ServerName blogguy.cn<br> ServerAlias <a href="http://www.blogguy.cn/">www.blogguy.cn</a> wayswang.blogguy.cn <br> <br> &lt;Directory /&gt;<br> Options FollowSymLinks<br> AllowOverride None<br> &lt;/Directory&gt;<br> &lt;Directory /var/www/&gt;<br> Options Indexes FollowSymLinks MultiViews<br> AllowOverride None<br> Order allow,deny<br> allow from all<br> &lt;/Directory&gt;</p><p> ErrorLog /var/log/apache2/blogguy_cn_error.log</p><p> # Possible values include: debug, info, notice, warn, error, crit,<br> # alert, emerg.<br> LogLevel warn</p><p> CustomLog /var/log/apache2/blogguy_cn_access.log combined</p><p><br>&lt;/VirtualHost&gt;</p><p>保存退出！这个只是一个最简单的实例，你可能要根据你的情况修改。</p><p>第二步：链接到/etc/apache2/sites-enabled/目录使之生效</p><p>ln -s /etc/apache2/sites-available/blogguy_cn /etc/apache2/sites-enabled/blogguy_cn</p><p>重启apache即可～～</p><p>/etc/init.d/apache restart</p>', '', '', 1, 1, 1423445072, 1423445072);

-- --------------------------------------------------------

--
-- 表的结构 `lfs_comments`
--

CREATE TABLE IF NOT EXISTS `lfs_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `model_class` int(11) unsigned NOT NULL,
  `model_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `status_id` tinyint(2) NOT NULL DEFAULT '0',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `status_id` (`status_id`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`),
  KEY `FK_comment_parent` (`parent_id`),
  KEY `FK_comment_author` (`author_id`),
  KEY `FK_comment_model_class` (`model_class`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `lfs_comments_models`
--

CREATE TABLE IF NOT EXISTS `lfs_comments_models` (
  `id` int(11) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `status_id` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `status_id` (`status_id`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `lfs_comments_models`
--

INSERT INTO `lfs_comments_models` (`id`, `name`, `status_id`, `created_at`, `updated_at`) VALUES
(4232574542, 'vova07\\blogs\\models\\frontend\\Blog', 1, 1416446327, 1416446327);

-- --------------------------------------------------------

--
-- 表的结构 `lfs_migration`
--

CREATE TABLE IF NOT EXISTS `lfs_migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `lfs_migration`
--

INSERT INTO `lfs_migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1416444515),
('m140418_204054_create_module_tbl', 1416444519),
('m140526_193056_create_module_tbl', 1416444528),
('m140911_074715_create_module_tbl', 1416444536);

-- --------------------------------------------------------

--
-- 表的结构 `lfs_profiles`
--

CREATE TABLE IF NOT EXISTS `lfs_profiles` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `avatar_url` varchar(64) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `lfs_profiles`
--

INSERT INTO `lfs_profiles` (`user_id`, `name`, `surname`, `avatar_url`) VALUES
(1, 'pdwjun', 'Site', '54f3c7ab5320b.png');

-- --------------------------------------------------------

--
-- 表的结构 `lfs_subj`
--

CREATE TABLE IF NOT EXISTS `lfs_subj` (
  `sub` int(11) NOT NULL,
  `sub_sub` int(11) NOT NULL,
  UNIQUE KEY `sub` (`sub`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `lfs_subj`
--

INSERT INTO `lfs_subj` (`sub`, `sub_sub`) VALUES
(1001, 0),
(1002, 0),
(1003, 0),
(1021, 0),
(1031, 0),
(1101, 0),
(1102, 0),
(1111, 0),
(1121, 0),
(1122, 0),
(1123, 0),
(1131, 0),
(1132, 0),
(1201, 0),
(1211, 0),
(1212, 0),
(1221, 0),
(1231, 0),
(1301, 0),
(1302, 0),
(1303, 0),
(1304, 0),
(1311, 0),
(1321, 0),
(1401, 0),
(1402, 0),
(1403, 0),
(1404, 0),
(1405, 0),
(1406, 0),
(1407, 0),
(1408, 0),
(1411, 0),
(1412, 0),
(1421, 0),
(1431, 0),
(1441, 0),
(1451, 0),
(1461, 0),
(1471, 0),
(1501, 0),
(1502, 0),
(1503, 0),
(1511, 0),
(1512, 0),
(1521, 0),
(1531, 0),
(1532, 0),
(1541, 0),
(1601, 0),
(1602, 0),
(1603, 0),
(1604, 0),
(1605, 0),
(1606, 0),
(1611, 0),
(1621, 0),
(1622, 0),
(1623, 0),
(1631, 0),
(1632, 0),
(1701, 0),
(1702, 0),
(1703, 0),
(1711, 0),
(1801, 0),
(1811, 0),
(1821, 0),
(1901, 0),
(2001, 0),
(2002, 0),
(2003, 0),
(2004, 0),
(2011, 0),
(2012, 0),
(2021, 0),
(2101, 0),
(2111, 0),
(2201, 0),
(2202, 0),
(2203, 0),
(2211, 2221),
(2221, 0),
(2231, 0),
(2232, 0),
(2241, 0),
(2251, 0),
(2261, 0),
(2311, 0),
(2312, 0),
(2313, 0),
(2314, 0),
(2401, 0),
(2501, 0),
(2502, 0),
(2601, 0),
(2602, 0),
(2611, 0),
(2621, 0),
(2701, 0),
(2702, 0),
(2711, 0),
(2801, 0),
(2901, 0),
(4001, 0),
(4002, 0),
(4101, 0),
(4102, 0),
(4103, 0),
(4104, 0),
(4201, 0),
(6001, 0),
(6011, 0),
(6021, 0),
(6031, 0),
(6041, 0),
(6051, 0),
(6061, 0),
(6101, 0),
(6111, 0),
(6201, 0),
(6202, 0),
(6203, 0),
(6301, 0),
(6401, 0),
(6402, 0),
(6403, 0),
(6411, 0),
(6421, 0),
(6501, 0),
(6502, 0),
(6511, 0),
(6521, 0),
(6531, 0),
(6541, 0),
(6542, 0),
(6601, 0),
(6602, 0),
(6603, 0),
(6604, 0),
(6701, 0),
(6711, 0),
(6801, 0),
(6901, 0);

-- --------------------------------------------------------

--
-- 表的结构 `lfs_users`
--

CREATE TABLE IF NOT EXISTS `lfs_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `token` varchar(53) NOT NULL,
  `role` varchar(64) NOT NULL DEFAULT 'user',
  `status_id` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `role` (`role`),
  KEY `status_id` (`status_id`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `lfs_users`
--

INSERT INTO `lfs_users` (`id`, `username`, `email`, `password_hash`, `auth_key`, `token`, `role`, `status_id`, `created_at`, `updated_at`) VALUES
(1, 'pdwjun', 'pdwjun@126.com', '$2y$13$agiSIOfVDugWc.0WairoMeFOvOGoFgshVs4kq0.KnfYlgUqGBDkNG', 'pqxK3qo99Sg0gftxE6h64v17eO0kzAUN', '4YlnE5BL3N74SMTbEHlmbDcHNtg4sTro_1416968915', 'superadmin', 1, 1416444518, 1422347700);

-- --------------------------------------------------------

--
-- 表的结构 `lfs_user_email`
--

CREATE TABLE IF NOT EXISTS `lfs_user_email` (
  `user_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `token` varchar(53) NOT NULL,
  PRIMARY KEY (`user_id`,`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 限制导出的表
--

--
-- 限制表 `lfs_bank`
--
ALTER TABLE `lfs_bank`
  ADD CONSTRAINT `lfs_bank_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `lfs_bank` (`id`);

--
-- 限制表 `lfs_comments`
--
ALTER TABLE `lfs_comments`
  ADD CONSTRAINT `FK_comment_author` FOREIGN KEY (`author_id`) REFERENCES `lfs_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_comment_model_class` FOREIGN KEY (`model_class`) REFERENCES `lfs_comments_models` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_comment_parent` FOREIGN KEY (`parent_id`) REFERENCES `lfs_comments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `lfs_profiles`
--
ALTER TABLE `lfs_profiles`
  ADD CONSTRAINT `FK_profile_user` FOREIGN KEY (`user_id`) REFERENCES `lfs_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `lfs_user_email`
--
ALTER TABLE `lfs_user_email`
  ADD CONSTRAINT `FK_user_email_user` FOREIGN KEY (`user_id`) REFERENCES `lfs_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
