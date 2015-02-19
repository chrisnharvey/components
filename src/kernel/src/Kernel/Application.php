<?php

namespace Encore\Kernel;

use Encore\Console\Command;
use Encore\Container\Container;
use Symfony\Component\Debug\Debug;
use Encore\Container\ServiceProvider;
use Encore\Config\ServiceProvider as ConfigServiceProvider;
use Encore\Error\ServiceProvider as ErrorServiceProvider;

class Application extends Container
{
    const VERSION = '0.1';

    const OS_OSX = 'osx';
    const OS_WIN = 'win';
    const OS_LINUX = 'linux';
    const OS_OTHER = 'other';

    private $appPath;
    private $basePath;
    private $resourcesPath;

    private $booted = false;
    private $os;

    protected $mode = 'dev';
    protected $serviceProviders = array();
    protected $loadedProviders = array();

    /**
     * Construct the application container
     * 
     * @param string $basePath
     * @param string $appPath
     * @param string $resourcesPath
     */
    public function __construct($basePath, $appPath = null, $resourcesPath = null)
    {
        $this->basePath = $basePath;
        $this->appPath = $appPath ?: $basePath.'/app';
        $this->resourcesPath = $resourcesPath ?: $basePath.'/resources';

        // First things first... Register this as the app
        $this->bind('app', $this);

        // Register the base service providers
        $this->registerBaseProviders();

        // Register exception/error handling
        $this['error']->register();
    }

    /**
     * Create application from current working directory
     * 
     * @return Application An instance of the current class
     */
    public static function fromCwd()
    {
        return new static(getcwd());
    }

    /**
     * Bind an event to be triggered when the application is launching
     * 
     * @param  callable $callback
     * @param  integer  $priority
     * @return void
     */
    public function launching(callable $callback, $priority = 100)
    {
        $this['events']->listen('app.launching', $callback);
    }

    /**
     * Bind an event to be triggered when the application is quitting
     * 
     * @param  callable $callback
     * @param  integer  $priority
     * @return void
     */
    public function quitting(callable $callback, $priority = 100)
    {
        $this['events']->listen('app.quitting', $callback, $priority);
    }

    /**
     * Get the current application mode
     * 
     * @return string The application mode
     */
    public function mode()
    {
        return $this->mode;
    }

    /**
     * Set the application mode
     * 
     * @param string $mode
     */
    public function setMode($mode)
    {
        $this->mode = $mode;
    }

    /**
     * Boot the application
     * 
     * @return void
     */
    public function boot()
    {
        if ($this->booted) return;

        // Register service providers
        foreach ($this['config']->get('app.providers') as $provider) {
            $this->addProvider($provider);
        }

        // Register aliases
        AliasLoader::getInstance($this['config']->get('app.aliases'))->register();

        // Now run boot events on service providers
        array_walk($this->registered, function($p) {
            if (method_exists($p, 'boot')) $p->boot();
        });

        if (file_exists($bootstrap = $this->appPath."/bootstrap/{$this->mode}.php")) {
            require $bootstrap;
        }

        $this->booted = true;
    }

    /**
     * Register the base service providers
     * 
     * @return void
     */
    protected function registerBaseProviders()
    {
        $this->addProvider(new ErrorServiceProvider($this));
        $this->addProvider(new ConfigServiceProvider($this));
    }

    /**
     * Fire the application launching events
     * 
     * @return void
     */
    public function launch()
    {
        $this['events']->fire('app.launching', [$this]);
    }

    /**
     * Fire the application quitting events
     * 
     * @return void
     */
    public function quit()
    {
        $this['events']->fire('app.quitting', [$this]);
    }

    /**
     * Get the instance of the app
     * 
     * @return Application An instance of this application
     */
    public function get()
    {
        return $this;
    }

    /**
     * Get the path the the app directory
     * 
     * @return string
     */
    public function appPath()
    {
        return $this->appPath;
    }
    
    /**
     * Get the path the base path
     * 
     * @return string
     */
    public function basePath()
    {
        return $this->basePath;
    }

    /**
     * Get the path to resources
     * 
     * @return string
     */
    public function resourcesPath()
    {
        return $this->resourcesPath;
    }

    /**
     * Get the current operating system
     * 
     * @return string
     */
    public function os()
    {
        return isset($this->os) ? $this->os : $this->findOS();
    }

    /**
     * Register a service provider
     *
     * @param ServiceProvider $provider The service provider object.
     * @param bool $force Force register (register whether needed or not)
     * @param string $binding The binding we're trying to register
     * @return void
     */
    protected function registerProvider(ServiceProvider $provider, $force = false, $binding = null)
    {
        parent::registerProvider($provider, $force, $binding);

        if ( ! in_array($provider, $this->registered)) return;

        if ($this->booted) {
            if (method_exists($provider, 'boot')) {
                $provider->boot();
            }
        }
    }

    /**
     * Figure out which operating system we're running on
     * 
     * @return string The operating system
     */
    protected function findOS()
    {
        if (isset($this->os)) return $this->os;

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
}
