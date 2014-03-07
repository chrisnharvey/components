<?php

namespace Encore\Console;

class Facade extends \Encore\Container\Facade
{
    public static function getFacade()
    {
        return 'console';
    }
}