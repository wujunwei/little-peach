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
use LittlePeach\Service\Kernel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

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

        if (Kernel::getInstance()->getDebugLevel(Kernel::DISPLAY_ERROR)){
            $this->registerWhoopsHandle();
        }
        return $delegate->process($request);
    }

    private function registerWhoopsHandle()
    {
        $whoops = new Run();
        $whoops->pushHandler(new PrettyPageHandler);
        $whoops->register();
    }
}