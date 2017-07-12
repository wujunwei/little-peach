<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-07-03
 * Time: 上午 10:24
 */

namespace LittlePeach\Base;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class Controller
{
    use ViewTrait;

    public function __construct()
    {
        //$this->response = new Response();
    }

    /**
     * @param array|string $content
     * @param int $code
     */
    public function sendResponse($content = '', $code = 200)
    {
        if ($this->component === null && is_array($content)){
            $response = new JsonResponse($content, $code);
        }else if($code === Response::HTTP_SEE_OTHER || $code === Response::HTTP_FOUND){
            $response = new RedirectResponse($content, $code);
        }else{
            $response = new Response($content, $code);
        }
        //todo handle cookies
    }
}