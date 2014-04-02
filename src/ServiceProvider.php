<?php

namespace Encore\REPL;

class ServiceProvider extends \Encore\Container\ServiceProvider
{
    public function commands()
    {
        return ['Encore\REPL\Command'];
    }
}