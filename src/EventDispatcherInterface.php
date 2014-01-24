<?php

namespace Encore\Container;

interface EventDispatcherInterface
{
    public function listen($event, \Closure $trigger);
}