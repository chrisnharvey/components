<?php

namespace Encore\View;

class Proxy extends \Encore\Container\Proxy
{
    public static function getConcreteBinding()
    {
        return 'view';
    }
}