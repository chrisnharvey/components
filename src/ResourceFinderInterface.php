<?php

namespace Encore\Resource;

interface ResourceFinderInterface
{
    /**
     * Get the fully qualified location of the resource.
     *
     * @param string $resource
     * @return string
     */
    public function find($resource);
}