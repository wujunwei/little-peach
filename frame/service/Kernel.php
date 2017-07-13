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
use LittlePeach\Service\Middleware\handleRequestMiddleware;
use LittlePeach\Service\Middleware\registerServiceMiddleware;
use LittlePeach\Utility\Common;
use LittlePeach\Utility\Config;
use LittlePeach\Utility\Delegate;
use Restore\Container;
use Symfony\Component\HttpFoundation\Request;

class Kernel
{
    private $debug;
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
    const VIEW_DEBUG = 0b11;
    /**
     * @var Request
     */
    private $request;

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }
    /**
     * @var Kernel
     */
    protected static $kernel;
    /**
     * @var Config
     */
    private $config;

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

    private function createConfig()
    {
        return new Config(Common::getConfigPath());
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
        return Request::createFromGlobals();
    }

    private function init()
    {
        $this->delegate = $this->createDelegate();
        $this->container = $this->createContainer();
        $this->config = $this->createConfig();
        $this->request = $this->initRequest();
        $this->registerErrorHandle();
    }

    public function run()
    {
        $this->dispatch(new errorHandleMiddleware());
        $this->dispatch(new registerServiceMiddleware());
        $this->dispatch(new handleRequestMiddleware());
        $this->delegate->process($this->request)->send();
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

    public static function getInstance()
    {
        return static::$kernel;
    }

    public function getConfig($key = null)
    {
        if (is_null($key)){
            return $this->config;
        }else{
            return $this->config[$key];
        }
    }

    /**
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }
}