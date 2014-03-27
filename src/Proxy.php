<?php

namespace Encore\Events;

class Proxy extends \Encore\Container\Proxy
{
    public static function getConcreteBinding()
    {
        return 'events';
    }
}