<?php

namespace Encore\Resource;

class ServiceProvider extends \Encore\Container\ServiceProvider
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