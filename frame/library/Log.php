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

    public function onShutDown()
    {
        $lastError = error_get_last();
        if (is_null($lastError)){
            return;
        }
        $this->data = json_encode($lastError);
        self::Log('shutDown', Logger::ALERT);
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
        $this->data = json_encode([
            'errno' => $errno,
            'errstr' => $errstr,
            'errfile' => $errfile,
            'errline' => $errline,
            'errcontext' => $errcontext
        ]);
        $this->Log('error', Logger::ERROR);
    }

    /**
     * @param \Exception|\Throwable $exception
     */
    public function onException(\Exception $exception)
    {
        $this->data = $exception->getTraceAsString();
        $this->Log('exception', Logger::EMERGENCY);
    }

    public function Log($filename, $level = Logger::DEBUG)
    {
        self::$logger->pushHandler(new StreamHandler($this->getLogPath($filename), $level));
        self::$logger->log($level, $this->data);
    }

}