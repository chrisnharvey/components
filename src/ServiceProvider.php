<?php

namespace Encore\Resource;

class ServiceProvider extends \Encore\Container\ServiceProvider
{
    public function register()
    {
        $this->container->bind('resource', function() {
            return new Manager($this->container->resourcePath());
        });
    }

    public function commands()
    {
        return ['Encore\Resource\Command\Publish'];
    }
}