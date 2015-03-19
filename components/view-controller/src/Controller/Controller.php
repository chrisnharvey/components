<?php

namespace Encore\Controller;

use Encore\View\View;
use Encore\Container\ContainerAwareTrait;
use Encore\Container\ContainerAwareInterface;

abstract class Controller implements ContainerAwareInterface, \ArrayAccess
{
    use ContainerAwareTrait;

    protected $view;
    protected $style = null;

    /**
     * Setup the view and assign it to the controller
     * 
     * @return void
     */
    public function setupView()
    {
        if ( ! isset($this->view)) return;

        $view = $this->container['view']->make($this->view, $this->style);
        $view->setController($this);

        $this->view = $view;
    }

    /**
     * Get magic method
     * @param  string $property
     * @return mixed
     */
    public function __get($property)
    {
        return $this->view->$property;
    }

    /** 
     * Set magic method
     * 
     * @param string $property
     * @param mixed $value
     * @return mixed
     */
    public function __set($property, $value)
    {
        $this->view->$property = $value;
    }

    /**
     * Call magic method
     * 
     * @param  string $method
     * @param  array $arguments
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        return call_user_func_array([$this->view, $method], $arguments);
    }

    /**
     * Determine if a given offset exists.
     *
     * @param string $key
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * Get the value at a given offset.
     *
     * @param string $key
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->container[$offset];
    }

    /**
     * Set the value at a given offset.
     *
     * @param string $offset
     * @param mixed $value
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->container[$offset] = $value;
    }

    /**
     * Unset the value at a given offset.
     *
     * @param string $key
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }
}