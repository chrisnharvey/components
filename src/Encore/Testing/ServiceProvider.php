<?php

namespace Encore\Testing;

class ServiceProvider extends \Encore\Foundation\ServiceProvider
{
    public function boot()
    {
        $this->app['console']->add(new Command($this->app));
    }
}