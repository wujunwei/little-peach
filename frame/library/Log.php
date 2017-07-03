<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-07-03
 * Time: 下午 4:52
 */

namespace LittlePeach\library;


use LittlePeach\Utility\Common;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class Log
{
    private static $_instance = null;
    /**
     * @var Logger
     */
    private static $logger = null;
    private $data;

    /**
     * @return static
     */
    public static function getInstance()
    {
        if (self::$_instance === null){
            self::$_instance = new self();
        }
        if (self::$logger === null){
            self::$logger = new Logger('Log-system');
        }
        return self::$_instance;
    }

    private function getLogPath($fileName = 'log')
    {
        $date = date('Y-m-d');
        return Common::getLogPath() . DIRECTORY_SEPARATOR . $date . DIRECTORY_SEPARATOR . $fileName . '.log';
    }


    /**
     * @param \Throwable $error
     */
    public function onShutDown(\Throwable $error)
    {

    }

    /**
     * @param $errno
     * @param $errstr
     * @param $errfile
     * @param string $errline
     * @param string $errcontext
     */
    public function onError($errno, $errstr, $errfile, $errline = '', $errcontext = '')
    {

    }

    /**
     * @param \Throwable $exception
     */
    public function onException(\Throwable $exception)
    {

    }

    public function Log($filename, $level = Logger::DEBUG)
    {
        //todo logEntity
        self::$logger->pushHandler(new StreamHandler($this->getLogPath($filename), $level));
        self::$logger->log($level, $this->data);
    }

}