<?php

namespace Encore\Error;

class ServiceProvider extends \Encore\Container\ServiceProvider
{
    public function register()
    {
        $this->container->bind('Encore\Error\Displayer\DisplayerInterface', 'Encore\Error\Displayer\BasicDisplayer');
        $this->container->bind('error', 'Encore\Error\Handler');
    }
}