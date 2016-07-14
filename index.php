<?php
error_reporting(0); 	
// change the following paths if necessary
$yii=dirname(__FILE__).'/../yii-1.1.14/framework/yii.php';
$inx=dirname(__FILE__).'/protected/inx.php';
$config=dirname(__FILE__).'/protected/config/main.php';
// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($inx);
require_once($yii);
require_once(dirname(__FILE__).'/protected/web/JVWebApplication.php');
//Yii::createWebApplication('JVWebApplication',$config)->run();
Yii::createApplication('JVWebApplication',$config)->run();


//Linen
?>