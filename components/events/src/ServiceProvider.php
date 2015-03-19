<?php

namespace Encore\Events;

use Sabre\Event\EventEmitter;
use Encore\Container\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register the events dispatcher into the container.
     *
     * @return void
     */
    public function register()
    {
        $this->container->bind('events', new Dispatcher(new EventEmitter));
    }
}