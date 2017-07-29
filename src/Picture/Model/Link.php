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

    public function getKeyWordCount($key_word)
    {
        $info = $this->loadDB()
            ->selectFrom('count(*) as count', 'link');
        if (empty($key_word)){
            return $info->execute()->fetch();
        }
        return $info->where("name like '%{$key_word}%'")
            ->execute()->fetch();
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