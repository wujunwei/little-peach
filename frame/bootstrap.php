<?php
use LittlePeach\Kernel;

define('FRAME_PATH', dirname(__DIR__));
define('APP_PATH', FRAME_PATH.'../app');
$autoload = require_once(__DIR__."/vendor/autoload.php");
$autoload->addPsr4("\\", "src");

$kernel = new Kernel();
$kernel->run();