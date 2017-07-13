<?php
use Cake\I18n\I18n;
$autoload = require_once(__DIR__."/vendor/autoload.php");

define('FRAME_PATH', __DIR__);
define('ROOT_PATH', FRAME_PATH.DIRECTORY_SEPARATOR.'..');
define('APP_PATH', ROOT_PATH.DIRECTORY_SEPARATOR.'src');
define('LOG_PATH', ROOT_PATH.DIRECTORY_SEPARATOR.'log');
define('CACHE_PATH', ROOT_PATH.DIRECTORY_SEPARATOR.'cache');
define('TEMPLATE_PATH', ROOT_PATH.DIRECTORY_SEPARATOR.'template');
define('CONFIG_PATH', ROOT_PATH.DIRECTORY_SEPARATOR.'config');
define('APP_ROOT_SPACE', 'App\\');
date_default_timezone_set('Asia/shanghai');
//设置默认语言
I18n::locale('en');

$autoload->addPsr4(APP_ROOT_SPACE, APP_PATH);
