<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-06-30
 * Time: 下午 4:53
 */

namespace LittlePeach\Utility;



class Common
{
    private function __construct()
    {
    }

    function __clone()
    {
        trigger_error('Common Class can not be cloned !', E_ERROR);
    }

    static function getRootPath()
    {
        return ROOT_PATH;
    }

    static function getLogPath()
    {
        return LOG_PATH;
    }

    static function getConfigPath()
    {
        return CONFIG_PATH;
    }

    static function getCachePath()
    {
        return CACHE_PATH;
    }

    static function getTemplatePath()
    {
        return TEMPLATE_PATH;
    }

    static function getAppRootNameSpace()
    {
        return APP_ROOT_SPACE;
    }

    static function getModuleName($class)
    {
        $reflection = new \ReflectionClass($class);
        return $reflection->getNamespaceName();
    }

    static function getModuleNameSpace($class, $service, $module)
    {
        $path = explode('.', $service);
        if (count($path) == 1){
            $namespace = self::getModuleName($class)."\\{$module}\\".$service;
        }else{
            $namespace = self::getAppRootNameSpace()."{$path[0]}\\{$module}\\{$path[1]}";
        }
        return $namespace;
    }

}