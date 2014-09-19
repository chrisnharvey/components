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

    public function setupView()
    {
        if ( ! isset($this->view)) return;

        $view = $this->container['view']->make($this->view, $this->style);
        $view->setController($this);

        $this->view = $view;
    }

    public function __get($property)
    {
        return $this->view->$property;
    }

    public function __set($property, $value)
    {
        $this->view->$property = $value;
    }

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