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

        if (defined('COMPILING') and COMPILING) {
            static::$appPath = BUILD_PATH.'/app';
            static::$vendorPath = BUILD_PATH.'/vendor';
            static::$resourcesPath = BUILD_PATH.'/resources';
        }
    }

    public static function postPackageInstall(Event $event)
    {
        // static::init();

        // $package = $event->getOperation()->getPackage();

        // $data = $package->getExtra();

        // if ( ! array_key_exists('resources', $data)) return;

        // $name = $package->getName();

        // foreach ($data['resources'] as $resource => $)
        // $path = static::$vendorPath."/{$name}/";

        // static::$resources[$name] = $path;

       // var_dump($path); exit;

        // if ( ! array_key_exists('paths', $data)) return;

        // if (array_key_exists('view', $data['paths'])) {
        //     foreach ($data['paths']['view'] as $namespace => $path) {
                
        //     }
        // }

        // if (array_key_exists('asset', $data['paths'])) {
        //     foreach ($data['paths']['asset'] as $namespace => $path) {

        //     }
        // }

        // Get the namespace from extra
        // Copy over the "view-path" and "asset-path" (if they are not set then use default)
        // Copy them into an assets folder (/assets/namespaces/namespace)
        // Standard assets will go into /assets/app/dir-name-sha1
    }

    public static function postPackageUpdate(Event $event)
    {
        return static::postPackageInstall($event);
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