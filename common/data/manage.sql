-- phpMyAdmin SQL Dump
-- version 4.2.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2015-05-03 14:24:03
-- 服务器版本： 5.5.40-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `manage`
--

-- --------------------------------------------------------

--
-- 表的结构 `yii2_start_access`
--

CREATE TABLE IF NOT EXISTS `yii2_start_access` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `condom_id` int(11) NOT NULL,
  `role_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `yii2_start_access`
--

INSERT INTO `yii2_start_access` (`id`, `user_id`, `condom_id`, `role_id`) VALUES
(47, 1, 2, 2),
(48, 1, 4, 2),
(49, 1, 21, 2),
(50, 1, 5, 2),
(51, 1, 20, 2),
(52, 1, 7, 2),
(53, 42, 1, 2),
(54, 1, 6, 2),
(55, 1, 22, 2),
(58, 48, 2, 2),
(59, 48, 4, 2),
(60, 48, 21, 2),
(61, 48, 5, 2),
(62, 48, 20, 2),
(63, 48, 7, 2),
(64, 48, 6, 2),
(65, 48, 22, 2);

-- --------------------------------------------------------

--
-- 表的结构 `yii2_start_blogs`
--

CREATE TABLE IF NOT EXISTS `yii2_start_blogs` (
`id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `alias` varchar(100) NOT NULL,
  `snippet` text NOT NULL,
  `content` longtext NOT NULL,
  `image_url` varchar(64) NOT NULL,
  `preview_url` varchar(64) NOT NULL,
  `views` int(11) NOT NULL DEFAULT '0',
  `status_id` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `yii2_start_blogs`
--

INSERT INTO `yii2_start_blogs` (`id`, `title`, `alias`, `snippet`, `content`, `image_url`, `preview_url`, `views`, `status_id`, `created_at`, `updated_at`) VALUES
(1, 'php_openssl_support', 'phpopensslsupport', '<h3>OpenSSL support =&gt; disabled (install ext/openssl) </h3>', '<p>#下面是php的安装目录</p><p>/usr/local/php5/bin/ </p><p>#切换到php安装目录的 etx/openssl目录 </p><p>cd /php-5.3.8p/ext/openssl </p><p>#查看openssl目录下有个config0.m4，把config0.m4改名为config.m4。 </p><p>cp config0.m4 config.m4 </p><p>#依次执行: </p><p>/usr/local/php5/bin/phpize </p><p>./configure –with-openssl –with-php-config=/usr/local/php5/bin/php-config </p><p>make &amp;&amp; make install </p><p>#然后找到php.ini所在位置 打开 extension_dir(如果没有则自行添加), 同时添加 extension = "openssl.so" </p><p>#重启服务器 即可 </p><p>#openssl 查看方法: </p><p>/usr/local/php5/bin/php -i |grep openssl </p>', '', '', 3, 1, 1416441600, 1416441600),
(2, 'ubuntu command', 'ubuntu-command', '<p>ubuntu command</p>', '<p>vim /etc/resolv.conf</p><p>nameserver 8.8.8.8</p><p>nameserver 192.168.100.11</p><p>apt-get install openssh-server</p><p>useradd webmaster</p><p>passwd webmaster</p><p>usermod -g adminis webmaster</p><p>vim /etc/passwd</p><p>apt-get install apache2</p><p>apt-get install php5</p><p>sudo apt-get install mysql-server</p><p>sudo apt-get install libapache2-mod-auth-mysql</p><p>sudo apt-get install php5-mysql</p><p>sudo /etc/init.d/apache2 restart</p><p>apt-get install phpmyadmin</p><p>sudo apt-get install vsftpd</p><p>sudo chmod 777 -R /var/www</p><p>sudo vim /etc/vsftp.conf</p><p>/*</p><p>local_enable=YES</p><p>local_root=/var/www</p><p>max_clients=5un</p><p>#</p><p># Uncomment this to enable any form of FTP write command.</p><p>write_enable=YES</p><p>*/</p><p>useradd -d /var/www/ ubuntuftp</p><p>passwd ubuntuftp</p><p>useradd -d /home/ubuntugit/ ubuntugit</p><p>passwd ubuntugit</p><p>apt-get install git-core</p><p>git init</p><p>/* if need sass install ruby first don''t use the 163''s source list */</p><p>sudo apt-get install ruby</p><p>apt-get install rubygems</p><p>/* it seems it does not work fine */</p><p>gem install sass</p><p>sudo apt-get -uVf install libfssm-ruby</p><p>sudo sass --watch /var/www/100/wp-content/themes/100/css/sass:/var/www/100/wp-content/themes/100/css/stylesheets -C -t compressed</p><p>/* if it didn''t overwrite any *.css. Because the server time is not same as upload client.*/</p><p>sudo ntpdate time.stdtime.gov.tw</p><p>sudo hwclock -w</p><p>刷新dns</p><p>/etc/init.d/dns-clean restart</p>', '', '', 2, 1, 1416441600, 1416441600);

