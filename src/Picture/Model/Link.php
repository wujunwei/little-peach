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
    public function getList($page = 0, $size = 30)
    {
        return $this->loadDB()->selectFrom('*', 'link')->setFirstResult($page * $size)->setMaxResults($size)->execute()->fetchAll();
    }

    public function getCount()
    {
        return $this->loadDB()->selectFrom('*', 'link')->select('count(*) as count')->execute()->fetch();
    }
    public function getKeyWordList($key, $page, $size)
    {
        $key = trim($key);
        return $this->loadDB()->selectFrom('*', 'link')
            ->where("name like '%{$key}%'")
            ->setFirstResult($page * $size)
            ->setMaxResults($size)
            ->execute()->fetchAll();
    }

}