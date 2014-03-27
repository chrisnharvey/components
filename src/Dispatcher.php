<?php

namespace Encore\Events;

use Sabre\Event\EventEmitterInterface;

class Dispatcher implements DispatcherInterface
{
    protected $event;

    public function __construct(EventEmitterInterface $event)
    {
        $this->event = $event;
    }

    /**
     * Subscribe to an event.
     *
     * @param string $event
     * @param callable $callback
     * @param int $priority
     * @return void
     */
    public function listen($event, callable $callback, $priority = 100)
    {
        $this->event->on($event, $callback, $priority);
    }

    /**
     * Subscribe to an event exactly once.
     *
     * @param string $event
     * @param callable $callback
     * @param int $priority
     * @return void
     */
    public function once($event, callable $callback, $priority = 100)
    {
        $this->event->once($event, $callback, $priority);
    }

    /**
     * Emits an event.
     *
     * This method will return true if 0 or more listeners were succesfully
     * handled. false is returned if one of the events broke the event chain.
     *
     * @param string $event
     * @param array $arguments
     * @return bool
     */
    public function fire($event, array $arguments = [])
    {
        return $this->event->emit($event, $arguments);
    }

    /**
     * Returns the list of listeners for an event.
     *
     * The list is returned as an array. Every item is another array with 2
     * elements: priority and the callback.
     *
     * The array is returned by reference, and can therefore be used to
     * manipulate the list of events.
     *
     * @param string $event
     * @return array
     */
    public function listeners($event)
    {
        return $this->event->listeners($event);
    }

    /**
     * Removes a specific listener from an event.
     *
     * @param string $event
     * @param callable $listener
     * @return void
     */
    public function forgetListener($event, callable $listener)
    {
        $this->event->removeListener($event, $listener);
    }

    /**
     * Removes all listeners from the specified event.
     *
     * @param string $event
     * @return void
     */
    public function forget($event)
    {
        $this->event->removeAllListeners($event);
    }
}