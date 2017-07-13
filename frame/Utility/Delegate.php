<?php
/**
 * Created by PhpStorm.
 * User: wjw33
 * Date: 2017-07-02
 * Time: 19:57
 */

namespace LittlePeach\Utility;


use LittlePeach\Interfaces\DelegateInterface;
use LittlePeach\Interfaces\MiddlewareInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Delegate implements DelegateInterface
{

    /**
     * @var \SplQueue
     */
    private $middles;

    /**
     * @var array
     */
    private $objPool;

    public function __construct()
    {
        $this->middles = new \SplQueue();
        $this->objPool = [];
    }

    /**
     * enqueue middleware
     * @param MiddlewareInterface $middleware
     */
    public function enqueue(MiddlewareInterface $middleware)
    {
        $className = get_class($middleware);
        if ($middleware instanceof MiddlewareInterface && !isset($this->objPool[$className])){
            $this->middles->enqueue($middleware);
            $this->objPool[$className] = 1;
        }else{
            throw new \InvalidArgumentException('The params got are not instance of MiddlewareInterface');
        }
    }

    /**
     * @return null|MiddlewareInterface
     */
    public function dequeue()
    {
        if ($this->middles->isEmpty()){
            return null;
        }

        return $this->middles->dequeue();
    }

    /**
     * dispatch the next available middleware and return the response.
     *
     * @param Request $request
     * @return Response
     */
    public function process(Request $request)
    {
        if (!$this->middles->isEmpty()){
            $current = $this->dequeue();
            if (method_exists($current, 'process')){
                $response = $current->process($request, $this);
            }else{
                throw new \BadMethodCallException(sprintf('\'process\' Method noe exist on \'%s\' class', get_class($request)));
            }
        }else{
            $response = new Response();
        }
        if ($response instanceof Response){
            return $response;
        }else{
            return new Response('', 500);
        }
    }
}