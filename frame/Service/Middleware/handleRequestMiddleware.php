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
        if (count($pathInfo) < 3){
            return new Response('', Response::HTTP_FORBIDDEN);
        }
        $pathInfo = array_map([$this, 'dealStr'], $pathInfo);
        list($module, $class, $action) = $pathInfo;
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