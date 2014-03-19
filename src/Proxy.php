<?php

namespace Encore\Console;

class Proxy extends \Encore\Container\Proxy
{
    public static function getConcreteBinding()
    {
        return 'console';
    }
}