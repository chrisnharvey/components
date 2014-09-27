<?php

namespace Encore\View;

use Encore\Container\Proxy as BaseProxy;

class Proxy extends BaseProxy
{
    public static function getConcreteBinding()
    {
        return 'view';
    }
}