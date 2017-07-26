<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-07-13
 * Time: 下午 4:19
 */

namespace App\Picture\Model;


use LittlePeach\Base\Model;

class Link extends Model
{
    public function getList($page = 0)
    {
        return $this->loadDB()->selectFrom('*', 'link')->setFirstResult($page * 30)->setMaxResults(30)->execute()->fetchAll();
    }

    public function getCount()
    {
        return $this->loadDB()->selectFrom('*', 'link')->select('count(*) as count')->execute()->fetch();
    }
}