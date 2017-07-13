<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-07-03
 * Time: 上午 10:24
 */

namespace LittlePeach\Base;


use LittlePeach\Service\Kernel;
use LittlePeach\Utility\Common;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Controller
{
    use ViewTrait;
    public $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param array|string $info
     * @param int $code
     * @param null $message
     * @return JsonResponse|RedirectResponse|Response
     */
    public function createResponse($info = '', $code = 200, $message = null)
    {
        if ($this->component === null){
            $data = [
                'code' => $code,
                'msg' => $message ? $message:'',
                'info' => empty($info) ? null: $info
            ];
            $response = new JsonResponse($data, $code);
        }else if($code >= 300 && $code < 400){
            $response = new RedirectResponse($info, $code);
        }else{
            $response = new Response($info, $code);
        }
        return $response;
        //todo handle cookies
    }

    public function getContainer()
    {
        return Kernel::getInstance()->getContainer();
    }

    public function loadBusiness($business)
    {
        $namespace = Common::getModuleNameSpace($this, $business, 'Business');
        return $this->getContainer()->get($namespace);
    }

}