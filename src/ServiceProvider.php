<?php

namespace Encore\Events;

use Sabre\Event\EventEmitter;

class ServiceProvider extends \Encore\Container\ServiceProvider
{
    public function register()
    {
        $this->container->bind('events', new Dispatcher(new EventEmitter));
    }
}