<?php

namespace Encore\Container;

abstract class Proxy
{

    /**
     * The container instance being proxied.
     *
     * @var \Encore\Container\Container
     */
    protected static $container;

    /**
     * The resolved object instances.
     *
     * @var array
     */
    protected static $instance;

    /**
     * Hotswap the underlying instance behind the proxy.
     *
     * @param  mixed  $instance
     * @return void
     */
    public static function swap($instance)
    {
        static::$instance[static::getConcreteBinding()] = $instance;

        static::$container->instance(static::getConcreteBinding(), $instance);
    }

    /**
     * Initiate a mock expectation on the proxy.
     *
     * @param  dynamic
     * @return \Mockery\Expectation
     */
    public static function shouldReceive()
    {
        $name = static::getConcreteBinding();

        if (static::isMock()) {
            $mock = static::$instance[$name];
        } else {
            $mock = static::createFreshMockInstance($name);
        }

        return call_user_func_array(array($mock, 'shouldReceive'), func_get_args());
    }

    /**
     * Create a fresh mock instance for the given class.
     *
     * @param  string  $name
     * @return \Mockery\Expectation
     */
    protected static function createFreshMockInstance($name)
    {
        static::$instance[$name] = $mock = static::createMockByName($name);

        if (isset(static::$container)) {
            static::$container->instance($name, $mock);
        }

        return $mock;
    }

    /**
     * Create a fresh mock instance for the given class.
     *
     * @param  string  $name
     * @return \Mockery\Expectation
     */
    protected static function createMockByName($name)
    {
        $class = static::getMockableClass($name);

        return $class ? \Mockery::mock($class) : \Mockery::mock();
    }

    /**
     * Determines whether a mock is set as the instance of the proxy.
     *
     * @return bool
     */
    protected static function isMock()
    {
        $name = static::getConcreteBinding();

        return isset(static::$instance[$name]) && static::$instance[$name] instanceof MockInterface;
    }

    /**
     * Get the mockable class for the bound instance.
     *
     * @return string
     */
    protected static function getMockableClass()
    {
        if ($root = static::getConcreteInstance()) return get_class($root);
    }

    /**
     * Get the root object behind the proxy.
     *
     * @return mixed
     */
    public static function getConcreteInstance()
    {
        return static::resolveProxyInstance(static::getConcreteBinding());
    }

    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected static function getConcreteBinding()
    {
        throw new \RuntimeException("Proxy does not implement getConcreteBinding method.");
    }

    /**
     * Resolve the proxy binding instance from the container.
     *
     * @param  string  $name
     * @return mixed
     */
    protected static function resolveProxyInstance($name)
    {
        if (is_object($name)) return $name;

        if (isset(static::$instance[$name])) {
            return static::$instance[$name];
        }

        return static::$instance[$name] = static::$container[$name];
    }

    /**
     * Clear a resolved proxy instance.
     *
     * @param  string  $name
     * @return void
     */
    public static function clearResolvedInstance($name)
    {
        unset(static::$instance[$name]);
    }

    /**
     * Clear all of the resolved instances.
     *
     * @return void
     */
    public static function clearResolvedInstances()
    {
        static::$instance = array();
    }

    /**
     * Get the container instance behind the proxy.
     *
     * @return \Encore\Container\Container
     */
    public static function getContainer()
    {
        return static::$container;
    }

    /**
     * Set the container instance.
     *
     * @param  \Encore\Container\Container  $container
     * @return void
     */
    public static function setContainer(Container $container)
    {
        static::$container = $container;
    }

    /**
     * Handle dynamic, static calls to the object.
     *
     * @param  string  $method
     * @param  array   $args
     * @return mixed
     */
    public static function __callStatic($method, $args)
    {
        $instance = static::resolveProxyInstance(static::getConcreteBinding());

        switch (count($args)) {
            case 0:
                return $instance->$method();

            case 1:
                return $instance->$method($args[0]);

            case 2:
                return $instance->$method($args[0], $args[1]);

            case 3:
                return $instance->$method($args[0], $args[1], $args[2]);

            case 4:
                return $instance->$method($args[0], $args[1], $args[2], $args[3]);

            default:
                return call_user_func_array(array($instance, $method), $args);
        }
    }

}