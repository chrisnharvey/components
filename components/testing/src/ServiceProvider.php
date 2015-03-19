<?php

namespace Encore\Testing;

use Encore\Container\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register the test command.
     *
     * @return void
     */
    public function commands()
    {
        return ['Encore\Testing\Command'];
    }
}
