<?php

if (false !== strpos('peteraccount.local', $_SERVER['SERVER_NAME'])) {
    defined('YII_DEBUG') or define('YII_DEBUG',true);
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
    $yii=dirname(__FILE__).'/vendor/yii/framework/yii.php';
    $config=dirname(__FILE__).'/protected/config/development.php';
} else {
    $dbprefix='account_';
    $dbname=str_replace('.'.$_SERVER['SERVER_NAME'],'',$_SERVER['HTTP_HOST']);
    define('SYSDB',$dbprefix.$dbname);
    define('YII_DEBUG',false);
    $yii=dirname(__FILE__).'/vendor/yii/framework/yii.php';
    $config=dirname(__FILE__).'/protected/config/production.php';
}

require_once(dirname(__FILE__).'/protected/extensions/utils.php');
require_once($yii);
Yii::createWebApplication($config)->run();
