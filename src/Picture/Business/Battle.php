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
    public function getLink($page = 0, $page_size)
    {
        return $this->loadModel('Link')->getList($page, $page_size);
    }

    public function getCount($key_word = '')
    {
        $result =  $this->loadModel('Link')->getKeyWordCount($key_word);
//        var_dump($result);die();
        return $result['count'];
    }
    public function search($key, $page = 0, $page_size = 30)
    {
        return $this->loadModel('Link')->getKeyWordList($key, $page, $page_size);
    }
}