account
=======
sql file: doc/account.sql

----2 Novemeber 2014----

使用子域名创建多个公司账套

1. Nginx配置文件

server_name参数第一个值对应PHP中的$_SERVER['SERVER_NAME'],后续值为别名alias, 对应PHP中的$_SERVER['HTTP_HOST']

server_name stcsm.org *.stcsm.org

2. 创建MySQL数据库，数据库名称前缀默认为account_

create database account_xh;

use database account_xh;

source account.sql;

grant all on account_qj.* to 'dev'@'%' identified by 'P@ssw0rd';

flush privileges;
