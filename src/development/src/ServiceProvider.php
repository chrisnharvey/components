<?php

namespace Encore\Development;

use TaskFile;
use Robo\Runner;
use Robo\Result;
use Symfony\Component\Console\Input\InputInterface;
use Encore\Container\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register the dev config directory and register providers.
     *
     * @return void
     */
    public function register()
    {
        $this->container['config']->addLocation($this->container->basePath().'/dev/config');

        foreach ($this->container['config']->get('app.providers') as $provider) {
            $this->container->addProvider($provider);
        }
    }

    /**
     * Register the debug command.
     *
     * @return void
     */
    public function commands()
    {
        return array_merge($this->getDevelopmentCommands(), [
            'Encore\Development\Command\Debug'
        ]);
    }

    protected function getDevelopmentCommands()
    {
        if ( ! class_exists('TaskFile')) return [];

        $commands = [];

        $tasks = new TaskFile;
        $runner = new Runner;

        $commandNames = array_filter(get_class_methods($tasks), function($m) {
            return strpos($m, '__') === false;
        });

        foreach ($commandNames as $commandName) {
            $command = $runner->createCommand(new TaskInfo('TaskFile', $commandName));
            $command->setCode(function(InputInterface $input) use ($tasks, $commandName) {
                // get passthru args
                $args = $input->getArguments();
                array_shift($args);
                $args[] = $input->getOptions();
                $res = call_user_func_array([$tasks, $commandName], $args);
                if (is_int($res)) exit($res);
                if (is_bool($res)) exit($res ? 0 : 1);
                if ($res instanceof Result) exit($res->getExitCode());
            });

            $commands[] = $command;
        }

        return $commands;
    }
}
