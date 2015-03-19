<?php

namespace Encore\Controller;

interface ControllerAwareInterface
{
    /**
     * Set the controller
     * 
     * @param Controller $controller
     */
    public function setController(Controller $controller);

    /**
     * Check if the object has a controller assigned
     * 
     * @return boolean
     */
    public function hasController();

    /**
     * Get the controller object
     * 
     * @return Controller
     */
    public function getController();
}