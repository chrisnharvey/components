<?php

namespace Encore\View;

use Illuminate\Filesystem\Filesystem;

class FileFinder implements FinderInterface
{
    protected $fs;
    protected $paths;
    protected $views = array();
    protected $extensions = array('xrc');

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
        if (isset($this->views[$name])) return $this->views[$name];

        if (strpos($name, '::') !== false) {
                return $this->views[$name] = $this->findNamedPathView($name);
        }

        return $this->views[$name] = $this->findInPaths($name, $this->paths);
    }

    /**
     * Add a location to the finder.
     *
     * @param string $location
     * @return void
     */
    public function addLocation($location)
    {

    }

    /**
     * Add a namespace hint to the finder.
     *
     * @param string $namespace
     * @param string $hint
     * @return void
     */
    public function addNamespace($namespace, $hint)
    {

    }

    /**
     * Add a valid view extension to the finder.
     *
     * @param string $extension
     * @return void
     */
    public function addExtension($extension)
    {

    }

    protected function findInPaths($name, array $paths)
    {
        foreach ($paths as $path) {
            foreach ($this->getPossibleViewFiles($name) as $file) {

                if ($this->fs->exists($viewPath = $path.'/'.$file)) {
                    return $viewPath;
                }

            }
        }

        throw new \InvalidArgumentException("View '$name' not found.");
    }

    /**
     * Get an array of possible view files.
     *
     * @param string $name
     * @return array
     */
    protected function getPossibleViewFiles($name)
    {
        return array_map(function($extension) use ($name) {
            return str_replace('.', '/', $name).'.'.$extension;
        }, $this->extensions);
    }
}