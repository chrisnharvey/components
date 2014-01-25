<?php

namespace Encore\Resource;

class ResourceFinder implements ResourceFinderInterface
{
    protected $name;
    protected $extensions;
    protected $path;

    public function __construct($name, array $extensions, array $namespaces, $path)
    {
        $this->name = $name;
        $this->extensions = $extensions;
        $this->namespaces = $namespaces;
        $this->path = $path;
    }

    public function find($resource)
    {

    }
}