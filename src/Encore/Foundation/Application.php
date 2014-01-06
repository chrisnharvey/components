<?php

namespace Encore\Foundation;

use Encore\Testing\Testing;
use Illuminate\Container\Container;
use Encore\Config\Loader;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Config\Repository as Config;

class Application extends Container
{
    const VERSION = '0.1';

    const OS_OSX = 'osx';
    const OS_WIN = 'win';
    const OS_LINUX = 'linux';
    const OS_OTHER = 'other';

    private $appPath;
    private $vendorPath;
    private $booted = false;

    protected $env;
    protected $serviceProviders = array();
    protected $loadedProviders = array();

    public function __construct($appPath, $vendorPath)
    {
        $this->appPath = $appPath;
        $this->vendorPath = $vendorPath;

        // First things first... Register this as the app
        $this->instance('app', $this);

        // Events shit should go into a service provider
        $that = $this;

        $this->singleton('events', function() use ($that) {
            return new \Illuminate\Events\Dispatcher($that);
        });
    }

    public function launching($callback)
    {
        $this['events']->listen('app.launching', $callback);
    }

    public function quitting($callback)
    {
        $this['events']->listen('app.quitting', $callback);
    }

    public function setEnvironment($env)
    {
        $this->env = empty($env) ? 'dev' : $env;

        ini_set('display_errors', 1);
        error_reporting(E_ALL);

        if ($this->env != 'dev') ini_set('display_errors', 0);
    }

    public function boot()
    {
        $config = new Config(new Loader(new Filesystem, $this->appPath.'/config', $this->getOS()), $this->env);

        $this->instance('config', $config);

        // Register service providers
        foreach ($config->get('app.providers') as $provider) {
            $this->register($provider);
        }

        // Register aliases
        foreach ($config->get('app.aliases') as $alias => $class) {
            class_alias($class, $alias);
        }

        // Now run boot events on service providers
        array_walk($this->serviceProviders, function($p) {
            $p->boot();
        });

        if (file_exists($bootstrap = $this->appPath."/bootstrap/{$this->env}.php")) {
            require $bootstrap;
        }

        require $this->appPath.'/start.php';

        $this->booted = true;
    }

    public function launch()
    {
        $this['events']->fire('app.launching');
    }

    public function quit()
    {
        $this['events']->fire('app.quitting');

        exit;
    }

    public function register($provider, $options = array())
    {
        // If the given "provider" is a string, we will resolve it, passing in the
        // application instance automatically for the developer. This is simply
        // a more convenient way of specifying your service provider classes.
        if (is_string($provider)) {
            if ( ! class_exists($provider)) return;

            $provider = new $provider($this);
        }

        $provider->register();

        // Once we have registered the service we will iterate through the options
        // and set each of them on the application so they will be available on
        // the actual loading of the service objects and for developer usage.
        foreach ($options as $key => $value) $this[$key] = $value;

        $this->markAsRegistered($provider);

        // If the application has already booted, we will call this boot method on
        // the provider class so it has an opportunity to do its boot logic and
        // will be ready for any usage by the developer's application logics.
        if ($this->booted) $provider->boot();

        return $provider;
    }

    public function get()
    {
        return $this;
    }

    public function path()
    {
        return $this->appPath;
    }

    public function vendorPath()
    {
        return $this->vendorPath;
    }

    public function getOS()
    {
        return isset($this->os) ? $this->os : $this->findOS();
    }

    protected function findOS()
    {
        switch (true) {
            case stristr(PHP_OS, 'DAR'):
                return $this->os = static::OS_OSX;

            case stristr(PHP_OS, 'WIN'):
                return $this->os = static::OS_WIN;

            case stristr(PHP_OS, 'LINUX'):
                return $this->os = static::OS_LINUX;

            default:
                return $this->os = static::OS_OTHER;
        }
    }

    /**
     * Mark the given provider as registered.
     *
     * @param \Illuminate\Support\ServiceProvider
     * @return void
     */
    protected function markAsRegistered($provider)
    {
        $this->serviceProviders[] = $provider;

        $this->loadedProviders[get_class($provider)] = true;
    }
}