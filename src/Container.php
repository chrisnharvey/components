<?php

namespace Encore\Container;

use Closure;
use ArrayAccess;
use League\Di\Definition;
use League\Di\Container as BaseContainer;

class Container extends BaseContainer implements ArrayAccess
{
    protected $event = null;
    protected $provides = [];
    protected $registered = [];

    public function __construct(EventDispatcherInterface $event = null, Container $parent = null)
    {
        $this->event = $event;

        parent::__construct($parent);
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->bindings)
            or array_key_exists($offset, $this->provides);
    }

    public function offsetGet($offset)
    {
        return $this->resolve($offset);
    }

    public function offsetSet($offset, $value)
    {
        $this->bind($offset, $value);
    }

    public function offsetUnset($offset)
    {
        if (array_key_exists($offset, $this->bindings)) {
            unset($this->bindings[$offset]);
        }
    }

    public function addProvider($provider)
    {
        if (is_string($provider)) {
            $provider = new $provider($this);
        }

        $this->registerEvents($provider);
        $this->registerProvides($provider);

        $this->registerProvider($provider);
    }

    public function initializeFacaces()
    {
        Facade::setContainer($this);
    }

    public function createChild()
    {
        return new static($this->event, $this);
    }

    public function build($concrete)
    {
        if (is_object($concrete)) {
           return $concrete; 
        }

        return parent::build($concrete);
    }

    public function bind($abstract, $concrete = null)
    {
        if ($this->objectNotClosure($concrete)) {
            $concrete = new Definition($this, $concrete);

            return $this->bindings[$abstract] = $concrete;
        }

        return parent::bind($abstract, $concrete);
    }

    public function registerProvidersFor($binding)
    {
        foreach ($this->provides($binding) as $provider) {
            $this->registerProvider($provider, true);
        }
    }

    public function provides($binding)
    {
        if ( ! array_key_exists($binding, $this->provides)) return [];

        return $this->provides[$binding];
    }

    public function providerIsRegistered(ServiceProvider $provider)
    {
        return in_array($provider, $this->registered);
    }

    public function resolve($binding)
    {
        $this->registerProvidersFor($binding);

        return parent::resolve($binding);
    }

    protected function registerEvents(ServiceProvider $provider)
    {
        if (is_null($this->event)) return;

        foreach ($provider->when() as $event) {
            $this->event->listen($event, function() use ($provider) {
                $this->registerProvider($provider, true);
            });
        }
    }

    protected function registerProvider(ServiceProvider $provider, $force = false)
    {
        if ($this->providerIsRegistered($provider)) return;

        $events = $provider->when();
        $provides = $provider->provides();

        if ($force or (empty($events) and empty($provides))) {
            $provider->register();

            $this->registered[] = $provider;
        }
    }

    protected function registerProvides(ServiceProvider $provider)
    {
        foreach ($provider->provides() as $binding) {
            $this->provides[$binding][] = $provider;
        }
    }

    protected function objectNotClosure($instance)
    {
        return is_object($instance) and ! $instance instanceof Closure;
    }
}
