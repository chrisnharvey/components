<?php

namespace Encore\Container;

use League\Di\Container as BaseContainer;

class Container extends BaseContainer
{
    protected $event = null;
    protected $provides = [];
    protected $registered = [];

    public function __construct(EventDispatcherInterface $event = null, Container $parent = null)
    {
        $this->event = $event;

        parent::__construct($parent);
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

    public function createChild()
    {
        return new static($this->events, $this);
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
        if (is_null($this->events)) return;

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
}