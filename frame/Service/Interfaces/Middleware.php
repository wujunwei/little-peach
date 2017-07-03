<?php
/**
 * Created by PhpStorm.
 * User: wjw33
 * Date: 2017-07-02
 * Time: 18:36
 */

namespace LittlePeach\Service\Interfaces;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface MiddlewareInterface
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
    );
}