<?php

namespace Encore\Config;

use Symfony\Component\Filesystem\Filesystem;

class FileLoader implements LoaderInterface
{
    public function __construct(Filesystem $fs, $path, $os = null)
    {
        $this->fs = $fs;
        $this->path = $path;
        $this->os = $os;
    }

    /**
    * Load the given configuration group.
    *
    * @param string $environment
    * @param string $group
    * @param string $namespace
    * @return array
    */
    public function load($environment, $group, $namespace = null)
    {

    }

    /**
    * Determine if the given configuration group exists.
    *
    * @param string $group
    * @param string $namespace
    * @return bool
    */
    public function exists($group, $namespace = null)
    {

    }

    /**
    * Add a new namespace to the loader.
    *
    * @param string $namespace
    * @param string $hint
    * @return void
    */
    public function addNamespace($namespace, $hint)
    {

    }

    /**
    * Returns all registered namespaces with the config
    * loader.
    *
    * @return array
    */
    public function getNamespaces()
    {

    }
}