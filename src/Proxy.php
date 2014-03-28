<?php

namespace Encore\Config;

class Proxy extends \Encore\Container\Proxy
{
    public static function getConcreteBinding()
    {
        return 'config';
    }
}