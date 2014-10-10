<?php

namespace Encore\Repl;

use Encore\Container\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register the REPL command.
     *
     * @return void
     */
    public function commands()
    {
        return ['Encore\Repl\Command'];
    }
}