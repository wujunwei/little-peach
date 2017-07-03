<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-07-03
 * Time: 上午 9:25
 */

namespace LittlePeach\Service\Middleware;


use LittlePeach\Interfaces\DelegateInterface;
use LittlePeach\Interfaces\MiddlewareInterface;
use LittlePeach\library\Log;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class errorHandleMiddleware implements MiddlewareInterface
{


    /**
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
        try {
            return $delegate->process($request);
        }catch (\Throwable $e){
            Log::getInstance()->onException($e);
            return new Response('', 500);
        }

    }
}