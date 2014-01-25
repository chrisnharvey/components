<?php

namespace Encore\Resource;

class Manager
{
    protected $path;
    protected $namespaces = [];

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function create($name, array $extensions = ['*'])
    {
        $namespaces = [];

        if (array_key_exists($name, $this->namespaces)) {
            $namespaces = $this->namespaces[$name];
        }

        return new ResourceFinder($name, $extensions, $namespaces, $this->path);
    }
}