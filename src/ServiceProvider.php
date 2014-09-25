<?php

namespace Encore\Config;

use Encore\Namespacer\Resolver;
use Encore\Filesystem\Filesystem;

class ServiceProvider extends \Encore\Container\ServiceProvider
{
    /**
     * Register the config loader into the container.
     *
     * @return void
     */
    public function register()
    {
        $this->container->bind('config', new Repository(
            new FileLoader(
                new Filesystem,
                $this->container->appPath().'/config'
            ),
            new Resolver,
            $this->container->os()
        ));
    }
}