<?php

namespace Openphp\Container;


abstract class Facade
{
    /**
     * @return string
     */
    protected static function getFacadeClass()
    {
    }

    /**
     * @param string $class
     * @param array $args
     * @return mixed|object
     * @throws BindingResolutionException
     */
    protected static function createFacade(string $class = '', array $args = [])
    {
        $class       = $class ?: static::class;
        $facadeClass = static::getFacadeClass();
        if ($facadeClass) {
            $class = $facadeClass;
        }
        return Application::getInstance()->make($class, $args);
    }

    /**
     * @param ...$args
     * @return mixed|object|void
     * @throws BindingResolutionException
     */
    public static function instance(...$args)
    {
        if (__CLASS__ != static::class) {
            return self::createFacade('', $args);
        }
    }
    // 调用实际类的方法

    /**
     * @param $method
     * @param $params
     * @return false|mixed
     * @throws BindingResolutionException
     */
    public static function __callStatic($method, $params)
    {
        return call_user_func_array([static::createFacade(), $method], $params);
    }
}