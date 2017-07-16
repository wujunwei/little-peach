<?php
/**
 * Created by PhpStorm.
 * User: wjw33
 * Date: 2017-07-04
 * Time: 20:24
 */

namespace LittlePeach\Service\Middleware;


use Doctrine\DBAL\DriverManager;
use LittlePeach\Interfaces\DelegateInterface;
use LittlePeach\Interfaces\MiddlewareInterface;
use LittlePeach\Service\Kernel;
use LittlePeach\Utility\Common;
use LittlePeach\Utility\Redis;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig_Environment;
use Twig_Loader_Filesystem;

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
        //add redis container
        Kernel::getInstance()->getContainer()->addFactory('redis', function (){
            return new Redis();
        });
        //add db container
        Kernel::getInstance()->getContainer()->addFactory('database', function(){
            $db_config = Kernel::getInstance()->getConfig('db');
            $connectionParams = array(
                'dbname' => $db_config['db_name'],
                'user' => $db_config['db_user'],
                'prefix' => $db_config['db_prefix'],
                'password' => $db_config['db_pass'],
                'host' => $db_config['db_host'],
                'port' =>  $db_config['db_port'],
                'driver' => 'pdo_mysql',
                'charset' => 'utf8'
            );
            return DriverManager::getConnection($connectionParams);
        });

        //add twig container
        Kernel::getInstance()->getContainer()->addFactory('twig', function (){
            $loader = new Twig_Loader_Filesystem(Common::getTemplatePath());
            $config = [
                'cache' => Common::getCachePath(),
            ];
            if (Kernel::getInstance()->getDebugLevel(Kernel::VIEW_DEBUG)){
                $config['debug'] = true;
                $config['cache'] = false;
                $config['strict_variables'] = true;
            }
            return new Twig_Environment($loader, $config);
        });
        return $delegate->process($request);
    }
}