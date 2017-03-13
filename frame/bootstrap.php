<?php
use LittlePeach\Kernel;

$autoload = require_once(__DIR__."/vendor/autoload.php");
$autoload->addPsr4("", "");

$kernel = new Kernel();
$kernel->run();