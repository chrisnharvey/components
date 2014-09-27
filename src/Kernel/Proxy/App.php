<?php

namespace Encore\Kernel\Proxy;

use Encore\Container\Proxy;

class App extends Proxy
{
    public static function getConcreteBinding()
    {
        return 'app';
    }
}