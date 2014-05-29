<?php

if (false !== strpos('local', $_SERVER['SERVER_NAME'])) {
    defined('YII_DEBUG') or define('YII_DEBUG',true);
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
    $yii=dirname(__FILE__).'/vendor/yii/framework/yii.php';
    $config=dirname(__FILE__).'/protected/config/development.php';
echo "<p>\$_SERVER['SERVER_NAME']=".$_SERVER['SERVER_NAME']."</p>";
} else {
    $yii=dirname(__FILE__).'/vendor/yii/framework/yii.php';
    $config=dirname(__FILE__).'/protected/config/development.php';
}

?>
