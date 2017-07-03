<?php
/**
 * Created by PhpStorm.
 * User: wjw33
 * Date: 2017-07-02
 * Time: 19:57
 */

namespace LittlePeach\Utility;


use LittlePeach\Service\Interfaces\DelegateInterface;
use LittlePeach\Service\Interfaces\MiddlewareInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Delegate implements DelegateInterface
{

    /**
     * @var \SplQueue
     */
    private $middles;

    /**
     * @var \SplObjectStorage
     */
    private $objPool;

    public function __construct()
    {
        $this->middles = new \SplQueue();
        $this->objPool = new \SplObjectStorage();
    }

    /**
     * enqueue middleware
     * @param MiddlewareInterface $middleware
     */
    public function enqueue(MiddlewareInterface $middleware)
    {
        if ($middleware instanceof MiddlewareInterface && !$this->objPool->contains($middleware)){
            $this->middles->enqueue($middleware);
            $this->objPool->attach($middleware);
        }else{
            throw new \InvalidArgumentException('The params get are not instance of MiddlewareInterface');
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
            $response = new Request();
        }
        return $response;
    }
}