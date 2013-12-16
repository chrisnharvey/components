<?php

namespace Encore\View\Object;

class Frame extends Bindable
{
    public function __construct($name)
    {
        $this->object = new \wxFrame;

        \wxXmlResource::Get()->LoadFrame($this->object, null, $name);
    }
}