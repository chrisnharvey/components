<?php

namespace Encore\Kernel\Provider;

use Encore\Kernel\Collection as CollectionClass;

class Collection extends \Encore\Container\ServiceProvider
{
    public function register()
    {
        $this->container->bind('collection', new CollectionClass);
    }
}