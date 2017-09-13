<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-07-13
 * Time: 上午 9:53
 */

namespace LittlePeach\Service\Middleware;

use LittlePeach\Interfaces\DelegateInterface;
use LittlePeach\Interfaces\MiddlewareInterface;
use LittlePeach\library\Log;
use LittlePeach\Service\Kernel;
use LittlePeach\Utility\Common;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class handleRequestMiddleware implements MiddlewareInterface
{
    const DEFAULT_ACTION = 'Index';
    const DEFAULT_CLASS = 'Index';
    const DEFAULT_MODULE = 'Home';
    /** var_dump($request->getUri());
     *  var_dump($request->getRequestUri());
     *  var_dump($request->getPathInfo());
     * Process an incoming server request and return a response, optionally delegating
     * to the next middleware component to create the response.
     *
     * @param Request $request
     * @param DelegateInterface $delegate
     * @return Response
     */
    public function process(
        Request $request,
        DelegateInterface $delegate
    )
    {
        $pathInfo = explode('/', trim($request->getPathInfo(), '/ '));
        if (count($pathInfo) < 2){
            $pathInfo[] = self::DEFAULT_MODULE;
        }
        $module = $this->dealStr(array_pop($pathInfo)? : self::DEFAULT_MODULE);
        $class = $this->dealStr(array_pop($pathInfo)? : self::DEFAULT_CLASS);
        $action = array_pop($pathInfo)? : self::DEFAULT_ACTION;
        $wholeName = Common::getAppRootNameSpace()."{$module}\\{$class}";
        try{
            $_instance = Kernel::getInstance()->getContainer()->get($wholeName, [$request]);
            if (!method_exists($_instance, $action)){
                throw new \BadMethodCallException('Can not find it anywhere !');
            }
        }catch (\BadMethodCallException $e){
            Log::getInstance()->onException($e);
            return new Response('Can not find it anywhere !', 404);
        }
        return $_instance->$action($request);
    }

    private function dealStr($str)
    {
        return ucfirst(strtolower($str));
    }

}