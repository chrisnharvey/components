<?php

namespace Encore\Config;

use Encore\Namespacer\Namespacable;
use Symfony\Component\Filesystem\Filesystem;

class FileLoader extends Namespacable implements LoaderInterface
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
    protected $path;

    /**
    * The operating system
    *
    * @var string
    */
    protected $os = null;

    /**
    * The constructor
    *
    * @param Symfony\Component\Filesystem\Filesystem
    * @param $path
    * @param $os
    */
    public function __construct(Filesystem $fs, $path, $os = null)
    {
        $this->fs = $fs;
        $this->path = $path;
        $this->os = $os;
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
        $items = array();

        // Lets find where the path is
        $path = $this->getPath($namespace);

        if (is_null($path)) return $items;

        // First things first... Is there a top-level config file?
        $file = "{$path}/{$group}.php";

        if ($this->fs->exists($file)) {
            $items = require $file;
        }

        // Do we have an operating system specific config file?
        $file = "{$path}/{$this->os}/{$group}.php";

        if ($this->fs->exists($file)) {
            $items = $this->mergeItems($items, $file);
        }

        // Do we have an application mode specific config file?
        $file = "{$path}/{$mode}/{$group}.php";

        if ($this->fs->exists($file)) {
            $items = $this->mergeItems($items, $file);
        }

        // And lastly we'll check if we have an mode and OS specific
        // config file.
        $file = "{$path}/{$this->os}/{$mode}/{$group}.php";

        if ($this->fs->exists($file)) {
            $items = $this->mergeMode($items, $file);
        }

        return $items;
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

        $path = $this->getPath($namespace);

        // If the path is null then the file does not exist
        if (is_null($path)) return $this->exists[$key] = false;

        $file = "{$path}/{$group}.php";

        // Does it exist?
        $exists = $this->fs->exists($file);

        // Cache and return
        return $this->exists[$key] = $exists;
    }

    /**
    * Merge the configuration items
    *
    * @param array $items
    * @param string $file
    * @return array
    */
    protected function mergeItems(array $items, $file)
    {
        return array_merge_recursive($items, require $file);
    }

    /**
    * Get the path for the specified namespace
    *
    * @param string $namespace
    * @return string
    */
    protected function getPath($namespace)
    {
        if (is_null($namespace)) {
            return $this->path;
        } elseif (isset($this->hints[$namespace])) {
            return $this->hints[$namespace];
        }
    }
}