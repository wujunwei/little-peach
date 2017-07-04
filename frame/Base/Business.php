<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-07-03
 * Time: 下午 4:19
 */

namespace LittlePeach\Base;


use LittlePeach\Service\Kernel;

class Business
{
    use CacheTrait;

    /**
     * @return \Restore\Container
     */
    public function getContainer()
    {
        return Kernel::getInstance()->getContainer();
    }

    public function getConfig($key = null)
    {
        return Kernel::getInstance()->getConfig($key);
    }
}