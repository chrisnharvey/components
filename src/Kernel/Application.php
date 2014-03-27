<?php

namespace Encore\Kernel;

use Encore\Console\Command;
use Encore\Container\Container;
use Symfony\Component\Debug\Debug;
use Encore\Container\ServiceProvider;
use Encore\Config\ServiceProvider as ConfigServiceProvider;

class Application extends Container
{
    const VERSION = '0.1';

    const OS_OSX = 'osx';
    const OS_WIN = 'win';
    const OS_LINUX = 'linux';
    const OS_OTHER = 'other';

    private $appPath;
    private $resourcesPath;
    private $vendorPath;

    private $booted = false;
    private $os;

    protected $mode;
    protected $serviceProviders = array();
    protected $loadedProviders = array();

    public function __construct($appPath, $resourcesPath, $vendorPath)
    {
        $this->appPath = $appPath;
        $this->resourcesPath = $resourcesPath;
        $this->vendorPath = $vendorPath;

        // First things first... Register this as the app
        $this->bind('app', $this);
    }

    public static function fromCwd()
    {
        $cwd = getcwd();

        return new static("{$cwd}/app", "{$cwd}/resources", "{$cwd}/vendor");
    }

    public function launching(callable $callback)
    {
        $this['events']->listen('app.launching', $callback);
    }

    public function quitting(callable $callback)
    {
        $this['events']->listen('app.quitting', $callback);
    }

    public function mode()
    {
        return $this->mode;
    }

    public function setMode($mode)
    {
        $this->mode = empty($mode) ? 'dev' : $mode;

        ini_set('display_errors', $this->mode === 'dev');
    }

    public function boot()
    {
        if ($this->booted) return;

        $this->addProvider(new ConfigServiceProvider($this));

        // Register service providers
        foreach ($this['config']->get('app.providers') as $provider) {
            $this->addProvider($provider);
        }

        // Register aliases
        foreach ($this['config']->get('app.aliases') as $alias => $class) {
            class_alias($class, $alias);
        }

        // Now run boot events on service providers
        array_walk($this->registered, function($p) {
            if (method_exists($p, 'boot')) $p->boot();

            if ($this->mode == 'dev' and method_exists($p, 'commands')) {
                $this->registerCommands($p->commands());
            }
        });

        if (file_exists($bootstrap = $this->appPath."/bootstrap/{$this->mode}.php")) {
            require $bootstrap;
        }

        require $this->appPath.'/start.php';

        $this->booted = true;
    }

    public function launch()
    {
        $this['events']->fire('app.launching', [$this]);
    }

    public function quit()
    {
        $this['events']->fire('app.quitting', [$this]);

        exit;
    }

    public function get()
    {
        return $this;
    }

    public function appPath()
    {
        return $this->appPath;
    }

    public function resourcesPath()
    {
        return $this->resourcesPath;
    }

    public function vendorPath()
    {
        return $this->vendorPath;
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
    protected function registerProvider(ServiceProvider $provider, $force = false)
    {
        parent::registerProvider($provider, $force);

        if ( ! in_array($provider, $this->registered)) return;

        if ($this->booted) {
            if (method_exists($provider, 'boot')) {
                $provider->boot();
            }

            if ($this->mode == 'dev' and method_exists($provider, 'commands')) {
                $this->registerCommands($provider->commands());
            }
        }
    }

    protected function registerCommands(array $commands)
    {
        foreach ($commands as $command) {
            $this->registerCommand($command);
        }
    }

    protected function registerCommand(Command $command)
    {
        $abstract = "command.{$command->name}";

        $this->bind($abstract, $command);

        $this['console']->add($this[$abstract]);
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
