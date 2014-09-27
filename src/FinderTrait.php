<?php

namespace Encore\Resource;

use Encore\Namespacer\NamespacableTrait;

trait FinderTrait
{
    use NamespacableTrait;

    /**
     * Add a location to the finder.
     *
     * @param string $location
     * @return void
     */
    public function addLocation($location)
    {
        $this->paths[] = $location;
    }

    /**
     * Add a valid view extension to the finder.
     *
     * @param string $extension
     * @return void
     */
    public function addExtension($extension)
    {
        $this->extensions[] = $extension;
    }

    /**
     * Return an array of all the registered locations
     *
     * @return array
     */
    public function getLocations()
    {
        return $this->locations;
    }

    /**
     * Return an array of all the registered extensions
     *
     * @return array
     */
    public function getExtensions()
    {
        return $this->extensions;
    }
}