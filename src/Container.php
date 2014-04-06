<?php

namespace Encore\Container;

class Container implements \ArrayAccess
{
    /**
     * The event dispatcher implementation.
     *
     * @var EventDispatcherInterface
     */
    protected $event;

    /**
     * Array of all service providers, even those that aren't registered
     *
     * @var array
     */
    protected $providers = [];

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
     * Array of container bindings.
     *
     * @var $array
     */
    protected $bindings = [];

    /**
     * The parent Container object.
     *
     * @var Container
     */
    protected $parent;

    /**
     * Constructor
     *
     * @param object $parent Container
     */
    public function __construct(Container $parent = null)
    {
        $this->parent = $parent;
    }

    /**
     * Set the event dispatcher
     *
     * @param object $event EventDispatcherInterface
     */
    public function setEventDispatcher(EventDispatcherInterface $event)
    {
        $this->event = $event;
    }

    /**
     * Create a child Container with a new property scope that
     * that has the ability to access the parent scope when resolving.
     *
     * @return Container
     */
    public function createChild()
    {
        return new static($this);
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

        // Only allow a service provider to be registered
        // once.
        if (in_array($provider, $this->providers)) {
            return;
        }

        $this->providers[] = $provider;

        $this->registerEvents($provider);
        $this->registerProvides($provider);

        $this->registerProvider($provider);
    }

    public function providers($registered = true)
    {
        return $registered ? $this->registered : $this->providers;
    }

    /**
     * Initialize the proxies with this instance of the container
     *
     * @return void
     */
    public function initializeProxies()
    {
        Proxy::setContainer($this);
    }

    /**
     * Method to bind a concrete class to an abstract class or interface.
     *
     * @param string          $abstract Class to bind.
     * @param \Closure|string $concrete Concrete definition to bind to $abstract.
     *
     * @return Definition|\Closure The concrete class for adding method calls / constructor arguments if desired.
     */
    public function bind($abstract, $concrete = null)
    {
        if (is_null($concrete)) {
            $concrete = $abstract;
        }

        if ($this->shouldBeDefinitionObject($concrete)) {
            $concrete = new Definition($this, $concrete);
        }

        return $this->bindings[$abstract] = $concrete;
    }

    /**
     * Checks to see if a binding key has been bound in current Container.
     * If not bound in the current Container, it will recursively search
     * parent Container's until it finds the $binding.
     *
     * @param string $binding The binding to check.
     * @param bool $lazy Check lazy loaded too?
     * @return bool
     */
    public function bound($binding, $lazy = true)
    {
        return isset($this->bindings[$binding]) or
            ($lazy and isset($this->provides[$binding])) or
            (isset($this->parent) and $this->parent->bound($binding, $lazy));
    }

    /**
     * Build a concrete instance of a class.
     *
     * @param string $concrete The name of the class to buld.
     *
     * @return mixed The instantiated class.
     * @throws  \InvalidArgumentException
     */
    public function build($concrete)
    {
        if (is_object($concrete)) {
           return $concrete; 
        }

        $reflection = new \ReflectionClass($concrete);

        if (! $reflection->isInstantiable()) {
            throw new \InvalidArgumentException(sprintf('Class %s is not instantiable.', $concrete));
        }

        $constructor = $reflection->getConstructor();

        if (is_null($constructor)) {
            return new $concrete;
        }

        $dependencies = $this->getDependencies($constructor);

        return $reflection->newInstanceArgs($dependencies);
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
            $this->registerProvider($provider, true, $binding);
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
     * Extend an existing binding.
     *
     * @param   string   $binding  The name of the binding to extend.
     * @param   \Closure $closure  The function to use to extend the existing binding.
     *
     * @return  void
     * @throws  \InvalidArgumentException
     */
    public function extend($binding, \Closure $closure)
    {
        $rawObject = $this->getRaw($binding);

        if (is_null($rawObject)) {
            throw new \InvalidArgumentException(sprintf('Cannot extend %s because it has not yet been bound.', $binding));
        }

        $this->bind($binding, function ($container) use ($closure, $rawObject) {
            return $closure($container, $rawObject($container));
        });
    }

    /**
     * Recursively build the dependency list for the provided method.
     *
     * @param \ReflectionMethod $method The method for which to obtain dependencies.
     *
     * @return array An array containing the method dependencies.
     * @throws \InvalidArgumentException
     */
    protected function getDependencies(\ReflectionMethod $method)
    {
        $dependencies = [];

        foreach ($method->getParameters() as $param) {
            $dependency = $param->getClass();

            if (is_null($dependency)) {
                if ($param->isOptional()) {
                    $dependencies[] = $param->getDefaultValue();
                    continue;
                }
            } else {
                $dependencies[] = $this->resolve($dependency->name);
                continue;
            }

            throw new \InvalidArgumentException('Could not resolve ' . $param->getName());
        }

        return $dependencies;
    }

    /**
     * Get the raw object prior to resolution.
     *
     * @param string $binding The $binding key to get the raw value from.
     *
     * @return Definition|\Closure Value of the $binding.
     */
    public function getRaw($binding)
    {
        if (isset($this->bindings[$binding])) {
            return $this->bindings[$binding];
        } elseif (isset($this->parent)) {
            return $this->parent->getRaw($binding);
        }

        return null;
    }

    /**
     * Resolve the given binding.
     *
     * @param string $binding The binding to resolve.
     *
     * @return mixed The results of invoking the binding callback.
     */
    public function resolve($binding)
    {
        $this->registerProvidersFor($binding);

        $rawObject = $this->getRaw($binding);

        // If the abstract is not registered, do it now for easy resolution.
        if (is_null($rawObject)) {
            // Pass $binding to both so it doesn't need to check if null again.
            $this->bind($binding, $binding);

            $rawObject = $this->getRaw($binding);
        }

        return $rawObject($this);
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
        if ( ! isset($this->event)) return;

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
    protected function registerProvider(ServiceProvider $provider, $force = false, $binding = null)
    {
        if ($this->providerIsRegistered($provider) 
            and $binding and $this->bound($binding, false)) return;

        $events = $provider->when();
        $provides = $provider->provides();

        if ($force or (empty($events) and empty($provides))) {
            if (method_exists($provider, 'register')) {
                $provider->register($binding);
            }

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
     * Check if the specified concrete definiton should be a
     * definition object.
     *
     * @param object $concrete The concrete definition
     * @return bool
     */
    protected function shouldBeDefinitionObject($concrete)
    {
        return (
            (is_object($concrete) and ! $concrete instanceof \Closure)
            or is_string($concrete)
        );
    }
}
