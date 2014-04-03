<?php

namespace Encore\GIML;

use Encore\GIML\Support\View as ViewParser;

class ServiceProvider extends \Encore\Container\ServiceProvider
{
    public function register()
    {
        $this->container['giml.reader'] = new Reader;
    }

    public function boot()
    {
        $this->container['view.finder']->addExtension('gim');
    }
}