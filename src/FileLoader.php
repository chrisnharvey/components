<?php

namespace Encore\Config;

use Encore\Namespacer\NamespacableTrait;
use Encore\Filesystem\Filesystem;

class FileLoader implements LoaderInterface
{
    /**
    * A cache of whether namespaces and groups exists.
    *
    * @var array
    */
    protected $exists = array();

    /**
    * The Symfony Filesystem component
    *
    * @var Symfony\Component\Filesystem\Filesystem
    */
    protected $fs;

    /**
    * The configuration file path
    *
    * @var string
    */
    protected $locations;

    /**
     * All of the namespace hints.
     *
     * @var array
     */
    protected $hints = [];

    /**
    * The constructor
    *
    * @param Symfony\Component\Filesystem\Filesystem
    * @param $path
    * @param $os
    */
    public function __construct(Filesystem $fs, $path)
    {
        $this->fs = $fs;
        $this->locations[] = $path;
    }

    /**
    * Load the given configuration group.
    *
    * @param string $mode
    * @param string $group
    * @param string $namespace
    * @return array
    */
    public function load($mode, $group, $namespace = null)
    {
        // Lets find where the paths are
        $paths = $this->getPaths($namespace);

        if (empty($paths)) return [];

        return $this->findInPaths($paths, $group, $mode);
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
        $key = $group.$namespace;

        // Check if we have a cached answer
        if (isset($this->exists[$key])) return $this->exists[$key];

        $paths = $this->getPaths($namespace);

        // If the path is null then the file does not exist
        if (empty($paths)) return $this->exists[$key] = false;

        // Does it exist?
        $exists = $this->findInPaths($paths, $group, null, true);

        // Cache and return
        return $this->exists[$key] = $exists;
    }

    /**
    * Add a location to config files.
    *
    * @param string $location
    * @return void
    */
    public function addLocation($location)
    {
        $this->locations[] = $location;
    }

    /**
     * Add a namespace and provide a hint
     *
     * @param string $namespace
     * @param string $hint
     * @return void
     */
    public function addNamespace($namespace, $hint)
    {
        $this->hints[$namespace][] = $hint;
    }

    /**
     * Return an array of all the registered namespaces
     *
     * @return array
     */
    public function getNamespaces()
    {
        return $this->hints;
    }

    /**
    * Get the path for the specified namespace
    *
    * @param string $namespace
    * @return string
    */
    protected function getPaths($namespace)
    {
        if (is_null($namespace)) {
            return $this->locations;
        } elseif (isset($this->hints[$namespace])) {
            return $this->hints[$namespace];
        }
    }

    /**
    * Get the path for the specified namespace
    *
    * @param array $paths
    * @param string $group
    * @param string $mode
    * @param bool $exists
    * @return string
    */
    protected function findInPaths(array $paths, $group, $mode = null, $exists = false)
    {
        $items = [];

        foreach ($paths as $path) {
            if ($this->fs->exists($file = "{$path}/{$group}.php")) {
                if ($exists) return true;

                $items = array_merge_recursive($this->fs->getRequire($file), $items);
            }

            if ($mode and $this->fs->exists($file = "{$path}/{$mode}/{$group}.php")) {
                if ($exists) return true;

                $items = array_merge_recursive($this->fs->getRequire($file), $items);
            }
        }

        return $items;
    }
}