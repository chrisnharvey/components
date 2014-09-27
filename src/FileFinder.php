<?php

namespace Encore\Resource;

use InvalidArgumentException;
use Encore\Filesystem\Filesystem;

class FileFinder implements FinderInterface
{
    use FinderTrait;

    protected $fs;
    protected $paths = [];
    protected $resolved = [];
    protected $extensions = [];

    public function __construct(Filesystem $fs, array $paths)
    {
        $this->fs = $fs;
        $this->paths = $paths;
    }

    /**
     * Get the fully qualified location of the view.
     *
     * @param string $view
     * @return string
     */
    public function find($name)
    {
        if (isset($this->resolved[$name])) return $this->resolved[$name];

        if (strpos($name, '::') !== false) {
            return $this->resolved[$name] = $this->findNamedPathView($name);
        }

        return $this->resolved[$name] = $this->findInPaths($name, $this->paths);
    }

    /**
     * Find the file in the possible paths
     * 
     * @param  string $name
     * @param  array  $paths
     * @throws InvalidArgumentException
     * @return string Path the the view
     */
    protected function findInPaths($name, array $paths)
    {
        foreach ($paths as $path) {
            foreach ($this->getPossibleFiles($name) as $file) {

                if ($this->fs->exists($viewPath = $path.'/'.$file)) {
                    return $viewPath;
                }

            }
        }

        throw new InvalidArgumentException("Resource '$name' not found.");
    }

    /**
     * Get an array of possible files.
     *
     * @param string $name
     * @return array
     */
    protected function getPossibleFiles($name)
    {
        return array_map(function($extension) use ($name) {
            return str_replace('.', '/', $name).'.'.$extension;
        }, $this->extensions);
    }
}