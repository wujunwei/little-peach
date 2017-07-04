<?php
/**
 * Created by PhpStorm.
 * User: wjw33
 * Date: 2017-07-04
 * Time: 21:18
 */
namespace LittlePeach\Base;

use LittlePeach\Utility\Redis;

trait CacheTrait{
    /**
     * @return Redis
     */
    public function loadCache()
    {
        return $this->getContainer()->get('redis');
    }
}