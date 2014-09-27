<?php

namespace Encore\Testing;

class ServiceProvider extends \Encore\Container\ServiceProvider
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