<?php

namespace Encore\Giml;

use Encore\Giml\Exception\InvalidElementException;

class NamespaceElementFactory implements ElementFactoryInterface
{
    /**
     * Construct the namespace element object
     * 
     * @param string $namespace
     */
    public function __construct($namespace)
    {
        $this->namespace = $namespace;
    }

    /**
     * Make an element
     * 
     * @param  string $element
     * @throws InvalidElementException
     * @return ElementInterface
     */
    public function make($element)
    {
        $class = "{$this->namespace}\\{$element}";

        if ( ! class_exists($class)) {
            throw new InvalidElementException("Handler for '{$element}' not found");
        }

        return new $class;
    }
}