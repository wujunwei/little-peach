<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-07-03
 * Time: 下午 4:19
 */

namespace LittlePeach\Base;


use LittlePeach\Service\Kernel;
use LittlePeach\Utility\Common;

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

    public function loadBusiness($business)
    {
        $namespace = Common::getModuleNameSpace($this, $business, 'Business');
        return $this->getContainer()->get($namespace);
    }

    public function loadModel($model)
    {
        $namespace = Common::getModuleNameSpace($this, $model, 'Model');
        return $this->getContainer()->get($namespace);
    }
}