<?php

namespace Encore\Error;

use Encore\Container\Proxy as BaseProxy;

class Proxy extends BaseProxy
{
    public static function getConcreteBinding()
    {
        return 'error';
    }
}