<?php

namespace Encore\Config;

use Encore\Namespacer\Resolver;
use Symfony\Component\Filesystem\Filesystem;

class ServiceProvider extends \Encore\Container\ServiceProvider
{
    public function register()
    {
        $this->container->bind('config', new Repository(
            new FileLoader(new Filesystem),
            new Resolver
        ));
    }
}