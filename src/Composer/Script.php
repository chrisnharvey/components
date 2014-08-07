<?php

namespace Encore\Composer;

use Encore\Kernel\Application;
use Symfony\Component\Finder\Finder;
use Composer\Script\Event;

class Script
{
    protected static $appPath;
    protected static $vendorPath;
    protected static $resourcesPath;

    protected static $resources = [];

    public static function init()
    {
        // Instantiate the application
        $app = Application::fromCwd();

        // Give proxies an instance of the application
        $app->initializeProxies();

        // Boot the app
        $app->boot();

        static::$appPath = \App::appPath();
        static::$vendorPath = \App::vendorPath();

        if (defined('COMPILING')) {
            static::$appPath = BUILD_PATH.'/app';
            static::$vendorPath = BUILD_PATH.'/vendor';
        }
    }

    public static function postInstall(Event $event)
    {
        static::init();

        $event->getIO()->write('<info>Writing resources.lock file</info>');

        $installed = json_decode(file_get_contents(static::$vendorPath.'/composer/installed.json'));

        $data = [];

        $finder = (new Finder)
            ->directories()
            ->ignoreVCS(true)
            ->in(static::$resourcesPath.'/packages');

        foreach ($installed as $package) {
            if ( ! property_exists($package, 'extra')) continue;

            $extra = $package->extra;

            if ( ! property_exists($extra, 'resources')) continue;

            $resources = $extra->resources;

            foreach ($resources as $resource => $namespaces) {
                foreach ($namespaces as $namespace => $path) {
                    $finder->exclude($namespace);

                    $data[$resource][$namespace] = $path;
                }
            }
        }

        // We turn the iterator to an array to
        // prevent an exception when we delete the directorys
        foreach (iterator_to_array($finder) as $file) {
            \Filesystem::deleteDirectory($file->getPathname());
        }

        file_put_contents(static::$resourcesPath.'/resources.lock', json_encode($data, JSON_PRETTY_PRINT));
    }

    public static function postUpdate(Event $event)
    {
        return static::postInstall($event);
    }
}
