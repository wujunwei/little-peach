<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-07-04
 * Time: 下午 3:10
 */

namespace LittlePeach\Utility;


use LittlePeach\Interfaces\ConfigInterface;

class Config implements ConfigInterface, \ArrayAccess
{
    private $data = null;
    private $supportFileParsers = ['ini', 'php', 'json'];

    public function __construct($path = null)
    {
        if (! is_null($path)) {
            $this->load($path);
        }
    }

    /**
     * 加载配置文件或者目录
     * @param string|array $path
     * @return $this
     */
    public function load($path)
    {
        $this->data = [];
        $paths = is_array($path) ? $path : [$path];
        foreach ($paths as $path) {
            $this->data = array_merge($this->data, $this->parse($path));
        }
        return $this;
    }

    /**
     * 解析一个配置文件或者配置目录
     * @param string|array $path
     * @return array
     */
    public function parse($path)
    {
        $data = [];
        $filePaths = $this->getFilePath($path);
        foreach ($filePaths as $filePath) {
            $extension = pathinfo($filePath, PATHINFO_EXTENSION);
            if (in_array($extension, $this->supportFileParsers)){
                $temp = call_user_func([$this, 'parse'.ucfirst($extension)], $filePath);
                $data = array_merge($data, $temp);
            }
        }
        return $data;
    }

    /**
     * 将配置数据静态化到一个配置文件
     * @param string $filePath
     * @return boolean
     */
    function dump($filePath)
    {
        //todo
    }

    /**
     * 获取配置文件或者配置目录下的合法文件
     *
     * @param string| $path
     * @throws \InvalidArgumentException
     * @return array
     */
    function getFilePath($path)
    {
        if (is_dir($path)) {
            $paths = glob($path . '/*.*');
            if (empty($paths)) {
                throw new \InvalidArgumentException(sprintf('Directory "%s" is empty', $path));
            }
        } else {
            if (!file_exists($path)) {
                throw new \InvalidArgumentException(sprintf('File "%s" cannot be found', $path));
            } else {
                $paths = [$path];
            }
        }
        return $paths;
    }

    private function parseIni($filePath)
    {
        if (($data = @parse_ini_file($filePath, true)) === false) {
            throw new \Exception(sprintf('The file "%s" has syntax errors', $filePath));
        } else {
            return $data;
        }
    }

    private function parseJson($filePath)
    {
        $data = json_decode(file_get_contents($filePath), true);
        if (json_last_error() != JSON_ERROR_NONE) {
            throw new \Exception(sprintf('The file (%s)  need to contain a valid json string', $filePath));
        }
        return $data;
    }

    /**
     * @param $filePath
     * @return mixed
     * @throws \Exception
     */
    private function parsePhp($filePath)
    {
        $data = require $filePath;
        if (! is_array($data)) {
            throw new \Exception(sprintf('The file "%s" must return a PHP array', $filePath));
        }
        return $data;
    }

    /**
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        if (is_null($this->data)){
            return false;
        }
        return isset($this->data[$offset]);
    }

    /**
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        if (is_null($this->data)){
            return null;
        }
        return isset($this->data[$offset]) ? $this->data[$offset] : null;
    }

    /**
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($this->data)){
            $this->data = [];
        }
        $this->data[$offset] = $value;
    }

    /**
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        if (is_null($this->data)){
            $this->data = [];
        }else{
            unset($this->data[$offset]);
        }

    }
}