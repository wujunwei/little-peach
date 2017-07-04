<?php
/**
 * Created by PhpStorm.
 * User: wjw33
 * Date: 2017-07-04
 * Time: 19:42
 */

namespace LittlePeach\Utility;


use LittlePeach\Service\Kernel;

class Redis
{

    static $ONE_HOUR = 3600;
    static $ONE_DAY = 24 * 3600;
    private $client = null;
    private $prefix = '';
    public function __construct()
    {
        $this->prefix = Kernel::getInstance()->getConfig('prefix');
        $config = Kernel::getInstance()->getConfig('redis');
        $this->client = new \Redis();
        $this->client->connect($config['host'], $config['port']);
    }

    /**
     * @param string $key
     * @param string $value
     * @param int $timeout
     * @return bool
     */
    public function set($key = '', $value = '', $timeout = 3600)
    {
        $key = $this->addPrefix($key);
        $value = serialize($value);
        return $this->client->setex($key, $timeout, $value);
    }

    private function addPrefix($key)
    {
        return $this->prefix . $key;
    }

    /**
     * @param string $key
     * @return bool|string
     */
    public function get($key = '')
    {
        if (Kernel::getInstance()->getDebugLevel(Kernel::DISABLE_CACHE)){
            return false;
        }
        $key = $this->addPrefix($key);
        return unserialize($this->client->get($key));
    }

    public function ttl($key = '')
    {
        $key = $this->addPrefix($key);
        return $this->client->ttl($key);
    }

    function __destruct()
    {
        $this->client->close();
    }
}