<?php

namespace Encore\Error;

use Encore\Error\Displayer\BasicDisplayer;

class ServiceProvider extends \Encore\Container\ServiceProvider
{
    public function register()
    {
        $displayer = new BasicDisplayer;
        $handler = new Handler($displayer);
        $this->container->bind('error', $handler);
    }
}