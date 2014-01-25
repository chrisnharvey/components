<?php

namespace Encore\Kernel\Provider;

use Encore\Kernel\Command\Run as RunCommand;

class Application extends \Encore\Container\ServiceProvider
{
    public function boot()
    {
        $this->container['console']->add(new RunCommand($this->container));
    }
}