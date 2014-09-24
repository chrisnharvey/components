<?php

namespace Encore\Config;

use Encore\Namespacer\ResolverInterface;
use Encore\Namespacer\NamespacableInterface;

class Repository implements NamespacableInterface, \ArrayAccess
{
    /**
    * An instance of ResolverInterface.
    *
    * @var Encore\Namespacer\ResolverInterface
    */
    protected $resolver;

    /**
    * The application mode.
    *
    * @var string
    */
    protected $mode;

    /**
    * The constructor.
    *
    * @param LoaderInterface
    * @param Encore\Namespacer\ResolverInterface
    * @param string $mode
    * @return void
    */
    public function __construct(LoaderInterface $loader, ResolverInterface $resolver, $mode)
    {
        $this->loader = $loader;
        $this->resolver = $resolver;
        $this->mode = $mode;
    }

    /**
    * Get a configuration item.
    *
    * @param string $key
    * @return mixed
    */
    public function get($key)
    {
        list($namespace, $group, $item) = $this->resolver->parseKey($key);

        $collection = $this->getCollection($group, $namespace);

        $items = $this->load($group, $namespace, $collection);
        
        return $this->resolver->resolveKey($item, $items);
    }

    public function offsetSet($offset, $value)
    {

    }
    
    public function offsetExists($offset)
    {
        
    }
    
    public function offsetUnset($offset)
    {
        
    }
    
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
    * Get the registered namespaces from the loader.
    *
    * @return array
    */
    public function getNamespaces()
    {
        return $this->loader->getNamespaces();
    }

    /**
    * Add a namespace to the loader.
    *
    * @param string $namespace
    * @param string $hint
    * @return void
    */
    public function addNamespace($namespace, $hint)
    {
        $this->loader->addNamespace($namespace, $hint);
    }

    /**
    * Add a location to config files.
    *
    * @param string $location
    * @return void
    */
    public function addLocation($location)
    {
        $this->loader->addLocation($location);
    }

    /**
    * Load the configuration group for the key.
    *
    * @param string $group
    * @param string $namespace
    * @param string $collection
    * @return array
    */
    protected function load($group, $namespace, $collection)
    {
        // Is it already loaded? If so, just return it.
        if (isset($this->items[$collection])) return $this->items[$collection];

        $items = $this->loader->load($this->mode, $group, $namespace);

        return $this->items[$collection] = $items;
    }

    /**
    * Get the collection string.
    *
    * @param string $group
    * @param string $namespace
    * @return string
    */
    protected function getCollection($group, $namespace = null)
    {
        $namespace = $namespace ?: '*';

        return $namespace.'::'.$group;
    }
}