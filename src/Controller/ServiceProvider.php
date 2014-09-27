<?php

namespace Encore\Controller;

class ServiceProvider extends \Encore\Container\ServiceProvider
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