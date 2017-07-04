<?php
/**
 * Created by PhpStorm.
 * User: wjw33
 * Date: 2017-07-04
 * Time: 20:24
 */

namespace LittlePeach\Service\Middleware;


use LittlePeach\Interfaces\DelegateInterface;
use LittlePeach\Interfaces\MiddlewareInterface;
use LittlePeach\Service\Kernel;
use LittlePeach\Utility\Redis;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class registerServiceMiddleware implements MiddlewareInterface
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
        Kernel::getInstance()->getContainer()->addFactory('redis', function (){
            return new Redis();
        });
        return $delegate->process($request);
    }
}