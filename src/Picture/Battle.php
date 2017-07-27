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
        $page = $this->request->query->get('page', 1);
        if ($page <= 1){
            $page = 1;
        }
        $param['current_page'] = $page;
        $param['img_list'] = $this->loadBusiness('Battle')->getLink($page - 1);
        $param['welcome'] = 'haha';
        $param['key_word']='';
        $param['page_count'] = $this->loadBusiness('Battle')->getCount()/100;
        $message = $this->getView()->render('index.twig', $param);
        return $this->createResponse($message);
    }

    public function detail()
    {
        $message = $this->getView()->render('detail.twig', array('page' => 12, 'welcome' => '欢迎'));
        return $this->createResponse($message);
    }

    public function search()
    {
        $page = $this->request->query->get('page', 1);
        $key_word = $this->request->query->get('search', '');
        if ($page <= 1){
            $page = 1;
        }
        $param['current_page'] = $page;
        $param['img_list'] = $this->loadBusiness('Battle')->search($key_word, $page - 1);
        $param['key_word'] = $key_word;
        $param['welcome'] = '搜索';
        $param['key_word'] = $key_word;
        $param['page_count'] = 15;//$this->loadBusiness('Battle')->getCount();
        $message = $this->getView()->render('index.twig', $param);
        return $this->createResponse($message);
    }
}