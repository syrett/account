<?php
date_default_timezone_set('UTC');
if (false !== strpos('www.jason.com', $_SERVER['SERVER_NAME'])) {
    defined('YII_DEBUG') or define('YII_DEBUG',true);
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
    $yii=dirname(__FILE__).'/framework/yii.php';
    $config=dirname(__FILE__).'/protected/config/development.php';
} else {
    $yii=dirname(__FILE__).'/framework/yii.php';
    $config=dirname(__FILE__).'/protected/config/production.php';
}

require_once($yii);
Yii::createWebApplication($config)->run();