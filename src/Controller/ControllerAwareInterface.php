<?php

namespace Encore\Controller;

interface ControllerAwareInterface
{
    public function setController(Controller $controller);

    public function hasController();

    public function getController();
}