<?php

namespace Encore\Events;

class ContainerDispatcher implements \Encore\Container\EventDispatcherInterface
{
    /**
     * The constructor
     *
     * @param DispatcherInterface $dispatcher
     * @return void
     */
    public function __construct(DispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * Listen for a specific event to occur
     *
     * @param string $event
     * @param Closure $trigger
     * @return void
     */
    public function listen($event, \Closure $trigger)
    {
        $this->dispatcher->listen($event, $trigger);
    }
}