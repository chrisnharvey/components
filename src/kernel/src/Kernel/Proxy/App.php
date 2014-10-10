<?php

namespace Encore\Kernel\Proxy;

use Encore\Container\Proxy;

class App extends Proxy
{
    /**
     * Get the name of the concrete binding in the container.
     *
     * @return string
     */
    public static function getConcreteBinding()
    {
        return 'app';
    }
}