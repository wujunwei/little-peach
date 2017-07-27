<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-07-13
 * Time: 下午 2:19
 */
namespace App\Picture\Business;

use LittlePeach\Base\Business;

class Battle extends Business
{
    public function getLink($page = 0)
    {
        return $this->loadModel('Link')->getList($page, 100);
    }

    public function getCount()
    {
        $result =  $this->loadModel('Link')->getCount();
        return $result['count'];
    }
    public function search($key, $page = 0)
    {
        return $this->loadModel('Link')->getKeyWordList($key, $page, 100);
    }
}