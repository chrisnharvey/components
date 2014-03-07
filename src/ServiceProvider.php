<?php

namespace Encore\Config;

use Encore\Namespacer\Resolver;
use Symfony\Component\Filesystem\Filesystem;

class ServiceProvider extends \Encore\Container\ServiceProvider
{
    public function register()
    {
        $this->container->bind('config', new Repository(
            new FileLoader(
                new Filesystem,
                $this->container->appPath().'/config',
                $this->container->os()
            ),
            new Resolver,
            $this->container->mode()
        ));
    }
}