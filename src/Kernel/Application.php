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

    private $booted = false;
    private $os;

    protected $mode = 'dev';
    protected $serviceProviders = array();
    protected $loadedProviders = array();

    public function __construct($basePath, $appPath = null)
    {
        $this->basePath = $basePath;
        $this->appPath = $appPath ?: $basePath.'/app';

        // First things first... Register this as the app
        $this->bind('app', $this);

        // Register the base service providers
        $this->registerBaseProviders();

        // Register exception/error handling
        $this['error']->register();
    }

    public static function fromCwd()
    {
        return new static(getcwd());
    }

    public function launching(callable $callback, $priority = 100)
    {
        $this['events']->listen('app.launching', $callback);
    }

    public function quitting(callable $callback, $priority = 100)
    {
        $this['events']->listen('app.quitting', $callback, $priority);
    }

    public function mode()
    {
        return $this->mode;
    }

    public function setMode($mode)
    {
        $this->mode = $mode;
    }

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

        $this->quitting(function() {
            exit(0);
        });

        $this->booted = true;
    }

    protected function registerBaseProviders()
    {
        $this->addProvider(new ErrorServiceProvider($this));
        $this->addProvider(new ConfigServiceProvider($this));
    }

    public function launch()
    {
        $this['events']->fire('app.launching', [$this]);
    }

    public function quit()
    {
        $this['events']->fire('app.quitting', [$this]);
    }

    public function get()
    {
        return $this;
    }

    public function appPath()
    {
        return $this->appPath;
    }
    
    public function basePath()
    {
        return $this->basePath;
    }

    public function os()
    {
        return isset($this->os) ? $this->os : $this->findOS();
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
        parent::registerProvider($provider, $force, $binding);

        if ( ! in_array($provider, $this->registered)) return;

        if ($this->booted) {
            if (method_exists($provider, 'boot')) {
                $provider->boot();
            }
        }
    }

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
