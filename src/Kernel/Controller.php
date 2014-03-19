<?php

namespace Encore\Kernel;

use Encore\Container\ContainerAwareTrait;
use Encore\Container\ContainerAwareInterface;

abstract class Controller implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function __destruct()
    {
        $collection = $this->container->resolve('collection');

        // Assign the object to another var
        $that = $this;

        // Change the scope (kinda).
        $savable = function() use ($that) {
            return get_object_vars($that);
        };

        // Save public properties in the collection
        $collection[] = $savable(); 
    }
}