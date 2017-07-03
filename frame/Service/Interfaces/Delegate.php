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

interface DelegateInterface
{
    /**
     * dispatch the next available middleware and return the response.
     *
     * @param Request $request
     * @return Response
     */
    public function process(Request $request);
}