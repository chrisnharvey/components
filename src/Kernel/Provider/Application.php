<?php

namespace Encore\Kernel\Provider;

class Application extends \Encore\Container\ServiceProvider
{
    public function commands()
    {
        return ['Encore\Kernel\Command\Debug'];
    }
}