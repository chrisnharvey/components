<?php

namespace Encore\Resource;

use Encore\Resource\Command\Publish as PublishCommand;

class ServiceProvider extends \Encore\Foundation\ServiceProvider
{
    public function register()
    {
        $this->app->bind('resource', function() {
            return new Manager($this->app->resourcePath());
        });
    }

    public function boot()
    {
        $this->app['console']->add(new PublishCommand($this->app));
    }
}