<?php
use Cake\I18n\I18n;
$autoload = require_once(__DIR__."/vendor/autoload.php");

define('FRAME_PATH', dirname(__DIR__));
define('ROOT_PATH', FRAME_PATH.'/..');
define('APP_PATH', ROOT_PATH.'/app');
define('LOG_PATH', FRAME_PATH.'/Log');
define('CONFIG_PATH', ROOT_PATH.'/config');
date_default_timezone_set('Asia/shanghai');

//设置默认语言
I18n::locale('en');

$autoload->addPsr4("App\\", APP_PATH);
