<?php

namespace Encore\Error;

use Encore\Error\Displayer\BasicDisplayer;
use Encore\Container\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register the error handler into the container.
     *
     * @return void
     */
    public function register()
    {
        $displayer = new BasicDisplayer;
        $handler = new Handler($displayer);
        $this->container->bind('error', $handler);
    }
}