-- --------------------------------------------------------

--
-- 表的结构 `yii2_start_comments`
--

CREATE TABLE IF NOT EXISTS `yii2_start_comments` (
`id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `model_class` int(11) unsigned NOT NULL,
  `model_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `status_id` tinyint(2) NOT NULL DEFAULT '0',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `yii2_start_comments_models`
--

CREATE TABLE IF NOT EXISTS `yii2_start_comments_models` (
  `id` int(11) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `status_id` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `yii2_start_comments_models`
--

INSERT INTO `yii2_start_comments_models` (`id`, `name`, `status_id`, `created_at`, `updated_at`) VALUES
(4232574542, 'vova07\\blogs\\models\\frontend\\Blog', 1, 1416446327, 1416446327);

-- --------------------------------------------------------

--
-- 表的结构 `yii2_start_condom`
--

CREATE TABLE IF NOT EXISTS `yii2_start_condom` (
`id` int(11) NOT NULL,
  `dbname` varchar(32) NOT NULL,
  `company` varchar(256) NOT NULL,
  `starttime` int(11) NOT NULL,
  `address` text NOT NULL,
  `cuser` varchar(256) NOT NULL COMMENT '联系人姓名',
  `cphone` varchar(16) NOT NULL COMMENT '联系人电话',
  `note` longtext NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `yii2_start_condom`
--

INSERT INTO `yii2_start_condom` (`id`, `dbname`, `company`, `starttime`, `address`, `cuser`, `cphone`, `note`, `created_at`, `updated_at`, `status`) VALUES
(1, 'account', '测试账套', 0, '', '', '', '', 1416441600, 1423558080, 1),
(2, 'ah', '艾鸿', 0, '', '', '', '', 1416441600, 1423557860, 1),
(4, 'gbl', '哥布林', 0, '', '', '', '', 1422230400, 1422257210, 1),
(5, 'gp', '光朴', 0, '', '', '', '', 1422230400, 1423557057, 0),
(6, 'jn', '极鸟', 0, '', '', '', '', 1422263479, 1422263479, 0),
(7, 'pz', '平章', 0, '', '', '', '', 1422263495, 1422263495, 0),
(20, 'qj', '锲坚', 0, '', '', '', '', 1423008000, 1422263495, 0),
(21, 'sxg', '三仙馆', 0, '', '', '', '', 1423008000, 1423558860, 0),
(22, 'xh', '享合', 1356998400, '', '', '', '', 1423008000, 1423020904, 0),
(32, 'yhm', 'yhm', 0, '', '', '', '', 1423712821, 1423712821, 0);

-- --------------------------------------------------------

--
-- 表的结构 `yii2_start_migration`
--

CREATE TABLE IF NOT EXISTS `yii2_start_migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `yii2_start_migration`
--

INSERT INTO `yii2_start_migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1416444515),
('m140418_204054_create_module_tbl', 1416444519),
('m140526_193056_create_module_tbl', 1416444528),
('m140911_074715_create_module_tbl', 1416444536);

-- --------------------------------------------------------

--
-- 表的结构 `yii2_start_profiles`
--

CREATE TABLE IF NOT EXISTS `yii2_start_profiles` (
`user_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `phone` varchar(16) NOT NULL,
  `condom_id` int(11) DEFAULT NULL,
  `avatar_url` varchar(64) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `yii2_start_profiles`
--

INSERT INTO `yii2_start_profiles` (`user_id`, `name`, `surname`, `phone`, `condom_id`, `avatar_url`) VALUES
(1, '超级管理员', 'Site', '0', NULL, '54d87ce0aa03b.png'),
(42, '超级管理员', 'Site', '0', NULL, '54d87ce0aa03b.png'),
(48, '', '', '', NULL, ''),
(51, '吴嘉韵', '', '13166278586', NULL, '');

-- --------------------------------------------------------

--
-- 表的结构 `yii2_start_roles`
--

CREATE TABLE IF NOT EXISTS `yii2_start_roles` (
`id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `access` varchar(1024) NOT NULL,
  `description` varchar(1024) DEFAULT NULL COMMENT '角色描述',
  `condom_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `yii2_start_roles`
--

INSERT INTO `yii2_start_roles` (`id`, `name`, `access`, `description`, `condom_id`) VALUES
(1, 'admin', '/admin', NULL, 1),
(2, 'normal', '/edit', NULL, 1);

-- --------------------------------------------------------

--
-- 表的结构 `yii2_start_users`
--

CREATE TABLE IF NOT EXISTS `yii2_start_users` (
`id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `token` varchar(53) NOT NULL,
  `role` varchar(64) NOT NULL DEFAULT 'user',
  `group` int(11) NOT NULL,
  `vip` tinyint(4) DEFAULT '0',
  `status_id` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `yii2_start_users`
--

INSERT INTO `yii2_start_users` (`id`, `username`, `email`, `password_hash`, `auth_key`, `token`, `role`, `group`, `vip`, `status_id`, `created_at`, `updated_at`) VALUES
(1, 'supersu', 'pdwjun1@126.com', '$2y$13$9zfKNlpPXnSCTCg8uY2mHOJIueDMwVLmmhWA5ZHqYhrlkkCl4o2Ee', 'oI6nn5C3Uux3vtLfS7ijEk_pA7wfIrS_', 'DyvjebVHiArRL3jUBB0rRpZIjMfUypU2_1423557897', 'superadmin', 1, 1, 1, 1416444518, 1423557896),
(42, 'demo', 'pdwjun@126.com', '$2y$13$9zfKNlpPXnSCTCg8uY2mHOJIueDMwVLmmhWA5ZHqYhrlkkCl4o2Ee', 'oI6nn5C3Uux3vtLfS7ijEk_pA7wfIrS_', 'DyvjebVHiArRL3jUBB0rRpZIjMfUypU2_1423557897', 'superadmin', 42, 0, 1, 1416444518, 1423557896),
(48, 'admin', '2503143934@qq.com', '$2y$13$HLSQciq.sxtpa8xgPP5Ivui1oP6nCiUsVIS1iS5G/YoN7PGF2Vfv2', 't9NSdxFb8O2VgIt4SIIip8yO0roTQqBk', 'SQ-dRj5pZUMyFd3i2UwCY7qcGPDIPrIf_1423722844', 'superadmin', 1, 0, 1, 1423722843, 1423724630),
(51, 'wujy', '741916063@qq.com', '$2y$13$tlNvne988vIgQR5yykPweuGWAG3lNcC2TZd8yPf5oDyjNtyRhUAuq', 'OYlLcpwtJA10rQdF1eUpBW5_MvRJCg8o', 'tSjmDj2ME6zqlNbbCgQjBtR16BlT8v4L_1427362188', 'superadmin', 51, 0, 1, 1427362188, 1427362189);

-- --------------------------------------------------------

--
-- 表的结构 `yii2_start_user_email`
--

CREATE TABLE IF NOT EXISTS `yii2_start_user_email` (
  `user_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `token` varchar(53) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `yii2_start_access`
--
ALTER TABLE `yii2_start_access`
 ADD PRIMARY KEY (`id`), ADD KEY `user_id` (`user_id`), ADD KEY `condom_id` (`condom_id`), ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `yii2_start_blogs`
--
ALTER TABLE `yii2_start_blogs`
 ADD PRIMARY KEY (`id`), ADD KEY `status_id` (`status_id`), ADD KEY `views` (`views`), ADD KEY `created_at` (`created_at`), ADD KEY `updated_at` (`updated_at`);

--
-- Indexes for table `yii2_start_comments`
--
ALTER TABLE `yii2_start_comments`
 ADD PRIMARY KEY (`id`), ADD KEY `status_id` (`status_id`), ADD KEY `created_at` (`created_at`), ADD KEY `updated_at` (`updated_at`), ADD KEY `FK_comment_parent` (`parent_id`), ADD KEY `FK_comment_author` (`author_id`), ADD KEY `FK_comment_model_class` (`model_class`);

--
-- Indexes for table `yii2_start_comments_models`
--
ALTER TABLE `yii2_start_comments_models`
 ADD PRIMARY KEY (`id`), ADD KEY `name` (`name`), ADD KEY `status_id` (`status_id`), ADD KEY `created_at` (`created_at`), ADD KEY `updated_at` (`updated_at`);

--
-- Indexes for table `yii2_start_condom`
--
ALTER TABLE `yii2_start_condom`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `dbname` (`dbname`);

--
-- Indexes for table `yii2_start_migration`
--
ALTER TABLE `yii2_start_migration`
 ADD PRIMARY KEY (`version`);

--
-- Indexes for table `yii2_start_profiles`
--
ALTER TABLE `yii2_start_profiles`
 ADD PRIMARY KEY (`user_id`), ADD KEY `condom` (`condom_id`);

--
-- Indexes for table `yii2_start_roles`
--
ALTER TABLE `yii2_start_roles`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `name` (`name`), ADD KEY `condom_id` (`condom_id`);

--
-- Indexes for table `yii2_start_users`
--
ALTER TABLE `yii2_start_users`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username` (`username`), ADD UNIQUE KEY `email` (`email`), ADD KEY `role` (`role`), ADD KEY `status_id` (`status_id`), ADD KEY `created_at` (`created_at`);

--
-- Indexes for table `yii2_start_user_email`
--
ALTER TABLE `yii2_start_user_email`
 ADD PRIMARY KEY (`user_id`,`token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `yii2_start_access`
--
ALTER TABLE `yii2_start_access`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=68;
--
-- AUTO_INCREMENT for table `yii2_start_blogs`
--
ALTER TABLE `yii2_start_blogs`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `yii2_start_comments`
--
ALTER TABLE `yii2_start_comments`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `yii2_start_condom`
--
ALTER TABLE `yii2_start_condom`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `yii2_start_profiles`
--
ALTER TABLE `yii2_start_profiles`
MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=52;
--
-- AUTO_INCREMENT for table `yii2_start_roles`
--
ALTER TABLE `yii2_start_roles`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `yii2_start_users`
--
ALTER TABLE `yii2_start_users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=52;
--
-- 限制导出的表
--

--
-- 限制表 `yii2_start_access`
--
ALTER TABLE `yii2_start_access`
ADD CONSTRAINT `yii2_start_access_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `yii2_start_profiles` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `yii2_start_access_ibfk_2` FOREIGN KEY (`condom_id`) REFERENCES `yii2_start_condom` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `yii2_start_access_ibfk_3` FOREIGN KEY (`role_id`) REFERENCES `yii2_start_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `yii2_start_comments`
--
ALTER TABLE `yii2_start_comments`
ADD CONSTRAINT `FK_comment_author` FOREIGN KEY (`author_id`) REFERENCES `yii2_start_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `FK_comment_model_class` FOREIGN KEY (`model_class`) REFERENCES `yii2_start_comments_models` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `FK_comment_parent` FOREIGN KEY (`parent_id`) REFERENCES `yii2_start_comments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `yii2_start_profiles`
--
ALTER TABLE `yii2_start_profiles`
ADD CONSTRAINT `FK_profile_user` FOREIGN KEY (`user_id`) REFERENCES `yii2_start_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `yii2_start_profiles_ibfk_1` FOREIGN KEY (`condom_id`) REFERENCES `yii2_start_condom` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `yii2_start_roles`
--
ALTER TABLE `yii2_start_roles`
ADD CONSTRAINT `yii2_start_roles_ibfk_1` FOREIGN KEY (`condom_id`) REFERENCES `yii2_start_condom` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `yii2_start_user_email`
--
ALTER TABLE `yii2_start_user_email`
ADD CONSTRAINT `FK_user_email_user` FOREIGN KEY (`user_id`) REFERENCES `yii2_start_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
