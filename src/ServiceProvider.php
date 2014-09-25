<?php

namespace Encore\Console;

use Encore\Console\Error\ConsoleDisplayer;
use Encore\Console\Application as Console;
use Encore\Container\ServiceProvider as BaseServiceProvider;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register the console into the container.
     *
     * @return void
     */
    public function register()
    {
        $container = $this->container;
        $console = new Console('EncorePHP', $container::VERSION);

        $this->container->bind('console', $console);

        if ($this->container->bound('error')) {
            $this->container['error']->setDisplayer(new ConsoleDisplayer($console));
        }
    }

    /**
     * Register service provider commands on boot.
     *
     * @return void
     */
    public function boot()
    {
        // Loop the providers and register commands
        $providers = $this->container->providers(false);

        foreach ($providers as $provider) {
            if (method_exists($provider, 'commands')) {
                $this->registerCommands($provider->commands());
            }
        }
    }

    /**
     * Register an array of commands into the console.
     *
     * @return void
     */
    protected function registerCommands(array $commands)
    {
        foreach ($commands as $command) {
            if ( ! $command instanceof SymfonyCommand) {
                $command = $this->container[$command];
            }

            $this->container['console']->add($command);
        }
    }
}