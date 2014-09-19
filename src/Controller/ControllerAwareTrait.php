<?php

namespace Encore\Controller;

trait ControllerAwareTrait
{
    protected $controller;

    public function hasController()
    {
        return isset($this->controller);
    }

    public function setController(Controller $controller)
    {
        $this->controller = $controller;
    }

    public function getController()
    {
        return $this->controller;
    }
}