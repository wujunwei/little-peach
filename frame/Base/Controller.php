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
     * @param null $message
     */
    public function sendResponse($content = '', $code = 200, $message = null)
    {
        if ($this->component === null && is_array($content)){
            $data = [
                'code' => $code,
                'msg' => $message ? $message:'',
                'info' => empty($content) ? null: $content
            ];
            $response = new JsonResponse($data, $code);
        }else if($code >= 300 && $code <= 400){
            $response = new RedirectResponse($content, $code);
        }else{
            $response = new Response($content, $code);
        }
        //todo handle cookies
    }
}