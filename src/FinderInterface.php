<?php

namespace Encore\Resource;

use Encore\Namespacer\NamespacableInterface;

interface FinderInterface extends NamespacableInterface
{
    /**
     * Get the fully qualified location of the resource.
     *
     * @param  string  $name
     * @return string
     */
    public function find($name);

    /**
     * Add a location to the finder.
     *
     * @param  string  $location
     * @return void
     */
    public function addLocation($location);

    /**
     * Return an array of all the registered locations
     *
     * @return array
     */
    public function getLocations();

    /**
     * Add a valid view extension to the finder.
     *
     * @param  string  $extension
     * @return void
     */
    public function addExtension($extension);

    /**
     * Return an array of all the registered extensions
     *
     * @return array
     */
    public function getExtensions();
}