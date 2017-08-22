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
    private $context = array();
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

    public function addToContext($key, $obj)
    {
        $key = strval($key);
        $context[$key] = $obj;
    }

    public function getContent($template = '')
    {
        return $this->component->render($template, $this->context);
    }

    public function display($template = '')
    {
        $this->component->display($template, $this->context);
    }

}