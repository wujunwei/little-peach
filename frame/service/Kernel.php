<?php
/**
 * Created by PhpStorm.
 * User: wjw33
 * Date: 2017-03-13
 * Time: 20:16
 */

namespace LittlePeach\Service;


use Symfony\Component\HttpFoundation\Request;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

class Kernel
{
    private $debug;//todo LOG Cache Container MiddlewareAware (unset request) debug class
    static private $debug_level = [
        'DISPLAY_ERROR' => 0b01,
    ];
    function __construct($debug = 0)
    {
        $this->debug = $debug;
        if ($debug)
        $this->registerErrorHandle();
    }
    public function run()
    {
        $request = Request::createFromGlobals();
    }

    /**
     *register Whoops component
     */
    private function registerErrorHandle()
    {
        $whoops = new Run;
        $whoops->pushHandler(new PrettyPageHandler);
        $whoops->register();
    }

    private function initRequest()
    {

    }

}