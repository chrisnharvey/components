<?php

namespace Encore\Controller;

class ServiceProvider extends \Encore\Container\ServiceProvider
{
    public function register()
    {
        $this->container->bind('Encore\Controller\Controller')
            ->withMethod('setupView');
    }
}