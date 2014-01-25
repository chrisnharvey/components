<?php

namespace Encore\Kernel\Facade;

class App extends \Encore\Container\Facade
{
    public static function getFacadeAccessor()
    {
        return 'app';
    }
}