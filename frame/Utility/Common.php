<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-06-30
 * Time: 下午 4:53
 */

namespace LittlePeach\Utility;


use Restore\Container;
use Symfony\Component\HttpFoundation\Request;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

class Common
{
    private function __construct()
    {
    }

    function __clone()
    {
        trigger_error('Common Class can not be cloned !', E_ERROR);
    }

    static function getRootPath()
    {
        return ROOT_PATH;
    }

    static function createContainer()
    {
        return new Container();
    }

    static function createDelegate()
    {
        return new Delegate();
    }

    static function registerErrorHandle()
    {
        $whoops = new Run();
        $whoops->pushHandler(new PrettyPageHandler);
        $whoops->register();
    }

    /**
     * @return Request
     */
    static function initRequest()
    {
        $request = Request::createFromGlobals();
        unset($_REQUEST, $_SERVER, $_GET, $_POST, $_FILES);
        return $request;
    }

}