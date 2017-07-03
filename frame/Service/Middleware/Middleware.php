<?php
/**
 * Created by PhpStorm.
 * User: wjw33
 * Date: 2017-07-02
 * Time: 19:57
 */

namespace LittlePeach\Service\Middleware;

use LittlePeach\Interfaces\DelegateInterface;
use LittlePeach\Interfaces\MiddlewareInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class Middleware implements MiddlewareInterface
{

    /**
     * Process an incoming server request and return a response, optionally delegating
     * to the next middleware component to create the response.
     *
     * @param Request $request
     * @param DelegateInterface $delegate
     *
     * @return Response
     */
    final function process(
        Request $request,
        DelegateInterface $delegate
    )
    {
        $this->run($request);
        return $delegate->process($request);
    }

    /**
     *  Perform actions specific to this middleware
     * @param Request $request
     */
    public function run(Request $request)
    {

    }
}