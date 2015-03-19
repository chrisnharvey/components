<?php

namespace Encore\Controller;

trait ControllerAwareTrait
{
    protected $controller;

    /**
     * Check if the object has a controller assigned
     * 
     * @return boolean
     */
    public function hasController()
    {
        return isset($this->controller);
    }

    /**
     * Set the controller
     * 
     * @param Controller $controller
     */
    public function setController(Controller $controller)
    {
        $this->controller = $controller;
    }

    /**
     * Get the controller object
     * 
     * @return Controller
     */
    public function getController()
    {
        return $this->controller;
    }
}