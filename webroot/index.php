<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-03-13
 * Time: 下午 2:35
 */

use LittlePeach\Service\Kernel;
ini_set('display_errors', true);
require_once("../frame/bootstrap.php");
//putenv('HTTP_LITTLEPEACHDEBUG=7');
$kernel = new Kernel(getenv('HTTP_LITTLEPEACHDEBUG') & 0x0F);
$kernel->run();