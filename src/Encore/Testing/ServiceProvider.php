<?php

namespace Encore\Testing;

class ServiceProvider extends \Encore\Container\ServiceProvider
{
    public function boot()
    {
        $this->container['console']->add(new Command($this->container));
    }
}