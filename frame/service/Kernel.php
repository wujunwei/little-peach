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
    private $debug;//todo 
    function __construct($debug = 0)
    {

        $this->registerErrorHandle();
    }
    public function run()
    {
        $request = Request::createFromGlobals();
    }

    /**
     *
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