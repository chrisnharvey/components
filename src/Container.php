<?php

namespace Encore\Container;

use Closure;
use ArrayAccess;
use League\Di\Definition;
use League\Di\Container as BaseContainer;

class Container extends BaseContainer implements ArrayAccess
{
    /**
     * The event dispatcher implementation.
     *
     * @var \Encore\Container\EventDispatcherInterface
     */
    protected $event = null;

    /**
     * Array of service providers that resolve instances in the container
     *
     * @var array
     */
    protected $provides = [];

    /**
     * Array of service providers that have been registered
     *
     * @var array
     */
    protected $registered = [];

    /**
     * Constructor
     *
     * @param object $event \Encore\Container\EventDispatcherInterface
     * @param object $parent \Encore\Container\Container
     */
    public function __construct(EventDispatcherInterface $event = null, Container $parent = null)
    {
        $this->event = $event;

        parent::__construct($parent);
    }

    /**
     * Add a service provider to the application.
     *
     * @param mixed $provider
     * @return void
     */
    public function addProvider($provider)
    {
        if (is_string($provider)) {
            $provider = new $provider($this);
        }

        $this->registerEvents($provider);
        $this->registerProvides($provider);

        $this->registerProvider($provider);
    }

    /**
     * Initialize the facades with this instance of the container
     *
     * @return void
     */
    public function initializeFacaces()
    {
        Facade::setContainer($this);
    }

    /**
     * Create a child Container with a new property scope that
     * that has the ability to access the parent scope when resolving.
     *
     * @return \Encore\Container\Container
     */
    public function createChild()
    {
        return new static($this->event, $this);
    }

    /**
     * Build a concrete instance of a class.
     *
     * @param string $concrete The name of the class to buld.
     * @return mixed The instantiated class.
     */
    public function build($concrete)
    {
        if (is_object($concrete)) {
           return $concrete; 
        }

        return parent::build($concrete);
    }

    /**
     * Bind a concrete class to an abstract class or interface.
     *
     * @param string $abstract Class to bind.
     * @param mixed $concrete Concrete definition to bind to $abstract.
     * Can be a \Closure, string or an instantiated object.
     *
     * @return mixed The concrete class for adding method calls / constructor arguments if desired.
     */
    public function bind($abstract, $concrete = null)
    {
        if ($this->objectNotClosure($concrete)) {
            $concrete = new Definition($this, $concrete);

            return $this->bindings[$abstract] = $concrete;
        }

        return parent::bind($abstract, $concrete);
    }

    /**
     * Register the service providers for a specific binding
     *
     * @param string $binding The name of binding.
     * @return void
     */
    public function registerProvidersFor($binding)
    {
        foreach ($this->provides($binding) as $provider) {
            $this->registerProvider($provider, true);
        }
    }

    /**
     * Return the service providers that provide a specified binding
     *
     * @param string $binding The name of binding.
     * @return array
     */
    public function provides($binding)
    {
        if ( ! array_key_exists($binding, $this->provides)) return [];

        return $this->provides[$binding];
    }

    /**
     * Resolve the given binding.
     *
     * @param string $binding The binding to resolve.
     * @return mixed The results of invoking the binding callback.
     */
    public function resolve($binding)
    {
        $this->registerProvidersFor($binding);

        return parent::resolve($binding);
    }

    /**
     * Is a specified provider registered?
     *
     * @param ServiceProvider $provider The service provider object.
     * @return bool
     */
    protected function providerIsRegistered(ServiceProvider $provider)
    {
        return in_array($provider, $this->registered);
    }

    /**
     * Register the events that register the specified provider
     *
     * @param ServiceProvider $provider The service provider object.
     * @return void
     */
    protected function registerEvents(ServiceProvider $provider)
    {
        if (is_null($this->event)) return;

        foreach ($provider->when() as $event) {
            $this->event->listen($event, function() use ($provider) {
                $this->registerProvider($provider, true);
            });
        }
    }

    /**
     * Register a service provider
     *
     * @param ServiceProvider $provider The service provider object.
     * @param bool $force Force register (register whether needed or not)
     * @return void
     */
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

    /**
     * Remember the bindings that the specified service provider provides
     *
     * @param ServiceProvider $provider The service provider object.
     * @return void
     */
    protected function registerProvides(ServiceProvider $provider)
    {
        foreach ($provider->provides() as $binding) {
            $this->provides[$binding][] = $provider;
        }
    }

    /**
     * Check that the specified object is an object, but not a closure
     *
     * @param object $instance The object to check
     * @return bool
     */
    protected function objectNotClosure($instance)
    {
        return is_object($instance) and ! $instance instanceof Closure;
    }

    /**
     * Determine if a given offset exists.
     *
     * @param string $key
     * @return bool
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->bindings)
            or array_key_exists($offset, $this->provides);
    }

    /**
     * Get the value at a given offset.
     *
     * @param string $key
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->resolve($offset);
    }

    /**
     * Set the value at a given offset.
     *
     * @param string $offset
     * @param mixed $value
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->bind($offset, $value);
    }

    /**
     * Unset the value at a given offset.
     *
     * @param string $key
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->bindings[$offset]);
    }
}
