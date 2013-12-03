<?php
// change the following paths if necessary
$yii = dirname(__FILE__) . '/yii/framework/yii.php';

if (strripos($_SERVER['SERVER_NAME'], "localhost") == true || strrpos($_SERVER['SERVER_NAME'], ".local") == true) {
    $config = dirname(__FILE__) . '/protected/config/dev.php';
    defined('YII_DEBUG') or define('YII_DEBUG', true);
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
} else {
    defined('YII_DEBUG') or define('YII_DEBUG', false);
    $config = dirname(__FILE__) . '/protected/config/prod.php';
}

defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);

require_once($yii);
Yii::createWebApplication($config)->run();