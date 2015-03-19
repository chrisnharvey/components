<?php

namespace Encore\Resource;

use Encore\Container\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register the command for publishing resources.
     *
     * @return void
     */
    public function commands()
    {
        return ['Encore\Resource\Command\Publish'];
    }
}
