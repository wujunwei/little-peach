<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-07-12
 * Time: 下午 3:33
 */
namespace LittlePeach\Base;

use LittlePeach\Service\Kernel;
use Twig_Environment;

trait ViewTrait{
    /**
     * @var Twig_Environment
     */
    private $component = null;

    /**
     * @return Twig_Environment
     */
    public function getView()
    {
        $this->component = Kernel::getInstance()->getContainer()->get('twig');
        return $this->component;
    }
}