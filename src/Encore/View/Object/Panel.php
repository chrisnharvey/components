<?php

namespace Encore\View\Object;

class Panel extends Bindable
{
    public function __construct($name)
    {
        $this->object = new \wxPanel;

        \wxXmlResource::Get()->LoadPanel($this->object, null, $name);
    }
}