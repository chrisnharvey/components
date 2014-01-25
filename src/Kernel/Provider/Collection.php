<?php

namespace Encore\Kernel\Provider;

use \Encore\Kernel\Collection;

class Collection extends \Encore\Container\ServiceProvider
{
    public function register()
    {
        $this->container->bind('collection', new Collection);
    }
}