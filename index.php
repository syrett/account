<?php

$domain=str_replace('.'.$_SERVER['SERVER_NAME'],'',$_SERVER['HTTP_HOST']);
if(preg_match('/\..*/',$_SERVER['HTTP_HOST'],$match))
    $domain = $match[0];
$domain = substr($domain,1);
defined('LoginURL') or define('LoginURL','http://manage.'.$domain.'/frontend/web/index.php?r=users/guest/login');
defined('LogoutURL') or define('LogoutURL','http://manage.'.$domain.'/frontend/web/index.php?r=users/user/logout');
defined('UserURL') or define('UserURL','http://manage.'.$domain.'/backend/web/index.php?r=users%2Fdefault%2Findex');
$yii=dirname(__FILE__).'/vendor/yii/framework/yii.php';
if (false !== strpos('abc.com', $domain)) {
    define('SYSDB','account_abc');
    defined('YII_DEBUG') or define('YII_DEBUG',true);
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
    $config=dirname(__FILE__).'/protected/config/development.php';
} else {
    $dbprefix='account_';
    $dbname=str_replace('.'.$_SERVER['SERVER_NAME'],'',$_SERVER['HTTP_HOST']);
    if(preg_match('/[^\.]*/',$_SERVER['HTTP_HOST'],$match))
        $dbname = $match[0];
    define('SYSDB',$dbprefix.$dbname);
    $config=dirname(__FILE__).'/protected/config/production.php';
}
//use yii2 with yii1 http://www.yiiframework.com/doc-2.0/guide-tutorial-yii-integration.html
//$yii2Config = require(__DIR__ . '/backend/config/main.php');
//new yii\web\Application($yii2Config); // Do NOT call run()

//defined('Laofashi') or define('Laofashi', '/backend/web');

require_once(dirname(__FILE__).'/protected/extensions/utils.php');
require_once($yii);
Yii::createWebApplication($config)->run();
