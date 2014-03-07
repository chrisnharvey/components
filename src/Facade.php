<?php

namespace Encore\Resource;

class Facade extends \Encore\Container\Facade
{
    public static function getFacadeAccessor()
    {
        return 'resource';
    }
}