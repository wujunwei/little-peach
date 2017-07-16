<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-07-13
 * Time: 上午 9:48
 */

namespace App\Hello;


use LittlePeach\Base\Controller;

class World extends Controller
{
     public function say()
     {
         var_dump( $this->loadBusiness('Test')->getTitle());
         $page = $this->getView()->render('index.html', array('host' => 'hello'));
         return $this->createResponse($page);
     }
}