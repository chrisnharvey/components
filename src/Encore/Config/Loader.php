<?php

namespace Encore\Config;

use Illuminate\Filesystem\Filesystem;

class Loader extends \Illuminate\Config\FileLoader
{
    protected $os;

    public function __construct(Filesystem $files, $defaultPath, $os)
    {
        $this->os = $os;

        parent::__construct($files, $defaultPath);
    }

    public function load($environment, $group, $namespace = null)
    {
        $items = array();

        // First we'll get the root configuration path for the environment which is
        // where all of the configuration files live for that namespace, as well
        // as any environment folders with their specific configuration items.
        $path = $this->getPath($namespace);

        if (is_null($path)) {
            return $items;
        }

        // First we'll get the main configuration file for the groups. Once we have
        // that we can check for any environment specific files, which will get
        // merged on top of the main arrays to make the environments cascade.
        $file = "{$path}/{$group}.php";

        if ($this->files->exists($file)) {
            $items = $this->files->getRequire($file);
        }

        // Now we'll check if we have an OS specific config file
        $file = "{$path}/{$this->os}/{$group}.php";

        if ($this->files->exists($file)) {
            $items = $this->mergeEnvironment($items, $file);
        }

        // Check for a global environment config file (not OS specific)
        $file = "{$path}/{$environment}/{$group}.php";

        if ($this->files->exists($file)) {
            $items = $this->mergeEnvironment($items, $file);
        }

        // And lastly we'll check if we have an environment and OS specific
        // config file and merge.
        $file = "{$path}/{$this->os}/{$environment}/{$group}.php";

        if ($this->files->exists($file)) {
            $items = $this->mergeEnvironment($items, $file);
        }

        return $items;
    }
}