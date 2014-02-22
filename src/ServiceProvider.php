<?php

namespace Encore\Console;

use Encore\Console\Application as Console;

class ServiceProvider extends \Encore\Container\ServiceProvider
{
    public function register()
    {
        $this->container->bind('console', new Console('EncorePHP', $this->container::VERSION));
    }
}