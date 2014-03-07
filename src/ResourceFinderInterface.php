<?php

namespace Encore\Resource;

interface ResourceFinderInterface
{
    /**
     * Get the fully qualified location of the resource.
     *
     * @param string $resource
     * @param string $name
     * @return string
     */
    public function find($name);

    /**
     * Set the name of this resource so we know where to look.
     *
     * @param string $name
     * @return string
     */
    public function setResource($name);

    /**
     * Set the extensions for this resource.
     *
     * @param array $extensions
     * @return void
     */
    public function setExtensions(array $extensions);

    /**
     * Add a location for the current resource
     *
     * @param string $location
     * @return void
     */
    public function addLocation($location);

    /**
     * Add a namespace for the current resource
     *
     * @param string $namespace
     * @param string $location
     * @return void
     */
    public function addNamespace($namespace, $location);
}