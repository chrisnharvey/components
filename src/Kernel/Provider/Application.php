<?php

namespace Encore\Kernel\Provider;

use Encore\Kernel\Command\Debug as DebugCommand;

class Application extends \Encore\Container\ServiceProvider
{
    public function commands()
    {
        return [
            new DebugCommand
        ];
    }
}