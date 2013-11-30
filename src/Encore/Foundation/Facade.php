<?php

namespace Encore\Foundation;

abstract class Facade
{
    protected static $app;
    protected static $resolved;

    public static function getFacade()
    {
        throw new \RuntimeException('Facade does not implement getFacade method');
    }

    public static function resolveFacade($name)
    {
        if (is_object($name)) return $name;

        if (isset(static::$resolved[$name])) return static::$resolved[$name];

        return static::$resolved[$name] = static::$app[$name];
    }

    public static function getApplication()
    {
        return static::$app;
    }

    public static function setApplication($app)
    {
        static::$app = $app;
    }

    public static function __callStatic($method, $args)
    {
        $instance = static::resolveFacade(static::getFacade());

        switch (count($args))
        {
            case 0:
                return $instance->$method();

            case 1:
                return $instance->$method($args[0]);

            case 2:
                return $instance->$method($args[0], $args[1]);

            case 3:
                return $instance->$method($args[0], $args[1], $args[2]);

            case 4:
                return $instance->$method($args[0], $args[1], $args[2], $args[3]);

            default:
                return call_user_func_array(array($instance, $method), $args);
        }
    }
}