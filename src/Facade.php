<?php

namespace Encore\Console;

class Facade extends \Encore\Container\Facade
{
    public static function getFacadeAccessor()
    {
        return 'console';
    }
}