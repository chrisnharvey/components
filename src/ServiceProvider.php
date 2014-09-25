<?php

namespace Encore\Events;

use Sabre\Event\EventEmitter;

class ServiceProvider extends \Encore\Container\ServiceProvider
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