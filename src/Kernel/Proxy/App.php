<?php

namespace Encore\Kernel\Proxy;

class App extends \Encore\Container\Proxy
{
    public static function getConcreteBinding()
    {
        return 'app';
    }
}