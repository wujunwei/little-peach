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

}