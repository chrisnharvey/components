<?php

namespace Encore\Giml;

use Encore\Giml\Exception\InvalidElementException;

class NamespaceElementFactory implements ElementFactoryInterface
{
    public function __construct($namespace)
    {
        $this->namespace = $namespace;
    }

    public function make($element)
    {
        $class = "{$this->namespace}\\{$element}";

        if ( ! class_exists($class)) {
            throw new InvalidElementException("Handler for '{$element}' not found");
        }

        return new $class;
    }
}