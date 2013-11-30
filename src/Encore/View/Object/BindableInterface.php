<?php

namespace Encore\View\Object;

interface BindableInterface
{
    public function bind($name, $event, $callback);
}