<?php


$domain=str_replace('.'.$_SERVER['SERVER_NAME'],'',$_SERVER['HTTP_HOST']);
if(preg_match('/\..*/',$_SERVER['HTTP_HOST'],$match))
    $domain = $match[0];
$domain = substr($domain,1);
defined('LoginURL') or define('LoginURL','http://manage.'.$domain.'/frontend/web/index.php?r=users/guest/login');
defined('LogoutURL') or define('LogoutURL','http://manage.'.$domain.'/frontend/web/index.php?r=users/user/logout');
defined('UserURL') or define('UserURL','http://manage.'.$domain.'/backend/web/index.php?r=users%2Fdefault%2Findex');
if (false !== strpos('abc.com', $domain)) {
    defined('YII_DEBUG') or define('YII_DEBUG',true);
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
    $yii=dirname(__FILE__).'/vendor/yii/framework/yii.php';
    $config=dirname(__FILE__).'/protected/config/development.php';
} else {
    $dbprefix='account_';
    $dbname=str_replace('.'.$_SERVER['SERVER_NAME'],'',$_SERVER['HTTP_HOST']);
    if(preg_match('/[^\.]*/',$_SERVER['HTTP_HOST'],$match))
        $dbname = $match[0];
    define('SYSDB',$dbprefix.$dbname);
    $yii=dirname(__FILE__).'/vendor/yii/framework/yii.php';
    $config=dirname(__FILE__).'/protected/config/production.php';
}

require_once(dirname(__FILE__).'/protected/extensions/utils.php');
require_once($yii);
Yii::createWebApplication($config)->run();
