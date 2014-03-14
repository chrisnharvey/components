<?php

namespace Encore\Config;

use Encore\Namespacer\NamespacableInterface;

interface LoaderInterface extends NamespacableInterface
{
    /**
    * Load the given configuration group.
    *
    * @param string $environment
    * @param string $group
    * @param string $namespace
    * @return array
    */
    public function load($environment, $group, $namespace = null);

    /**
    * Determine if the given configuration group exists.
    *
    * @param string $group
    * @param string $namespace
    * @return bool
    */
    public function exists($group, $namespace = null);
}