<?php

namespace Encore\Resource;

class Proxy extends \Encore\Container\Proxy
{
    public static function getConcreteBinding()
    {
        return 'resource';
    }
}