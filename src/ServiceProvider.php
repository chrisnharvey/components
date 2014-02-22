<?php

namespace Encore\Console;

use Encore\Console\Application as Console;

class ServiceProvider extends \Encore\Container\ServiceProvider
{
    public function register()
    {
        $container = $this->container;
        $this->container->bind('console', new Console('EncorePHP', $container::VERSION));
    }
}