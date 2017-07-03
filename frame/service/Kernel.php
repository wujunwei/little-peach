<?php
/**
 * Created by PhpStorm.
 * User: wjw33
 * Date: 2017-03-13
 * Time: 20:16
 */

namespace LittlePeach\Service;
use LittlePeach\Service\Middleware\Middleware;
use LittlePeach\Service\Middleware\RequestHandleMiddleware;
use LittlePeach\Utility\Common;
use LittlePeach\Utility\Delegate;
use Restore\Container;
use Symfony\Component\HttpFoundation\Request;

class Kernel
{
    private $debug;//todo LOG Cache Container
    /**
     * @var Delegate
     */
    private $delegate;
    /**
     * @var Container
     */
    private $container;
    const DISPLAY_ERROR = 0b01;
    const DISABLE_CACHE = 0b10;
    const DISPLAY_SQL = 0b11;//todo remove for test
    /**
     * @var Request
     */
    private $request;
    public function __construct($debug = 0)
    {
        $this->debug = $debug;
        $this->delegate = Common::createDelegate();
        $this->container = Common::createContainer();
        $this->request = Common::initRequest();
        if ($this->getDebugLevel(self::DISPLAY_ERROR)){
            Common::registerErrorHandle();
        }
    }
    public function run()
    {
        $this->dispatch(new RequestHandleMiddleware());
        $this->delegate->process($this->request);
    }

    /**
     * @param $type
     * @return Boolean
     */
    public function getDebugLevel($type)
    {
        if ($type & $this->debug){
            return true;
        }else{
            return false;
        }
    }

    public function dispatch(Middleware $middleware)
    {
        $this->delegate->enqueue($middleware);
    }
}