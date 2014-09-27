<?php

namespace Encore\REPL;

class ServiceProvider extends \Encore\Container\ServiceProvider
{
    /**
     * Register the REPL command.
     *
     * @return void
     */
    public function commands()
    {
        return ['Encore\REPL\Command'];
    }
}