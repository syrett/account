<?php
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require(__DIR__ . '/../../vendor/autoload.php');
require(__DIR__ . '/../../vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/../../common/config/aliases.php');

$domain=str_replace('.'.$_SERVER['SERVER_NAME'],'',$_SERVER['HTTP_HOST']);
if(preg_match('/\..*/',$_SERVER['HTTP_HOST'],$match))
    $domain = $match[0];
$domain = substr($domain,1);
defined('DOMAIN') or define('DOMAIN', $domain);

$config = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../common/config/main.php'),
    require(__DIR__ . '/../../common/config/main-local.php'),
    require(__DIR__ . '/../config/main.php'),
    require(__DIR__ . '/../config/main-local.php')
);


require_once(__DIR__ . '/../../common/function/common.php');
$application = new yii\web\Application($config);
$application->run();
