<?php

namespace Encore\Container;

use Closure;

interface EventDispatcherInterface
{
    /**
     * Listen for a specific event to occur
     *
     * @param string $event
     * @param Closure $trigger
     * @return void
     */
    public function listen($event, Closure $trigger);
}