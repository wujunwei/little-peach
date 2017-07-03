<?php
/**
 * Created by PhpStorm.
 * User: wjw33
 * Date: 2017-03-13
 * Time: 20:16
 */

namespace LittlePeach\Service;

use LittlePeach\Interfaces\MiddlewareInterface;
use LittlePeach\library\Log;
use LittlePeach\Service\Middleware\errorHandleMiddleware;
use LittlePeach\Utility\Delegate;
use Restore\Container;
use Symfony\Component\HttpFoundation\Request;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

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
    /**
     * @var Kernel
     */
    protected static $kernel;
    public function __construct($debug = 0)
    {
        $this->debug = $debug;
        $this->init();
        self::$kernel = $this;
    }
    private function createContainer()
    {
        return new Container();
    }

    private function createDelegate()
    {
        return new Delegate();
    }

    private function registerWhoopsHandle()
    {
        $whoops = new Run();
        $whoops->pushHandler(new PrettyPageHandler);
        $whoops->register();
    }

    private function registerErrorHandle()
    {
        set_error_handler(function ($errno, $errstr, $errfile, $errline = '', $errcontext = '') {
            Log::getInstance()->onError($errno, $errstr, $errfile, $errline, $errcontext);
        });
        register_shutdown_function(function () {
            Log::getInstance()->onShutDown();
        });
    }

    /**
     * @return Request
     */
    private function initRequest()
    {
        $request = Request::createFromGlobals();
        unset($_REQUEST, $_SERVER, $_GET, $_POST, $_FILES);
        return $request;
    }

    private function init()
    {
        $this->delegate = $this->createDelegate();
        $this->container = $this->createContainer();
        $this->request = $this->initRequest();
        $this->registerErrorHandle();
        if ($this->getDebugLevel(self::DISPLAY_ERROR)){
            $this->registerWhoopsHandle();
        }
    }

    public function run()
    {
        $this->dispatch(new errorHandleMiddleware());
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

    public function dispatch(MiddlewareInterface $middleware)
    {
        $this->delegate->enqueue($middleware);
    }

    public function getInstance()
    {
        return static::$kernel;
    }
}