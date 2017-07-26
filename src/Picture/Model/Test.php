<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-07-13
 * Time: 下午 4:19
 */

namespace App\Hello\Model;


use LittlePeach\Base\Model;

class Test extends Model
{
    public function getTitle()
    {
        return $this->loadDB()->selectFrom('*', 'site')->execute()->fetch();
    }
}