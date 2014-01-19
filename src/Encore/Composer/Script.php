<?php

namespace Encore\Composer;

use Composer\Script\Event;

class Script
{
    protected static $appPath;
    protected static $vendorPath;
    protected static $resourcesPath;

    protected static $resources = [];

    public static function init()
    {
        static::$appPath = \App::path();
        static::$vendorPath = \App::vendorPath();
        static::$resourcesPath = \App::resourcesPath();

        if (defined('COMPILING')) {
            static::$appPath = BUILD_PATH.'/app';
            static::$vendorPath = BUILD_PATH.'/vendor';
            static::$resourcesPath = BUILD_PATH.'/resources';
        }
    }

    public static function postInstall(Event $event)
    {
        static::init();
        $installed = json_decode(file_get_contents(static::$vendorPath.'/composer/installed.json'));

        $data = [];

        foreach ($installed as $package) {
            if ( ! property_exists($package, 'extra')) continue;

            $extra = $package->extra;

            if ( ! property_exists($extra, 'resources')) continue;

            $resources = $extra->resources;

            foreach ($resources as $resource => $namespaces) {
                foreach ($namespaces as $namespace => $path) {
                    $data[$resource][$namespace] = $path;
                }
            }
        }

        file_put_contents(static::$resourcesPath.'/resources.lock', json_encode($data));
    }

    public static function postUpdate(Event $event)
    {
        return static::postInstall($event);
    }
}