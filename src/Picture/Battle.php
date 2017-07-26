<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-07-26
 * Time: 下午 2:23
 */

namespace App\Picture;


use LittlePeach\Base\Controller;

class Battle extends Controller
{
    public function getList()
    {
        $message = $this->getView()->render('index.twig', array('page' => 12,'page_count' => 10, 'current_page' => 3, 'welcome' => '欢迎搜索'));
        return $this->createResponse($message);
    }

    public function detail()
    {
        $message = $this->getView()->render('detail.twig', array('page' => 12, 'welcome' => '欢迎'));
        return $this->createResponse($message);
    }
}