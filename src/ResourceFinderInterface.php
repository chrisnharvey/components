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
    public function find($resource, $name);

    /**
     * Set the name of this resource so we know where to look.
     *
     * @param string $name
     * @return string
     */
    public function setResource($name);

    /**
     * Get the fully qualified location of the resource.
     *
     * @param string $resource
     * @param array $extensions
     * @return void
     */
    public function setExtensions($resource, array $extensions);

    /**
     * Add a namespace for the specified resource
     *
     * @param string $resource
     * @§param string $namespace
     * @param string $location
     * @return void
     */
    public function addNamespace($resource, $namespace, $location);
}