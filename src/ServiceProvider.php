<?php

namespace Encore\Giml;

use Encore\Giml\Support\View as ViewParser;
use Encore\Container\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        $this->container['giml.reader'] = new Reader;
    }

    public function boot()
    {
        if ($this->container->bound('view.viewfinder')) {
            $this->container['view.viewfinder']->addExtension('gim');
        }
    }
}