<?php

namespace Encore\Resource;

use Encore\Resource\Command\Publish as PublishCommand;

class ServiceProvider extends \Encore\Container\ServiceProvider
{
    public function register()
    {
        $this->container->bind('resource', function() {
            return new Manager($this->container->resourcePath());
        });
    }

    public function boot()
    {
        $this->container['console']->add(new PublishCommand($this->container));
    }
}