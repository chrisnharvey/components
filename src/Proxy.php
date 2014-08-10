<?php

namespace Encore\Error;

class Proxy extends \Encore\Container\Proxy
{
    public static function getConcreteBinding()
    {
        return 'error';
    }
}