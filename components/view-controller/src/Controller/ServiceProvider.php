<?php

namespace Encore\Controller;

use Encore\Container\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register the controller into the container
     *
     * @return void
     */
    public function register()
    {
        $this->container->bind('Encore\Controller\Controller')
            ->withMethod('setupView');
    }
}