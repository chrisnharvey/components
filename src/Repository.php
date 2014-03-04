<?php

namespace Encore\Config;

use Encore\Namespacer\ResolverInterface;
use Encore\Namespacer\NamespacableInterface;

class Repository implements NamespacableInterface
{
    protected $fs;
    protected $resolver;

    public function __construct(LoaderInterface $loader, ResolverInterface $resolver)
    {
        $this->loader = $loader;
        $this->resolver = $resolver;
    }

    public function addNamespace($namespace, $hint)
    {

    }

    public function get($key)
    {

    }
}