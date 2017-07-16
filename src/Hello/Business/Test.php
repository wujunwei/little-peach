<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-07-13
 * Time: 下午 2:19
 */
namespace App\Hello\Business;

use LittlePeach\Base\Business;

class Test extends Business
{
    public function getTitle()
    {
        return $this->loadModel('Test')->getTitle();
    }
}