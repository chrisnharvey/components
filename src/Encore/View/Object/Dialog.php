<?php

namespace Encore\View\Object;

class Dialog extends Bindable
{
    public function __construct($name)
    {
        $this->object = new \wxDialog;

        \wxXmlResource::Get()->LoadDialog($this->object, null, $name);
    }
}