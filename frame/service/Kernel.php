<?php
/**
 * Created by PhpStorm.
 * User: wjw33
 * Date: 2017-03-13
 * Time: 20:16
 */

namespace LittlePeach\Service;

use LittlePeach\Base\Business;
use LittlePeach\Interfaces\MiddlewareInterface;
use LittlePeach\library\Log;
use LittlePeach\Service\Middleware\errorHandleMiddleware;
use LittlePeach\Service\Middleware\registerServiceMiddleware;
use LittlePeach\Utility\Common;
use LittlePeach\Utility\Config;
use LittlePeach\Utility\Delegate;
use Restore\Container;
use Symfony\Component\HttpFoundation\Request;

class Kernel
{
    private $debug;//todo db controller  business model
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
        $request = Request::createFromGlobals();
        return $request;
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
        $this->delegate->process($this->request);
//        echo (new Business())->loadCache()->get('test');
        echo (new Business())->loadCache()->get('test');
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