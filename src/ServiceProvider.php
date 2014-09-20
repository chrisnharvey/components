<?php

namespace Encore\Error;

class ServiceProvider extends \Encore\Container\ServiceProvider
{
    public function register()
    {
        $this->container->bind('Encore\Error\ExceptionDisplayerInterface', 'Encore\Error\ConsoleDisplayer');
        $this->container->bind('error', 'Encore\Error\Handler');
    }
}