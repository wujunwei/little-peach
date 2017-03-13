<?php
use Cake\I18n\I18n;

define('FRAME_PATH', dirname(__DIR__));
define('APP_PATH', FRAME_PATH.'../app');

date_default_timezone_set('Asia/shanghai');

//设置默认语言
I18n::locale('en');
$autoload = require_once(__DIR__."/vendor/autoload.php");
$autoload->addPsr4("App\\", "src");
